@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Header Section --}}
    <div class="mb-8 animate-fade-in">
        <div class="bg-gradient-to-r from-primary to-forest-emerald rounded-2xl p-8 shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Laporan & Analitik</h1>
                    <p class="text-white/90">Pantau performa sistem dan aktivitas pengguna</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-6 py-3 bg-white text-primary font-bold rounded-xl hover:shadow-lg transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export
                    </button>
                    <button class="px-6 py-3 bg-white/20 hover:bg-white/30 font-bold rounded-xl transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Refresh
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Controls --}}
    <div class="mb-8 animate-slide-in">
        <x-card class="border border-outline-variant">
            <h3 class="text-lg font-bold text-on-surface mb-4">Filter Laporan</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <x-select-field
                    label="Jenis Laporan"
                    name="report_type"
                    :options="[
                        'all' => 'Semua Laporan',
                        'transaksi' => 'Transaksi',
                        'pengguna' => 'Pengguna',
                        'sampah' => 'Sampah',
                        'performa' => 'Performa Sistem'
                    ]"
                />
                <x-select-field
                    label="Periode"
                    name="period"
                    :options="[
                        'today' => 'Hari Ini',
                        'week' => '7 Hari Terakhir',
                        'month' => '1 Bulan Terakhir',
                        'quarter' => '3 Bulan Terakhir',
                        'year' => '1 Tahun'
                    ]"
                />
                <x-input-field
                    label="Dari Tanggal"
                    name="date_from"
                    type="date"
                />
                <x-input-field
                    label="Sampai Tanggal"
                    name="date_to"
                    type="date"
                />
            </div>
            <div class="flex gap-3 mt-6">
                <button class="px-6 py-2.5 bg-primary hover:bg-primary-container text-white font-bold rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>
                <button class="px-6 py-2.5 bg-surface-container hover:bg-surface-container-lowest text-on-surface font-bold rounded-lg transition-colors">
                    Reset
                </button>
            </div>
        </x-card>
    </div>

    {{-- Key Metrics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-slide-in">
        <x-stat-tile
            title="Total Transaksi"
            value="2,347"
            icon="arrow-up-right"
            stat_value="+12.5%"
            trend_positive
            sub_text="vs bulan lalu"
        />
        <x-stat-tile
            title="Total Sampah"
            value="1.247 Kg"
            icon="shopping-bag"
            stat_value="+8.2%"
            trend_positive
            sub_text="Tahun ini"
        />
        <x-stat-tile
            title="Pengguna Aktif"
            value="483"
            icon="users"
            stat_value="+5.1%"
            trend_positive
            sub_text="Bulan ini"
        />
        <x-stat-tile
            title="Nilai Transaksi"
            value="Rp 45.2M"
            icon="banknote"
            stat_value="+18.7%"
            trend_positive
            sub_text="vs bulan lalu"
        />
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 animate-slide-in">
        {{-- Transaksi Trend --}}
        <x-card class="border border-outline-variant">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-on-surface">Tren Transaksi</h3>
                <p class="text-sm text-on-surface-variant">30 hari terakhir</p>
            </div>
            <div class="h-64 bg-gradient-to-br from-primary/10 to-forest-emerald/10 rounded-lg flex items-center justify-center border border-outline-variant">
                <div class="text-center">
                    <svg class="w-16 h-16 text-primary/40 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <p class="text-on-surface-variant text-sm">Chart integration placeholder</p>
                </div>
            </div>
        </x-card>

        {{-- Sampah Kategori --}}
        <x-card class="border border-outline-variant">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-on-surface">Sampah per Kategori</h3>
                <p class="text-sm text-on-surface-variant">Distribusi sampah</p>
            </div>
            <div class="space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-on-surface">Plastik</span>
                        <span class="text-sm font-bold text-primary">425 Kg (35%)</span>
                    </div>
                    <div class="w-full bg-outline-variant rounded-full h-2">
                        <div class="bg-gradient-to-r from-primary to-forest-emerald h-2 rounded-full" style="width: 35%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-on-surface">Kertas</span>
                        <span class="text-sm font-bold text-forest-emerald">300 Kg (25%)</span>
                    </div>
                    <div class="w-full bg-outline-variant rounded-full h-2">
                        <div class="bg-gradient-to-r from-forest-emerald to-primary h-2 rounded-full" style="width: 25%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-on-surface">Logam</span>
                        <span class="text-sm font-bold text-orange-500">275 Kg (23%)</span>
                    </div>
                    <div class="w-full bg-outline-variant rounded-full h-2">
                        <div class="bg-orange-500 h-2 rounded-full" style="width: 23%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-on-surface">Kaca</span>
                        <span class="text-sm font-bold text-blue-500">147 Kg (12%)</span>
                    </div>
                    <div class="w-full bg-outline-variant rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 12%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-on-surface">Organik</span>
                        <span class="text-sm font-bold text-green-600">100 Kg (5%)</span>
                    </div>
                    <div class="w-full bg-outline-variant rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 5%"></div>
                    </div>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Activity Table --}}
    <x-card class="border border-outline-variant overflow-hidden animate-slide-in">
        <div class="p-6 border-b border-outline-variant">
            <h3 class="text-xl font-bold text-on-surface">Aktivitas Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-surface-container border-b border-outline-variant">
                    <tr>
                        <th class="text-left py-4 px-6 font-bold text-on-surface">Tanggal & Waktu</th>
                        <th class="text-left py-4 px-6 font-bold text-on-surface">Pengguna</th>
                        <th class="text-left py-4 px-6 font-bold text-on-surface">Aktivitas</th>
                        <th class="text-left py-4 px-6 font-bold text-on-surface">Detail</th>
                        <th class="text-center py-4 px-6 font-bold text-on-surface">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="py-4 px-6 text-sm text-on-surface">
                            <div>
                                <p class="font-semibold">Hari ini, 14:32</p>
                                <p class="text-xs text-on-surface-variant">{{ now()->translatedFormat('d M Y') }}</p>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div>
                                <p class="font-semibold text-on-surface">Budi Santoso</p>
                                <p class="text-xs text-on-surface-variant">Nasabah</p>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium">Transaksi Baru</span>
                        </td>
                        <td class="py-4 px-6 text-sm text-on-surface-variant">
                            25 Kg Plastik - Rp 87.500
                        </td>
                        <td class="py-4 px-6 text-center">
                            <x-badge status="completed" label="Berhasil" />
                        </td>
                    </tr>

                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="py-4 px-6 text-sm text-on-surface">
                            <div>
                                <p class="font-semibold">Hari ini, 13:15</p>
                                <p class="text-xs text-on-surface-variant">{{ now()->translatedFormat('d M Y') }}</p>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div>
                                <p class="font-semibold text-on-surface">Admin Sistem</p>
                                <p class="text-xs text-on-surface-variant">Administrator</p>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 bg-purple-50 text-purple-700 rounded-lg text-sm font-medium">Perubahan Harga</span>
                        </td>
                        <td class="py-4 px-6 text-sm text-on-surface-variant">
                            Plastik: Rp 3.500 ? Rp 3.750
                        </td>
                        <td class="py-4 px-6 text-center">
                            <x-badge status="completed" label="Berhasil" />
                        </td>
                    </tr>

                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="py-4 px-6 text-sm text-on-surface">
                            <div>
                                <p class="font-semibold">Kemarin, 16:45</p>
                                <p class="text-xs text-on-surface-variant">{{ now()->subDay()->translatedFormat('d M Y') }}</p>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div>
                                <p class="font-semibold text-on-surface">Siti Nurhaliza</p>
                                <p class="text-xs text-on-surface-variant">Nasabah</p>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium">Transaksi Baru</span>
                        </td>
                        <td class="py-4 px-6 text-sm text-on-surface-variant">
                            15 Kg Kertas + 8 Kg Logam - Rp 74.000
                        </td>
                        <td class="py-4 px-6 text-center">
                            <x-badge status="completed" label="Berhasil" />
                        </td>
                    </tr>

                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="py-4 px-6 text-sm text-on-surface">
                            <div>
                                <p class="font-semibold">Kemarin, 11:20</p>
                                <p class="text-xs text-on-surface-variant">{{ now()->subDay()->translatedFormat('d M Y') }}</p>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div>
                                <p class="font-semibold text-on-surface">Petugas Lapangan</p>
                                <p class="text-xs text-on-surface-variant">Petugas</p>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 bg-green-50 text-green-700 rounded-lg text-sm font-medium">Verifikasi Transaksi</span>
                        </td>
                        <td class="py-4 px-6 text-sm text-on-surface-variant">
                            Verifikasi 12 transaksi - Semuanya valid
                        </td>
                        <td class="py-4 px-6 text-center">
                            <x-badge status="completed" label="Berhasil" />
                        </td>
                    </tr>

                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="py-4 px-6 text-sm text-on-surface">
                            <div>
                                <p class="font-semibold">2 hari lalu, 09:30</p>
                                <p class="text-xs text-on-surface-variant">{{ now()->subDays(2)->translatedFormat('d M Y') }}</p>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div>
                                <p class="font-semibold text-on-surface">Admin Sistem</p>
                                <p class="text-xs text-on-surface-variant">Administrator</p>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 bg-yellow-50 text-yellow-700 rounded-lg text-sm font-medium">Backup Sistem</span>
                        </td>
                        <td class="py-4 px-6 text-sm text-on-surface-variant">
                            Backup otomatis - 2.4 GB
                        </td>
                        <td class="py-4 px-6 text-center">
                            <x-badge status="completed" label="Berhasil" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="bg-surface-container-lowest px-6 py-4 border-t border-outline-variant flex items-center justify-between">
            <p class="text-sm text-on-surface-variant">Menampilkan 1-5 dari 127 aktivitas</p>
            <div class="flex gap-2">
                <button class="px-4 py-2 text-on-surface border border-outline-variant rounded-lg hover:bg-surface-container transition-colors disabled:opacity-50" disabled>
                    Sebelumnya
                </button>
                <button class="px-4 py-2 text-on-surface border border-outline-variant rounded-lg hover:bg-surface-container transition-colors">
                    Selanjutnya
                </button>
            </div>
        </div>
    </x-card>

    {{-- System Health --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8 animate-slide-in">
        <x-card class="border border-outline-variant">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-sm text-on-surface-variant">Server Status</p>
                    <h4 class="text-xl font-bold text-on-surface">Sehat</h4>
                </div>
                <div class="p-3 bg-green-50 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="space-y-2 text-xs text-on-surface-variant">
                <p>Uptime: 99.95%</p>
                <p>Response: 145ms</p>
                <p>CPU: 32%</p>
            </div>
        </x-card>

        <x-card class="border border-outline-variant">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-sm text-on-surface-variant">Database</p>
                    <h4 class="text-xl font-bold text-on-surface">Optimal</h4>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 6a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm0 8a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z"/>
                    </svg>
                </div>
            </div>
            <div class="space-y-2 text-xs text-on-surface-variant">
                <p>Queries: 2.4k/min</p>
                <p>Memory: 78%</p>
                <p>Size: 245 MB</p>
            </div>
        </x-card>

        <x-card class="border border-outline-variant">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-sm text-on-surface-variant">Storage</p>
                    <h4 class="text-xl font-bold text-on-surface">85% Penuh</h4>
                </div>
                <div class="p-3 bg-orange-50 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                    </svg>
                </div>
            </div>
            <div class="space-y-2 text-xs text-on-surface-variant">
                <p>Available: 45 GB</p>
                <p>Total: 300 GB</p>
                <button class="text-primary font-bold hover:underline mt-2">Lihat Detail</button>
            </div>
        </x-card>
    </div>
</div>

@endsection
