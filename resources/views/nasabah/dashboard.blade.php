@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if(session('success'))
        <x-alert type="success" class="mb-6 animate-slide-in">{{ session('success') }}</x-alert>
    @endif

    <x-role-nav role="nasabah" />

    <x-dashboard-hero
        :title="'Halo, ' . explode(' ', Auth::user()->name)[0] . '!'"
        subtitle="Kelola sampah Anda, pantau saldo, dan jadwalkan penjemputan"
        gradient="from-[#00694c] to-[#1D9E75]"
        badge="Nasabah"
    />

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8 animate-slide-in">
        <x-stat-tile
            title="Rp {{ number_format($saldo, 0, ',', '.') }}"
            subtitle="Saldo Aktif"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        />
        <x-stat-tile
            title="{{ number_format($totalBerat, 1) }} Kg"
            subtitle="Total Berat Setor"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2"/></svg>'
        />
        <x-stat-tile
            title="{{ number_format($totalPoin, 0) }}"
            subtitle="Poin Lingkungan"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>'
        />
        <x-stat-tile
            title="{{ $transaksiTerbaru->count() }}"
            subtitle="Transaksi Terbaru"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>'
        />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <a href="{{ route('nasabah.pickup.form') }}" class="quick-action-card">
            <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div><p class="font-semibold text-sm">Jemput Sampah</p><p class="text-xs text-on-surface-variant">GPS & penjadwalan</p></div>
        </a>
        <a href="{{ route('nasabah.wallet') }}" class="quick-action-card">
            <div class="w-11 h-11 bg-primary/15 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
            <div><p class="font-semibold text-sm">Dompet & Penarikan</p><p class="text-xs text-on-surface-variant">Tunai / transfer</p></div>
        </a>
        <a href="{{ route('nasabah.wallet') }}#withdrawal-form" class="quick-action-card">
            <div class="w-11 h-11 bg-amber-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            </div>
            <div><p class="font-semibold text-sm">Tarik Dana</p><p class="text-xs text-on-surface-variant">Ajukan penarikan</p></div>
        </a>
        <a href="{{ route('nasabah.edukasi') }}" class="quick-action-card">
            <div class="w-11 h-11 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div><p class="font-semibold text-sm">Edukasi Daur Ulang</p><p class="text-xs text-on-surface-variant">Artikel & tips</p></div>
        </a>
    </div>

    {{-- ═══════════════ DAMPAK LINGKUNGAN (CARBON FOOTPRINT) ═══════════════ --}}
    <div class="mb-10">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-xl font-bold text-on-surface">Dampak Lingkungan Anda</h2>
            @if($impact['isGreenStarter'])
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold border border-green-200" title="Anda telah menyetor lebih dari 10kg sampah">
                    <span>🌿</span> Green Starter
                </div>
            @endif
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
                    <p class="text-3xl mb-2">☁️</p>
                    <p class="text-2xl font-black text-on-surface"><span x-ref="co2">0</span> <span class="text-sm font-semibold">Kg</span></p>
                    <p class="text-xs text-on-surface-variant font-medium mt-1">CO₂ Dikurangi</p>
                </x-card>
                
                <x-card class="border-t-4 border-t-forest-emerald !p-5 flex flex-col justify-center text-center">
                    <p class="text-3xl mb-2">🌲</p>
                    <p class="text-2xl font-black text-on-surface"><span x-ref="pohon">0</span></p>
                    <p class="text-xs text-on-surface-variant font-medium mt-1">Pohon Diselamatkan</p>
                </x-card>

                <x-card class="border-t-4 border-t-amber-500 !p-5 flex flex-col justify-center text-center">
                    <p class="text-3xl mb-2">⚡</p>
                    <p class="text-2xl font-black text-on-surface"><span x-ref="energi">0</span> <span class="text-sm font-semibold">kWh</span></p>
                    <p class="text-xs text-on-surface-variant font-medium mt-1">Energi Dihemat</p>
                </x-card>

                <x-card class="border-t-4 border-t-blue-500 !p-5 flex flex-col justify-center text-center">
                    <p class="text-3xl mb-2">💧</p>
                    <p class="text-2xl font-black text-on-surface"><span x-ref="air">0</span> <span class="text-sm font-semibold">L</span></p>
                    <p class="text-xs text-on-surface-variant font-medium mt-1">Air Dihemat</p>
                </x-card>
            </div>

            {{-- Grafik Bulanan --}}
            <x-card class="lg:col-span-2 border border-outline-variant/50 relative">
                <p class="text-sm font-bold text-on-surface-variant mb-4">Aktivitas Setor Bulanan (Kg)</p>
                <div class="h-56 w-full">
                    <canvas id="impactChart"></canvas>
                </div>
            </x-card>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <x-card class="border border-outline-variant/50">
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

            <x-card class="border border-outline-variant/50">
                <div class="mb-5">
                    <h2 class="text-xl font-bold text-on-surface">Riwayat Transaksi</h2>
                    <p class="text-sm text-on-surface-variant mt-1">Mutasi saldo dari setoran sampah</p>
                </div>
                <div class="space-y-3">
                    @forelse($transaksiTerbaru as $transaksi)
                        <div class="flex items-center justify-between p-4 rounded-xl bg-surface-container-low border border-outline-variant/30">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2"/></svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm">{{ $transaksi->trashCategory->nama ?? 'Setoran Sampah' }}</p>
                                    <p class="text-xs text-on-surface-variant">{{ $transaksi->berat_kg }} Kg · {{ $transaksi->created_at->translatedFormat('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-primary text-sm">+Rp {{ number_format($transaksi->total_rp, 0, ',', '.') }}</p>
                                <x-badge :status="$transaksi->status === 'selesai' ? 'completed' : 'pending'" :label="ucfirst($transaksi->status)" />
                            </div>
                        </div>
                    @empty
                        <p class="text-center py-8 text-on-surface-variant text-sm">Belum ada transaksi. Mulai dengan jadwalkan penjemputan!</p>
                    @endforelse
                </div>
                <a href="{{ route('nasabah.wallet') }}" class="block mt-4 text-center text-sm font-semibold text-primary hover:underline">Lihat semua transaksi & penarikan →</a>
            </x-card>
        </div>

        <div class="space-y-6">
            <x-card class="border border-outline-variant/50">
                <h3 class="text-lg font-bold text-on-surface mb-4">Papan Peringkat</h3>
                <div class="space-y-3">
                    @forelse($leaderboard as $index => $entry)
                        <div class="flex items-center gap-3 p-3 rounded-xl {{ $entry->user_id === Auth::id() ? 'bg-primary/10 border border-primary/20' : 'bg-surface-container-low' }}">
                            <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold {{ $index < 3 ? 'bg-primary text-white' : 'bg-surface-container text-on-surface-variant' }}">{{ $index + 1 }}</span>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate">{{ $entry->user->name }}</p>
                                <p class="text-xs text-on-surface-variant">{{ number_format($entry->total_poin_lingkungan, 0) }} poin</p>
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
        }
    });
</script>
@endpush
@endsection
