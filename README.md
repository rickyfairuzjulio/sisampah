# ♻️ SiSampah - Platform Smart Bank Sampah & Multi-Unit Daur Ulang Eco-System (v1.1.0)

<p align="center">
  <img src="https://img.shields.io/badge/Release-v1.1.0-blue?style=for-the-badge&logo=github" alt="Release v1.1.0" />
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/Inertia.js-React_SPA-9553E9?style=for-the-badge&logo=inertia&logoColor=white" alt="Inertia.js React SPA" />
  <img src="https://img.shields.io/badge/React-19.x-61DAFB?style=for-the-badge&logo=react&logoColor=black" alt="React 19" />
  <img src="https://img.shields.io/badge/TailwindCSS-v4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/Dark_Mode-Emerald_Midnight-059669?style=for-the-badge&logo=moon&logoColor=white" alt="Emerald Midnight" />
  <img src="https://img.shields.io/badge/AI_Vision-Gemini_2.0-8A2BE2?style=for-the-badge&logo=google-gemini&logoColor=white" alt="AI Powered" />
</p>

**SiSampah** adalah platform digital berbasis Web *Single Page Application (SPA)* *production-ready* yang dibangun di atas arsitektur modern **Laravel + Inertia.js + React**. Platform ini mengintegrasikan kecerdasan buatan (**SiSampah AI Vision & Smart Assistant berbasis Gemini 2.0 Flash**), sistem tema adaptif (**Emerald Midnight Dark Mode**), verifikasi legalitas Bank Sampah Unit (Pipeline Verifikasi Super Admin), pemetaan GIS (*Leaflet.js*), penjemputan berbasis radius lokasi, hingga sistem pencatatan keuangan transparan (*Wallet Ledger, Midtrans Gateway, & Atomic Balance Locks*).

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

- **Backend Framework**: [Laravel 12](https://laravel.com) (PHP 8.2+)
- **SPA Layer**: [Inertia.js](https://inertiajs.com) (Server-driven Single Page Application)
- **Frontend UI Library**: [React 19](https://react.dev) + [Lucide React](https://lucide.dev)
- **Styling & Design System**: [Tailwind CSS v4](https://tailwindcss.com) + *Emerald Midnight Dark Mode*
- **Database**: MySQL / MariaDB / SQLite / PostgreSQL
- **Security & Authorization**: Spatie Laravel-Permission & Custom Multi-Tenant Policy Guards
- **Map & GIS**: Leaflet.js & OpenStreetMap API
- **Payment Gateway**: Midtrans Snap & Core API Integration
- **AI Integration**: Google Gemini 2.0 Flash / Multimodal Vision API Integration
- **Asset Bundler**: Vite (Rolldown Compiler)

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

## 🗺️ Peta Routing Utama (Inertia SPA)

- **Publik & Autentikasi**:
  - `/` - Landing Page Utama
  - `/login` - Halaman Masuk Akun
  - `/register` - Halaman Pendaftaran Nasabah Baru
  - `/daftar-bank-sampah` - Pendaftaran Organisasi Bank Sampah
  - `/lacak-pendaftaran` - Tracking & Reupload Dokumen Registrasi
- **Nasabah (`/nasabah/*` & `/profile`)**:
  - `/nasabah/dashboard` - Dashboard Interaktif, Gamifikasi Level, & Jejak Karbon
  - `/nasabah/katalog-harga` - Katalog Harga Komoditas Sampah Realtime
  - `/nasabah/jemput-sampah` - Form Penjemputan Sampah GPS (Radius Scoped)
  - `/nasabah/dompet` - Dompet SiSampay & Form Penarikan Saldo Kas
  - `/nasabah/sertifikat` - Generator Sertifikat Kontribusi Ekologis
  - `/nasabah/edukasi` - Portal Literasi & Panduan Pemilahan Sampah
  - `/profile` - Pengaturan Akun & Profil Nasabah
- **Petugas Lapangan (`/petugas/*`)**:
  - `/petugas/dashboard` - Manifes Penjemputan & Antrean Unit
  - `/petugas/timbangan/{id?}` - Input Timbangan Digital & Bukti Foto
  - `/petugas/setor-mandiri` - Input Setor Mandiri (Teller Pos)
  - `/petugas/profil` - Pengaturan Akun & Rekap Kinerja Petugas
- **Admin Bank Sampah Unit (`/admin/*`)**:
  - `/admin/dashboard` - Pusat Kendali Operasional Unit
  - `/admin/inventaris-gudang` - Inventaris Stok Fisik & Penjualan Pengepul
  - `/admin/keuangan` - Validasi Payout & Approval Penarikan Saldo
  - `/admin/harga-sampah` - Pengaturan Katalog Harga Sampah Unit
  - `/admin/manajemen-user` - Pengelolaan Nasabah & Petugas Unit
  - `/admin/pelanggaran-audit` - Pencatatan Pelanggaran & Log Audit
  - `/admin/laporan-unit` - Laporan Rekapitulasi Neraca Sampah Unit
- **Super Admin Platform Nasional (`/super-admin/*`)**:
  - `/super-admin/dashboard` - Agregator Bank Sampah Nasional
  - `/super-admin/verifikasi-bank-sampah` - Pipeline Verifikasi Legalitas Unit
  - `/super-admin/master-bank-sampah` - Manajemen Master Bank Sampah se-Indonesia
  - `/super-admin/peta-sebaran` - Peta GIS Sebaran Bank Sampah Nasional
  - `/super-admin/artikel-nasional` - Publikasi Artikel & Literasi Nasional
  - `/super-admin/konfigurasi-wilayah` - Konfigurasi Wilayah Binaan & Kuota
  - `/super-admin/audit-logs` - Log Audit Keamanan & Transaksi Global

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
