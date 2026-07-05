@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="priceDetail({{ $category->id }}, {{ $isFavorite ? 'true' : 'false' }})">

    {{-- Breadcrumbs --}}
    <nav class="flex mb-6 text-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('nasabah.prices.index') }}" class="text-on-surface-variant hover:text-primary inline-flex items-center font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Katalog Harga
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-on-surface font-semibold ml-1 md:ml-2 truncate max-w-[150px] sm:max-w-xs">{{ $category->nama }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-slide-in">
        
        {{-- Left: Image & Price Card --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-surface rounded-3xl overflow-hidden shadow-lg border border-outline-variant relative group">
                <div class="h-64 sm:h-72 w-full bg-surface-container relative">
                    @if($category->image_url)
                        <img src="{{ $category->image_url }}" alt="{{ $category->nama }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-forest-emerald/10">
                            <svg class="w-24 h-24 text-primary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    
                    {{-- Badges on Image --}}
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        <span class="px-3 py-1 bg-white/90 backdrop-blur font-bold text-xs rounded-full shadow">{{ $category->kode }}</span>
                        <span class="px-3 py-1 bg-primary/90 backdrop-blur text-white font-bold text-xs rounded-full shadow">{{ $category->kategori_label }}</span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-2xl font-black text-on-surface mb-1">{{ $category->nama }}</h1>
                            <p class="text-sm font-medium text-on-surface-variant">{{ $category->jenis }}</p>
                        </div>
                        <button @click="toggleFavorite()" class="p-3 rounded-full transition-colors flex-shrink-0"
                                :class="isFavorite ? 'bg-red-50 text-red-500' : 'bg-surface-container text-on-surface-variant hover:bg-red-50 hover:text-red-500'">
                            <svg class="w-6 h-6" :fill="isFavorite ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="bg-surface-container-lowest rounded-2xl p-5 border border-outline-variant mb-6 text-center">
                        <p class="text-xs text-on-surface-variant font-bold uppercase tracking-wider mb-2">Harga Diterima</p>
                        <div class="flex items-end justify-center gap-1 mb-3">
                            <span class="text-4xl font-black text-primary leading-none">Rp {{ number_format($category->harga_per_kg, 0, ',', '.') }}</span>
                            <span class="text-sm font-bold text-on-surface-variant mb-1">/{{ $category->satuan }}</span>
                        </div>
                        <div class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold {{ $category->price_status_bg }}">
                            <span>{{ $category->price_status_icon }}</span>
                            <span>{{ abs($category->perubahan_persen) }}% dari sebelumnya</span>
                        </div>
                    </div>

                    <a href="{{ route('nasabah.pickup.form') }}?kategori={{ $category->id }}" class="w-full flex items-center justify-center gap-2 bg-primary hover:bg-primary-container text-white font-bold py-3.5 px-4 rounded-xl shadow-md shadow-primary/20 transition-all hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        Jual Sekarang
                    </a>
                </div>
            </div>
        </div>

        {{-- Right: Details & Chart --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Info Tabs (Implemented simply) --}}
            <div class="bg-surface rounded-3xl p-6 shadow-sm border border-outline-variant">
                <h3 class="text-lg font-bold text-on-surface mb-4 border-b border-outline-variant/50 pb-2">Informasi Lengkap</h3>
                
                <p class="text-on-surface text-sm leading-relaxed mb-6">
                    {{ $category->deskripsi ?: 'Kategori ini tidak memiliki deskripsi spesifik.' }}
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-amber-50 rounded-2xl p-4 border border-amber-100">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h4 class="font-bold text-amber-900 text-sm">Tips Penyimpanan</h4>
                        </div>
                        <p class="text-sm text-amber-800 leading-relaxed">{{ $category->tips_penyimpanan ?: 'Tidak ada instruksi khusus. Simpan di tempat kering.' }}</p>
                    </div>
                    
                    <div class="bg-green-50 rounded-2xl p-4 border border-green-100">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h4 class="font-bold text-green-900 text-sm">Tips Menjual Max Harga</h4>
                        </div>
                        <p class="text-sm text-green-800 leading-relaxed">{{ $category->tips_menjual ?: 'Pastikan barang bersih dan dipilah sesuai jenisnya untuk mendapatkan harga terbaik.' }}</p>
                    </div>
                </div>
            </div>

            {{-- Chart --}}
            <div class="bg-surface rounded-3xl p-6 shadow-sm border border-outline-variant">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-on-surface">Tren Harga 30 Hari</h3>
                </div>
                
                <div class="h-64 w-full relative">
                    @if($histories->count() > 1)
                        <canvas id="publicChart"></canvas>
                    @else
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <svg class="w-12 h-12 text-outline-variant mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                            <p class="text-on-surface font-semibold">Belum cukup data historis</p>
                            <p class="text-on-surface-variant text-sm mt-1">Grafik akan muncul setelah ada perubahan harga beberapa kali.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
@if($histories->count() > 1)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const data = @json($histories);
        
        const labels = data.map(item => {
            const date = new Date(item.created_at);
            return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
        });
        
        const prices = data.map(item => item.harga_baru);
        
        const ctx = document.getElementById('publicChart').getContext('2d');
        
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.4)');
        gradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Harga',
                    data: prices,
                    borderColor: '#10b981',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#10b981',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        titleFont: { size: 12, family: "'Inter', sans-serif" },
                        bodyFont: { size: 14, family: "'Inter', sans-serif", weight: 'bold' },
                        padding: 10,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false, drawBorder: false }, ticks: { font: { family: "'Inter', sans-serif", size: 11 }, color: '#9ca3af' } },
                    y: { border: { display: false }, grid: { color: '#f3f4f6', drawBorder: false }, ticks: { font: { family: "'Inter', sans-serif", size: 11 }, color: '#9ca3af', callback: val => 'Rp ' + (val/1000) + 'k' } }
                }
            }
        });
    });
</script>
@endif

<script>
    function priceDetail(id, initialFav) {
        return {
            isFavorite: initialFav,
            
            async toggleFavorite() {
                try {
                    const response = await fetch(`/nasabah/prices/${id}/favorite`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.status === 'added') {
                        this.isFavorite = true;
                        window.dispatchEvent(new CustomEvent('notify', { detail: { type: 'success', message: 'Ditambahkan ke favorit!' }}));
                    } else if (data.status === 'removed') {
                        this.isFavorite = false;
                        window.dispatchEvent(new CustomEvent('notify', { detail: { type: 'info', message: 'Dihapus dari favorit.' }}));
                    }
                } catch (error) {
                    console.error('Error toggling favorite:', error);
                }
            }
        }
    }
</script>
@endpush
@endsection
