@extends('layouts.landing')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

@section('content')
<div class="relative min-h-screen pt-28 pb-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        {{-- Header Title --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald/10 border border-emerald/30 text-emerald-400 text-xs sm:text-sm font-semibold mb-4">
                <span class="w-2 h-2 rounded-full bg-emerald animate-pulse"></span>
                Pendaftaran Mitra Bank Sampah
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                Daftarkan Organisasi Bank Sampah Anda
            </h1>
            <p class="mt-3 text-base sm:text-lg text-slate-300 max-w-2xl mx-auto">
                Bergabung dengan jaringan digital SiSampah. Dapatkan sistem pengelolaan transaksi, radius penjemputan, wallet ledger, dan pelaporan otomatis.
            </p>
        </div>

        @if($errors->any())
            <div class="mb-8 p-4 bg-rose-500/10 border border-rose-500/30 rounded-2xl text-rose-300 text-sm">
                <div class="font-bold mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Terdapat kesalahan pengisian formulir:
                </div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pendaftaran_bank_sampah.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{
            radiusKm: {{ old('radius_layanan', 5000) / 1000 }},
            hariOperasional: '{{ old('hari_operasional', 'Senin - Sabtu') }}',
            jamBuka: '{{ old('jam_buka', '08:00') }}',
            jamTutup: '{{ old('jam_tutup', '16:00') }}',
            updateRadiusMeters() {
                document.getElementById('radius_layanan').value = this.radiusKm * 1000;
            },
            resetToDefaultOperasional() {
                this.hariOperasional = 'Senin - Sabtu';
                this.jamBuka = '08:00';
                this.jamTutup = '16:00';
                this.radiusKm = 5;
                this.updateRadiusMeters();
            }
        }">
            @csrf
            <input type="hidden" name="radius_layanan" id="radius_layanan" :value="radiusKm * 1000">

            {{-- SECTION 1: Identitas Pengelola & Akun Login --}}
            <div class="bg-[#0b221a]/90 backdrop-blur-xl border border-emerald-500/20 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                <div class="flex items-center gap-4 pb-4 border-b border-emerald-500/20">
                    <div class="w-10 h-10 rounded-2xl bg-emerald/20 text-emerald flex items-center justify-center font-bold text-lg">1</div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Identitas Penanggung Jawab & Akun Login</h2>
                        <p class="text-xs sm:text-sm text-slate-400">Pengelola utama yang akan mengendalikan dashboard Admin Bank Sampah.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Penanggung Jawab *</label>
                        <input type="text" name="penanggung_jawab" value="{{ old('penanggung_jawab') }}" required placeholder="Contoh: Budi Santoso"
                            class="w-full bg-black/40 border border-emerald-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Jabatan *</label>
                        <input type="text" name="jabatan_pj" value="Ketua Pengelola" readonly
                            class="w-full bg-slate-900/80 border border-emerald-500/30 rounded-xl px-4 py-3 text-emerald-400 font-extrabold cursor-not-allowed select-none focus:outline-none shadow-inner"
                            title="Jabatan otomatis dikunci sebagai Ketua Pengelola">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Email Login Utama *</label>
                        <input type="email" name="email_pj" value="{{ old('email_pj') }}" required placeholder="admin@banksampah.id"
                            class="w-full bg-black/40 border border-emerald-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nomor Telepon / WhatsApp *</label>
                        <input type="text" name="telepon_pj" value="{{ old('telepon_pj') }}" required placeholder="081234567890"
                            class="w-full bg-black/40 border border-emerald-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Password Akun Admin *</label>
                        <div class="relative">
                            <input id="passwordReg" type="password" name="password" required placeholder="Minimal 8 karakter"
                                class="w-full bg-black/40 border border-emerald-500/30 rounded-xl px-4 py-3 pr-12 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-400">
                            <button type="button" onclick="togglePass('passwordReg', 'eyeIconReg1')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-400 transition-colors p-1 z-10" title="Tampilkan/Sembunyikan Password">
                                <svg id="eyeIconReg1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Konfirmasi Password *</label>
                        <div class="relative">
                            <input id="passwordConfReg" type="password" name="password_confirmation" required placeholder="Ulangi password"
                                class="w-full bg-black/40 border border-emerald-500/30 rounded-xl px-4 py-3 pr-12 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-400">
                            <button type="button" onclick="togglePass('passwordConfReg', 'eyeIconReg2')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-400 transition-colors p-1 z-10" title="Tampilkan/Sembunyikan Password">
                                <svg id="eyeIconReg2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: Profil & Alamat Organisasi --}}
            <div class="bg-[#0b221a]/90 backdrop-blur-xl border border-emerald-500/20 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                <div class="flex items-center gap-4 pb-4 border-b border-emerald-500/20">
                    <div class="w-10 h-10 rounded-2xl bg-emerald/20 text-emerald flex items-center justify-center font-bold text-lg">2</div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Profil & Lokasi Operasional Bank Sampah</h2>
                        <p class="text-xs sm:text-sm text-slate-400">Data legalitas lokasi dan titik koordinat GPS layanan penjemputan.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Bank Sampah / Unit *</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Bank Sampah Asri Sukamaju"
                            class="w-full bg-black/40 border border-emerald-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-400">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi Singkat</label>
                        <textarea name="deskripsi" rows="3" placeholder="Profil singkat unit bank sampah, visi, dan jenis layanan..."
                            class="w-full bg-black/40 border border-emerald-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-400">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6" x-data="regionDropdowns()">
                        <input type="hidden" name="provinsi" :value="selectedProvinceName">
                        <input type="hidden" name="kabupaten" :value="selectedRegencyName">
                        <input type="hidden" name="kecamatan" :value="selectedDistrictName">
                        <input type="hidden" name="desa" :value="selectedVillageName">

                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Provinsi *</label>
                            <select @change="onProvinceChange($event)" required
                                class="w-full bg-slate-900 border border-emerald-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-400 font-semibold cursor-pointer">
                                <option value="">-- Pilih Provinsi --</option>
                                <template x-for="p in provinces" :key="p.id">
                                    <option :value="p.name" :selected="p.name.toLowerCase() === selectedProvinceName.toLowerCase()" x-text="p.name"></option>
                                </template>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Kabupaten / Kota *</label>
                            <select @change="onRegencyChange($event)" required
                                class="w-full bg-slate-900 border border-emerald-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-400 font-semibold cursor-pointer">
                                <option value="">-- Pilih Kabupaten / Kota --</option>
                                <template x-for="r in regencies" :key="r.id">
                                    <option :value="r.name" :selected="r.name.toLowerCase() === selectedRegencyName.toLowerCase() || r.name.toLowerCase().includes(selectedRegencyName.toLowerCase())" x-text="r.name"></option>
                                </template>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Kecamatan *</label>
                            <select @change="onDistrictChange($event)" required
                                class="w-full bg-slate-900 border border-emerald-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-400 font-semibold cursor-pointer">
                                <option value="">-- Pilih Kecamatan --</option>
                                <template x-for="d in districts" :key="d.id">
                                    <option :value="d.name" :selected="d.name.toLowerCase() === selectedDistrictName.toLowerCase()" x-text="d.name"></option>
                                </template>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Kelurahan / Desa</label>
                            <select @change="selectedVillageName = $event.target.value; geocodeAndMoveMap(15)"
                                class="w-full bg-slate-900 border border-emerald-500/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-400 font-semibold cursor-pointer">
                                <option value="">-- Pilih Kelurahan / Desa --</option>
                                <template x-for="v in villages" :key="v.id">
                                    <option :value="v.name" :selected="v.name.toLowerCase() === selectedVillageName.toLowerCase()" x-text="v.name"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Alamat Lengkap *</label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}" required placeholder="Jl. Raya Utama No. 123, RT 02 / RW 05"
                            class="w-full bg-black/40 border border-emerald-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-400">
                    </div>

                    {{-- Interactive Leaflet Map --}}
                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-sm font-medium text-slate-300 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                            <span class="flex items-center gap-2 font-bold text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Peta Lokasi & Pin GPS Operasional *
                            </span>
                            <span class="text-xs text-slate-400 font-normal">Peta otomatis terbang ke lokasi dropdown terpilih. Geser pin / klik peta untuk titik presisi.</span>
                        </label>
                        <div id="registrationMapContainer" class="w-full h-80 rounded-2xl border border-emerald-500/40 overflow-hidden relative z-0 shadow-2xl"></div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Latitude (GPS) *</label>
                        <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude', '-6.595038') }}" required
                            class="w-full bg-slate-900/80 border border-emerald-500/30 rounded-xl px-4 py-3 text-emerald-400 font-bold focus:outline-none focus:border-emerald-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Longitude (GPS) *</label>
                        <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude', '106.816635') }}" required
                            class="w-full bg-slate-900/80 border border-emerald-500/30 rounded-xl px-4 py-3 text-emerald-400 font-bold focus:outline-none focus:border-emerald-400">
                    </div>
                </div>
            </div>

            {{-- SECTION 3: Operasional & Radius Penjemputan --}}
            <div class="bg-[#0b221a]/90 backdrop-blur-xl border border-emerald-500/20 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-emerald-500/20">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-emerald/20 text-emerald flex items-center justify-center font-bold text-lg">3</div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Jam Operasional & Radius Layanan Pickup</h2>
                            <p class="text-xs sm:text-sm text-slate-400">Otomatis terisi standar operasional (08:00 - 16:00, Senin-Sabtu, 5 KM).</p>
                        </div>
                    </div>
                    <button type="button" @click="resetToDefaultOperasional()"
                        class="px-3.5 py-2 bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-400 border border-emerald-500/30 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm self-start sm:self-auto"
                        title="Reset ke Standar Operasional">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Reset Standar Otomatis
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Hari Operasional *</label>
                        <select name="hari_operasional" x-model="hariOperasional" required
                            class="w-full bg-slate-900 border border-emerald-500/30 rounded-xl px-4 py-3 text-emerald-400 font-bold focus:outline-none focus:border-emerald-400 cursor-pointer">
                            <option value="Senin - Sabtu">Senin - Sabtu (Standar Default)</option>
                            <option value="Senin - Jumat">Senin - Jumat</option>
                            <option value="Setiap Hari (Senin - Minggu)">Setiap Hari (Senin - Minggu)</option>
                            <option value="Sabtu - Minggu">Sabtu - Minggu (Akhir Pekan)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Jam Buka *</label>
                        <input type="time" name="jam_buka" x-model="jamBuka" required
                            class="w-full bg-slate-900 border border-emerald-500/30 rounded-xl px-4 py-3 text-emerald-400 font-bold focus:outline-none focus:border-emerald-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Jam Tutup *</label>
                        <input type="time" name="jam_tutup" x-model="jamTutup" required
                            class="w-full bg-slate-900 border border-emerald-500/30 rounded-xl px-4 py-3 text-emerald-400 font-bold focus:outline-none focus:border-emerald-400">
                    </div>
                </div>

                <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="font-bold text-emerald-400 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Radius Penjemputan Maksimal (Otomatis 5 KM):
                        </span>
                        <span class="font-extrabold text-emerald-400 text-lg" x-text="radiusKm + ' km (' + (radiusKm * 1000) + ' meter)'">5 km (5000 meter)</span>
                    </div>
                    <input type="range" min="1" max="25" step="1" x-model="radiusKm" @input="updateRadiusMeters()"
                        class="w-full accent-emerald cursor-pointer">
                    <p class="text-xs text-slate-400">Nasabah yang berada di luar radius ini tidak dapat mengajukan penjemputan otomatis ke unit Anda.</p>
                </div>
            </div>

            {{-- SECTION 4: Upload Dokumen Legalitas Wajib --}}
            <div class="bg-[#0b221a]/90 backdrop-blur-xl border border-emerald-500/20 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                <div class="flex items-center gap-4 pb-4 border-b border-emerald-500/20">
                    <div class="w-10 h-10 rounded-2xl bg-emerald/20 text-emerald flex items-center justify-center font-bold text-lg">4</div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Upload Dokumen Legalitas & Rekening</h2>
                        <p class="text-xs sm:text-sm text-slate-400">Dokumen wajib untuk proses audit dan verifikasi Super Admin (PDF/JPG/PNG max 5-10MB).</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-black/30 border border-emerald-500/20 rounded-2xl p-4">
                        <label class="block text-sm font-semibold text-white mb-1">1. KTP Penanggung Jawab *</label>
                        <p class="text-xs text-slate-400 mb-3">Foto KTP asli penanggung jawab utama.</p>
                        <input type="file" name="doc_ktp" required accept=".pdf,.jpg,.jpeg,.png"
                            class="block w-full text-xs text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald/20 file:text-emerald hover:file:bg-emerald/30 cursor-pointer">
                    </div>

                    <div class="bg-black/30 border border-emerald-500/20 rounded-2xl p-4">
                        <label class="block text-sm font-semibold text-white mb-1">2. Surat Legalitas / SK Komunitas *</label>
                        <p class="text-xs text-slate-400 mb-3">Surat keterangan desa/kelurahan atau akta notaris/SK.</p>
                        <input type="file" name="doc_legalitas" required accept=".pdf,.jpg,.jpeg,.png"
                            class="block w-full text-xs text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald/20 file:text-emerald hover:file:bg-emerald/30 cursor-pointer">
                    </div>

                    <div class="bg-black/30 border border-emerald-500/20 rounded-2xl p-4">
                        <label class="block text-sm font-semibold text-white mb-1">3. Foto Lokasi Bank Sampah *</label>
                        <p class="text-xs text-slate-400 mb-3">Foto plang nama & kondisi area operasional penimbangan.</p>
                        <input type="file" name="doc_foto_lokasi" required accept=".jpg,.jpeg,.png"
                            class="block w-full text-xs text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald/20 file:text-emerald hover:file:bg-emerald/30 cursor-pointer">
                    </div>

                    <div class="bg-black/30 border border-emerald-500/20 rounded-2xl p-4">
                        <label class="block text-sm font-semibold text-white mb-1">4. Buku Rekening Bank Organisasi *</label>
                        <p class="text-xs text-slate-400 mb-3">Foto halaman depan buku rekening penampung operasional.</p>
                        <input type="file" name="doc_rekening" required accept=".pdf,.jpg,.jpeg,.png"
                            class="block w-full text-xs text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald/20 file:text-emerald hover:file:bg-emerald/30 cursor-pointer">
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="text-center pt-4">
                <button type="submit" class="w-full sm:w-auto px-10 py-5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-extrabold text-lg rounded-2xl shadow-xl shadow-emerald-500/20 hover:scale-[1.02] transition-all">
                    Kirim Permohonan Pendaftaran Bank Sampah
                </button>
                <p class="mt-3 text-xs text-slate-400">Setelah dikirim, permohonan akan ditinjau oleh Super Admin dalam 1x24 jam.</p>
            </div>
        </form>

    </div>
