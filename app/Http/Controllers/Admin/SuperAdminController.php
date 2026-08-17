<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankSampah;
use App\Models\Transaction;
use App\Models\User;
use App\Models\ScanLog;
use App\Models\TrashCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    /**
     * Dashboard Utama Super Admin dengan Metrik, 5 Grafik Visual & Top 10 Bank Sampah.
     */
    public function dashboard()
    {
        $user = auth()->user();
        $isSuperAdmin = $user->hasRole('super_admin') || empty($user->bank_sampah_id);
        $bsId = $user->bank_sampah_id;

        // Metric Counters (Scoped for Admin Unit, Global for Super Admin)
        if ($isSuperAdmin) {
            $metrics = [
                'count_bank_sampah' => BankSampah::where('status', 'aktif')->count(),
                'count_admin' => User::role('admin')->count(),
                'count_petugas' => User::role('petugas')->count(),
                'count_nasabah' => User::role('nasabah')->count(),
                'count_transaksi' => Transaction::count(),
                'count_pickup' => DB::table('transactions')->where('tipe_setoran', 'jemput')->count(),
                'total_berat' => Transaction::where('status', 'selesai')->sum('berat_kg') ?: 0,
                'total_pendapatan' => Transaction::where('status', 'selesai')->sum('total_rp') ?: 0,
            ];
        } else {
            $unitBankSampah = BankSampah::find($bsId);
            $metrics = [
                'count_bank_sampah' => 1,
                'count_admin' => User::role('admin')->where('bank_sampah_id', $bsId)->count(),
                'count_petugas' => User::role('petugas')->where('bank_sampah_id', $bsId)->count(),
                'count_nasabah' => User::role('nasabah')->where('bank_sampah_id', $bsId)->count(),
                'count_transaksi' => Transaction::where('bank_sampah_id', $bsId)->count(),
                'count_pickup' => Transaction::where('bank_sampah_id', $bsId)->where('tipe_setoran', 'jemput')->count(),
                'total_berat' => Transaction::where('bank_sampah_id', $bsId)->where('status', 'selesai')->sum('berat_kg') ?: 0,
                'total_pendapatan' => Transaction::where('bank_sampah_id', $bsId)->where('status', 'selesai')->sum('total_rp') ?: 0,
                'unit_nama' => $unitBankSampah?->nama ?? 'Unit Bank Sampah',
                'unit_alamat' => $unitBankSampah?->alamat ?? '-',
                'unit_rt_rw' => 'RT ' . ($unitBankSampah?->rt ?? '01') . ' / RW ' . ($unitBankSampah?->rw ?? '01'),
                'unit_desa' => $unitBankSampah?->desa ?? '-',
                'unit_kecamatan' => $unitBankSampah?->kecamatan ?? '-',
                'unit_kabupaten' => $unitBankSampah?->kabupaten ?? '-',
                'unit_kas' => $unitBankSampah?->kas_unit ?? 0,
            ];
        }

        // 1. Grafik Setoran Harian (Last 7 Days)
        $chartSetoran = [
            'labels' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            'data' => [120, 230, 180, 290, 340, 420, 390],
        ];

        // 2. Grafik Penjemputan (Status)
        $chartPenjemputan = [
            'labels' => ['Selesai', 'Dalam Proses', 'Dibatalkan', 'Menunggu'],
            'data' => [145, 32, 8, 19],
        ];

        // 3. Grafik Pendapatan Bulanan (6 Bulan Terakhir)
        $chartPendapatan = [
            'labels' => ['Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
            'data' => [12500000, 15800000, 18200000, 21400000, 24800000, 29500000],
        ];

        // 4. Grafik Jenis Sampah (Kategori)
        $chartJenisSampah = [
            'labels' => ['Plastik', 'Kertas', 'Logam', 'Kaca', 'Organik', 'Elektronik', 'Tekstil'],
            'data' => [42, 28, 12, 8, 5, 3, 2],
        ];

        // 5. Grafik Pengurangan Emisi CO2 (kg)
        $chartCO2 = [
            'labels' => ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
            'data' => [450, 780, 1120, 1560],
        ];

        // Top 10 Bank Sampah Terbaik
        $topQuery = BankSampah::withCount(['nasabah', 'petugas']);
        if (!$isSuperAdmin && $bsId) {
            $topQuery->where('id', $bsId);
        }

        $topBankSampahs = $topQuery->get()
            ->map(function ($bs) {
                $userIds = $bs->users()->pluck('id');
                $bs->total_pendapatan = \App\Models\Transaction::whereIn('user_id', $userIds)->where('status', 'selesai')->sum('total_rp');
                $bs->total_berat = \App\Models\Transaction::whereIn('user_id', $userIds)->where('status', 'selesai')->sum('berat_kg');
                return $bs;
            })
            ->sortByDesc('total_pendapatan')
            ->take(10)
            ->values();

        $allBankSampahs = BankSampah::all(['id', 'nama', 'kode_bank', 'latitude', 'longitude', 'radius_layanan', 'alamat', 'telepon', 'email', 'jam_buka', 'jam_tutup']);

        return view('admin.super-dashboard', compact(
            'metrics', 'chartSetoran', 'chartPenjemputan', 'chartPendapatan',
            'chartJenisSampah', 'chartCO2', 'topBankSampahs', 'isSuperAdmin', 'allBankSampahs'
        ));
    }

    /**
     * Master Admin Bank Sampah Unit
     */
    public function masterAdmins(Request $request)
    {
        $admins = User::role('admin')->with('bankSampah')->paginate(15);
        $bankSampahs = BankSampah::all();
        return view('admin.master.admins', compact('admins', 'bankSampahs'));
    }

    /**
     * Master Petugas Penjemputan / Timbangan
     */
    public function masterPetugas(Request $request)
    {
        $petugas = User::role('petugas')->with('bankSampah')->paginate(15);
        $bankSampahs = BankSampah::all();
        return view('admin.master.petugas', compact('petugas', 'bankSampahs'));
    }

    /**
     * Master Nasabah
     */
    public function masterNasabah(Request $request)
    {
        $nasabah = User::role('nasabah')->with('bankSampah')->paginate(15);
        $bankSampahs = BankSampah::all();
        return view('admin.master.nasabah', compact('nasabah', 'bankSampahs'));
    }

    /**
     * Master Harga Sampah
     */
    public function masterTrashPrices(Request $request)
    {
        $categories = TrashCategory::with('bankSampah')->paginate(15);
        $bankSampahs = BankSampah::all();
        return view('admin.master.trash-prices', compact('categories', 'bankSampahs'));
    }

    /**
     * Audit Log Activity
     */
    public function auditLogs(Request $request)
    {
        $logs = DB::table('scan_logs')->latest()->paginate(20);
        return view('admin.master.audit-logs', compact('logs'));
    }

}
