<?php

namespace Database\Seeders;

use App\Models\Leaderboard;
use App\Models\Transaction;
use App\Models\TrashCategory;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompetitionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Extra Users (Nasabah & Petugas)
        $petugasUsers = [
            ['name' => 'Ahmad Jaelani', 'email' => 'petugas2@sisampah.local', 'nomor_telepon' => '082211223344'],
            ['name' => 'Siti Aminah', 'email' => 'petugas3@sisampah.local', 'nomor_telepon' => '082211223355'],
        ];

        foreach ($petugasUsers as $data) {
            $user = User::firstOrCreate(['email' => $data['email']], [
                'name' => $data['name'],
                'password' => Hash::make('password'),
                'saldo' => 0,
                'rt' => '02',
                'rw' => '05',
                'alamat_lengkap' => 'Jalan Kenanga No. '.rand(1, 100),
                'nomor_telepon' => $data['nomor_telepon'],
            ]);
            $user->assignRole('petugas');
        }

        $nasabahNames = [
            'Bapak Budi Hartono',
            'Ibu Ratna',
            'Dimas Saputra',
            'Keluarga Haryanto',
            'Warung Bu Neng'
        ];

        foreach ($nasabahNames as $index => $name) {
            $user = User::firstOrCreate(['email' => 'nasabah_c'.($index + 1).'@sisampah.local'], [
                'name' => $name,
                'password' => Hash::make('password'),
                'saldo' => rand(10000, 150000), // Random starting balance
                'rt' => '0'.rand(1, 9),
                'rw' => '05',
                'alamat_lengkap' => 'Jalan Mawar No. '.rand(1, 50),
                'nomor_telepon' => '0855667788'.rand(10, 99),
            ]);
            $user->assignRole('nasabah');
        }

        // 2. Generate Transactions
        $nasabahs = User::role('nasabah')->get();
        $petugases = User::role('petugas')->get();
        $categories = TrashCategory::all();

        if ($nasabahs->isEmpty() || $petugases->isEmpty() || $categories->isEmpty()) {
            return;
        }

        $statuses = ['selesai', 'selesai', 'selesai', 'pending', 'pending'];
        $types = ['jemput', 'mandiri'];

        foreach ($nasabahs as $nasabah) {
            // Each nasabah has 2-5 transactions
            for ($i = 0; $i < rand(2, 5); $i++) {
                $category = $categories->random();
                $petugas = $petugases->random();
                $berat = rand(10, 150) / 10; // 1.0 to 15.0 kg
                $harga = $category->harga_per_kg;
                $total = $berat * $harga;
                $status = $statuses[array_rand($statuses)];
                $type = $types[array_rand($types)];

                Transaction::create([
                    'user_id' => $nasabah->id,
                    'petugas_id' => ($status === 'selesai' || $type === 'mandiri') ? $petugas->id : null,
                    'trash_category_id' => $category->id,
                    'berat_kg' => $berat,
                    'harga_per_kg' => $harga,
                    'total_rp' => $total,
                    'tipe_setoran' => $type,
                    'status' => $status,
                    'koordinat_lat' => '-6.9'.rand(1000, 9999),
                    'koordinat_lng' => '110.4'.rand(1000, 9999),
                    'catatan' => 'Setoran bulan ini.',
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(0, 30))
                ]);
            }
        }

        // 3. Generate Withdrawals
        $methods = ['Gopay', 'OVO', 'Dana', 'Tunai', 'Transfer Bank'];
        
        foreach ($nasabahs as $nasabah) {
            // Give 1-2 withdrawals to some users
            if (rand(0, 1)) {
                $status = ['pending', 'disetujui', 'ditolak'][rand(0, 2)];
                $nominal = rand(1, 5) * 10000;
                
                Withdrawal::create([
                    'user_id' => $nasabah->id,
                    'nominal' => $nominal,
                    'metode' => $methods[array_rand($methods)],
                    'rekening_tujuan' => '08' . rand(1000000000, 9999999999),
                    'nama_penerima' => $nasabah->name,
                    'status' => $status,
                    'catatan_admin' => $status === 'ditolak' ? 'Rekening tidak valid' : ($status === 'disetujui' ? 'Sudah ditransfer' : null),
                    'created_at' => now()->subDays(rand(1, 15)),
                    'updated_at' => now()->subDays(rand(0, 15))
                ]);
            }
        }

        // 4. Generate Leaderboard Data
        foreach ($nasabahs as $nasabah) {
            $selesaiTransactions = Transaction::where('user_id', $nasabah->id)
                ->where('status', 'selesai')
                ->get();

            if ($selesaiTransactions->isNotEmpty()) {
                Leaderboard::updateOrCreate(
                    ['user_id' => $nasabah->id],
                    [
                        'total_poin_lingkungan' => $selesaiTransactions->sum('total_rp'),
                        'total_berat_kg' => $selesaiTransactions->sum('berat_kg'),
                        'jumlah_transaksi' => $selesaiTransactions->count(),
                    ]
                );
            }
        }
    }
}
