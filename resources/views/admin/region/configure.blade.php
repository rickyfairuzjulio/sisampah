@extends('layouts.dashboard')

@section('header', 'General Settings — Konfigurasi Sistem')

@section('content')
<div class="space-y-6">

    {{-- Top Title Banner --}}
    <div class="card card-body bg-gradient-to-r from-emerald-500/10 via-surface to-background border border-emerald-500/20 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl flex items-center justify-center text-emerald-500 text-xl shadow-soft">
                <i class="bi bi-gear-fill"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-text-primary tracking-tight">General Settings</h1>
                <p class="text-xs font-semibold text-text-secondary mt-0.5">Pengaturan informasi perusahaan, tema aplikasi, zona waktu, fitur toggle, dan gateway</p>
            </div>
        </div>

        <button type="submit" form="settings-form" class="btn bg-emerald-600 hover:bg-emerald-500 text-white font-bold !py-2.5 !px-6 text-xs shadow-lg">
            <i class="bi bi-save-fill"></i> Simpan Semua Pengaturan
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl text-emerald-400 text-xs font-semibold flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-base"></i>
            {{ session('success') }}
        </div>
    @endif

    <form id="settings-form" action="{{ route('admin.region.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- COLUMN 1: Informasi Perusahaan / Organisasi --}}
            <div class="space-y-6">
                <div class="card p-6 space-y-4">
                    <h3 class="text-sm font-bold text-text-primary uppercase tracking-wider border-b border-border pb-3 flex items-center gap-2">
                        <i class="bi bi-building text-primary"></i> Informasi Perusahaan
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">Nama Aplikasi</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-text-secondary">
                                    <i class="bi bi-app-indicator"></i>
                                </span>
                                <input type="text" name="app_name" value="{{ old('app_name', $settings['app_name'] ?? 'SiSampah') }}" required
                                    class="form-input text-xs w-full pl-9 rounded-xl border-border">
                            </div>
                        </div>

                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">Nama Perusahaan / Instansi</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-text-secondary">
                                    <i class="bi bi-house-door"></i>
                                </span>
                                <input type="text" name="company_name" value="{{ old('company_name', $settings['company_name'] ?? 'PT SiSampah Digital Indonesia') }}" required
                                    class="form-input text-xs w-full pl-9 rounded-xl border-border">
                            </div>
                        </div>

                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">Alamat Perusahaan</label>
                            <textarea name="company_address" rows="3" required class="form-input text-xs w-full rounded-xl border-border">{{ old('company_address', $settings['company_address'] ?? 'Jl. Pemuda No. 1, Jakarta') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">Telepon</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-text-secondary">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <input type="text" name="phone" value="{{ old('phone', $settings['phone'] ?? '021-5551234') }}" required
                                    class="form-input text-xs w-full pl-9 rounded-xl border-border">
                            </div>
                        </div>

                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">Nama HRD / Penanggung Jawab</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-text-secondary">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="hrd_name" value="{{ old('hrd_name', $settings['hrd_name'] ?? 'Adam Abdi Al Ala') }}" required
                                    class="form-input text-xs w-full pl-9 rounded-xl border-border">
                            </div>
                        </div>

                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">Logo Perusahaan</label>
                            <input type="file" name="logo" accept="image/*" class="block w-full text-xs text-text-secondary file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary/20 file:text-primary">
                        </div>

                        <div class="pt-2 text-center">
                            <img src="{{ $settings['logo_url'] ?? asset('images/logo.png') }}" alt="Company Logo" class="w-28 h-28 object-contain mx-auto border border-border p-2 rounded-2xl bg-surface">
                        </div>
                    </div>
                </div>
            </div>

            {{-- COLUMN 2: Pengaturan Sistem, Tema, Presensi --}}
            <div class="space-y-6">

                {{-- Pengaturan Sistem Card --}}
                <div class="card p-6 space-y-4">
                    <h3 class="text-sm font-bold text-text-primary uppercase tracking-wider border-b border-border pb-3 flex items-center gap-2">
                        <i class="bi bi-sliders text-primary"></i> Pengaturan Sistem
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">Zona Waktu Default Sistem *</label>
                            <select name="timezone" class="form-select text-xs w-full rounded-xl border-border">
                                <option value="Asia/Jakarta" {{ ($settings['timezone'] ?? '') === 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                                <option value="Asia/Makassar" {{ ($settings['timezone'] ?? '') === 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                                <option value="Asia/Jayapura" {{ ($settings['timezone'] ?? '') === 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                            </select>
                            <p class="text-[10px] text-text-secondary mt-1">Zona waktu ini akan mengubah pengaturan timezone di file config.</p>
                        </div>

                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">Durasi Sesi Login (Hari)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-text-secondary">
                                    <i class="bi bi-clock"></i>
                                </span>
                                <input type="number" name="session_duration_days" value="{{ old('session_duration_days', $settings['session_duration_days'] ?? 30) }}" required
                                    class="form-input text-xs w-full pl-9 rounded-xl border-border">
                            </div>
                            <p class="text-[10px] text-text-secondary mt-1">Lama waktu user tetap login tanpa perlu login ulang.</p>
                        </div>
                    </div>
                </div>

                {{-- Pengaturan Tema Aplikasi Card --}}
                <div class="card p-6 space-y-4">
                    <h3 class="text-sm font-bold text-text-primary uppercase tracking-wider border-b border-border pb-3 flex items-center gap-2">
                        <i class="bi bi-palette text-primary"></i> Pengaturan Tema Aplikasi
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-text-secondary font-semibold mb-1">Warna Utama (Primary)</label>
                                <input type="color" name="primary_color" value="{{ old('primary_color', $settings['primary_color'] ?? '#041A12') }}"
                                    class="w-full h-10 rounded-xl cursor-pointer bg-surface border border-border p-1">
                            </div>
                            <div>
                                <label class="block text-text-secondary font-semibold mb-1">Warna Sekunder (Hover)</label>
                                <input type="color" name="secondary_color" value="{{ old('secondary_color', $settings['secondary_color'] ?? '#10B981') }}"
                                    class="w-full h-10 rounded-xl cursor-pointer bg-surface border border-border p-1">
                            </div>
                        </div>

                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">Tema Aplikasi Mobile / Web</label>
                            <select name="app_theme" class="form-select text-xs w-full rounded-xl border-border">
                                <option value="Green (Default)">Green (Default Emerald)</option>
                                <option value="Forest Dark">Forest Dark</option>
                                <option value="Ocean Blue">Ocean Blue</option>
                                <option value="Slate Dark">Slate Dark</option>
                            </select>
                            <p class="text-[10px] text-text-secondary mt-1">Warna ini akan mengubah tampilan Sidebar dan tombol utama.</p>
                        </div>
                    </div>
                </div>

                {{-- Pengaturan Presensi & Operasional --}}
                <div class="card p-6 space-y-4">
                    <h3 class="text-sm font-bold text-text-primary uppercase tracking-wider border-b border-border pb-3 flex items-center gap-2">
                        <i class="bi bi-calendar-check text-primary"></i> Pengaturan Presensi & Radius
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">Total Jam Kerja dalam 1 Bulan</label>
                            <input type="number" name="work_hours_monthly" value="{{ old('work_hours_monthly', $settings['work_hours_monthly'] ?? 173) }}" required
                                class="form-input text-xs w-full rounded-xl border-border">
                        </div>
                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">Default Radius Penjemputan (Meter)</label>
                            <input type="number" name="default_radius_m" value="{{ old('default_radius_m', $settings['default_radius_m'] ?? 3000) }}" required
                                class="form-input text-xs w-full rounded-xl border-border">
                        </div>
                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">Minimum Berat Penjemputan (Kg)</label>
                            <input type="number" step="any" name="min_pickup_weight_kg" value="{{ old('min_pickup_weight_kg', $settings['min_pickup_weight_kg'] ?? 5) }}" required
                                class="form-input text-xs w-full rounded-xl border-border">
                        </div>
                    </div>
                </div>

            </div>

            {{-- COLUMN 3: Menu Karyawan Toggles & Integrasi Gateway --}}
            <div class="space-y-6">

                {{-- Fitur Navigation Toggles Card --}}
                <div class="card p-6 space-y-4">
                    <h3 class="text-sm font-bold text-text-primary uppercase tracking-wider border-b border-border pb-3 flex items-center gap-2">
                        <i class="bi bi-toggle-on text-primary"></i> Menu & Module Toggles
                    </h3>

                    @php
                        $toggles = $settings['toggles'] ?? [];
                    @endphp

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between p-2 rounded-xl bg-surface">
                            <span class="font-semibold text-text-primary">ID Card Nasabah/Petugas</span>
                            <input type="checkbox" name="toggle_id_card" value="1" {{ !empty($toggles['id_card']) ? 'checked' : '' }} class="form-checkbox h-4 w-4 text-emerald-500 rounded border-border">
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-xl bg-surface">
                            <span class="font-semibold text-text-primary">Dokumen Legalitas</span>
                            <input type="checkbox" name="toggle_dokumen" value="1" {{ !empty($toggles['dokumen']) ? 'checked' : '' }} class="form-checkbox h-4 w-4 text-emerald-500 rounded border-border">
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-xl bg-surface">
                            <span class="font-semibold text-text-primary">Slip Gaji / Setoran</span>
                            <input type="checkbox" name="toggle_slip_gaji" value="1" {{ !empty($toggles['slip_gaji']) ? 'checked' : '' }} class="form-checkbox h-4 w-4 text-emerald-500 rounded border-border">
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-xl bg-surface">
                            <span class="font-semibold text-text-primary">Kunjungan Penjemputan</span>
                            <input type="checkbox" name="toggle_kunjungan" value="1" {{ !empty($toggles['kunjungan']) ? 'checked' : '' }} class="form-checkbox h-4 w-4 text-emerald-500 rounded border-border">
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-xl bg-surface">
                            <span class="font-semibold text-text-primary">Catatan Pelanggaran</span>
                            <input type="checkbox" name="toggle_pelanggaran" value="1" {{ !empty($toggles['pelanggaran']) ? 'checked' : '' }} class="form-checkbox h-4 w-4 text-emerald-500 rounded border-border">
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-xl bg-surface">
                            <span class="font-semibold text-text-primary">Reimbursement / Penarikan</span>
                            <input type="checkbox" name="toggle_reimbursement" value="1" {{ !empty($toggles['reimbursement']) ? 'checked' : '' }} class="form-checkbox h-4 w-4 text-emerald-500 rounded border-border">
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-xl bg-surface">
                            <span class="font-semibold text-text-primary">Tukar Sampah / Katalog</span>
                            <input type="checkbox" name="toggle_tukar_sampah" value="1" {{ !empty($toggles['tukar_sampah']) ? 'checked' : '' }} class="form-checkbox h-4 w-4 text-emerald-500 rounded border-border">
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-xl bg-surface">
                            <span class="font-semibold text-text-primary">AI Vision Chatbot</span>
                            <input type="checkbox" name="toggle_project_ai" value="1" {{ !empty($toggles['project_ai']) ? 'checked' : '' }} class="form-checkbox h-4 w-4 text-emerald-500 rounded border-border">
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-xl bg-surface">
                            <span class="font-semibold text-text-primary">Hak Akses Role Scoping</span>
                            <input type="checkbox" name="toggle_hak_akses" value="1" {{ !empty($toggles['hak_akses']) ? 'checked' : '' }} class="form-checkbox h-4 w-4 text-emerald-500 rounded border-border">
                        </div>
                    </div>
                </div>

                {{-- Integration Gateway Card --}}
                <div class="card p-6 space-y-4">
                    <h3 class="text-sm font-bold text-text-primary uppercase tracking-wider border-b border-border pb-3 flex items-center gap-2">
                        <i class="bi bi-key text-primary"></i> Pengaturan Gateway & Messaging
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">Cloud / Payment Gateway ID</label>
                            <input type="text" name="cloud_id" value="{{ old('cloud_id', $settings['cloud_id'] ?? 'CLOUD-SISAMPAH-9921') }}"
                                class="form-input text-xs w-full rounded-xl border-border">
                        </div>
                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">API Key Gateway</label>
                            <input type="password" name="api_key" value="{{ old('api_key', $settings['api_key'] ?? 'sk_live_sisampah_8819231') }}"
                                class="form-input text-xs w-full rounded-xl border-border">
                        </div>
                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">Provider WhatsApp Gateway</label>
                            <input type="text" name="wa_provider" value="{{ old('wa_provider', $settings['wa_provider'] ?? 'Fonnte (Official)') }}"
                                class="form-input text-xs w-full rounded-xl border-border">
                        </div>
                        <div>
                            <label class="block text-text-secondary font-semibold mb-1">WhatsApp API Key</label>
                            <input type="password" name="wa_api_key" value="{{ old('wa_api_key', $settings['wa_api_key'] ?? 'fonnte_key_live_772183') }}"
                                class="form-input text-xs w-full rounded-xl border-border">
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>

    {{-- Readonly Coverage Table Footer --}}
    <div class="card p-6 space-y-4">
        <h3 class="text-sm font-bold text-text-primary uppercase tracking-wider border-b border-border pb-3 flex items-center gap-2">
            <i class="bi bi-geo-alt text-primary"></i> Daftar Wilayah Ter-cover (RT & RW Organic Coverage)
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <div>
                <span class="font-bold text-text-primary block mb-2">Daftar Rukun Tetangga (RT):</span>
                <div class="flex flex-wrap gap-2">
                    @forelse(collect($rtList)->sort() as $rt)
                        <span class="px-3 py-1 bg-surface border border-border rounded-lg font-bold text-primary">RT {{ str_pad($rt, 3, '0', STR_PAD_LEFT) }}</span>
                    @empty
                        <span class="text-text-secondary italic">Belum ada RT terdaftar</span>
                    @endforelse
                </div>
            </div>
            <div>
                <span class="font-bold text-text-primary block mb-2">Daftar Rukun Warga (RW):</span>
                <div class="flex flex-wrap gap-2">
                    @forelse(collect($rwList)->sort() as $rw)
                        <span class="px-3 py-1 bg-surface border border-border rounded-lg font-bold text-emerald-400">RW {{ str_pad($rw, 3, '0', STR_PAD_LEFT) }}</span>
                    @empty
                        <span class="text-text-secondary italic">Belum ada RW terdaftar</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
