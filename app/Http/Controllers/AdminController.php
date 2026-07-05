<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use App\Models\TrashCategory;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalNasabah = User::role('nasabah')->count();
        $totalPetugas = User::role('petugas')->count();
        $totalTransaksi = Transaction::count();
        $totalSampahKg = Transaction::where('status', 'selesai')->sum('berat_kg');

        $transaksiHariIni = Transaction::where('status', 'selesai')
            ->whereDate('updated_at', today())
            ->sum('berat_kg');

        $pendingWithdrawals = Withdrawal::where('status', 'pending')->count();

        $topContributors = Leaderboard::orderByDesc('total_poin_lingkungan')
            ->with('user')
            ->take(10)
            ->get();

        $rtComparison = User::role('nasabah')
            ->selectRaw('rt, SUM(saldo) as total_saldo, COUNT(*) as jumlah_nasabah')
            ->groupBy('rt')
            ->get();

        $monthlyTrend = Transaction::where('status', 'selesai')
            ->selectRaw('MONTH(created_at) as bulan, SUM(berat_kg) as total_berat')
            ->groupBy('bulan')
            ->get();

        return view('admin.dashboard', compact(
            'totalNasabah',
            'totalPetugas',
            'totalTransaksi',
            'totalSampahKg',
            'transaksiHariIni',
            'pendingWithdrawals',
            'topContributors',
            'rtComparison',
            'monthlyTrend'
        ));
    }

    public function indexTrashPrice()
    {
        $categories = TrashCategory::all();
        return view('admin.trash-price.index', compact('categories'));
    }

    public function storeTrashPrice(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|unique:trash_categories,nama',
            'harga_per_kg' => 'required|numeric|min:100',
            'deskripsi' => 'nullable|string',
        ]);

        TrashCategory::create($validated);

        return redirect()->route('admin.trash_price.index')
            ->with('success', 'Kategori sampah berhasil ditambahkan.');
    }

    public function updateTrashPrice(Request $request, $id)
    {
        $category = TrashCategory::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|unique:trash_categories,nama,' . $id,
            'harga_per_kg' => 'required|numeric|min:100',
            'deskripsi' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('admin.trash_price.index')
            ->with('success', 'Harga sampah berhasil diperbarui.');
    }

    public function destroyTrashPrice($id)
    {
        $category = TrashCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.trash_price.index')
            ->with('success', 'Kategori sampah berhasil dihapus.');
    }

    public function validateFinance()
    {
        $withdrawals = Withdrawal::where('status', 'pending')
            ->with('user')
            ->latest()
            ->paginate(15);

        $approved = Withdrawal::where('status', 'disetujui')
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.finance.validate', compact('withdrawals', 'approved'));
    }

    public function approveWithdrawal(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        $validated = $request->validate([
            'foto_resi' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::transaction(function () use ($withdrawal, $validated, $request) {
            if ($request->hasFile('foto_resi')) {
                $withdrawal->foto_resi = $request->file('foto_resi')->store('receipts', 'public');
            }

            $withdrawal->status = 'disetujui';
            $withdrawal->save();

            $user = $withdrawal->user;
            $user->decrement('saldo', $withdrawal->nominal);
        });

        return redirect()->route('admin.finance.validate')
            ->with('success', 'Pengajuan penarikan dana berhasil disetujui.');
    }

    public function rejectWithdrawal(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        $validated = $request->validate([
            'catatan_admin' => 'required|string|max:500',
        ]);

        $withdrawal->update([
            'status' => 'ditolak',
            'catatan_admin' => $validated['catatan_admin'],
        ]);

        return redirect()->route('admin.finance.validate')
            ->with('success', 'Pengajuan penarikan dana berhasil ditolak.');
    }

    public function configureRegion()
    {
        $rtList = User::role('nasabah')
            ->selectRaw('DISTINCT rt')
            ->whereNotNull('rt')
            ->pluck('rt');

        $rwList = User::role('nasabah')
            ->selectRaw('DISTINCT rw')
            ->whereNotNull('rw')
            ->pluck('rw');

        return view('admin.region.configure', compact('rtList', 'rwList'));
    }

    public function reports(Request $request)
    {
        $query = Transaction::where('status', 'selesai')
            ->with('user', 'trashCategory');

        if ($request->filled('rt')) {
            $query->whereHas('user', fn ($q) => $q->where('rt', $request->rt));
        }

        if ($request->filled('rw')) {
            $query->whereHas('user', fn ($q) => $q->where('rw', $request->rw));
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transactions = $query->latest()->paginate(20);

        $rtList = User::role('nasabah')
            ->selectRaw('DISTINCT rt')
            ->whereNotNull('rt')
            ->pluck('rt');

        $rwList = User::role('nasabah')
            ->selectRaw('DISTINCT rw')
            ->whereNotNull('rw')
            ->pluck('rw');

        return view('admin.reports.index', compact('transactions', 'rtList', 'rwList'));
    }

    public function exportReports(Request $request)
    {
        $query = Transaction::where('status', 'selesai')
            ->with('user', 'trashCategory');

        if ($request->filled('rt')) {
            $query->whereHas('user', fn ($q) => $q->where('rt', $request->rt));
        }

        if ($request->filled('rw')) {
            $query->whereHas('user', fn ($q) => $q->where('rw', $request->rw));
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transactions = $query->get();

        $csv = "ID,Nama Nasabah,Kategori,Berat (Kg),Harga/Kg,Total (Rp),Tipe Setoran,Tanggal\n";

        foreach ($transactions as $transaction) {
            $csv .= "{$transaction->id},";
            $csv .= "{$transaction->user->name},";
            $csv .= "{$transaction->trashCategory->nama},";
            $csv .= "{$transaction->berat_kg},";
            $csv .= "{$transaction->harga_per_kg},";
            $csv .= "{$transaction->total_rp},";
            $csv .= "{$transaction->tipe_setoran},";
            $csv .= "{$transaction->created_at->format('Y-m-d H:i:s')}\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="laporan_sisampah_' . now()->format('Y-m-d') . '.csv"');
    }
}
