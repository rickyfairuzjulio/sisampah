# ♻️ SiSampah - Platform Smart Bank Sampah & Ecosystem Pengolahan Limbah

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 13" />
  <img src="https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.3" />
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/AI_Vision-Powered-8A2BE2?style=for-the-badge&logo=google-gemini&logoColor=white" alt="AI Powered" />
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License" />
</p>

**SiSampah** adalah platform digital berbasis Web *production-ready* yang dirancang untuk mengelola dan mengdigitalisasi ekosistem Bank Sampah skala lokal (RT/RW/Desa/Kecamatan). Platform ini mengintegrasikan kecerdasan buatan (**AI Vision & Chatbot**) untuk deteksi jenis sampah secara otomatis, pemetaan lokasi Bank Sampah terdekat (*Interactive Maps*), pengelolaan manifes penjemputan, hingga sistem insentif keuangan (*E-Wallet & Gamifikasi*) bagi masyarakat.

---

## 🌟 Fitur Utama Platform

### 🤖 1. AI Vision & Smart Assistant (Kecerdasan Buatan)
- **Deteksi Sampah via AI Vision**: Pengguna dapat mengunggah foto sampah untuk dianalisis oleh AI mengenai kategori sampah, estimasi berat, potensi ekonomi, dan panduan daur ulang.
- **Chatbot Asisten Lingkungan**: Layanan interaktif 24/7 untuk menjawab pertanyaan seputar pemilahan sampah dan pengelolaan limbah.
- **Riwayat Scan AI**: Menyimpan riwayat hasil pemindaian gambar sampah beserta log analisanya.

### 👤 2. Modul Nasabah (Masyarakat)
- **Dashboard Ringkasan Saldo & Poin**: Menampilkan saldo e-wallet, poin lingkungan, serta riwayat transaksi secara real-time.
- **Penjadwalan Penjemputan Sampah**: Fitur order jemput sampah berdasar lokasi GPS dan foto titik jemput.
- **Katalog & Favorit Harga Sampah**: Cek fluktuasi harga sampah per Kg dan tandai jenis sampah favorit.
- **Dompet Digital & Penarikan Dana**: Mutasi saldo, pengajuan pencairan dana (Tunai/E-Wallet/Transfer Bank), dan fitur Top-Up.
- **Sertifikat Dampak Lingkungan**: Generator sertifikat digital atas kontribusi pengurangan emisi karbon dan penanganan sampah.
- **Rating & Ulasan Petugas**: Memberikan penilaian bintang dan masukan terhadap layanan penjemputan sampah.

### 🚚 3. Modul Petugas (Collector / Lapangan)
- **Manifes Penjemputan Real-Time**: Daftar tugas penjemputan sampah dari nasabah beserta rute dan detail lokasi.
- **Input Timbangan Digital**: Pencatatan otomatis bobot sampah dengan fitur *Snapshot Price* (harga terkunci saat transaksi).
- **Layanan Setor Mandiri**: Penginputan setoran sampah langsung di tempat (*drop-off*) dengan sistem pencarian nasabah yang cepat.
- **Upload Bukti Transaksi**: Dokumentasi foto timbangan untuk audit dan transparansi data.

### 👑 4. Modul Admin & Super Admin
- **Dashboard Statistik Executive**: Overview total transaksi, emisi karbon yang diredam, volume sampah terkumpul, dan performa keuangan.
- **Peta Sebaran Bank Sampah (GIS)**: Peta interaktif (*Leaflet.js*) untuk memetakan sebaran cabang Bank Sampah dan jangkauan wilayah.
- **Manajemen Harga Sampah**: Pengaturan kategori harga (Plastik, Kertas, Logam, Kaca, Organik) beserta histori & pencatatan harga.
- **Validasi Keuangan & Gateway**: Persetujuan penarikan saldo nasabah, validasi resi transfer, dan top-up kas operasional.
- **Laporan & Ekspor Data**: Filter data transaksi berdasar wilayah RT/RW dan rentang tanggal dengan ekspor laporan Excel/CSV.
- **Manajemen Artikel & Edukasi**: Portal artikel untuk meningkatkan literasi daur ulang dan kesadaran lingkungan.

