# SiSampah - Platform Bank Sampah Skala Lokal RT/RW/Desa

SiSampah adalah aplikasi web production-ready yang dirancang untuk mengelola Bank Sampah di tingkat lokal (RT/RW/Desa). Platform ini memfasilitasi pengumpulan sampah, perhitungan nilai ekonomi, dan pembayaran kepada masyarakat dengan sistem gamifikasi untuk meningkatkan kesadaran lingkungan.

## Fitur Utama

### Untuk Nasabah
- Dashboard dengan informasi saldo dan harga sampah terkini
- Penjadwalan penjemputan sampah dengan deteksi GPS
- Tracking riwayat transaksi dan mutasi saldo
- Pengajuan penarikan dana (tunai/transfer)
- Sistem poin dan papan peringkat komunitas
- Akses ke pusat edukasi daur ulang

### Untuk Petugas
- Dashboard manifes penjemputan dengan daftar pending
- Input data timbangan dengan snapshot harga
- Setoran mandiri dengan pencarian nasabah
- Foto bukti transaksi untuk dokumentasi
- Otomatis penambahan saldo dan poin nasabah

### Untuk Admin
- Dashboard dengan statistik komprehensif
- Manajemen harga sampah per kategori
- Validasi penarikan dana dengan upload resi
- Filter laporan berdasarkan RT/RW dan rentang tanggal
- Ekspor laporan ke format CSV
- Manajemen artikel edukasi
- Visualisasi perbandingan sampah antar RT

## Tech Stack

- **Framework**: Laravel 11 (PHP 8.2+)
- **Frontend**: Blade Components, Tailwind CSS, Alpine.js
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Breeze (Session-based)
- **Authorization**: Spatie/Laravel-Permission (3 Roles: Admin, Petugas, Nasabah)
- **Build Tool**: Vite

## Instalasi

### Prerequisites
- PHP 8.2+
- MySQL 8.0+
- Node.js 18+
- Composer

### Setup Cepat dengan Makefile

```bash
cd sisampah
make setup
```

### Setup Manual

```bash
cp .env.example .env
php artisan key:generate
composer install
npm install

php artisan migrate:fresh --seed
npm run build
php artisan optimize
```

## Kredensial Default

Setelah menjalankan seeder:

- **Admin**: admin@sisampah.local / password
- **Petugas**: petugas1@sisampah.local / password
- **Nasabah**: nasabah1@sisampah.local / password

## Struktur Routing

### Public Routes
- `/` - Landing page
- `/edukasi` - Daftar artikel edukasi
- `/edukasi/{slug}` - Detail artikel

### Nasabah Routes (`/nasabah/`)
- `/dashboard` - Dashboard dengan saldo
- `/jemput-sampah` - Form penjemputan GPS
- `/dompet` - Mutasi dan penarikan
- `/edukasi` - Artikel edukasi

### Petugas Routes (`/petugas/`)
- `/dashboard-manifes` - Daftar penjemputan
- `/input-timbangan/{user_id}` - Form timbangan
- `/setor-mandiri` - Form setoran mandiri

### Admin Routes (`/admin/`)
- `/dashboard` - Dashboard statistik
- `/harga-sampah` - Manajemen harga
- `/validasi-keuangan` - Persetujuan penarikan
- `/laporan` - Filter dan ekspor laporan
- `/articles` - Manajemen artikel

## Fitur Keamanan

- Rate limiting pada autentikasi
- CSRF protection pada semua form
- Input sanitization untuk XSS prevention
- Role-based access control
- DB transactions untuk konsistensi keuangan
- Snapshot price untuk integritas historis

## Fitur Bisnis

### Snapshot Price
Harga per kg disimpan saat transaksi untuk mengunci nilai historis.

### Gamifikasi
- 1 Kg organik = 10 poin
- 1 Kg anorganik = 20-25 poin
- Papan peringkat Top 5 Pahlawan Lingkungan

### Validasi Penjemputan
- Minimum 5 Kg untuk penjemputan
- Otomatis penambahan saldo
- Foto bukti untuk dokumentasi

## Perintah Makefile

```bash
make help       # Tampilkan bantuan
make install    # Install dependencies
make setup      # Setup lengkap
make migrate    # Jalankan migrations
make seed       # Seed database
make build      # Build frontend
make optimize   # Optimize production
make clean      # Bersihkan cache
make serve      # Start dev server
```

## Deployment

1. Set `APP_ENV=production` di .env
2. Set `APP_DEBUG=false`
3. Run: `php artisan migrate`
4. Run: `php artisan db:seed`
5. Run: `npm run build`
6. Run: `php artisan optimize`
7. Setup web server dengan document root ke `public/`

## Lisensi

MIT License

---

**Dibuat untuk Kompetisi Bank Sampah Skala Nasional**
