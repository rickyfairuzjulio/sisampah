<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use App\Core\Services\MidtransService;
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

        $driver = DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            $bulanExpr = "CAST(strftime('%m', created_at) AS INTEGER)";
        } elseif ($driver === 'pgsql') {
            $bulanExpr = "EXTRACT(MONTH FROM created_at)::INTEGER";
        } else {
            $bulanExpr = "MONTH(created_at)";
        }

        $monthlyTrend = Transaction::where('status', 'selesai')
            ->selectRaw("{$bulanExpr} as bulan, SUM(berat_kg) as total_berat")
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
        $user = auth()->user();
        $bsId = $user->bank_sampah_id;

        $withdrawalsQuery = Withdrawal::with('user');
        $approvedQuery = Withdrawal::where('status', 'disetujui')->with('user');

        if ($bsId) {
            $withdrawalsQuery->where(function($q) use ($bsId) {
                $q->where('bank_sampah_id', $bsId)
                  ->orWhereHas('user', fn($u) => $u->where('bank_sampah_id', $bsId));
            });
            $approvedQuery->where(function($q) use ($bsId) {
                $q->where('bank_sampah_id', $bsId)
                  ->orWhereHas('user', fn($u) => $u->where('bank_sampah_id', $bsId));
            });
        }

        $withdrawals = $withdrawalsQuery->where('status', 'pending')
            ->latest()
            ->paginate(15);

        $approved = $approvedQuery->latest()
            ->take(10)
            ->get();

        // Financial Treasury Metrics for Unit or Global
        if ($bsId) {
            $unitBankSampah = \App\Models\BankSampah::find($bsId);
            $totalSaldoNasabah = User::role('nasabah')->where('bank_sampah_id', $bsId)->sum('saldo');
            $totalSetoran = Transaction::where('bank_sampah_id', $bsId)->where('status', 'selesai')->sum('total_rp');
            $totalDisetujui = Withdrawal::where('bank_sampah_id', $bsId)->where('status', 'disetujui')->sum('nominal');
            $saldoKasPusat = $unitBankSampah?->kas_unit ?? 0;
        } else {
            $totalSaldoNasabah = User::role('nasabah')->sum('saldo');
            $totalSetoran = Transaction::where('status', 'selesai')->sum('total_rp');
            $totalDisetujui = Withdrawal::where('status', 'disetujui')->sum('nominal');
            $kasTambahan = Cache::get('kas_tambahan_pusat', 50000000);
            $saldoKasPusat = $kasTambahan + $totalSetoran - $totalDisetujui;
        }

        return view('admin.finance.validate', compact(
            'withdrawals',
            'approved',
            'saldoKasPusat',
            'totalSaldoNasabah',
            'totalSetoran',
            'totalDisetujui'
        ));
    }

    public function topupKas(Request $request)
    {
        $user = auth()->user();
        $bsId = $user->bank_sampah_id;

        $validated = $request->validate([
            'nominal' => 'required|numeric|min:10000',
            'sumber_dana' => 'required|string|max:255',
            'catatan' => 'nullable|string|max:500',
        ]);

        if ($bsId) {
            $bankSampah = \App\Models\BankSampah::findOrFail($bsId);
            $bankSampah->increment('kas_unit', $validated['nominal']);
            return redirect()->route('admin.finance.validate')
                ->with('success', "Berhasil menambahkan Kas Unit '{$bankSampah->nama}' sebesar Rp " . number_format($validated['nominal'], 0, ',', '.'));
        }

        $currentKas = Cache::get('kas_tambahan_pusat', 50000000);
        Cache::put('kas_tambahan_pusat', $currentKas + $validated['nominal'], 86400 * 365);

        return redirect()->route('admin.finance.validate')
            ->with('success', 'Berhasil menambahkan Kas Utama Bank Sampah Pusat sebesar Rp ' . number_format($validated['nominal'], 0, ',', '.'));
    }

    private function checkWithdrawalAccess(Withdrawal $withdrawal): void
    {
        $user = auth()->user();
        if ($user->bank_sampah_id) {
            $bsId = $withdrawal->bank_sampah_id ?: $withdrawal->user?->bank_sampah_id;
            if ($bsId != $user->bank_sampah_id) {
                abort(403, 'Anda tidak berhak memproses penarikan dana dari Bank Sampah Unit lain.');
            }
        }
    }

    public function approveWithdrawal(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $this->checkWithdrawalAccess($withdrawal);

        $validated = $request->validate([
            'foto_resi' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        DB::transaction(function () use ($withdrawal, $request) {
            if ($request->hasFile('foto_resi')) {
                $path = $request->file('foto_resi')->store('receipts', 'public');
                $withdrawal->foto_resi = $path;
                $withdrawal->bukti_mutasi = $path;
            }

            $withdrawal->status = 'disetujui';
            $withdrawal->status_penerimaan = 'pending';
            $withdrawal->save();

            // Deduct Unit Kas
            $bsId = $withdrawal->bank_sampah_id ?: $withdrawal->user?->bank_sampah_id;
            if ($bsId) {
                \App\Models\BankSampah::where('id', $bsId)->decrement('kas_unit', $withdrawal->nominal);
            }
        });

        return redirect()->route('admin.finance.validate')
            ->with('success', 'Pengajuan penarikan dana berhasil disetujui dan bukti mutasi berhasil dikirim ke nasabah.');
    }

    public function approveWithdrawalWithGateway(Request $request, $id, MidtransService $midtransService)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $this->checkWithdrawalAccess($withdrawal);

        if ($withdrawal->status !== 'pending') {
            return redirect()->route('admin.finance.validate')
                ->with('error', 'Pengajuan penarikan ini sudah diproses.');
        }

        DB::transaction(function () use ($withdrawal, $midtransService) {
            // Trigger simulated disbursement
            $payoutResult = $midtransService->simulateDisbursement(
                $withdrawal->id,
                (float) $withdrawal->nominal,
                $withdrawal->metode,
                $withdrawal->rekening_tujuan ?? 'TUNAI'
            );

            // Record transaction details in admin notes
            $withdrawal->status = 'disetujui';
            $withdrawal->status_penerimaan = 'pending';
            $withdrawal->catatan_admin = "Diproses otomatis via Gateway. Ref: {$payoutResult['reference_no']}, ID: {$payoutResult['transaction_id']}";
            $withdrawal->save();

            // Deduct Unit Kas
            $bsId = $withdrawal->bank_sampah_id ?: $withdrawal->user?->bank_sampah_id;
            if ($bsId) {
                \App\Models\BankSampah::where('id', $bsId)->decrement('kas_unit', $withdrawal->nominal);
            }
        });

        return redirect()->route('admin.finance.validate')
            ->with('success', 'Pengajuan penarikan dana berhasil dicairkan secara instan via Payment Gateway.');
    }

    public function rejectWithdrawal(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $this->checkWithdrawalAccess($withdrawal);

        $validated = $request->validate([
            'catatan_admin' => 'required|string|max:500',
        ]);

        DB::transaction(function () use ($withdrawal, $validated) {
            $withdrawal->update([
                'status' => 'ditolak',
                'catatan_admin' => $validated['catatan_admin'],
            ]);

            // Reverse withdrawal hold via WalletLedgerService
            $walletService = new \App\Services\WalletLedgerService();
            $walletService->recordTransaction(
                $withdrawal->user,
                'withdrawal_reversal',
                (float) $withdrawal->nominal,
                $withdrawal->bank_sampah_id,
                null,
                $withdrawal->id,
                'REV-' . $withdrawal->id,
                "Pengembalian saldo karena penarikan dana ID #{$withdrawal->id} ditolak. Alasan: " . $validated['catatan_admin']
            );
        });

        return redirect()->route('admin.finance.validate')
            ->with('success', 'Pengajuan penarikan dana berhasil ditolak dan saldo dikembalikan.');
    }

    public function configureRegion()
    {
        Cache::forget('nasabah_rt_list');
        Cache::forget('nasabah_rw_list');

        $rtList = collect(Cache::remember('nasabah_rt_list', 86400, fn () => User::role('nasabah')
            ->selectRaw('DISTINCT rt')
            ->whereNotNull('rt')
            ->pluck('rt')
            ->toArray()));

        $rwList = collect(Cache::remember('nasabah_rw_list', 86400, fn () => User::role('nasabah')
            ->selectRaw('DISTINCT rw')
            ->whereNotNull('rw')
            ->pluck('rw')
            ->toArray()));

        $settings = Cache::get('general_settings', [
            'app_name' => 'SiSampah',
            'company_name' => 'PT SiSampah Digital Indonesia',
            'company_address' => 'Jl. Pemuda No. 1, Jakarta / Bogor',
            'phone' => '021-5551234',
            'hrd_name' => 'Adam Abdi Al Ala',
            'logo_url' => asset('images/logo.png'),
            'timezone' => 'Asia/Jakarta',
            'session_duration_days' => 30,
            'primary_color' => '#041A12',
            'secondary_color' => '#10B981',
            'app_theme' => 'Green (Default)',
            'work_hours_monthly' => 173,
            'default_radius_m' => 3000,
            'min_pickup_weight_kg' => 5,
            'toggles' => [
                'id_card' => true,
                'dokumen' => true,
                'slip_gaji' => true,
                'kunjungan' => true,
                'pelanggaran' => true,
                'reimbursement' => true,
                'tukar_sampah' => true,
                'project_ai' => true,
                'hak_akses' => true,
            ],
            'cloud_id' => 'CLOUD-SISAMPAH-9921',
            'api_key' => 'sk_live_sisampah_8819231',
            'wa_provider' => 'Fonnte (Official)',
            'wa_api_key' => 'fonnte_key_live_772183',
        ]);

        return view('admin.region.configure', compact('rtList', 'rwList', 'settings'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'phone' => 'required|string|max:50',
            'hrd_name' => 'required|string|max:255',
            'timezone' => 'required|string',
            'session_duration_days' => 'required|integer|min:1|max:365',
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
            'app_theme' => 'required|string',
            'work_hours_monthly' => 'required|integer',
            'default_radius_m' => 'required|integer',
            'min_pickup_weight_kg' => 'required|numeric',
            'cloud_id' => 'nullable|string',
            'api_key' => 'nullable|string',
            'wa_provider' => 'nullable|string',
            'wa_api_key' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $currentSettings = Cache::get('general_settings', []);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('settings', 'public');
            $validated['logo_url'] = asset('storage/' . $logoPath);
        } else {
            $validated['logo_url'] = $currentSettings['logo_url'] ?? asset('images/logo.png');
        }

        // Toggles
        $validated['toggles'] = [
            'id_card' => $request->has('toggle_id_card'),
            'dokumen' => $request->has('toggle_dokumen'),
            'slip_gaji' => $request->has('toggle_slip_gaji'),
            'kunjungan' => $request->has('toggle_kunjungan'),
            'pelanggaran' => $request->has('toggle_pelanggaran'),
            'reimbursement' => $request->has('toggle_reimbursement'),
            'tukar_sampah' => $request->has('toggle_tukar_sampah'),
            'project_ai' => $request->has('toggle_project_ai'),
            'hak_akses' => $request->has('toggle_hak_akses'),
        ];

        Cache::forever('general_settings', array_merge($currentSettings, $validated));

        \App\Services\AuditLogger::log(
            'GENERAL_SETTINGS_UPDATED',
            'SystemSetting',
            1,
            $currentSettings,
            $validated,
            "Pengaturan sistem General Settings diperbarui oleh Admin."
        );

        return redirect()->route('admin.region.configure')
            ->with('success', 'Pengaturan sistem berhasil disimpan.');
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
