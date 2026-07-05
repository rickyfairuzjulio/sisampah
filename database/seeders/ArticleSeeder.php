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
        $admin = User::where('email', 'admin@sisampah.local')->first();

        if (! $admin) {
            return;
        }

        $articles = [
            [
                'judul' => 'Pentingnya Daur Ulang untuk Lingkungan',
                'kategori' => 'Edukasi Daur Ulang',
                'gambar' => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=800&q=80',
                'konten' => "Daur ulang adalah proses mengubah sampah menjadi bahan atau produk baru yang bermanfaat. Pengertian daur ulang mencakup pengumpulan, pemilahan, pengolahan, dan pembuatan produk baru dari material bekas.\n\nManfaat utama daur ulang antara lain mengurangi volume sampah di Tempat Pembuangan Akhir (TPA), menghemat energi dan sumber daya alam, serta menurunkan emisi gas rumah kaca. Setiap kilogram sampah yang didaur ulang berarti mengurangi beban lingkungan.\n\nSebagai nasabah bank sampah, Anda turut berperan dalam rantai daur ulang dengan memilah dan menyerahkan sampah bernilai ekonomi. Tindakan kecil di tingkat rumah tangga berdampak besar bagi keberlanjutan desa.",
            ],
            [
                'judul' => 'Cara Memilah Sampah dengan Benar',
                'kategori' => 'Tips Pemilahan',
                'gambar' => 'https://images.unsplash.com/photo-1611280045168-d2b97a447c68?w=800&q=80',
                'konten' => "Pemilahan sampah adalah langkah pertama dan paling penting dalam sistem bank sampah. Pengertian pemilahan adalah memisahkan sampah berdasarkan jenis dan karakteristiknya agar mudah diolah.\n\nKategori umum: organik (sisa makanan, daun), anorganik kering (kertas, kardus, plastik, logam), dan B3 (baterai, lampu). Cuci dan keringkan sampah anorganik sebelum disetor agar tidak menurunkan kualitas dan harga.\n\nGunakan wadah terpisah di rumah. Label setiap tempat sampah agar seluruh anggota keluarga ikut berpartisipasi. Pemilahan yang benar meningkatkan nilai jual dan mempercepat proses penimbangan di bank sampah.",
            ],
            [
                'judul' => 'Manfaat Ekonomi Bank Sampah',
                'kategori' => 'Ekonomi Sirkular',
                'gambar' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&q=80',
                'konten' => "Bank sampah adalah model ekonomi sirkular yang mengubah sampah menjadi sumber pendapatan masyarakat. Pengertian ekonomi sirkular adalah sistem di mana material tetap berputar dalam siklus produksi tanpa menjadi limbah.\n\nNasabah menerima imbalan berupa saldo digital berdasarkan berat dan jenis sampah. Saldo dapat ditarik tunai atau transfer. Sistem ini mendorong partisipasi aktif karena ada insentif ekonomi langsung.\n\nDi tingkat desa, bank sampah menciptakan lapangan kerja bagi petugas pengumpul dan pengolah. Dampaknya meliputi peningkatan pendapatan rumah tangga, kebersihan lingkungan, dan kemandirian ekonomi komunitas.",
            ],
            [
                'judul' => 'Jenis-Jenis Plastik dan Cara Pengolahannya',
                'kategori' => 'Pengetahuan Sampah',
                'gambar' => 'https://images.unsplash.com/photo-1565793298595-6a879b1d9492?w=800&q=80',
                'konten' => "Plastik memiliki berbagai jenis yang ditandai simbol segitiga dengan angka 1–7 di kemasan. Pengertian kode plastik membantu menentukan apakah material dapat didaur ulang dan bagaimana cara pengolahannya.\n\nPET (1) dan HDPE (2) paling umum didaur ulang — botol minuman dan jerigen. PVC (3) dan PS (6) lebih sulit diolah. PP (5) sering digunakan untuk tutup botol dan wadah makanan.\n\nCuci bersih plastik sebelum disetor. Lepaskan label dan tutup jika jenis plastiknya berbeda. Plastik yang bersih dan terpilah mendapat harga lebih tinggi di bank sampah.",
            ],
            [
                'judul' => 'Dampak Sampah Plastik terhadap Laut',
                'kategori' => 'Kesadaran Lingkungan',
                'gambar' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800&q=80',
                'konten' => "Sampah plastik yang tidak dikelola dengan baik dapat terbawa ke sungai dan laut, menyebabkan pencemaran ekosistem perairan. Pengertian polusi plastik laut adalah akumulasi material sintetis yang mengganggu kehidupan biota air.\n\nHewan laut dapat menelan plastik dan mengalami luka atau kematian. Plastik juga terurai menjadi mikroplastik — partikel kecil yang masuk rantai makanan hingga ke manusia.\n\nDengan memilah plastik di sumber (rumah tangga) dan menyerahkannya ke bank sampah, kita mencegah plastik berakhir di perairan. Setiap kilogram plastik yang disetor adalah kontribusi nyata untuk laut yang lebih bersih.",
            ],
            [
                'judul' => 'Panduan Menggunakan Aplikasi SiSampah',
                'kategori' => 'Panduan Aplikasi',
                'gambar' => 'https://images.unsplash.com/photo-1556740758-90de374c12ad?w=800&q=80',
                'konten' => "SiSampah adalah aplikasi bank sampah digital yang menghubungkan nasabah, petugas, dan admin dalam satu platform. Pengertian platform ini adalah sistem terintegrasi untuk mencatat setoran, penjemputan, saldo, dan laporan secara transparan.\n\nSebagai nasabah: daftar akun, jadwalkan penjemputan dengan peta GPS, pantau saldo di dashboard, dan ajukan penarikan dana. Sebagai petugas: kelola manifes jemputan, input timbangan dengan foto bukti. Sebagai admin: atur harga sampah, validasi penarikan, dan ekspor laporan.\n\nGunakan fitur deteksi GPS saat memesan jemput agar petugas menemukan lokasi Anda dengan akurat. Pantau papan peringkat untuk motivasi mengumpulkan lebih banyak sampah.",
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
                    'created_by' => $admin->id,
                    'is_published' => true,
                ]
            );
        }
    }
}
