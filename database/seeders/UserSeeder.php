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
        $banks = BankSampah::all();
        $bankMelati = $banks->where('kode_bank', 'BS-001')->first() ?? $banks->first();
        $bankMawar = $banks->where('kode_bank', 'BS-002')->first() ?? $banks->skip(1)->first() ?? $bankMelati;
        $bankKenanga = $banks->where('kode_bank', 'BS-003')->first() ?? $banks->skip(2)->first() ?? $bankMelati;

        // 1. Super Admin
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@sisampah.local'],
            [
                'name' => 'Admin SiSampah Pusat',
                'password' => Hash::make('password'),
                'saldo' => 0,
                'bank_sampah_id' => $bankMelati?->id,
                'alamat_lengkap' => 'Kantor Bank Sampah Pusat',
                'nomor_telepon' => '081234567890',
            ]
        );
        $superAdmin->syncRoles(['admin']);

        // 2. Admins Per Bank Sampah
        $adminList = [
            ['name' => 'Admin Melati Bersih', 'email' => 'admin.melati@sisampah.id', 'bank' => $bankMelati],
            ['name' => 'Admin Mawar Asri', 'email' => 'admin.mawar@sisampah.id', 'bank' => $bankMawar],
            ['name' => 'Admin Kenanga Utama', 'email' => 'admin.kenanga@sisampah.id', 'bank' => $bankKenanga],
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

        // 3. Petugas Per Bank Sampah
        $petugasList = [
            // Melati Bersih
            ['name' => 'Budi Santoso', 'email' => 'petugas1@sisampah.local', 'bank' => $bankMelati, 'telp' => '081234567891'],
            ['name' => 'Agus Pratama', 'email' => 'petugas.melati1@sisampah.id', 'bank' => $bankMelati, 'telp' => '081234567892'],
            
            // Mawar Asri
            ['name' => 'Ahmad Jaelani', 'email' => 'petugas2@sisampah.local', 'bank' => $bankMawar, 'telp' => '081234567893'],
            ['name' => 'Hendra Wijaya', 'email' => 'petugas.mawar1@sisampah.id', 'bank' => $bankMawar, 'telp' => '081234567894'],
            
            // Kenanga Utama
            ['name' => 'Siti Aminah', 'email' => 'petugas3@sisampah.local', 'bank' => $bankKenanga, 'telp' => '081234567895'],
            ['name' => 'Bambang Setyo', 'email' => 'petugas.kenanga1@sisampah.id', 'bank' => $bankKenanga, 'telp' => '081234567896'],
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

        // 4. Nasabah Per Bank Sampah
        $nasabahList = [
            // Unit 1: Melati Bersih
            ['name' => 'Ibu Sari Wulandari', 'email' => 'nasabah1@sisampah.local', 'bank' => $bankMelati],
            ['name' => 'Bapak Budi Hartono', 'email' => 'nasabah_c1@sisampah.local', 'bank' => $bankMelati],
            ['name' => 'Dimas Saputra', 'email' => 'nasabah_c3@sisampah.local', 'bank' => $bankMelati],
            ['name' => 'Warung Bu Neng', 'email' => 'nasabah_c5@sisampah.local', 'bank' => $bankMelati],

            // Unit 2: Mawar Asri
            ['name' => 'Ibu Tejo', 'email' => 'nasabah_c2@sisampah.local', 'bank' => $bankMawar],
            ['name' => 'Ray', 'email' => 'ray@emai.com', 'bank' => $bankMawar],
            ['name' => 'Riki Pairus', 'email' => 'rikiboja@gmail.com', 'bank' => $bankMawar],
            ['name' => 'Rina Marlina', 'email' => 'nasabah.mawar1@sisampah.id', 'bank' => $bankMawar],

            // Unit 3: Kenanga Utama
            ['name' => 'Keluarga Haryanto', 'email' => 'nasabah_c4@sisampah.local', 'bank' => $bankKenanga],
            ['name' => 'Eko Prasetyo', 'email' => 'nasabah.kenanga1@sisampah.id', 'bank' => $bankKenanga],
            ['name' => 'Maya Indah', 'email' => 'nasabah.kenanga2@sisampah.id', 'bank' => $bankKenanga],
            ['name' => 'Dedi Kurniawan', 'email' => 'nasabah.kenanga3@sisampah.id', 'bank' => $bankKenanga],
        ];

        foreach ($nasabahList as $idx => $n) {
            $user = User::updateOrCreate(
                ['email' => $n['email']],
                [
                    'name' => $n['name'],
                    'password' => Hash::make('password'),
                    'saldo' => rand(75000, 450000),
                    'bank_sampah_id' => $n['bank']?->id,
                    'rt' => '0' . rand(1, 5),
                    'rw' => '0' . rand(1, 8),
                    'alamat_lengkap' => 'Jl. Permata No. ' . ($idx + 10),
                    'nomor_telepon' => '0812' . rand(10000000, 99999999),
                ]
            );
            $user->syncRoles(['nasabah']);

            Leaderboard::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'total_poin_lingkungan' => rand(200, 1500),
                    'total_berat_kg' => rand(20, 180),
                    'jumlah_transaksi' => rand(8, 45),
                ]
            );
        }

        // Update all unassigned users to Melati Bersih as default fallback
        User::whereNull('bank_sampah_id')->update(['bank_sampah_id' => $bankMelati?->id]);
    }
}
