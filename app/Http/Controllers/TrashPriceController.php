<?php

namespace App\Http\Controllers;

use App\Core\Services\PricePredictionService;
use App\Core\Services\TrashPriceService;
use App\Http\Requests\StoreTrashPriceRequest;
use App\Http\Requests\UpdateTrashPriceRequest;
use App\Models\PriceHistory;
use App\Models\TrashCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrashPriceController extends Controller
{
    protected TrashPriceService $priceService;

    protected PricePredictionService $predictionService;

    public function __construct(TrashPriceService $priceService, PricePredictionService $predictionService)
    {
        $this->priceService = $priceService;
        $this->predictionService = $predictionService;
    }

    // ==========================================
    // ADMIN ACTIONS
    // ==========================================

    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->loadMissing('bankSampah');
        }
        $bsId = $user?->bank_sampah_id;
        $unitBankSampah = $bsId ? \App\Models\BankSampah::find($bsId) : \App\Models\BankSampah::first();

        $authData = [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name ?? 'Admin',
                'email' => $user?->email ?? 'admin@sisampah.id',
                'avatar_url' => $user?->avatar_url,
                'role' => 'admin',
            ],
            'is_super_admin' => false,
            'bank_sampah_name' => $unitBankSampah?->nama ?? 'Unit Melati Asri',
            'bank_sampah_id' => $unitBankSampah?->id,
            'unit_address' => $unitBankSampah ? ($unitBankSampah->alamat . ', ' . $unitBankSampah->desa . ', ' . $unitBankSampah->kecamatan) : 'Desa Sukamaju, RT 01 / RW 02, Kec. Ngaliyan, Kota Semarang',
        ];

        $categoriesQuery = TrashCategory::query();
        if ($bsId) {
            $categoriesQuery->where(function($q) use ($bsId) {
                $q->where('bank_sampah_id', $bsId)->orWhereNull('bank_sampah_id');
            });
        }

        $allCategories = $categoriesQuery->orderBy('kategori')->orderBy('nama')->get();

        $mapCategory = function ($c) {
            $group = strtolower($c->kategori ?? 'lainnya');
            $emoji = '📦';
            if (str_contains($group, 'plastik')) $emoji = '🍾';
            elseif (str_contains($group, 'kertas') || str_contains($group, 'karton')) $emoji = '📦';
            elseif (str_contains($group, 'logam') || str_contains($group, 'besi') || str_contains($group, 'aluminium')) $emoji = '🔩';
            elseif (str_contains($group, 'kaca') || str_contains($group, 'beling')) $emoji = '🍶';
            elseif (str_contains($group, 'minyak') || str_contains($group, 'jelantah')) $emoji = '🛢️';
            elseif (str_contains($group, 'organik')) $emoji = '🍂';
            elseif (str_contains($group, 'elektronik') || str_contains($group, 'e-waste')) $emoji = '💻';

            $price = (float) $c->harga_per_kg;
            $unit = $c->satuan ?: 'kg';

            return [
                'id' => $c->id,
                'name' => $c->nama,
                'code' => $c->kode ?? ('TR-' . str_pad($c->id, 3, '0', STR_PAD_LEFT)),
                'category_group' => $c->kategori ?? 'Umum',
                'unit' => $unit,
                'price_per_kg' => $price,
                'price_formatted' => 'Rp ' . number_format($price, 0, ',', '.') . ' / ' . $unit,
                'price_min' => (float) ($c->harga_minimal ?: $price * 0.9),
                'price_max' => (float) ($c->harga_maksimal ?: $price * 1.15),
                'status_harga' => $c->status_harga ?? 'stabil',
                'perubahan_persen' => (float) ($c->perubahan_persen ?? 0),
                'kualitas' => $c->kualitas ?? 'Standar Terpilah',
                'points_reward' => round($price / 100) . ' Pts / ' . $unit,
                'image_url' => $c->image_url ?? $c->gambar,
                'emoji' => $emoji,
                'is_archived' => (bool) $c->is_archived,
                'description' => $c->deskripsi ?? 'Material terpilah bersih dan kering siap ditimbang.',
                'tips' => $c->tips_menjual ?? $c->tips_penyimpanan ?? 'Pastikan tidak tercampur cairan dan sampah basah.',
            ];
        };

        $categoryList = $allCategories->map($mapCategory)->values();

        $maxPrice = (float) ($allCategories->max('harga_per_kg') ?: 15000);
        $statistics = [
            'total_categories' => $allCategories->count() ?: 18,
            'highest_price' => $maxPrice,
            'highest_price_formatted' => 'Rp ' . number_format($maxPrice, 0, ',', '.') . ' / kg',
            'price_up_count' => $allCategories->where('status_harga', 'naik')->count() ?: 4,
            'price_down_count' => $allCategories->where('status_harga', 'turun')->count() ?: 2,
        ];

        return view('admin.trash-price.index', compact('authData', 'statistics', 'categoryList'));
    }

    public function show($id)
    {
        $category = TrashCategory::with(['bankSampah', 'priceHistories.admin'])->findOrFail($id);
        $prediction = $this->predictionService->predictPrice($id, 7); // Predict 7 days ahead
        $trend = $this->predictionService->getTrendAnalysis($id);

        $histories = PriceHistory::where('trash_category_id', $id)
            ->with('admin')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $chartHistories = PriceHistory::where('trash_category_id', $id)
            ->orderBy('created_at', 'asc')
            ->take(30)
            ->get();

        return view('admin.trash-price.show', compact('category', 'prediction', 'trend', 'histories', 'chartHistories'));
    }

    public function store(StoreTrashPriceRequest $request)
    {
        $validated = $request->validated();

        if (Auth::user()?->bank_sampah_id) {
            $validated['bank_sampah_id'] = Auth::user()->bank_sampah_id;
        }

        $this->priceService->createPrice($validated, Auth::user());

        return redirect()->route('admin.trash_price.index')->with('success', 'Harga sampah berhasil ditambahkan.');
    }

    public function update(UpdateTrashPriceRequest $request, $id)
    {
        $data = $request->validated();
        $alasan = $request->input('alasan');

        $this->priceService->updatePrice($id, $data, Auth::user(), $alasan);

        return redirect()->route('admin.trash_price.index')->with('success', 'Harga sampah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $deleted = $this->priceService->deleteOrArchivePrice($id);
        $message = $deleted
            ? 'Harga sampah berhasil dihapus.'
            : 'Kategori ini memiliki transaksi, sehingga telah diarsipkan (soft delete).';

        return redirect()->route('admin.trash_price.index')->with('success', $message);
    }

    public function archive($id)
    {
        $this->priceService->deleteOrArchivePrice($id, false);

        return redirect()->route('admin.trash_price.index')->with('success', 'Harga sampah berhasil diarsipkan.');
    }

    public function restore($id)
    {
        $this->priceService->restorePrice($id);

        return redirect()->route('admin.trash_price.index')->with('success', 'Harga sampah berhasil dikembalikan dari arsip.');
    }

    public function duplicate($id)
    {
        $this->priceService->duplicatePrice($id, Auth::user());

        return redirect()->route('admin.trash_price.index')->with('success', 'Data harga berhasil digandakan.');
    }

    public function history(Request $request)
    {
        $query = PriceHistory::with(['trashCategory', 'admin'])->orderBy('created_at', 'desc');

        if ($request->filled('kategori_id')) {
            $query->where('trash_category_id', $request->kategori_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $histories = $query->paginate(15);
        $categories = TrashCategory::all();

        return view('admin.trash-price.history', compact('histories', 'categories'));
    }

    // ==========================================
    // NASABAH / PUBLIC ACTIONS
    // ==========================================

    public function publicIndex(Request $request)
    {
        $user = Auth::user();
        $userLat = $request->filled('lat') ? (float)$request->lat : -6.8915;
        $userLng = $request->filled('lng') ? (float)$request->lng : 107.6107;
        $radiusKm = $request->filled('radius') ? (float)$request->radius : 5.0;

        // Determine target Bank Sampah (default to user's followed unit or requested unit)
        $selectedBsId = $request->filled('bank_sampah_id') 
            ? (int) $request->bank_sampah_id 
            : ($user?->bank_sampah_id ?: (\App\Models\BankSampah::active()->first()?->id ?? 1));

        $selectedBankSampah = \App\Models\BankSampah::find($selectedBsId) ?: \App\Models\BankSampah::first();

        // Fetch active Bank Sampahs within dynamic radius
        $allActiveBankSampahs = \App\Models\BankSampah::active()->get();
        $nearbyBankSampahs = $allActiveBankSampahs->filter(function ($bs) use ($userLat, $userLng, $radiusKm) {
            if ($radiusKm >= 999) return true; // 'semua' filter
            $dist = $bs->calculateDistance($userLat, $userLng);
            return $dist <= $radiusKm || $dist == 0;
        })->values()->map(fn($b) => [
            'id' => $b->id,
            'nama' => $b->nama,
            'alamat' => $b->alamat,
            'kecamatan' => $b->kecamatan ?? 'Terdekat',
            'is_my_unit' => $user?->bank_sampah_id == $b->id,
        ]);

        $activeCategory = $request->input('kategori', 'all');
        $favorites = $user ? $user->priceFavorites()->pluck('trash_category_id')->toArray() : [];

        // Query categories
        $query = TrashCategory::active()
            ->when($selectedBsId, fn($q) => $q->where('bank_sampah_id', $selectedBsId));

        if ($activeCategory === 'favorites') {
            $query->whereIn('id', $favorites);
        } elseif (in_array($activeCategory, ['organik', 'anorganik', 'b3'])) {
            $query->where('kategori', $activeCategory);
        }

        $rawPrices = $query->get();

        $prices = $rawPrices->map(fn($p) => [
            'id' => $p->id,
            'nama' => $p->nama,
            'kode' => $p->kode ?: 'SM-'.str_pad($p->id, 2, '0', STR_PAD_LEFT),
            'kategori' => strtolower($p->kategori ?: 'anorganik'),
            'kualitas' => $p->kualitas ?: 'Grade A',
            'harga_per_kg' => (int) $p->harga_per_kg,
            'satuan' => $p->satuan ?: 'Kg',
            'status_harga' => $p->status_harga ?: 'stabil',
            'perubahan_persen' => (float) ($p->perubahan_persen ?? 0),
            'deskripsi' => $p->deskripsi ?: 'Sampah pilah bersih siap setor dan timbang.',
            'image_url' => $p->image_url,
            'is_favorite' => in_array($p->id, $favorites),
        ]);

        // Category Counts
        $baseQuery = TrashCategory::active()->when($selectedBsId, fn($q) => $q->where('bank_sampah_id', $selectedBsId));
        $categoryCounts = [
            'all' => (clone $baseQuery)->count(),
            'organik' => (clone $baseQuery)->where('kategori', 'organik')->count(),
            'anorganik' => (clone $baseQuery)->where('kategori', 'anorganik')->count(),
            'b3' => (clone $baseQuery)->where('kategori', 'b3')->count(),
            'favorites' => (clone $baseQuery)->whereIn('id', $favorites)->count(),
        ];

        $authData = [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name ?? 'Nasabah',
                'email' => $user?->email,
                'avatar_url' => $user?->avatar_url,
            ],
            'bank_sampah_name' => $user?->bankSampah?->nama ?? 'Unit Melati',
            'bank_sampah_id' => $user?->bank_sampah_id,
        ];

        $selectedBankSampahData = [
            'id' => $selectedBankSampah?->id,
            'nama' => $selectedBankSampah?->nama ?? 'Bank Sampah Unit',
            'alamat' => $selectedBankSampah?->alamat ?? 'Alamat Unit Domisili',
            'kecamatan' => $selectedBankSampah?->kecamatan ?? 'Terdekat',
            'is_my_unit' => $user?->bank_sampah_id == $selectedBankSampah?->id,
        ];

        return view('nasabah.prices.index', compact(
            'authData',
            'selectedBankSampahData',
            'nearbyBankSampahs',
            'radiusKm',
            'selectedBsId',
            'activeCategory',
            'prices',
            'categoryCounts'
        ));
    }

    public function publicShow($id)
    {
        $category = TrashCategory::active()->findOrFail($id);

        // Data for chart
        $histories = PriceHistory::where('trash_category_id', $id)
            ->orderBy('created_at', 'asc')
            ->take(30)
            ->get();

        $user = Auth::user();
        $isFavorite = $user ? $user->priceFavorites()->where('trash_category_id', $id)->exists() : false;

        return view('nasabah.prices.show', compact('category', 'histories', 'isFavorite'));
    }

    public function toggleFavorite($id)
    {
        $user = Auth::user();
        $exists = $user->priceFavorites()->where('trash_category_id', $id)->exists();

        if ($exists) {
            $user->priceFavorites()->where('trash_category_id', $id)->delete();

            return response()->json(['status' => 'removed', 'message' => 'Dihapus dari favorit']);
        } else {
            $user->priceFavorites()->create(['trash_category_id' => $id]);

            return response()->json(['status' => 'added', 'message' => 'Ditambahkan ke favorit']);
        }
    }

    public function favorites()
    {
        $user = Auth::user();
        $favorites = $user->priceFavorites()->with('trashCategory')->get();

        return view('nasabah.prices.favorites', compact('favorites'));
    }
}
