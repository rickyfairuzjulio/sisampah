<?php

namespace Database\Seeders;

use App\Models\PriceHistory;
use App\Models\TrashCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class PriceHistorySeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'superadmin@sisampah.id')->first() ?: User::role('admin')->first();

        if (! $admin) {
            return;
        }

        $categories = TrashCategory::all();
        $reasons = [
            'Penyesuaian harga pasar',
            'Kenaikan permintaan dari pengepul',
            'Harga bahan baku naik',
            'Stok berlebih, penurunan harga',
            'Evaluasi harga bulanan',
            'Penyesuaian inflasi',
            'Permintaan industri meningkat',
            'Harga turun karena musim hujan',
        ];

        foreach ($categories as $category) {
            $basePrice = $category->harga_per_kg;

            // Generate 30 days of price history
            for ($i = 30; $i >= 1; $i--) {
                $fluctuation = rand(-15, 15) / 100; // -15% to +15%
                $oldPrice = $basePrice * (1 + (rand(-20, 20) / 100));
                $newPrice = $oldPrice * (1 + $fluctuation);

                $oldPrice = max(100, round($oldPrice / 100) * 100);
                $newPrice = max(100, round($newPrice / 100) * 100);

                if ($oldPrice == $newPrice) {
                    continue;
                }

                $persentase = $oldPrice > 0
                    ? round((($newPrice - $oldPrice) / $oldPrice) * 100, 2)
                    : 0;

                PriceHistory::create([
                    'trash_category_id' => $category->id,
                    'harga_lama' => $oldPrice,
                    'harga_baru' => $newPrice,
                    'persentase_perubahan' => $persentase,
                    'admin_id' => $admin->id,
                    'alasan' => $reasons[array_rand($reasons)],
                    'created_at' => now()->subDays($i)->addHours(rand(8, 17)),
                    'updated_at' => now()->subDays($i)->addHours(rand(8, 17)),
                ]);
            }
        }
    }
}
