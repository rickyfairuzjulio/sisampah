<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\BankSampah;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PelanggaranController extends Controller
{
    /**
     * Display Audit Logs & Violation Reports (Dinamis).
     */
    public function index(?Request $request = null)
    {
        $request = $request ?? request();
        $currentUser = auth()->user();
        if ($currentUser) {
            $currentUser->loadMissing('bankSampah');
        }
        $bsId = $currentUser?->bank_sampah_id;
        $unitBankSampah = $bsId ? BankSampah::find($bsId) : BankSampah::first();

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

        // Ambil data pelanggaran dari database
        $violationsQuery = Violation::with(['user', 'reporter', 'bankSampah'])
            ->when($bsId, fn($q) => $q->where('bank_sampah_id', $bsId));

        if ($request->filled('type') && $request->type !== 'all') {
            $violationsQuery->where('tipe', $request->type);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $violationsQuery->where('status', $request->status);
        }

        $allViolations = $violationsQuery->latest('id')->get();

        $violationsList = $allViolations->map(function ($v) {
            return [
                'id' => $v->id,
                'user_name' => $v->user_name ?: ($v->user?->name ?? 'Warga Nasabah'),
                'user_role' => $v->user_role ?: ($v->user?->hasRole('petugas') ? 'Petugas Lapangan' : 'Warga Nasabah'),
                'user_avatar' => $v->user?->avatar_url,
                'phone' => $v->phone ?: ($v->user?->nomor_telepon ?? '08123456789'),
                'type' => $v->tipe,
                'type_label' => $v->tipe_label ?: ucfirst($v->tipe),
                'description' => $v->deskripsi,
                'sanction' => $v->sanksi ?: 'Dalam Peninjauan',
                'poin_penalti' => (int) $v->poin_penalti,
                'status' => $v->status,
                'bukti_foto' => $v->bukti_foto ? asset('storage/' . $v->bukti_foto) : null,
                'catatan_penyelesaian' => $v->catatan_penyelesaian,
                'created_at_formatted' => $v->created_at ? $v->created_at->diffForHumans() : 'Hari ini',
                'created_at_full' => $v->created_at ? $v->created_at->format('d M Y, H:i') . ' WIB' : now()->format('d M Y, H:i') . ' WIB',
            ];
        })->values();

        $statistics = [
            'total_cases' => $allViolations->count(),
            'suspicious_count' => $allViolations->where('tipe', 'suspicious')->count(),
            'in_review_count' => $allViolations->where('status', 'pending')->count(),
            'resolved_count' => $allViolations->where('status', 'resolved')->count(),
        ];

        // Daftar pengguna untuk dropdown pembuatan laporan
        $usersDropdown = User::when($bsId, fn($q) => $q->where('bank_sampah_id', $bsId))
            ->whereHas('roles', fn($q) => $q->whereIn('name', ['nasabah', 'petugas']))
            ->select('id', 'name', 'nomor_telepon', 'rt', 'rw')
            ->get()
            ->map(function ($u) {
                return [
                    'id' => $u->id,
                    'name' => $u->name,
                    'phone' => $u->nomor_telepon ?? '',
                    'role_label' => $u->hasRole('petugas') ? 'Petugas Lapangan' : ('Nasabah RT ' . ($u->rt ?? '01')),
                ];
            });

        return Inertia::render('admin/violations/AdminViolationsPage', compact('authData', 'statistics', 'violationsList', 'usersDropdown'));
    }

    /**
     * Buat Laporan Kasus Pelanggaran Baru
     */
    public function store(Request $request)
    {
        $currentUser = auth()->user();
        $bsId = $currentUser?->bank_sampah_id ?: BankSampah::first()?->id;

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'user_name' => 'required|string|max:255',
            'user_role' => 'required|string|max:100',
            'phone' => 'nullable|string|max:50',
            'tipe' => 'required|string|in:unsegregated,suspicious,missed_pickup,hazardous_material,other',
            'deskripsi' => 'required|string|max:1000',
            'sanksi' => 'nullable|string|max:255',
            'poin_penalti' => 'nullable|integer|min:0|max:500',
            'bukti_foto' => 'nullable|image|max:2048',
        ]);

        $typeLabels = [
            'unsegregated' => 'Sampah Tidak Terpilah',
            'suspicious' => 'Transaksi Anomali (>100kg)',
            'missed_pickup' => 'Ketidakhadiran Jadwal Jemput',
            'hazardous_material' => 'Sampah B3 / Pecahan Berbahaya',
            'other' => 'Pelanggaran Lainnya',
        ];

        $fotoPath = null;
        if ($request->hasFile('bukti_foto')) {
            $fotoPath = $request->file('bukti_foto')->store('violations', 'public');
        }

        $violation = Violation::create([
            'bank_sampah_id' => $bsId,
            'user_id' => $validated['user_id'] ?? null,
            'reporter_id' => $currentUser?->id,
            'user_name' => $validated['user_name'],
            'user_role' => $validated['user_role'],
            'phone' => $validated['phone'] ?? null,
            'tipe' => $validated['tipe'],
            'tipe_label' => $typeLabels[$validated['tipe']] ?? ucfirst($validated['tipe']),
            'deskripsi' => $validated['deskripsi'],
            'sanksi' => $validated['sanksi'] ?? 'Teguran & Verifikasi Pos',
            'poin_penalti' => $validated['poin_penalti'] ?? 0,
            'bukti_foto' => $fotoPath,
            'status' => 'pending',
        ]);

        \App\Services\AuditLogger::log(
            'VIOLATION_REPORTED',
            'Violation',
            $violation->id,
            [],
            $violation->toArray(),
            "Laporan kasus pelanggaran baru: {$violation->tipe_label} atas nama {$violation->user_name}"
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Laporan pelanggaran berhasil dicatat ke sistem.',
                'data' => $violation,
            ]);
        }

        return redirect()->route('admin.pelanggaran.index')->with('success', 'Laporan pelanggaran berhasil ditambahkan.');
    }

    /**
     * Selesaikan / Tindak Lanjut Kasus Pelanggaran
     */
    public function resolve(Request $request, $id)
    {
        $violation = Violation::findOrFail($id);

        $validated = $request->validate([
            'catatan_penyelesaian' => 'required|string|max:1000',
            'sanksi' => 'nullable|string|max:255',
            'kurangi_saldo' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($violation, $validated) {
            $violation->status = 'resolved';
            $violation->catatan_penyelesaian = $validated['catatan_penyelesaian'];
            if (!empty($validated['sanksi'])) {
                $violation->sanksi = $validated['sanksi'];
            }
            $violation->resolved_at = now();
            $violation->save();

            // Jika ada penalti pemotongan saldo / poin pada nasabah terkait
            if (!empty($validated['kurangi_saldo']) && $validated['kurangi_saldo'] > 0 && $violation->user) {
                $nominal = (float) $validated['kurangi_saldo'];
                $violation->user->decrement('saldo', $nominal);

                $walletService = new \App\Services\WalletLedgerService();
                $walletService->recordTransaction(
                    $violation->user,
                    'penalty_deduction',
                    $nominal,
                    $violation->bank_sampah_id,
                    null,
                    $violation->id,
                    'PEN-' . $violation->id,
                    "Denda penalti pelanggaran ID #{$violation->id}: {$validated['catatan_penyelesaian']}"
                );
            }
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kasus pelanggaran berhasil diselesaikan & ditindaklanjuti.',
            ]);
        }

        return redirect()->route('admin.pelanggaran.index')->with('success', 'Kasus pelanggaran berhasil diselesaikan.');
    }

    /**
     * Hapus Catatan Pelanggaran
     */
    public function destroy(string $id)
    {
        $violation = Violation::findOrFail($id);
        $violation->delete();

        return redirect()->route('admin.pelanggaran.index')->with('success', 'Catatan pelanggaran berhasil dihapus.');
    }
}

