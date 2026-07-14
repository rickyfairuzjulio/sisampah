@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if(session('success'))
        <x-alert type="success" class="mb-6 animate-slide-in">{{ session('success') }}</x-alert>
    @endif

    <x-role-nav role="admin" />

    <x-dashboard-hero
        title="Dashboard Admin"
        subtitle="Statistik komprehensif dan manajemen sistem SiSampah"
        gradient="from-[#1a1c1b] to-[#2d4a3e]"
        badge="Administrator"
    />

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8 animate-slide-in">
        <x-stat-tile
            title="{{ $totalNasabah }}"
            subtitle="Total Nasabah"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2z"/></svg>'
        />
        <x-stat-tile
            title="{{ number_format($totalSampahKg, 1) }} Kg"
            subtitle="Sampah Terolah"
            trend="up"
            trendValue="{{ number_format($transaksiHariIni, 1) }} Kg hari ini"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2"/></svg>'
        />
        <x-stat-tile
            title="{{ $totalTransaksi }}"
            subtitle="Total Transaksi"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>'
        />
        <x-stat-tile
            title="{{ $pendingWithdrawals }}"
            subtitle="Penarikan Pending"
            badge="Perlu Aksi"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <a href="{{ route('admin.trash_price.index') }}" class="quick-action-card">
            <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center"><svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1"/></svg></div>
            <div><p class="font-semibold text-sm">Harga Sampah</p><p class="text-xs text-on-surface-variant">Per kategori</p></div>
        </a>
        <a href="{{ route('admin.finance.validate') }}" class="quick-action-card">
            <div class="w-11 h-11 bg-green-100 rounded-xl flex items-center justify-center"><svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></div>
            <div><p class="font-semibold text-sm">Validasi Keuangan</p><p class="text-xs text-on-surface-variant">Upload resi</p></div>
        </a>
        <a href="{{ route('admin.reports') }}" class="quick-action-card">
            <div class="w-11 h-11 bg-purple-100 rounded-xl flex items-center justify-center"><svg class="w-5 h-5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
            <div><p class="font-semibold text-sm">Laporan</p><p class="text-xs text-on-surface-variant">Filter RT/RW & CSV</p></div>
        </a>
        <a href="{{ route('admin.articles.index') }}" class="quick-action-card">
            <div class="w-11 h-11 bg-amber-100 rounded-xl flex items-center justify-center"><svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></div>
            <div><p class="font-semibold text-sm">Artikel Edukasi</p><p class="text-xs text-on-surface-variant">Kelola konten</p></div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <x-card class="border border-outline-variant" hover="true">
            <h2 class="text-xl font-extrabold text-on-surface mb-5 flex items-center gap-2">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Perbandingan Sampah per RT
            </h2>
            @php $maxSaldo = $rtComparison->max('total_saldo') ?: 1; @endphp
            <div class="space-y-4">
                @forelse($rtComparison as $rt)
                    <div>
                        <div class="flex justify-between text-sm mb-1.5">
                            <span class="font-semibold">RT {{ $rt->rt ?? 'N/A' }}</span>
                            <span class="text-on-surface-variant">{{ $rt->jumlah_nasabah }} nasabah · Rp {{ number_format($rt->total_saldo, 0, ',', '.') }}</span>
                        </div>
                        <div class="w-full h-3 bg-surface-container rounded-full overflow-hidden">
                            <div class="h-full bg-primary rounded-full transition-all" style="width: {{ min(($rt->total_saldo / $maxSaldo) * 100, 100) }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-on-surface-variant text-center py-6">Belum ada data per RT</p>
                @endforelse
            </div>
        </x-card>

        <x-card class="border border-outline-variant" hover="true">
            <h2 class="text-xl font-extrabold text-on-surface mb-5 flex items-center gap-2">
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                Top Kontributor
            </h2>
            <div class="space-y-3">
                @forelse($topContributors->take(5) as $index => $contributor)
                    <div class="flex items-center gap-4 p-3.5 rounded-2xl bg-surface-container-low border border-outline-variant hover:border-primary hover:bg-surface-container transition-all duration-300">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-extrabold {{ $index == 0 ? 'bg-amber-100 text-amber-700 border border-amber-300' : ($index == 1 ? 'bg-slate-100 text-slate-700 border border-slate-300' : ($index == 2 ? 'bg-orange-100 text-orange-800 border border-orange-300' : 'bg-primary/10 text-primary')) }}">
                            #{{ $index + 1 }}
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-sm text-on-surface">{{ $contributor->user->name ?? '-' }}</p>
                            <p class="text-xs text-on-surface-variant font-medium mt-0.5">{{ number_format($contributor->total_berat_kg, 1) }} Kg · <span class="text-primary">{{ number_format($contributor->total_poin_lingkungan, 0) }} poin</span></p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-on-surface-variant text-center py-6">Belum ada data kontributor</p>
                @endforelse
            </div>
        </x-card>
    </div>

    <x-card class="border border-outline-variant" hover="true">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-extrabold text-on-surface flex items-center gap-2">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Ringkasan Sistem
                </h2>
                <p class="text-sm text-on-surface-variant font-medium mt-1">{{ $totalPetugas }} petugas aktif · {{ $pendingWithdrawals }} penarikan menunggu validasi</p>
            </div>
            <a href="{{ route('admin.reports.export') }}" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-container transition-colors">
                Ekspor CSV
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-4 rounded-xl bg-green-50 border border-green-100 text-center">
                <p class="text-2xl font-bold text-green-700">{{ $totalNasabah }}</p>
                <p class="text-xs text-green-600 mt-1">Nasabah Terdaftar</p>
            </div>
            <div class="p-4 rounded-xl bg-blue-50 border border-blue-100 text-center">
                <p class="text-2xl font-bold text-blue-700">{{ $totalPetugas }}</p>
                <p class="text-xs text-blue-600 mt-1">Petugas Aktif</p>
            </div>
            <div class="p-4 rounded-xl bg-amber-50 border border-amber-100 text-center">
                <p class="text-2xl font-bold text-amber-700">{{ number_format($transaksiHariIni, 1) }} Kg</p>
                <p class="text-xs text-amber-600 mt-1">Sampah Hari Ini</p>
            </div>
        </div>
    </x-card>
</div>
@endsection
