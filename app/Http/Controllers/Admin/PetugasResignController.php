<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class PetugasResignController extends Controller
{
    /**
     * Display list of Petugas (active & resigned).
     */
    public function index(Request $request)
    {
        $currentUser = auth()->user();
        $query = User::role('petugas')->with('bankSampah');

        if ($currentUser->bank_sampah_id) {
            $query->where('bank_sampah_id', $currentUser->bank_sampah_id);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nomor_telepon', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'resign') {
                $query->whereNotNull('email_verified_at');
            }
        }

        $petugasList = $query->latest()->paginate(15)->withQueryString();

        $statsQuery = User::role('petugas');
        if ($currentUser->bank_sampah_id) {
            $statsQuery->where('bank_sampah_id', $currentUser->bank_sampah_id);
        }

        $stats = [
            'total_petugas' => (clone $statsQuery)->count(),
            'aktif' => (clone $statsQuery)->whereNull('email_verified_at')->count(),
            'resign' => (clone $statsQuery)->whereNotNull('email_verified_at')->count(),
        ];

        return view('admin.petugas-resign.index', compact('petugasList', 'stats'));
    }

    /**
     * Process Petugas resignation / offboarding.
     */
    public function processResign(Request $request, $id)
    {
        $user = User::role('petugas')->findOrFail($id);

        $validated = $request->validate([
            'alasan_resign' => 'required|string|max:500',
            'tanggal_resign' => 'required|date',
        ]);

        // Deactivate user account and log offboarding
        $user->email_verified_at = now(); // Tagged as inactive/resigned
        $user->save();

        AuditLogger::log(
            'PETUGAS_RESIGNED',
            'User',
            $user->id,
            ['name' => $user->name, 'email' => $user->email],
            ['alasan_resign' => $validated['alasan_resign'], 'tanggal_resign' => $validated['tanggal_resign']],
            "Petugas '{$user->name}' diproses resign/offboarding. Alasan: {$validated['alasan_resign']}"
        );

        return back()->with('success', "Status resign petugas '{$user->name}' berhasil diproses.");
    }

    /**
     * Reinstate resigned petugas to active duty.
     */
    public function reinstate($id)
    {
        $user = User::role('petugas')->findOrFail($id);
        $user->email_verified_at = null;
        $user->save();

        AuditLogger::log(
            'PETUGAS_REINSTATED',
            'User',
            $user->id,
            null,
            ['status' => 'active'],
            "Petugas '{$user->name}' diaktifkan kembali."
        );

        return back()->with('success', "Petugas '{$user->name}' berhasil diaktifkan kembali.");
    }
}
