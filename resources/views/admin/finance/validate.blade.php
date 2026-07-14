@extends('layouts.app')

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

    <x-role-nav role="admin" />

    <div class="mb-8 animate-fade-in">
        <div class="bg-gradient-to-r from-primary to-forest-emerald rounded-2xl p-6 shadow-lg text-white">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold mb-1">Validasi Penarikan Dana</h1>
                    <p class="text-white/80 text-sm">Proses permintaan pencairan saldo nasabah ke rekening/e-wallet mereka.</p>
                </div>
            </div>
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
            <div class="overflow-x-auto hidden md:block">
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
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 capitalize shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    {{ $item->metode }}
                                </span>
                            </td>
                            <td class="p-5 text-right space-x-2">
                                <button @click="approveId = '{{ $item->id }}'; $dispatch('open-modal', 'approve-modal')" class="px-3.5 py-2 bg-green-500 hover:bg-green-600 hover:shadow-md hover:-translate-y-0.5 text-white text-xs font-bold rounded-xl transition-all inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Setujui
                                </button>
                                <button @click="rejectId = '{{ $item->id }}'; $dispatch('open-modal', 'reject-modal')" class="px-3.5 py-2 bg-red-50 hover:bg-red-100 border border-red-200 hover:border-red-300 text-red-700 hover:shadow-sm text-xs font-bold rounded-xl transition-all inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
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
            <div class="block md:hidden divide-y divide-outline-variant">
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
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200 capitalize shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                {{ $item->metode }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4 bg-surface-container-low p-3 rounded-xl border border-outline-variant">
                            <span class="text-xs text-on-surface-variant font-semibold uppercase">Nominal Penarikan</span>
                            <span class="text-base font-extrabold text-green-600">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <button @click="rejectId = '{{ $item->id }}'; $dispatch('open-modal', 'reject-modal')" class="py-2 bg-red-50 hover:bg-red-100 border border-red-200 text-red-700 text-xs font-bold rounded-xl flex items-center justify-center gap-1.5 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Tolak
                            </button>
                            <button @click="approveId = '{{ $item->id }}'; $dispatch('open-modal', 'approve-modal')" class="py-2 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-xl shadow-md flex items-center justify-center gap-1.5 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Setujui
                            </button>
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
            <div class="overflow-x-auto hidden md:block">
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
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 capitalize shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    {{ $item->metode }}
                                </span>
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
            <div class="block md:hidden divide-y divide-outline-variant">
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
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200 capitalize shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                {{ $item->metode }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4 bg-surface-container-low p-3 rounded-xl border border-outline-variant">
                            <span class="text-xs text-on-surface-variant font-semibold uppercase">Nominal</span>
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

</div>
@endsection
