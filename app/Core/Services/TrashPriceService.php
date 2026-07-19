<?php

namespace App\Core\Services;

use App\Models\PriceHistory;
use App\Models\TrashCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TrashPriceService
{
    protected PriceNotificationService $notificationService;

    protected PricePredictionService $predictionService;

    public function __construct(
        PriceNotificationService $notificationService,
        PricePredictionService $predictionService
    ) {
        $this->notificationService = $notificationService;
        $this->predictionService = $predictionService;
    }

    /**
     * Get filtered and paginated trash prices.
     */
    public function getFilteredPrices(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = TrashCategory::query();

        // Include archived or not
        if (isset($filters['is_archived']) && $filters['is_archived'] === 'true') {
            $query->archived();
        } else {
            $query->active();
        }

        // Search
        if (! empty($filters['search'])) {
            $query->search($filters['search']);
        }

        // Filter by Kategori
        if (! empty($filters['kategori'])) {
            $query->byKategori($filters['kategori']);
        }

        // Filter by Status Harga
        if (! empty($filters['status_harga'])) {
            $query->byStatusHarga($filters['status_harga']);
        }

        // Filter by Kualitas
        if (! empty($filters['kualitas'])) {
            $query->where('kualitas', $filters['kualitas']);
        }

        // Price range
        if (isset($filters['min_price']) || isset($filters['max_price'])) {
            $min = isset($filters['min_price']) && $filters['min_price'] !== '' ? (float) $filters['min_price'] : null;
            $max = isset($filters['max_price']) && $filters['max_price'] !== '' ? (float) $filters['max_price'] : null;
            $query->priceRange($min, $max);
        }

        // Sorting
        $sort = $filters['sort'] ?? 'terbaru';
        switch ($sort) {
            case 'nama':
                $query->orderBy('nama', 'asc');
                break;
            case 'harga_asc':
                $query->orderBy('harga_per_kg', 'asc');
                break;
            case 'harga_desc':
                $query->orderBy('harga_per_kg', 'desc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('updated_at', 'desc');
                break;
        }

        return $query->paginate($perPage);
    }

    /**
     * Create a new price category.
     */
    public function createPrice(array $data, User $admin): TrashCategory
    {
        return DB::transaction(function () use ($data, $admin) {
            $data['kode'] = TrashCategory::generateKode($data['nama']);
            $data['harga_per_gram'] = $data['harga_per_kg'] / 1000;

            // Handle image upload if exists
            if (isset($data['gambar_file'])) {
                $path = $data['gambar_file']->store('trash_categories', 'public');
                $data['gambar'] = $path;
            }

            $category = TrashCategory::create($data);

            // Initial history entry
            PriceHistory::create([
                'trash_category_id' => $category->id,
                'harga_lama' => 0,
                'harga_baru' => $category->harga_per_kg,
                'persentase_perubahan' => 100,
                'admin_id' => $admin->id,
                'alasan' => 'Harga awal sistem',
            ]);

            return $category;
        });
    }

    /**
     * Update an existing price and record history.
     */
    public function updatePrice(int $id, array $data, User $admin, ?string $alasan = null): TrashCategory
    {
        return DB::transaction(function () use ($id, $data, $admin, $alasan) {
            $category = TrashCategory::findOrFail($id);
            $oldPrice = $category->harga_per_kg;
            $newPrice = isset($data['harga_per_kg']) ? (float) $data['harga_per_kg'] : $oldPrice;

            // Handle image upload
            if (isset($data['gambar_file'])) {
                // Delete old image if exists (optional logic here)
                $path = $data['gambar_file']->store('trash_categories', 'public');
                $data['gambar'] = $path;
            }

            // Calculate status and percentage if price changed
            if ($oldPrice != $newPrice) {
                $diff = $newPrice - $oldPrice;
                $persentase = $oldPrice > 0 ? ($diff / $oldPrice) * 100 : 100;

                $data['perubahan_persen'] = round(abs($persentase), 2);
                $data['status_harga'] = $newPrice > $oldPrice ? 'naik' : 'turun';
                $data['harga_per_gram'] = $newPrice / 1000;

                // Record history
                PriceHistory::create([
                    'trash_category_id' => $category->id,
                    'harga_lama' => $oldPrice,
                    'harga_baru' => $newPrice,
                    'persentase_perubahan' => $data['perubahan_persen'],
                    'admin_id' => $admin->id,
                    'alasan' => $alasan ?? 'Penyesuaian admin',
                ]);

                // Notifications
                $this->checkAndCreateNotifications($category, $oldPrice, $newPrice, $data['perubahan_persen']);
            } else {
                $data['harga_per_gram'] = $oldPrice / 1000;
            }

            $category->update($data);

            return $category;
        });
    }

    /**
     * Archive or delete a price.
     */
    public function deleteOrArchivePrice(int $id, bool $force = false): bool
    {
        $category = TrashCategory::findOrFail($id);

        // If there are transactions, we can only soft archive
        if ($category->transactions()->exists() && ! $force) {
            $category->update(['is_archived' => true]);

            return false; // Indicates it was archived, not deleted
        }

        $category->delete();

        return true; // Indicates it was deleted
    }

    /**
     * Restore an archived price.
     */
    public function restorePrice(int $id): bool
    {
        $category = TrashCategory::findOrFail($id);

        return $category->update(['is_archived' => false]);
    }

    /**
     * Duplicate a price.
     */
    public function duplicatePrice(int $id, User $admin): TrashCategory
    {
        $category = TrashCategory::findOrFail($id);
        $newCategoryData = $category->toArray();
        unset($newCategoryData['id'], $newCategoryData['kode'], $newCategoryData['created_at'], $newCategoryData['updated_at']);

        $newCategoryData['nama'] = $newCategoryData['nama'].' (Copy)';

        return $this->createPrice($newCategoryData, $admin);
    }

    /**
     * Check and trigger notifications based on price change logic.
     */
    protected function checkAndCreateNotifications(TrashCategory $category, float $old, float $new, float $percent): void
    {
        // 1. Check for drastic change (>20%)
        if ($percent > 20) {
            $this->notificationService->createAdminNotification('harga_drastis', $category, ['persentase' => $percent]);
        }

        // 2. Alert users if price goes up or down
        $type = $new > $old ? 'harga_naik' : 'harga_turun';
        $this->notificationService->createUserNotification($type, $category, $percent);
    }

    /**
     * Get dashboard statistics.
     */
    public function getStatistics(): array
    {
        $activeCategories = TrashCategory::active()->get();

        $stats = [
            'total_jenis' => $activeCategories->count(),
            'harga_tertinggi' => $activeCategories->max('harga_per_kg') ?? 0,
            'harga_terendah' => $activeCategories->min('harga_per_kg') ?? 0,
            'harga_rata_rata' => $activeCategories->avg('harga_per_kg') ?? 0,
            'harga_naik' => $activeCategories->where('status_harga', 'naik')->count(),
            'harga_turun' => $activeCategories->where('status_harga', 'turun')->count(),
            'update_hari_ini' => PriceHistory::whereDate('created_at', Carbon::today())->count(),
        ];

        return $stats;
    }
}
