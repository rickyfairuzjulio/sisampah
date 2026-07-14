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
                    <span class="text-on-surface font-semibold ml-1 md:ml-2">Riwayat Global</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 animate-fade-in">
        <div>
            <h1 class="text-3xl font-bold text-on-surface">Riwayat Perubahan Harga</h1>
            <p class="text-on-surface-variant mt-1 text-sm">Audit trail semua aktivitas pembaruan harga di sistem.</p>
        </div>
        <div class="flex gap-2">
            <button onclick="alert('Fitur Export TXT segera hadir')" class="px-4 py-2 bg-surface-container hover:bg-surface-container-high text-on-surface font-semibold rounded-xl transition-colors border border-outline-variant flex items-center gap-2 text-sm shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export TXT
            </button>
            <button onclick="window.print()" class="px-4 py-2 bg-surface-container hover:bg-surface-container-high text-on-surface font-semibold rounded-xl transition-colors border border-outline-variant flex items-center gap-2 text-sm shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print PDF
            </button>
        </div>
    </div>

    {{-- Filter Bar --}}
    <x-card class="mb-6 !p-4 border border-outline-variant animate-slide-in">
        <form action="{{ route('admin.trash_price.history') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            
            <div class="w-full md:w-64">
                <select name="kategori_id" class="w-full border border-outline-variant rounded-xl py-2 px-3 focus:ring-primary focus:border-primary text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('kategori_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nama }} ({{ $cat->kode }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 grid grid-cols-2 gap-3">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border border-outline-variant rounded-xl py-2 px-3 focus:ring-primary focus:border-primary text-sm">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border border-outline-variant rounded-xl py-2 px-3 focus:ring-primary focus:border-primary text-sm">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-primary text-white font-semibold rounded-xl hover:bg-primary-container transition-colors text-sm shadow-sm">
                    Filter
                </button>
                @if(request()->anyFilled(['kategori_id', 'start_date', 'end_date']))
                    <a href="{{ route('admin.trash_price.history') }}" class="px-4 py-2 bg-surface-container-high text-on-surface font-semibold rounded-xl hover:bg-surface-container-highest transition-colors text-sm">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </x-card>

    <x-card class="border border-outline-variant p-0 overflow-hidden animate-slide-in">
        <div class="overflow-x-auto hidden md:block">
            <table class="w-full text-sm text-left print-friendly-table">
                <thead class="text-xs text-on-surface-variant uppercase bg-surface-container font-semibold border-b border-outline-variant">
                    <tr>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3 text-right">Harga Lama</th>
                        <th class="px-4 py-3 text-right">Harga Baru</th>
                        <th class="px-4 py-3 text-center">Perubahan</th>
                        <th class="px-4 py-3">Admin</th>
                        <th class="px-4 py-3">Alasan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($histories as $history)
                        <tr class="hover:bg-surface-container-lowest transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="font-medium text-on-surface">{{ $history->created_at->format('d M Y') }}</p>
                                <p class="text-[10px] text-on-surface-variant">{{ $history->created_at->format('H:i') }} WIB</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-bold text-on-surface"><a href="{{ route('admin.trash_price.show', $history->trash_category_id) }}" class="hover:text-primary hover:underline">{{ $history->trashCategory->nama ?? 'Dihapus' }}</a></p>
                                <p class="text-[10px] text-on-surface-variant">{{ $history->trashCategory->kode ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-right text-on-surface-variant">Rp {{ number_format($history->harga_lama, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right font-bold text-primary">Rp {{ number_format($history->harga_baru, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold {{ $history->change_bg }}">
                                    @if($history->change_direction == 'naik') ↑
                                    @elseif($history->change_direction == 'turun') ↓
                                    @else → @endif
                                    {{ abs($history->persentase_perubahan) }}%
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold uppercase">
                                        {{ substr($history->admin->name ?? 'A', 0, 1) }}
                                    </div>
                                    <p class="text-sm text-on-surface">{{ $history->admin->name ?? 'System' }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-xs text-on-surface-variant max-w-[200px] truncate" title="{{ $history->alasan }}">{{ $history->alasan ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-on-surface-variant">
                                Tidak ada data riwayat harga yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card View --}}
        <div class="block md:hidden divide-y divide-outline-variant">
            @forelse($histories as $history)
                <div class="p-4 bg-surface-container-lowest">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="font-bold text-on-surface">
                                <a href="{{ route('admin.trash_price.show', $history->trash_category_id) }}" class="hover:text-primary">
                                    {{ $history->trashCategory->nama ?? 'Dihapus' }}
                                </a>
                            </p>
                            <p class="text-[10px] text-on-surface-variant flex items-center gap-1 mt-0.5">
                                <span class="font-mono bg-surface-container-high px-1 rounded">{{ $history->trashCategory->kode ?? '-' }}</span>
                                · {{ $history->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $history->change_bg }}">
                                @if($history->change_direction == 'naik') ↑
                                @elseif($history->change_direction == 'turun') ↓
                                @else → @endif
                                {{ abs($history->persentase_perubahan) }}%
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between bg-surface-container-low p-3 rounded-xl border border-outline-variant mb-3">
                        <div>
                            <p class="text-[10px] text-on-surface-variant uppercase font-semibold">Harga Lama</p>
                            <p class="font-bold text-on-surface-variant line-through text-sm">Rp {{ number_format($history->harga_lama, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-on-surface-variant">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-on-surface-variant uppercase font-semibold">Harga Baru</p>
                            <p class="font-extrabold text-primary text-sm">Rp {{ number_format($history->harga_baru, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-1.5">
                            <div class="w-5 h-5 rounded-full bg-primary/10 text-primary flex items-center justify-center text-[10px] font-bold uppercase">
                                {{ substr($history->admin->name ?? 'A', 0, 1) }}
                            </div>
                            <span class="text-on-surface font-medium">{{ $history->admin->name ?? 'System' }}</span>
                        </div>
                        <div class="text-on-surface-variant italic text-[10px] truncate max-w-[150px]">
                            {{ $history->alasan ?: 'Tanpa alasan' }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-8 text-center text-on-surface-variant text-sm">
                    Tidak ada data riwayat harga.
                </div>
            @endforelse
        </div>
        
        @if($histories->hasPages())
            <div class="p-4 border-t border-outline-variant bg-surface-container-lowest">
                {{ $histories->withQueryString()->links() }}
            </div>
        @endif
    </x-card>

</div>
@endsection
