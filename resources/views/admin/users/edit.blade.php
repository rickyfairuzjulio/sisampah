@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-on-surface-variant hover:text-primary transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Pengguna
        </a>
    </div>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-on-surface">Edit Pengguna</h1>
        <p class="text-on-surface-variant">Perbarui informasi akun Petugas atau Nasabah.</p>
    </div>

    <x-card>
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-sm font-medium text-on-surface mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-2 bg-surface border border-outline-variant rounded-lg text-sm focus:ring-2 focus:ring-primary">
                @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-on-surface mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-2 bg-surface border border-outline-variant rounded-lg text-sm focus:ring-2 focus:ring-primary">
                @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-on-surface mb-2">Password Baru <span class="text-xs text-on-surface-variant font-normal">(Kosongkan jika tidak ingin mengubah)</span></label>
                <input type="password" name="password" id="password"
                       class="w-full px-4 py-2 bg-surface border border-outline-variant rounded-lg text-sm focus:ring-2 focus:ring-primary">
                @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            @php $currentRole = $user->getRoleNames()->first(); @endphp
            <div>
                <label for="role" class="block text-sm font-medium text-on-surface mb-2">Peran (Role) <span class="text-red-500">*</span></label>
                <select name="role" id="role" required class="w-full px-4 py-2 bg-surface border border-outline-variant rounded-lg text-sm focus:ring-2 focus:ring-primary">
                    <option value="">-- Pilih Role --</option>
                    <option value="petugas" {{ old('role', $currentRole) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="nasabah" {{ old('role', $currentRole) == 'nasabah' ? 'selected' : '' }}>Nasabah</option>
                </select>
                @error('role') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 border-t border-outline-variant flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg shadow-md transition-all active:scale-95">
                    Perbarui Pengguna
                </button>
            </div>
        </form>
    </x-card>
</div>
@endsection