---

## 🛠️ Tech Stack & Arsitektur

- **Backend Framework**: [Laravel 13](https://laravel.com) (PHP 8.3+)
- **Frontend Layer**: Blade Components, Tailwind CSS, Alpine.js
- **Database**: MySQL / MariaDB / SQLite
- **Map & GIS**: Leaflet.js & OpenStreetMap API
- **AI Integration**: Gemini / OpenAI Vision API Integration
- **Authentication**: Laravel Breeze (Session-based)
- **Role & Permission**: `spatie/laravel-permission` (Admin, Petugas, Nasabah)
- **Asset Bundler**: Vite

---

## 🚀 Panduan Instalasi (Local Development)

### Prasyarat System:
- PHP >= 8.3
- Composer >= 2.x
- Node.js >= 18.x & NPM
- MySQL / MariaDB Database Server

### Langkah Instalasi:

1. **Clone Repositori & Masuk ke Directory Project**:
   ```bash
   git clone https://github.com/USERNAME/sisampah.git
   cd sisampah
   ```

2. **Install Dependensi PHP & Node.js**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment (`.env`)**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Buka file `.env` dan sesuaikan kredensial database (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) serta API Key AI (jika menggunakan fitur AI Vision).*

4. **Jalankan Migration & Database Seeder**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Buat Symlink Storage**:
   ```bash
   php artisan storage:link
   ```

6. **Jalankan Server Pembangunan (Development)**:
   ```bash
   # Menggunakan Composer Dev Command (Vite + Artisan Serve secara bersamaan)
   composer dev
   ```
   *Aplikasi akan berjalan di `http://localhost:8000`*

---

## 🔑 Kredensial Akun Default (Seeder)

Setelah menjalankan `php artisan db:seed`, Anda dapat mencoba berbagai peran pengguna berikut:

| Role | Email | Password | Hak Akses Utama |
|---|---|---|---|
| **Super Admin** | `admin@sisampah.local` | `password` | Akses Penuh Sistem, Kelola User, Peta GIS, Validasi Keuangan |
| **Petugas** | `petugas1@sisampah.local` | `password` | Dashboard Manifes, Input Timbangan, Setor Mandiri |
| **Nasabah** | `nasabah1@sisampah.local` | `password` | Order Penjemputan, Dompet Saldo, AI Vision, Sertifikat |

---

## 🗺️ Struktur Utama Routing

- **Publik / Edukasi**:
  - `/` - Landing Page Utama
  - `/edukasi` - Artikel & Media Edukasi
  - `/scan-history` - Riwayat Pemindaian AI
- **Nasabah (`/nasabah/*`)**:
  - `/nasabah/dashboard` - Ringkasan Saldo & Poin
  - `/nasabah/jemput-sampah` - Form Penjemputan Sampah GPS
  - `/nasabah/dompet` - Riwayat & Penarikan Saldo
  - `/nasabah/sertifikat` - Generator Sertifikat Dampak Lingkungan
- **Petugas (`/petugas/*`)**:
  - `/petugas/dashboard-manifes` - Antrean Manifes Penjemputan
  - `/petugas/input-timbangan/{user_id}` - Pencatatan Timbangan Digital
  - `/petugas/setor-mandiri` - Form Drop-off Sampah
- **Admin (`/admin/*`)**:
  - `/admin/dashboard` - Statistik & Performa Bank Sampah
  - `/admin/peta-sebaran` - Peta Lokasi & Sebaran GIS
  - `/admin/validasi-keuangan` - Pencairan Saldo & Kas Operasional
  - `/admin/trash-price` - Manajemen Katalog & Histori Harga

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

<p align="center">
  <b>SiSampah</b> — <i>Solusi Cerdas Pengolahan Sampah Demi Masa Depan Berkelanjutan 🌱</i>
</p>
