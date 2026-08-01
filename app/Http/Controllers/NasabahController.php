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

        $hargaSampah = TrashCategory::all();

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
        $monthlyStats = $user->transactions()
            ->where('status', 'selesai')
            ->where('created_at', '>=', $sixMonthsAgo)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(berat_kg) as total_berat')
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

        return view('nasabah.dashboard', compact(
            'saldo',
            'hargaSampah',
            'transaksiTerbaru',
            'totalBerat',
            'totalPoin',
            'leaderboard',
            'impact',
            'chartData'
        ));
    }

    public function showPickupForm()
    {
        $trashCategories = TrashCategory::all();

        return view('nasabah.pickup-form', compact('trashCategories'));
    }

    public function storePickup(StorePickupRequest $request)
    {
        $validated = $request->validated();
        
        $items = $validated['items'];
        $transactions = [];

        DB::transaction(function () use ($items, $validated) {
            foreach ($items as $item) {
                $trashCategory = TrashCategory::findOrFail($item['trash_category_id']);
                $weight = (float) $item['perkiraan_berat'];

                Transaction::create([
                    'user_id' => auth()->id(),
                    'trash_category_id' => $trashCategory->id,
                    'berat_kg' => $weight,
                    'harga_per_kg' => $trashCategory->harga_per_kg,
                    'total_rp' => $weight * $trashCategory->harga_per_kg,
                    'tipe_setoran' => 'jemput',
                    'status' => 'pending',
                    'koordinat_lat' => $validated['koordinat_lat'],
                    'koordinat_lng' => $validated['koordinat_lng'],
                    'catatan' => $validated['catatan'] ?? null,
                ]);
            }
        });

        return redirect()->route('nasabah.dashboard')
            ->with('success', 'Jadwal penjemputan sampah berhasil dibuat. Tunggu konfirmasi petugas.');
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

        if ($user->saldo < $validated['nominal']) {
            return back()->with('error', 'Saldo Anda tidak cukup untuk penarikan sebesar Rp ' . number_format($validated['nominal'], 0, ',', '.'));
        }

        DB::transaction(function () use ($user, $validated) {
            Withdrawal::create([
                'user_id' => $user->id,
                'nominal' => $validated['nominal'],
                'metode' => $validated['metode'],
                'rekening_tujuan' => $validated['metode'] !== 'tunai' ? ($validated['rekening_tujuan'] ?? null) : null,
                'nama_penerima' => $validated['metode'] !== 'tunai' ? ($validated['nama_penerima'] ?? null) : null,
                'status' => 'pending',
            ]);

            $user->decrement('saldo', $validated['nominal']);
        });

        return redirect()->route('nasabah.wallet')
            ->with('success', 'Pengajuan penarikan dana berhasil dibuat. Tunggu persetujuan admin.');
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

        // Find the TopUp record
        $topup = TopUp::find($orderId);
        if (!$topup) {
            Log::error('Midtrans Webhook: Top-Up transaction not found for Order ID: ' . $orderId);
            return response()->json(['message' => 'Transaction not found'], 404);
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

        DB::transaction(function () use ($topup, $status, $paymentType, $payload) {
            $topup->update([
                'status' => $status,
                'payment_method' => $paymentType,
                'payment_time' => now(),
                'raw_response' => json_encode($payload),
            ]);

            if ($status === 'success') {
                $user = $topup->user;
                $user->increment('saldo', $topup->nominal);
                Log::info("User ID {$user->id} ({$user->name}) balance topped up by Rp {$topup->nominal} via Midtrans.");
            }
        });

        return response()->json(['message' => 'OK']);
    }
}
