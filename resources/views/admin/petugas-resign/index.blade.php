@extends('layouts.dashboard')

@section('header', 'Manajemen Resign & Offboarding Petugas')

@section('content')
<div class="space-y-6">

    {{-- Header Banner --}}
    <div class="card card-body bg-gradient-to-r from-rose-500/10 via-surface to-background border border-rose-500/20 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-rose-500/10 border border-rose-500/30 rounded-2xl flex items-center justify-center text-rose-500 text-xl shadow-soft">
                <i class="bi bi-person-x-fill"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">Manajemen Resign & Status Karyawan</h1>
                <p class="text-xs font-semibold text-text-secondary mt-0.5">Kelola status aktif, penonaktifan tugas lapangan, dan offboarding petugas Bank Sampah</p>
            </div>
        </div>
    </div>

    {{-- Summary Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="card p-4 border border-primary/20 bg-primary/5">
            <span class="text-xs font-bold text-primary uppercase tracking-wider">Total Petugas</span>
            <div class="text-2xl font-black text-text-primary mt-1">{{ $stats['total_petugas'] }}</div>
        </div>
        <div class="card p-4 border border-emerald-500/20 bg-emerald-500/5">
            <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Petugas Aktif</span>
            <div class="text-2xl font-black text-text-primary mt-1">{{ $stats['aktif'] }}</div>
        </div>
        <div class="card p-4 border border-rose-500/20 bg-rose-500/5">
            <span class="text-xs font-bold text-rose-400 uppercase tracking-wider">Petugas Resign / Nonaktif</span>
            <div class="text-2xl font-black text-text-primary mt-1">{{ $stats['resign'] }}</div>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl text-emerald-400 text-xs font-semibold">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table Card --}}
    <div class="card">
        <div class="card-header p-4 border-b border-border flex flex-col sm:flex-row items-center justify-between gap-4">
            <form action="{{ route('admin.petugas_resign.index') }}" method="GET" class="flex items-center gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email / telp petugas..."
                    class="form-input text-xs w-64 rounded-xl border-border">
                <button type="submit" class="btn btn-secondary !py-2 !px-3 text-xs">Cari</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table-custom w-full text-left">
                <thead class="bg-surface text-xs text-text-secondary uppercase">
                    <tr>
                        <th class="px-4 py-3">Nama Petugas</th>
                        <th class="px-4 py-3">Kontak & Email</th>
                        <th class="px-4 py-3">Unit Bank Sampah</th>
                        <th class="px-4 py-3">Status Karir</th>
                        <th class="px-4 py-3 text-right">Aksi Management</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border text-xs">
                    @forelse($petugasList as $p)
                        <tr class="hover:bg-surface/50 transition-colors">
                            <td class="px-4 py-3 font-bold text-text-primary">
                                {{ $p->name }}
                            </td>
                            <td class="px-4 py-3 text-text-secondary">
                                <div>{{ $p->email }}</div>
                                <div class="text-[11px]">{{ $p->nomor_telepon ?: '-' }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-primary/10 text-primary font-bold">
                                    {{ $p->bankSampah?->nama ?: 'Pusat' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($p->email_verified_at)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-rose-500/20 text-rose-400 border border-rose-500/30">
                                        Resign / Nonaktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                        Aktif Berdinas
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if(!$p->email_verified_at)
                                    <button onclick="document.getElementById('modal-resign-{{ $p->id }}').showModal()" class="btn bg-rose-600 hover:bg-rose-500 text-white !py-1.5 !px-3 text-xs">
                                        <i class="bi bi-person-x"></i> Proses Resign
                                    </button>

                                    <dialog id="modal-resign-{{ $p->id }}" class="modal backdrop:bg-black/60 p-0 rounded-3xl overflow-hidden bg-surface border border-border text-left">
                                        <div class="p-6 space-y-4 w-96">
                                            <h3 class="font-bold text-base text-text-primary">Proses Resign Petugas</h3>
                                            <p class="text-xs text-text-secondary">Proses offboarding untuk petugas <strong>{{ $p->name }}</strong>.</p>
                                            
                                            <form action="{{ route('admin.petugas_resign.process', $p->id) }}" method="POST" class="space-y-3 text-xs">
                                                @csrf
                                                <div>
                                                    <label class="block text-text-secondary font-semibold mb-1">Tanggal Resign</label>
                                                    <input type="date" name="tanggal_resign" value="{{ date('Y-m-d') }}" required class="form-input text-xs w-full rounded-xl border-border">
                                                </div>
                                                <div>
                                                    <label class="block text-text-secondary font-semibold mb-1">Alasan Offboarding / Resign</label>
                                                    <textarea name="alasan_resign" rows="3" required placeholder="Alasan pengunduran diri..." class="form-input text-xs w-full rounded-xl border-border"></textarea>
                                                </div>

                                                <div class="flex justify-end gap-2 pt-2">
                                                    <button type="button" onclick="document.getElementById('modal-resign-{{ $p->id }}').close()" class="btn btn-secondary !py-1.5 !px-3 text-xs">Batal</button>
                                                    <button type="submit" class="btn bg-rose-600 text-white !py-1.5 !px-3 text-xs font-bold">Proses Resign</button>
                                                </div>
                                            </form>
                                        </div>
                                    </dialog>
                                @else
                                    <form action="{{ route('admin.petugas_resign.reinstate', $p->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn bg-emerald-600 hover:bg-emerald-500 text-white !py-1.5 !px-3 text-xs">
                                            <i class="bi bi-arrow-counterclockwise"></i> Aktifkan Kembali
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-text-secondary">Tidak ada data petugas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($petugasList->hasPages())
            <div class="p-4 border-t border-border">
                {{ $petugasList->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
