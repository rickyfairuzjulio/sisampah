@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <x-role-nav role="admin" />

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-on-surface">Manajemen Pengguna</h1>
        <p class="text-on-surface-variant">Kelola akun Petugas dan Nasabah SiSampah.</p>
    </div>

    <div class="mb-6 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="px-4 py-2 bg-surface border border-outline-variant rounded-lg text-sm w-full sm:w-64 focus:ring-2 focus:ring-primary">
            <div class="relative w-full sm:w-auto">
                <select name="role" class="w-full sm:w-auto px-4 py-2 pr-10 bg-surface border border-outline-variant rounded-lg text-sm focus:ring-2 focus:ring-primary appearance-none cursor-pointer">
                    <option value="all">Semua Role</option>
                    <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="nasabah" {{ request('role') == 'nasabah' ? 'selected' : '' }}>Nasabah</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-on-surface-variant">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>

            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-surface-variant hover:bg-outline-variant rounded-lg text-sm font-semibold transition-colors">
                Filter
            </button>
        </form>

        <a href="{{ route('admin.users.create') }}" class="w-full sm:w-auto px-4 py-2 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg shadow-md transition-colors flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Petugas
        </a>
    </div>

    <x-card class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[600px]">
            <thead>
                <tr class="border-b border-outline-variant text-on-surface-variant text-sm">
                    <th class="py-3 px-4 font-semibold">Nama</th>
                    <th class="py-3 px-4 font-semibold">Email</th>
                    <th class="py-3 px-4 font-semibold">Role</th>
                    <th class="py-3 px-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-b border-outline-variant/50 hover:bg-surface-container-lowest transition-colors group">
                        <td class="py-3 px-4 font-medium text-on-surface">{{ $user->name }}</td>
                        <td class="py-3 px-4 text-sm text-on-surface-variant">{{ $user->email }}</td>
                        <td class="py-3 px-4 text-sm">
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $user->hasRole('petugas') ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $user->roles->first()?->name ?? '-' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-3 opacity-80 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center gap-1 text-primary hover:text-forest-emerald font-semibold text-sm transition-colors bg-primary/10 px-3 py-1.5 rounded-lg hover:bg-primary/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus pengguna ini? Semua data terkait (transaksi, dll) bisa terpengaruh.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 text-red-600 hover:text-red-700 font-semibold text-sm transition-colors bg-red-50 px-3 py-1.5 rounded-lg hover:bg-red-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-on-surface-variant">Tidak ada data pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($users->hasPages())
            <div class="mt-4 border-t border-outline-variant pt-4">
                {{ $users->links() }}
            </div>
        @endif
    </x-card>
</div>
@endsection
