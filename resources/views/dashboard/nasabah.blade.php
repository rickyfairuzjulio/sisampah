<!-- Nasabah Dashboard -->
<x-app-layout title="Dashboard">
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-primary to-forest-emerald rounded-2xl p-8 text-white shadow-lg">
            <h1 class="text-3xl font-bold mb-2">Selamat Datang! 👋</h1>
            <p class="text-white/90">Kelola sampahmu dan raih penghasilan bersama SiSampah</p>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-stat-tile 
                title="Rp 2.500.000" 
                subtitle="Saldo Anda"
                trend="up"
                trendValue="+Rp 250.000 bulan ini"
            >
                <x-slot:icon>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.16 2.75a.75.75 0 00-.75.75v2.5H4.5a2.75 2.75 0 000 5.5h2.91v2.5a.75.75 0 001.5 0v-2.5h2.91a2.75 2.75 0 000-5.5H11v-2.5a.75.75 0 00-.75-.75H8.16z" />
                    </svg>
                </x-slot:icon>
            </x-stat-tile>

            <x-stat-tile 
                title="1.250 poin" 
                subtitle="Poin Komunitas"
                trend="up"
                trendValue="+125 poin"
            >
                <x-slot:icon>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </x-slot:icon>
            </x-stat-tile>

            <x-stat-tile 
                title="Peringkat #5" 
                subtitle="Komunitas Anda"
            >
                <x-slot:icon>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3.5 2a1.5 1.5 0 100 3 1.5 1.5 0 000-3zM11 5a3 3 0 11-6 0 3 3 0 016 0zM16.5 2a1.5 1.5 0 100 3 1.5 1.5 0 000-3zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 13a1 1 0 11-2 0 1 1 0 012 0z" />
                    </svg>
                </x-slot:icon>
            </x-stat-tile>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-card hover class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-on-surface mb-1">Jadwalkan Penjemputan</h3>
                    <p class="text-sm text-on-surface-variant">Pesan penjemputan sampah Anda</p>
                </div>
                <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.893 3.5a.75.75 0 00-1.786 0l-.718 3.268a.75.75 0 001.482.328L9.2 6.971h3.6l.329 1.504a.75.75 0 101.482-.328l-.718-3.268zM4 13a4 4 0 100 8 4 4 0 000-8zm7.5 2a.75.75 0 01.75.75v2.5a.75.75 0 01-1.5 0v-2.5a.75.75 0 01.75-.75zM14 16a.75.75 0 00-1.5 0v2a.75.75 0 101.5 0v-2z" />
                </svg>
            </x-card>

            <x-card hover class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-on-surface mb-1">Tarik Dana</h3>
                    <p class="text-sm text-on-surface-variant">Cairkan saldo Anda sekarang</p>
                </div>
                <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 7a1 1 0 011 1v3a1 1 0 01-2 0v-3a1 1 0 011-1zm6-5a1 1 0 011 1v3a1 1 0 01-2 0V5a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
            </x-card>
        </div>

        <!-- Recent Transactions -->
        <x-card>
            <h2 class="text-lg font-bold text-on-surface mb-4">Transaksi Terakhir</h2>
            <div class="space-y-3">
                @for($i = 0; $i < 5; $i++)
                    <div class="flex items-center justify-between pb-3 border-b border-outline-variant last:border-b-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-on-surface">Setoran Sampah Plastik</p>
                                <p class="text-xs text-on-surface-variant">15 kg • 5 Des 2024</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-green-600">+Rp 50.000</p>
                            <x-badge status="completed" label="Selesai" />
                        </div>
                    </div>
                @endfor
            </div>
        </x-card>
    </div>
</x-app-layout>
