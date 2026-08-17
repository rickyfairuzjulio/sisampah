# ♻️ SiSampah - Platform Smart Bank Sampah & Multi-Unit Daur Ulang Eco-System (v1.0.1)

<p align="center">
  <img src="https://img.shields.io/badge/Release-v1.0.1-blue?style=for-the-badge&logo=github" alt="Release v1.0.1" />
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 13" />
  <img src="https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.3" />
  <img src="https://img.shields.io/badge/Security-Hardened-00C853?style=for-the-badge&logo=shieldsdotio&logoColor=white" alt="Security Hardened" />
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/AI_Vision-v2.0-8A2BE2?style=for-the-badge&logo=google-gemini&logoColor=white" alt="AI Powered" />
</p>

**SiSampah** adalah platform digital berbasis Web *production-ready* yang dirancang untuk mengelola dan mengdigitalisasi ekosistem Bank Sampah multi-unit skala daerah/nasional. Platform ini mengintegrasikan kecerdasan buatan (**SiSampah AI Vision v2.0 & Smart Assistant**), verifikasi legalitas Bank Sampah Unit (Pipeline Verifikasi Super Admin), pemetaan GIS (*Leaflet.js*), penjemputan berbasis radius lokasi, hingga sistem pencatatan keuangan transparan (*Wallet Ledger, Midtrans Gateway, & Atomic Balance Locks*).

---

## 🌟 Fitur Utama Platform

### 🏛️ 1. Pendaftaran & Pipeline Verifikasi Bank Sampah (Publik & Super Admin)
- **Pendaftaran Mandiri Unit Bank Sampah**: Formulir publik (`/daftar-bank-sampah`) untuk pendaftaran organisasi bank sampah baru beserta unggah dokumen legalitas (KTP, Surat Legalitas, Rekening, Foto Lokasi).
- **Tracking Status Pendaftaran**: Fitur publik (`/lacak-pendaftaran`) untuk memantau status registrasi dan mengunggah revisi dokumen.
- **Pipeline Verifikasi Super Admin**: Verifikasi bertahap oleh Super Admin (Review Dokumen -> Schedule Meeting Offline/Online -> Record Meeting Result -> Approve & Active / Reject).

### 🤖 2. SiSampah AI Vision v2.0 & Smart Assistant
- **AI Vision Multimodal Waste Analysis**: Pengguna mengunggah foto sampah untuk dianalisis oleh AI mengenai identifikasi material, estimasi berat, kalkulasi nilai rupiah, kualifikasi kebersihan, hingga dampak ekologi.
- **Computer Vision Fallback Engine**: Sistem cadangan analisis citra berbasis aturan lokal jika API key eksternal sedang tidak aktif.
- **Chatbot Asisten Daur Ulang**: Layanan tanya jawab interaktif 24/7 seputar sampah, harga terkini, dan integrasi FAQ.
- **Riwayat Scan AI**: Log histori hasil pemindaian dan deteksi objek.

### 👤 3. Modul Nasabah (Masyarakat)
- **Dashboard Dynamic & Carbon Impact**: Grafik tren setoran bulanan (SQL Driver Agnostic) dan estimasi dampak reduksi CO2, energi, air, & hemat pohon.
- **Order Penjemputan GPS Berbasis Radius**: Pengajuan penjemputan sampah otomatis yang memvalidasi lokasi nasabah terhadap radius operasional Bank Sampah Unit.
- **Katalog & Favorit Harga Sampah**: Monitoring harga sampah real-time per Kg/Gram dengan indikator naik/turun/stabil dan fitur favorit.
- **Dompet Digital & Saldo Atomic**: Mutasi saldo real-time, pengajuan penarikan dana (Withdrawal Hold), pencairan instan, dan Top-Up via Payment Gateway.
- **Sertifikat Dampak Lingkungan**: Generator sertifikat digital atas kontribusi lingkungan hidup.
- **Rating & Ulasan Penjemputan**: Penilaian bintang 1-5 dan ulasan layanan petugas.

### 🚚 4. Modul Petugas (Collector Unit Lapangan)
- **Manifes Penjemputan Scoped per Unit**: Daftar penjemputan sampah yang terisolasi khusus untuk Bank Sampah Unit petugas bersangkutan.
- **Form Penimbangan Digital**: Pencatatan bobot aktual dan *Snapshot Price* (harga terkunci saat penimbangan).
- **Setor Mandiri (Drop-off)**: Penginputan setoran sampah cepat di lokasi Bank Sampah Unit.
- **Bukti Foto Penimbangan**: Dokumentasi foto untuk audit transparansi.

### 👑 5. Modul Admin Bank Sampah Unit & Super Admin
- **Super Admin**: Master data seluruh Bank Sampah Unit, verifikasi organisasi, peta sebaran GIS nasional, audit log aktivitas, dan laporan agregat.
- **Admin Unit**: Manajemen profil unit, pengaturan radius & jam operasional, pengelolaan user unit (Nasabah & Petugas), harga sampah unit, validasi keuangan & pencairan saldo unit, serta top-up kas unit.
- **Audit Trail & Catatan Pelanggaran**: Log transparan mengenai setiap aksi penting (LOGIN, APPROVE, REJECT, WITHDRAWAL, TOPUP, PENIMBANGAN).

---

## 🔒 Security Hardening & Perlindungan Sistem

