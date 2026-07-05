<x-app-layout title="Dompet Saya">
    <div class="space-y-6 pb-8">
        <!-- Header with Back Button -->
        <div class="flex items-center gap-3">
            <a href="{{ route('nasabah.dashboard') }}" class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-on-surface">💰 Dompet Saya</h1>
                <p class="text-sm text-on-surface-variant">Kelola saldo dan riwayat transaksi Anda</p>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <x-alert type="success" title="Sukses!" dismissible class="animate-slide-in">
                {{ session('success') }}
            </x-alert>
        @endif

        <!-- Main Balance Card -->
        <div class="bg-gradient-to-br from-primary via-primary-container to-forest-emerald rounded-2xl p-8 text-white shadow-lg overflow-hidden relative">
            <!-- Decorative Background -->
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <svg class="absolute right-0 bottom-0 w-64 h-64 transform translate-x-16 translate-y-16" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                </svg>
            </div>

            <div class="relative z-10">
                <p class="text-white/80 text-sm font-semibold uppercase tracking-wider mb-2">💵 Saldo Aktif Anda</p>
                <h2 class="text-5xl font-bold mb-1">Rp {{ number_format($saldo, 0, ',', '.') }}</h2>
                <p class="text-white/70 text-sm mb-6">Siap untuk ditarik kapan saja</p>

                <div class="flex flex-wrap gap-3">
                    <a href="#withdrawal-form" class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 transition-all duration-300 text-white text-sm font-bold px-6 py-3 rounded-full backdrop-blur-sm hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Tarik Saldo
                    </a>
                    <a href="{{ route('nasabah.pickup.form') }}" class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 transition-all duration-300 text-white text-sm font-bold px-6 py-3 rounded-full backdrop-blur-sm hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Jadwalkan Pickup
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <x-stat-tile 
                title="{{ $withdrawals->where('status', 'pending')->count() }}" 
                subtitle="Penarikan Pending"
            >
                <x-slot:icon>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </x-slot:icon>
            </x-stat-tile>

            <x-stat-tile 
                title="{{ $withdrawals->where('status', 'disetujui')->count() }}" 
                subtitle="Berhasil Ditarik"
            >
                <x-slot:icon>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </x-slot:icon>
            </x-stat-tile>

            <x-stat-tile 
                title="{{ $withdrawals->where('status', 'ditolak')->count() }}" 
                subtitle="Ditolak"
            >
                <x-slot:icon>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </x-slot:icon>
            </x-stat-tile>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Transactions -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Transaction History Card -->
                <x-card>
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-outline-variant">
                        <div>
                            <h2 class="text-lg font-bold text-on-surface">📊 Riwayat Mutasi</h2>
                            <p class="text-xs text-on-surface-variant">Saldo masuk dari setoran sampah</p>
                        </div>
                        <x-badge status="completed" label="Masuk" />
                    </div>

                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @forelse($mutasi as $transaksi)
                            <div class="flex items-center justify-between p-4 rounded-lg hover:bg-surface-container-low/50 transition-colors group cursor-pointer">
                                <div class="flex items-center gap-3 flex-1">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3v-6"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-on-surface">{{ $transaksi->trashCategory->nama }}</p>
                                        <p class="text-xs text-on-surface-variant">{{ $transaksi->berat_kg }} Kg • {{ $transaksi->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-green-600">+Rp {{ number_format($transaksi->total_rp, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <svg class="w-12 h-12 text-outline-variant mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-on-surface-variant font-medium">Belum ada transaksi</p>
                                <p class="text-xs text-on-surface-variant">Jadwalkan penjemputan pertama Anda sekarang</p>
                            </div>
                        @endforelse
                    </div>

                    @if($mutasi->hasPages())
                        <div class="mt-4 pt-4 border-t border-outline-variant">
                            {{ $mutasi->links() }}
                        </div>
                    @endif
                </x-card>
            </div>

            <!-- Right Column: Withdrawals & Form -->
            <div class="space-y-6">
                <!-- Withdrawal History Card -->
                <x-card>
                    <div class="mb-4 pb-4 border-b border-outline-variant">
                        <h2 class="text-lg font-bold text-on-surface">🏦 Riwayat Penarikan</h2>
                        <p class="text-xs text-on-surface-variant">Status permintaan penarikan dana Anda</p>
                    </div>

                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @forelse($withdrawals as $withdrawal)
                            <div class="p-3 rounded-lg border border-outline-variant hover:bg-surface-container-low/50 transition-colors">
                                <div class="flex items-start justify-between mb-1">
                                    <p class="text-sm font-semibold text-on-surface">Rp {{ number_format($withdrawal->nominal, 0, ',', '.') }}</p>
                                    <x-badge 
                                        :status="$withdrawal->status === 'pending' ? 'pending' : ($withdrawal->status === 'disetujui' ? 'completed' : 'error')"
                                        :label="ucfirst($withdrawal->status)"
                                    />
                                </div>
                                <p class="text-xs text-on-surface-variant mb-1">{{ ucfirst($withdrawal->metode) }}</p>
                                <p class="text-xs text-outline">{{ $withdrawal->created_at->format('d M Y H:i') }}</p>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-10 h-10 text-outline-variant mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-xs text-on-surface-variant">Belum ada pengajuan penarikan</p>
                            </div>
                        @endforelse
                    </div>

                    @if($withdrawals->hasPages())
                        <div class="mt-3 pt-3 border-t border-outline-variant">
                            {{ $withdrawals->links() }}
                        </div>
                    @endif
                </x-card>

                <!-- Withdrawal Form -->
                <x-card id="withdrawal-form">
                    <div class="mb-4 pb-4 border-b border-outline-variant">
                        <h2 class="text-lg font-bold text-on-surface">💸 Ajukan Penarikan</h2>
                        <p class="text-xs text-on-surface-variant">Tarik dana Anda dengan mudah</p>
                    </div>

                    @if ($errors->any())
                        <x-alert type="error" title="Ada Kesalahan" class="mb-4">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-xs">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-alert>
                    @endif

                    <form action="{{ route('nasabah.withdrawal.request') }}" method="POST" class="space-y-4">
                        @csrf

                        <x-input-field 
                            label="Nominal (Rp)"
                            name="nominal"
                            type="number"
                            placeholder="Minimal Rp 10.000"
                            min="10000"
                            step="1000"
                            required
                            :error="$errors->has('nominal') ? $errors->first('nominal') : false"
                        />

                        <x-select-field 
                            label="Metode Penarikan"
                            name="metode"
                            :items="[
                                ['value' => 'tunai', 'label' => '💵 Tunai'],
                                ['value' => 'transfer', 'label' => '🏦 Transfer Bank'],
                            ]"
                            required
                            :error="$errors->has('metode') ? $errors->first('metode') : false"
                        />

                        <x-input-field 
                            label="Nomor Rekening (Transfer)"
                            name="rekening_tujuan"
                            type="text"
                            placeholder="1234567890"
                            :error="$errors->has('rekening_tujuan') ? $errors->first('rekening_tujuan') : false"
                        />

                        <x-input-field 
                            label="Nama Penerima (Transfer)"
                            name="nama_penerima"
                            type="text"
                            placeholder="Nama pemilik rekening"
                            :error="$errors->has('nama_penerima') ? $errors->first('nama_penerima') : false"
                        />

                        <x-button type="submit" variant="primary" class="w-full">
                            Ajukan Penarikan
                        </x-button>
                    </form>
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>
