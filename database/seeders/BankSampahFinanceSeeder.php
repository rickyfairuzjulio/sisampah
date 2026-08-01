<?php

namespace Database\Seeders;

use App\Models\BankSampah;
use App\Models\Leaderboard;
use App\Models\Transaction;
use App\Models\TrashCategory;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BankSampahFinanceSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure Trash Categories Exist
        if (TrashCategory::count() === 0) {
            $this->call(TrashCategorySeeder::class);
        }
        $categories = TrashCategory::all();

        // 2. Create 5 Realistic Bank Sampah Units
        $unitsData = [
            [
                'kode_bank' => 'BS-001',
                'nama' => 'Bank Sampah Melati Bersih',
                'slug' => 'bank-sampah-melati-bersih',
                'deskripsi' => 'Unit pusat pengelolaan daur ulang sampah organik dan anorganik wilayah Bandung Tengah.',
                'email' => 'melati.bersih@sisampah.id',
                'telepon' => '081234567890',
                'whatsapp' => '6281234567890',
                'alamat' => 'Jl. Ir. H. Juanda No. 123, Dago, Kec. Coblong, Kota Bandung, Jawa Barat',
                'provinsi' => 'Jawa Barat',
                'kabupaten' => 'Kota Bandung',
                'kecamatan' => 'Coblong',
                'desa' => 'Dago',
                'kode_pos' => '40135',
                'latitude' => -6.8915,
                'longitude' => 107.6107,
                'jam_buka' => '08:00',
                'jam_tutup' => '16:00',
                'hari_operasional' => 'Senin - Sabtu',
                'radius_layanan' => 2000,
                'status' => 'aktif',
            ],
            [
                'kode_bank' => 'BS-002',
                'nama' => 'Bank Sampah Tampingan Asri',
                'slug' => 'bank-sampah-tampingan-asri',
                'deskripsi' => 'Spesialis pemilahan plastik PET, HDPE, dan minyak jelantah terpadu.',
                'email' => 'tampingan.asri@sisampah.id',
                'telepon' => '081298765432',
                'whatsapp' => '6281298765432',
                'alamat' => 'Jl. Tampingan Utama No. 45, Kec. Boja, Kab. Kendal, Jawa Tengah',
                'provinsi' => 'Jawa Tengah',
                'kabupaten' => 'Kendal',
                'kecamatan' => 'Boja',
                'desa' => 'Tampingan',
                'kode_pos' => '51381',
                'latitude' => -7.0911,
                'longitude' => 110.2711,
                'jam_buka' => '08:00',
                'jam_tutup' => '16:00',
                'hari_operasional' => 'Senin - Sabtu',
                'radius_layanan' => 2000,
                'status' => 'aktif',
            ],
            [
                'kode_bank' => 'BS-003',
                'nama' => 'Bank Sampah Kenanga Utama',
                'slug' => 'bank-sampah-kenanga-utama',
                'deskripsi' => 'Pusat daur ulang sampah kertas, karton, dan e-waste rumah tangga.',
                'email' => 'kenanga.utama@sisampah.id',
                'telepon' => '081311223344',
                'whatsapp' => '6281311223344',
                'alamat' => 'Jl. Soekarno-Hatta No. 450, Batununggal, Kota Bandung, Jawa Barat',
                'provinsi' => 'Jawa Barat',
                'kabupaten' => 'Kota Bandung',
                'kecamatan' => 'Batununggal',
                'desa' => 'Mengger',
                'kode_pos' => '40267',
                'latitude' => -6.9450,
                'longitude' => 107.6320,
                'jam_buka' => '09:00',
                'jam_tutup' => '17:00',
                'hari_operasional' => 'Senin - Sabtu',
                'radius_layanan' => 2000,
                'status' => 'aktif',
            ],
            [
                'kode_bank' => 'BS-004',
                'nama' => 'Bank Sampah Surabaya Eco',
                'slug' => 'bank-sampah-surabaya-eco',
                'deskripsi' => 'Unit ramah lingkungan pengelolaan daur ulang anorganik Kota Surabaya.',
                'email' => 'surabaya.eco@sisampah.id',
                'telepon' => '081455667788',
                'whatsapp' => '6281455667788',
                'alamat' => 'Jl. Raya Darmo No. 12, Tegalsari, Kota Surabaya, Jawa Timur',
                'provinsi' => 'Jawa Timur',
                'kabupaten' => 'Kota Surabaya',
                'kecamatan' => 'Tegalsari',
                'desa' => 'Dr. Soetomo',
                'kode_pos' => '60264',
                'latitude' => -7.2891,
                'longitude' => 112.7388,
                'jam_buka' => '08:00',
                'jam_tutup' => '15:30',
                'hari_operasional' => 'Senin - Jumat',
                'radius_layanan' => 2000,
                'status' => 'aktif',
            ],
            [
                'kode_bank' => 'BS-005',
                'nama' => 'Bank Sampah Bali Asri',
                'slug' => 'bank-sampah-bali-asri',
                'deskripsi' => 'Pengelolaan limbah botol kaca, aluminium, dan plastik wilayah Denpasar.',
                'email' => 'bali.asri@sisampah.id',
                'telepon' => '081599887766',
                'whatsapp' => '6281599887766',
                'alamat' => 'Jl. Teuku Umar No. 88, Denpasar Barat, Kota Denpasar, Bali',
                'provinsi' => 'Bali',
                'kabupaten' => 'Kota Denpasar',
                'kecamatan' => 'Denpasar Barat',
                'desa' => 'Dauh Puri',
                'kode_pos' => '80113',
                'latitude' => -8.6705,
                'longitude' => 115.2126,
                'jam_buka' => '08:30',
                'jam_tutup' => '16:30',
                'hari_operasional' => 'Senin - Sabtu',
                'radius_layanan' => 2000,
                'status' => 'aktif',
            ],
        ];

        $createdUnits = [];
        foreach ($unitsData as $data) {
            $createdUnits[] = BankSampah::updateOrCreate(['kode_bank' => $data['kode_bank']], $data);
        }

        // 3. Create Nasabah & Petugas for each unit
        foreach ($createdUnits as $unit) {
            // Petugas
            $petugas = User::firstOrCreate(
                ['email' => 'petugas.' . Str::slug($unit->kode_bank) . '@sisampah.id'],
                [
                    'name' => 'Petugas ' . $unit->nama,
                    'password' => Hash::make('password'),
                    'saldo' => 0,
                    'bank_sampah_id' => $unit->id,
                    'rt' => '01',
                    'rw' => '02',
                    'alamat_lengkap' => $unit->alamat,
                    'nomor_telepon' => $unit->telepon,
                ]
            );
            $petugas->syncRoles(['petugas']);

            // 3 Nasabah per Unit
            for ($n = 1; $n <= 3; $n++) {
                $nasabahEmail = 'nasabah.' . Str::slug($unit->kode_bank) . '.' . $n . '@sisampah.id';
                $nasabahName = 'Nasabah ' . $n . ' ' . $unit->nama;

                $nasabah = User::firstOrCreate(
                    ['email' => $nasabahEmail],
                    [
                        'name' => $nasabahName,
                        'password' => Hash::make('password'),
                        'saldo' => rand(150000, 850000),
                        'bank_sampah_id' => $unit->id,
                        'rt' => '0' . rand(1, 5),
                        'rw' => '0' . rand(1, 8),
                        'alamat_lengkap' => 'Alamat Warga No. ' . rand(1, 100) . ', ' . $unit->kecamatan,
                        'nomor_telepon' => '08' . rand(100000000, 999999999),
                    ]
                );
                $nasabah->syncRoles(['nasabah']);

                // Generate Setoran Transactions
                for ($t = 1; $t <= rand(3, 6); $t++) {
                    $cat = $categories->random();
                    $berat = rand(15, 120) / 10; // 1.5 - 12.0 kg
                    $harga = $cat->harga_per_kg;
                    $total = $berat * $harga;

                    Transaction::create([
                        'user_id' => $nasabah->id,
                        'petugas_id' => $petugas->id,
                        'trash_category_id' => $cat->id,
                        'berat_kg' => $berat,
                        'harga_per_kg' => $harga,
                        'total_rp' => $total,
                        'tipe_setoran' => ($t % 2 == 0) ? 'jemput' : 'mandiri',
                        'status' => 'selesai',
                        'koordinat_lat' => $unit->latitude + (rand(-50, 50) / 10000),
                        'koordinat_lng' => $unit->longitude + (rand(-50, 50) / 10000),
                        'catatan' => 'Setoran daur ulang rutin ' . $cat->nama,
                        'created_at' => now()->subDays(rand(1, 45)),
                        'updated_at' => now()->subDays(rand(0, 40)),
                    ]);
                }

                // Generate Financial Withdrawals (Keuangan)
                $metodes = ['gopay', 'ovo', 'dana', 'tunai', 'bca', 'mandiri'];
                $statuses = ['pending', 'disetujui', 'disetujui', 'ditolak'];

                foreach ($statuses as $stIdx => $st) {
                    $nominal = rand(2, 10) * 25000; // Rp 50.000 - Rp 250.000
                    $metode = $metodes[array_rand($metodes)];

                    Withdrawal::create([
                        'user_id' => $nasabah->id,
                        'nominal' => $nominal,
                        'metode' => $metode,
                        'rekening_tujuan' => $metode === 'tunai' ? '-' : '08' . rand(100000000, 999999999),
                        'nama_penerima' => $nasabah->name,
                        'status' => $st,
                        'catatan_admin' => $st === 'ditolak' ? 'Nomor rekening/e-wallet tidak terdaftar.' : ($st === 'disetujui' ? 'Transfer berhasil via E-Wallet.' : null),
                        'created_at' => now()->subDays(rand(1, 20)),
                        'updated_at' => now()->subDays(rand(0, 15)),
                    ]);
                }

                // Update Leaderboard
                $selesaiT = Transaction::where('user_id', $nasabah->id)->where('status', 'selesai')->get();
                Leaderboard::updateOrCreate(
                    ['user_id' => $nasabah->id],
                    [
                        'total_poin_lingkungan' => $selesaiT->sum('total_rp'),
                        'total_berat_kg' => $selesaiT->sum('berat_kg'),
                        'jumlah_transaksi' => $selesaiT->count(),
                    ]
                );
            }
        }
    }
}
