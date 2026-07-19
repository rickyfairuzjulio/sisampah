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
            ->select('user_id', \DB::raw('SUM(berat_kg) as total_berat'), \DB::raw('COUNT(*) as total_items'), \DB::raw('MAX(created_at) as created_at'))
            ->groupBy('user_id')
            ->with('user')
            ->orderBy('created_at', 'desc')
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

        DB::transaction(function () use ($validated, $request) {
            $user = User::findOrFail($validated['user_id']);
            $items = $validated['items'];
            $totalPoints = 0;
            $totalSaldo = 0;
            $totalWeight = 0;

            // Hapus request pending sebelumnya karena sudah diproses
            Transaction::where('user_id', $user->id)
                ->where('tipe_setoran', 'jemput')
                ->where('status', 'pending')
                ->delete();

            $fotoPath = $request->hasFile('foto_bukti')
                ? $request->file('foto_bukti')->store('transactions', 'public')
                : null;

            foreach ($items as $item) {
                $trashCategory = TrashCategory::findOrFail($item['trash_category_id']);
                $weight = (float) $item['berat_kg'];
                $hargaTotal = $weight * $trashCategory->harga_per_kg;

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'petugas_id' => auth()->id(),
                    'trash_category_id' => $trashCategory->id,
                    'berat_kg' => $weight,
                    'harga_per_kg' => $trashCategory->harga_per_kg,
                    'total_rp' => $hargaTotal,
                    'tipe_setoran' => 'jemput',
                    'status' => 'selesai',
                    'foto_bukti' => $fotoPath,
                ]);

                $totalSaldo += $hargaTotal;
                $totalWeight += $weight;
                $totalPoints += $this->calculatePoints($trashCategory->nama, $weight);
            }

            $user->increment('saldo', $totalSaldo);

            $leaderboard = Leaderboard::firstOrCreate(
                ['user_id' => $user->id],
                ['total_poin_lingkungan' => 0, 'total_berat_kg' => 0, 'jumlah_transaksi' => 0]
            );

            $leaderboard->increment('total_poin_lingkungan', $totalPoints);
            $leaderboard->increment('total_berat_kg', $totalWeight);
            $leaderboard->increment('jumlah_transaksi', count($items));
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
            'items' => 'required|array|min:1',
            'items.*.trash_category_id' => 'required|exists:trash_categories,id',
            'items.*.berat_kg' => 'required|numeric|min:0.1',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::where('email', $validated['user_email'])->firstOrFail();

        DB::transaction(function () use ($validated, $user, $request) {
            $items = $validated['items'];
            $totalPoints = 0;
            $totalSaldo = 0;
            $totalWeight = 0;

            $fotoPath = isset($validated['foto_bukti'])
                ? $validated['foto_bukti']->store('transactions', 'public')
                : null;

            foreach ($items as $item) {
                $trashCategory = TrashCategory::findOrFail($item['trash_category_id']);
                $weight = (float) $item['berat_kg'];
                $hargaTotal = $weight * $trashCategory->harga_per_kg;

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'petugas_id' => auth()->id(),
                    'trash_category_id' => $trashCategory->id,
                    'berat_kg' => $weight,
                    'harga_per_kg' => $trashCategory->harga_per_kg,
                    'total_rp' => $hargaTotal,
                    'tipe_setoran' => 'mandiri',
                    'status' => 'selesai',
                    'foto_bukti' => $fotoPath,
                ]);

                $totalSaldo += $hargaTotal;
                $totalWeight += $weight;
                $totalPoints += $this->calculatePoints($trashCategory->nama, $weight);
            }

            $user->increment('saldo', $totalSaldo);

            $leaderboard = Leaderboard::firstOrCreate(
                ['user_id' => $user->id],
                ['total_poin_lingkungan' => 0, 'total_berat_kg' => 0, 'jumlah_transaksi' => 0]
            );

            $leaderboard->increment('total_poin_lingkungan', $totalPoints);
            $leaderboard->increment('total_berat_kg', $totalWeight);
            $leaderboard->increment('jumlah_transaksi', count($items));
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
