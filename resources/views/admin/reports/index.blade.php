@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">



    <div class="mb-8 animate-fade-in">
        <div class="bg-gradient-to-r from-primary to-forest-emerald rounded-2xl p-6 shadow-lg text-white">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold mb-1">Laporan Transaksi Sampah</h1>
                    <p class="text-white/80 text-sm">Rekapitulasi seluruh transaksi setoran yang telah selesai. Filter atau ekspor data ke CSV.</p>
                </div>
                <div>
                    <a href="{{ route('admin.reports.export', request()->query()) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-primary hover:bg-gray-100 font-bold rounded-xl transition-all shadow-sm text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Ekspor CSV
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <x-card class="mb-8 animate-slide-in">
        <form method="GET" action="{{ route('admin.reports') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-lowest focus:ring-primary text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-2">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-lowest focus:ring-primary text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-2">Filter RT</label>
                    <select name="rt" class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-lowest focus:ring-primary text-sm">
                        <option value="">Semua RT</option>
                        @foreach($rtList as $rt)
                            <option value="{{ $rt }}" {{ request('rt') == $rt ? 'selected' : '' }}>RT {{ str_pad($rt, 3, '0', STR_PAD_LEFT) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-primary hover:bg-primary/90 text-white font-semibold rounded-lg transition-colors text-sm">
                        Terapkan Filter
                    </button>
                    @if(request()->hasAny(['start_date', 'end_date', 'rt', 'rw']))
                    <a href="{{ route('admin.reports') }}" class="px-4 py-2 bg-surface-container hover:bg-surface-container-high text-on-surface font-semibold rounded-lg transition-colors border border-outline-variant text-sm">
                        Reset
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </x-card>

    <!-- Table -->
    <x-card class="overflow-hidden animate-slide-in" style="animation-delay: 100ms;">
        <div class="overflow-x-auto hidden lg:block">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant text-sm border-b border-outline-variant">
                        <th class="p-4 font-semibold">ID & TANGGAL</th>
                        <th class="p-4 font-semibold">NASABAH</th>
                        <th class="p-4 font-semibold">KATEGORI</th>
                        <th class="p-4 font-semibold">BERAT & HARGA</th>
                        <th class="p-4 font-semibold text-right">TOTAL</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/50">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="p-4">
                            <div class="text-sm font-bold text-primary">#{{ substr($trx->id, -6) }}</div>
                            <div class="text-xs text-on-surface-variant mt-0.5">{{ $trx->created_at->format('d M Y, H:i') }}</div>
                        </td>
                        <td class="p-4">
                            <div class="text-sm font-medium text-on-surface">{{ $trx->user->name }}</div>
                            <div class="text-xs text-on-surface-variant mt-0.5">
                                RT {{ str_pad($trx->user->rt ?? 0, 3, '0', STR_PAD_LEFT) }} / RW {{ str_pad($trx->user->rw ?? 0, 3, '0', STR_PAD_LEFT) }}
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="text-sm font-medium text-on-surface">{{ $trx->trashCategory->nama }}</div>
                            <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-[10px] font-medium bg-surface-container-high text-on-surface-variant">
                                {{ ucfirst($trx->tipe_setoran) }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="text-sm font-medium text-on-surface">{{ $trx->berat_kg }} Kg</div>
                            <div class="text-xs text-on-surface-variant mt-0.5">@ Rp {{ number_format($trx->harga_per_kg, 0, ',', '.') }} / Kg</div>
                        </td>
                        <td class="p-4 text-right">
                            <div class="text-sm font-bold text-on-surface">Rp {{ number_format($trx->total_rp, 0, ',', '.') }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-on-surface-variant">
                            <svg class="w-12 h-12 mx-auto text-outline-variant mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p>Tidak ada data transaksi yang sesuai dengan filter.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="block lg:hidden divide-y divide-outline-variant">
            @forelse($transactions as $trx)
                <div class="p-4 bg-surface-container-lowest">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <div class="text-sm font-bold text-primary">#{{ substr($trx->id, -6) }}</div>
                            <div class="text-[10px] text-on-surface-variant mt-0.5">{{ $trx->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-surface-container-high text-on-surface-variant">
                            {{ ucfirst($trx->tipe_setoran) }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <div class="text-sm font-bold text-on-surface">{{ $trx->user->name }}</div>
                        <div class="text-xs text-on-surface-variant">RT {{ str_pad($trx->user->rt ?? 0, 3, '0', STR_PAD_LEFT) }} / RW {{ str_pad($trx->user->rw ?? 0, 3, '0', STR_PAD_LEFT) }}</div>
                    </div>

                    <div class="bg-surface-container-low p-3 rounded-xl border border-outline-variant">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-semibold text-on-surface">{{ $trx->trashCategory->nama }}</span>
                            <span class="text-xs font-bold text-on-surface">{{ $trx->berat_kg }} Kg</span>
                        </div>
                        <div class="flex justify-between items-end border-t border-outline-variant pt-2">
                            <div class="text-[10px] text-on-surface-variant">@ Rp {{ number_format($trx->harga_per_kg, 0, ',', '.') }}</div>
                            <div class="text-sm font-extrabold text-primary">Rp {{ number_format($trx->total_rp, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-on-surface-variant">
                    <svg class="w-12 h-12 mx-auto text-outline-variant mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p class="text-sm">Tidak ada data transaksi yang sesuai filter.</p>
                </div>
            @endforelse
        </div>
        @if($transactions->hasPages())
            <div class="p-4 border-t border-outline-variant bg-surface-container-lowest">
                {{ $transactions->withQueryString()->links() }}
            </div>
        @endif
    </x-card>

</div>
@endsection
