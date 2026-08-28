<?php

namespace Database\Seeders;

use App\Models\BankSampah;
use App\Models\MaterialLedger;
use App\Models\OfftakerSale;
use App\Models\TrashCategory;
use App\Models\UpcyclingProduct;
use App\Models\User;
use App\Models\Violation;
use App\Models\WarehouseStock;
use Illuminate\Database\Seeder;

class AdminModuleSeeder extends Seeder
{
    public function run(): void
    {
        $bankSampahs = BankSampah::all();
        $adminUser = User::role('admin')->first() ?? User::first();
        $petugasUser = User::role('petugas')->first();
        $nasabahUser = User::role('nasabah')->first();

        foreach ($bankSampahs as $bs) {
            $categories = TrashCategory::where('bank_sampah_id', $bs->id)->get();
            if ($categories->isEmpty()) {
                $categories = TrashCategory::all();
            }

            // 1. Inisialisasi Stok Gudang per Kategori
            foreach ($categories as $cat) {
                $stockWeights = [
                    'Plastik' => 1250.0,
                    'Kertas' => 980.0,
                    'Logam' => 320.0,
                    'Minyak' => 150.0,
                    'Organik' => 450.0,
                    'Kaca' => 200.0,
                    'Elektronik' => 80.0,
                ];

                $matchedWeight = 100.0;
                foreach ($stockWeights as $key => $w) {
                    if (stripos($cat->nama, $key) !== false || stripos($cat->kategori, $key) !== false) {
                        $matchedWeight = $w;
                        break;
                    }
                }

                WarehouseStock::updateOrCreate(
                    [
                        'bank_sampah_id' => $bs->id,
                        'trash_category_id' => $cat->id,
                    ],
                    [
                        'stok_kg' => $matchedWeight,
                        'kapasitas_maks_kg' => 5000,
                        'lokasi_rak' => 'Sektor Gudang ' . chr(65 + ($cat->id % 4)),
                        'status_kondisi' => 'Siap Angkut Pengepul',
                    ]
                );
            }

            // 2. Produk Daur Ulang (Upcycling)
            $upcyclingItems = [
                [
                    'nama_produk' => 'Tas Belanja Anyam Sachet',
                    'deskripsi' => 'Tas belanja tahan air modis dibuat dari anyaman 100% limbah sachet plastik kopi & detergen.',
                    'bahan_baku_keterangan' => '100 Kg Plastik Sachet Kopi',
                    'jumlah_bahan_kg' => 100,
                    'stok_qty' => 50,
                    'satuan' => 'Pcs',
                    'harga_satuan' => 25000,
                    'total_valuasi' => 1250000,
                    'pengrajin' => 'Kader PKK RW 02',
                    'status' => 'tersedia',
                ],
                [
                    'nama_produk' => 'Pupuk Kompos Organik Super',
                    'deskripsi' => 'Pupuk organik hayati hasil biokonversi sampah sayur, buah & daun kering dengan aktivator EM4.',
                    'bahan_baku_keterangan' => '350 Kg Daun & Sisa Makanan',
                    'jumlah_bahan_kg' => 350,
                    'stok_qty' => 200,
                    'satuan' => 'Kg',
                    'harga_satuan' => 5000,
                    'total_valuasi' => 1000000,
                    'pengrajin' => 'Tim Kebun Hijau Unit',
                    'status' => 'tersedia',
                ],
                [
                    'nama_produk' => 'Lilin Aromaterapi Jelantah',
                    'deskripsi' => 'Lilin ramah lingkungan dengan minyak atsiri lavender dari pemurnian minyak jelantah bekas dapur.',
                    'bahan_baku_keterangan' => '50 Liter Minyak Jelantah',
                    'jumlah_bahan_kg' => 50,
                    'stok_qty' => 80,
                    'satuan' => 'Pcs',
                    'harga_satuan' => 15000,
                    'total_valuasi' => 1200000,
                    'pengrajin' => 'Kelompok Pemuda Karang Taruna',
                    'status' => 'tersedia',
                ],
                [
                    'nama_produk' => 'Pakan Maggot BSF Kering',
                    'deskripsi' => 'Larva lalat tentara hitam berprotein tinggi 45% untuk pakan unggas & ikan hias dari sampah organik.',
                    'bahan_baku_keterangan' => '400 Kg Buah & Sayur Busuk',
                    'jumlah_bahan_kg' => 400,
                    'stok_qty' => 120,
                    'satuan' => 'Kg',
                    'harga_satuan' => 12000,
                    'total_valuasi' => 1440000,
                    'pengrajin' => 'Unit Biokonversi Melati',
                    'status' => 'tersedia',
                ],
            ];

            foreach ($upcyclingItems as $item) {
                UpcyclingProduct::updateOrCreate(
                    [
                        'bank_sampah_id' => $bs->id,
                        'nama_produk' => $item['nama_produk'],
                    ],
                    array_merge($item, [
                        'trash_category_id' => $categories->first()?->id,
                    ])
                );
            }

            // 3. Penjualan ke Pengepul (Offtaker Sales)
            $sales = [
                [
                    'nama_pembeli' => 'PT Daur Ulang Nusantara Jaya',
                    'berat_kg' => 2500,
                    'harga_per_kg' => 4500,
                    'total_pendapatan' => 11250000,
                    'catatan' => 'Muatan truk fuso 1 ritase baling plastik PET bening & campur',
                    'status' => 'selesai',
                    'created_at' => now()->subDays(4),
                ],
                [
                    'nama_pembeli' => 'CV Logam Perkasa Sejahtera',
                    'berat_kg' => 800,
                    'harga_per_kg' => 9000,
                    'total_pendapatan' => 7200000,
                    'catatan' => 'Besi rongsok, seng & kaleng minuman aluminium press',
                    'status' => 'selesai',
                    'created_at' => now()->subDays(8),
                ],
                [
                    'nama_pembeli' => 'PT Bio Energi Hijau Nusantara',
                    'berat_kg' => 864,
                    'harga_per_kg' => 7000,
                    'total_pendapatan' => 6050000,
                    'catatan' => 'Pengiriman jerigen minyak jelantah (UCO) bahan baku biofuel',
                    'status' => 'selesai',
                    'created_at' => now()->subDays(12),
                ],
            ];

            foreach ($sales as $s) {
                OfftakerSale::create(array_merge($s, [
                    'bank_sampah_id' => $bs->id,
                    'trash_category_id' => $categories->first()?->id ?? 1,
                    'admin_id' => $adminUser?->id,
                ]));
            }

            // 4. Buku Besar Mutasi Material (Material Ledgers)
            $ledgers = [
                [
                    'tipe' => 'sale',
                    'tipe_label' => 'Penjualan Pengepul',
                    'kategori_nama' => 'Plastik PET & Campur',
                    'berat_kg' => 2500,
                    'nilai_rp' => 11250000,
                    'output_desc' => '+Rp 11.250.000',
                    'pihak_terkait' => 'PT Daur Ulang Nusantara',
                    'status' => 'Selesai (Kas Masuk)',
                    'created_at' => now()->subDays(4),
                ],
                [
                    'tipe' => 'upcycling',
                    'tipe_label' => 'Alih Karya Upcycling',
                    'kategori_nama' => 'Sampah Organik',
                    'berat_kg' => 300,
                    'nilai_rp' => 0,
                    'output_desc' => '150 Kg Kompos',
                    'pihak_terkait' => 'Kader Kebun PKK Melati',
                    'status' => 'Sedang Diproses',
                    'created_at' => now()->subDays(5),
                ],
                [
                    'tipe' => 'inbound',
                    'tipe_label' => 'Setoran Jemput Warga',
                    'kategori_nama' => 'Kardus & Kertas',
                    'berat_kg' => 15.5,
                    'nilai_rp' => 46500,
                    'output_desc' => 'Rp 46.500',
                    'pihak_terkait' => 'Dewi Lestari (RT 01)',
                    'status' => 'Tersimpan Gudang',
                    'created_at' => now()->subDays(5),
                ],
                [
                    'tipe' => 'inbound',
                    'tipe_label' => 'Setor Mandiri Teller Pos',
                    'kategori_nama' => 'Plastik PET & Campur',
                    'berat_kg' => 8.2,
                    'nilai_rp' => 24600,
                    'output_desc' => 'Rp 24.600',
                    'pihak_terkait' => 'Ahmad Fauzi (RT 02)',
                    'status' => 'Tersimpan Gudang',
                    'created_at' => now()->subDays(6),
                ],
                [
                    'tipe' => 'upcycling',
                    'tipe_label' => 'Alih Karya Upcycling',
                    'kategori_nama' => 'Plastik Sachet Residu',
                    'berat_kg' => 100,
                    'nilai_rp' => 0,
                    'output_desc' => '50 pcs Tas Belanja',
                    'pihak_terkait' => 'Kelompok Pengrajin RW 02',
                    'status' => 'Siap Jual',
                    'created_at' => now()->subDays(7),
                ],
                [
                    'tipe' => 'sale',
                    'tipe_label' => 'Penjualan Pengepul',
                    'kategori_nama' => 'Besi, Logam & Kaleng',
                    'berat_kg' => 800,
                    'nilai_rp' => 7200000,
                    'output_desc' => '+Rp 7.200.000',
                    'pihak_terkait' => 'CV Logam Perkasa Sejahtera',
                    'status' => 'Selesai (Kas Masuk)',
                    'created_at' => now()->subDays(8),
                ],
            ];

            foreach ($ledgers as $l) {
                MaterialLedger::create(array_merge($l, [
                    'bank_sampah_id' => $bs->id,
                    'trash_category_id' => $categories->first()?->id,
                ]));
            }

            // 5. Kasus Pelanggaran & Audit Trail
            $violations = [
                [
                    'user_id' => $nasabahUser?->id,
                    'reporter_id' => $petugasUser?->id ?? $adminUser?->id,
                    'user_name' => 'Budi Santoso',
                    'user_role' => 'Warga Nasabah (RT 02)',
                    'phone' => '081234567890',
                    'tipe' => 'unsegregated',
                    'tipe_label' => 'Sampah Tidak Terpilah',
                    'deskripsi' => 'Setoran kantong plastik tercampur sisa makanan basah & residu popok bekas saat penjemputan armada.',
                    'sanksi' => 'Teguran Lisan 1 + Pengurangan 50 Poin Reward',
                    'poin_penalti' => 50,
                    'status' => 'pending',
                    'created_at' => now()->subHours(8),
                ],
                [
                    'user_id' => $petugasUser?->id,
                    'reporter_id' => $adminUser?->id,
                    'user_name' => 'Armada Truk Unit 02 (Joko)',
                    'user_role' => 'Petugas Lapangan',
                    'phone' => '081234567891',
                    'tipe' => 'suspicious',
                    'tipe_label' => 'Transaksi Anomali (>100kg)',
                    'deskripsi' => 'Penimbangan kardus seberat 145.0 Kg dalam 1 transaksi setoran warga RT 04 yang perlu dicocokkan nota fisiknya.',
                    'sanksi' => 'Verifikasi Nota Timbang Fisik Pos',
                    'poin_penalti' => 0,
                    'status' => 'pending',
                    'created_at' => now()->subDay(),
                ],
                [
                    'user_id' => $nasabahUser?->id,
                    'reporter_id' => $petugasUser?->id ?? $adminUser?->id,
                    'user_name' => 'Dewi Lestari',
                    'user_role' => 'Warga Nasabah (RT 01)',
                    'phone' => '081298765432',
                    'tipe' => 'missed_pickup',
                    'tipe_label' => 'Ketidakhadiran Jadwal Jemput',
                    'deskripsi' => 'Petugas tiba di lokasi RT 01 sesuai pesanan namun rumah terkunci & sampah belum disiapkan.',
                    'sanksi' => 'Jadwal Ulang Penjemputan Otomatis',
                    'poin_penalti' => 0,
                    'status' => 'resolved',
                    'catatan_penyelesaian' => 'Telah dikonfirmasi warga bersangkutan sedang keluar mendadak, jadwal jemput disetujui untuk diulang esok hari.',
                    'resolved_at' => now()->subDays(2),
                    'created_at' => now()->subDays(3),
                ],
                [
                    'user_id' => $nasabahUser?->id,
                    'reporter_id' => $petugasUser?->id ?? $adminUser?->id,
                    'user_name' => 'Ahmad Fauzi',
                    'user_role' => 'Warga Nasabah (RT 03)',
                    'phone' => '081567890123',
                    'tipe' => 'unsegregated',
                    'tipe_label' => 'Sampah Tercampur Logam Tajam',
                    'deskripsi' => 'Ditemukan pecahan kaca & paku tanpa pembungkus pelindung di dalam kantong kardus yang membahayakan kurir.',
                    'sanksi' => 'Surat Peringatan 1 + Edukasi Keselamatan Petugas',
                    'poin_penalti' => 25,
                    'status' => 'resolved',
                    'catatan_penyelesaian' => 'Nasabah telah meminta maaf dan diberikan kotak pelindung pecahan kaca khusus.',
                    'resolved_at' => now()->subDays(4),
                    'created_at' => now()->subDays(5),
                ],
            ];

            foreach ($violations as $v) {
                Violation::create(array_merge($v, [
                    'bank_sampah_id' => $bs->id,
                ]));
            }
        }
    }
}
