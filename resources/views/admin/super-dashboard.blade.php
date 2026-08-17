@extends('layouts.dashboard')

@section('header', 'Overview Nasional')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <style>
        .leaflet-popup-content-wrapper { border-radius: 16px; padding: 4px; background: #0A241B; color: #ffffff; border: 1px solid rgba(255,255,255,0.12); box-shadow: 0 10px 25px rgba(0,0,0,0.5); }
        .leaflet-popup-content { margin: 10px 12px; width: 260px !important; }
        .leaflet-container { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
@endpush

@section('content')
<div class="space-y-6">
    
    @if(!$isSuperAdmin)
        <!-- Banner Admin Unit Bank Sampah -->
        <div class="bg-gradient-to-r from-emerald-900/80 to-slate-900 p-6 rounded-2xl border border-emerald-500/30 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/20 text-emerald-300 rounded-full text-xs font-semibold mb-2">
                    <i class="bi bi-buildings"></i> Admin Unit Bank Sampah
                </div>
                <h2 class="text-2xl font-bold tracking-tight">{{ $metrics['unit_nama'] }}</h2>
                <p class="text-slate-300 text-xs mt-1">
                    <i class="bi bi-geo-alt-fill text-emerald-400"></i> {{ $metrics['unit_alamat'] }} ({{ $metrics['unit_rt_rw'] }}), Desa {{ $metrics['unit_desa'] }}, Kec. {{ $metrics['unit_kecamatan'] }}, {{ $metrics['unit_kabupaten'] }}
                </p>
            </div>
            <div class="bg-slate-800/80 border border-slate-700/80 px-5 py-3 rounded-xl flex items-center gap-4">
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400">Kas Unit Saat Ini</span>
                    <p class="text-xl font-black text-emerald-400">Rp {{ number_format($metrics['unit_kas'], 0, ',', '.') }}</p>
                </div>
                <a href="{{ route('admin.finance.validate') }}" class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-xs font-bold transition-colors">
                    Kelola Kas
                </a>
            </div>
        </div>
    @endif

    <!-- 4 Circular Metric Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="stat-card group">
            <h3 class="stat-label uppercase tracking-wider">Bank Sampah</h3>
            <div class="relative w-20 h-20 mb-2 mx-auto">
                <svg class="w-full h-full -rotate-90 transform origin-center" viewBox="0 0 36 36">
                    <circle class="fill-none stroke-border-color" stroke-width="2.5" cx="18" cy="18" r="15.9155"></circle>
                    <circle class="fill-none stroke-primary stroke-[2.5px] stroke-linecap-round" cx="18" cy="18" r="15.9155" stroke-dasharray="100" stroke-dashoffset="25"></circle>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-xl font-black text-text-primary">{{ number_format($metrics['count_bank_sampah']) }}</span>
                </div>
            </div>
            <p class="trend-up mx-auto"><i class="bi bi-arrow-up-short text-sm"></i> Aktif</p>
        </div>
        
        <!-- Card 2 -->
        <div class="stat-card group">
            <h3 class="stat-label uppercase tracking-wider">Nasabah</h3>
            <div class="relative w-20 h-20 mb-2 mx-auto">
                <svg class="w-full h-full -rotate-90 transform origin-center" viewBox="0 0 36 36">
                    <circle class="fill-none stroke-border-color" stroke-width="2.5" cx="18" cy="18" r="15.9155"></circle>
                    <circle class="fill-none stroke-blue stroke-[2.5px] stroke-linecap-round" cx="18" cy="18" r="15.9155" stroke-dasharray="100" stroke-dashoffset="40"></circle>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-xl font-black text-text-primary">{{ number_format($metrics['count_nasabah']) }}</span>
                </div>
            </div>
            <p class="inline-flex items-center gap-1 text-xs font-bold text-blue mt-1 bg-blue/10 px-2 py-1 rounded-full mx-auto"><i class="bi bi-people text-xs"></i> Pengguna</p>
        </div>
        
        <!-- Card 3 -->
        <div class="stat-card group">
            <h3 class="stat-label uppercase tracking-wider">Volume (Kg)</h3>
            <div class="relative w-20 h-20 mb-2 mx-auto">
                <svg class="w-full h-full -rotate-90 transform origin-center" viewBox="0 0 36 36">
                    <circle class="fill-none stroke-border-color" stroke-width="2.5" cx="18" cy="18" r="15.9155"></circle>
                    <circle class="fill-none stroke-warning stroke-[2.5px] stroke-linecap-round" cx="18" cy="18" r="15.9155" stroke-dasharray="100" stroke-dashoffset="15"></circle>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-base font-black text-text-primary">{{ number_format($metrics['total_berat'], 1) }}</span>
                </div>
                <p class="inline-flex items-center gap-1 text-xs font-bold text-warning mt-1 bg-warning/10 px-2 py-1 rounded-full mx-auto"><i class="bi bi-box-seam text-xs"></i> Daur Ulang</p>
            </div>
        </div>
        
        <!-- Card 4 -->
        <div class="stat-card group">
            <h3 class="stat-label uppercase tracking-wider">Pendapatan</h3>
            <div class="relative w-20 h-20 mb-2 mx-auto">
                <svg class="w-full h-full -rotate-90 transform origin-center" viewBox="0 0 36 36">
                    <circle class="fill-none stroke-border-color" stroke-width="2.5" cx="18" cy="18" r="15.9155"></circle>
                    <circle class="fill-none stroke-mint stroke-[2.5px] stroke-linecap-round" cx="18" cy="18" r="15.9155" stroke-dasharray="100" stroke-dashoffset="60"></circle>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-xs font-black text-text-primary">Rp {{ number_format($metrics['total_pendapatan'] / 1000, 0) }}k</span>
                </div>
            </div>
            <p class="inline-flex items-center gap-1 text-xs font-bold text-mint mt-1 bg-mint/10 px-2 py-1 rounded-full mx-auto"><i class="bi bi-wallet2 text-xs"></i> Total Rp</p>
        </div>
    </div>

    <!-- Peta Sebaran Bank Sampah & Leaderboard Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Peta Sebaran (2 cols) -->
        <div class="lg:col-span-2 card card-body border border-slate-200/80 dark:border-white/10 shadow-soft flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="card-title text-base font-bold flex items-center gap-2">
                        <i class="bi bi-map-fill text-emerald-500"></i> Peta Sebaran Bank Sampah
                    </h3>
                    <p class="text-xs text-slate-400">Pemetaaan lokasi GPS & radius layanan Bank Sampah aktif</p>
                </div>
                <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-bold rounded-lg border border-emerald-500/20">
                    {{ count($allBankSampahs) }} Titik Lokasi
                </span>
            </div>
            
            <div id="sebaranMap" class="w-full h-80 rounded-xl overflow-hidden border border-slate-700/60 z-10"></div>
        </div>

        <!-- Leaderboard Bank Sampah (1 col) -->
        <div class="card card-body border border-slate-200/80 dark:border-white/10 shadow-soft">
            <div class="flex items-center justify-between mb-4">
                <h3 class="card-title text-base font-bold flex items-center gap-2">
                    <i class="bi bi-trophy-fill text-amber-400"></i> Leaderboard Unit
                </h3>
                <span class="text-[10px] font-bold text-slate-400 bg-slate-800 px-2 py-0.5 rounded">Top 10</span>
            </div>

            <div class="space-y-3 overflow-y-auto max-h-80 custom-scrollbar pr-1">
                @forelse($topBankSampahs as $index => $bs)
                    <div class="flex items-center justify-between p-2.5 bg-slate-800/50 hover:bg-slate-800 rounded-xl border border-slate-700/40 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 flex items-center justify-center font-bold text-xs rounded-full 
                                {{ $index == 0 ? 'bg-amber-400 text-slate-900' : ($index == 1 ? 'bg-slate-300 text-slate-900' : ($index == 2 ? 'bg-amber-600 text-white' : 'bg-slate-700 text-slate-300')) }}">
                                {{ $index + 1 }}
                            </span>
                            <div>
                                <h4 class="text-xs font-bold text-white tracking-tight">{{ $bs->nama }}</h4>
                                <p class="text-[10px] text-slate-400"><i class="bi bi-people"></i> {{ $bs->nasabah_count }} Nasabah • {{ number_format($bs->total_berat, 1) }} kg</p>
                            </div>
                        </div>
                        <span class="text-xs font-extrabold text-emerald-400">Rp {{ number_format($bs->total_pendapatan, 0, ',', '.') }}</span>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada data leaderboard.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Main Charts Section -->
    <div class="space-y-6">
        
        <!-- Main Line Chart: Performance Overview -->
        <div class="card card-body relative border border-slate-200/80 dark:border-white/10 shadow-soft">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="card-title">Performance Overview (Pendapatan Nasional)</h2>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-2xl font-black text-text-primary">Rp {{ number_format($metrics['total_pendapatan'], 0, ',', '.') }}</span>
                        <span class="px-2 py-1 bg-emerald-500/10 text-emerald-500 text-[10px] font-bold rounded-full flex items-center gap-1"><i class="bi bi-arrow-up-right"></i> Naik</span>
                    </div>
                </div>
                
                <div class="px-4 py-2 bg-surface/80 border border-slate-200/80 dark:border-white/10 rounded-xl text-xs font-bold text-text-secondary cursor-pointer hover:bg-hover-bg transition-colors flex items-center gap-2">
                    6 Bulan Terakhir <i class="bi bi-chevron-down text-[10px]"></i>
                </div>
            </div>
            
            <div class="w-full h-72">
                <canvas id="chartPendapatanCanvas"></canvas>
            </div>
        </div>
        
        <!-- Bottom Charts Row (Bar / Pie) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Bar Chart -->
            <div class="card card-body border border-slate-200/80 dark:border-white/10 shadow-soft">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="card-title">Volume Setoran (Kg)</h3>
                    <span class="text-[10px] font-bold text-text-muted bg-surface/80 border border-slate-200/80 dark:border-white/10 px-2.5 py-1 rounded-lg">Minggu Ini</span>
                </div>
                <div class="w-full h-52">
                    <canvas id="chartSetoranCanvas"></canvas>
                </div>
            </div>
            
            <!-- Pie Chart -->
            <div class="card card-body border border-slate-200/80 dark:border-white/10 shadow-soft">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="card-title">Komposisi Kategori Sampah</h3>
                    <span class="text-[10px] font-bold text-emerald-500 bg-emerald-500/10 px-2.5 py-1 rounded-lg">Realtime</span>
                </div>
                <div class="w-full h-52">
                    <canvas id="chartJenisSampahCanvas"></canvas>
                </div>
            </div>
        </div>

    </div>
    
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // Define colors globally to match Eco Tech Dark/Light modes
        const isDarkMode = document.documentElement.classList.contains('dark');
        const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.05)' : '#E5E7EB';
        const textColor = isDarkMode ? '#8BA39A' : '#64748B';
        const primaryColor = '#22C55E';
        
        // Common Options for minimal look
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = textColor;
        Chart.defaults.scale.grid.color = gridColor;
        
        // Chart 1: Pendapatan (Line Chart)
        const ctxPendapatan = document.getElementById('chartPendapatanCanvas');
        if (ctxPendapatan) {
            new Chart(ctxPendapatan, {
                type: 'line',
                data: {
                    labels: @json($chartPendapatan['labels']),
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: @json($chartPendapatan['data']),
                        borderColor: primaryColor,
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: isDarkMode ? '#072018' : '#ffffff',
                        pointBorderColor: primaryColor,
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { border: { display: false }, beginAtZero: true },
                        x: { border: { display: false }, grid: { display: false } }
                    }
                }
            });
        }

        // Chart 2: Setoran (Bar Chart)
        const ctxSetoran = document.getElementById('chartSetoranCanvas');
        if (ctxSetoran) {
            new Chart(ctxSetoran, {
                type: 'bar',
                data: {
                    labels: @json($chartSetoran['labels']),
                    datasets: [{
                        label: 'Setoran (Kg)',
                        data: @json($chartSetoran['data']),
                        backgroundColor: primaryColor,
                        borderRadius: 6,
                        barPercentage: 0.5
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { border: { display: false }, display: false },
                        x: { border: { display: false }, grid: { display: false } }
                    }
                }
            });
        }

        // Chart 3: Jenis Sampah (Doughnut Chart)
        const ctxJenis = document.getElementById('chartJenisSampahCanvas');
        if (ctxJenis) {
            new Chart(ctxJenis, {
                type: 'doughnut',
                data: {
                    labels: @json($chartJenisSampah['labels']),
                    datasets: [{
                        data: @json($chartJenisSampah['data']),
                        backgroundColor: ['#22C55E', '#3B82F6', '#F59E0B', '#34D399', '#10B981', '#14B8A6', '#F43F5E'],
                        borderWidth: 0,
                        cutout: '75%'
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { position: 'right', labels: { boxWidth: 10, usePointStyle: true, font: { size: 11, weight: 'bold' } } } 
                    }
                }
            });
        }

        // GIS Map Initialization with Radius Circles
        const bankData = @json($allBankSampahs);
        const mapContainer = document.getElementById('sebaranMap');
        
        if (mapContainer && bankData && bankData.length > 0) {
            const defaultLat = parseFloat(bankData[0].latitude) || -6.8915;
            const defaultLng = parseFloat(bankData[0].longitude) || 107.6107;
            
            const map = L.map('sebaranMap').setView([defaultLat, defaultLng], 9);
            
            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                maxZoom: 19,
                attribution: '&copy; CARTO & OpenStreetMap'
            }).addTo(map);

            const bounds = [];

            bankData.forEach(bank => {
                if (bank.latitude && bank.longitude) {
                    const lat = parseFloat(bank.latitude);
                    const lng = parseFloat(bank.longitude);
                    const radiusMeters = bank.radius_layanan ? parseInt(bank.radius_layanan) : 2000;
                    bounds.push([lat, lng]);

                    // Service Radius Circle (Emerald)
                    L.circle([lat, lng], {
                        color: '#10B981',
                        fillColor: '#10B981',
                        fillOpacity: 0.15,
                        weight: 2,
                        dashArray: '5, 5'
                    }).addTo(map);

                    // Marker
                    const marker = L.marker([lat, lng]).addTo(map);
                    
                    const popupHtml = `
                        <div class="space-y-1.5 p-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 rounded-md text-[10px] font-black">${bank.kode_bank}</span>
                                <h4 class="font-bold text-xs text-white">${bank.nama}</h4>
                            </div>
                            <p class="text-[11px] text-gray-300">${bank.alamat}</p>
                            <div class="pt-1.5 border-t border-white/10 text-[10px] text-emerald-300 font-semibold space-y-0.5">
                                <div><i class="bi bi-geo text-[10px]"></i> Radius Layanan: <strong>${(radiusMeters/1000).toFixed(1)} km</strong></div>
                                <div><i class="bi bi-clock text-[10px]"></i> Jam Buka: ${bank.jam_buka || '08:00'} - ${bank.jam_tutup || '16:00'}</div>
                            </div>
                        </div>
                    `;
                    marker.bindPopup(popupHtml);
                }
            });

            if (bounds.length > 0) {
                map.fitBounds(bounds, { padding: [30, 30] });
            }
        }
    });
</script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
@endpush
