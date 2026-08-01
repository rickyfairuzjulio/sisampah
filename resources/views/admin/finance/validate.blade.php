@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'pending', approveId: null, rejectId: null }">

    @if(session('success'))
        <x-alert type="success" class="mb-6 animate-slide-in" dismissible>{{ session('success') }}</x-alert>
    @endif
    @if(session('error'))
        <x-alert type="error" class="mb-6 animate-slide-in" dismissible>{{ session('error') }}</x-alert>
    @endif
    @if($errors->any())
        <div class="mb-6 animate-slide-in">
            <x-alert type="error" dismissible>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        </div>
    @endif



    <!-- Treasury Kas Header Card -->
    <div class="card card-body bg-gradient-to-r from-primary/10 via-surface to-background border border-primary/20 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-primary/10 border border-primary/30 rounded-2xl flex items-center justify-center text-primary text-2xl shrink-0 shadow-soft">
                <i class="bi bi-wallet2"></i>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-text-muted">Kas Utama Bank Sampah Pusat</p>
                <h1 class="text-2xl sm:text-3xl font-black text-text-primary mt-0.5 tracking-tight">
                    Rp {{ number_format($saldoKasPusat ?? 50000000, 0, ',', '.') }}
                </h1>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button @click="$dispatch('open-modal', 'topup-kas-modal')" class="btn btn-primary !py-2.5 !px-5 text-xs flex items-center gap-2 shadow-soft">
                <i class="bi bi-plus-circle-fill text-sm"></i> Isi Saldo Kas Pusat
            </button>
        </div>
    </div>

    <!-- Financial Metrics Bar -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="card card-body">
            <p class="text-xs font-bold text-text-muted uppercase tracking-wider mb-1">Kas Bank Sampah</p>
            <p class="text-xl font-extrabold text-primary">Rp {{ number_format($saldoKasPusat ?? 50000000, 0, ',', '.') }}</p>
        </div>
        <div class="card card-body">
            <p class="text-xs font-bold text-text-muted uppercase tracking-wider mb-1">Saldo Nasabah</p>
            <p class="text-xl font-extrabold text-text-primary">Rp {{ number_format($totalSaldoNasabah ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="card card-body">
            <p class="text-xs font-bold text-text-muted uppercase tracking-wider mb-1">Setoran Selesai</p>
            <p class="text-xl font-extrabold text-primary">Rp {{ number_format($totalSetoran ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="card card-body">
            <p class="text-xs font-bold text-text-muted uppercase tracking-wider mb-1">Pencairan Disetujui</p>
            <p class="text-xl font-extrabold text-danger">Rp {{ number_format($totalDisetujui ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex gap-2 border-b border-outline-variant mb-8 overflow-x-auto pb-1">
        <button @click="activeTab = 'pending'" :class="activeTab === 'pending' ? 'bg-primary text-white shadow-md' : 'bg-surface-container hover:bg-surface-container-high text-on-surface-variant'" class="px-6 py-2.5 rounded-full font-semibold text-sm transition-all duration-300 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Menunggu Validasi
            <span :class="activeTab === 'pending' ? 'bg-white/20 text-white' : 'bg-primary/10 text-primary'" class="ml-1 px-2 py-0.5 rounded-full text-xs">{{ $withdrawals->total() }}</span>
        </button>
        <button @click="activeTab = 'approved'" :class="activeTab === 'approved' ? 'bg-primary text-white shadow-md' : 'bg-surface-container hover:bg-surface-container-high text-on-surface-variant'" class="px-6 py-2.5 rounded-full font-semibold text-sm transition-all duration-300 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Riwayat Disetujui
        </button>
    </div>

    <!-- Pending Tab -->
    <div x-show="activeTab === 'pending'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <x-card class="overflow-hidden !p-0 border border-outline-variant shadow-sm">
            <div class="overflow-x-auto hidden lg:block">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface-variant text-xs uppercase tracking-wider border-b border-outline-variant">
                            <th class="p-5 font-bold">Tanggal</th>
                            <th class="p-5 font-bold">Nasabah</th>
                            <th class="p-5 font-bold">Nominal</th>
                            <th class="p-5 font-bold">Metode</th>
                            <th class="p-5 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @forelse($withdrawals as $item)
                        <tr class="hover:bg-surface-container-lowest/80 transition-colors group">
                            <td class="p-5">
                                <div class="text-sm font-semibold text-on-surface">{{ $item->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-on-surface-variant font-medium mt-0.5">{{ $item->created_at->format('H:i') }}</div>
                            </td>
                            <td class="p-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($item->user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-on-surface">{{ $item->user->name }}</div>
                                        <div class="text-xs text-on-surface-variant font-medium">{{ $item->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-5">
                                <div class="text-sm font-extrabold text-green-600 bg-green-50 inline-block px-3 py-1 rounded-lg border border-green-200">
                                    Rp {{ number_format($item->nominal, 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="p-5">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 shadow-sm mb-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    {{ $item->metode === 'tunai' ? 'Tunai' : strtoupper($item->metode) }}
                                </span>
                                @if($item->metode !== 'tunai')
                                <div class="text-xs mt-1">
                                    <div class="font-bold text-on-surface">{{ $item->rekening_tujuan }}</div>
                                    <div class="text-on-surface-variant uppercase text-[10px]">A.N. {{ $item->nama_penerima }}</div>
                                </div>
                                @endif
                            </td>
                            <td class="p-5 text-right space-x-2 flex items-center justify-end gap-1.5">
                                <form action="{{ route('admin.finance.approve_gateway', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 hover:shadow-md hover:-translate-y-0.5 text-white text-xs font-bold rounded-xl transition-all inline-flex items-center gap-1" onclick="confirmGatewayPayment(event, this.form, '{{ addslashes($item->user->name) }}', '{{ number_format($item->nominal, 0, ',', '.') }}')">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        Bayar Instan
                                    </button>
                                </form>
                                <button @click="approveId = '{{ $item->id }}'; $dispatch('open-modal', 'approve-modal')" class="px-3 py-2 bg-green-500 hover:bg-green-600 hover:shadow-md hover:-translate-y-0.5 text-white text-xs font-bold rounded-xl transition-all inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Setujui
                                </button>
                                <button @click="rejectId = '{{ $item->id }}'; $dispatch('open-modal', 'reject-modal')" class="px-3 py-2 bg-red-50 hover:bg-red-100 border border-red-200 hover:border-red-300 text-red-700 hover:shadow-sm text-xs font-bold rounded-xl transition-all inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Tolak
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-on-surface-variant">
                                Tidak ada pengajuan penarikan yang menunggu validasi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View for Pending -->
            <div class="block lg:hidden divide-y divide-outline-variant">
                @forelse($withdrawals as $item)
                    <div class="p-4 bg-surface-container-lowest">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm uppercase">
                                    {{ substr($item->user->name, 0, 2) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-on-surface">{{ $item->user->name }}</div>
                                    <div class="text-[10px] text-on-surface-variant font-medium">{{ $item->created_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200 shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                {{ $item->metode === 'tunai' ? 'Tunai' : strtoupper($item->metode) }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4 bg-surface-container-low p-3 rounded-xl border border-outline-variant">
                            <div>
                                <span class="text-xs text-on-surface-variant font-semibold uppercase block">Nominal Penarikan</span>
                                @if($item->metode !== 'tunai')
                                <div class="text-[10px] mt-1">
                                    <span class="font-bold text-on-surface">{{ $item->rekening_tujuan }}</span><br>
                                    <span class="text-on-surface-variant">A.N. {{ $item->nama_penerima }}</span>
                                </div>
                                @endif
                            </div>
                            <span class="text-base font-extrabold text-green-600">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                        </div>

                        <div class="space-y-2">
                            <form action="{{ route('admin.finance.approve_gateway', $item->id) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm flex items-center justify-center gap-1.5 transition-all" onclick="confirmGatewayPayment(event, this.form, '{{ addslashes($item->user->name) }}', '{{ number_format($item->nominal, 0, ',', '.') }}')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    Bayar Instan (Gateway)
                                </button>
                            </form>
                            <div class="grid grid-cols-2 gap-2">
                                <button @click="rejectId = '{{ $item->id }}'; $dispatch('open-modal', 'reject-modal')" class="py-2 bg-red-50 hover:bg-red-100 border border-red-200 text-red-700 text-xs font-bold rounded-xl flex items-center justify-center gap-1.5 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Tolak
                                </button>
                                <button @click="approveId = '{{ $item->id }}'; $dispatch('open-modal', 'approve-modal')" class="py-2 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-xl shadow-md flex items-center justify-center gap-1.5 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Setujui (Resi)
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-on-surface-variant text-sm">
                        Tidak ada pengajuan penarikan yang menunggu validasi.
                    </div>
                @endforelse
            </div>
            @if($withdrawals->hasPages())
                <div class="p-4 border-t border-outline-variant bg-surface-container-lowest">
                    {{ $withdrawals->links() }}
                </div>
            @endif
        </x-card>
    </div>

    <!-- Approved Tab -->
    <div x-show="activeTab === 'approved'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <x-card class="overflow-hidden !p-0 border border-outline-variant shadow-sm">
            <div class="overflow-x-auto hidden lg:block">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface-variant text-xs uppercase tracking-wider border-b border-outline-variant">
                            <th class="p-5 font-bold">Tanggal</th>
                            <th class="p-5 font-bold">Nasabah</th>
                            <th class="p-5 font-bold">Nominal</th>
                            <th class="p-5 font-bold">Metode</th>
                            <th class="p-5 font-bold text-center">Bukti Resi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @forelse($approved as $item)
                        <tr class="hover:bg-surface-container-lowest/80 transition-colors group">
                            <td class="p-5">
                                <div class="text-sm font-semibold text-on-surface">{{ $item->updated_at->format('d M Y') }}</div>
                                <div class="text-xs text-on-surface-variant font-medium mt-0.5">{{ $item->updated_at->format('H:i') }}</div>
                            </td>
                            <td class="p-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($item->user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-on-surface">{{ $item->user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-5">
                                <div class="text-sm font-extrabold text-green-600 bg-green-50 inline-block px-3 py-1 rounded-lg border border-green-200">
                                    Rp {{ number_format($item->nominal, 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="p-5">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    {{ $item->metode === 'tunai' ? 'Tunai' : strtoupper($item->metode) }}
                                </span>
                                @if($item->metode !== 'tunai')
                                <div class="text-xs mt-1">
                                    <div class="font-bold text-on-surface">{{ $item->rekening_tujuan }}</div>
                                    <div class="text-on-surface-variant uppercase text-[10px]">A.N. {{ $item->nama_penerima }}</div>
                                </div>
                                @endif
                            </td>
                            <td class="p-5 text-center">
                                @if($item->foto_resi)
                                    <a href="{{ Storage::url($item->foto_resi) }}" target="_blank" class="inline-flex items-center justify-center p-2.5 bg-surface-container hover:bg-primary/10 hover:text-primary hover:shadow-sm text-on-surface-variant rounded-xl transition-all" title="Lihat Resi">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                @else
                                    <span class="text-xs text-on-surface-variant italic bg-surface-container-low px-2 py-1 rounded-md">Tidak ada resi</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-on-surface-variant">
                                Belum ada riwayat penarikan yang disetujui.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View for Approved -->
            <div class="block lg:hidden divide-y divide-outline-variant">
                @forelse($approved as $item)
                    <div class="p-4 bg-surface-container-lowest">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm uppercase">
                                    {{ substr($item->user->name, 0, 2) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-on-surface">{{ $item->user->name }}</div>
                                    <div class="text-[10px] text-on-surface-variant font-medium">{{ $item->updated_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200 shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                {{ $item->metode === 'tunai' ? 'Tunai' : strtoupper($item->metode) }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4 bg-surface-container-low p-3 rounded-xl border border-outline-variant">
                            <div>
                                <span class="text-xs text-on-surface-variant font-semibold uppercase block">Nominal</span>
                                @if($item->metode !== 'tunai')
                                <div class="text-[10px] mt-1">
                                    <span class="font-bold text-on-surface">{{ $item->rekening_tujuan }}</span><br>
                                    <span class="text-on-surface-variant">A.N. {{ $item->nama_penerima }}</span>
                                </div>
                                @endif
                            </div>
                            <span class="text-base font-extrabold text-green-600">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                        </div>

                        <div class="text-center">
                            @if($item->foto_resi)
                                <a href="{{ Storage::url($item->foto_resi) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 bg-surface-container hover:bg-surface-container-high text-on-surface font-semibold text-xs rounded-xl transition-colors border border-outline-variant w-full justify-center">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Resi
                                </a>
                            @else
                                <span class="text-xs text-on-surface-variant italic py-2 block">Tanpa Resi</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-on-surface-variant text-sm">
                        Belum ada riwayat penarikan disetujui.
                    </div>
                @endforelse
            </div>
        </x-card>
    </div>

    <!-- Approve Modal -->
    <x-modal name="approve-modal" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-bold text-on-surface mb-4">Setujui Penarikan Dana</h2>
            <p class="text-sm text-on-surface-variant mb-4">Silakan unggah bukti resi transfer untuk menyelesaikan proses penarikan ini.</p>
            
            <form x-bind:action="`/admin/validasi-keuangan/${approveId}`" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-on-surface mb-2">Upload Bukti Resi <span class="text-red-500">*</span></label>
                    <input type="file" name="foto_resi" required accept="image/*" class="w-full border border-outline-variant rounded-lg py-2 px-3 text-sm focus:ring-primary bg-surface-container-lowest file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" @click="$dispatch('close-modal', 'approve-modal')" class="px-4 py-2 text-sm font-semibold text-on-surface-variant hover:text-on-surface transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-xl transition-all shadow-sm">Kirim & Setujui</button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Reject Modal -->
    <x-modal name="reject-modal" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-bold text-red-600 mb-4">Tolak Penarikan Dana</h2>
            <p class="text-sm text-on-surface-variant mb-4">Tuliskan alasan mengapa Anda menolak pengajuan penarikan dana ini. Saldo akan dikembalikan ke nasabah.</p>
            
            <form x-bind:action="`/admin/validasi-keuangan/${rejectId}/reject`" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-on-surface mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea name="catatan_admin" required rows="3" class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-lowest focus:ring-red-500 focus:border-red-500" placeholder="Contoh: Rekening tujuan tidak valid"></textarea>
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" @click="$dispatch('close-modal', 'reject-modal')" class="px-4 py-2 text-sm font-semibold text-on-surface-variant hover:text-on-surface transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm">Tolak Penarikan</button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Topup Kas Modal -->
    <x-modal name="topup-kas-modal" maxWidth="md">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center text-primary text-xl shrink-0">
                    <i class="bi bi-plus-circle-fill"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-text-primary">Isi Saldo Kas Utama</h2>
                    <p class="text-xs text-text-secondary">Tambah dana cadangan kas Bank Sampah Pusat</p>
                </div>
            </div>

            <form action="{{ route('admin.finance.topup_kas') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-text-secondary uppercase tracking-wide mb-1.5">Nominal Top Up Kas (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="nominal" required min="10000" step="10000" value="10000000" placeholder="Contoh: 10000000" class="form-input text-sm font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-secondary uppercase tracking-wide mb-1.5">Sumber Dana / Asal Kas <span class="text-danger">*</span></label>
                    <select name="sumber_dana" required class="form-select text-xs">
                        <option value="Kas Pemdes & Anggaran Desa">Kas Pemdes & Anggaran Desa</option>
                        <option value="Hasil Penjualan Daur Ulang ke Pabrik">Hasil Penjualan Daur Ulang ke Pabrik</option>
                        <option value="Hibah / Dana CSR Mitra Lingkungan">Hibah / Dana CSR Mitra Lingkungan</option>
                        <option value="Setoran Modal Awal Pengurus Bank Sampah">Setoran Modal Awal Pengurus Bank Sampah</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-secondary uppercase tracking-wide mb-1.5">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan" rows="2" class="form-input text-xs" placeholder="Tuliskan catatan transaksi kas..."></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-border-color">
                    <button type="button" @click="$dispatch('close-modal', 'topup-kas-modal')" class="btn btn-secondary text-xs">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary text-xs !py-2.5 !px-5 shadow-soft">
                        <i class="bi bi-[#2DD67B] bi-check-circle-fill"></i> Tambah Saldo Kas
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

</div>

@push('scripts')
<script>
    function confirmGatewayPayment(e, form, name, nominal) {
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Pembayaran Instan',
            html: `Apakah Anda yakin ingin memproses pencairan dana sebesar <b>Rp ${nominal}</b> untuk <b>${name}</b> via Payment Gateway?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Bayar Sekarang',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#64748b',
            background: document.documentElement.classList.contains('dark') ? '#0A241B' : '#ffffff',
            color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#0F172A',
            customClass: { popup: 'rounded-[20px]', confirmButton: 'rounded-xl px-6 py-2.5 font-bold', cancelButton: 'rounded-xl px-6 py-2.5 font-bold' }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endpush
@endsection
