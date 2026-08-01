@extends('layouts.dashboard')

@section('header', 'Peta Sebaran Bank Sampah')

@section('content')
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <style>
        #sebaran-full-map { height: 300px; width: 100%; border-radius: 20px; z-index: 0; }
        @media (min-width: 1024px) {
            #sebaran-full-map { height: 460px; }
        }
        .leaflet-popup-content-wrapper { border-radius: 20px; padding: 4px; background: #0A241B; color: #ffffff; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 12px 30px -5px rgba(0,0,0,0.5); }
        .leaflet-popup-content { margin: 12px; width: 280px !important; }
        .leaflet-container { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Animated dashed route polyline */
        .animated-polyline {
            stroke-dasharray: 8, 8;
            animation: dash 1.5s linear infinite;
        }
        @keyframes dash {
            to { stroke-dashoffset: -16; }
        }

        /* Pulsing User GPS Marker */
        .user-gps-marker {
            width: 22px;
            height: 22px;
            background-color: #2DD67B;
            border: 3px solid #ffffff;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(45, 214, 123, 0.7);
            animation: pulse-gps 1.8s infinite;
        }
        @keyframes pulse-gps {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(45, 214, 123, 0.7); }
            70% { transform: scale(1.15); box-shadow: 0 0 0 14px rgba(45, 214, 123, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(45, 214, 123, 0); }
        }
    </style>
    @endpush

    <div class="space-y-6">
        <!-- Header Bar (8pt system, 24px gap) -->
        <div class="bg-[#0A241B] p-5 rounded-[20px] border border-white/10 shadow-lg flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#2DD67B]/10 border border-[#2DD67B]/30 rounded-2xl flex items-center justify-center text-[#2DD67B] shadow-md text-xl shrink-0">
                    <i class="bi bi-globe-americas"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white tracking-tight">GIS Dashboard: Peta Sebaran & Radius Layanan</h1>
                    <p class="text-sm font-medium text-[#B7C7C1] mt-0.5">Analisis spasial area jangkauan radius (Service Coverage Maks. 2 Km), jarak nasabah GPS, & rute tempuh</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.master_bank_sampah.index') }}" class="min-h-[44px] px-4 py-2.5 bg-[#04160F] border border-white/10 rounded-xl text-xs font-bold text-[#B7C7C1] hover:text-white hover:bg-white/5 transition-all flex items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Master Tabel Data
                </a>
                <a href="{{ route('admin.master_bank_sampah.create') }}" class="min-h-[44px] px-4 py-2.5 bg-[#2DD67B] hover:bg-[#22C55E] text-[#04160F] font-bold rounded-xl text-xs transition-all shadow-md flex items-center gap-2">
                    <i class="bi bi-plus-circle-fill"></i> Tambah Bank Sampah
                </a>
            </div>
        </div>

        <!-- Dashboard GIS Statistics Bar -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 text-xs">
            <div class="bg-[#0A241B] p-5 rounded-[20px] border border-white/10 shadow-lg">
                <span class="text-[#B7C7C1] font-semibold block text-xs flex items-center gap-1.5"><i class="bi bi-buildings text-white"></i> Total Unit</span>
                <span class="text-xl font-bold text-white mt-1 block">{{ $gisStats['total_bank_sampah'] }} Unit</span>
            </div>
            <div class="bg-[#0A241B] p-5 rounded-[20px] border border-white/10 shadow-lg">
                <span class="text-[#B7C7C1] font-semibold block text-xs flex items-center gap-1.5"><i class="bi bi-radar text-[#2DD67B]"></i> Luas Area</span>
                <span class="text-xl font-bold text-[#2DD67B] mt-1 block">{{ $gisStats['total_coverage_km2'] }} km²</span>
            </div>
            <div class="bg-[#0A241B] p-5 rounded-[20px] border border-white/10 shadow-lg">
                <span class="text-[#B7C7C1] font-semibold block text-xs flex items-center gap-1.5"><i class="bi bi-people-fill text-blue-400"></i> Nasabah</span>
                <span class="text-xl font-bold text-blue-400 mt-1 block">{{ number_format($gisStats['total_nasabah']) }}</span>
            </div>
            <div class="bg-[#0A241B] p-5 rounded-[20px] border border-white/10 shadow-lg">
                <span class="text-[#B7C7C1] font-semibold block text-xs flex items-center gap-1.5"><i class="bi bi-check-circle-fill text-[#2DD67B]"></i> Aktif</span>
                <span class="text-xl font-bold text-[#2DD67B] mt-1 block">{{ $gisStats['aktif_count'] }}</span>
            </div>
            <div class="bg-[#0A241B] p-5 rounded-[20px] border border-white/10 shadow-lg">
                <span class="text-[#B7C7C1] font-semibold block text-xs flex items-center gap-1.5"><i class="bi bi-pause-circle-fill text-amber-400"></i> Libur</span>
                <span class="text-xl font-bold text-amber-400 mt-1 block">{{ $gisStats['libur_count'] }}</span>
            </div>
            <div class="bg-[#0A241B] p-5 rounded-[20px] border border-white/10 shadow-lg">
                <span class="text-[#B7C7C1] font-semibold block text-xs flex items-center gap-1.5"><i class="bi bi-x-circle-fill text-rose-400"></i> Nonaktif</span>
                <span class="text-xl font-bold text-rose-400 mt-1 block">{{ $gisStats['nonaktif_count'] }}</span>
            </div>
        </div>

        <!-- Control Bar: Deteksi GPS -->
        <div class="bg-[#0A241B] p-5 rounded-[20px] border border-white/10 shadow-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <span class="text-sm font-bold text-white flex items-center gap-2">
                    <i class="bi bi-bullseye text-[#2DD67B] text-base"></i> Analisis Spasial Jangkauan Layanan (Maksimal Radius 2 Km)
                </span>
                <p class="text-xs text-[#B7C7C1] mt-0.5">Menampilkan seluruh unit Bank Sampah dan lingkaran jangkauan maksimal 2 kilometer</p>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button id="btn-request-gps" class="min-h-[44px] px-5 py-2.5 bg-[#2DD67B]/10 hover:bg-[#2DD67B]/20 text-[#2DD67B] border border-[#2DD67B]/30 font-bold rounded-xl text-xs transition-all flex items-center justify-center gap-2 shadow-sm w-full sm:w-auto">
                    <i class="bi bi-crosshair text-sm"></i> Deteksi Lokasi Saya (GPS)
                </button>
            </div>
        </div>

        <!-- GIS GPS Warning Notice -->
        <div id="gps-status-notice" class="hidden bg-amber-500/10 border border-amber-500/20 rounded-xl p-4 text-amber-300 text-xs flex items-center justify-between">
            <span id="gps-notice-text" class="flex items-center gap-2 font-medium">
                <i class="bi bi-geo-alt-fill text-amber-400 text-sm"></i> Mengambil koordinat GPS lokasi Anda...
            </span>
            <button onclick="document.getElementById('gps-status-notice').classList.add('hidden')" class="text-amber-400 font-bold p-1"><i class="bi bi-x-lg"></i></button>
        </div>

        <!-- Main GIS Map & Side Panel Layout (Gap 24px) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Map & AI Recommendation Column -->
            <div class="lg:col-span-2 space-y-4">
                
                <!-- Map Container Card -->
                <div class="bg-[#0A241B] p-2 rounded-[20px] border border-white/10 shadow-lg relative overflow-hidden" x-data="{ legendOpen: false }">
                    
                    <!-- Leaflet Map -->
                    <div id="sebaran-full-map" class="rounded-[16px] overflow-hidden"></div>

                    <!-- Floating Expandable GIS Legend Card (Top Left - Collapsed by Default) -->
                    <div class="absolute top-4 left-4 z-[400]">
                        <!-- Collapsed Toggle Button -->
                        <button @click="legendOpen = !legendOpen" 
                                x-show="!legendOpen"
                                class="px-3.5 py-2 bg-[#04160F]/90 backdrop-blur-md text-white font-bold text-xs rounded-xl border border-white/20 shadow-xl flex items-center gap-2 hover:bg-[#0A241B] transition-all">
                            <i class="bi bi-layers-half text-[#2DD67B]"></i>
                            <span>Legenda GIS</span>
                            <i class="bi bi-chevron-down text-[10px] text-[#B7C7C1]"></i>
                        </button>

                        <!-- Expanded Floating Card (Max height 220px, scrollable, max 30% area) -->
                        <div x-show="legendOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="bg-[#04160F]/95 backdrop-blur-md p-4 rounded-[16px] border border-white/15 shadow-2xl w-[260px] max-h-[220px] overflow-y-auto custom-scrollbar text-xs text-[#B7C7C1] space-y-3"
                             x-cloak>
                            
                            <div class="flex items-center justify-between border-b border-white/10 pb-2">
                                <span class="font-bold text-white text-xs flex items-center gap-1.5">
                                    <i class="bi bi-layers-fill text-[#2DD67B]"></i> Legenda GIS
                                </span>
                                <button @click="legendOpen = false" class="text-[#B7C7C1] hover:text-white p-1">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>

                            <div class="space-y-2.5">
                                <div class="flex items-center gap-2.5 text-[11px]"><i class="bi bi-geo-alt-fill text-blue-400 text-sm"></i> <span>Lokasi Saya (GPS)</span></div>
                                <div class="flex items-center gap-2.5 text-[11px]"><i class="bi bi-building-fill text-[#2DD67B] text-sm"></i> <span>Bank Sampah Aktif</span></div>
                                <div class="flex items-center gap-2.5 text-[11px]"><i class="bi bi-building-fill text-amber-400 text-sm"></i> <span>Bank Sampah Libur</span></div>
                                <div class="flex items-center gap-2.5 text-[11px]"><i class="bi bi-building-fill text-rose-400 text-sm"></i> <span>Bank Sampah Nonaktif</span></div>
                                <div class="flex items-center gap-2.5 text-[11px]"><i class="bi bi-record-circle text-[#2DD67B] text-sm"></i> <span>Area Layanan (Radius 2 Km)</span></div>
                                <div class="flex items-center gap-2.5 text-[11px]"><i class="bi bi-dash-lg text-blue-400 font-bold text-base"></i> <span>Garis Rute Jarak (Polyline)</span></div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 4. Recommendation Card (Redesigned Spec Total) -->
                <div id="ai-recommendation-card" class="bg-[#0A241B] p-5 rounded-[20px] border border-white/10 shadow-lg max-h-[240px] flex flex-col justify-between overflow-y-auto custom-scrollbar space-y-3">
                    
                    <!-- Header -->
                    <div class="flex items-center justify-between border-b border-white/10 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="text-[#2DD67B] text-base font-bold">✨</span>
                            <h3 class="text-base font-bold text-white tracking-tight">Rekomendasi AI</h3>
                        </div>
                        <!-- Small Chip Badge -->
                        <span id="ai-chip-badge" class="px-2.5 py-0.5 bg-[#2DD67B]/20 text-[#2DD67B] border border-[#2DD67B]/30 rounded-full font-bold text-[10px] tracking-wider uppercase">
                            Optimal
                        </span>
                    </div>

                    <!-- Body Highlights (Bullet Points) -->
                    <div class="space-y-2 text-xs">
                        <div class="font-bold text-white text-sm flex items-center gap-1.5">
                            <span>📍</span> <span id="rec-bank-name">Bank Sampah Tampingan Asri</span>
                        </div>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 py-1 text-[11px] text-[#B7C7C1]">
                            <div class="bg-[#04160F] p-2 rounded-xl border border-white/5">
                                <span class="text-white/50 block text-[10px]">• Jarak</span>
                                <strong id="rec-dist" class="text-white font-bold">0.2 Km</strong>
                            </div>
                            <div class="bg-[#04160F] p-2 rounded-xl border border-white/5">
                                <span class="text-white/50 block text-[10px]">• Waktu</span>
                                <strong id="rec-time" class="text-white font-bold">1 menit</strong>
                            </div>
                            <div class="bg-[#04160F] p-2 rounded-xl border border-white/5">
                                <span class="text-white/50 block text-[10px]">• Harga PET</span>
                                <strong id="rec-price" class="text-[#2DD67B] font-bold">Rp4.700/Kg</strong>
                            </div>
                            <div class="bg-[#04160F] p-2 rounded-xl border border-white/5">
                                <span class="text-white/50 block text-[10px]">• Radius</span>
                                <strong id="rec-radius" class="text-white font-bold">2 Km</strong>
                            </div>
                        </div>

                        <!-- AI Text summary -->
                        <p id="ai-rec-text" class="text-xs text-[#B7C7C1] italic leading-relaxed">
                            "Lokasi ini merupakan pilihan terbaik berdasarkan jarak, harga, dan status operasional."
                        </p>
                    </div>

                    <!-- Action Buttons (Min height 44px for Accessibility) -->
                    <div class="grid grid-cols-3 gap-2.5 pt-2 border-t border-white/10">
                        <a id="btn-rec-detail" href="#" class="min-h-[44px] px-3 py-2.5 bg-[#04160F] hover:bg-white/5 text-[#B7C7C1] hover:text-white font-bold rounded-xl text-xs border border-white/10 transition-all flex items-center justify-center gap-1.5 text-center">
                            <i class="bi bi-info-circle"></i> Lihat Detail
                        </a>
                        <a id="btn-rec-nav" href="#" target="_blank" class="min-h-[44px] px-3 py-2.5 bg-[#04160F] hover:bg-white/5 text-[#2DD67B] font-bold rounded-xl text-xs border border-[#2DD67B]/30 transition-all flex items-center justify-center gap-1.5 text-center">
                            <i class="bi bi-compass-fill"></i> Navigasi
                        </a>
                        <button id="btn-rec-select" class="min-h-[44px] px-3 py-2.5 bg-[#2DD67B] hover:bg-[#22C55E] text-[#04160F] font-bold rounded-xl text-xs transition-all shadow-md flex items-center justify-center gap-1.5 text-center">
                            <i class="bi bi-check-circle-fill"></i> Pilih Bank
                        </button>
                    </div>
                </div>

            </div>

            <!-- Side Panel: Bank Sampah Terdekat Ranking -->
            <div class="space-y-4">
                <div class="bg-[#0A241B] p-5 rounded-[20px] border border-white/10 shadow-lg space-y-4">
                    <div class="flex items-center justify-between border-b border-white/10 pb-3">
                        <h3 class="font-bold text-white text-xs uppercase tracking-wider flex items-center gap-2">
                            <i class="bi bi-trophy-fill text-amber-400 text-sm"></i> Bank Sampah Terdekat
                        </h3>
                        <span id="user-gps-badge" class="px-2.5 py-1 bg-blue-500/10 text-blue-400 text-[10px] font-bold rounded-full border border-blue-500/20 flex items-center gap-1">
                            <i class="bi bi-crosshair"></i> GPS Aktif
                        </span>
                    </div>

                    <!-- Ranked List Container -->
                    <div id="nearest-ranking-list" class="space-y-3 max-h-[500px] overflow-y-auto custom-scrollbar pr-1">
                        <p class="text-center text-[#B7C7C1] text-xs py-8">Memuat urutan jarak Bank Sampah...</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let userLat = -6.2088;
            let userLng = 106.8456;
            let userGpsActive = false;
            let activePolyline = null;

            const map = L.map('sebaran-full-map').setView([userLat, userLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap & SiSampah GIS Platform'
            }).addTo(map);

            const bankData = @json($bankSampahs);
            const markers = [];
            const circles = [];
            let userMarker = null;

            // Haversine Distance Helper
            function calculateDistance(lat1, lon1, lat2, lon2) {
                const R = 6371;
                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLon = (lon2 - lon1) * Math.PI / 180;
                const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                          Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                          Math.sin(dLon / 2) * Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c;
            }

            // Render Map Elements
            function renderGisElements() {
                markers.forEach(m => map.removeLayer(m.marker));
                circles.forEach(c => map.removeLayer(c));
                markers.length = 0;
                circles.length = 0;

                const bounds = [];
                if (userGpsActive) bounds.push([userLat, userLng]);

                // Sort bank data by distance from current user GPS
                const processed = bankData.map(bs => {
                    const dist = calculateDistance(userLat, userLng, parseFloat(bs.latitude), parseFloat(bs.longitude));
                    bs.dist_km = dist;
                    bs.drive_min = Math.ceil(dist * 3); // ~20 km/h
                    bs.walk_min = Math.ceil(dist * 12); // ~5 km/h
                    bs.radius_m = Math.min(bs.radius_layanan || 2000, 2000);
                    bs.is_in_radius = dist <= (bs.radius_m / 1000);
                    return bs;
                }).sort((a, b) => a.dist_km - b.dist_km);

                processed.forEach((bs, idx) => {
                    const lat = parseFloat(bs.latitude);
                    const lng = parseFloat(bs.longitude);
                    if (!lat || !lng) return;

                    bounds.push([lat, lng]);

                    let markerColor = '#2DD67B'; // Green
                    let statusLabel = '<i class="bi bi-check-circle-fill text-[#2DD67B]"></i> Aktif';
                    if (bs.status === 'libur') { markerColor = '#f59e0b'; statusLabel = '<i class="bi bi-pause-circle-fill text-amber-400"></i> Sedang Libur'; }
                    else if (bs.status === 'nonaktif') { markerColor = '#ef4444'; statusLabel = '<i class="bi bi-x-circle-fill text-rose-400"></i> Nonaktif'; }

                    // Circle Overlay for Service Radius (Max 2 Km)
                    const circle = L.circle([lat, lng], {
                        radius: bs.radius_m,
                        color: markerColor,
                        fillColor: markerColor,
                        fillOpacity: 0.15,
                        weight: 2
                    }).addTo(map);
                    circles.push(circle);

                    // Marker Icon with Bootstrap Icon bi-building
                    const customIcon = L.divIcon({
                        className: 'sebaran-marker',
                        html: `<div style="background:${markerColor};width:38px;height:38px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid #04160F;box-shadow:0 6px 16px rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;"><i class="bi bi-building text-[#04160F] text-base font-bold" style="transform:rotate(45deg);"></i></div>`,
                        iconSize: [38, 38],
                        iconAnchor: [19, 38]
                    });

                    // Rich Popup Content
                    const popupContent = `
                        <div class="space-y-2 text-xs font-sans text-white">
                            <div class="flex items-center gap-2.5 pb-2 border-b border-white/10">
                                <img src="${bs.logo_url}" class="w-9 h-9 rounded-xl object-cover border border-white/10" alt="Logo">
                                <div class="leading-tight">
                                    <h4 class="font-bold text-white text-xs">${bs.nama}</h4>
                                    <span class="text-[10px] text-[#B7C7C1] flex items-center gap-1 mt-0.5">${statusLabel}</span>
                                </div>
                            </div>
                            <p class="text-[#B7C7C1] leading-snug"><i class="bi bi-geo-alt-fill text-[#2DD67B]"></i> ${bs.alamat}</p>
                            
                            <div class="bg-[#04160F] p-2.5 rounded-xl border border-white/10 space-y-1 text-[11px] text-[#B7C7C1] font-medium">
                                <div class="flex justify-between"><span><i class="bi bi-pin-map text-[#2DD67B]"></i> Jarak:</span> <strong class="text-white">${bs.dist_km.toFixed(1)} Km</strong></div>
                                <div class="flex justify-between"><span><i class="bi bi-car-front-fill text-[#2DD67B]"></i> Kendaraan:</span> <strong class="text-white">~${bs.drive_min} Menit</strong></div>
                                <div class="flex justify-between"><span><i class="bi bi-bullseye text-[#2DD67B]"></i> Radius:</span> <strong class="text-white">${(bs.radius_m / 1000)} Km (${bs.is_in_radius ? '<span class="text-[#2DD67B]">Terjangkau</span>' : '<span class="text-amber-400">Luar Radius</span>'})</strong></div>
                            </div>

                            <div class="flex gap-2 pt-1">
                                <a href="/admin/master-bank-sampah/${bs.id}" class="flex-1 min-h-[38px] bg-[#04160F] hover:bg-white/10 text-white font-bold rounded-xl text-[11px] text-center transition-colors flex items-center justify-center gap-1 border border-white/10">
                                    <i class="bi bi-info-circle"></i> Detail
                                </a>
                                <a href="https://www.google.com/maps/dir/?api=1&destination=${bs.latitude},${bs.longitude}" target="_blank" class="flex-1 min-h-[38px] bg-[#2DD67B] hover:bg-[#22C55E] text-[#04160F] font-bold rounded-xl text-[11px] text-center transition-colors shadow-xs flex items-center justify-center gap-1">
                                    <i class="bi bi-compass-fill"></i> Navigasi
                                </a>
                            </div>
                        </div>
                    `;

                    const m = L.marker([lat, lng], { icon: customIcon }).addTo(map).bindPopup(popupContent);
                    
                    m.on('click', function() {
                        drawRouteLine(lat, lng);
                    });

                    markers.push({ id: bs.id, marker: m, data: bs });
                });

                if (bounds.length > 0) {
                    map.fitBounds(bounds, { padding: [50, 50] });
                }

                updateRankingPanel(processed);
                if (processed.length > 0) {
                    updateAiRecommendation(processed[0]);
                }
            }

            // Draw Animated Polyline
            function drawRouteLine(destLat, destLng) {
                if (activePolyline) map.removeLayer(activePolyline);
                activePolyline = L.polyline([
                    [userLat, userLng],
                    [destLat, destLng]
                ], {
                    color: '#2DD67B',
                    weight: 4,
                    opacity: 0.85,
                    className: 'animated-polyline'
                }).addTo(map);
            }

            // Render Side Panel Ranking
            function updateRankingPanel(sortedList) {
                const container = document.getElementById('nearest-ranking-list');
                container.innerHTML = '';

                if (sortedList.length === 0) {
                    container.innerHTML = '<p class="text-center text-[#B7C7C1] text-xs py-8">Tidak ada Bank Sampah ditemukan.</p>';
                    return;
                }

                sortedList.forEach((bs, idx) => {
                    const medal = idx === 0 ? '<i class="bi bi-award-fill text-amber-400 text-lg"></i>' : (idx === 1 ? '<i class="bi bi-award-fill text-slate-400 text-lg"></i>' : (idx === 2 ? '<i class="bi bi-award-fill text-amber-700 text-lg"></i>' : `<span class="text-xs font-bold text-[#B7C7C1]">#${idx+1}</span>`));
                    const card = document.createElement('div');
                    card.className = `p-4 rounded-[16px] border transition-all cursor-pointer hover:border-[#2DD67B] hover:shadow-md ${idx === 0 ? 'bg-[#04160F] border-[#2DD67B]/40' : 'bg-[#04160F] border-white/10'}`;
                    card.innerHTML = `
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-6 flex items-center justify-center">${medal}</div>
                                <div>
                                    <h4 class="font-bold text-white text-xs">${bs.nama}</h4>
                                    <span class="text-[10px] text-[#B7C7C1] block mt-0.5">${bs.kecamatan || bs.kabupaten || ''}</span>
                                </div>
                            </div>
                            <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full ${bs.status === 'aktif' ? 'bg-[#2DD67B]/20 text-[#2DD67B] border border-[#2DD67B]/30' : 'bg-amber-400/20 text-amber-400 border border-amber-400/30'}">
                                ${bs.status}
                            </span>
                        </div>
                        <div class="grid grid-cols-3 gap-1 mt-3 text-[10px] pt-2.5 border-t border-white/10 text-[#B7C7C1] font-medium">
                            <div>Jarak: <strong class="text-white font-bold">${bs.dist_km.toFixed(1)} km</strong></div>
                            <div><i class="bi bi-car-front-fill text-[#2DD67B]"></i> ~${bs.drive_min}m</div>
                            <div><i class="bi bi-person-walking text-[#2DD67B]"></i> ~${bs.walk_min}m</div>
                        </div>
                    `;

                    card.addEventListener('click', () => {
                        const mObj = markers.find(m => m.id === bs.id);
                        if (mObj) {
                            map.setView([parseFloat(bs.latitude), parseFloat(bs.longitude)], 15);
                            mObj.marker.openPopup();
                            drawRouteLine(parseFloat(bs.latitude), parseFloat(bs.longitude));
                            updateAiRecommendation(bs);
                        }
                    });

                    container.appendChild(card);
                });
            }

            // Update AI Recommendation Card
            function updateAiRecommendation(bestBank) {
                if (!bestBank) return;
                document.getElementById('rec-bank-name').textContent = bestBank.nama;
                document.getElementById('rec-dist').textContent = bestBank.dist_km.toFixed(1) + ' Km';
                document.getElementById('rec-time').textContent = bestBank.drive_min + ' menit';
                document.getElementById('rec-price').textContent = 'Rp4.700/Kg';
                document.getElementById('rec-radius').textContent = (bestBank.radius_m / 1000) + ' Km';
                
                document.getElementById('ai-rec-text').textContent = `"Bank Sampah ${bestBank.nama} merupakan pilihan terbaik berdasarkan jarak ${bestBank.dist_km.toFixed(1)} km (~${bestBank.drive_min}m), status operasional aktif, dan harga daur ulang optimal."`;
                
                document.getElementById('btn-rec-detail').href = `/admin/master-bank-sampah/${bestBank.id}`;
                document.getElementById('btn-rec-nav').href = `https://www.google.com/maps/dir/?api=1&destination=${bestBank.latitude},${bestBank.longitude}`;
                
                document.getElementById('btn-rec-select').onclick = function() {
                    const mObj = markers.find(m => m.id === bestBank.id);
                    if (mObj) {
                        map.setView([parseFloat(bestBank.latitude), parseFloat(bestBank.longitude)], 16);
                        mObj.marker.openPopup();
                        drawRouteLine(parseFloat(bestBank.latitude), parseFloat(bestBank.longitude));
                    }
                };
            }

            // Geolocation API User GPS Marker
            function initUserGps() {
                if (navigator.geolocation) {
                    const notice = document.getElementById('gps-status-notice');
                    notice.classList.remove('hidden');

                    navigator.geolocation.getCurrentPosition(pos => {
                        userLat = pos.coords.latitude;
                        userLng = pos.coords.longitude;
                        userGpsActive = true;

                        if (userMarker) map.removeLayer(userMarker);

                        const gpsIcon = L.divIcon({
                            className: 'user-gps-wrapper',
                            html: '<div class="user-gps-marker"></div>',
                            iconSize: [22, 22],
                            iconAnchor: [11, 11]
                        });

                        userMarker = L.marker([userLat, userLng], { icon: gpsIcon }).addTo(map).bindPopup('<b class="text-xs text-white"><i class="bi bi-geo-alt-fill text-[#2DD67B]"></i> Lokasi Saya (GPS)</b>');

                        document.getElementById('gps-notice-text').innerHTML = `<i class="bi bi-check-circle-fill text-[#2DD67B]"></i> GPS Berhasil Dideteksi! Koordinat: ${userLat.toFixed(4)}, ${userLng.toFixed(4)}`;
                        setTimeout(() => notice.classList.add('hidden'), 4000);

                        renderGisElements();
                    }, err => {
                        document.getElementById('gps-notice-text').innerHTML = '<i class="bi bi-exclamation-triangle-fill text-amber-400"></i> GPS tidak aktif. Menggunakan lokasi default.';
                        renderGisElements();
                    });
                }
            }

            document.getElementById('btn-request-gps').addEventListener('click', initUserGps);

            // Initial Execution
            initUserGps();
            setTimeout(() => map.invalidateSize(), 300);
        });
    </script>
    @endpush
</div>
@endsection
