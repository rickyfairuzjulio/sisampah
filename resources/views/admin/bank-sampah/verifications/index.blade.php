@extends('layouts.dashboard')

@section('header', 'Verifikasi Pendaftaran Bank Sampah')

@section('content')
<div class="space-y-6">

    {{-- Header Banner --}}
    <div class="p-6 rounded-3xl bg-gradient-to-r from-emerald-900/60 via-slate-900 to-slate-900 border border-emerald-500/30 text-white shadow-xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-14 h-14 bg-emerald-500/20 border border-emerald-500/40 rounded-2xl flex items-center justify-center text-emerald-400 text-2xl shadow-lg shrink-0">
                <i class="bi bi-shield-check"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-white tracking-tight">Antrean Verifikasi Bank Sampah</h1>
                <p class="text-xs text-slate-300 mt-1 max-w-xl">Peninjauan dokumen legalitas, jadwal pertemuan validasi, dan otorisasi kelayakan Bank Sampah oleh Super Admin</p>
            </div>
        </div>

        <a href="{{ route('admin.master_bank_sampah.index') }}" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 rounded-xl text-xs font-bold transition-all shadow-md flex items-center gap-2 w-fit relative z-10">
            <i class="bi bi-buildings text-emerald-400"></i> Master Bank Sampah
        </a>
    </div>

    {{-- Summary Stats Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="p-4 rounded-2xl border border-sky-500/30 bg-gradient-to-br from-sky-500/10 to-slate-900/60 backdrop-blur-md shadow-md transition-transform hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-sky-400 uppercase tracking-wider">Permohonan Baru</span>
                <span class="w-8 h-8 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center text-sm"><i class="bi bi-inbox-fill"></i></span>
            </div>
            <div class="text-2xl font-black text-white mt-2">{{ $stats['total_submitted'] }}</div>
        </div>
        <div class="p-4 rounded-2xl border border-amber-500/30 bg-gradient-to-br from-amber-500/10 to-slate-900/60 backdrop-blur-md shadow-md transition-transform hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-amber-400 uppercase tracking-wider">Sedang Ditinjau</span>
                <span class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-sm"><i class="bi bi-search"></i></span>
            </div>
            <div class="text-2xl font-black text-white mt-2">{{ $stats['under_review'] }}</div>
        </div>
        <div class="p-4 rounded-2xl border border-indigo-500/30 bg-gradient-to-br from-indigo-500/10 to-slate-900/60 backdrop-blur-md shadow-md transition-transform hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-indigo-400 uppercase tracking-wider">Jadwal Pertemuan</span>
                <span class="w-8 h-8 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-sm"><i class="bi bi-calendar-event"></i></span>
            </div>
            <div class="text-2xl font-black text-white mt-2">{{ $stats['meeting_scheduled'] }}</div>
        </div>
        <div class="p-4 rounded-2xl border border-emerald-500/30 bg-gradient-to-br from-emerald-500/10 to-slate-900/60 backdrop-blur-md shadow-md transition-transform hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Total Disetujui</span>
                <span class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-sm"><i class="bi bi-patch-check-fill"></i></span>
            </div>
            <div class="text-2xl font-black text-white mt-2">{{ $stats['verified'] }}</div>
        </div>
    </div>

    {{-- Filter & Table Card --}}
    <div class="card border border-slate-200/80 dark:border-white/10 shadow-soft overflow-hidden">
        <div class="p-4 border-b border-slate-200/80 dark:border-white/10 bg-slate-50/50 dark:bg-slate-900/40">
            <form action="{{ route('admin.verifikasi_bank_sampah.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <div class="relative flex-1 min-w-[200px]">
                    <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / penanggung jawab / registrasi..."
                        class="form-input text-xs pl-9 rounded-xl border-slate-300 dark:border-white/10">
                </div>
                
                <select name="status_verifikasi" onchange="this.form.submit()" class="form-select text-xs rounded-xl border-slate-300 dark:border-white/10 w-auto">
                    <option value="">-- Semua Status Verifikasi --</option>
                    <option value="submitted" {{ request('status_verifikasi') === 'submitted' ? 'selected' : '' }}>Submitted (Baru)</option>
                    <option value="under_review" {{ request('status_verifikasi') === 'under_review' ? 'selected' : '' }}>Under Review</option>
                    <option value="document_revision" {{ request('status_verifikasi') === 'document_revision' ? 'selected' : '' }}>Revisi Dokumen</option>
                    <option value="meeting_scheduled" {{ request('status_verifikasi') === 'meeting_scheduled' ? 'selected' : '' }}>Dijadwalkan Pertemuan</option>
                    <option value="verified" {{ request('status_verifikasi') === 'verified' ? 'selected' : '' }}>Verified (Aktif)</option>
                    <option value="rejected" {{ request('status_verifikasi') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>

                <button type="submit" class="btn btn-primary !py-2 !px-4 text-xs">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="data-table w-full text-left">
                <thead>
                    <tr>
                        <th class="px-4 py-3.5">Registrasi</th>
                        <th class="px-4 py-3.5">Nama Bank Sampah</th>
                        <th class="px-4 py-3.5">Penanggung Jawab</th>
                        <th class="px-4 py-3.5">Lokasi / Kecamatan</th>
                        <th class="px-4 py-3.5">Dokumen</th>
                        <th class="px-4 py-3.5">Status Verifikasi</th>
                        <th class="px-4 py-3.5 text-right">Aksi Workstation</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/80 dark:divide-white/10 text-xs">
                    @forelse($registrations as $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-4 py-3.5 font-mono text-emerald-600 dark:text-emerald-400 font-extrabold">
                                {{ $item->nomor_registrasi ?: $item->kode_bank }}
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="font-bold text-text-primary text-sm">{{ $item->nama }}</div>
                                <div class="text-[11px] text-text-secondary mt-0.5"><i class="bi bi-geo"></i> Radius: {{ number_format(($item->radius_layanan ?: 3000) / 1000, 1) }} km</div>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="font-bold text-text-primary">{{ $item->penanggung_jawab }}</div>
                                <div class="text-[11px] text-text-secondary">{{ $item->email_pj }} • {{ $item->telepon_pj }}</div>
                            </td>
                            <td class="px-4 py-3.5 text-text-secondary font-medium">
                                {{ $item->kecamatan }}, {{ $item->kabupaten }}
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 font-extrabold text-[11px]">
                                    <i class="bi bi-file-earmark-check"></i> {{ $item->documents_count }} berkas
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border tracking-wide {{ $item->verifikasi_badge_bg }}">
                                    {{ str_replace('_', ' ', $item->status_verifikasi) }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <a href="{{ route('admin.verifikasi_bank_sampah.show', $item->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                                    <i class="bi bi-eye-fill"></i> Review & Audit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-text-secondary">
                                <i class="bi bi-inbox text-3xl text-slate-400 block mb-2"></i>
                                Tidak ada data pendaftaran Bank Sampah dalam antrean.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
            <div class="p-4 border-t border-slate-200/80 dark:border-white/10">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
