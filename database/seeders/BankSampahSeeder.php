<?php

namespace Database\Seeders;

use App\Models\BankSampah;
use Illuminate\Database\Seeder;

class BankSampahSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            [
                'kode_bank' => 'BS-001',
                'nama' => 'Bank Sampah Melati Bersih',
                'slug' => 'bank-sampah-melati-bersih',
                'deskripsi' => 'Unit pusat pengelolaan daur ulang sampah organik dan anorganik wilayah Bandung Tengah.',
                'email' => 'melati.bersih@sisampah.id',
                'telepon' => '081234567890',
                'whatsapp' => '6281234567890',
                'website' => 'https://melatibersih.sisampah.id',
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
                'radius_layanan' => 5000,
                'status' => 'aktif',
            ],
            [
                'kode_bank' => 'BS-002',
                'nama' => 'Bank Sampah Mawar Asri',
                'slug' => 'bank-sampah-mawar-asri',
                'deskripsi' => 'Spesialis daur ulang plastik PET, HDPE, dan kertas karton kemasan.',
                'email' => 'mawar.asri@sisampah.id',
                'telepon' => '081298765432',
                'whatsapp' => '6281298765432',
                'website' => 'https://mawarasri.sisampah.id',
                'alamat' => 'Jl. Asia Afrika No. 88, Kec. Sumur Bandung, Kota Bandung, Jawa Barat',
                'provinsi' => 'Jawa Barat',
                'kabupaten' => 'Kota Bandung',
                'kecamatan' => 'Sumur Bandung',
                'desa' => 'Braga',
                'kode_pos' => '40111',
                'latitude' => -6.9211,
                'longitude' => 107.6111,
                'jam_buka' => '08:00',
                'jam_tutup' => '15:30',
                'hari_operasional' => 'Senin - Jumat',
                'radius_layanan' => 5000,
                'status' => 'aktif',
            ],
            [
                'kode_bank' => 'BS-003',
                'nama' => 'Bank Sampah Kenanga Utama',
                'slug' => 'bank-sampah-kenanga-utama',
                'deskripsi' => 'Unit penerima sampah elektronik, logam, dan minyak jelantah.',
                'email' => 'kenanga.utama@sisampah.id',
                'telepon' => '081311223344',
                'whatsapp' => '6281311223344',
                'website' => 'https://kenangautama.sisampah.id',
                'alamat' => 'Jl. Soekarno-Hatta No. 450, Kec. Batununggal, Kota Bandung, Jawa Barat',
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
                'radius_layanan' => 5000,
                'status' => 'aktif',
            ],
        ];

        foreach ($units as &$unit) {
            $unit['radius_layanan'] = 2000;
        }

        foreach ($units as $unit) {
            BankSampah::updateOrCreate(['kode_bank' => $unit['kode_bank']], $unit);
        }

        // Enforce 2000m max radius on all records
        BankSampah::query()->update(['radius_layanan' => 2000]);
    }
}
