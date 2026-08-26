<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePickupRequest;
use App\Http\Requests\StoreWithdrawalRequest;
use App\Models\Leaderboard;
use App\Models\Transaction;
use App\Models\TrashCategory;
use App\Models\Withdrawal;
use App\Models\TopUp;
use App\Core\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NasabahController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $bsId = $user->bank_sampah_id;

        // 1. Auth & Bank Sampah Domisili
        $authData = [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar_url' => $user->avatar_url,
                'role' => $user->getRoleNames()->first() ?? 'nasabah',
            ],
            'bank_sampah_name' => $user->bankSampah?->nama ?? 'Unit Melati',
            'bank_sampah_id' => $bsId,
        ];

        // 2. Gamifikasi
        $userLeaderboard = $user->leaderboard;
        $gamification = [
            'level' => $userLeaderboard ? $userLeaderboard->level : 1,
            'badge_name' => $userLeaderboard ? $userLeaderboard->badge_name : 'Warga Peduli',
            'badge_icon' => $userLeaderboard ? $userLeaderboard->badge_icon : '🥉',
            'badge_color' => $userLeaderboard ? $userLeaderboard->badge_color : 'from-orange-700 to-orange-900',
            'current_xp' => (int) ($userLeaderboard?->total_poin_lingkungan ?? 0),
            'next_xp' => (int) ($userLeaderboard?->next_level_xp ?? 100),
            'xp_percentage' => (int) ($userLeaderboard?->xp_percentage ?? 0),
        ];

        // 3. Saldo & KPI
        $saldo = (float) ($user->saldo ?? 0);
        $totalBerat = (float) $user->transactions()->where('status', 'selesai')->sum('berat_kg');
        $totalPoin = (int) ($userLeaderboard?->total_poin_lingkungan ?? 0);
        $totalTrx = (int) $user->transactions()->count();

        $kpiData = [
            'saldo' => $saldo,
            'saldo_formatted' => 'Rp ' . number_format($saldo, 0, ',', '.'),
            'total_berat' => $totalBerat,
            'total_poin' => $totalPoin,
            'total_transaksi' => $totalTrx,
        ];

        // 4. Dampak Lingkungan
        $impact = [
            'co2' => round($totalBerat * 1.5, 2),
            'pohon' => round($totalBerat / 50, 2),
            'energi' => round($totalBerat * 5, 2),
            'air' => round($totalBerat * 20, 2),
            'isGreenStarter' => $totalBerat > 10,
        ];

        // 5. Monthly Data (Last 6 Months)
        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();

        $driver = DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            $yearExpr = "CAST(strftime('%Y', created_at) AS INTEGER)";
            $monthExpr = "CAST(strftime('%m', created_at) AS INTEGER)";
        } elseif ($driver === 'pgsql') {
            $yearExpr = "EXTRACT(YEAR FROM created_at)::INTEGER";
            $monthExpr = "EXTRACT(MONTH FROM created_at)::INTEGER";
        } else {
            $yearExpr = "YEAR(created_at)";
            $monthExpr = "MONTH(created_at)";
        }

        $monthlyStats = $user->transactions()
            ->where('status', 'selesai')
            ->where('created_at', '>=', $sixMonthsAgo)
            ->selectRaw("{$yearExpr} as year, {$monthExpr} as month, SUM(berat_kg) as total_berat")
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $chartData = [
            'labels' => [],
            'data' => [],
        ];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartData['labels'][] = $date->translatedFormat('M Y');

            $stat = $monthlyStats->first(function ($item) use ($date) {
                return $item->year == $date->year && $item->month == $date->month;
            });

            $chartData['data'][] = $stat ? (float) $stat->total_berat : 0;
        }

        // 6. Prices, Transactions, Leaderboard, Bank Sampahs
        $rawPrices = TrashCategory::active()
            ->when($bsId, fn ($q) => $q->where('bank_sampah_id', $bsId))
            ->get();

        $prices = $rawPrices->map(fn ($p) => [
            'id' => $p->id,
            'nama' => $p->nama,
            'harga_per_kg' => (int) $p->harga_per_kg,
            'satuan' => $p->satuan ?? 'kg',
        ]);

        $rawTrx = $user->transactions()
            ->with('trashCategory')
            ->latest()
            ->take(5)
            ->get();

        $recentTransactions = $rawTrx->map(fn ($t) => [
            'id' => $t->id,
            'kategori' => ['nama' => $t->trashCategory?->nama ?? 'Setoran Sampah'],
            'berat_kg' => (float) $t->berat_kg,
            'total_rp' => (int) $t->total_rp,
            'status' => $t->status,
            'rating' => $t->rating,
            'ulasan' => $t->ulasan,
            'created_at' => $t->created_at ? $t->created_at->toIso8601String() : null,
        ]);

        $rawLeaderboard = Leaderboard::orderByDesc('total_poin_lingkungan')
            ->take(5)
            ->with('user:id,name,avatar')
            ->get();

        $leaderboard = $rawLeaderboard->map(fn ($l) => [
            'user_id' => $l->user_id,
            'user' => ['name' => $l->user?->name ?? 'Warga'],
            'badge_name' => $l->badge_name,
            'badge_icon' => $l->badge_icon,
            'total_poin_lingkungan' => (int) $l->total_poin_lingkungan,
        ]);

        $bankSampahs = \App\Models\BankSampah::all(['id', 'nama', 'kode_bank', 'latitude', 'longitude', 'radius_layanan', 'alamat', 'telepon'])
            ->map(fn ($b) => [
                'id' => $b->id,
                'nama' => $b->nama,
                'latitude' => (float) $b->latitude,
                'longitude' => (float) $b->longitude,
                'radius_layanan' => (float) ($b->radius_layanan ?? 5.0),
                'alamat' => $b->alamat,
                'telepon' => $b->telepon,
            ]);

        return view('nasabah.dashboard', compact(
            'authData',
            'gamification',
            'kpiData',
            'impact',
            'chartData',
            'prices',
            'recentTransactions',
            'leaderboard',
            'bankSampahs'
        ));
    }

    public function showPickupForm()
    {
        $user = auth()->user();
        if ($user) {
            $user->load('bankSampah');
        }

        $bankSampahId = $user?->bank_sampah_id ?: (\App\Models\BankSampah::active()->first()?->id ?? 1);
        $bankSampah = \App\Models\BankSampah::find($bankSampahId) ?: \App\Models\BankSampah::first();

        $trashCategories = TrashCategory::active()
            ->when($bankSampahId, fn ($q) => $q->where('bank_sampah_id', $bankSampahId))
            ->get(['id', 'nama', 'harga_per_kg', 'satuan', 'kategori'])
            ->map(fn ($c) => [
                'id' => $c->id,
                'nama' => $c->nama,
                'harga_per_kg' => (int) $c->harga_per_kg,
                'satuan' => $c->satuan ?: 'Kg',
                'kategori' => strtolower($c->kategori ?: 'anorganik'),
            ]);

        // If no categories found for specific unit, fetch all active categories
        if ($trashCategories->isEmpty()) {
            $trashCategories = TrashCategory::active()
                ->take(12)
                ->get(['id', 'nama', 'harga_per_kg', 'satuan', 'kategori'])
                ->map(fn ($c) => [
                    'id' => $c->id,
                    'nama' => $c->nama,
                    'harga_per_kg' => (int) $c->harga_per_kg,
                    'satuan' => $c->satuan ?: 'Kg',
                    'kategori' => strtolower($c->kategori ?: 'anorganik'),
                ]);
        }

        $authData = [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name ?? 'Nasabah',
                'email' => $user?->email ?? '',
                'avatar_url' => $user?->avatar_url,
                'nomor_telepon' => $user?->nomor_telepon ?? '',
                'alamat_lengkap' => $user?->alamat_lengkap ?? '',
                'rt' => $user?->rt ?? '',
                'rw' => $user?->rw ?? '',
            ],
            'bank_sampah_name' => $bankSampah?->nama ?? 'Unit Melati Asri',
            'bank_sampah_id' => $bankSampahId,
        ];

        $bankSampahData = [
            'id' => $bankSampah?->id,
            'nama' => $bankSampah?->nama ?? 'Bank Sampah Unit',
            'alamat' => $bankSampah?->alamat ?? 'Alamat Unit Domisili',
            'telepon' => $bankSampah?->telepon ?? '0812-3456-7890',
            'kecamatan' => $bankSampah?->kecamatan ?? 'Terdekat',
            'latitude' => (float) ($bankSampah?->latitude ?? -6.8915),
            'longitude' => (float) ($bankSampah?->longitude ?? 107.6107),
            'radius_layanan' => (float) ($bankSampah?->radius_layanan ? ($bankSampah->radius_layanan / 1000) : 5.0),
        ];

        // Fetch recent pickup requests for this user
        $rawPickups = $user ? $user->pickupsAsNasabah()->with(['petugas'])->latest()->take(5)->get() : collect();
        $pickupHistory = $rawPickups->map(fn ($p) => [
            'id' => $p->id,
            'code' => 'PKP-' . str_pad($p->id, 4, '0', STR_PAD_LEFT),
            'status' => $p->status,
            'estimasi_berat' => (float) ($p->estimasi_berat ?? 0),
            'distance_km' => (float) ($p->distance_km ?? 0),
            'address' => $p->address,
            'scheduled_at' => $p->scheduled_at ? $p->scheduled_at->translatedFormat('d M Y, H:i') : null,
            'created_at' => $p->created_at ? $p->created_at->translatedFormat('d M Y') : null,
            'petugas_name' => $p->petugas?->name ?? 'Tim Armada',
        ]);

        return view('nasabah.pickup-form', compact(
            'authData',
            'bankSampahData',
            'trashCategories',
            'pickupHistory'
        ));
    }

    public function storePickup(StorePickupRequest $request)
    {
        $validated = $request->validated();
        $userLat = (float) $validated['koordinat_lat'];
        $userLng = (float) $validated['koordinat_lng'];

        // Enforce pickup strictly to Nasabah's followed Bank Sampah
        $user = auth()->user();
        $bankSampahId = $user->bank_sampah_id;

        if (!$bankSampahId) {
            return back()->with('error', 'Anda belum terhubung dengan Unit Bank Sampah. Silakan perbarui profil Anda.')->withInput();
        }

        $bankSampah = \App\Models\BankSampah::find($bankSampahId);
        if (!$bankSampah || $bankSampah->status !== 'aktif') {
            return back()->with('error', 'Unit Bank Sampah yang Anda ikuti saat ini sedang tidak aktif.')->withInput();
        }

        // Validate service radius
        $distanceKm = $bankSampah->calculateDistance($userLat, $userLng);
        $maxRadiusKm = ($bankSampah->radius_layanan ?: 3000) / 1000;

        if ($distanceKm > $maxRadiusKm) {
            return back()->with('error', "Lokasi Anda ({$distanceKm} km) berada di luar radius layanan Bank Sampah '{$bankSampah->nama}' (Maksimal {$maxRadiusKm} km).")->withInput();
        }

        $items = $validated['items'];
        $totalEstimasiBerat = 0;

        foreach ($items as $item) {
            $totalEstimasiBerat += (float) $item['perkiraan_berat'];
        }

        DB::transaction(function () use ($items, $validated, $bankSampah, $userLat, $userLng, $distanceKm, $totalEstimasiBerat) {
            // 1. Create Pickup record
            $pickup = \App\Models\Pickup::create([
                'bank_sampah_id' => $bankSampah->id,
                'nasabah_id' => auth()->id(),
                'address' => $validated['alamat_lengkap'] ?? auth()->user()->alamat_lengkap ?? 'Lokasi GPS Nasabah',
                'latitude' => $userLat,
                'longitude' => $userLng,
                'distance_km' => $distanceKm,
                'scheduled_at' => now()->addHours(2),
                'status' => 'requested',
                'estimasi_berat' => $totalEstimasiBerat,
                'catatan' => $validated['catatan'] ?? null,
            ]);

            // 2. Create Transaction records linked to bank_sampah_id
            foreach ($items as $item) {
                $trashCategory = TrashCategory::findOrFail($item['trash_category_id']);
                $weight = (float) $item['perkiraan_berat'];

                Transaction::create([
                    'user_id' => auth()->id(),
                    'bank_sampah_id' => $bankSampah->id,
                    'trash_category_id' => $trashCategory->id,
                    'berat_kg' => $weight,
                    'harga_per_kg' => $trashCategory->harga_per_kg,
                    'total_rp' => $weight * $trashCategory->harga_per_kg,
                    'tipe_setoran' => 'jemput',
                    'status' => 'pending',
                    'koordinat_lat' => $userLat,
                    'koordinat_lng' => $userLng,
                    'catatan' => $validated['catatan'] ?? null,
                ]);
            }

            \App\Services\AuditLogger::log(
                'PICKUP_REQUESTED',
                'Pickup',
                $pickup->id,
                null,
                ['bank_sampah_id' => $bankSampah->id, 'distance_km' => $distanceKm],
                "Permintaan pickup dibuat oleh " . auth()->user()->name
            );
        });

        return redirect()->route('nasabah.dashboard')
            ->with('success', "Permintaan penjemputan ke Bank Sampah '{$bankSampah->nama}' berhasil dibuat (Jarak: {$distanceKm} km). Tunggu konfirmasi petugas.");
    }

    public function wallet()
    {
        $user = auth()->user();
        if ($user) {
            $user->load('bankSampah');
        }

        $saldo = (int) ($user?->saldo ?? 0);
        $points = (int) ($user?->total_poin_lingkungan ?? $user?->points ?? 0);

        $authData = [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name ?? 'Nasabah',
                'email' => $user?->email ?? '',
                'avatar_url' => $user?->avatar_url,
                'nomor_telepon' => $user?->nomor_telepon ?? '',
                'rt' => $user?->rt ?? '',
                'rw' => $user?->rw ?? '',
                'alamat_lengkap' => $user?->alamat_lengkap ?? '',
                'saldo' => $saldo,
                'points' => $points,
                'virtual_account' => '8802 ' . str_pad($user?->id ?? 1, 4, '0', STR_PAD_LEFT) . ' 7891 4192',
            ],
            'bank_sampah_name' => $user?->bankSampah?->nama ?? 'Unit Melati Asri',
            'bank_sampah_id' => $user?->bank_sampah_id,
        ];

        // 1. Transactions / Setoran Sampah
        $rawMutasi = $user ? $user->transactions()
            ->where('status', 'selesai')
            ->with('trashCategory')
            ->latest()
            ->take(15)
            ->get() : collect();

        $depositTransactions = $rawMutasi->map(fn ($t) => [
            'id' => $t->id,
            'kategori' => $t->trashCategory?->nama ?? 'Setoran Sampah',
            'berat_kg' => (float) $t->berat_kg,
            'harga_per_kg' => (int) $t->harga_per_kg,
            'total_rp' => (int) $t->total_rp,
            'status' => $t->status,
            'created_at' => $t->created_at ? $t->created_at->toIso8601String() : null,
            'created_at_formatted' => $t->created_at ? $t->created_at->translatedFormat('d M Y, H:i') : null,
        ]);

        // 2. Withdrawals
        $rawWithdrawals = $user ? $user->withdrawals()->latest()->take(15)->get() : collect();
        $withdrawals = $rawWithdrawals->map(fn ($w) => [
            'id' => $w->id,
            'nominal' => (int) $w->nominal,
            'metode' => $w->metode,
            'rekening_tujuan' => $w->rekening_tujuan,
            'nama_penerima' => $w->nama_penerima,
            'status' => $w->status,
            'status_penerimaan' => $w->status_penerimaan,
            'catatan_admin' => $w->catatan_admin,
            'created_at' => $w->created_at ? $w->created_at->toIso8601String() : null,
            'created_at_formatted' => $w->created_at ? $w->created_at->translatedFormat('d M Y, H:i') : null,
        ]);

        // 3. Stats KPI
        $totalPemasukan = (int) ($user ? $user->transactions()->where('status', 'selesai')->sum('total_rp') : 0);
        $totalDitarik = (int) ($user ? $user->withdrawals()->where('status', 'disetujui')->sum('nominal') : 0);
        $penarikanPending = (int) ($user ? $user->withdrawals()->where('status', 'pending')->sum('nominal') : 0);

        $walletStats = [
            'total_pemasukan' => $totalPemasukan,
            'total_ditarik' => $totalDitarik,
            'penarikan_pending' => $penarikanPending,
        ];

        return view('nasabah.wallet', compact(
            'authData',
            'saldo',
            'walletStats',
            'depositTransactions',
            'withdrawals'
        ));
    }

    public function requestWithdrawal(StoreWithdrawalRequest $request)
    {
        $validated = $request->validated();
        $user = auth()->user();
        $nominal = (float) $validated['nominal'];

        if ($nominal <= 0) {
            return back()->with('error', 'Nominal penarikan harus lebih besar dari Rp 0.');
        }

        if (!$user->bank_sampah_id) {
            return back()->with('error', 'Anda belum terhubung dengan Bank Sampah mana pun untuk melakukan penarikan saldo.');
        }

        try {
            DB::transaction(function () use ($user, $validated, $nominal) {
                $lockedUser = User::where('id', $user->id)->lockForUpdate()->firstOrFail();

                if ($lockedUser->saldo < $nominal) {
                    throw new \InvalidArgumentException('Saldo Anda tidak cukup untuk penarikan sebesar Rp ' . number_format($nominal, 0, ',', '.'));
                }

                $withdrawal = Withdrawal::create([
                    'user_id' => $lockedUser->id,
                    'bank_sampah_id' => $lockedUser->bank_sampah_id,
                    'nominal' => $nominal,
                    'metode' => $validated['metode'],
                    'rekening_tujuan' => $validated['metode'] !== 'tunai' ? ($validated['rekening_tujuan'] ?? null) : null,
                    'nama_penerima' => $validated['metode'] !== 'tunai' ? ($validated['nama_penerima'] ?? null) : null,
                    'status' => 'pending',
                    'status_penerimaan' => 'pending',
                ]);

                // Use WalletLedgerService for atomic hold
                $walletService = new \App\Services\WalletLedgerService();
                $walletService->recordTransaction(
                    $lockedUser,
                    'withdrawal_hold',
                    $nominal,
                    $lockedUser->bank_sampah_id,
                    null,
                    $withdrawal->id,
                    'HOLD-' . $withdrawal->id,
                    "Hold saldo untuk penarikan dana ID #{$withdrawal->id}"
                );
            });
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('nasabah.wallet')
            ->with('success', 'Pengajuan penarikan dana berhasil dibuat dan dimohonkan ke Admin Bank Sampah yang Anda ikuti.');
    }

    public function confirmWithdrawalReceipt(Request $request, $id)
    {
        $validated = $request->validate([
            'action' => 'required|in:diterima,disanggah',
            'catatan' => 'nullable|string|max:500',
        ]);

        $withdrawal = Withdrawal::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $withdrawal->status_penerimaan = $validated['action'];
        if ($validated['action'] === 'disanggah' && !empty($validated['catatan'])) {
            $withdrawal->catatan_admin = ($withdrawal->catatan_admin ? $withdrawal->catatan_admin . "\n" : '') . "Sanggahan Nasabah: " . $validated['catatan'];
        }
        $withdrawal->save();

        $msg = $validated['action'] === 'diterima'
            ? 'Terima kasih, konfirmasi pencairan saldo telah berhasil.'
            : 'Sanggahan Anda telah dikirimkan ke Admin Bank Sampah Unit.';

        return back()->with('success', $msg);
    }

    public function certificate()
    {
        $user = auth()->user();

        $totalBerat = (float) ($user ? $user->transactions()
            ->where('status', 'selesai')
            ->sum('berat_kg') : 0);

        $totalTransaksi = (int) ($user ? $user->transactions()
            ->where('status', 'selesai')
            ->count() : 0);

        $totalPoin = (int) ($user?->leaderboard?->total_poin_lingkungan ?? 0);

        // Impact calculations
        $impact = [
            'co2' => round($totalBerat * 1.5, 1),
            'pohon' => round($totalBerat / 50, 1),
            'energi' => round($totalBerat * 5, 1),
            'air' => round($totalBerat * 20, 1),
        ];

        // Determine Badge & Level
        if ($user?->leaderboard) {
            $badgeName = $user->leaderboard->badge_name ?? 'Warga Peduli';
            $badgeIcon = $user->leaderboard->badge_icon ?? '🥉';
            $levelText = 'Level ' . ($user->leaderboard->level ?? 1);
        } else {
            $badgeName = 'Warga Peduli';
            $badgeIcon = '🥉';
            $levelText = 'Level 1 (Perunggu)';
        }

        // Get Rank Position
        $rank = Leaderboard::where('total_poin_lingkungan', '>', $totalPoin)->count() + 1;

        $stats = [
            'total_berat' => $totalBerat,
            'total_transaksi' => $totalTransaksi,
            'total_poin' => $totalPoin,
            'rank' => $rank,
            'badge_name' => $badgeName,
            'badge_icon' => $badgeIcon,
            'level_text' => $levelText,
        ];

        $certNumber = 'SMP-CERT/' . date('Y') . '/' . date('m') . '/' . str_pad($user?->id ?? 1, 4, '0', STR_PAD_LEFT);
        $certificateDetails = [
            'cert_number' => $certNumber,
            'issued_date' => now()->translatedFormat('d F Y'),
            'year' => date('Y'),
            'verification_url' => url('/nasabah/sertifikat?verify=' . $certNumber),
        ];

        // 4 Milestones Gamification Badges
        $badges = [
            [
                'id' => 'warga_peduli',
                'name' => 'Warga Peduli',
                'icon' => '🥉',
                'tier' => 'Perunggu',
                'target_kg' => 5,
                'unlocked' => $totalBerat >= 5,
                'description' => 'Memulai langkah pertama memilah dan menyetor sampah minimal 5 Kg.',
            ],
            [
                'id' => 'pejuang_sirkular',
                'name' => 'Pejuang Sirkular',
                'icon' => '🥈',
                'tier' => 'Perak',
                'target_kg' => 25,
                'unlocked' => $totalBerat >= 25,
                'description' => 'Konsisten mendaur ulang sampah hingga mencapai 25 Kg sampah terkelola.',
            ],
            [
                'id' => 'pahlawan_bumi',
                'name' => 'Pahlawan Bumi',
                'icon' => '🥇',
                'tier' => 'Emas',
                'target_kg' => 50,
                'unlocked' => $totalBerat >= 50,
                'description' => 'Kontribusi nyata mereduksi lebih dari 75 Kg CO₂e dengan total 50 Kg sampah.',
            ],
            [
                'id' => 'duta_lestari',
                'name' => 'Duta Lestari Desa',
                'icon' => '👑',
                'tier' => 'Mahkota Platinum',
                'target_kg' => 100,
                'unlocked' => $totalBerat >= 100,
                'description' => 'Gelar kehormatan tertinggi atas dedikasi luar biasa lebih dari 100 Kg sampah.',
            ],
        ];

        $authData = [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name,
                'email' => $user?->email,
                'avatar_url' => $user?->avatar_url,
                'saldo' => (float) ($user?->saldo ?? 0),
                'virtual_account' => $user?->virtual_account ?? '88020812' . str_pad($user?->id ?? 1, 4, '0', STR_PAD_LEFT),
            ],
            'bank_sampah_name' => $user?->bankSampah?->nama ?? 'Unit Melati Asri',
            'bank_sampah_id' => $user?->bank_sampah_id,
        ];

        return view('nasabah.certificate', compact(
            'authData',
            'stats',
            'impact',
            'certificateDetails',
            'badges'
        ));
    }

    public function submitRating(Request $request, $id)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:500',
        ]);

        $transaction = Transaction::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'selesai')
            ->firstOrFail();

        if ($transaction->rating !== null) {
            return back()->withErrors(['rating' => 'Anda sudah memberikan ulasan untuk transaksi ini.']);
        }

        $transaction->update([
            'rating' => $validated['rating'],
            'ulasan' => $validated['ulasan'],
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    public function showTopUpForm()
    {
        $user = auth()->user();
        $recentTopups = $user->topups()->latest()->take(5)->get();

        return view('nasabah.topup-form', compact('recentTopups'));
    }

    public function storeTopUp(Request $request, MidtransService $midtransService)
    {
        $validated = $request->validate([
            'nominal' => 'required|numeric|min:10000|max:10000000',
        ]);

        $user = auth()->user();

        // 1. Create a pending TopUp record
        $topup = TopUp::create([
            'user_id' => $user->id,
            'nominal' => $validated['nominal'],
            'status' => 'pending',
        ]);

        // 2. Call Midtrans Service to generate snap token
        $midtransResult = $midtransService->getSnapToken($topup->id, $topup->nominal, $user);

        if (!$midtransResult || !isset($midtransResult['token'])) {
            $topup->delete();
            return back()->with('error', 'Gagal menghubungkan ke payment gateway Midtrans. Silakan coba beberapa saat lagi.');
        }

        // 3. Save the token
        $topup->update([
            'snap_token' => $midtransResult['token'],
        ]);

        return response()->json([
            'status' => 'success',
            'token' => $topup->snap_token,
            'redirect_url' => $midtransResult['redirect_url'],
            'topup_id' => $topup->id,
        ]);
    }

    public function checkTopUpStatus($id)
    {
        $topup = TopUp::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return response()->json([
            'status' => $topup->status,
            'nominal' => $topup->nominal,
        ]);
    }

    public function midtransCallback(Request $request, MidtransService $midtransService)
    {
        $payload = $request->all();
        
        Log::info('Midtrans Webhook Received:', $payload);

        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? null;

        if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey) {
            Log::error('Midtrans Webhook: Invalid payload parameters.');
            return response()->json(['message' => 'Invalid Payload'], 400);
        }

        // Verify Signature
        if (!$midtransService->verifyCallbackSignature($orderId, $statusCode, $grossAmount, $signatureKey)) {
            Log::error('Midtrans Webhook: Signature verification failed for Order ID: ' . $orderId);
            return response()->json(['message' => 'Invalid Signature'], 403);
        }

        // Atomic Database Lock & Process
        return DB::transaction(function () use ($orderId, $grossAmount, $transactionStatus, $paymentType, $payload) {
            $topup = TopUp::where('id', $orderId)->lockForUpdate()->first();
            if (!$topup) {
                Log::error('Midtrans Webhook: Top-Up transaction not found for Order ID: ' . $orderId);
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Server-side Amount Validation
            if ((float) $grossAmount < (float) $topup->nominal) {
                Log::error("Midtrans Webhook: Amount mismatch for Order ID {$orderId}. Expected {$topup->nominal}, got {$grossAmount}");
                return response()->json(['message' => 'Amount mismatch'], 400);
            }

            // If transaction is already success, ignore it (Idempotency)
            if ($topup->status === 'success') {
                return response()->json(['message' => 'Transaction already processed']);
            }

            // Map status
            $status = 'pending';
            if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
                $status = 'success';
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                $status = 'failed';
            }

            $topup->update([
                'status' => $status,
                'payment_method' => $paymentType,
                'payment_time' => now(),
                'raw_response' => json_encode($payload),
            ]);

            if ($status === 'success') {
                $user = $topup->user;
                $walletService = new \App\Services\WalletLedgerService();
                $walletService->recordTransaction(
                    $user,
                    'credit',
                    (float) $topup->nominal,
                    $user->bank_sampah_id,
                    null,
                    null,
                    'TOPUP-' . $topup->id,
                    "Top Up Saldo via Midtrans Gateway ({$paymentType})"
                );

                Log::info("User ID {$user->id} ({$user->name}) balance topped up by Rp {$topup->nominal} via Midtrans.");
            }

            return response()->json(['message' => 'OK']);
        });
    }
}
