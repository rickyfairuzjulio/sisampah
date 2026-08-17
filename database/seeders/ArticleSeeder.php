<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'superadmin@sisampah.id')->first() ?: User::role('admin')->first();

        if (! $admin) {
            return;
        }

        $articles = [
            [
                'judul' => 'Pentingnya Daur Ulang untuk Lingkungan & Masa Depan',
                'kategori' => 'Edukasi Daur Ulang',
                'gambar' => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=1000&auto=format&fit=crop&q=80',
                'konten' => "Daur ulang adalah proses mengubah bahan limbah menjadi produk baru bernilai guna. Dengan melakukan pemilahan sampah dari rumah, kita dapat menghemat penggunaan sumber daya alam, menekan emisi gas rumah kaca, dan memperpanjang umur Tempat Pembuangan Akhir (TPA).\n\nSetiap kilogram sampah anorganik yang didaur ulang setara dengan menghemat energi listrik serta mengurangi jejak karbon desa. Bergabung dengan Bank Sampah SiSampah merupakan langkah konkret menjaga kelestarian lingkungan demi generasi mendatang.",
            ],
            [
                'judul' => 'Cara Pemilahan Sampah Organik & Anorganik dari Rumah',
                'kategori' => 'Tips Pemilahan',
                'gambar' => 'https://images.unsplash.com/photo-1605600659873-d808a13e4d2a?w=1000&auto=format&fit=crop&q=80',
                'konten' => "Langkah pertama menuju lingkungan bersih dimulainya dari pemilahan sampah di dapur dan rumah tangga:\n\n1. Sampah Organik: Sisa sayuran, buah, dan daun dapat diolah menjadi pupuk kompos.\n2. Sampah Anorganik: Botol plastik, kardus, kertas, dan kaleng aluminium wajib dibersihkan dan dikeringkan sebelum disetor.\n3. Sampah B3: Baterai bekas dan botol kimia dipisahkan secara khusus.\n\nSampah anorganik yang bersih dan tidak tercampur bahan basah akan dinilai dengan harga tertinggi oleh unit Bank Sampah.",
            ],
            [
                'judul' => 'Manfaat Ekonomi & Sistem Saldo Digital Bank Sampah',
                'kategori' => 'Ekonomi Sirkular',
                'gambar' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=1000&auto=format&fit=crop&q=80',
                'konten' => "Bank Sampah menerapkan prinsip Ekonomi Sirkular yang mengubah limbah menjadi nilai uang tunai. Setiap sampah yang disetorkan nasabah disimbang secara transparan oleh petugas dan langsung dikonversi menjadi saldo digital.\n\nSaldo digital yang terkumpul dapat ditarik secara tunai di lokasi Bank Sampah atau ditransfer langsung ke rekening bank dan dompet digital nasabah (E-Wallet).",
            ],
            [
                'judul' => 'Mengenal Kode Jenis Plastik (PET, HDPE, PP) & Harga Jualnya',
                'kategori' => 'Pengetahuan Sampah',
                'gambar' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=1000&auto=format&fit=crop&q=80',
                'konten' => "Plastik memiliki kode daur ulang 1 sampai 7 yang menentukan harga jual per kilogramnya:\n\n- PET (Kode 1): Botol mineral transparan. Memiliki harga jual stabil dan tinggi.\n- HDPE (Kode 2): Botol jerigen, botol shampo tebal.\n- PP (Kode 5): Gelas minuman dan wadah makanan tahan panas.\n\nMemisahkan botol plastik berdasarkan warna dan melepas segel plastiknya akan menaikkan grade kualifikasi penimbangan di Bank Sampah.",
            ],
            [
                'judul' => 'Bahaya Mikroplastik & Pentingnya Menjaga Lautan',
                'kategori' => 'Kesadaran Lingkungan',
                'gambar' => 'https://images.unsplash.com/photo-1621451537084-482c73073a0f?w=1000&auto=format&fit=crop&q=80',
                'konten' => "Sampah plastik yang terbuang ke perairan membutuhkan ratusan tahun untuk terurai. Dalam prosesnya, plastik memecah menjadi partikel mikroplastik berukuran kurang dari 5mm yang termakan oleh biota laut dan berisiko masuk ke rantai makanan manusia.\n\nDengan memanfaatkan fitur layanan Penjemputan Sampah SiSampah, Anda memastikan plastik olahan rumah tangga masuk ke jalur daur ulang resmi dan tidak terbuang ke laut.",
            ],
            [
                'judul' => 'Panduan Lengkap Penjemputan Sampah Berbasis Peta GPS',
                'kategori' => 'Panduan Aplikasi',
                'gambar' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=1000&auto=format&fit=crop&q=80',
                'konten' => "Aplikasi SiSampah menyediakan fitur Penjemputan Sampah Mandiri langsung dari lokasi rumah Anda:\n\n1. Buka menu 'Jemput Sampah' di aplikasi.\n2. Tentukan koordinat titik rumah Anda melalui Peta GPS Interaktif.\n3. Pilih jenis dan perkiraan berat sampah.\n4. Petugas armada Bank Sampah akan datang menjemput sampah sesuai jadwal dan langsung melakukan penimbangan di tempat.",
            ],
            [
                'judul' => 'Panduan Olah Sampah Organik Menjadi Kompos & Eco-Enzyme',
                'kategori' => 'Tips Pemilahan',
                'gambar' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=1000&auto=format&fit=crop&q=80',
                'konten' => "Sampah organik seperti kulit buah dan sisa sayuran dapat dimanfaatkan menjadi pupuk kompos alami atau cairan pembersih serbaguna Eco-Enzyme.\n\nMembuat Eco-Enzyme sangat mudah: campurkan 3 bagian sisa buah/sayur, 1 bagian gula merah/molase, dan 10 bagian air bersih dalam wadah tertutup selama 3 bulan. Cairan yang dihasilkan sangat efektif untuk pembersih ramah lingkungan.",
            ],
            [
                'judul' => 'Daftar Kategori & Tren Pergerakan Harga Sampah Terbaru',
                'kategori' => 'Katalog Harga',
                'gambar' => 'https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?w=1000&auto=format&fit=crop&q=80',
                'konten' => "Bank Sampah SiSampah secara berkala memperbarui tarif dan katalog harga sampah anorganik berdasarkan pergerakan pasar daur ulang nasional:\n\n- Kertas & Kardus: Rp 1.500 - Rp 2.500 / kg\n- Botol Plastik PET: Rp 3.000 - Rp 5.000 / kg\n- Logam Aluminium & Tembaga: Rp 12.000 - Rp 65.000 / kg\n\nPantau pergerakan grafik tren harga pada menu 'Katalog Harga' di aplikasi SiSampah untuk mendapatkan keuntungan optimal saat menyetor sampah.",
            ],
        ];

        foreach ($articles as $article) {
            $slug = Str::slug($article['judul']);

            Article::updateOrCreate(
                ['slug' => $slug],
                [
                    'judul' => $article['judul'],
                    'konten' => $article['konten'],
                    'kategori' => $article['kategori'],
                    'gambar' => $article['gambar'],
                    'image' => $article['gambar'],
                    'created_by' => $admin->id,
                    'is_published' => true,
                ]
            );
        }
    }
}
