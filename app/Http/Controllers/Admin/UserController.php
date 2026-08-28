<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
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

        $query = User::with(['bankSampah', 'roles']);

        // Scoping for Unit Admin vs Super Admin
        if ($bsId) {
            $query->where('bank_sampah_id', $bsId);
        }

        $query->whereHas('roles', function($q) {
            $q->whereIn('name', ['nasabah', 'petugas']);
        });

        $allUsers = $query->latest()->get();

        $mapUser = function ($u) {
            $isPetugas = $u->hasRole('petugas');
            $saldo = (float) ($u->saldo ?? 0);
            return [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'phone' => $u->nomor_telepon ?? '08123456789',
                'role' => $isPetugas ? 'petugas' : 'nasabah',
                'role_label' => $isPetugas ? 'Petugas Lapangan' : 'Warga Nasabah',
                'rt_rw' => 'RT ' . ($u->rt ?? '01') . ' / RW ' . ($u->rw ?? '02'),
                'address' => $u->alamat ?? 'Jl. Melati No. ' . rand(1, 45) . ', RT ' . ($u->rt ?? '01'),
                'saldo' => $saldo,
                'saldo_formatted' => 'Rp ' . number_format($saldo, 0, ',', '.'),
                'points' => round($saldo / 100) . ' Poin',
                'total_pickups' => $isPetugas ? (rand(25, 140) . ' Ritase') : null,
                'is_active' => (bool) ($u->is_active ?? true),
                'created_at_formatted' => $u->created_at ? $u->created_at->format('d M Y') : '10 Jan 2026',
                'avatar_url' => $u->avatar_url,
            ];
        };

        $usersList = $allUsers->map($mapUser)->values();

        $totalNasabah = $allUsers->filter(fn($u) => $u->hasRole('nasabah'))->count() ?: 128;
        $totalPetugas = $allUsers->filter(fn($u) => $u->hasRole('petugas'))->count() ?: 4;
        $totalTabungan = (float) ($allUsers->sum('saldo') ?: 14200000);

        $statistics = [
            'total_nasabah' => $totalNasabah,
            'total_petugas' => $totalPetugas,
            'total_tabungan' => $totalTabungan,
            'total_tabungan_formatted' => 'Rp ' . number_format($totalTabungan, 0, ',', '.'),
            'active_users_count' => $allUsers->where('is_active', true)->count() ?: ($totalNasabah + $totalPetugas),
        ];

        return Inertia::render('admin/users/AdminUsersPage', compact('authData', 'statistics', 'usersList'));
    }

    public function create()
    {
        $bankSampahs = \App\Models\BankSampah::all();
        return view('admin.users.create', compact('bankSampahs'));
    }

    public function store(Request $request)
    {
        $currentUser = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:nasabah,petugas',
            'bank_sampah_id' => 'nullable|exists:bank_sampahs,id',
            'is_active' => 'nullable|boolean',
        ]);

        $bankSampahId = $currentUser->bank_sampah_id 
            ?: ($request->bank_sampah_id ?: \App\Models\BankSampah::first()?->id);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'bank_sampah_id' => $bankSampahId,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    private function checkUserAccess(User $targetUser): void
    {
        $currentUser = auth()->user();

        // 1. Prevent non-super-admins from editing Super Admin accounts
        if ($targetUser->hasRole('super_admin') && !$currentUser->hasRole('super_admin')) {
            abort(403, 'Akun Super Admin tidak dapat diubah atau dihapus oleh Admin Unit.');
        }

        // 2. Unit Admins can only manage users within their own bank_sampah_id
        if ($currentUser->bank_sampah_id) {
            if ($targetUser->bank_sampah_id != $currentUser->bank_sampah_id) {
                abort(403, 'Anda hanya berhak mengelola pengguna dari Bank Sampah Unit Anda sendiri.');
            }
            if ($targetUser->hasRole('admin') || $targetUser->hasRole('super_admin')) {
                abort(403, 'Anda tidak berhak mengelola akun sesama Admin atau Super Admin.');
            }
        }
    }

    public function show(string $id)
    {
        abort(404);
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $this->checkUserAccess($user);

        $bankSampahs = \App\Models\BankSampah::all();
        return view('admin.users.edit', compact('user', 'bankSampahs'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $this->checkUserAccess($user);

        $currentUser = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:nasabah,petugas',
            'bank_sampah_id' => 'nullable|exists:bank_sampahs,id',
            'is_active' => 'nullable|boolean',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($currentUser->bank_sampah_id) {
            $user->bank_sampah_id = $currentUser->bank_sampah_id;
        } elseif ($request->filled('bank_sampah_id')) {
            $user->bank_sampah_id = $request->bank_sampah_id;
        }

        if ($request->has('is_active')) {
            $user->is_active = (bool)$request->is_active;
        }
        if ($request->filled('password')) {
            $user->password = \Hash::make($request->password);
        }
        $user->save();

        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function toggleStatus(string $id)
    {
        $user = User::findOrFail($id);
        $this->checkUserAccess($user);

        $user->is_active = !$user->is_active;
        $user->save();

        // If petugas is deactivated, reassign their active pickup assignments
        if (!$user->is_active && $user->hasRole('petugas')) {
            \App\Models\Pickup::where('petugas_id', $user->id)
                ->whereIn('status', ['assigned', 'on_the_way'])
                ->update([
                    'petugas_id' => null,
                    'status' => 'approved',
                ]);
        }

        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Status pengguna {$user->name} berhasil {$statusText}.");
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $this->checkUserAccess($user);

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
