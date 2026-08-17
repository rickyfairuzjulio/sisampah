@extends('layouts.dashboard')

@section('header', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="card card-body flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">Manajemen Pengguna</h1>
            <p class="page-subtitle">Kelola akun Petugas dan Nasabah dalam ekosistem SiSampah.</p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary !py-2.5 !px-4 text-xs">
            <i class="bi bi-person-plus-fill"></i> Tambah Petugas
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="card card-body">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 justify-between items-center">
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto flex-1 max-w-xl">
                <div class="relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="form-input text-xs">
                </div>
                
                <div class="w-full sm:w-40">
                    <select name="role" class="form-select text-xs">
                        <option value="all">Semua Role</option>
                        <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="nasabah" {{ request('role') == 'nasabah' ? 'selected' : '' }}>Nasabah</option>
                    </select>
                </div>

                <div class="w-full sm:w-40">
                    <select name="status" class="form-select text-xs">
                        <option value="all">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                <button type="submit" class="btn btn-primary !py-2.5 !px-5 text-xs">
                    Filter
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary p-2.5 text-xs" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Users Table Card -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Email</th>
                        <th>Bank Sampah Unit</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($users as $user)
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center text-primary font-black text-xs uppercase shrink-0">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <span class="font-bold text-text-primary text-xs">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="text-text-secondary text-xs font-medium">{{ $user->email }}</td>
                            <td class="text-xs text-text-secondary font-medium">
                                <span class="px-2.5 py-1 rounded-lg bg-surface border border-border/80 font-bold text-text-primary">
                                    {{ $user->bankSampah?->nama ?: 'Platform Pusat' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($user->hasRole('super_admin'))
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-purple-500/20 text-purple-400 border border-purple-500/30">Super Admin</span>
                                @elseif($user->hasRole('admin'))
                                    <span class="chip chip-error">Admin Unit</span>
                                @elseif($user->hasRole('petugas'))
                                    <span class="chip chip-warning">Petugas</span>
                                @else
                                    <span class="chip chip-success">Nasabah</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($user->is_active ?? true)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                        <i class="bi bi-check-circle-fill"></i> Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-500/10 text-rose-400 border border-rose-500/30">
                                        <i class="bi bi-x-circle-fill"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.users.toggle_status', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @if($user->is_active ?? true)
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/30 text-[11px] font-bold transition-colors flex items-center gap-1" title="Nonaktifkan User">
                                                <i class="bi bi-person-x-fill"></i> Nonaktifkan
                                            </button>
                                        @else
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-[11px] font-bold transition-colors flex items-center gap-1" title="Aktifkan User">
                                                <i class="bi bi-person-check-fill"></i> Aktifkan
                                            </button>
                                        @endif
                                    </form>

                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="w-8 h-8 rounded-lg bg-surface hover:bg-hover-bg text-text-secondary hover:text-text-primary border border-border-color flex items-center justify-center transition-colors" title="Edit Pengguna">
                                        <i class="bi bi-pencil-square text-xs"></i>
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini? Semua data terkait (transaksi, dll) bisa terpengaruh.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-danger/10 hover:bg-danger/20 text-danger flex items-center justify-center transition-colors" title="Hapus">
                                            <i class="bi bi-trash-fill text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-text-muted">
                                <div class="text-3xl mb-2">👤</div>
                                <p class="font-bold text-sm text-text-secondary">Tidak ada data pengguna.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-border-color">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
