@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <x-role-nav role="admin" />

    <div class="mb-8 animate-fade-in">
        <div class="bg-gradient-to-r from-primary to-forest-emerald rounded-2xl p-6 shadow-lg text-white">
            <h1 class="text-2xl sm:text-3xl font-bold mb-1">Konfigurasi Wilayah</h1>
            <p class="text-white/80 text-sm">Daftar wilayah cakupan RT dan RW dari nasabah yang terdaftar saat ini.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 animate-slide-in">
        
        <!-- Kolom RT -->
        <x-card class="overflow-hidden">
            <div class="p-6 border-b border-outline-variant bg-surface-container-lowest">
                <h2 class="text-lg font-bold text-on-surface flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Daftar Rukun Tetangga (RT)
                </h2>
                <p class="text-xs text-on-surface-variant mt-1">Total: {{ $rtList->count() }} RT ter-cover</p>
            </div>
            <div class="p-6">
                @if($rtList->isEmpty())
                    <div class="text-center py-8 text-on-surface-variant">
                        <p>Belum ada data RT yang terdaftar.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($rtList->sort() as $rt)
                        <div class="bg-surface-container hover:bg-surface-container-high transition-colors p-4 rounded-xl border border-outline-variant text-center flex flex-col items-center justify-center">
                            <span class="text-2xl font-black text-primary">{{ str_pad($rt, 3, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-[10px] uppercase font-bold tracking-wider text-on-surface-variant mt-1">RT</span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </x-card>

        <!-- Kolom RW -->
        <x-card class="overflow-hidden">
            <div class="p-6 border-b border-outline-variant bg-surface-container-lowest">
                <h2 class="text-lg font-bold text-on-surface flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                    Daftar Rukun Warga (RW)
                </h2>
                <p class="text-xs text-on-surface-variant mt-1">Total: {{ $rwList->count() }} RW ter-cover</p>
            </div>
            <div class="p-6">
                @if($rwList->isEmpty())
                    <div class="text-center py-8 text-on-surface-variant">
                        <p>Belum ada data RW yang terdaftar.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($rwList->sort() as $rw)
                        <div class="bg-surface-container hover:bg-surface-container-high transition-colors p-4 rounded-xl border border-outline-variant text-center flex flex-col items-center justify-center">
                            <span class="text-2xl font-black text-forest-emerald">{{ str_pad($rw, 3, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-[10px] uppercase font-bold tracking-wider text-on-surface-variant mt-1">RW</span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </x-card>

    </div>

    <div class="mt-8 bg-blue-50 border border-blue-100 rounded-xl p-4 flex gap-3 text-sm text-blue-800 animate-fade-in" style="animation-delay: 200ms;">
        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div>
            <span class="font-bold">Info:</span> Saat ini halaman Konfigurasi Wilayah bersifat *read-only* (hanya menampilkan wilayah yang sudah didaftarkan secara organik oleh Nasabah saat registrasi). Penambahan pembatasan pendaftaran wilayah dapat dikembangkan di rilis berikutnya.
        </div>
    </div>

</div>
@endsection
