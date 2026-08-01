@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if(session('success'))
        <x-alert type="success" class="mb-6 animate-slide-in">{{ session('success') }}</x-alert>
    @endif

    <x-dashboard-hero
        title="Dashboard Manifes"
        subtitle="Kelola penjemputan pending, input timbangan, dan setoran mandiri"
        badge="Petugas Lapangan"
    />

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8 animate-slide-in">
        <x-stat-tile
            title="{{ $pickupRequests->total() }}"
            subtitle="Jemput Pending"
            badge="Aktif"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        />
        <x-stat-tile
            title="{{ $completedToday }}"
            subtitle="Selesai Hari Ini"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        />
        <x-stat-tile
            title="{{ number_format($totalWeightToday, 1) }} Kg"
            subtitle="Berat Hari Ini"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2"/></svg>'
        />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
        <a href="{{ route('petugas.self_deposit.form') }}" class="quick-action-card">
            <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div><p class="font-semibold text-sm">Setor Mandiri</p><p class="text-xs text-on-surface-variant">Cari nasabah & input setoran</p></div>
        </a>
        <div class="quick-action-card opacity-80">
            <div class="w-11 h-11 bg-primary/15 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div><p class="font-semibold text-sm">Foto Bukti Transaksi</p><p class="text-xs text-on-surface-variant">Tersedia di form timbangan & setoran</p></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <x-card class="border border-outline-variant">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                    <div>
                        <h2 class="text-xl font-bold text-on-surface">Manifes Penjemputan</h2>
                        <p class="text-sm text-on-surface-variant mt-1">Daftar permintaan jemput dari nasabah</p>
                    </div>
                    <div class="self-start sm:self-auto">
                        <span class="text-xs font-bold px-3 py-1.5 bg-amber-100 text-amber-800 rounded-full border border-amber-200 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                            {{ $pickupRequests->total() }} Menunggu
                        </span>
                    </div>
                </div>

                <div class="space-y-3">
                    @forelse($pickupRequests as $request)
                        <div class="flex flex-col p-5 rounded-2xl bg-surface-container-lowest border border-outline-variant hover:border-primary/50 hover:shadow-lg transition-all duration-300 gap-4 group">
                            
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-xl shadow-sm border border-outline-variant/30 group-hover:bg-primary/10 transition-colors">
                                        👤
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-on-surface text-lg leading-tight">{{ $request->user->name }}</h3>
                                        <p class="text-xs font-semibold text-primary flex items-center gap-1 mt-0.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ $request->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <span class="bg-amber-100 text-amber-700 text-xs font-black px-2.5 py-1 rounded-lg border border-amber-200">
                                    PENDING
                                </span>
                            </div>

                            <div class="bg-surface-container-low rounded-xl p-3 grid grid-cols-2 gap-3 text-sm border border-outline-variant/50">
                                <div>
                                    <p class="text-on-surface-variant text-xs mb-0.5">Total Jenis Sampah</p>
                                    <p class="font-bold text-on-surface flex items-center gap-1">
                                        <svg class="w-4 h-4 text-forest-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                                        {{ $request->total_items }} Jenis
                                    </p>
                                </div>
                                <div>
                                    <p class="text-on-surface-variant text-xs mb-0.5">Total Estimasi Berat</p>
                                    <p class="font-bold text-on-surface flex items-center gap-1">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2"/></svg>
                                        {{ $request->total_berat }} Kg
                                    </p>
                                </div>
                            </div>

                            <div class="flex mt-1">
                                <a href="{{ route('petugas.weighing.form', $request->user_id) }}"
                                   class="w-full py-3 bg-gradient-to-r from-primary to-forest-emerald hover:from-primary-container hover:to-primary text-white text-sm font-bold rounded-xl text-center shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 group-hover:-translate-y-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Terima & Timbang
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-12 h-12 text-outline-variant mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-on-surface-variant text-sm">Tidak ada permintaan jemput pending</p>
                        </div>
                    @endforelse
                </div>

                @if($pickupRequests->hasPages())
                    <div class="mt-4">{{ $pickupRequests->links() }}</div>
                @endif
            </x-card>
        </div>

        <div>
            <x-card class="border border-outline-variant">
                <h3 class="text-lg font-bold text-on-surface mb-4">Penimbangan Terbaru</h3>
                <div class="space-y-3">
                    @forelse($recentWeighing as $item)
                        <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant">
                            <p class="font-semibold text-sm">{{ $item->user->name ?? '-' }}</p>
                            <p class="text-xs text-on-surface-variant">{{ $item->trashCategory->nama ?? '-' }} · {{ $item->berat_kg }} Kg</p>
                            <p class="text-sm font-bold text-primary mt-1">Rp {{ number_format($item->total_rp, 0, ',', '.') }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-on-surface-variant text-center py-4">Belum ada penimbangan</p>
                    @endforelse
                </div>
            </x-card>

            <x-card class="mt-6 bg-gradient-to-br from-primary/5 to-forest-emerald/10 border border-primary/20">
                <h3 class="text-base font-bold text-primary mb-3">Info Petugas</h3>
                <ul class="space-y-2 text-sm text-on-surface">
                    <li>Input timbangan otomatis menambah saldo & poin nasabah</li>
                    <li>Upload foto bukti di form timbangan/setoran</li>
                    <li>Harga tercatat sebagai snapshot saat transaksi</li>
                </ul>
            </x-card>
        </div>
    </div>
</div>
@endsection
