<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalNasabah = Cache::remember('admin.dashboard.total_nasabah', 600, fn () => User::role('nasabah')->count());
        $totalPetugas = Cache::remember('admin.dashboard.total_petugas', 600, fn () => User::role('petugas')->count());
        $totalTransaksi = Cache::remember('admin.dashboard.total_transaksi', 600, fn () => Transaction::count());
        $totalSampahKg = Cache::remember('admin.dashboard.total_sampah_kg', 600, fn () => Transaction::where('status', 'selesai')->sum('berat_kg'));

        $transaksiMingguIni = Cache::remember('admin.dashboard.transaksi_minggu_ini', 600, fn () => Transaction::where('status', 'selesai')
            ->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('berat_kg'));

        $pendingWithdrawals = Cache::remember('admin.dashboard.pending_withdrawals', 600, fn () => Withdrawal::where('status', 'pending')->count());

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
            'transaksiMingguIni',
            'pendingWithdrawals',
            'topContributors',
            'rtComparison',
            'monthlyTrend'
        ));
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

        DB::transaction(function () use ($withdrawal, $request) {
            if ($request->hasFile('foto_resi')) {
                $withdrawal->foto_resi = $request->file('foto_resi')->store('receipts', 'public');
            }

            $withdrawal->status = 'disetujui';
            $withdrawal->save();
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

        DB::transaction(function () use ($withdrawal, $validated) {
            $withdrawal->update([
                'status' => 'ditolak',
                'catatan_admin' => $validated['catatan_admin'],
            ]);

            $withdrawal->user->increment('saldo', $withdrawal->nominal);
        });

        return redirect()->route('admin.finance.validate')
            ->with('success', 'Pengajuan penarikan dana berhasil ditolak.');
    }

    public function configureRegion()
    {
        $rtList = Cache::remember('nasabah_rt_list', 86400, fn () => User::role('nasabah')
            ->selectRaw('DISTINCT rt')
            ->whereNotNull('rt')
            ->pluck('rt'));

        $rwList = Cache::remember('nasabah_rw_list', 86400, fn () => User::role('nasabah')
            ->selectRaw('DISTINCT rw')
            ->whereNotNull('rw')
            ->pluck('rw'));

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

        $response = new StreamedResponse(function () use ($query) {
            $handle = fopen('php://output', 'w');

            // Add BOM for Excel UTF-8 compatibility
            fwrite($handle, "\xEF\xBB\xBF");

            // Write Header
            fputcsv($handle, [
                'ID',
                'Nama Nasabah',
                'Kategori',
                'Berat (Kg)',
                'Harga/Kg',
                'Total (Rp)',
                'Tipe Setoran',
                'Tanggal',
            ]);

            // Chunk through the data to prevent memory exhaustion
            $query->chunk(500, function ($transactions) use ($handle) {
                foreach ($transactions as $transaction) {
                    fputcsv($handle, [
                        $transaction->id,
                        $transaction->user->name ?? '-',
                        $transaction->trashCategory->nama ?? '-',
                        $transaction->berat_kg,
                        $transaction->harga_per_kg,
                        $transaction->total_rp,
                        $transaction->tipe_setoran,
                        $transaction->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        });

        $filename = 'laporan_sisampah_'.now()->format('Y-m-d').'.csv';

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');

        return $response;
    }
}
