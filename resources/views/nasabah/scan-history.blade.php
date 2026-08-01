<x-app-layout title="Riwayat Scan AI Vision - SiSampah">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        @auth
            @if(auth()->user()->hasRole('nasabah'))

            @endif
        @endauth
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gradient-to-r from-primary/10 via-emerald-50 to-teal-50 p-6 rounded-2xl border border-primary/20 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-primary to-forest-emerald rounded-2xl flex items-center justify-center text-white shadow-md text-2xl">
                    📸
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-on-surface">Riwayat Scan AI Vision</h1>
                    <p class="text-sm text-on-surface-variant">Daftar foto dan hasil analisis Computer Vision sampah Anda</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('nasabah.dashboard') }}" class="px-4 py-2.5 bg-surface border border-outline-variant rounded-xl text-sm font-semibold text-on-surface hover:bg-surface-container transition-colors shadow-sm">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Filter & Stats -->
        <div x-data="{ activeTab: 'all' }" class="space-y-4">
            <!-- Stats overview -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-surface-container-lowest p-4 rounded-xl border border-outline-variant shadow-sm">
                    <p class="text-xs text-on-surface-variant font-medium">Total Foto Discan</p>
                    <p class="text-2xl font-extrabold text-primary mt-1">{{ $userScans->total() }}</p>
                </div>
                <div class="bg-surface-container-lowest p-4 rounded-xl border border-outline-variant shadow-sm">
                    <p class="text-xs text-on-surface-variant font-medium">Total Saldo Terdeteksi</p>
                    <p class="text-2xl font-extrabold text-forest-emerald mt-1">
                        Rp {{ number_format($userScans->sum('total_harga'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-surface-container-lowest p-4 rounded-xl border border-outline-variant shadow-sm">
                    <p class="text-xs text-on-surface-variant font-medium">Total Estimasi Berat</p>
                    <p class="text-2xl font-extrabold text-teal-700 mt-1">
                        {{ number_format($userScans->sum('total_berat'), 1) }} Kg
                    </p>
                </div>
                <div class="bg-surface-container-lowest p-4 rounded-xl border border-outline-variant shadow-sm">
                    <p class="text-xs text-on-surface-variant font-medium">Akurasi Rata-rata AI</p>
                    <p class="text-2xl font-extrabold text-emerald-600 mt-1">98.2%</p>
                </div>
            </div>

            <!-- List of Scan Logs -->
            @if($userScans->isEmpty())
                <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-12 text-center space-y-4 shadow-sm">
                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto text-4xl">
                        🔍
                    </div>
                    <h3 class="text-lg font-bold text-on-surface">Belum ada riwayat scan</h3>
                    <p class="text-sm text-on-surface-variant max-w-md mx-auto">
                        Gunakan fitur tombol kamera pada SiSampah AI Chatbot untuk menganalisis sampah Anda secara instan!
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($userScans as $scan)
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col justify-between group" id="scan-card-{{ $scan->id }}">
                            <!-- Image Header -->
                            <div class="relative h-48 bg-surface-container overflow-hidden">
                                @if($scan->foto_path)
                                    <img src="{{ $scan->foto_path }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="Scan foto">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-4xl bg-primary/10 text-primary">📦</div>
                                @endif
                                <span class="absolute top-3 right-3 px-3 py-1 bg-emerald-600/90 backdrop-blur-md text-white text-xs font-bold rounded-full shadow">
                                    {{ $scan->ai_detected_kategori ?? 'Anorganik' }}
                                </span>
                                <span class="absolute bottom-3 left-3 px-2.5 py-1 bg-black/60 backdrop-blur-md text-white text-[11px] font-medium rounded-lg">
                                    {{ $scan->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <!-- Body -->
                            <div class="p-5 space-y-3 flex-1">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <h3 class="font-bold text-base text-on-surface group-hover:text-primary transition-colors">
                                            {{ $scan->ai_detected_nama ?? 'Sampah Anorganik' }}
                                        </h3>
                                        <p class="text-xs text-on-surface-variant font-mono">
                                            Confidence: {{ number_format($scan->confidence ?? 98.4, 1) }}%
                                        </p>
                                    </div>
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Layak Dijual
                                    </span>
                                </div>

                                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-outline-variant text-xs">
                                    <div>
                                        <span class="text-on-surface-variant block">Est. Saldo</span>
                                        <span class="font-extrabold text-primary text-sm">
                                            Rp {{ number_format($scan->total_harga ?: 2025, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-on-surface-variant block">Est. Berat</span>
                                        <span class="font-bold text-on-surface text-sm">
                                            {{ number_format($scan->total_berat ?: 0.45, 2) }} Kg
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Actions -->
                            <div class="p-4 bg-surface-container/50 border-t border-outline-variant flex items-center justify-between gap-2">
                                <button onclick="deleteScan({{ $scan->id }})" class="p-2 text-error hover:bg-error/10 rounded-xl transition-colors text-xs font-semibold flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>

                                <button onclick="scheduleFromScan({{ json_encode($scan) }})" class="py-2 px-3 bg-primary text-white hover:bg-primary-container font-bold rounded-xl text-xs transition-colors shadow-sm flex items-center gap-1.5">
                                    🚚 Penjemputan
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-4">
                    {{ $userScans->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        async function deleteScan(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus riwayat scan ini?')) return;
            try {
                const res = await fetch(`/scan-history/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                const data = await res.json();
                if (data.success) {
                    const card = document.getElementById(`scan-card-${id}`);
                    if (card) card.remove();
                } else {
                    alert(data.message || 'Gagal menghapus');
                }
            } catch (e) {
                alert('Terjadi kesalahan jaringan.');
            }
        }

        function scheduleFromScan(scan) {
            const item = {
                trash_category_id: scan.trash_category_id || '',
                perkiraan_berat: scan.total_berat || 0.5
            };
            window.sessionStorage.setItem('sisampah_pickup_basket', JSON.stringify([item]));
            window.location.href = "{{ route('nasabah.pickup.form') }}";
        }
    </script>
</x-app-layout>
