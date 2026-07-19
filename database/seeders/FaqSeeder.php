<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'pertanyaan' => 'Apa itu aplikasi SiSampah?',
                'jawaban' => 'SiSampah adalah platform Bank Sampah Digital yang memudahkan masyarakat (Nasabah) untuk menjual sampah daur ulang mereka, menabung saldo, dan berpartisipasi menjaga lingkungan hidup.',
            ],
            [
                'pertanyaan' => 'Bagaimana cara menyetor sampah?',
                'jawaban' => 'Terdapat dua metode penyetoran: \n1. **Setor Mandiri**: Anda bisa membawa langsung sampah yang sudah dipilah ke lokasi Bank Sampah terdekat.\n2. **Jemput Sampah**: Anda bisa meminta Petugas untuk datang menjemput sampah langsung ke rumah Anda melalui menu Jemput.',
            ],
            [
                'pertanyaan' => 'Apakah semua jenis sampah bisa disetor?',
                'jawaban' => 'Saat ini kami berfokus menerima sampah **Anorganik** seperti: Botol Plastik (PET), Kardus, Kertas HVS, Besi, Aluminium, dan Tembaga. Anda bisa mengecek daftar lengkapnya di menu **Harga Sampah**.',
            ],
            [
                'pertanyaan' => 'Bagaimana cara cek harga sampah hari ini?',
                'jawaban' => 'Anda bisa melihat *update* harga secara real-time di halaman **Beranda** (Dashboard) Nasabah atau masuk ke menu **Harga Sampah**. Harga bisa naik/turun menyesuaikan harga pasar pengepul.',
            ],
            [
                'pertanyaan' => 'Bagaimana cara mencairkan saldo atau menarik uang?',
                'jawaban' => 'Masuk ke menu **Dompet**, lalu klik **Tarik Saldo**. Anda bisa memilih metode pencairan secara Tunai (ambil di lokasi) atau Transfer Bank/E-Wallet. Masukkan nominal dan tunggu persetujuan Admin.',
            ],
            [
                'pertanyaan' => 'Berapa lama proses pencairan saldo penarikan dana?',
                'jawaban' => 'Proses persetujuan (validasi) oleh Admin biasanya memakan waktu **1x24 jam hari kerja**. Jika disetujui, Admin akan melampirkan bukti transfer di riwayat penarikan Anda.',
            ],
            [
                'pertanyaan' => 'Apakah ada biaya tambahan untuk fitur Jemput Sampah?',
                'jawaban' => 'Tidak ada! Layanan jemput sampah oleh petugas kami **100% Gratis** untuk nasabah yang terdaftar dalam cakupan wilayah RT/RW layanan kami.',
            ],
            [
                'pertanyaan' => 'Bagaimana sistem Poin Lingkungan bekerja?',
                'jawaban' => 'Selain mendapat saldo uang, setiap 1 Kg sampah yang Anda setor akan dihitung sebagai Poin Lingkungan. Nasabah dengan kontribusi tertinggi akan masuk ke dalam daftar **Pahlawan Lingkungan (Leaderboard)**.',
            ],
            [
                'pertanyaan' => 'Kenapa harga sampah bisa berubah-ubah (naik/turun)?',
                'jawaban' => 'Harga material daur ulang bersifat fluktuatif (berubah-ubah) mengikuti standar harga pabrik pengolah dan pasar komoditas global. Oleh karena itu, aplikasi kami memiliki sistem grafik Riwayat Harga.',
            ],
            [
                'pertanyaan' => 'Apakah sampah organik (sisa makanan) bisa ditabung?',
                'jawaban' => 'Mohon maaf, saat ini kami **belum menerima** sampah organik (sisa makanan/daun basah). Kami sarankan Anda membuat lubang biopori atau komposter mandiri di rumah untuk sampah organik.',
            ],
            [
                'pertanyaan' => 'Bagaimana cara memilah sampah yang benar sebelum disetor?',
                'jawaban' => '1. Pastikan sampah dalam keadaan **bersih dan kering** (cuci sisa minuman manis di botol).\n2. **Pisahkan** berdasarkan material (kertas dengan kertas, botol plastik dengan plastik).\n3. Kemas dengan rapi menggunakan karung atau dus.',
            ],
            [
                'pertanyaan' => 'Apakah saldo tabungan saya bisa hangus atau kedaluwarsa?',
                'jawaban' => 'Tidak. Saldo Anda **aman sepenuhnya** di sistem kami dan tidak memiliki masa berlaku. Anda bisa menyimpannya selama bertahun-tahun sebagai tabungan jangka panjang.',
            ],
            [
                'pertanyaan' => 'Siapa yang menimbang sampah saya?',
                'jawaban' => 'Penimbangan dilakukan oleh **Petugas SiSampah** yang ditugaskan, baik saat menjemput ke rumah Anda, maupun saat Anda datang menyetor ke lokasi. Data timbangan akan langsung dimasukkan ke aplikasi secara transparan.',
            ],
            [
                'pertanyaan' => 'Saya lupa password akun, apa yang harus dilakukan?',
                'jawaban' => 'Anda bisa menggunakan fitur "Lupa Password" di halaman Login, atau langsung menghubungi pengurus/Admin RT setempat agar akun Anda di-*reset* secara manual.',
            ],
            [
                'pertanyaan' => 'Apakah saya bisa mendaftar jika saya di luar wilayah cakupan RT/RW?',
                'jawaban' => 'Saat ini operasional kami difokuskan pada pemberdayaan RT/RW setempat. Namun, Anda tetap bisa mendaftar dengan memilih opsi "Lainnya" pada kolom wilayah, dengan catatan layanan jemput sampah mungkin dibatasi.',
            ],
            [
                'pertanyaan' => 'Apa bedanya peran Nasabah, Petugas, dan Admin?',
                'jawaban' => '1. **Nasabah**: Masyarakat yang menabung sampah.\n2. **Petugas**: Tim lapangan yang menimbang dan menginput data setoran.\n3. **Admin**: Pengelola utama yang mengatur harga, memvalidasi pencairan dana, dan mencetak laporan.',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
