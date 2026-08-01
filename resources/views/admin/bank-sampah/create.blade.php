<x-app-layout title="Tambah Bank Sampah - SiSampah Admin">
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <style>
        #bank-map { height: 380px; width: 100%; border-radius: 1rem; z-index: 0; }
        .leaflet-popup-content-wrapper { border-radius: 1rem; }
    </style>
    @endpush

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <x-role-nav role="admin" />
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.master_bank_sampah.index') }}" class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition-colors">
                ←
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-on-surface">Tambah Bank Sampah Baru</h1>
                <p class="text-sm text-on-surface-variant">Tentukan unit operasional baru dan tentukan lokasinya di Peta Interaktif</p>
            </div>
        </div>

        <form action="{{ route('admin.master_bank_sampah.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Form Card 1: Informast Utama & Kontak -->
            <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant shadow-sm space-y-4">
                <h3 class="font-extrabold text-lg text-slate-900 border-b pb-2 flex items-center gap-2">
                    <span>🏬</span> Informasi Umum & Operasional
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Bank Sampah <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama" required value="{{ old('nama') }}" placeholder="Contoh: Bank Sampah Melati Bersih Unit 01" class="w-full px-4 py-2.5 rounded-xl border border-outline-variant text-sm focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Telepon / HP</label>
                        <input type="text" name="telepon" value="{{ old('telepon') }}" placeholder="081234567890" class="w-full px-4 py-2.5 rounded-xl border border-outline-variant text-sm focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="6281234567890" class="w-full px-4 py-2.5 rounded-xl border border-outline-variant text-sm focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email Unit</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="banksampah.melati@sisampah.id" class="w-full px-4 py-2.5 rounded-xl border border-outline-variant text-sm focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status Unit <span class="text-rose-500">*</span></label>
                        <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-outline-variant text-sm focus:ring-2 focus:ring-primary">
                            <option value="aktif" selected>🟢 Aktif Operasional</option>
                            <option value="libur">🟡 Sedang Libur</option>
                            <option value="nonaktif">🔴 Nonaktif</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Hari Operasional</label>
                        <input type="text" name="hari_operasional" value="{{ old('hari_operasional', 'Senin - Sabtu') }}" placeholder="Senin - Sabtu" class="w-full px-4 py-2.5 rounded-xl border border-outline-variant text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Radius Layanan (Coverage Maks. 2 Km) <span class="text-rose-500">*</span></label>
                        <select name="radius_layanan" required class="w-full px-4 py-2.5 rounded-xl border border-outline-variant text-sm focus:ring-2 focus:ring-primary">
                            <option value="500" {{ old('radius_layanan') == '500' ? 'selected' : '' }}>500 Meter (0.5 Km)</option>
                            <option value="1000" {{ old('radius_layanan') == '1000' ? 'selected' : '' }}>1.000 Meter (1 Km)</option>
                            <option value="1500" {{ old('radius_layanan') == '1500' ? 'selected' : '' }}>1.500 Meter (1.5 Km)</option>
                            <option value="2000" {{ old('radius_layanan', '2000') == '2000' ? 'selected' : '' }}>2.000 Meter (2 Km) - Maksimal</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Jam Buka</label>
                            <input type="time" name="jam_buka" value="{{ old('jam_buka', '08:00') }}" class="w-full px-3 py-2.5 rounded-xl border border-outline-variant text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Jam Tutup</label>
                            <input type="time" name="jam_tutup" value="{{ old('jam_tutup', '16:00') }}" class="w-full px-3 py-2.5 rounded-xl border border-outline-variant text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Logo Unit (Opsional)</label>
                        <input type="file" name="logo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Foto Gedung/Lokasi (Opsional)</label>
                        <input type="file" name="foto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas</label>
                        <textarea name="deskripsi" rows="2" placeholder="Catatan operasional atau deskripsi singkat..." class="w-full px-4 py-2.5 rounded-xl border border-outline-variant text-sm">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Form Card 2: Interactive Map & Geocoding -->
            <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b pb-2">
                    <h3 class="font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <span>🗺️</span> Penentuan Lokasi Peta (Google Maps / OpenStreetMap)
                    </h3>
                    <span class="text-xs text-slate-500 font-semibold">Gunakan Pencarian & Drag Marker</span>
                </div>

                <!-- Address Autocomplete Search Bar & Toolbar Controls -->
                <div class="relative space-y-2">
                    <label class="block text-xs font-bold text-slate-700">Pencarian Alamat Autocomplete & Kontrol Peta</label>
                    <div class="flex flex-wrap gap-2">
                        <input type="text" id="map-search-input" placeholder="Ketik nama jalan, desa, kecamatan, kota, landmark, atau kode pos..." class="flex-1 min-w-[220px] px-4 py-2.5 rounded-xl border border-outline-variant text-sm focus:ring-2 focus:ring-primary">
                        <button type="button" id="btn-search-location" class="px-4 py-2.5 bg-primary text-white font-bold rounded-xl text-xs hover:bg-primary-container transition-colors">
                            🔍 Cari
                        </button>
                        <button type="button" id="btn-my-gps" class="px-3.5 py-2.5 bg-emerald-50 text-emerald-700 font-bold rounded-xl text-xs border border-emerald-200 hover:bg-emerald-100 transition-colors flex items-center gap-1">
                            📍 GPS Saya
                        </button>
                        <button type="button" id="btn-toggle-satellite" class="px-3.5 py-2.5 bg-slate-100 text-slate-800 font-bold rounded-xl text-xs border border-slate-300 hover:bg-slate-200 transition-colors flex items-center gap-1">
                            🛰️ Satelit
                        </button>
                        <button type="button" id="btn-reset-marker" class="px-3.5 py-2.5 bg-amber-50 text-amber-800 font-bold rounded-xl text-xs border border-amber-200 hover:bg-amber-100 transition-colors flex items-center gap-1">
                            🔄 Reset
                        </button>
                    </div>
                    <div id="search-results-dropdown" class="hidden absolute top-full left-0 right-0 bg-white border border-slate-200 rounded-xl shadow-xl z-30 max-h-48 overflow-y-auto mt-1 text-xs"></div>
                </div>

                <!-- Leaflet Interactive Map -->
                <div id="bank-map" class="border border-outline-variant shadow-sm"></div>

                <!-- Preview Koordinat & Alamat -->
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-2 text-xs">
                    <div class="flex flex-wrap items-center justify-between gap-2 font-bold text-slate-900">
                        <span>📍 Koordinat Terpilih:</span>
                        <div class="flex items-center gap-3">
                            <span id="display-lat-lng" class="font-mono text-emerald-700">-6.208800, 106.845600</span>
                            <a id="gmaps-external-link" href="#" target="_blank" class="text-blue-600 hover:underline font-bold text-[11px] flex items-center gap-1">
                                🔗 Buka di Google Maps
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Auto-extracted Address Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 pt-2">
                    <div class="sm:col-span-2 md:col-span-3">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap <span class="text-rose-500">*</span></label>
                        <textarea id="alamat" name="alamat" required rows="2" placeholder="Alamat jalan, RT/RW, dan patokan..." class="w-full px-4 py-2.5 rounded-xl border border-outline-variant text-sm">{{ old('alamat') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Provinsi</label>
                        <input type="text" id="provinsi" name="provinsi" value="{{ old('provinsi') }}" placeholder="Jawa Barat" class="w-full px-3 py-2 rounded-xl border border-outline-variant text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kabupaten / Kota</label>
                        <input type="text" id="kabupaten" name="kabupaten" value="{{ old('kabupaten') }}" placeholder="Kota Bandung" class="w-full px-3 py-2 rounded-xl border border-outline-variant text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kecamatan</label>
                        <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" placeholder="Coblong" class="w-full px-3 py-2 rounded-xl border border-outline-variant text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kelurahan / Desa</label>
                        <input type="text" id="desa" name="desa" value="{{ old('desa') }}" placeholder="Dago" class="w-full px-3 py-2 rounded-xl border border-outline-variant text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kode Pos</label>
                        <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}" placeholder="40135" class="w-full px-3 py-2 rounded-xl border border-outline-variant text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Latitude <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.0000001" id="latitude" name="latitude" required value="{{ old('latitude', '-6.2088') }}" class="w-full px-3 py-2 rounded-xl border border-outline-variant text-xs font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Longitude <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.0000001" id="longitude" name="longitude" required value="{{ old('longitude', '106.8456') }}" class="w-full px-3 py-2 rounded-xl border border-outline-variant text-xs font-mono">
                    </div>
                </div>
            </div>

            <!-- Submit Button Footer -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.master_bank_sampah.index') }}" class="py-3 px-6 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition-colors">
                    Batal
                </a>
                <button type="submit" class="py-3 px-8 bg-gradient-to-r from-primary to-forest-emerald hover:from-primary-container hover:to-primary text-white font-extrabold rounded-xl text-xs shadow-md transition-transform hover:scale-105">
                    💾 Simpan Bank Sampah
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const defaultLat = parseFloat(document.getElementById('latitude').value) || -6.2088;
            const defaultLng = parseFloat(document.getElementById('longitude').value) || 106.8456;

            const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap & SiSampah GIS'
            });

            const satLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 18,
                attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
            });

            const map = L.map('bank-map', {
                center: [defaultLat, defaultLng],
                zoom: 14,
                layers: [streetLayer]
            });

            let isSatellite = false;
            document.getElementById('btn-toggle-satellite').addEventListener('click', function () {
                if (isSatellite) {
                    map.removeLayer(satLayer);
                    map.addLayer(streetLayer);
                    this.textContent = '🛰️ Satelit';
                    isSatellite = false;
                } else {
                    map.removeLayer(streetLayer);
                    map.addLayer(satLayer);
                    this.textContent = '🗺️ Jalan';
                    isSatellite = true;
                }
            });

            const markerIcon = L.divIcon({
                className: 'bank-marker',
                html: '<div style="background:#10b981;width:36px;height:36px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid white;box-shadow:0 4px 14px rgba(0,0,0,.4);display:flex;align-items:center;justify-center;"><span style="transform:rotate(45deg);font-size:16px;">🏢</span></div>',
                iconSize: [36, 36],
                iconAnchor: [18, 36]
            });

            let marker = L.marker([defaultLat, defaultLng], { draggable: true, icon: markerIcon }).addTo(map);

            function updateDisplayCoords(lat, lng) {
                document.getElementById('latitude').value = lat.toFixed(7);
                document.getElementById('longitude').value = lng.toFixed(7);
                document.getElementById('display-lat-lng').textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                document.getElementById('gmaps-external-link').href = `https://www.google.com/maps/search/?api=1&query=${lat},${lng}`;
            }

            function reverseGeocode(lat, lng) {
                updateDisplayCoords(lat, lng);
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.address) {
                            const addr = data.address;
                            if (data.display_name && !document.getElementById('alamat').value) {
                                document.getElementById('alamat').value = data.display_name;
                            }
                            if (addr.state) document.getElementById('provinsi').value = addr.state;
                            if (addr.city || addr.regency || addr.county) document.getElementById('kabupaten').value = addr.city || addr.regency || addr.county;
                            if (addr.subdistrict || addr.district) document.getElementById('kecamatan').value = addr.subdistrict || addr.district;
                            if (addr.village || addr.suburb) document.getElementById('desa').value = addr.village || addr.suburb;
                            if (addr.postcode) document.getElementById('kode_pos').value = addr.postcode;
                        }
                    }).catch(e => console.warn('Geocoding error:', e));
            }

            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                reverseGeocode(e.latlng.lat, e.latlng.lng);
            });

            marker.on('dragend', function () {
                const pos = marker.getLatLng();
                reverseGeocode(pos.lat, pos.lng);
            });

            // Reset Marker button
            document.getElementById('btn-reset-marker').addEventListener('click', function () {
                marker.setLatLng([defaultLat, defaultLng]);
                map.setView([defaultLat, defaultLng], 14);
                reverseGeocode(defaultLat, defaultLng);
            });

            // Autocomplete Search Address
            const searchInput = document.getElementById('map-search-input');
            const searchDropdown = document.getElementById('search-results-dropdown');

            document.getElementById('btn-search-location').addEventListener('click', performSearch);
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') { e.preventDefault(); performSearch(); }
            });

            function performSearch() {
                const query = searchInput.value.trim();
                if (!query) return;
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=5`)
                    .then(res => res.json())
                    .then(results => {
                        searchDropdown.innerHTML = '';
                        if (results.length === 0) {
                            searchDropdown.innerHTML = '<div class="p-3 text-slate-400 text-center">Lokasi tidak ditemukan.</div>';
                        } else {
                            results.forEach(item => {
                                const div = document.createElement('div');
                                div.className = 'p-2.5 hover:bg-emerald-50 cursor-pointer border-b border-slate-100 font-medium text-slate-800';
                                div.textContent = item.display_name;
                                div.addEventListener('click', function () {
                                    const lat = parseFloat(item.lat);
                                    const lon = parseFloat(item.lon);
                                    marker.setLatLng([lat, lon]);
                                    map.setView([lat, lon], 16);
                                    document.getElementById('alamat').value = item.display_name;
                                    reverseGeocode(lat, lon);
                                    searchDropdown.classList.add('hidden');
                                });
                                searchDropdown.appendChild(div);
                            });
                        }
                        searchDropdown.classList.remove('hidden');
                    });
            }

            // GPS Saya Button
            document.getElementById('btn-my-gps').addEventListener('click', function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (pos) {
                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;
                        marker.setLatLng([lat, lng]);
                        map.setView([lat, lng], 16);
                        reverseGeocode(lat, lng);
                    });
                }
            });

            setTimeout(() => map.invalidateSize(), 300);
        });
    </script>
    @endpush
</x-app-layout>
