<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentUser = auth()->user();
        $query = User::with('bankSampah');

        // Scoping for Unit Admin vs Super Admin
        if ($currentUser->bank_sampah_id) {
            $query->where('bank_sampah_id', $currentUser->bank_sampah_id);
        } elseif ($request->filled('bank_sampah_id')) {
            $query->where('bank_sampah_id', $request->bank_sampah_id);
        }

        if ($request->has('role') && $request->role != 'all') {
            $query->role($request->role);
        } else {
            $query->whereHas('roles', function($q) {
                $q->whereIn('name', ['nasabah', 'petugas']);
            });
        }

        if ($request->has('search') && $request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->has('status') && $request->filled('status') && $request->status !== 'all') {
            if ($request->status === 'aktif') {
                $query->where('is_active', true);
            } elseif ($request->status === 'nonaktif') {
                $query->where('is_active', false);
            }
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        $bankSampahs = \App\Models\BankSampah::all();

        return view('admin.users.index', compact('users', 'bankSampahs'));
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
