<?php

namespace Database\Seeders;

use App\Models\Leaderboard;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::create([
            'name' => 'Admin SiSampah',
            'email' => 'admin@sisampah.local',
            'password' => Hash::make('password'),
            'saldo' => 0,
            'rt' => null,
            'rw' => null,
            'alamat_lengkap' => 'Kantor Bank Sampah Kelurahan',
            'nomor_telepon' => '081234567890',
        ]);
        $adminUser->assignRole('admin');

        $petugasUsers = [
            [
                'name' => 'Budi Santoso',
                'email' => 'petugas1@sisampah.local',
                'rt' => '01',
                'rw' => '05',
                'nomor_telepon' => '081234567891',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'petugas2@sisampah.local',
                'rt' => '02',
                'rw' => '05',
                'nomor_telepon' => '081234567892',
            ],
            [
                'name' => 'Ahmad Wijaya',
                'email' => 'petugas3@sisampah.local',
                'rt' => '03',
                'rw' => '06',
                'nomor_telepon' => '081234567893',
            ],
        ];

        foreach ($petugasUsers as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'saldo' => 0,
                'rt' => $data['rt'],
                'rw' => $data['rw'],
                'alamat_lengkap' => 'Jalan Merdeka No. ' . rand(1, 100),
                'nomor_telepon' => $data['nomor_telepon'],
            ]);
            $user->assignRole('petugas');
        }

        $nasabahNames = [
            'Ibu Sari Wulandari', 'Pak Hendra Gunawan', 'Ibu Dewi Lestari',
            'Pak Rudi Hermawan', 'Ibu Eka Putri', 'Pak Bambang Suryanto',
            'Ibu Ratna Kusuma', 'Pak Dedi Supriyadi', 'Ibu Nita Sanjaya',
            'Pak Yusuf Rahman', 'Ibu Citra Dewi', 'Pak Joni Prasetyo',
            'Ibu Mira Handoko', 'Pak Tono Wijaya', 'Ibu Sinta Rahayu',
        ];

        $rtList = ['01', '02', '03', '04', '05'];
        $rwList = ['05', '06', '07'];

        foreach ($nasabahNames as $index => $name) {
            $user = User::create([
                'name' => $name,
                'email' => 'nasabah' . ($index + 1) . '@sisampah.local',
                'password' => Hash::make('password'),
                'saldo' => rand(50000, 500000),
                'rt' => $rtList[$index % count($rtList)],
                'rw' => $rwList[$index % count($rwList)],
                'alamat_lengkap' => 'Jalan Sudirman No. ' . rand(1, 150),
                'nomor_telepon' => '0812' . rand(10000000, 99999999),
            ]);
            $user->assignRole('nasabah');

            Leaderboard::create([
                'user_id' => $user->id,
                'total_poin_lingkungan' => rand(100, 1000),
                'total_berat_kg' => rand(10, 100),
                'jumlah_transaksi' => rand(5, 50),
            ]);
        }
    }
}
