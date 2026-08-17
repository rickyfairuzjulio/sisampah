<?php

namespace Database\Seeders;

use App\Models\BankSampah;
use App\Models\TrashCategory;
use Illuminate\Database\Seeder;

class TrashCategorySeeder extends Seeder
{
    public function run(): void
    {
        $banks = BankSampah::all();

        $baseCategories = [
            [
                'nama' => 'Plastik',
                'kode_prefix' => 'PLS',
                'kategori' => 'anorganik',
                'jenis' => 'Botol PET, Kantong, Kemasan',
                'gambar' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=600&auto=format&fit=crop&q=80',
                'harga_base' => 3500,
                'satuan' => 'kg',
                'kualitas' => 'standar',
                'stok_dibutuhkan' => 500,
                'status_harga' => 'naik',
                'perubahan_persen' => 5.50,
                'deskripsi' => 'Sampah plastik termasuk botol, kantong, dan kemasan plastik lainnya',
                'manfaat' => 'Plastik daur ulang dapat dijadikan biji plastik untuk industri manufaktur.',
                'nilai_daur_ulang' => 'Tinggi',
                'tips_penyimpanan' => 'Cuci bersih, lepaskan label, kempiskan botol agar hemat tempat.',
                'tips_menjual' => 'Pilah berdasarkan jenis plastik (PET, HDPE, PP). Plastik bersih terpilah dihargai tinggi.',
            ],
            [
                'nama' => 'Kardus',
                'kode_prefix' => 'KDS',
                'kategori' => 'anorganik',
                'jenis' => 'Kardus Bekas, Box Kemasan',
                'gambar' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?w=600&auto=format&fit=crop&q=80',
                'harga_base' => 2500,
                'satuan' => 'kg',
                'kualitas' => 'standar',
                'stok_dibutuhkan' => 300,
                'status_harga' => 'stabil',
                'perubahan_persen' => 0,
                'deskripsi' => 'Kardus bekas dan kertas kemasan',
                'manfaat' => 'Kardus daur ulang menjadi kertas baru, mengurangi penebangan pohon.',
                'nilai_daur_ulang' => 'Tinggi',
                'tips_penyimpanan' => 'Lipat rapi, hindari basah. Pisahkan dari kardus berlapis plastik.',
                'tips_menjual' => 'Kardus yang bersih dan kering mendapat harga terbaik. Ikat rapi.',
            ],
            [
                'nama' => 'Kertas',
                'kode_prefix' => 'KRT',
                'kategori' => 'anorganik',
                'jenis' => 'Kertas HVS, Koran, Majalah',
                'gambar' => 'https://images.unsplash.com/photo-1586075010923-2dd4570fb338?w=600&auto=format&fit=crop&q=80',
                'harga_base' => 2000,
                'satuan' => 'kg',
                'kualitas' => 'standar',
                'stok_dibutuhkan' => 400,
                'status_harga' => 'turun',
                'perubahan_persen' => -2.30,
                'deskripsi' => 'Kertas putih, koran, dan majalah',
                'manfaat' => 'Kertas daur ulang menghemat 70% energi dibanding kertas baru.',
                'nilai_daur_ulang' => 'Sedang',
                'tips_penyimpanan' => 'Simpan di tempat kering, jauhkan dari air.',
                'tips_menjual' => 'Kertas putih HVS dihargai lebih tinggi dari koran.',
            ],
            [
                'nama' => 'Logam',
                'kode_prefix' => 'LGM',
                'kategori' => 'anorganik',
                'jenis' => 'Aluminium, Besi, Tembaga',
                'gambar' => 'https://images.unsplash.com/photo-1537498425277-c283d32ef9db?w=600&auto=format&fit=crop&q=80',
                'harga_base' => 8000,
                'satuan' => 'kg',
                'kualitas' => 'premium',
                'stok_dibutuhkan' => 200,
                'status_harga' => 'naik',
                'perubahan_persen' => 8.75,
                'deskripsi' => 'Logam bekas termasuk aluminium, besi, dan tembaga',
                'manfaat' => 'Logam 100% dapat didaur ulang tanpa kehilangan kualitas.',
                'nilai_daur_ulang' => 'Sangat Tinggi',
                'tips_penyimpanan' => 'Pisahkan berdasarkan jenis logam. Hindari logam berkarat.',
                'tips_menjual' => 'Tembaga dan aluminium memiliki nilai tertinggi.',
            ],
            [
                'nama' => 'Kaca',
                'kode_prefix' => 'KCC',
                'kategori' => 'anorganik',
                'jenis' => 'Botol Kaca, Pecahan Aman',
                'gambar' => 'https://images.unsplash.com/photo-1516905041604-7a35da3a2b72?w=600&auto=format&fit=crop&q=80',
                'harga_base' => 1500,
                'satuan' => 'kg',
                'kualitas' => 'standar',
                'stok_dibutuhkan' => 150,
                'status_harga' => 'stabil',
                'perubahan_persen' => 0,
                'deskripsi' => 'Botol kaca dan pecahan kaca yang aman',
                'manfaat' => 'Kaca dapat didaur ulang berkali-kali tanpa penurunan kualitas.',
                'nilai_daur_ulang' => 'Tinggi',
                'tips_penyimpanan' => 'Bungkus pecahan kaca dengan koran. Simpan botol utuh terpisah.',
                'tips_menjual' => 'Botol utuh lebih bernilai dari pecahan.',
            ],
            [
                'nama' => 'Organik',
                'kode_prefix' => 'ORG',
                'kategori' => 'organik',
                'jenis' => 'Sisa Makanan, Daun, Ranting',
                'gambar' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=600&auto=format&fit=crop&q=80',
                'harga_base' => 500,
                'satuan' => 'kg',
                'kualitas' => 'rendah',
                'stok_dibutuhkan' => 1000,
                'status_harga' => 'stabil',
                'perubahan_persen' => 0,
                'deskripsi' => 'Sampah organik seperti sisa makanan dan daun',
                'manfaat' => 'Dijadikan kompos berkualitas untuk pertanian organik.',
                'nilai_daur_ulang' => 'Sedang',
                'tips_penyimpanan' => 'Pisahkan dari sampah anorganik. Gunakan wadah tertutup.',
                'tips_menjual' => 'Sampah organik segar lebih disukai untuk komposting.',
            ],
            [
                'nama' => 'Elektronik',
                'kode_prefix' => 'ELK',
                'kategori' => 'b3',
                'jenis' => 'PCB, Kabel, Komponen',
                'gambar' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=600&auto=format&fit=crop&q=80',
                'harga_base' => 12000,
                'satuan' => 'kg',
                'kualitas' => 'premium',
                'stok_dibutuhkan' => 50,
                'status_harga' => 'naik',
                'perubahan_persen' => 12.00,
                'deskripsi' => 'Limbah elektronik termasuk PCB, kabel, dan komponen',
                'manfaat' => 'Mengandung logam mulia (emas, perak, tembaga).',
                'nilai_daur_ulang' => 'Sangat Tinggi',
                'tips_penyimpanan' => 'Jangan bongkar baterai. Simpan di tempat kering.',
                'tips_menjual' => 'Peralatan utuh lebih bernilai. Pisahkan kabel tembaga.',
            ],
            [
                'nama' => 'Tekstil & Pakaian',
                'kode_prefix' => 'TKS',
                'kategori' => 'anorganik',
                'jenis' => 'Pakaian Bekas, Kain Perca, Sepatu/Tas Kain',
                'gambar' => 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=600&auto=format&fit=crop&q=80',
                'harga_base' => 2500,
                'satuan' => 'kg',
                'kualitas' => 'standar',
                'stok_dibutuhkan' => 400,
                'status_harga' => 'naik',
                'perubahan_persen' => 4.00,
                'deskripsi' => 'Limbah tekstil seperti pakaian bekas layak/rusak, kain perca, dan sprei/handuk.',
                'manfaat' => 'Tekstil daur ulang dapat diolah menjadi lap industri (rag), isian peredam, dan benang daur ulang.',
                'nilai_daur_ulang' => 'Sedang',
                'tips_penyimpanan' => 'Cuci bersih dan pastikan dalam kondisi kering. Pisahkan pakaian berserat alami (katun) dari sintetis.',
                'tips_menjual' => 'Pakaian bekas layak pakai yang terpilah baik biasanya dihargai lebih tinggi oleh Bank Sampah.',
            ],
            [
                'nama' => 'Minyak Jelantah',
                'kode_prefix' => 'MJL',
                'kategori' => 'organik',
                'jenis' => 'Minyak Goreng Bekas',
                'gambar' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=600&auto=format&fit=crop&q=80',
                'harga_base' => 4000,
                'satuan' => 'kg',
                'kualitas' => 'standar',
                'stok_dibutuhkan' => 100,
                'status_harga' => 'naik',
                'perubahan_persen' => 3.20,
                'deskripsi' => 'Minyak goreng bekas pakai yang sudah disaring',
                'manfaat' => 'Diolah menjadi biodiesel ramah lingkungan.',
                'nilai_daur_ulang' => 'Tinggi',
                'tips_penyimpanan' => 'Saring dari sisa makanan, simpan dalam botol tertutup.',
                'tips_menjual' => 'Minyak yang bersih dari ampas mendapat harga lebih baik.',
            ],
        ];

        // Seed prices per Bank Sampah unit with unique price variations
        if ($banks->isEmpty()) {
            foreach ($baseCategories as $base) {
                TrashCategory::updateOrCreate(
                    ['kode' => $base['kode_prefix'] . '-001'],
                    array_merge($base, [
                        'kode' => $base['kode_prefix'] . '-001',
                        'harga_per_kg' => $base['harga_base'],
                        'harga_per_gram' => $base['harga_base'] / 1000,
                    ])
                );
            }
            return;
        }

        $multiplierPerBank = [
            'BS-001' => 1.00, // Melati Bersih
            'BS-002' => 1.08, // Tampingan Asri
            'BS-003' => 0.95, // Kenanga Utama
            'BS-004' => 1.15, // Surabaya Eco
            'BS-005' => 1.20, // Bali Asri
        ];

        foreach ($banks as $bank) {
            $mult = $multiplierPerBank[$bank->kode_bank] ?? 1.00;

            foreach ($baseCategories as $idx => $base) {
                $unitPrice = round($base['harga_base'] * $mult, -2);
                $kodeUnit = $base['kode_prefix'] . '-' . str_replace('-', '', $bank->kode_bank);

                TrashCategory::updateOrCreate(
                    [
                        'bank_sampah_id' => $bank->id,
                        'nama' => $base['nama'],
                    ],
                    [
                        'bank_sampah_id' => $bank->id,
                        'nama' => $base['nama'],
                        'kode' => $kodeUnit,
                        'kategori' => $base['kategori'],
                        'jenis' => $base['jenis'],
                        'gambar' => $base['gambar'],
                        'harga_per_kg' => $unitPrice,
                        'harga_per_gram' => $unitPrice / 1000,
                        'satuan' => $base['satuan'],
                        'kualitas' => $base['kualitas'],
                        'stok_dibutuhkan' => $base['stok_dibutuhkan'],
                        'status_harga' => $base['status_harga'],
                        'perubahan_persen' => $base['perubahan_persen'],
                        'deskripsi' => $base['deskripsi'],
                        'manfaat' => $base['manfaat'],
                        'nilai_daur_ulang' => $base['nilai_daur_ulang'],
                        'tips_penyimpanan' => $base['tips_penyimpanan'],
                        'tips_menjual' => $base['tips_menjual'],
                        'is_archived' => false,
                    ]
                );
            }
        }
    }
}
