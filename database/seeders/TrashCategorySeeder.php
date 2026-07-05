<?php

namespace Database\Seeders;

use App\Models\TrashCategory;
use Illuminate\Database\Seeder;

class TrashCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nama' => 'Plastik',
                'harga_per_kg' => 3500,
                'deskripsi' => 'Sampah plastik termasuk botol, kantong, dan kemasan plastik lainnya',
            ],
            [
                'nama' => 'Kardus',
                'harga_per_kg' => 2500,
                'deskripsi' => 'Kardus bekas dan kertas kemasan',
            ],
            [
                'nama' => 'Kertas',
                'harga_per_kg' => 2000,
                'deskripsi' => 'Kertas putih, koran, dan majalah',
            ],
            [
                'nama' => 'Logam',
                'harga_per_kg' => 8000,
                'deskripsi' => 'Logam bekas termasuk aluminium, besi, dan tembaga',
            ],
            [
                'nama' => 'Kaca',
                'harga_per_kg' => 1500,
                'deskripsi' => 'Botol kaca dan pecahan kaca yang aman',
            ],
            [
                'nama' => 'Organik',
                'harga_per_kg' => 500,
                'deskripsi' => 'Sampah organik seperti sisa makanan dan daun',
            ],
        ];

        foreach ($categories as $category) {
            TrashCategory::create($category);
        }
    }
}
