@extends('layouts.dashboard')

@section('header', 'Overview Nasional')

@section('content')
<div class="space-y-6">
    
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
            </div>
            <p class="inline-flex items-center gap-1 text-xs font-bold text-warning mt-1 bg-warning/10 px-2 py-1 rounded-full mx-auto"><i class="bi bi-box-seam text-xs"></i> Terselamatkan</p>
        </div>
        
        <!-- Card 4 -->
        <div class="stat-card group">
            <h3 class="stat-label uppercase tracking-wider">Transaksi</h3>
            <div class="relative w-20 h-20 mb-2 mx-auto">
                <svg class="w-full h-full -rotate-90 transform origin-center" viewBox="0 0 36 36">
                    <circle class="fill-none stroke-border-color" stroke-width="2.5" cx="18" cy="18" r="15.9155"></circle>
                    <circle class="fill-none stroke-mint stroke-[2.5px] stroke-linecap-round" cx="18" cy="18" r="15.9155" stroke-dasharray="100" stroke-dashoffset="60"></circle>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-xl font-black text-text-primary">{{ number_format($metrics['count_transaksi']) }}</span>
                </div>
            </div>
            <p class="inline-flex items-center gap-1 text-xs font-bold text-mint mt-1 bg-mint/10 px-2 py-1 rounded-full mx-auto"><i class="bi bi-arrow-down-up text-xs"></i> Aktivitas</p>
        </div>
    </div>

    <!-- Main Split Section -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <!-- Left Main Column (Charts) -->
        <div class="xl:col-span-2 space-y-6">
            
            <!-- Main Line Chart: Performance Overview -->
            <div class="card card-body relative">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="card-title">Performance Overview</h2>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-2xl font-black text-text-primary">Rp {{ number_format($metrics['total_pendapatan'], 0, ',', '.') }}</span>
                            <span class="px-2 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded-full flex items-center gap-1"><i class="bi bi-arrow-up-right"></i> Naik</span>
                        </div>
                    </div>
                    
                    <div class="px-4 py-2 bg-surface border border-border-color rounded-btn text-xs font-bold text-text-secondary cursor-pointer hover:bg-hover-bg transition-colors flex items-center gap-2">
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
                <div class="card card-body">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="card-title">Setoran (Kg)</h3>
                        <span class="text-[10px] font-bold text-text-muted bg-surface border border-border-color px-2 py-1 rounded">Minggu Ini</span>
                    </div>
                    <div class="w-full h-52">
                        <canvas id="chartSetoranCanvas"></canvas>
                    </div>
                </div>
                
                <!-- Pie Chart -->
                <div class="card card-body">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="card-title">Komposisi Sampah</h3>
                        <a href="#" class="text-[10px] font-bold text-primary hover:underline">Detail</a>
                    </div>
                    <div class="w-full h-52">
                        <canvas id="chartJenisSampahCanvas"></canvas>
                    </div>
                </div>
            </div>

        </div>
        
        <!-- Right Column (List / Top Bank Sampah) -->
        <div class="xl:col-span-1">
            <div class="card h-full flex flex-col">
                
                <div class="card-header border-b border-border-color">
                    <h2 class="card-title">Top Bank Sampah</h2>
                    <button class="w-8 h-8 rounded-full flex items-center justify-center text-text-muted hover:bg-hover-bg hover:text-text-primary transition-colors">
                        <i class="bi bi-three-dots"></i>
                    </button>
                </div>
                
                <div class="flex-1 overflow-y-auto custom-scrollbar p-6 space-y-5">
                    @forelse($topBankSampahs as $index => $bs)
                        <div class="flex items-start justify-between group cursor-pointer">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-surface border border-border-color flex items-center justify-center overflow-hidden flex-shrink-0 group-hover:border-primary/50 transition-colors relative">
                                    @if($bs->logo_url)
                                        <img src="{{ $bs->logo_url }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($bs->nama) }}&background=22C55E&color=fff';">
                                    @else
                                        <i class="bi bi-buildings text-text-muted"></i>
                                    @endif
                                    
                                    @if($index < 3)
                                        <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-warning border-2 border-card rounded-full flex items-center justify-center text-[9px] font-black text-white shadow-soft">
                                            {{ $index + 1 }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-text-primary group-hover:text-primary transition-colors leading-tight">{{ $bs->nama }}</h4>
                                    <p class="text-[11px] font-semibold text-text-muted mt-1">{{ $bs->kabupaten }}</p>
                                    <p class="text-[11px] text-text-muted mt-0.5">Vol: <span class="font-bold text-text-secondary">{{ number_format($bs->total_berat ?: 0, 1) }} Kg</span></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-text-primary">Rp {{ number_format(round(($bs->total_pendapatan ?: 0) / 1000), 0, ',', '.') }}k</p>
                                <span class="inline-block px-2 py-1 bg-primary/10 text-primary rounded text-[10px] font-bold mt-1.5">
                                    {{ $bs->nasabah_count }} Nsbh
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <div class="w-14 h-14 rounded-full bg-surface border border-border-color mx-auto flex items-center justify-center mb-4">
                                <i class="bi bi-inbox text-2xl text-text-muted"></i>
                            </div>
                            <p class="text-sm font-bold text-text-muted">Belum ada data tersedia.</p>
                        </div>
                    @endforelse
                </div>
                
                <div class="p-6 border-t border-border-color bg-surface">
                    <a href="{{ route('admin.master_bank_sampah.index') }}" class="flex items-center justify-between text-sm font-bold text-primary hover:text-primary-dark transition-colors w-full">
                        <span>Lihat Semua Unit</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
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

    });
</script>
@endpush
