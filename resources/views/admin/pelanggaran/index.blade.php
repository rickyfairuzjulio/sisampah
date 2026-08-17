@extends('layouts.dashboard')

@section('header', 'Catatan Pelanggaran & Audit Trail')

@section('content')
<div class="space-y-6">

    {{-- Header Banner --}}
    <div class="card card-body bg-gradient-to-r from-amber-500/10 via-surface to-background border border-amber-500/20 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-500/10 border border-amber-500/30 rounded-2xl flex items-center justify-center text-amber-500 text-xl shadow-soft">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">Catatan Pelanggaran & Log Audit Sistem</h1>
                <p class="text-xs font-semibold text-text-secondary mt-0.5">Pemantauan transaksi terindikasi anomali, log audit perubahan data, dan histori pelanggaran</p>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="card p-4 border border-amber-500/20 bg-amber-500/5">
            <span class="text-xs font-bold text-amber-400 uppercase tracking-wider">Aktivitas Audit Log</span>
            <div class="text-2xl font-black text-text-primary mt-1">{{ $stats['total_audit_logs'] }}</div>
        </div>
        <div class="card p-4 border border-rose-500/20 bg-rose-500/5">
            <span class="text-xs font-bold text-rose-400 uppercase tracking-wider">Transaksi Terindikasi Anomali</span>
            <div class="text-2xl font-black text-text-primary mt-1">{{ $stats['suspicious_transactions'] }}</div>
        </div>
        <div class="card p-4 border border-sky-500/20 bg-sky-500/5">
            <span class="text-xs font-bold text-sky-400 uppercase tracking-wider">Aktivitas Hari Ini</span>
            <div class="text-2xl font-black text-text-primary mt-1">{{ $stats['total_actions_today'] }}</div>
        </div>
    </div>

    {{-- Suspicious Transactions Table --}}
    @if($suspiciousTransactions->count() > 0)
        <div class="card border border-rose-500/30 bg-rose-500/5">
            <div class="card-header p-4 border-b border-rose-500/20">
                <h3 class="text-sm font-bold text-rose-400 uppercase tracking-wider flex items-center gap-2">
                    <i class="bi bi-shield-exclamation text-rose-400"></i> Transaksi Terindikasi Anomali (Perlu Peninjauan)
                </h3>
            </div>
            <div class="table-responsive">
                <table class="table-custom w-full text-left">
                    <thead class="bg-surface text-xs text-text-secondary uppercase">
                        <tr>
                            <th class="px-4 py-3">ID Transaksi</th>
                            <th class="px-4 py-3">Nasabah</th>
                            <th class="px-4 py-3">Kategori & Berat</th>
                            <th class="px-4 py-3">Nilai Transaksi</th>
                            <th class="px-4 py-3">Bank Sampah</th>
                            <th class="px-4 py-3">Catatan Anomali</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border text-xs">
                        @foreach($suspiciousTransactions as $st)
                            <tr class="hover:bg-surface/50">
                                <td class="px-4 py-3 font-mono text-primary font-bold">{{ substr($st->id, 0, 8) }}...</td>
                                <td class="px-4 py-3 font-semibold text-text-primary">{{ $st->user?->name }}</td>
                                <td class="px-4 py-3">{{ $st->trashCategory?->nama }} (<strong>{{ $st->berat_kg }} kg</strong>)</td>
                                <td class="px-4 py-3 font-bold text-emerald-400">Rp {{ number_format($st->total_rp, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-text-secondary">{{ $st->bankSampah?->nama ?: 'Pusat' }}</td>
                                <td class="px-4 py-3 text-rose-400 font-semibold">
                                    {{ $st->berat_kg > 100 ? 'Berat melampaui 100kg' : 'Nilai melampaui Rp 1.000.000' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- System Audit Log Table --}}
    <div class="card">
        <div class="card-header p-4 border-b border-border flex flex-col sm:flex-row items-center justify-between gap-4">
            <h3 class="text-sm font-bold text-text-primary uppercase tracking-wider">Log Audit Sistem Terperinci</h3>
            <form action="{{ route('admin.pelanggaran.index') }}" method="GET" class="flex items-center gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aksi / entitas / alasan..."
                    class="form-input text-xs w-64 rounded-xl border-border">
                <button type="submit" class="btn btn-secondary !py-2 !px-3 text-xs">Cari</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table-custom w-full text-left">
                <thead class="bg-surface text-xs text-text-secondary uppercase">
                    <tr>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Aktor / Pengubah</th>
                        <th class="px-4 py-3">Aksi System</th>
                        <th class="px-4 py-3">Entitas & ID</th>
                        <th class="px-4 py-3">Alasan / Catatan Audit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border text-xs">
                    @forelse($auditLogs as $log)
                        <tr class="hover:bg-surface/50 transition-colors">
                            <td class="px-4 py-3 text-text-secondary font-mono text-[11px]">
                                {{ $log->created_at->format('d M Y H:i:s') }}
                            </td>
                            <td class="px-4 py-3 font-semibold text-text-primary">
                                {{ $log->actor?->name ?: 'Sistem Otomatis' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-primary/10 text-primary border border-primary/20">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-text-secondary">
                                {{ $log->entity_type }} #{{ $log->entity_id }}
                            </td>
                            <td class="px-4 py-3 text-text-primary">
                                {{ $log->reason ?: '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-text-secondary">Belum ada catatan audit log.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($auditLogs->hasPages())
            <div class="p-4 border-t border-border">
                {{ $auditLogs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