Aplikasi ini telah melalui audit dan **security hardening menyeluruh**:
1. **Mass-Assignment Protection**: Field sensitif seperti `saldo` dikunci dari `$fillable` dan hanya diubah secara atomic melalui `WalletLedgerService` dengan database row locking (`lockForUpdate`).
2. **Anti-IDOR & Multi-Unit Authorization**: Otorisasi backend ketat yang memastikan Admin Unit hanya dapat mengelola data, user, transaksi, dan penarikan saldo dari `bank_sampah_id` unitnya sendiri.
3. **Security Headers Middleware**: Meng-append HTTP security headers (`X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, `Permissions-Policy`, `HSTS`) secara otomatis.
4. **Rate Limiting**: Pembatasan request (`throttle`) pada endpoint AI Vision, Chatbot, TopUp, Withdrawal, Pickup, dan Registrasi Publik untuk mencegah brute-force/spamming.
5. **Midtrans Webhook Security**: Verifikasi SHA512 signature, validasi `gross_amount` server-side, dan kunci *Idempotency* untuk mencegah penambahan saldo berulang.
6. **Cross-Database Driver Support**: Query SQL yang kompatibel secara otomatis di lingkungan **SQLite**, **MySQL/MariaDB**, maupun **PostgreSQL**.

---

## 🛠️ Tech Stack & Arsitektur

- **Backend Framework**: [Laravel 13](https://laravel.com) (PHP 8.3+)
- **Frontend Layer**: Blade Components, Tailwind CSS v4, Alpine.js
- **Database**: MySQL / MariaDB / SQLite / PostgreSQL
- **Security & Authorization**: Spatie Laravel-Permission & Custom Policy Guards
- **Map & GIS**: Leaflet.js & OpenStreetMap API
- **Payment Gateway**: Midtrans Snap & Core API Integration
- **AI Integration**: Gemini 2.0 Flash / Multimodal Vision API Integration
- **Asset Bundler**: Vite v8

---

## 🚀 Panduan Instalasi (Local Development)

### Prasyarat Sistem:
- PHP >= 8.3
- Composer >= 2.x
- Node.js >= 18.x & NPM
- SQLite / MySQL / PostgreSQL

### Langkah Instalasi:

1. **Clone Repositori & Masuk ke Directory Project**:
   ```bash
   git clone https://github.com/rickyfairuzjulio/sisampah.git
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

4. **Jalankan Migration & Database Seeder**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Buat Symlink Storage**:
   ```bash
   php artisan storage:link
   ```

6. **Jalankan Automated Test Suite (Opsional)**:
   ```bash
   php artisan test
   ```

7. **Jalankan Server Development**:
   ```bash
   # Jalankan Vite & Artisan Serve secara bersamaan
   npm run dev
   php artisan serve
   ```
   *Aplikasi akan berjalan di `http://127.0.0.1:8000`*

---

## 🔑 Kredensial Akun Default (Seeder)

Setelah menjalankan `php artisan db:seed`, Anda dapat menggunakan akun demo berikut (Password: `password`):

| Role | Email | Unit Bank Sampah | Akses Utama |
|---|---|---|---|
| **Super Admin** | `superadmin@sisampah.id` | Pusat (Nasional) | Verifikasi Bank Sampah, Master Data, Peta GIS, Audit Log |
| **Admin Unit (Melati)** | `admin@sisampah.id` | Bank Sampah Melati Bersih | Validasi Keuangan Unit, User Unit, Harga Unit, Kas Unit |
| **Admin Unit (Tampingan)** | `admin.tampingan@sisampah.id` | Bank Sampah Tampingan Asri | Validasi Keuangan Unit, User Unit, Harga Unit, Kas Unit |
| **Petugas** | `petugas1@sisampah.local` | Bank Sampah Unit | Dashboard Manifes Unit, Input Timbangan, Setor Mandiri |
| **Nasabah** | `nasabah1@sisampah.local` | Bank Sampah Unit | Request Pickup Radius, Dompet Saldo, TopUp, AI Vision |

---

## 🗺️ Peta Routing Utama

- **Publik**:
  - `/` - Landing Page Utama
  - `/daftar-bank-sampah` - Pendaftaran Organisasi Bank Sampah
  - `/lacak-pendaftaran` - Tracking & Reupload Dokumen Registrasi
  - `/edukasi` - Portal Artikel & Literasi Daur Ulang
- **Nasabah (`/nasabah/*`)**:
  - `/nasabah/dashboard` - Dashboard Saldo, Impact, & Trend
  - `/nasabah/jemput-sampah` - Form Pickup GPS (Validasi Radius)
  - `/nasabah/dompet` - Ledger Saldo & Form Penarikan (Withdrawal)
  - `/nasabah/topup` - Form Top-Up Midtrans Gateway
  - `/nasabah/sertifikat` - Generator Sertifikat Kontribusi Lingkungan
- **Petugas (`/petugas/*`)**:
  - `/petugas/dashboard-manifes` - Antrean Manifes Penjemputan Unit
  - `/petugas/input-timbangan/{user_id}` - Form Timbangan Digital
  - `/petugas/setor-mandiri` - Form Drop-off Sampah Langsung
- **Admin & Super Admin (`/admin/*`)**:
  - `/admin/dashboard` - Executive Overview & Analytics
  - `/admin/verifikasi-bank-sampah` - Pipeline Verifikasi Pendaftaran (Super Admin)
  - `/admin/master-bank-sampah` - Pengelolaan Master Unit (Super Admin)
  - `/admin/peta-sebaran` - Peta GIS Sebaran Bank Sampah
  - `/admin/validasi-keuangan` - Financial Validation & Withdrawal Approval
  - `/admin/trash-price` - Katalog & Histori Harga Sampah
  - `/admin/pelanggaran` - Audit Log Aktivitas System

---

## 🧪 Status Automated Test Suite

```text
  Tests:    27 passed (66 assertions)
  Duration: 3.03s
  Status:   100% PASS (0 Failure, 0 Error)
```

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

<p align="center">
  <b>SiSampah v1.0.1</b> — <i>Solusi Cerdas Pengolahan Sampah Demi Masa Depan Berkelanjutan 🌱</i>
</p>
