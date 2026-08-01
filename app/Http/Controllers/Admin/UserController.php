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
        $query = User::with('bankSampah');

        if ($request->has('role') && $request->role != 'all') {
            $query->role($request->role);
        } else {
            $query->whereHas('roles', function($q) {
                $q->whereIn('name', ['nasabah', 'petugas']);
            });
        }

        if ($request->filled('bank_sampah_id')) {
            $query->where('bank_sampah_id', $request->bank_sampah_id);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }

        $users = $query->latest()->paginate(15);
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:nasabah,petugas',
            'bank_sampah_id' => 'nullable|exists:bank_sampahs,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'bank_sampah_id' => $request->bank_sampah_id ?: \App\Models\BankSampah::first()?->id,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        abort(404);
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $bankSampahs = \App\Models\BankSampah::all();
        return view('admin.users.edit', compact('user', 'bankSampahs'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:nasabah,petugas',
            'bank_sampah_id' => 'nullable|exists:bank_sampahs,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->bank_sampah_id = $request->bank_sampah_id;
        if ($request->filled('password')) {
            $user->password = \Hash::make($request->password);
        }
        $user->save();

        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
