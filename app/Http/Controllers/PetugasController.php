<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Leaderboard;
use App\Models\Transaction;
use App\Models\TrashCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function dashboardManifes()
    {
        $petugas = auth()->user();

        $pickupRequests = Transaction::where('tipe_setoran', 'jemput')
            ->where('status', 'pending')
            ->with('user', 'trashCategory')
            ->latest()
            ->paginate(15);

        $completedToday = Transaction::where('petugas_id', $petugas->id)
            ->where('status', 'selesai')
            ->whereDate('updated_at', today())
            ->count();

        $totalWeightToday = Transaction::where('petugas_id', $petugas->id)
            ->where('status', 'selesai')
            ->whereDate('updated_at', today())
            ->sum('berat_kg');

        $recentWeighing = Transaction::where('petugas_id', $petugas->id)
            ->where('status', 'selesai')
            ->with('user', 'trashCategory')
            ->latest()
            ->take(8)
            ->get();

        return view('petugas.dashboard', compact(
            'pickupRequests',
            'completedToday',
            'totalWeightToday',
            'recentWeighing'
        ));
    }

    public function showWeighingForm($userId)
    {
        $user = User::findOrFail($userId);
        $trashCategories = TrashCategory::all();

        return view('petugas.weighing-form', compact('user', 'trashCategories'));
    }

    public function storeWeighing(StoreTransactionRequest $request)
    {
        $validated = $request->validated();

        $trashCategory = TrashCategory::findOrFail($validated['trash_category_id']);

        DB::transaction(function () use ($validated, $trashCategory, $request) {
            $transaction = Transaction::create([
                'user_id' => $validated['user_id'],
                'petugas_id' => auth()->id(),
                'trash_category_id' => $validated['trash_category_id'],
                'berat_kg' => $validated['berat_kg'],
                'harga_per_kg' => $trashCategory->harga_per_kg,
                'total_rp' => $validated['berat_kg'] * $trashCategory->harga_per_kg,
                'tipe_setoran' => 'jemput',
                'status' => 'selesai',
                'foto_bukti' => $request->hasFile('foto_bukti')
                    ? $request->file('foto_bukti')->store('transactions', 'public')
                    : null,
            ]);

            $user = User::findOrFail($validated['user_id']);
            $user->increment('saldo', $transaction->total_rp);

            $poin = $this->calculatePoints($trashCategory->nama, $validated['berat_kg']);

            $leaderboard = Leaderboard::firstOrCreate(
                ['user_id' => $user->id],
                ['total_poin_lingkungan' => 0, 'total_berat_kg' => 0, 'jumlah_transaksi' => 0]
            );

            $leaderboard->increment('total_poin_lingkungan', $poin);
            $leaderboard->increment('total_berat_kg', $validated['berat_kg']);
            $leaderboard->increment('jumlah_transaksi');
        });

        return redirect()->route('petugas.dashboard')
            ->with('success', 'Data timbangan berhasil disimpan dan saldo nasabah telah diperbarui.');
    }

    public function showSelfDepositForm()
    {
        $trashCategories = TrashCategory::all();

        return view('petugas.self-deposit-form', compact('trashCategories'));
    }

    public function storeSelfDeposit(Request $request)
    {
        $validated = $request->validate([
            'user_email' => 'required|email|exists:users,email',
            'trash_category_id' => 'required|exists:trash_categories,id',
            'berat_kg' => 'required|numeric|min:0.5',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::where('email', $validated['user_email'])->firstOrFail();
        $trashCategory = TrashCategory::findOrFail($validated['trash_category_id']);

        DB::transaction(function () use ($validated, $user, $trashCategory) {
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'petugas_id' => auth()->id(),
                'trash_category_id' => $validated['trash_category_id'],
                'berat_kg' => $validated['berat_kg'],
                'harga_per_kg' => $trashCategory->harga_per_kg,
                'total_rp' => $validated['berat_kg'] * $trashCategory->harga_per_kg,
                'tipe_setoran' => 'mandiri',
                'status' => 'selesai',
                'foto_bukti' => isset($validated['foto_bukti'])
                    ? $validated['foto_bukti']->store('transactions', 'public')
                    : null,
            ]);

            $user->increment('saldo', $transaction->total_rp);

            $poin = $this->calculatePoints($trashCategory->nama, $validated['berat_kg']);

            $leaderboard = Leaderboard::firstOrCreate(
                ['user_id' => $user->id],
                ['total_poin_lingkungan' => 0, 'total_berat_kg' => 0, 'jumlah_transaksi' => 0]
            );

            $leaderboard->increment('total_poin_lingkungan', $poin);
            $leaderboard->increment('total_berat_kg', $validated['berat_kg']);
            $leaderboard->increment('jumlah_transaksi');
        });

        return redirect()->route('petugas.dashboard')
            ->with('success', 'Setoran mandiri berhasil diproses.');
    }

    private function calculatePoints($trashType, $weight)
    {
        $basePoints = match ($trashType) {
            'Organik' => 10,
            'Plastik' => 20,
            'Kardus' => 15,
            'Kertas' => 15,
            'Logam' => 25,
            'Kaca' => 10,
            default => 10,
        };

        return (int) ($weight * $basePoints);
    }
}
