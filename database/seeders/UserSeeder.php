<?php

namespace Database\Seeders;

use App\Models\BankSampah;
use App\Models\Leaderboard;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure Bank Sampah units exist
        if (BankSampah::count() === 0) {
            $this->call(BankSampahSeeder::class);
        }

        $bsMelati = BankSampah::where('kode_bank', 'BS-001')->first() ?: BankSampah::first();
        $bsTampingan = BankSampah::where('kode_bank', 'BS-002')->first() ?: BankSampah::skip(1)->first() ?: $bsMelati;
        $bsKenanga = BankSampah::where('kode_bank', 'BS-003')->first() ?: BankSampah::skip(2)->first() ?: $bsMelati;
        $bsSurabaya = BankSampah::where('kode_bank', 'BS-004')->first() ?: BankSampah::skip(3)->first() ?: $bsMelati;
        $bsBali = BankSampah::where('kode_bank', 'BS-005')->first() ?: BankSampah::skip(4)->first() ?: $bsMelati;

        // 2. Super Admin Platform (Kewenangan penuh seluruh platform & verifikasi Bank Sampah)
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@sisampah.id'],
            [
                'name' => 'Super Admin Platform Pusat',
                'password' => Hash::make('password'),
                'saldo' => 0,
                'bank_sampah_id' => null,
                'alamat_lengkap' => 'Kantor Pusat SiSampah Digital',
                'nomor_telepon' => '081100000000',
            ]
        );
        $superAdmin->syncRoles(['super_admin']);

        // Delete legacy admin@sisampah.local if it exists
        User::where('email', 'admin@sisampah.local')->delete();

        // 3. Admins Per Unit Bank Sampah (Exact accounts requested)
        $adminList = [
            ['name' => 'Admin Bank Sampah Melati', 'email' => 'admin@sisampah.id', 'bank' => $bsMelati],
            ['name' => 'Admin Bank Sampah Tampingan', 'email' => 'admin.tampingan@sisampah.id', 'bank' => $bsTampingan],
            ['name' => 'Admin Bank Sampah Kenanga', 'email' => 'admin.kenanga@sisampah.id', 'bank' => $bsKenanga],
            ['name' => 'Admin Bank Sampah Surabaya', 'email' => 'admin.surabaya@sisampah.id', 'bank' => $bsSurabaya],
            ['name' => 'Admin Bank Sampah Bali', 'email' => 'admin.bali@sisampah.id', 'bank' => $bsBali],
        ];

        foreach ($adminList as $a) {
            $user = User::updateOrCreate(
                ['email' => $a['email']],
                [
                    'name' => $a['name'],
                    'password' => Hash::make('password'),
                    'saldo' => 0,
                    'bank_sampah_id' => $a['bank']?->id,
                    'alamat_lengkap' => 'Kantor Unit ' . $a['name'],
                    'nomor_telepon' => '0812' . rand(10000000, 99999999),
                ]
            );
            $user->syncRoles(['admin']);
        }

        // 4. Petugas Per Bank Sampah
        $petugasList = [
            ['name' => 'Budi Santoso', 'email' => 'petugas1@sisampah.local', 'bank' => $bsMelati, 'telp' => '081234567891'],
            ['name' => 'Agus Pratama', 'email' => 'petugas.melati@sisampah.id', 'bank' => $bsMelati, 'telp' => '081234567892'],
            ['name' => 'Ahmad Jaelani', 'email' => 'petugas.tampingan@sisampah.id', 'bank' => $bsTampingan, 'telp' => '081234567893'],
            ['name' => 'Siti Aminah', 'email' => 'petugas.kenanga@sisampah.id', 'bank' => $bsKenanga, 'telp' => '081234567895'],
            ['name' => 'Dedi Kurniawan', 'email' => 'petugas.surabaya@sisampah.id', 'bank' => $bsSurabaya, 'telp' => '081234567897'],
            ['name' => 'I Wayan Balik', 'email' => 'petugas.bali@sisampah.id', 'bank' => $bsBali, 'telp' => '081234567899'],
        ];

        foreach ($petugasList as $p) {
            $user = User::updateOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['name'],
                    'password' => Hash::make('password'),
                    'saldo' => 0,
                    'bank_sampah_id' => $p['bank']?->id,
                    'rt' => '0' . rand(1, 5),
                    'rw' => '0' . rand(1, 8),
                    'alamat_lengkap' => 'Jl. Petugas No. ' . rand(1, 50),
                    'nomor_telepon' => $p['telp'],
                ]
            );
            $user->syncRoles(['petugas']);
        }

        // 5. Nasabah Per Bank Sampah
        $nasabahList = [
            ['name' => 'Dewi Lestari', 'email' => 'nasabah1@sisampah.local', 'bank' => $bsMelati, 'saldo' => 150000, 'rt' => '01', 'rw' => '02'],
            ['name' => 'Rina Gunawan', 'email' => 'nasabah.melati@sisampah.id', 'bank' => $bsMelati, 'saldo' => 75000, 'rt' => '01', 'rw' => '03'],
            ['name' => 'Sari Indah', 'email' => 'nasabah.tampingan@sisampah.id', 'bank' => $bsTampingan, 'saldo' => 95000, 'rt' => '02', 'rw' => '01'],
            ['name' => 'Eko Prasetyo', 'email' => 'nasabah.kenanga@sisampah.id', 'bank' => $bsKenanga, 'saldo' => 120000, 'rt' => '03', 'rw' => '04'],
            ['name' => 'Bambang Tri', 'email' => 'nasabah.surabaya@sisampah.id', 'bank' => $bsSurabaya, 'saldo' => 200000, 'rt' => '04', 'rw' => '05'],
            ['name' => 'Ni Made Putu', 'email' => 'nasabah.bali@sisampah.id', 'bank' => $bsBali, 'saldo' => 180000, 'rt' => '05', 'rw' => '02'],
        ];

        foreach ($nasabahList as $n) {
            $user = User::updateOrCreate(
                ['email' => $n['email']],
                [
                    'name' => $n['name'],
                    'password' => Hash::make('password'),
                    'saldo' => $n['saldo'],
                    'bank_sampah_id' => $n['bank']?->id,
                    'rt' => $n['rt'],
                    'rw' => $n['rw'],
                    'alamat_lengkap' => 'Jl. Nasabah No. ' . rand(1, 100),
                    'nomor_telepon' => '0857' . rand(10000000, 99999999),
                ]
            );
            $user->syncRoles(['nasabah']);

            Leaderboard::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'total_poin_lingkungan' => rand(100, 1500),
                    'total_berat_kg' => rand(20, 300),
                    'jumlah_transaksi' => rand(5, 40),
                ]
            );
        }
    }
}
