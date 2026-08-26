<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    /**
     * Display Audit Logs & Violation Reports.
     */
    public function index(Request $request)
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

        // Audit Logs & Flagged Suspicious transactions
        $suspiciousTransactions = Transaction::with(['user', 'trashCategory', 'bankSampah'])
            ->where('berat_kg', '>', 100)
            ->orWhere('total_rp', '>', 1000000)
            ->latest()
            ->take(10)
            ->get();

        $auditLogs = AuditLog::with('actor')->latest()->take(15)->get();

        $defaultViolations = [
            [
                'id' => 101,
                'user_name' => 'Budi Santoso',
                'user_role' => 'Warga Nasabah (RT 02)',
                'user_avatar' => null,
                'phone' => '081234567890',
                'type' => 'unsegregated',
                'type_label' => 'Sampah Tidak Terpilah',
                'description' => 'Setoran kantong plastik tercampur sisa makanan basah & residu popok bekas.',
                'sanction' => 'Teguran Lisan 1 + Pengurangan 50 Poin Reward',
                'status' => 'pending',
                'created_at_formatted' => 'Hari ini, 09:30',
            ],
            [
                'id' => 102,
                'user_name' => 'Armada Truk Unit 02 (Joko)',
                'user_role' => 'Petugas Lapangan',
                'user_avatar' => null,
                'phone' => '081234567891',
                'type' => 'suspicious',
                'type_label' => 'Transaksi Anomali (>100kg)',
                'description' => 'Penimbangan kardus seberat 145.0 Kg dalam 1 transaksi setoran warga RT 04.',
                'sanction' => 'Verifikasi Nota Timbang Fisik Pos',
                'status' => 'pending',
                'created_at_formatted' => 'Kemarin, 14:15',
            ],
            [
                'id' => 103,
                'user_name' => 'Dewi Lestari',
                'user_role' => 'Warga Nasabah (RT 01)',
                'user_avatar' => null,
                'phone' => '081298765432',
                'type' => 'missed_pickup',
                'type_label' => 'Ketidakhadiran Jadwal Jemput',
                'description' => 'Petugas tiba di lokasi RT 01 sesuai pesanan namun rumah terkunci & sampah belum disiapkan.',
                'sanction' => 'Jadwal Ulang Penjemputan Otomatis',
                'status' => 'resolved',
                'created_at_formatted' => '20 Jan 2026',
            ],
            [
                'id' => 104,
                'user_name' => 'Ahmad Fauzi',
                'user_role' => 'Warga Nasabah (RT 03)',
                'user_avatar' => null,
                'phone' => '081567890123',
                'type' => 'unsegregated',
                'type_label' => 'Sampah Tercampur Logam Tajam',
                'description' => 'Ditemukan pecahan kaca & paku tanpa pembungkus pelindung di dalam kantong kardus.',
                'sanction' => 'Surat Peringatan 1 + Edukasi Keselamatan Petugas',
                'status' => 'resolved',
                'created_at_formatted' => '18 Jan 2026',
            ],
            [
                'id' => 105,
                'user_name' => 'Siti Rahmawati',
                'user_role' => 'Warga Nasabah (RT 05)',
                'user_avatar' => null,
                'phone' => '081345678901',
                'type' => 'suspicious',
                'type_label' => 'Transaksi Anomali (>Rp 1 Juta)',
                'description' => 'Setoran tembaga & kuningan senilai Rp 1.250.000. Telah divalidasi oleh Kepala Pos.',
                'sanction' => 'Validasi Payout Kasir Unit',
                'status' => 'resolved',
                'created_at_formatted' => '15 Jan 2026',
            ],
        ];

        $violationsList = $defaultViolations;

        $statistics = [
            'total_cases' => count($violationsList),
            'suspicious_count' => collect($violationsList)->where('type', 'suspicious')->count(),
            'in_review_count' => collect($violationsList)->where('status', 'pending')->count(),
            'resolved_count' => collect($violationsList)->where('status', 'resolved')->count(),
        ];

        return view('admin.pelanggaran.index', compact('authData', 'statistics', 'violationsList'));
    }
}
