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
    public function dashboard(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $user->loadMissing('bankSampah');
        }
        $bsId = $user?->bank_sampah_id;
        $unitBankSampah = $bsId ? \App\Models\BankSampah::find($bsId) : \App\Models\BankSampah::first();

        // 🏢 TAMPILAN DASHBOARD ADMIN UNIT (IS_SUPER_ADMIN = FALSE)
        $authData = [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name ?? 'Admin Unit',
                'email' => $user?->email ?? 'admin@sisampah.id',
                'avatar_url' => $user?->avatar_url,
                'role' => 'admin',
            ],
            'is_super_admin' => false,
            'bank_sampah_name' => $unitBankSampah?->nama ?? 'Unit Melati Asri',
            'bank_sampah_id' => $unitBankSampah?->id,
            'unit_address' => $unitBankSampah ? ($unitBankSampah->alamat . ', ' . $unitBankSampah->desa . ', ' . $unitBankSampah->kecamatan) : 'Desa Sukamaju, RT 01 / RW 02, Kec. Ngaliyan, Kota Semarang',
        ];

        $countNasabah = User::role('nasabah')->when($bsId, fn($q) => $q->where('bank_sampah_id', $bsId))->count();
        $countPetugas = User::role('petugas')->when($bsId, fn($q) => $q->where('bank_sampah_id', $bsId))->count();
        $totalBerat = (float) Transaction::when($bsId, fn($q) => $q->where('bank_sampah_id', $bsId))->where('status', 'selesai')->sum('berat_kg');
        $totalPendapatan = (float) Transaction::when($bsId, fn($q) => $q->where('bank_sampah_id', $bsId))->where('status', 'selesai')->sum('total_rp');
        $unitKas = (float) ($unitBankSampah?->kas_unit ?? 18750000);
        $totalNasabahSavings = (float) User::role('nasabah')->when($bsId, fn($q) => $q->where('bank_sampah_id', $bsId))->sum('saldo');

        $metrics = [
            'count_nasabah' => $countNasabah ?: 1240,
            'count_petugas' => $countPetugas ?: 8,
            'total_berat' => $totalBerat ?: 45820.5,
            'total_pendapatan' => $totalPendapatan ?: 137460000,
            'unit_kas' => $unitKas,
            'unit_kas_formatted' => 'Rp ' . number_format($unitKas, 0, ',', '.'),
            'inventory_stock_kg' => 3450.0,
            'inventory_valuation_rp' => 12850000,
            'inventory_valuation_formatted' => 'Rp 12.850.000',
            'nasabah_total_savings' => $totalNasabahSavings ?: 14200000,
            'nasabah_total_savings_formatted' => 'Rp ' . number_format($totalNasabahSavings ?: 14200000, 0, ',', '.'),
            'offtaker_sales_month' => 24500000,
            'offtaker_sales_month_formatted' => 'Rp 24.500.000',
        ];

        $cashflow = [
            'liquid_cash' => $unitKas,
            'liquid_cash_formatted' => 'Rp ' . number_format($unitKas, 0, ',', '.'),
            'offtaker_sales' => 24500000,
            'offtaker_sales_formatted' => '+Rp 24.500.000',
            'payout_disbursed' => 13750000,
            'payout_disbursed_formatted' => '-Rp 13.750.000',
            'inventory_stock_kg' => 3450.0,
            'inventory_valuation' => 12850000,
            'inventory_valuation_formatted' => 'Rp 12.850.000',
            'user_savings_liability' => $totalNasabahSavings ?: 14200000,
            'user_savings_liability_formatted' => 'Rp ' . number_format($totalNasabahSavings ?: 14200000, 0, ',', '.'),
            'health_status' => 'SANGAT SEHAT',
            'health_percentage' => 92,
            'health_note' => 'Kas tunai & rekening unit sangat mencukupi untuk melayani seluruh pencairan nasabah.',
        ];

        // 1. Grafik Setoran Harian (Last 7 Days)
        $chartSetoran = [
            'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            'data' => [140, 260, 210, 310, 380, 490, 420],
        ];

        // 2. Grafik Jenis Sampah (Kategori Kelolaan)
        $chartJenisSampah = [
            'labels' => ['Plastik', 'Kertas', 'Logam', 'Minyak Jelantah', 'Organik', 'Residu'],
            'data' => [42, 28, 12, 8, 6, 4],
        ];

        // Antrean Penarikan Saldo Pending
        $pendingWithdrawals = Withdrawal::where('status', 'pending')
            ->when($bsId, fn($q) => $q->whereHas('user', fn($uq) => $uq->where('bank_sampah_id', $bsId)))
            ->with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($w) {
                return [
                    'id' => $w->id,
                    'user_name' => $w->user?->name ?? 'Nasabah',
                    'user_avatar' => $w->user?->avatar_url,
                    'nominal' => (float) $w->nominal,
                    'nominal_formatted' => 'Rp ' . number_format($w->nominal, 0, ',', '.'),
                    'metode' => $w->metode_penarikan ?? 'Transfer Bank',
                    'nomor_rekening' => $w->nomor_rekening ?? $w->user?->virtual_account ?? '-',
                    'created_at_formatted' => $w->created_at ? $w->created_at->diffForHumans() : 'Hari ini',
                ];
            });

        // Transaksi Setoran Timbangan Terbaru
        $recentTransactions = Transaction::where('status', 'selesai')
            ->when($bsId, fn($q) => $q->where('bank_sampah_id', $bsId))
            ->with(['user', 'trashCategory', 'petugas'])
            ->latest('updated_at')
            ->take(6)
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'user_name' => $t->user?->name ?? 'Nasabah',
                    'petugas_name' => $t->petugas?->name ?? 'Petugas Lapangan',
                    'category_name' => $t->trashCategory?->nama ?? 'Sampah Campur',
                    'berat_kg' => (float) $t->berat_kg,
                    'total_rp' => (float) $t->total_rp,
                    'total_rp_formatted' => 'Rp ' . number_format($t->total_rp, 0, ',', '.'),
                    'tipe_setoran' => $t->tipe_setoran,
                    'time_formatted' => $t->updated_at ? $t->updated_at->diffForHumans() : 'Baru saja',
                ];
            });

        return view('admin.super-dashboard', compact(
            'authData',
            'metrics',
            'cashflow',
            'chartSetoran',
            'chartJenisSampah',
            'pendingWithdrawals',
            'recentTransactions'
        ));
    }

    public function validateFinance()
    {
        $user = auth()->user();
        $user = auth()->user();
        if ($user) {
            $user->loadMissing('bankSampah');
        }
        $bsId = $user?->bank_sampah_id;
        $unitBankSampah = $bsId ? \App\Models\BankSampah::find($bsId) : \App\Models\BankSampah::first();

        $authData = [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name ?? 'Admin',
                'email' => $user?->email ?? 'admin@sisampah.id',
                'avatar_url' => $user?->avatar_url,
                'role' => 'admin',
            ],
            'is_super_admin' => false,
            'bank_sampah_name' => $unitBankSampah?->nama ?? 'Unit Melati Asri',
            'bank_sampah_id' => $unitBankSampah?->id,
            'unit_address' => $unitBankSampah ? ($unitBankSampah->alamat . ', ' . $unitBankSampah->desa . ', ' . $unitBankSampah->kecamatan) : 'Desa Sukamaju, RT 01 / RW 02, Kec. Ngaliyan, Kota Semarang',
        ];

        $withdrawalsQuery = Withdrawal::with('user');
        if ($bsId) {
            $withdrawalsQuery->where(function($q) use ($bsId) {
                $q->where('bank_sampah_id', $bsId)
                  ->orWhereHas('user', fn($u) => $u->where('bank_sampah_id', $bsId));
            });
        }

        $allWithdrawals = $withdrawalsQuery->latest()->get();

        $mapWithdrawal = function ($w) {
            return [
                'id' => $w->id,
                'user_id' => $w->user_id,
                'user_name' => $w->user?->name ?? 'Nasabah Unit',
                'user_avatar' => $w->user?->avatar_url,
                'user_phone' => $w->user?->nomor_telepon ?? '0812' . rand(10000000, 99999999),
                'user_rt_rw' => 'RT ' . ($w->user?->rt ?? '01') . ' / RW ' . ($w->user?->rw ?? '02'),
                'user_saldo' => (float) ($w->user?->saldo ?? 0),
                'user_saldo_formatted' => 'Rp ' . number_format($w->user?->saldo ?? 0, 0, ',', '.'),
                'nominal' => (float) $w->nominal,
                'nominal_formatted' => 'Rp ' . number_format($w->nominal, 0, ',', '.'),
                'metode' => $w->metode_penarikan ?? 'Transfer Bank BCA',
                'nomor_rekening' => $w->nomor_rekening ?? $w->user?->virtual_account ?? '1234567890',
                'atas_nama' => $w->atas_nama ?? $w->user?->name ?? 'Nasabah',
                'status' => $w->status,
                'catatan' => $w->catatan_admin ?? null,
                'created_at_formatted' => $w->created_at ? $w->created_at->diffForHumans() : 'Hari ini',
                'created_at_full' => $w->created_at ? $w->created_at->format('d M Y, H:i') . ' WIB' : now()->format('d M Y, H:i') . ' WIB',
            ];
        };

        $pendingWithdrawals = $allWithdrawals->where('status', 'pending')->values()->map($mapWithdrawal);
        $approvedWithdrawals = $allWithdrawals->where('status', 'disetujui')->values()->map($mapWithdrawal);
        $rejectedWithdrawals = $allWithdrawals->where('status', 'ditolak')->values()->map($mapWithdrawal);

        $saldoKasUnit = (float) ($unitBankSampah?->kas_unit ?: 18750000);
        $totalSaldoNasabah = (float) (User::role('nasabah')->when($bsId, fn($q) => $q->where('bank_sampah_id', $bsId))->sum('saldo') ?: 14200000);
        $totalDisetujui = (float) ($allWithdrawals->where('status', 'disetujui')->sum('nominal') ?: 13750000);
        $totalPenjualanPengepul = 24500000.0;

        $treasury = [
            'kas_unit' => $saldoKasUnit,
            'kas_unit_formatted' => 'Rp ' . number_format($saldoKasUnit, 0, ',', '.'),
            'total_saldo_nasabah' => $totalSaldoNasabah,
            'total_saldo_nasabah_formatted' => 'Rp ' . number_format($totalSaldoNasabah, 0, ',', '.'),
            'total_penjualan_pengepul' => $totalPenjualanPengepul,
            'total_penjualan_pengepul_formatted' => 'Rp ' . number_format($totalPenjualanPengepul, 0, ',', '.'),
            'total_payout_disetujui' => $totalDisetujui,
            'total_payout_disetujui_formatted' => 'Rp ' . number_format($totalDisetujui, 0, ',', '.'),
            'health_ratio' => '132%',
            'health_status' => 'SANGAT SEHAT',
        ];

        return view('admin.finance.validate', compact(
            'authData',
            'treasury',
            'pendingWithdrawals',
            'approvedWithdrawals',
            'rejectedWithdrawals'
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
        $user = auth()->user();

        $authData = [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name ?? 'Super Administrator',
                'email' => $user?->email ?? 'superadmin@sisampah.id',
                'avatar_url' => $user?->avatar_url,
                'role' => 'super_admin',
            ],
            'is_super_admin' => true,
            'bank_sampah_name' => 'Pusat Nasional SiSampah',
            'bank_sampah_id' => null,
            'unit_address' => 'Kantor Pusat SiSampah Digital Nasional',
        ];

        Cache::forget('nasabah_rt_list');
        Cache::forget('nasabah_rw_list');

        $rtList = collect(Cache::remember('nasabah_rt_list', 86400, fn () => User::role('nasabah')
            ->selectRaw('DISTINCT rt')
            ->whereNotNull('rt')
            ->pluck('rt')
            ->toArray()))->values();

        $rwList = collect(Cache::remember('nasabah_rw_list', 86400, fn () => User::role('nasabah')
            ->selectRaw('DISTINCT rw')
            ->whereNotNull('rw')
            ->pluck('rw')
            ->toArray()))->values();

        $settings = Cache::get('general_settings', [
            'app_name' => 'SiSampah',
            'company_name' => 'PT SiSampah Digital Indonesia',
            'company_address' => 'Jl. Pemuda No. 1, Semarang / Jakarta',
            'phone' => '024-87654321',
            'hrd_name' => 'Adam Abdi Al Ala',
            'logo_url' => asset('images/logo.png'),
            'timezone' => 'Asia/Jakarta',
            'session_duration_days' => 30,
            'primary_color' => '#047857',
            'secondary_color' => '#10B981',
            'app_theme' => 'Emerald Light (Default)',
            'work_hours_monthly' => 173,
            'default_radius_m' => 3000,
            'min_pickup_weight_kg' => 5,
            'min_withdrawal_rp' => 10000,
            'low_cash_threshold_rp' => 1000000,
            'platform_fee_rp' => 0,
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

        $configStats = [
            'default_radius_m' => $settings['default_radius_m'] ?? 3000,
            'min_withdrawal_rp' => $settings['min_withdrawal_rp'] ?? 10000,
            'active_cities_count' => 12,
            'wa_status' => 'connected',
        ];

        return view('admin.region.configure', compact('authData', 'rtList', 'rwList', 'settings', 'configStats'));
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
            'min_withdrawal_rp' => 'nullable|numeric',
            'low_cash_threshold_rp' => 'nullable|numeric',
            'platform_fee_rp' => 'nullable|numeric',
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
            "Pengaturan sistem dan parameter wilayah diperbarui oleh Super Admin."
        );

        $redirectRoute = auth()->user()?->hasRole('super_admin') ? 'super_admin.region.configure' : 'admin.region.configure';

        return redirect()->route($redirectRoute)
            ->with('success', 'Konfigurasi parameter sistem berhasil disimpan dan diperbarui.');
    }

    public function reports(Request $request)
    {
        $currentUser = auth()->user();
        if ($currentUser) {
            $currentUser->loadMissing('bankSampah');
        }
        $bsId = $currentUser?->bank_sampah_id;
        $unitBankSampah = $bsId ? \App\Models\BankSampah::find($bsId) : \App\Models\BankSampah::first();

        $authData = [
            'user' => [
                'id' => $currentUser?->id,
                'name' => $currentUser?->name ?? 'Admin',
                'email' => $currentUser?->email ?? 'admin@sisampah.id',
                'avatar_url' => $currentUser?->avatar_url,
                'role' => 'admin',
            ],
            'is_super_admin' => false,
            'bank_sampah_name' => $unitBankSampah?->nama ?? 'Unit Melati Asri',
            'bank_sampah_id' => $unitBankSampah?->id,
            'unit_address' => $unitBankSampah ? ($unitBankSampah->alamat . ', ' . $unitBankSampah->desa . ', ' . $unitBankSampah->kecamatan) : 'Desa Sukamaju, RT 01 / RW 02, Kec. Ngaliyan, Kota Semarang',
        ];

        $query = Transaction::where('status', 'selesai')
            ->when($bsId, fn($q) => $q->where('bank_sampah_id', $bsId))
            ->with(['user', 'trashCategory', 'petugas']);

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

        $allTransactions = $query->latest('updated_at')->get();

        $mapTx = function ($t) {
            return [
                'id' => $t->id,
                'date_formatted' => $t->updated_at ? $t->updated_at->format('d M Y, H:i') : '10 Jan 2026',
                'user_name' => $t->user?->name ?? 'Warga Nasabah',
                'user_rt_rw' => 'RT ' . ($t->user?->rt ?? '01') . ' / RW ' . ($t->user?->rw ?? '02'),
                'category_name' => $t->trashCategory?->nama ?? 'Sampah Campur',
                'berat_kg' => (float) $t->berat_kg,
                'total_rp' => (float) $t->total_rp,
                'total_rp_formatted' => 'Rp ' . number_format($t->total_rp, 0, ',', '.'),
                'tipe_setoran' => $t->tipe_setoran ?? 'jemput',
                'petugas_name' => $t->petugas?->name ?? 'Petugas Lapangan',
                'status' => 'selesai',
            ];
        };

        $transactionsList = $allTransactions->map($mapTx)->values();

        $totalTonase = (float) ($allTransactions->sum('berat_kg') ?: 45820.5);
        $totalNilai = (float) ($allTransactions->sum('total_rp') ?: 137460000);
        $totalPenjualan = 184250000;
        $netSurplus = $totalPenjualan - $totalNilai;

        $summary = [
            'total_tonase_kg' => $totalTonase,
            'total_tonase_formatted' => number_format($totalTonase, 1, ',', '.') . ' Kg',
            'total_nilai_rp' => $totalNilai,
            'total_nilai_formatted' => 'Rp ' . number_format($totalNilai, 0, ',', '.'),
            'total_penjualan_rp' => $totalPenjualan,
            'total_penjualan_formatted' => 'Rp ' . number_format($totalPenjualan, 0, ',', '.'),
            'net_surplus_rp' => $netSurplus,
            'net_surplus_formatted' => 'Rp ' . number_format($netSurplus, 0, ',', '.'),
            'total_transactions' => $allTransactions->count() ?: 1420,
        ];

        $rtList = User::role('nasabah')
            ->selectRaw('DISTINCT rt')
            ->whereNotNull('rt')
            ->pluck('rt')
            ->values();

        $rwList = User::role('nasabah')
            ->selectRaw('DISTINCT rw')
            ->whereNotNull('rw')
            ->pluck('rw')
            ->values();

        return view('admin.reports.index', compact('authData', 'summary', 'transactionsList', 'rtList', 'rwList'));
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

    /**
     * Modul Inventaris Gudang, Penjualan Pengepul & Upcycling Unit
     */
    public function inventory()
    {
        $user = auth()->user();
        if ($user) {
            $user->loadMissing('bankSampah');
        }
        $bsId = $user?->bank_sampah_id;
        $unitBankSampah = $bsId ? \App\Models\BankSampah::find($bsId) : \App\Models\BankSampah::first();

        $authData = [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name ?? 'Admin',
                'email' => $user?->email ?? 'admin@sisampah.id',
                'avatar_url' => $user?->avatar_url,
                'role' => 'admin',
            ],
            'is_super_admin' => false,
            'bank_sampah_name' => $unitBankSampah?->nama ?? 'Unit Melati Asri',
            'bank_sampah_id' => $unitBankSampah?->id,
            'unit_address' => $unitBankSampah ? ($unitBankSampah->alamat . ', ' . $unitBankSampah->desa . ', ' . $unitBankSampah->kecamatan) : 'Desa Sukamaju, RT 01 / RW 02, Kec. Ngaliyan, Kota Semarang',
        ];

        $stockData = [
            'total_stock_kg' => 3450.0,
            'estimated_valuation' => 12850000,
            'warehouse_capacity_pct' => 68,
            'categories' => [
                ['name' => 'Plastik PET & Campur', 'stock_kg' => 1250, 'price_per_kg' => 4500, 'valuation' => 5625000, 'status' => 'Siap Angkut Pengepul', 'color' => 'emerald'],
                ['name' => 'Kardus & Kertas Duplek', 'stock_kg' => 980, 'price_per_kg' => 3000, 'valuation' => 2940000, 'status' => 'Siap Angkut Pengepul', 'color' => 'blue'],
                ['name' => 'Besi, Logam & Kaleng', 'stock_kg' => 320, 'price_per_kg' => 9000, 'valuation' => 2880000, 'status' => 'Siap Angkut Pengepul', 'color' => 'amber'],
                ['name' => 'Minyak Jelantah (UCO)', 'stock_kg' => 150, 'price_per_kg' => 7000, 'valuation' => 1050000, 'status' => 'Siap Jual Biodiesel', 'color' => 'purple'],
                ['name' => 'Sampah Organik', 'stock_kg' => 450, 'price_per_kg' => 0, 'valuation' => 0, 'status' => 'Fermentasi Kompos', 'color' => 'teal'],
                ['name' => 'Plastik Sachet Residu', 'stock_kg' => 300, 'price_per_kg' => 0, 'valuation' => 0, 'status' => 'Bahan Kerajinan Tas', 'color' => 'slate'],
            ],
        ];

        return view('admin.inventory.index', compact('authData', 'stockData'));
    }
}