</div>

<script>
    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        }
    }

    function regionDropdowns() {
        return {
            provinces: [],
            regencies: [],
            districts: [],
            villages: [],

            selectedProvinceName: '{{ old("provinsi", "Jawa Barat") }}',
            selectedRegencyName: '{{ old("kabupaten", "Kabupaten Bogor") }}',
            selectedDistrictName: '{{ old("kecamatan", "") }}',
            selectedVillageName: '{{ old("desa", "") }}',

            fallbackData: {
                "Jawa Barat": {
                    "Kabupaten Bogor": {
                        "Cibinong": ["Cibinong", "Pakansari", "Pabuaran", "Cirimekar", "Ciriung"],
                        "Cileungsi": ["Cileungsi", "Cileungsi Kidul", "Mekarsari", "Dayeuh", "Pasir Angin"],
                        "Ciampea": ["Ciampea", "Ciampea Udik", "Cibanteng", "Cihideung Udik"],
                        "Dramaga": ["Dramaga", "Babakan", "Ciherang", "Neglasari", "Petir"],
                        "Gunung Putri": ["Gunung Putri", "Cicadas", "Bojong Nangka", "Tlanjung Udik"],
                        "Sukaraja": ["Sukaraja", "Cikeas", "Cijujung", "Nagrak"]
                    },
                    "Kota Bogor": {
                        "Bogor Tengah": ["Paledang", "Babakan", "Gudang", "Kebon Kalapa", "Sempur"],
                        "Bogor Utara": ["Tegal Gundil", "Bantarjati", "Cibuluh", "Kedunghalang"],
                        "Bogor Selatan": ["Batutulis", "Bondongan", "Cikaret", "Empang"],
                        "Bogor Barat": ["Menteng", "Pasir Jaya", "Semplak", "Sindangbarang"]
                    },
                    "Kota Bandung": {
                        "Coblong": ["Dago", "Lebak Siliwangi", "Sadang Serang", "Sekeloa"],
                        "Cicendo": ["Arjuna", "Pasirkaliki", "Pajajaran", "Sukaraja"],
                        "Sumur Bandung": ["Braga", "Kebon Pisang", "Merdeka", "Pasir Kaliki"]
                    },
                    "Kabupaten Bekasi": {
                        "Cikarang Pusat": ["Sukamahi", "Cicau", "Pasirranji"],
                        "Cikarang Utara": ["Cikarang Kota", "Karangraharja", "Waluya"],
                        "Tambun Selatan": ["Lambangjaya", "Mechanic", "Setiadarma"]
                    }
                },
                "DKI Jakarta": {
                    "Jakarta Selatan": {
                        "Kebayoran Baru": ["Gandasari", "Kramat Pela", "Melawai", "Senayan"],
                        "Cilandak": ["Cilandak Barat", "Cipete Selatan", "Gandaria Selatan", "Pondok Labu"],
                        "Pasar Minggu": ["Jati Padang", "Kedung Badak", "Pasar Minggu", "Ragunan"]
                    },
                    "Jakarta Timur": {
                        "Jatinegara": ["Bali Mester", "Bidara Cina", "Cipinang Cempedak", "Kampung Melayu"],
                        "Duren Sawit": ["Duren Sawit", "Klender", "Malaka Jaya", "Pondok Kelapa"]
                    }
                },
                "Jawa Tengah": {
                    "Kota Semarang": {
                        "Semarang Tengah": ["Bangunharjo", "Brumbungan", "Kauman", "Kembangsari"],
                        "Semarang Selatan": ["Bulustalan", "Lamper Tengah", "Peterongan", "Randusari"]
                    },
                    "Kota Surakarta (Solo)": {
                        "Banjarsari": ["Banyuanyar", "Kadipiro", "Keprabon", "Manahan"],
                        "Jebres": ["Gandekan", "Jagalan", "Jebres", "Kepatihan Kulon"]
                    }
                },
                "Jawa Timur": {
                    "Kota Surabaya": {
                        "Gubeng": ["Air Langga", "Barata Jaya", "Gubeng", "Kertajaya"],
                        "Tegalsari": ["Dr. Soetomo", "Kedungdoro", "Keputran", "Tegalsari"]
                    },
                    "Kabupaten Malang": {
                        "Kepanjen": ["Kepanjen", "Ardirejo", "Curungrejo", "Dilem"],
                        "Singosari": ["Candirejo", "Klampok", "Losari", "Pangetan"]
                    }
                },
                "Banten": {
                    "Kota Tangerang": {
                        "Tangerang": ["Cikokol", "Kelapa Indah", "Sukasari", "Sukarsari"],
                        "Karawaci": ["Bugel", "Gerendeng", "Karawaci", "Margasari"]
                    },
                    "Kabupaten Tangerang": {
                        "Cikupa": ["Budi Mulya", "Cikupa", "Dukuh", "Talaga"],
                        "Balaraja": ["Balaraja", "Cangkudu", "Saga", "Talagasari"]
                    }
                },
                "DI Yogyakarta": {
                    "Kota Yogyakarta": {
                        "Gondokusuman": ["Baciro", "Demangan", "Klitren", "Kotabaru", "Terban"],
                        "Umbulharjo": ["Giwangan", "Muja Muju", "Pandeyan", "Semaki", "Sorosutan"]
                    },
                    "Kabupaten Sleman": {
                        "Depok": ["Caturtunggal", "Maguwoharjo", "Ngaplik"],
                        "Mlati": ["Caturharjo", "Sendangadi", "Sinduadi"]
                    }
                }
            },

            init() {
                this.fetchProvinces();
            },

            async fetchProvinces() {
                try {
                    const res = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                    if (res.ok) {
                        this.provinces = await res.json();
                        const matched = this.provinces.find(p => p.name.toLowerCase() === this.selectedProvinceName.toLowerCase());
                        if (matched && matched.id) {
                            this.fetchRegencies(matched.id);
                        } else {
                            this.useFallbackRegencies(this.selectedProvinceName);
                        }
                    } else {
                        this.useFallbackProvinces();
                    }
                } catch (e) {
                    this.useFallbackProvinces();
                }
            },

            useFallbackProvinces() {
                this.provinces = Object.keys(this.fallbackData).map((name, index) => ({ id: index + 1, name }));
                this.useFallbackRegencies(this.selectedProvinceName);
            },

            useFallbackRegencies(provName) {
                const key = Object.keys(this.fallbackData).find(k => k.toLowerCase() === provName.toLowerCase());
                if (key && this.fallbackData[key]) {
                    this.regencies = Object.keys(this.fallbackData[key]).map((name, idx) => ({ id: idx + 1, name }));
                }
            },

            onProvinceChange(event) {
                const selectedVal = event.target.value;
                this.selectedProvinceName = selectedVal;
                this.selectedRegencyName = '';
                this.selectedDistrictName = '';
                this.selectedVillageName = '';
                this.regencies = [];
                this.districts = [];
                this.villages = [];

                if (!selectedVal) return;

                const matched = this.provinces.find(p => p.name === selectedVal || p.name.toLowerCase() === selectedVal.toLowerCase());
                if (matched && matched.id) {
                    this.fetchRegencies(matched.id);
                } else {
                    this.useFallbackRegencies(selectedVal);
                }
            },

            async fetchRegencies(provId) {
                try {
                    const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`);
                    if (res.ok) {
                        this.regencies = await res.json();
                        if (this.selectedRegencyName) {
                            const matched = this.regencies.find(r => r.name.toLowerCase() === this.selectedRegencyName.toLowerCase() || r.name.toLowerCase().includes(this.selectedRegencyName.toLowerCase()));
                            if (matched && matched.id) {
                                this.fetchDistricts(matched.id);
                            }
                        }
                    } else {
                        this.useFallbackRegencies(this.selectedProvinceName);
                    }
                } catch (e) {
                    console.warn(e);
                    this.useFallbackRegencies(this.selectedProvinceName);
                }
            },

            onRegencyChange(event) {
                const selectedVal = event.target.value;
                this.selectedRegencyName = selectedVal;
                this.selectedDistrictName = '';
                this.selectedVillageName = '';
                this.districts = [];
                this.villages = [];

                if (!selectedVal) return;

                const matched = this.regencies.find(r => r.name === selectedVal || r.name.toLowerCase() === selectedVal.toLowerCase());
                if (matched && matched.id) {
                    this.fetchDistricts(matched.id);
                } else {
                    const provKey = Object.keys(this.fallbackData).find(k => k.toLowerCase() === this.selectedProvinceName.toLowerCase());
                    if (provKey && this.fallbackData[provKey]) {
                        const regKey = Object.keys(this.fallbackData[provKey]).find(k => k.toLowerCase() === selectedVal.toLowerCase());
                        if (regKey && this.fallbackData[provKey][regKey]) {
                            this.districts = Object.keys(this.fallbackData[provKey][regKey]).map((name, idx) => ({ id: idx + 1, name }));
                        }
                    }
                }
            },

            async fetchDistricts(regId) {
                try {
                    const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regId}.json`);
                    if (res.ok) {
                        this.districts = await res.json();
                    }
                } catch (e) {
                    console.warn(e);
                }
            },

            onDistrictChange(event) {
                const selectedVal = event.target.value;
                this.selectedDistrictName = selectedVal;
                this.selectedVillageName = '';
                this.villages = [];

                if (!selectedVal) return;

                const matched = this.districts.find(d => d.name === selectedVal || d.name.toLowerCase() === selectedVal.toLowerCase());
                if (matched && matched.id) {
                    this.fetchVillages(matched.id);
                } else {
                    const provKey = Object.keys(this.fallbackData).find(k => k.toLowerCase() === this.selectedProvinceName.toLowerCase());
                    if (provKey && this.fallbackData[provKey]) {
                        const regKey = Object.keys(this.fallbackData[provKey]).find(k => k.toLowerCase() === this.selectedRegencyName.toLowerCase());
                        if (regKey && this.fallbackData[provKey][regKey]) {
                            const distKey = Object.keys(this.fallbackData[provKey][regKey]).find(k => k.toLowerCase() === selectedVal.toLowerCase());
                            if (distKey && Array.isArray(this.fallbackData[provKey][regKey][distKey])) {
                                this.villages = this.fallbackData[provKey][regKey][distKey].map((name, idx) => ({ id: idx + 1, name }));
                            }
                        }
                    }
                }
                this.geocodeAndMoveMap(14);
            },

            async fetchVillages(distId) {
                try {
                    const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${distId}.json`);
                    if (res.ok) {
                        this.villages = await res.json();
                    }
                } catch (e) {
                    console.warn(e);
                }
            },

            async geocodeAndMoveMap(zoomLevel = 13) {
                const parts = [
                    this.selectedVillageName,
                    this.selectedDistrictName,
                    this.selectedRegencyName,
                    this.selectedProvinceName
                ].filter(Boolean);

                if (parts.length === 0) return;

                const query = parts.join(', ') + ', Indonesia';
                try {
                    const url = `https://nominatim.openstreetmap.org/search?format=json&countrycodes=id&limit=1&q=${encodeURIComponent(query)}`;
                    const res = await fetch(url);
                    if (res.ok) {
                        const data = await res.json();
                        if (data && data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            
                            const latInput = document.getElementById('latitude');
                            const lonInput = document.getElementById('longitude');
                            if (latInput) latInput.value = lat.toFixed(6);
                            if (lonInput) lonInput.value = lon.toFixed(6);

                            if (window.registrationMap && window.registrationMarker) {
                                window.registrationMarker.setLatLng([lat, lon]);
                                window.registrationMap.flyTo([lat, lon], zoomLevel, { duration: 1.5 });
                            }
                        }
                    }
                } catch (e) {
                    console.warn('Geocoding error:', e);
                }
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const latInput = document.getElementById('latitude');
        const lonInput = document.getElementById('longitude');
        
        let initialLat = parseFloat(latInput ? latInput.value : '-6.595038') || -6.595038;
        let initialLng = parseFloat(lonInput ? lonInput.value : '106.816635') || 106.816635;

        if (document.getElementById('registrationMapContainer')) {
            const map = L.map('registrationMapContainer').setView([initialLat, initialLng], 12);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

            marker.on('dragend', function (e) {
                const pos = e.target.getLatLng();
                if (latInput) latInput.value = pos.lat.toFixed(6);
                if (lonInput) lonInput.value = pos.lng.toFixed(6);
            });

            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                if (latInput) latInput.value = e.latlng.lat.toFixed(6);
                if (lonInput) lonInput.value = e.latlng.lng.toFixed(6);
            });

            window.registrationMap = map;
            window.registrationMarker = marker;
        }
    });
</script>
@endsection
