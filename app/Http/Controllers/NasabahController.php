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

        $saldo = $user->saldo;

        $bsId = $user->bank_sampah_id;
        $hargaSampah = TrashCategory::active()
            ->when($bsId, fn ($q) => $q->where('bank_sampah_id', $bsId))
            ->get();

        $transaksiTerbaru = $user->transactions()
            ->with('trashCategory')
            ->latest()
            ->take(5)
            ->get();

        $totalBerat = $user->transactions()
            ->where('status', 'selesai')
            ->sum('berat_kg');

        $totalPoin = $user->leaderboard?->total_poin_lingkungan ?? 0;

        $leaderboard = Leaderboard::orderByDesc('total_poin_lingkungan')
            ->take(5)
            ->with('user')
            ->get();

        // --- Carbon Footprint Logic ---
        $impact = [
            'co2' => $totalBerat * 1.5,
            'pohon' => $totalBerat / 50,
            'energi' => $totalBerat * 5,
            'air' => $totalBerat * 20,
            'isGreenStarter' => $totalBerat > 10,
        ];

        // Monthly Data (Last 6 Months)
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

            // Find data for this month
            $stat = $monthlyStats->first(function ($item) use ($date) {
                return $item->year == $date->year && $item->month == $date->month;
            });

            $chartData['data'][] = $stat ? (float) $stat->total_berat : 0;
        }

        $bankSampahs = \App\Models\BankSampah::all(['id', 'nama', 'kode_bank', 'latitude', 'longitude', 'radius_layanan', 'alamat', 'telepon', 'email', 'jam_buka', 'jam_tutup']);

        return view('nasabah.dashboard', compact(
            'saldo',
            'hargaSampah',
            'transaksiTerbaru',
            'totalBerat',
            'totalPoin',
            'leaderboard',
            'impact',
            'chartData',
            'bankSampahs'
        ));
    }

    public function showPickupForm()
    {
        $trashCategories = TrashCategory::all();
        $bankSampahs = \App\Models\BankSampah::active()->get();

        return view('nasabah.pickup-form', compact('trashCategories', 'bankSampahs'));
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

        $saldo = $user->saldo;

        $mutasi = $user->transactions()
            ->where('status', 'selesai')
            ->with('trashCategory')
            ->latest()
            ->paginate(10, ['*'], 'mutasi_page');

        $withdrawals = $user->withdrawals()
            ->latest()
            ->paginate(10, ['*'], 'withdrawals_page');

        if (\Illuminate\Support\Facades\Schema::hasTable('topups')) {
            $topups = $user->topups()
                ->latest()
                ->paginate(10, ['*'], 'topups_page');
        } else {
            $topups = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10, 1, ['pageName' => 'topups_page']);
        }

        return view('nasabah.wallet', compact('saldo', 'mutasi', 'withdrawals', 'topups'));
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

        $totalBerat = $user->transactions()
            ->where('status', 'selesai')
            ->sum('berat_kg');

        $totalTransaksi = $user->transactions()
            ->where('status', 'selesai')
            ->count();

        $totalPoin = $user->leaderboard?->total_poin_lingkungan ?? 0;

        // Impact calculations
        $impact = [
            'co2' => $totalBerat * 1.5,
            'pohon' => $totalBerat / 50,
            'energi' => $totalBerat * 5,
            'air' => $totalBerat * 20,
        ];

        // Determine Badge & Level using Model Accessors
        if ($user->leaderboard) {
            $badge = $user->leaderboard->badge_name.' '.$user->leaderboard->badge_icon;
            $levelText = 'Level '.$user->leaderboard->level;
        } else {
            $badge = 'Warga Peduli 🥉';
            $levelText = 'Level 1 (Perunggu)';
        }

        // Get Rank Position
        $rank = Leaderboard::where('total_poin_lingkungan', '>', $totalPoin)->count() + 1;

        return view('nasabah.certificate', compact(
            'user',
            'totalBerat',
            'totalTransaksi',
            'totalPoin',
            'impact',
            'badge',
            'levelText',
            'rank'
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
