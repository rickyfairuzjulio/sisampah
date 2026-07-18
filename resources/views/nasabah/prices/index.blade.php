@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="priceCatalog()">

    <x-role-nav role="nasabah" />

    {{-- Header Banner --}}
    <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-primary to-forest-emerald text-white shadow-xl mb-8 animate-fade-in h-48 md:h-56 flex items-center">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-overlay"></div>
        <div class="absolute inset-y-0 right-0 w-1/2 bg-gradient-to-l from-white/10 to-transparent"></div>
        <div class="relative z-10 px-8 md:px-12 w-full flex justify-between items-center">
            <div class="max-w-xl">
                <h1 class="text-3xl md:text-4xl font-black mb-2 tracking-tight">Katalog Harga Sampah</h1>
                <p class="text-primary-50 text-sm md:text-base leading-relaxed opacity-90 max-w-md">
                    Cek harga terbaru sebelum Anda setor! Pastikan pilah sampah Anda dengan baik untuk mendapatkan harga terbaik.
                </p>
            </div>
            <div class="hidden md:block">
                <svg class="w-32 h-32 opacity-20 transform rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="flex flex-col md:flex-row gap-4 justify-between items-center mb-8 animate-slide-in">
        <div class="w-full md:w-auto flex gap-2 overflow-x-auto pb-2 md:pb-0 hide-scrollbar">
            <a href="{{ route('nasabah.prices.index') }}" class="px-5 py-2 rounded-full whitespace-nowrap font-bold text-sm transition-all {{ !request('kategori') ? 'bg-primary text-white shadow-md' : 'bg-surface-container-high text-on-surface hover:bg-surface-container-highest' }}">
                Semua Kategori
            </a>
            <a href="{{ route('nasabah.prices.index', ['kategori' => 'organik']) }}" class="px-5 py-2 rounded-full whitespace-nowrap font-bold text-sm transition-all {{ request('kategori') == 'organik' ? 'bg-primary text-white shadow-md' : 'bg-surface-container-high text-on-surface hover:bg-surface-container-highest' }}">
                🍃 Organik
            </a>
            <a href="{{ route('nasabah.prices.index', ['kategori' => 'anorganik']) }}" class="px-5 py-2 rounded-full whitespace-nowrap font-bold text-sm transition-all {{ request('kategori') == 'anorganik' ? 'bg-primary text-white shadow-md' : 'bg-surface-container-high text-on-surface hover:bg-surface-container-highest' }}">
                ♻️ Anorganik
            </a>
            <a href="{{ route('nasabah.prices.index', ['kategori' => 'b3']) }}" class="px-5 py-2 rounded-full whitespace-nowrap font-bold text-sm transition-all {{ request('kategori') == 'b3' ? 'bg-primary text-white shadow-md' : 'bg-surface-container-high text-on-surface hover:bg-surface-container-highest' }}">
                ⚠️ B3 / Elektronik
            </a>
            <a href="{{ route('nasabah.prices.favorites') }}" class="px-5 py-2 rounded-full whitespace-nowrap font-bold text-sm transition-all bg-amber-100 text-amber-800 hover:bg-amber-200 border border-amber-200 flex items-center gap-1">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                Favorit Saya
            </a>
        </div>

        <form action="{{ route('nasabah.prices.index') }}" method="GET" class="w-full md:w-80">
            @if(request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari botol, kardus, dll..." class="w-full pl-11 pr-4 py-3 rounded-full border border-outline-variant focus:ring-primary focus:border-primary shadow-sm text-sm font-medium transition-all hover:border-gray-400">
            </div>
        </form>
    {{-- Grid Catalog --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6 animate-slide-in">
        @forelse($prices as $price)
            <div class="group bg-surface rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-outline-variant overflow-hidden flex flex-col h-full hover:-translate-y-1 relative">
                
                {{-- Card Image / Header --}}
                <a href="{{ route('nasabah.prices.show', $price->id) }}" class="block relative h-32 sm:h-48 overflow-hidden bg-surface-container-high">
                    @if($price->image_url)
                        <img src="{{ $price->image_url }}" alt="{{ $price->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-primary/30">
                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    
                    {{-- Badges --}}
                    <div class="absolute top-3 left-3 flex flex-col gap-1">
                        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-white/90 backdrop-blur text-on-surface rounded-md shadow-sm">
                            {{ $price->kategori_label }}
                        </span>
                        @if($price->kualitas === 'premium')
                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-purple-500/90 backdrop-blur text-white rounded-md shadow-sm">
                                Premium
                            </span>
                        @endif
                    </div>
                </a>

                {{-- Favorite Button Floating --}}
                @php $isFav = in_array($price->id, $favorites); @endphp
                <button @click.prevent="toggleFavorite({{ $price->id }})" class="absolute top-3 right-3 p-2 rounded-full backdrop-blur-md transition-all shadow-sm z-10"
                        :class="favorites.includes({{ $price->id }}) ? 'bg-white/90 text-red-500' : 'bg-black/20 hover:bg-white/90 text-white hover:text-red-500'">
                    <svg class="w-5 h-5 transition-transform hover:scale-110" :fill="favorites.includes({{ $price->id }}) ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>

                {{-- Card Body --}}
                <div class="p-3 sm:p-5 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-2 gap-1 sm:gap-2">
                        <a href="{{ route('nasabah.prices.show', $price->id) }}" class="text-sm sm:text-lg font-bold text-on-surface hover:text-primary transition-colors line-clamp-1 flex-1">
                            {{ $price->nama }}
                        </a>
                        <span class="text-[10px] font-mono bg-surface-container px-1.5 py-0.5 rounded text-on-surface-variant flex-shrink-0">{{ $price->kode }}</span>
                    </div>
                    
                    <p class="text-xs text-on-surface-variant line-clamp-2 mb-4 flex-1">
                        {{ $price->jenis ?: 'Kategori sampah ' . $price->kategori }}
                    </p>

                    <div class="pt-3 sm:pt-4 border-t border-outline-variant mt-auto">
                        <p class="text-[9px] sm:text-[10px] text-on-surface-variant font-semibold uppercase tracking-wider mb-1 hidden sm:block">Harga Beli Pengepul</p>
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-1 sm:gap-0">
                            <div>
                                <span class="text-base sm:text-2xl font-black text-primary leading-none">Rp {{ number_format($price->harga_per_kg, 0, ',', '.') }}</span>
                                <span class="text-[10px] sm:text-xs font-medium text-on-surface-variant">/{{ $price->satuan }}</span>
                            </div>
                            
                            <div class="inline-flex items-center gap-1 px-2 py-1 rounded text-[10px] font-bold {{ $price->price_status_bg }}">
                                <span>{{ $price->price_status_icon }}</span>
                                <span>{{ abs($price->perubahan_persen) }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 flex flex-col items-center justify-center text-center px-4">
                <div class="w-24 h-24 bg-surface-container rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-outline-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h3 class="text-xl font-bold text-on-surface mb-2">Tidak ada harga ditemukan</h3>
                <p class="text-on-surface-variant max-w-md">Kategori yang Anda cari tidak tersedia atau belum diupdate. Coba gunakan kata kunci lain.</p>
                <a href="{{ route('nasabah.prices.index') }}" class="mt-6 px-6 py-2.5 bg-primary text-white font-bold rounded-xl hover:bg-primary-container transition-colors">
                    Lihat Semua Harga
                </a>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($prices->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $prices->withQueryString()->links() }}
        </div>
    @endif

</div>

@push('scripts')
<script>
    function priceCatalog() {
        return {
            favorites: @json($favorites),
            
            async toggleFavorite(id) {
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
                        this.favorites.push(id);
                        // Optional: trigger toast
                        window.dispatchEvent(new CustomEvent('notify', { detail: { type: 'success', message: 'Ditambahkan ke favorit!' }}));
                    } else if (data.status === 'removed') {
                        this.favorites = this.favorites.filter(favId => favId !== id);
                        window.dispatchEvent(new CustomEvent('notify', { detail: { type: 'info', message: 'Dihapus dari favorit.' }}));
                    }
                } catch (error) {
                    console.error('Error toggling favorite:', error);
                    window.dispatchEvent(new CustomEvent('notify', { detail: { type: 'error', message: 'Terjadi kesalahan jaringan.' }}));
                }
            }
        }
    }
</script>
@endpush
@endsection
