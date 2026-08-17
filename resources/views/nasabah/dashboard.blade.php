@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if(session('success'))
        <x-alert type="success" class="mb-6 animate-slide-in">{{ session('success') }}</x-alert>
    @endif

    <x-dashboard-hero
        :title="'Halo, ' . explode(' ', Auth::user()->name)[0] . '!'"
        subtitle="Kelola sampah Anda, pantau saldo, dan jadwalkan penjemputan"
        badge="Nasabah"
    />

    @php
        $userLeaderboard = Auth::user()->leaderboard;
        $lvl = $userLeaderboard ? $userLeaderboard->level : 1;
        $badgeName = $userLeaderboard ? $userLeaderboard->badge_name : 'Warga Peduli';
        $badgeIcon = $userLeaderboard ? $userLeaderboard->badge_icon : '🥉';
        $badgeColor = $userLeaderboard ? $userLeaderboard->badge_color : 'from-orange-700 to-orange-900';
        $xpPercent = $userLeaderboard ? $userLeaderboard->xp_percentage : 0;
        $nextXp = $userLeaderboard ? $userLeaderboard->next_level_xp : 100;
        $currentXp = $userLeaderboard ? $userLeaderboard->total_poin_lingkungan : 0;
    @endphp

    <div class="mb-6 animate-slide-in">
        <div class="card p-5 sm:p-6 flex flex-col sm:flex-row items-center gap-5">
            <div class="relative shrink-0">
                <div class="w-16 h-16 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-3xl">
                    {{ $badgeIcon }}
                </div>
                <div class="absolute -bottom-1.5 -right-1.5 bg-slate-900 text-white text-[10px] font-bold px-2 py-0.5 rounded-full border border-slate-700">
                    LV {{ $lvl }}
                </div>
            </div>
            <div class="flex-1 w-full text-center sm:text-left">
                <h3 class="text-lg font-bold text-text-primary">{{ $badgeName }}</h3>
                <p class="text-xs text-text-secondary font-medium mt-0.5 mb-3">{{ number_format($currentXp, 0) }} / {{ number_format($nextXp, 0) }} Poin Lingkungan</p>
                
                <div class="w-full h-2.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" style="width: {{ $xpPercent }}%;"></div>
                </div>
                @if($lvl < 4)
                    <p class="text-[11px] text-text-muted mt-1.5 text-right">{{ 100 - $xpPercent }}% menuju Level {{ $lvl + 1 }}</p>
                @else
                    <p class="text-[11px] text-emerald-500 font-semibold mt-1.5 text-right">Maksimal Level Tercapai 🎉</p>
                @endif
            </div>
        </div>
    </div>

    <!-- E-Wallet & Quick Actions Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8 animate-slide-in">
        
        <!-- Saldo Card -->
        <div class="lg:col-span-5 rounded-2xl bg-emerald-600 dark:bg-emerald-700 p-6 text-white flex flex-col justify-between shadow-sm">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <p class="text-emerald-100 text-xs font-medium mb-1">Total Saldo Aktif</p>
                    <h2 class="text-2xl font-bold tracking-tight">Rp {{ number_format($saldo, 0, ',', '.') }}</h2>
                </div>
                <div class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center border border-white/20">
                    <i class="bi bi-wallet2 text-white text-base"></i>
                </div>
            </div>

            <div class="flex items-center justify-between mt-auto pt-4 border-t border-white/15">
                <span class="text-xs font-semibold text-emerald-100">SiSampah Pay</span>
                <a href="{{ route('nasabah.wallet') }}#withdrawal-form" class="inline-flex items-center justify-center px-3.5 py-1.5 bg-white text-emerald-800 text-xs font-semibold rounded-lg hover:bg-emerald-50 transition-colors">
                    Tarik Dana
                </a>
            </div>
        </div>

        <!-- Right Side: Stats & Quick Actions -->
        <div class="lg:col-span-7 flex flex-col gap-5">
            <!-- 3 Mini Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                <x-stat-tile
                    title="{{ number_format($totalBerat, 1) }} Kg"
                    subtitle="Berat Setor"
                    icon='<i class="bi bi-box-seam text-lg"></i>'
                />
                <x-stat-tile
                    title="{{ number_format($totalPoin, 0) }}"
                    subtitle="Total Poin"
                    icon='<i class="bi bi-star text-lg"></i>'
                />
                <x-stat-tile
                    title="{{ collect($transaksiTerbaru)->count() }}"
                    subtitle="Transaksi"
                    icon='<i class="bi bi-arrow-left-right text-lg"></i>'
                />
            </div>

            <!-- 4 Quick Actions -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 flex-1">
                <a href="{{ route('nasabah.pickup.form') }}" class="card p-4 flex flex-col items-center justify-center text-center hover:border-emerald-500/50 transition-colors">
                    <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center mb-2">
                        <i class="bi bi-truck text-lg"></i>
                    </div>
                    <p class="font-bold text-xs text-text-primary mb-0.5">Jemput</p>
                    <p class="text-[10px] text-text-muted hidden sm:block">GPS & Jadwal</p>
                </a>
                
                <a href="{{ route('nasabah.wallet') }}" class="card p-4 flex flex-col items-center justify-center text-center hover:border-emerald-500/50 transition-colors">
                    <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center mb-2">
                        <i class="bi bi-wallet2 text-lg"></i>
                    </div>
                    <p class="font-bold text-xs text-text-primary mb-0.5">Dompet</p>
                    <p class="text-[10px] text-text-muted hidden sm:block">Tunai / Tf</p>
                </a>

                <a href="{{ route('nasabah.wallet') }}#withdrawal-form" class="card p-4 flex flex-col items-center justify-center text-center hover:border-emerald-500/50 transition-colors">
                    <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center mb-2">
                        <i class="bi bi-box-arrow-up-right text-lg"></i>
                    </div>
                    <p class="font-bold text-xs text-text-primary mb-0.5">Tarik Dana</p>
                    <p class="text-[10px] text-text-muted hidden sm:block">Ajukan Tarik</p>
                </a>

                <a href="{{ route('nasabah.edukasi') }}" class="card p-4 flex flex-col items-center justify-center text-center hover:border-emerald-500/50 transition-colors">
                    <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center mb-2">
                        <i class="bi bi-book text-lg"></i>
                    </div>
                    </div>
                    <p class="font-bold text-sm text-on-surface mb-0.5">Edukasi</p>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-wider hidden sm:block">Artikel Tips</p>
                </a>
            </div>
        </div>
    </div>

    {{-- PETA GIS BANK SAMPAH & RADIUS PENJEMPUTAN UNTUK NASABAH --}}
    <x-card class="border border-border/80 dark:border-white/10 overflow-hidden shadow-soft mb-8 animate-slide-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-border/60 mb-4">
            <div>
                <h2 class="text-base font-black text-on-surface flex items-center gap-2">
                    <i class="bi bi-geo-alt-fill text-emerald-500 text-lg"></i>
                    Lokasi Bank Sampah & Radius Penjemputan
                </h2>
                <p class="text-xs text-on-surface-variant mt-0.5">Lihat titik lokasi Bank Sampah terdekat dan cakupan wilayah area penjemputan sampah ke rumah Anda.</p>
            </div>
            <a href="{{ route('nasabah.pickup.form') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-xs flex items-center gap-2 shadow-sm transition-all shrink-0">
                <i class="bi bi-truck-front-fill"></i>
                Pesan Penjemputan
            </a>
        </div>

        <div id="nasabahGisMap" class="w-full h-[360px] rounded-2xl border border-border/80 overflow-hidden z-10"></div>
    </x-card>

    {{-- ═══════════════ DAMPAK LINGKUNGAN (CARBON FOOTPRINT) ═══════════════ --}}
    <div class="mb-10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-5 gap-3">
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-bold text-on-surface">Dampak Lingkungan Anda</h2>
                @if($impact['isGreenStarter'])
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold border border-green-200" title="Anda telah menyetor lebih dari 10kg sampah">
                        <span>🌿</span> Green Starter
                    </div>
                @endif
            </div>
            
            <a href="{{ route('nasabah.certificate') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-sm font-bold rounded-lg shadow-md transition-all hover:scale-105 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                Lihat Sertifikat Rapor
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Metrik Counter --}}
            <div class="lg:col-span-1 grid grid-cols-2 gap-4" x-data="{
                animateValue(obj, start, end, duration) {
                    let startTimestamp = null;
                    const step = (timestamp) => {
                        if (!startTimestamp) startTimestamp = timestamp;
                        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                        obj.innerHTML = (progress * (end - start) + start).toFixed(2).replace(/[.,]00$/, '');
                        if (progress < 1) {
                            window.requestAnimationFrame(step);
                        }
                    };
                    window.requestAnimationFrame(step);
                }
            }" x-init="
                $nextTick(() => {
                    animateValue($refs.co2, 0, {{ $impact['co2'] }}, 2000);
                    animateValue($refs.pohon, 0, {{ $impact['pohon'] }}, 2000);
                    animateValue($refs.energi, 0, {{ $impact['energi'] }}, 2000);
                    animateValue($refs.air, 0, {{ $impact['air'] }}, 2000);
                });
            ">
                <x-card class="border-t-4 border-t-gray-500 !p-5 flex flex-col justify-center text-center">
                    <div class="mb-3 flex justify-center">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                    </div>
                    <p class="text-2xl font-black text-on-surface"><span x-ref="co2">0</span> <span class="text-sm font-semibold">Kg</span></p>
                    <p class="text-xs text-on-surface-variant font-medium mt-1">CO₂ Dikurangi</p>
                </x-card>
                
                <x-card class="border-t-4 border-t-forest-emerald !p-5 flex flex-col justify-center text-center">
                    <div class="mb-3 flex justify-center">
                        <svg class="w-8 h-8 text-forest-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 21C11 21 11 14 16 9C19 6 22 5 22 5C22 5 21 8 18 11C13 16 13 21 13 21H11Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21C10 21 10 16 5 11C2 8 1 7 1 7C1 7 2 10 5 13C10 18 10 21 10 21H10Z"/></svg>
                    </div>
                    <p class="text-2xl font-black text-on-surface"><span x-ref="pohon">0</span></p>
                    <p class="text-xs text-on-surface-variant font-medium mt-1">Pohon Diselamatkan</p>
                </x-card>

                <x-card class="border-t-4 border-t-amber-500 !p-5 flex flex-col justify-center text-center">
                    <div class="mb-3 flex justify-center">
                        <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <p class="text-2xl font-black text-on-surface"><span x-ref="energi">0</span> <span class="text-sm font-semibold">kWh</span></p>
                    <p class="text-xs text-on-surface-variant font-medium mt-1">Energi Dihemat</p>
                </x-card>

                <x-card class="border-t-4 border-t-blue-500 !p-5 flex flex-col justify-center text-center">
                    <div class="mb-3 flex justify-center">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a9 9 0 0018 0c0-4.97-9-15-9-15S3 10.03 3 15z"/></svg>
                    </div>
                    <p class="text-2xl font-black text-on-surface"><span x-ref="air">0</span> <span class="text-sm font-semibold">L</span></p>
                    <p class="text-xs text-on-surface-variant font-medium mt-1">Air Dihemat</p>
                </x-card>
            </div>

            {{-- Grafik Bulanan --}}
            <x-card class="lg:col-span-2 border border-outline-variant relative">
                <p class="text-sm font-bold text-on-surface-variant mb-4">Aktivitas Setor Bulanan (Kg)</p>
                <div class="h-56 w-full">
                    <canvas id="impactChart"></canvas>
                </div>
            </x-card>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <x-card class="border border-outline-variant">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-xl font-bold text-on-surface">Harga Sampah Terkini</h2>
                        <p class="text-sm text-on-surface-variant mt-1">Harga per kilogram hari ini</p>
                    </div>
                    <x-badge status="active" label="Live" />
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm data-table">
                        <thead><tr><th>Jenis</th><th class="text-right">Harga/Kg</th><th class="text-center">Status</th></tr></thead>
                        <tbody>
                            @forelse($hargaSampah as $kategori)
                                <tr>
                                    <td class="font-medium">{{ $kategori->nama }}</td>
                                    <td class="text-right font-bold text-primary">Rp {{ number_format($kategori->harga_per_kg, 0, ',', '.') }}</td>
                                    <td class="text-center"><x-badge status="completed" label="Aktif" /></td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center py-6 text-on-surface-variant">Belum ada data harga</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>

            <x-card class="border border-outline-variant">
                <div class="mb-5">
                    <h2 class="text-xl font-bold text-on-surface">Riwayat Transaksi</h2>
                    <p class="text-sm text-on-surface-variant mt-1">Mutasi saldo dari setoran sampah</p>
                </div>
                <div class="space-y-3" x-data="{ 
                    openRating: false, 
                    txId: null, 
                    rating: 0, 
                    hoverRating: 0,
                    ulasan: '',
                    openModal(id) { this.txId = id; this.rating = 0; this.hoverRating = 0; this.ulasan = ''; this.openRating = true; } 
                }">
                    @forelse($transaksiTerbaru as $transaksi)
                        <div class="group flex items-center justify-between p-4 rounded-2xl bg-surface-container-low hover:bg-surface border border-transparent hover:border-outline-variant transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 cursor-default flex-wrap gap-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary/10 group-hover:bg-primary/20 rounded-full flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2"/></svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm">{{ $transaksi->trashCategory->nama ?? 'Setoran Sampah' }}</p>
                                    <p class="text-xs text-on-surface-variant">{{ $transaksi->berat_kg }} Kg · {{ $transaksi->created_at->translatedFormat('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="text-right flex flex-col items-end gap-1">
                                <p class="font-bold text-primary text-sm">+Rp {{ number_format($transaksi->total_rp, 0, ',', '.') }}</p>
                                <div class="flex items-center gap-2">
                                    @if($transaksi->status === 'selesai')
                                        @if($transaksi->rating)
                                            <span class="text-xs text-amber-500 font-bold flex items-center gap-0.5">
                                                {{ $transaksi->rating }} <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            </span>
                                        @else
                                            <button @click="openModal('{{ $transaksi->id }}')" class="text-xs text-amber-600 bg-amber-50 hover:bg-amber-100 px-2 py-0.5 rounded font-bold transition-colors">Beri Ulasan</button>
                                        @endif
                                    @endif
                                    <x-badge :status="$transaksi->status === 'selesai' ? 'completed' : 'pending'" :label="ucfirst($transaksi->status)" />
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center py-8 text-on-surface-variant text-sm">Belum ada transaksi. Mulai dengan jadwalkan penjemputan!</p>
                    @endforelse

                    <!-- Modal Ulasan -->
                    <div x-show="openRating" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="openRating" x-transition.opacity class="fixed inset-0 bg-gray-900/75 transition-opacity backdrop-blur-sm" @click="openRating = false"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            
                            <div x-show="openRating" x-transition.scale class="inline-block align-bottom bg-surface-container rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-outline-variant">
                                <form :action="`/nasabah/transaksi/${txId}/rating`" method="POST">
                                    @csrf
                                    <div class="px-6 pt-6 pb-4">
                                        <div class="text-center mb-6">
                                            <h3 class="text-xl leading-6 font-bold text-on-surface mb-2" id="modal-title">Penilaian Transaksi</h3>
                                            <p class="text-sm text-on-surface-variant">Bagaimana pelayanan penjemputan/setoran Anda?</p>
                                        </div>
                                        
                                        <!-- Bintang -->
                                        <div class="flex justify-center gap-2 mb-6">
                                            <input type="hidden" name="rating" :value="rating">
                                            <template x-for="i in 5">
                                                <button type="button" @click="rating = i" @mouseenter="hoverRating = i" @mouseleave="hoverRating = 0" class="focus:outline-none transition-transform hover:scale-110">
                                                    <svg class="w-10 h-10" :class="(hoverRating >= i || rating >= i) ? 'text-amber-400 fill-current' : 'text-gray-300 stroke-current fill-transparent'" viewBox="0 0 20 20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                </button>
                                            </template>
                                        </div>

                                        <!-- Textarea -->
                                        <div>
                                            <label for="ulasan" class="block text-sm font-medium text-on-surface mb-2">Ulasan (Opsional)</label>
                                            <textarea name="ulasan" x-model="ulasan" rows="3" class="w-full bg-surface text-on-surface border border-outline-variant rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-shadow resize-none" placeholder="Ceritakan pengalaman Anda..."></textarea>
                                        </div>
                                    </div>
                                    <div class="px-6 py-4 bg-surface-container-low flex justify-end gap-3 rounded-b-2xl">
                                        <button type="button" @click="openRating = false" class="px-4 py-2 text-sm font-semibold text-on-surface-variant hover:text-on-surface transition-colors">Batal</button>
                                        <button type="submit" :disabled="rating === 0" class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg shadow-md hover:bg-primary-container transition-colors disabled:opacity-50 disabled:cursor-not-allowed">Kirim Ulasan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('nasabah.wallet') }}" class="block mt-4 text-center text-sm font-semibold text-primary hover:underline">Lihat semua transaksi & penarikan →</a>
            </x-card>
        </div>

        <div class="space-y-6">
            <x-card class="border border-outline-variant">
                <h3 class="text-lg font-bold text-on-surface mb-4">Papan Peringkat</h3>
                <div class="space-y-3">
                    @forelse($leaderboard as $index => $entry)
                        <div class="flex items-center gap-3 p-3 rounded-xl {{ $entry->user_id === Auth::id() ? 'bg-primary/10 border border-primary/20 shadow-inner' : 'bg-surface-container-low' }} transition-colors">
                            <div class="relative shrink-0">
                                <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold shadow-sm {{ $index == 0 ? 'bg-gradient-to-br from-amber-300 to-amber-500 text-white' : ($index == 1 ? 'bg-gradient-to-br from-gray-300 to-gray-500 text-white' : ($index == 2 ? 'bg-gradient-to-br from-orange-400 to-orange-600 text-white' : 'bg-surface-container-highest text-on-surface-variant')) }}">
                                    {{ $index + 1 }}
                                </span>
                                @if($index < 3)
                                    <span class="absolute -top-1 -right-1 text-xs">{{ $entry->badge_icon }}</span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate text-on-surface flex items-center gap-1">
                                    {{ $entry->user->name }}
                                    @if($entry->user_id === Auth::id())
                                        <span class="text-[10px] bg-primary text-white px-1.5 py-0.5 rounded-full font-bold ml-1">Anda</span>
                                    @endif
                                </p>
                                <p class="text-xs font-medium bg-clip-text text-transparent bg-gradient-to-r {{ $entry->badge_color }} inline-block">{{ $entry->badge_name }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-xs font-bold text-on-surface">{{ number_format($entry->total_poin_lingkungan, 0) }}</p>
                                <p class="text-[10px] text-on-surface-variant uppercase tracking-wider">Poin</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-on-surface-variant text-center py-4">Belum ada data peringkat</p>
                    @endforelse
                </div>
            </x-card>

            <x-card class="bg-gradient-to-br from-primary/5 to-forest-emerald/10 border border-primary/20">
                <h3 class="text-base font-bold text-primary mb-3">Tips Nasabah</h3>
                <ul class="space-y-2 text-sm text-on-surface">
                    <li class="flex gap-2"><span class="text-primary font-bold">•</span>Pisahkan sampah organik & anorganik</li>
                    <li class="flex gap-2"><span class="text-primary font-bold">•</span>Gunakan fitur GPS saat jadwalkan jemput</li>
                    <li class="flex gap-2"><span class="text-primary font-bold">•</span>Kumpulkan poin untuk naik peringkat</li>
                </ul>
            </x-card>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('impactChart');
        if (ctx) {
            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';
            const textColor = isDark ? 'rgba(255, 255, 255, 0.7)' : 'rgba(0, 0, 0, 0.7)';

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartData['labels']) !!},
                    datasets: [{
                        label: 'Sampah Terkelola (Kg)',
                        data: {!! json_encode($chartData['data']) !!},
                        backgroundColor: '#1D9E75',
                        borderRadius: 6,
                        barThickness: 24
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: gridColor },
                            ticks: { color: textColor, font: { family: 'Inter' } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: textColor, font: { family: 'Inter' } }
                        }
                    }
                }
            });
        // GIS Map Initialization for Nasabah
        const bankData = @json($bankSampahs ?? []);
        const mapContainer = document.getElementById('nasabahGisMap');

        if (mapContainer && bankData && bankData.length > 0) {
            const defaultLat = parseFloat(bankData[0].latitude) || -6.8915;
            const defaultLng = parseFloat(bankData[0].longitude) || 107.6107;

            const map = L.map('nasabahGisMap').setView([defaultLat, defaultLng], 9);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                maxZoom: 19,
                attribution: '&copy; CARTO & OpenStreetMap'
            }).addTo(map);

            const bounds = [];

            bankData.forEach(bank => {
                if (bank.latitude && bank.longitude) {
                    const lat = parseFloat(bank.latitude);
                    const lng = parseFloat(bank.longitude);
                    const radiusMeters = bank.radius_layanan ? parseInt(bank.radius_layanan) : 2000;
                    bounds.push([lat, lng]);

                    // Service Radius Circle
                    L.circle([lat, lng], {
                        color: '#10B981',
                        fillColor: '#10B981',
                        fillOpacity: 0.15,
                        weight: 2,
                        dashArray: '5, 5'
                    }).addTo(map);

                    // Marker
                    const marker = L.marker([lat, lng]).addTo(map);

                    const popupHtml = `
                        <div class="space-y-1.5 p-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 rounded-md text-[10px] font-black">${bank.kode_bank}</span>
                                <h4 class="font-bold text-xs text-white">${bank.nama}</h4>
                            </div>
                            <p class="text-[11px] text-gray-300">${bank.alamat}</p>
                            <div class="pt-1.5 border-t border-white/10 text-[10px] text-emerald-300 font-semibold space-y-0.5">
                                <div><i class="bi bi-geo text-[10px]"></i> Jangkauan Penjemputan: <strong>${(radiusMeters/1000).toFixed(1)} km</strong></div>
                                <div><i class="bi bi-clock text-[10px]"></i> Jam Buka: ${bank.jam_buka || '08:00'} - ${bank.jam_tutup || '16:00'}</div>
                            </div>
                        </div>
                    `;
                    marker.bindPopup(popupHtml);
                }
            });

            if (bounds.length > 0) {
                map.fitBounds(bounds, { padding: [30, 30] });
            }
        }
    });
</script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <style>
        .leaflet-popup-content-wrapper { border-radius: 16px; padding: 4px; background: #0A241B; color: #ffffff; border: 1px solid rgba(255,255,255,0.12); box-shadow: 0 10px 25px rgba(0,0,0,0.5); }
        .leaflet-popup-content { margin: 10px 12px; width: 260px !important; }
        .leaflet-container { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
@endpush
@endsection
