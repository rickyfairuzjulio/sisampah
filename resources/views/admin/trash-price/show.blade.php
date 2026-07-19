@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumbs --}}
    <nav class="flex mb-6 text-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-on-surface-variant hover:text-primary inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="{{ route('admin.trash_price.index') }}" class="text-on-surface-variant hover:text-primary ml-1 md:ml-2">Harga Sampah</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-on-surface font-semibold ml-1 md:ml-2">{{ $category->nama }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-slide-in">
        
        {{-- Left Column: Main Info --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Header Card --}}
            <x-card class="border border-outline-variant p-0 overflow-hidden">
                <div class="h-48 w-full bg-surface-container relative">
                    @if($category->image_url)
                        <img src="{{ $category->image_url }}" alt="{{ $category->nama }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-primary/20 to-forest-emerald/20">
                            <svg class="w-16 h-16 text-primary/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 flex gap-2">
                        <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-on-surface font-bold text-xs rounded-full shadow-sm">{{ $category->kode }}</span>
                        <span class="px-3 py-1 bg-primary text-white font-bold text-xs rounded-full shadow-sm">{{ $category->kategori_label }}</span>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-on-surface">{{ $category->nama }}</h1>
                            <p class="text-on-surface-variant font-medium mt-1">{{ $category->jenis }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-on-surface-variant font-semibold mb-1 uppercase tracking-wider">Harga Saat Ini</p>
                            <div class="flex items-end gap-2 justify-end">
                                <p class="text-4xl font-black text-primary leading-none">Rp {{ number_format($category->harga_per_kg, 0, ',', '.') }}</p>
                                <p class="text-sm text-on-surface-variant font-medium pb-1">/ {{ $category->satuan }}</p>
                            </div>
                            <div class="mt-2 flex items-center justify-end gap-1 text-sm font-semibold {{ $category->price_status_color }}">
                                <span>{{ $category->price_status_icon }}</span>
                                <span>{{ abs($category->perubahan_persen) }}% dari pembaruan terakhir</span>
                            </div>
                        </div>
                    </div>

                    <div class="prose prose-sm max-w-none text-on-surface">
                        <h4 class="text-base font-bold text-on-surface mb-2 border-b border-outline-variant pb-2">Deskripsi</h4>
                        <p class="mb-4">{{ $category->deskripsi ?: 'Tidak ada deskripsi tersedia.' }}</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <h4 class="text-sm font-bold text-on-surface mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    Manfaat Daur Ulang
                                </h4>
                                <p class="text-on-surface-variant">{{ $category->manfaat ?: '-' }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-on-surface mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Tips Penyimpanan
                                </h4>
                                <p class="text-on-surface-variant">{{ $category->tips_penyimpanan ?: '-' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <h4 class="text-sm font-bold text-on-surface mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Tips Menjual
                                </h4>
                                <p class="text-on-surface-variant">{{ $category->tips_menjual ?: '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Chart Section --}}
            @include('admin.trash-price.partials.chart-section')

            {{-- History Table --}}
            <x-card class="border border-outline-variant p-0 overflow-hidden">
                <div class="p-4 border-b border-outline-variant bg-surface-container-low flex justify-between items-center">
                    <h3 class="font-bold text-on-surface">Riwayat Perubahan Terakhir</h3>
                    <a href="{{ route('admin.trash_price.history', ['kategori_id' => $category->id]) }}" class="text-sm text-primary font-semibold hover:underline">Lihat Semua →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-on-surface-variant uppercase bg-surface-container font-semibold">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3 text-right">Harga Lama</th>
                                <th class="px-4 py-3 text-right">Harga Baru</th>
                                <th class="px-4 py-3 text-center">Selisih</th>
                                <th class="px-4 py-3">Alasan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            @forelse($histories as $history)
                                <tr class="hover:bg-surface-container-lowest">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <p class="font-medium text-on-surface">{{ $history->created_at->format('d M Y') }}</p>
                                        <p class="text-[10px] text-on-surface-variant">{{ $history->created_at->format('H:i') }} WIB</p>
                                    </td>
                                    <td class="px-4 py-3 text-right text-on-surface-variant">Rp {{ number_format($history->harga_lama, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right font-semibold text-on-surface">Rp {{ number_format($history->harga_baru, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-semibold {{ $history->change_bg }}">
                                            @if($history->change_direction == 'naik') ↑
                                            @elseif($history->change_direction == 'turun') ↓
                                            @else → @endif
                                            {{ abs($history->persentase_perubahan) }}%
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-xs text-on-surface-variant max-w-[200px] truncate" title="{{ $history->alasan }}">{{ $history->alasan ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-on-surface-variant">Belum ada riwayat perubahan harga.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>

        </div>

        {{-- Right Column: AI Prediction & Details --}}
        <div class="space-y-6">
            
            {{-- AI Prediction Card --}}
            <x-card class="border border-primary/30 bg-gradient-to-br from-primary/5 to-forest-emerald/10 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
                    <svg class="w-24 h-24 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                
                <h3 class="font-bold text-on-surface flex items-center gap-2 mb-4">
                    <span class="bg-primary text-white p-1.5 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    </span>
                    Prediksi Harga AI
                </h3>
                
                <div class="mb-4">
                    <p class="text-xs text-on-surface-variant font-semibold uppercase tracking-wider mb-1">Estimasi Harga (7 Hari ke depan)</p>
                    <div class="flex items-end gap-2">
                        <p class="text-3xl font-black text-primary">Rp {{ number_format($prediction['predicted_price'] ?? 0, 0, ',', '.') }}</p>
                        @if(isset($prediction['trend']))
                            <span class="text-sm font-bold pb-1 {{ $prediction['trend'] == 'naik' ? 'text-green-600' : ($prediction['trend'] == 'turun' ? 'text-red-600' : 'text-gray-500') }}">
                                @if($prediction['trend'] == 'naik') Naik ↑
                                @elseif($prediction['trend'] == 'turun') Turun ↓
                                @else Stabil → @endif
                            </span>
                        @endif
                    </div>
                </div>

                <div class="space-y-3 mb-4">
                    <div class="flex justify-between items-center text-sm border-b border-outline-variant pb-2">
                        <span class="text-on-surface-variant">Tingkat Kepercayaan</span>
                        <span class="font-semibold px-2 py-0.5 rounded text-xs {{ ($prediction['confidence'] ?? '') == 'Tinggi' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ $prediction['confidence'] ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm border-b border-outline-variant pb-2">
                        <span class="text-on-surface-variant">Analisis Tren</span>
                        <span class="font-semibold text-on-surface capitalize">{{ $trend['trend'] ?? '-' }}</span>
                    </div>
                </div>
                
                <p class="text-xs text-on-surface-variant bg-white/50 p-3 rounded-lg border border-white/50 leading-relaxed">
                    {{ $prediction['message'] ?? 'Prediksi berdasarkan algoritma pergerakan harga historis.' }}
                </p>
            </x-card>

            {{-- Operational Info --}}
            <x-card class="border border-outline-variant">
                <h3 class="font-bold text-on-surface mb-4">Informasi Operasional</h3>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-on-surface-variant font-semibold uppercase tracking-wider mb-1">Kualitas Standar</p>
                        <span class="px-2.5 py-1 text-xs font-bold rounded-md bg-blue-100 text-blue-800 uppercase">{{ $category->kualitas }}</span>
                    </div>
                    
                    <div>
                        <p class="text-xs text-on-surface-variant font-semibold uppercase tracking-wider mb-1">Target Stok Gudang</p>
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-lg text-on-surface">{{ number_format($category->stok_dibutuhkan, 0) }} Kg</span>
                            <div class="flex-1 h-2 bg-surface-container rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full w-1/3"></div> <!-- Visual dummy progress -->
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-on-surface-variant font-semibold uppercase tracking-wider mb-1">Nilai Daur Ulang Ekonomi</p>
                        <span class="font-semibold text-on-surface">{{ $category->nilai_daur_ulang ?: '-' }}</span>
                    </div>
                </div>
            </x-card>

            {{-- Quick Actions --}}
            <div class="flex flex-col gap-2">
                <form action="{{ route('admin.trash_price.duplicate', $category->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-2.5 px-4 bg-surface-container hover:bg-surface-container-high text-on-surface font-semibold rounded-xl transition-colors border border-outline-variant flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Gandakan Data
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</div>
@endsection
