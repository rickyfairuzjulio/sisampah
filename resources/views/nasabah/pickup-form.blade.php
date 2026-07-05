<x-app-layout title="Jadwalkan Penjemputan">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        #pickup-map { height: 280px; width: 100%; border-radius: 1rem; z-index: 0; }
        @media (min-width: 640px) { #pickup-map { height: 360px; } }
    </style>
    @endpush

    <div class="space-y-6 pb-8 max-w-3xl mx-auto px-4 sm:px-0">
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

            <form action="{{ route('nasabah.pickup.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-4">
                    <h3 class="font-semibold text-on-surface flex items-center gap-2">
                        <span class="w-7 h-7 rounded-full bg-primary/10 text-primary text-sm font-bold flex items-center justify-center">1</span>
                        Kategori Sampah
                    </h3>
                    <x-select-field
                        label="Kategori Sampah"
                        name="trash_category_id"
                        required
                        :items="$trashCategories->map(fn($k) => [
                            'value' => $k->id,
                            'label' => $k->nama . ' (Rp ' . number_format($k->harga_per_kg, 0, ',', '.') . '/Kg)'
                        ])->toArray()"
                        :error="$errors->has('trash_category_id') ? $errors->first('trash_category_id') : false"
                    />
                </div>

                <div class="space-y-4">
                    <h3 class="font-semibold text-on-surface flex items-center gap-2">
                        <span class="w-7 h-7 rounded-full bg-primary/10 text-primary text-sm font-bold flex items-center justify-center">2</span>
                        Estimasi Berat
                    </h3>
                    <x-input-field
                        label="Perkiraan Berat (Kg)"
                        name="perkiraan_berat"
                        type="number"
                        placeholder="Minimal 5 Kg"
                        step="0.5"
                        min="5"
                        required
                        :value="old('perkiraan_berat')"
                        :error="$errors->has('perkiraan_berat') ? $errors->first('perkiraan_berat') : false"
                    />
                </div>

                <div class="space-y-4">
                    <h3 class="font-semibold text-on-surface flex items-center gap-2">
                        <span class="w-7 h-7 rounded-full bg-primary/10 text-primary text-sm font-bold flex items-center justify-center">3</span>
                        Lokasi Penjemputan
                    </h3>

                    <div id="pickup-map" class="border border-outline-variant shadow-sm"></div>

                    <p class="text-xs text-on-surface-variant">Klik peta untuk menandai lokasi, atau geser penanda. Gunakan tombol GPS untuk deteksi otomatis.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-input-field
                            label="Latitude"
                            name="koordinat_lat"
                            id="koordinat_lat"
                            type="number"
                            placeholder="-6.208800"
                            step="0.000001"
                            required
                            :value="old('koordinat_lat')"
                            :error="$errors->has('koordinat_lat') ? $errors->first('koordinat_lat') : false"
                        />
                        <x-input-field
                            label="Longitude"
                            name="koordinat_lng"
                            id="koordinat_lng"
                            type="number"
                            placeholder="106.845600"
                            step="0.000001"
                            required
                            :value="old('koordinat_lng')"
                            :error="$errors->has('koordinat_lng') ? $errors->first('koordinat_lng') : false"
                        />
                    </div>

                    <button type="button" id="btn-gps" class="w-full sm:w-auto py-3 px-6 bg-surface-container-high hover:bg-surface-container text-on-surface font-semibold rounded-xl transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Deteksi GPS Saya
                    </button>
                </div>

                <div class="space-y-4">
                    <h3 class="font-semibold text-on-surface flex items-center gap-2">
                        <span class="w-7 h-7 rounded-full bg-primary/10 text-primary text-sm font-bold flex items-center justify-center">4</span>
                        Catatan (Opsional)
                    </h3>
                    <textarea id="catatan" name="catatan" rows="3"
                              class="w-full px-4 py-3 rounded-xl border border-outline-variant bg-surface-container-lowest focus:outline-none focus:ring-2 focus:ring-primary resize-none text-sm"
                              placeholder="Contoh: Sampah sudah dikemas di depan rumah">{{ old('catatan') }}</textarea>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-outline-variant">
                    <a href="{{ route('nasabah.dashboard') }}" class="flex-1 py-3 px-6 text-center border border-outline-variant text-on-surface font-semibold rounded-xl hover:bg-surface-container-low transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 py-3 px-6 bg-primary hover:bg-primary-container text-white font-bold rounded-xl transition-colors">
                        Jadwalkan Penjemputan
                    </button>
                </div>
            </form>
        </x-card>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
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
