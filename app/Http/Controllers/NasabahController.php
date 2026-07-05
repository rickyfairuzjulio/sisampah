<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePickupRequest;
use App\Http\Requests\StoreWithdrawalRequest;
use App\Models\TrashCategory;
use App\Models\Transaction;
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

        $leaderboard = \App\Models\Leaderboard::orderByDesc('total_poin_lingkungan')
            ->take(5)
            ->with('user')
            ->get();

        return view('nasabah.dashboard', compact(
            'saldo',
            'hargaSampah',
            'transaksiTerbaru',
            'totalBerat',
            'totalPoin',
            'leaderboard'
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

        $totalWeight = (float) $validated['perkiraan_berat'];

        $trashCategory = TrashCategory::findOrFail($validated['trash_category_id']);

        Transaction::create([
            'user_id' => auth()->id(),
            'trash_category_id' => $validated['trash_category_id'],
            'berat_kg' => $totalWeight,
            'harga_per_kg' => $trashCategory->harga_per_kg,
            'total_rp' => $totalWeight * $trashCategory->harga_per_kg,
            'tipe_setoran' => 'jemput',
            'status' => 'pending',
            'koordinat_lat' => $validated['koordinat_lat'],
            'koordinat_lng' => $validated['koordinat_lng'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

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
            return back()->withErrors(['nominal' => 'Saldo Anda tidak cukup.']);
        }

        Withdrawal::create([
            'user_id' => $user->id,
            'nominal' => $validated['nominal'],
            'metode' => $validated['metode'],
            'status' => 'pending',
        ]);

        return redirect()->route('nasabah.wallet')
            ->with('success', 'Pengajuan penarikan dana berhasil dibuat. Tunggu persetujuan admin.');
    }
}
