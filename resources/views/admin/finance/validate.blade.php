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
    <div class="flex border-b border-outline-variant mb-6">
        <button @click="activeTab = 'pending'" :class="activeTab === 'pending' ? 'border-primary text-primary' : 'border-transparent text-on-surface-variant hover:text-on-surface hover:border-outline'" class="px-4 py-2 border-b-2 font-medium text-sm transition-colors">
            Menunggu Validasi ({{ $withdrawals->total() }})
        </button>
        <button @click="activeTab = 'approved'" :class="activeTab === 'approved' ? 'border-primary text-primary' : 'border-transparent text-on-surface-variant hover:text-on-surface hover:border-outline'" class="px-4 py-2 border-b-2 font-medium text-sm transition-colors">
            Riwayat Disetujui
        </button>
    </div>

    <!-- Pending Tab -->
    <div x-show="activeTab === 'pending'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <x-card class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface-variant text-sm border-b border-outline-variant">
                            <th class="p-4 font-semibold">TANGGAL</th>
                            <th class="p-4 font-semibold">NASABAH</th>
                            <th class="p-4 font-semibold">NOMINAL</th>
                            <th class="p-4 font-semibold">METODE</th>
                            <th class="p-4 font-semibold text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/50">
                        @forelse($withdrawals as $item)
                        <tr class="hover:bg-surface-container-lowest transition-colors">
                            <td class="p-4">
                                <div class="text-sm font-medium text-on-surface">{{ $item->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-on-surface-variant">{{ $item->created_at->format('H:i') }}</div>
                            </td>
                            <td class="p-4">
                                <div class="text-sm font-medium text-on-surface">{{ $item->user->name }}</div>
                                <div class="text-xs text-on-surface-variant">{{ $item->user->email }}</div>
                            </td>
                            <td class="p-4">
                                <div class="text-sm font-bold text-on-surface">Rp {{ number_format($item->nominal, 0, ',', '.') }}</div>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                                    {{ $item->metode }}
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <button @click="approveId = '{{ $item->id }}'; $dispatch('open-modal', 'approve-modal')" class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold rounded-lg transition-colors">
                                    Setujui
                                </button>
                                <button @click="rejectId = '{{ $item->id }}'; $dispatch('open-modal', 'reject-modal')" class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-semibold rounded-lg transition-colors">
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
            @if($withdrawals->hasPages())
                <div class="p-4 border-t border-outline-variant bg-surface-container-lowest">
                    {{ $withdrawals->links() }}
                </div>
            @endif
        </x-card>
    </div>

    <!-- Approved Tab -->
    <div x-show="activeTab === 'approved'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <x-card class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface-variant text-sm border-b border-outline-variant">
                            <th class="p-4 font-semibold">TANGGAL</th>
                            <th class="p-4 font-semibold">NASABAH</th>
                            <th class="p-4 font-semibold">NOMINAL</th>
                            <th class="p-4 font-semibold">METODE</th>
                            <th class="p-4 font-semibold text-center">BUKTI RESI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/50">
                        @forelse($approved as $item)
                        <tr class="hover:bg-surface-container-lowest transition-colors">
                            <td class="p-4">
                                <div class="text-sm font-medium text-on-surface">{{ $item->updated_at->format('d M Y') }}</div>
                                <div class="text-xs text-on-surface-variant">{{ $item->updated_at->format('H:i') }}</div>
                            </td>
                            <td class="p-4">
                                <div class="text-sm font-medium text-on-surface">{{ $item->user->name }}</div>
                            </td>
                            <td class="p-4">
                                <div class="text-sm font-bold text-on-surface">Rp {{ number_format($item->nominal, 0, ',', '.') }}</div>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                                    {{ $item->metode }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                @if($item->foto_resi)
                                    <a href="{{ Storage::url($item->foto_resi) }}" target="_blank" class="inline-flex items-center justify-center p-2 bg-surface-container hover:bg-surface-container-high text-primary rounded-lg transition-colors" title="Lihat Resi">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                @else
                                    <span class="text-xs text-on-surface-variant italic">Tidak ada resi</span>
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
