<!-- Admin Dashboard -->
<x-app-layout title="Dashboard Admin">
    <div class="space-y-6">
        <!-- Header with Summary -->
        <div class="bg-gradient-to-r from-primary via-forest-emerald to-primary rounded-2xl p-8 text-white shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <p class="text-white/80 text-sm font-medium mb-1">Total Sampah Hari Ini</p>
                    <p class="text-4xl font-bold">2,450 kg</p>
                    <p class="text-white/70 text-xs mt-2">↑ 12% dari kemarin</p>
                </div>
                <div>
                    <p class="text-white/80 text-sm font-medium mb-1">Transaksi Selesai</p>
                    <p class="text-4xl font-bold">84</p>
                    <p class="text-white/70 text-xs mt-2">📍 15 dari 18 RT</p>
                </div>
                <div>
                    <p class="text-white/80 text-sm font-medium mb-1">Total Pengeluaran</p>
                    <p class="text-4xl font-bold">Rp 12,2 Jt</p>
                    <p class="text-white/70 text-xs mt-2">Untuk 84 transaksi</p>
                </div>
            </div>
        </div>

        <!-- Key Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <x-stat-tile 
                title="127" 
                subtitle="Nasabah Aktif"
                trend="up"
                trendValue="+8 minggu ini"
            >
                <x-slot:icon>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 13a6 6 0 11-12 0 6 6 0 0112 0z" />
                    </svg>
                </x-slot:icon>
            </x-stat-tile>

            <x-stat-tile 
                title="45,200 kg" 
                subtitle="Sampah Terkumpul"
                trend="up"
                trendValue="+2.450 kg hari ini"
            >
                <x-slot:icon>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4.5 3a2.5 2.5 0 00-2.5 2.5v7A2.5 2.5 0 004.5 15h11a2.5 2.5 0 002.5-2.5v-7A2.5 2.5 0 0015.5 3h-11zM5 5h10v8H5V5z" />
                    </svg>
                </x-slot:icon>
            </x-stat-tile>

            <x-stat-tile 
                title="Rp 45,6 Jt" 
                subtitle="Nilai Sampah"
                trend="up"
                trendValue="+Rp 2,25 Jt"
            >
                <x-slot:icon>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.5 10.5A1.5 1.5 0 1010 9a1.5 1.5 0 00-1.5 1.5z" />
                        <path fill-rule="evenodd" d="M0 10a10 10 0 1020 0 10 10 0 01-20 0zm10-8a8 8 0 100 16 8 8 0 000-16z" clip-rule="evenodd" />
                    </svg>
                </x-slot:icon>
            </x-stat-tile>

            <x-stat-tile 
                title="18/18" 
                subtitle="RT Partisipasi"
                trend="up"
                trendValue="100%"
            >
                <x-slot:icon>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                </x-slot:icon>
            </x-stat-tile>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Trash by Category Chart -->
            <x-card>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-on-surface">Sampah Berdasarkan Kategori</h3>
                    <button class="text-on-surface-variant hover:text-on-surface transition-colors">⋯</button>
                </div>
                <div class="space-y-3">
                    @php
                        $categories = [
                            ['name' => 'Plastik', 'value' => 45, 'color' => 'bg-blue-500', 'amount' => '2.025 kg'],
                            ['name' => 'Kertas', 'value' => 30, 'color' => 'bg-yellow-500', 'amount' => '1.350 kg'],
                            ['name' => 'Metal', 'value' => 15, 'color' => 'bg-gray-500', 'amount' => '675 kg'],
                            ['name' => 'Kaca', 'value' => 10, 'color' => 'bg-green-500', 'amount' => '450 kg'],
                        ]
                    @endphp
                    @foreach($categories as $cat)
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-on-surface">{{ $cat['name'] }}</span>
                                <span class="text-xs text-on-surface-variant">{{ $cat['amount'] }}</span>
                            </div>
                            <div class="w-full bg-surface-container-high rounded-full h-2">
                                <div class="{{ $cat['color'] }} h-full rounded-full" style="width: {{ $cat['value'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-card>

            <!-- Activity Timeline -->
            <x-card>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-on-surface">Aktivitas Terbaru</h3>
                    <button class="text-on-surface-variant hover:text-on-surface transition-colors">⋯</button>
                </div>
                <div class="space-y-3">
                    @for($i = 0; $i < 4; $i++)
                        <div class="flex gap-3">
                            <div class="w-2 h-2 rounded-full bg-primary mt-2 flex-shrink-0"></div>
                            <div>
                                <p class="text-sm font-medium text-on-surface">Petugas {{ 'ABCD'[$i] }} - Penjemputan RT {{ $i + 1 }}</p>
                                <p class="text-xs text-on-surface-variant">{{ rand(2, 8) }}5 kg • {{ rand(10, 23) }}:{{ rand(10, 59) }}</p>
                            </div>
                        </div>
                    @endfor
                </div>
            </x-card>
        </div>

        <!-- Pending Withdrawal Requests -->
        <x-card>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-on-surface">Permintaan Penarikan Dana Pending</h3>
                <x-button variant="ghost" size="sm">Lihat Semua →</x-button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-outline-variant">
                        <tr>
                            <th class="text-left py-3 px-4 font-semibold text-on-surface">Nasabah</th>
                            <th class="text-left py-3 px-4 font-semibold text-on-surface">Jumlah</th>
                            <th class="text-left py-3 px-4 font-semibold text-on-surface">Metode</th>
                            <th class="text-left py-3 px-4 font-semibold text-on-surface">Tanggal</th>
                            <th class="text-left py-3 px-4 font-semibold text-on-surface">Status</th>
                            <th class="text-left py-3 px-4 font-semibold text-on-surface">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i < 3; $i++)
                            <tr class="border-b border-outline-variant hover:bg-surface-container transition-colors">
                                <td class="py-3 px-4">
                                    <span class="font-medium text-on-surface">Nama Nasabah {{ $i + 1 }}</span>
                                </td>
                                <td class="py-3 px-4">Rp {{ number_format(rand(100, 500) * 1000, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-semibold">
                                        {{ ['Transfer Bank', 'Tunai', 'E-Wallet'][array_rand(['Transfer Bank', 'Tunai', 'E-Wallet'])] }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-on-surface-variant">5 Des 2024</td>
                                <td class="py-3 px-4">
                                    <x-badge status="pending" label="Pending" />
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex gap-2">
                                        <x-button variant="ghost" size="sm">✓</x-button>
                                        <x-button variant="danger" size="sm">✕</x-button>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</x-app-layout>
