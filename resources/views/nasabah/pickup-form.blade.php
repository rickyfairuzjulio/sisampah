<x-app-layout title="Jadwalkan Penjemputan">
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        #pickup-map { height: 280px; width: 100%; border-radius: 1rem; z-index: 0; }
        @media (min-width: 640px) { #pickup-map { height: 360px; } }
    </style>
    @endpush

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <x-role-nav role="nasabah" />
    </div>

    <div class="space-y-6 pb-8 max-w-3xl mx-auto px-4 sm:px-0 mt-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('nasabah.dashboard') }}" class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-on-surface">Jadwalkan Penjemputan</h1>
                <p class="text-sm text-on-surface-variant">Minimal 5 Kg · Tentukan lokasi di peta</p>
            </div>
        </div>

        <x-card>
            @if ($errors->any())
                <x-alert type="error" title="Ada Kesalahan" class="mb-6">
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <form action="{{ route('nasabah.pickup.store') }}" method="POST">
                @csrf

                <div class="relative ml-3.5 space-y-10 mt-4">
                    <!-- Stepper Line -->
                    <div class="absolute left-0 top-2 bottom-6 w-0.5 bg-outline-variant/30"></div>
                    
                    <div x-data="pickupForm()">
                        <!-- Step 1: Detail Sampah -->
                        <div class="relative pl-8 mb-10">
                            <div class="absolute -left-[17px] top-0 w-8 h-8 rounded-full bg-primary text-white text-sm font-bold flex items-center justify-center shadow-md border-4 border-surface">1</div>
                            <h3 class="font-bold text-lg text-on-surface mb-4">Daftar Sampah</h3>
                            <div class="bg-surface-container-lowest p-5 sm:p-6 rounded-2xl border border-outline-variant shadow-sm transition-all">
                                <p class="text-sm text-on-surface-variant mb-4">Tambahkan jenis sampah yang akan dijemput beserta estimasi beratnya (Minimal total 5 Kg).</p>
                                
                                <!-- Items List -->
                                <div class="space-y-4">
                                    <template x-for="(item, index) in items" :key="item.id">
                                        <div class="flex flex-col sm:flex-row gap-4 p-4 border border-outline-variant rounded-xl bg-surface relative group">
                                            <!-- Kategori -->
                                            <div class="flex-1">
                                                <label class="block text-sm font-medium text-on-surface mb-1">Kategori Sampah <span class="text-error">*</span></label>
                                                <select x-model="item.trash_category_id" :name="'items['+index+'][trash_category_id]'" required class="w-full px-4 py-3 rounded-xl border border-outline-variant bg-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary text-sm appearance-none transition-shadow shadow-sm hover:border-primary/50">
                                                    <option value="" disabled selected>Pilih Kategori</option>
                                                    @foreach($trashCategories as $k)
                                                        <option value="{{ $k->id }}">{{ $k->nama }} (Rp {{ number_format($k->harga_per_kg, 0, ',', '.') }}/Kg)</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <!-- Berat -->
                                            <div class="sm:w-40">
                                                <label class="block text-sm font-medium text-on-surface mb-1">Berat (Kg) <span class="text-error">*</span></label>
                                                <input type="number" x-model="item.perkiraan_berat" :name="'items['+index+'][perkiraan_berat]'" required min="0.1" step="0.1" placeholder="Contoh: 5.5" class="w-full px-4 py-3 rounded-xl border border-outline-variant bg-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-shadow shadow-sm hover:border-primary/50">
                                            </div>
                                            
                                            <!-- Hapus Button -->
                                            <div class="flex sm:self-end sm:mb-0.5">
                                                <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="w-full sm:w-12 h-[3.25rem] bg-error/10 text-error hover:bg-error hover:text-white rounded-xl flex items-center justify-center transition-colors shadow-sm mt-2 sm:mt-0" title="Hapus Sampah">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    <span class="sm:hidden ml-2 font-medium">Hapus</span>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Tambah Button -->
                                <button type="button" @click="addItem()" class="mt-4 py-2 px-4 border-2 border-dashed border-primary text-primary hover:bg-primary/5 font-bold rounded-xl transition-colors flex items-center justify-center gap-2 w-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Tambah Jenis Sampah Lain
                                </button>
                                
                                <div class="bg-amber-50 text-amber-800 p-3 rounded-xl border border-amber-200 text-xs mt-4">
                                    <strong class="block mb-1 text-sm">⚠️ Info Penting</strong>
                                    Total keseluruhan minimal penjemputan adalah <strong>5 Kg</strong>. Berat pasti akan ditimbang ulang oleh petugas di lokasi.
                                </div>
                            </div>
                        </div>

                    <!-- Step 3 -->
                    <div class="relative pl-8">
                        <div class="absolute -left-[17px] top-0 w-8 h-8 rounded-full bg-primary text-white text-sm font-bold flex items-center justify-center shadow-md border-4 border-surface">3</div>
                        <h3 class="font-bold text-lg text-on-surface mb-4">Lokasi Penjemputan</h3>
                        <div class="bg-surface-container-lowest p-5 sm:p-6 rounded-2xl border border-outline-variant shadow-sm transition-all hover:shadow-md">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
                                <p class="text-sm text-on-surface-variant flex-1">Geser penanda merah pada peta ke lokasi rumah Anda secara akurat.</p>
                                <button type="button" id="btn-gps" class="w-full sm:w-auto py-2.5 px-4 bg-primary/10 hover:bg-primary/20 text-primary font-bold rounded-xl transition-colors flex items-center justify-center gap-2 text-sm border border-primary/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Gunakan GPS
                                </button>
                            </div>

                            <div id="pickup-map" class="border border-outline-variant shadow-sm mb-4"></div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 hidden">
                                <x-input-field label="Latitude" name="koordinat_lat" id="koordinat_lat" type="number" step="0.000001" required :value="old('koordinat_lat')" />
                                <x-input-field label="Longitude" name="koordinat_lng" id="koordinat_lng" type="number" step="0.000001" required :value="old('koordinat_lng')" />
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-outline-variant">
                                <label for="catatan" class="block text-sm font-semibold text-on-surface mb-2">Catatan Detail Lokasi (Opsional)</label>
                                <textarea id="catatan" name="catatan" rows="2"
                                        class="w-full px-4 py-3 rounded-xl border border-outline-variant bg-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary resize-none text-sm transition-shadow shadow-sm hover:border-primary/50"
                                        placeholder="Contoh: Rumah cat biru pagar hitam, masuk gang sebelah masjid">{{ old('catatan') }}</textarea>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-outline-variant mt-2">
                    <a href="{{ route('nasabah.dashboard') }}" class="flex-1 py-3 px-6 text-center border border-outline-variant text-on-surface font-semibold rounded-xl hover:bg-surface-container-low transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 py-3 px-6 bg-gradient-to-r from-primary to-forest-emerald hover:from-primary-container hover:to-primary text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                        Konfirmasi Penjemputan
                    </button>
                </div>
            </form>
        </x-card>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('pickupForm', () => ({
                items: [],
                init() {
                    const savedBasket = window.sessionStorage.getItem('sisampah_pickup_basket');
                    if (savedBasket) {
                        try {
                            const parsed = JSON.parse(savedBasket);
                            if (Array.isArray(parsed) && parsed.length > 0) {
                                this.items = parsed.map(item => ({
                                    id: Date.now() + Math.random(),
                                    trash_category_id: item.trash_category_id || item.category_id || '',
                                    perkiraan_berat: item.perkiraan_berat || item.estimasi_berat_kg || 1.0
                                }));
                                window.sessionStorage.removeItem('sisampah_pickup_basket');
                                return;
                            }
                        } catch(e) { console.error('Error loading basket:', e); }
                    }
                    this.items = [{ id: Date.now(), trash_category_id: '', perkiraan_berat: '' }];
                },
                addItem() {
                    this.items.push({ id: Date.now(), trash_category_id: '', perkiraan_berat: '' });
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                }
            }));
        });
        
        document.addEventListener('DOMContentLoaded', function () {
            const defaultLat = parseFloat(document.getElementById('koordinat_lat').value) || -6.2088;
            const defaultLng = parseFloat(document.getElementById('koordinat_lng').value) || 106.8456;

            const map = L.map('pickup-map').setView([defaultLat, defaultLng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            const markerIcon = L.divIcon({
                className: 'pickup-marker',
                html: '<div style="background:#00694c;width:32px;height:32px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid white;box-shadow:0 4px 12px rgba(0,0,0,.3);"></div>',
                iconSize: [32, 32],
                iconAnchor: [16, 32]
            });

            let marker = L.marker([defaultLat, defaultLng], { draggable: true, icon: markerIcon }).addTo(map);

            function setCoords(lat, lng) {
                document.getElementById('koordinat_lat').value = lat.toFixed(6);
                document.getElementById('koordinat_lng').value = lng.toFixed(6);
            }

            function moveMarker(lat, lng) {
                marker.setLatLng([lat, lng]);
                map.panTo([lat, lng]);
                setCoords(lat, lng);
            }

            map.on('click', function (e) {
                moveMarker(e.latlng.lat, e.latlng.lng);
            });

            marker.on('dragend', function () {
                const pos = marker.getLatLng();
                setCoords(pos.lat, pos.lng);
            });

            document.getElementById('koordinat_lat').addEventListener('change', syncFromInputs);
            document.getElementById('koordinat_lng').addEventListener('change', syncFromInputs);

            function syncFromInputs() {
                const lat = parseFloat(document.getElementById('koordinat_lat').value);
                const lng = parseFloat(document.getElementById('koordinat_lng').value);
                if (!isNaN(lat) && !isNaN(lng)) {
                    marker.setLatLng([lat, lng]);
                    map.panTo([lat, lng]);
                }
            }

            document.getElementById('btn-gps').addEventListener('click', function () {
                const btn = this;
                if (!navigator.geolocation) {
                    alert('Browser Anda tidak mendukung GPS.');
                    return;
                }
                btn.disabled = true;
                btn.textContent = 'Mendeteksi lokasi...';

                navigator.geolocation.getCurrentPosition(
                    function (pos) {
                        moveMarker(pos.coords.latitude, pos.coords.longitude);
                        map.setZoom(17);
                        btn.disabled = false;
                        btn.innerHTML = '<svg class="w-5 h-5 text-primary inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Deteksi GPS Saya';
                    },
                    function () {
                        alert('Gagal mendeteksi lokasi. Izinkan akses GPS atau pilih manual di peta.');
                        btn.disabled = false;
                        btn.innerHTML = '<svg class="w-5 h-5 text-primary inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Deteksi GPS Saya';
                    },
                    { enableHighAccuracy: true, timeout: 10000 }
                );
            });

            setTimeout(() => map.invalidateSize(), 300);
        });
    </script>
    @endpush
</x-app-layout>
