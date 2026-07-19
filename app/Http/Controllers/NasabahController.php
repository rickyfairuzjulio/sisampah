<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePickupRequest;
use App\Http\Requests\StoreWithdrawalRequest;
use App\Models\Leaderboard;
use App\Models\Transaction;
use App\Models\TrashCategory;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->paginate(10);

        $withdrawals = $user->withdrawals()
            ->latest()
            ->paginate(10);

        return view('nasabah.wallet', compact('saldo', 'mutasi', 'withdrawals'));
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
}
