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
        if ($petugas) {
            $petugas->loadMissing('bankSampah');
        }

        $authData = [
            'user' => [
                'id' => $petugas?->id,
                'name' => $petugas?->name,
                'email' => $petugas?->email,
                'avatar_url' => $petugas?->avatar_url,
                'role' => 'petugas',
            ],
            'bank_sampah_name' => $petugas?->bankSampah?->nama ?? 'Unit Melati Asri',
            'bank_sampah_id' => $petugas?->bank_sampah_id,
        ];

        $pendingCount = Transaction::where('tipe_setoran', 'jemput')
            ->where('status', 'pending')
            ->when($petugas->bank_sampah_id, fn ($q) => $q->where('bank_sampah_id', $petugas->bank_sampah_id))
            ->distinct('user_id')
            ->count('user_id');

        $completedToday = Transaction::where('petugas_id', $petugas->id)
            ->where('status', 'selesai')
            ->whereDate('updated_at', today())
            ->count();

        $totalWeightToday = (float) Transaction::where('petugas_id', $petugas->id)
            ->where('status', 'selesai')
            ->whereDate('updated_at', today())
            ->sum('berat_kg');

        $kpiData = [
            'pending_count' => $pendingCount,
            'completed_today' => $completedToday,
            'total_weight_today' => $totalWeightToday,
        ];

        $pickupManifest = Transaction::where('tipe_setoran', 'jemput')
            ->where('status', 'pending')
            ->when($petugas->bank_sampah_id, fn ($q) => $q->where('bank_sampah_id', $petugas->bank_sampah_id))
            ->select('user_id', \DB::raw('SUM(berat_kg) as total_berat'), \DB::raw('COUNT(*) as total_items'), \DB::raw('MAX(created_at) as created_at'))
            ->groupBy('user_id')
            ->with('user.bankSampah')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($req) {
                $user = $req->user;
                $cleanPhone = preg_replace('/[^0-9]/', '', $user?->nomor_telepon ?? '');
                if (str_starts_with($cleanPhone, '0')) {
                    $cleanPhone = '62' . substr($cleanPhone, 1);
                }
                return [
                    'user_id' => $req->user_id,
                    'user_name' => $user?->name ?? 'Nasabah',
                    'avatar_url' => $user?->avatar_url,
                    'user_phone' => $user?->nomor_telepon ?? '-',
                    'wa_link' => !empty($cleanPhone) ? "https://wa.me/{$cleanPhone}?text=" . urlencode("Halo Bapak/Ibu {$user?->name}, kami dari armada petugas SiSampah sedang menuju lokasi penjemputan sampah Anda.") : null,
                    'address' => $user?->alamat_lengkap ?? 'Alamat terdaftar nasabah',
                    'bank_sampah_name' => $user?->bankSampah?->nama ?? 'Unit Melati Asri',
                    'total_berat' => (float) $req->total_berat,
                    'total_items' => (int) $req->total_items,
                    'created_at_formatted' => $req->created_at ? \Carbon\Carbon::parse($req->created_at)->diffForHumans() : 'Baru saja',
                    'weighing_url' => route('petugas.weighing.form', ['user_id' => $req->user_id]),
                ];
            });

        $recentWeighings = Transaction::where('petugas_id', $petugas->id)
            ->where('status', 'selesai')
            ->with(['user', 'trashCategory'])
            ->latest('updated_at')
            ->take(8)
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'user_name' => $t->user?->name ?? 'Nasabah',
                    'category_name' => $t->trashCategory?->nama ?? 'Sampah',
                    'berat_kg' => (float) $t->berat_kg,
                    'total_rp' => (float) $t->total_rp,
                    'total_rp_formatted' => 'Rp ' . number_format($t->total_rp, 0, ',', '.'),
                    'tipe_setoran' => $t->tipe_setoran,
                    'foto_bukti' => $t->foto_bukti ? asset('storage/' . $t->foto_bukti) : null,
                    'time_formatted' => $t->updated_at ? $t->updated_at->translatedFormat('H:i') . ' WIB' : '-',
                    'date_formatted' => $t->updated_at ? $t->updated_at->translatedFormat('d M') : '-',
                ];
            });

        return view('petugas.dashboard', compact(
            'authData',
            'kpiData',
            'pickupManifest',
            'recentWeighings'
        ));
    }

    public function showWeighingForm($userId)
    {
        $petugas = auth()->user();
        if ($petugas) {
            $petugas->loadMissing('bankSampah');
        }

        $authData = [
            'user' => [
                'id' => $petugas?->id,
                'name' => $petugas?->name,
                'email' => $petugas?->email,
                'avatar_url' => $petugas?->avatar_url,
                'role' => 'petugas',
            ],
            'bank_sampah_name' => $petugas?->bankSampah?->nama ?? 'Unit Melati Asri',
            'bank_sampah_id' => $petugas?->bank_sampah_id,
        ];

        $user = User::with('bankSampah')->findOrFail($userId);
        $cleanPhone = preg_replace('/[^0-9]/', '', $user->nomor_telepon ?? '');
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        $targetNasabah = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->nomor_telepon ?? '-',
            'wa_link' => !empty($cleanPhone) ? "https://wa.me/{$cleanPhone}" : null,
            'avatar_url' => $user->avatar_url,
            'address' => $user->alamat_lengkap ?? 'Alamat terdaftar nasabah',
            'virtual_account' => $user->virtual_account ?? '88020812' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
            'bank_sampah_name' => $user->bankSampah?->nama ?? 'Unit Melati Asri',
        ];

        $trashCategories = TrashCategory::active()
            ->when($petugas->bank_sampah_id, fn ($q) => $q->where('bank_sampah_id', $petugas->bank_sampah_id))
            ->get()
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'nama' => $c->nama,
                    'kategori' => $c->kategori ?? 'Umum',
                    'harga_per_kg' => (float) $c->harga_per_kg,
                    'satuan' => $c->satuan ?? 'kg',
                ];
            });

        $pendingItems = Transaction::where('user_id', $user->id)
            ->where('tipe_setoran', 'jemput')
            ->where('status', 'pending')
            ->get()
            ->map(function ($p) {
                return [
                    'trash_category_id' => $p->trash_category_id,
                    'berat_kg' => (float) $p->berat_kg,
                ];
            });

        return view('petugas.weighing-form', compact(
            'authData',
            'targetNasabah',
            'trashCategories',
            'pendingItems'
        ));
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

            $walletService = new \App\Services\WalletLedgerService();
            $petugasBankSampahId = auth()->user()->bank_sampah_id;

            foreach ($items as $item) {
                $trashCategory = TrashCategory::findOrFail($item['trash_category_id']);
                $weight = (float) $item['berat_kg'];
                $hargaTotal = $weight * $trashCategory->harga_per_kg;

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'bank_sampah_id' => $petugasBankSampahId ?: $user->bank_sampah_id,
                    'petugas_id' => auth()->id(),
                    'trash_category_id' => $trashCategory->id,
                    'berat_kg' => $weight,
                    'harga_per_kg' => $trashCategory->harga_per_kg,
                    'total_rp' => $hargaTotal,
                    'tipe_setoran' => 'jemput',
                    'status' => 'selesai',
                    'foto_bukti' => $fotoPath,
                ]);

                // Record credit in wallet ledger
                $walletService->recordTransaction(
                    $user,
                    'credit',
                    $hargaTotal,
                    $petugasBankSampahId ?: $user->bank_sampah_id,
                    $transaction->id,
                    null,
                    'DEP-' . $transaction->id,
                    "Setoran sampah jemput ({$trashCategory->nama} {$weight} kg)"
                );

                $totalSaldo += $hargaTotal;
                $totalWeight += $weight;
                $totalPoints += $this->calculatePoints($trashCategory->nama, $weight);
            }

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
        $petugas = auth()->user();
        if ($petugas) {
            $petugas->loadMissing('bankSampah');
        }

        $authData = [
            'user' => [
                'id' => $petugas?->id,
                'name' => $petugas?->name,
                'email' => $petugas?->email,
                'avatar_url' => $petugas?->avatar_url,
                'role' => 'petugas',
            ],
            'bank_sampah_name' => $petugas?->bankSampah?->nama ?? 'Unit Melati Asri',
            'bank_sampah_id' => $petugas?->bank_sampah_id,
        ];

        $trashCategories = TrashCategory::active()
            ->when($petugas->bank_sampah_id, fn ($q) => $q->where('bank_sampah_id', $petugas->bank_sampah_id))
            ->get()
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'nama' => $c->nama,
                    'kategori' => $c->kategori ?? 'Umum',
                    'harga_per_kg' => (float) $c->harga_per_kg,
                    'satuan' => $c->satuan ?? 'kg',
                ];
            });

        $registeredNasabahs = User::role('nasabah')
            ->with('bankSampah')
            ->get()
            ->map(function ($u) use ($petugas) {
                return [
                    'id' => $u->id,
                    'name' => $u->name,
                    'email' => $u->email,
                    'avatar_url' => $u->avatar_url,
                    'phone' => $u->nomor_telepon ?? '-',
                    'virtual_account' => $u->virtual_account ?? '88020812' . str_pad($u->id, 4, '0', STR_PAD_LEFT),
                    'bank_sampah_name' => $u->bankSampah?->nama ?? 'Unit Melati Asri',
                    'bank_sampah_id' => $u->bank_sampah_id,
                    'is_followed_bank' => ($u->bank_sampah_id == $petugas?->bank_sampah_id),
                    'saldo' => (float) ($u->saldo ?? 0),
                ];
            });

        return view('petugas.self-deposit-form', compact(
            'authData',
            'trashCategories',
            'registeredNasabahs'
        ));
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

            $walletService = new \App\Services\WalletLedgerService();
            $petugasBankSampahId = auth()->user()->bank_sampah_id;
            $isFollowedBank = ($user->bank_sampah_id == $petugasBankSampahId);

            foreach ($items as $item) {
                $trashCategory = TrashCategory::findOrFail($item['trash_category_id']);
                $weight = (float) $item['berat_kg'];
                $hargaTotal = $weight * $trashCategory->harga_per_kg;

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'bank_sampah_id' => $petugasBankSampahId ?: $user->bank_sampah_id,
                    'petugas_id' => auth()->id(),
                    'trash_category_id' => $trashCategory->id,
                    'berat_kg' => $weight,
                    'harga_per_kg' => $trashCategory->harga_per_kg,
                    'total_rp' => $hargaTotal,
                    'tipe_setoran' => 'mandiri',
                    'status' => 'selesai',
                    'catatan' => $isFollowedBank ? 'Pembayaran Dompet Digital' : 'Pembayaran TUNAI / CASH di tempat (Luar Unit)',
                    'foto_bukti' => $fotoPath,
                ]);

                if ($isFollowedBank) {
                    // Record credit in digital wallet ledger if depositing to followed bank
                    $walletService->recordTransaction(
                        $user,
                        'credit',
                        $hargaTotal,
                        $petugasBankSampahId ?: $user->bank_sampah_id,
                        $transaction->id,
                        null,
                        'DEP-MAN-' . $transaction->id,
                        "Setoran sampah mandiri ({$trashCategory->nama} {$weight} kg)"
                    );
                } else {
                    // Deduct Unit Kas for Cash Outflow (COD)
                    if ($petugasBankSampahId) {
                        \App\Models\BankSampah::where('id', $petugasBankSampahId)->decrement('kas_unit', $hargaTotal);
                    }
                }

                $totalSaldo += $hargaTotal;
                $totalWeight += $weight;
                $totalPoints += $this->calculatePoints($trashCategory->nama, $weight);
            }

            $leaderboard = Leaderboard::firstOrCreate(
                ['user_id' => $user->id],
                ['total_poin_lingkungan' => 0, 'total_berat_kg' => 0, 'jumlah_transaksi' => 0]
            );

            $leaderboard->increment('total_poin_lingkungan', $totalPoints);
            $leaderboard->increment('total_berat_kg', $totalWeight);
            $leaderboard->increment('jumlah_transaksi', count($items));
        });

        $message = ($user->bank_sampah_id == auth()->user()->bank_sampah_id)
            ? 'Setoran mandiri berhasil diproses (Saldo digital nasabah bertambah).'
            : 'Setoran mandiri berhasil diproses. Pembayaran diselesaikan secara CASH TUNAI di tempat (Kas Unit berkurang, Poin Lingkungan nasabah bertambah).';

        return redirect()->route('petugas.dashboard')->with('success', $message);
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
