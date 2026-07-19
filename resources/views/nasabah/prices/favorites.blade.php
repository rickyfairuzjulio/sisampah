@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="favoritePrices()">

    <x-role-nav role="nasabah" />

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
                    <span class="text-on-surface font-semibold ml-1 md:ml-2">Harga Favorit Saya</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 animate-fade-in">
        <div>
            <h1 class="text-3xl font-bold text-on-surface flex items-center gap-3">
                <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                Harga Favorit Saya
            </h1>
            <p class="text-on-surface-variant mt-1 text-sm">Pantau terus pergerakan harga sampah langganan Anda.</p>
        </div>
    </div>

    {{-- Grid Catalog --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 animate-slide-in">
        @forelse($favorites as $favorite)
            @php $price = $favorite->trashCategory; @endphp
            @if($price && !$price->is_archived)
            <div class="group bg-surface rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-outline-variant overflow-hidden flex flex-col h-full hover:-translate-y-1 relative" x-ref="card{{ $price->id }}">
                
                {{-- Card Image / Header --}}
                <a href="{{ route('nasabah.prices.show', $price->id) }}" class="block relative h-48 overflow-hidden bg-surface-container-high">
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
                    </div>
                </a>

                {{-- Remove Button --}}
                <button @click.prevent="removeFavorite({{ $price->id }})" class="absolute top-3 right-3 p-2 rounded-full bg-white/90 text-red-500 hover:bg-red-50 transition-all shadow-sm z-10 hover:scale-110" title="Hapus dari Favorit">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                {{-- Card Body --}}
                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-2 gap-2">
                        <a href="{{ route('nasabah.prices.show', $price->id) }}" class="text-lg font-bold text-on-surface hover:text-primary transition-colors line-clamp-1 flex-1">
                            {{ $price->nama }}
                        </a>
                        <span class="text-[10px] font-mono bg-surface-container px-1.5 py-0.5 rounded text-on-surface-variant flex-shrink-0">{{ $price->kode }}</span>
                    </div>
                    
                    <p class="text-xs text-on-surface-variant line-clamp-2 mb-4 flex-1">
                        {{ $price->jenis ?: 'Kategori sampah ' . $price->kategori }}
                    </p>

                    <div class="pt-4 border-t border-outline-variant mt-auto">
                        <p class="text-[10px] text-on-surface-variant font-semibold uppercase tracking-wider mb-1">Harga Beli Pengepul</p>
                        <div class="flex justify-between items-end">
                            <div>
                                <span class="text-2xl font-black text-primary leading-none">Rp {{ number_format($price->harga_per_kg, 0, ',', '.') }}</span>
                                <span class="text-xs font-medium text-on-surface-variant">/{{ $price->satuan }}</span>
                            </div>
                            
                            <div class="inline-flex items-center gap-1 px-2 py-1 rounded text-[10px] font-bold {{ $price->price_status_bg }}">
                                <span>{{ $price->price_status_icon }}</span>
                                <span>{{ abs($price->perubahan_persen) }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @empty
            <div class="col-span-full py-20 flex flex-col items-center justify-center text-center px-4">
                <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-red-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-on-surface mb-2">Belum ada harga favorit</h3>
                <p class="text-on-surface-variant max-w-md">Klik icon hati pada daftar harga sampah untuk menyimpannya ke halaman ini, agar Anda bisa memantaunya lebih mudah.</p>
                <a href="{{ route('nasabah.prices.index') }}" class="mt-6 px-6 py-2.5 bg-primary text-white font-bold rounded-xl hover:bg-primary-container transition-colors">
                    Lihat Katalog Harga
                </a>
            </div>
        @endforelse
    </div>

</div>

@push('scripts')
<script>
    function favoritePrices() {
        return {
            async removeFavorite(id) {
                try {
                    const response = await fetch(`/nasabah/prices/${id}/favorite`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.status === 'removed') {
                        // Fade out and remove the card visually
                        const card = this.$refs['card' + id];
                        if (card) {
                            card.style.opacity = '0';
                            card.style.transform = 'scale(0.95)';
                            setTimeout(() => {
                                card.remove();
                                // Optional: check if empty and reload if necessary
                                if (document.querySelectorAll('.group.bg-surface').length === 0) {
                                    window.location.reload();
                                }
                            }, 300);
                        }
                        window.dispatchEvent(new CustomEvent('notify', { detail: { type: 'success', message: 'Dihapus dari favorit.' }}));
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
