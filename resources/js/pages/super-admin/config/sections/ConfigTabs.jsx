import React, { useState } from 'react';

export default function ConfigTabs({
    settings = {},
    rtList = [],
    rwList = [],
    csrfToken = '',
}) {
    const [activeTab, setActiveTab] = useState('logistics');

    // Form fields state
    const [appName, setAppName] = useState(settings.app_name || 'SiSampah');
    const [companyName, setCompanyName] = useState(settings.company_name || 'PT SiSampah Digital Indonesia');
    const [companyAddress, setCompanyAddress] = useState(settings.company_address || 'Jl. Pemuda No. 1, Semarang / Jakarta');
    const [phone, setPhone] = useState(settings.phone || '024-87654321');
    const [hrdName, setHrdName] = useState(settings.hrd_name || 'Adam Abdi Al Ala');
    const [timezone, setTimezone] = useState(settings.timezone || 'Asia/Jakarta');
    const [sessionDays, setSessionDays] = useState(settings.session_duration_days || 30);
    const [defaultRadius, setDefaultRadius] = useState(settings.default_radius_m || 3000);
    const [minPickupWeight, setMinPickupWeight] = useState(settings.min_pickup_weight_kg || 5);
    const [minWithdrawal, setMinWithdrawal] = useState(settings.min_withdrawal_rp || 10000);
    const [lowCashThreshold, setLowCashThreshold] = useState(settings.low_cash_threshold_rp || 1000000);
    const [platformFee, setPlatformFee] = useState(settings.platform_fee_rp || 0);

    // Integrations
    const [cloudId, setCloudId] = useState(settings.cloud_id || 'CLOUD-SISAMPAH-9921');
    const [apiKey, setApiKey] = useState(settings.api_key || 'sk_live_sisampah_8819231');
    const [waProvider, setWaProvider] = useState(settings.wa_provider || 'Fonnte (Official)');
    const [waApiKey, setWaApiKey] = useState(settings.wa_api_key || 'fonnte_key_live_772183');

    // Toggles
    const [toggles, setToggles] = useState(settings.toggles || {
        project_ai: true,
        tukar_sampah: true,
        hak_akses: true,
        dokumen: true,
    });

    const handleToggle = (key) => {
        setToggles((prev) => ({ ...prev, [key]: !prev[key] }));
    };

    const tabs = [
        { key: 'logistics', label: 'Logistik & Armada', icon: 'bi-truck' },
        { key: 'financial', label: 'Finansial & Kas', icon: 'bi-cash-coin' },
        { key: 'regions', label: `Master Wilayah RT/RW (${rtList.length + rwList.length})`, icon: 'bi-geo-alt-fill' },
        { key: 'gateways', label: 'Gateway & Notifikasi', icon: 'bi-plug-fill' },
        { key: 'features', label: 'Saklar Fitur (Flags)', icon: 'bi-toggles2' },
    ];

    return (
        <div className="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            {/* Tab Header */}
            <div className="flex border-b border-slate-100 bg-slate-50/60 overflow-x-auto">
                {tabs.map((tab) => {
                    const isActive = activeTab === tab.key;
                    return (
                        <button
                            key={tab.key}
                            type="button"
                            onClick={() => setActiveTab(tab.key)}
                            className={`flex items-center gap-2 px-6 py-4 text-xs font-bold whitespace-nowrap transition-all border-b-2 ${
                                isActive
                                    ? 'border-emerald-600 text-emerald-800 bg-white shadow-2xs'
                                    : 'border-transparent text-slate-500 hover:text-slate-800 hover:bg-slate-100/60'
                            }`}
                        >
                            <i className={`bi ${tab.icon}`} />
                            <span>{tab.label}</span>
                        </button>
                    );
                })}
            </div>

            {/* Form */}
            <form method="POST" action="/super-admin/konfigurasi-wilayah" className="p-6 md:p-8 space-y-6 text-xs">
                <input type="hidden" name="_token" value={csrfToken} />

                {/* Hidden Defaults for General Settings compatibility */}
                <input type="hidden" name="app_name" value={appName} />
                <input type="hidden" name="company_name" value={companyName} />
                <input type="hidden" name="company_address" value={companyAddress} />
                <input type="hidden" name="phone" value={phone} />
                <input type="hidden" name="hrd_name" value={hrdName} />
                <input type="hidden" name="primary_color" value={settings.primary_color || '#047857'} />
                <input type="hidden" name="secondary_color" value={settings.secondary_color || '#10B981'} />
                <input type="hidden" name="app_theme" value={settings.app_theme || 'Emerald Light (Default)'} />
                <input type="hidden" name="work_hours_monthly" value={settings.work_hours_monthly || 173} />

                {/* ─── TAB 1: LOGISTIK & ARMADA ─── */}
                {activeTab === 'logistics' && (
                    <div className="space-y-5">
                        <div>
                            <h3 className="text-sm font-black text-slate-900">
                                Standar Logistik & Radius Armada Nasional
                            </h3>
                            <p className="text-[11px] text-slate-400">
                                Parameter acuan untuk pembatasan jangkauan penjemputan sampah dan sesi login aplikasi.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div className="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                                <label className="block font-extrabold text-slate-800">
                                    Default Radius Layanan (Meter) *
                                </label>
                                <input
                                    type="number"
                                    name="default_radius_m"
                                    required
                                    value={defaultRadius}
                                    onChange={(e) => setDefaultRadius(e.target.value)}
                                    className="w-full p-2.5 rounded-xl bg-white border border-slate-200 font-bold text-slate-900 focus:ring-2 focus:ring-emerald-400"
                                />
                                <p className="text-[11px] text-slate-400">
                                    * Radius acuan default yang diterapkan saat unit mitra baru terdaftar (misal: 3.000 m = 3.0 Km).
                                </p>
                            </div>

                            <div className="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                                <label className="block font-extrabold text-slate-800">
                                    Minimal Berat Jemput Sampah (Kg) *
                                </label>
                                <input
                                    type="number"
                                    step="0.5"
                                    name="min_pickup_weight_kg"
                                    required
                                    value={minPickupWeight}
                                    onChange={(e) => setMinPickupWeight(e.target.value)}
                                    className="w-full p-2.5 rounded-xl bg-white border border-slate-200 font-bold text-slate-900 focus:ring-2 focus:ring-emerald-400"
                                />
                                <p className="text-[11px] text-slate-400">
                                    * Bobot minimal sampah anorganik agar nasabah dapat mengajukan penjemputan armada ke rumah.
                                </p>
                            </div>

                            <div className="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                                <label className="block font-extrabold text-slate-800">
                                    Masa Kedaluwarsa Sesi Login (Hari) *
                                </label>
                                <input
                                    type="number"
                                    name="session_duration_days"
                                    required
                                    value={sessionDays}
                                    onChange={(e) => setSessionDays(e.target.value)}
                                    className="w-full p-2.5 rounded-xl bg-white border border-slate-200 font-bold text-slate-900 focus:ring-2 focus:ring-emerald-400"
                                />
                                <p className="text-[11px] text-slate-400">
                                    * Durasi token login sebelum pengguna harus mengautentikasi ulang demi keamanan.
                                </p>
                            </div>

                            <div className="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                                <label className="block font-extrabold text-slate-800">
                                    Zona Waktu Platform (Timezone) *
                                </label>
                                <select
                                    name="timezone"
                                    value={timezone}
                                    onChange={(e) => setTimezone(e.target.value)}
                                    className="w-full p-2.5 rounded-xl bg-white border border-slate-200 font-bold text-slate-900 focus:ring-2 focus:ring-emerald-400"
                                >
                                    <option value="Asia/Jakarta">Asia/Jakarta (WIB - UTC+7)</option>
                                    <option value="Asia/Makassar">Asia/Makassar (WITA - UTC+8)</option>
                                    <option value="Asia/Jayapura">Asia/Jayapura (WIT - UTC+9)</option>
                                </select>
                                <p className="text-[11px] text-slate-400">
                                    * Waktu standar acuan pencatatan transaksi & penimbangan sampah.
                                </p>
                            </div>
                        </div>
                    </div>
                )}

                {/* ─── TAB 2: FINANSIAL & KAS ─── */}
                {activeTab === 'financial' && (
                    <div className="space-y-5">
                        <div>
                            <h3 className="text-sm font-black text-slate-900">
                                Kebijakan Finansial & Ambang Batas Kas Nasional
                            </h3>
                            <p className="text-[11px] text-slate-400">
                                Batasan penarikan saldo nasabah dan indikator peringatan likuiditas kas bank sampah.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div className="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                                <label className="block font-extrabold text-slate-800">
                                    Minimal Penarikan Saldo (Rp)
                                </label>
                                <input
                                    type="number"
                                    name="min_withdrawal_rp"
                                    value={minWithdrawal}
                                    onChange={(e) => setMinWithdrawal(e.target.value)}
                                    className="w-full p-2.5 rounded-xl bg-white border border-slate-200 font-bold text-slate-900 focus:ring-2 focus:ring-emerald-400"
                                />
                                <p className="text-[11px] text-slate-400">
                                    * Batas bawah pencairan saldo dompet warga (mencegah beban biaya transaksi mikro).
                                </p>
                            </div>

                            <div className="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                                <label className="block font-extrabold text-slate-800">
                                    Ambang Peringatan Kas Menipis (Rp)
                                </label>
                                <input
                                    type="number"
                                    name="low_cash_threshold_rp"
                                    value={lowCashThreshold}
                                    onChange={(e) => setLowCashThreshold(e.target.value)}
                                    className="w-full p-2.5 rounded-xl bg-white border border-slate-200 font-bold text-slate-900 focus:ring-2 focus:ring-emerald-400"
                                />
                                <p className="text-[11px] text-slate-400">
                                    * Standar saldo kas unit minimum sebelum sistem mengirim notifikasi top-up kas.
                                </p>
                            </div>

                            <div className="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                                <label className="block font-extrabold text-slate-800">
                                    Biaya Admin Penarikan (Rp)
                                </label>
                                <input
                                    type="number"
                                    name="platform_fee_rp"
                                    value={platformFee}
                                    onChange={(e) => setPlatformFee(e.target.value)}
                                    className="w-full p-2.5 rounded-xl bg-white border border-slate-200 font-bold text-slate-900 focus:ring-2 focus:ring-emerald-400"
                                />
                                <p className="text-[11px] text-slate-400">
                                    * Gratis biaya admin (Rp 0) untuk kemudahan seluruh warga.
                                </p>
                            </div>
                        </div>
                    </div>
                )}

                {/* ─── TAB 3: MASTER WILAYAH RT/RW ─── */}
                {activeTab === 'regions' && (
                    <div className="space-y-5">
                        <div className="flex items-center justify-between">
                            <div>
                                <h3 className="text-sm font-black text-slate-900">
                                    Master Wilayah RT/RW Komunitas Warga
                                </h3>
                                <p className="text-[11px] text-slate-400">
                                    Daftar wilayah RT dan RW binaan aktif yang telah terhubung ke unit-unit Bank Sampah.
                                </p>
                            </div>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {/* RT List */}
                            <div className="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                                <div className="flex items-center justify-between">
                                    <span className="font-extrabold text-slate-900">Daftar RT Terdaftar</span>
                                    <span className="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px]">
                                        {rtList.length} RT Aktif
                                    </span>
                                </div>
                                <div className="flex flex-wrap gap-2 max-h-48 overflow-y-auto p-1">
                                    {rtList.map((rt, idx) => (
                                        <span key={idx} className="px-3 py-1.5 rounded-xl bg-white border border-slate-200 font-bold text-slate-800 text-xs shadow-2xs">
                                            RT {rt}
                                        </span>
                                    ))}
                                    {rtList.length === 0 && <span className="text-slate-400">Belum ada RT terdaftar.</span>}
                                </div>
                            </div>

                            {/* RW List */}
                            <div className="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                                <div className="flex items-center justify-between">
                                    <span className="font-extrabold text-slate-900">Daftar RW Terdaftar</span>
                                    <span className="px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-800 font-extrabold text-[10px]">
                                        {rwList.length} RW Aktif
                                    </span>
                                </div>
                                <div className="flex flex-wrap gap-2 max-h-48 overflow-y-auto p-1">
                                    {rwList.map((rw, idx) => (
                                        <span key={idx} className="px-3 py-1.5 rounded-xl bg-white border border-slate-200 font-bold text-slate-800 text-xs shadow-2xs">
                                            RW {rw}
                                        </span>
                                    ))}
                                    {rwList.length === 0 && <span className="text-slate-400">Belum ada RW terdaftar.</span>}
                                </div>
                            </div>
                        </div>
                    </div>
                )}

                {/* ─── TAB 4: GATEWAYS & NOTIFIKASI ─── */}
                {activeTab === 'gateways' && (
                    <div className="space-y-5">
                        <div>
                            <h3 className="text-sm font-black text-slate-900">
                                Integrasi API Gateway & Notifikasi WhatsApp
                            </h3>
                            <p className="text-[11px] text-slate-400">
                                Konfigurasi gateway pengiriman pesan OTP, jadwal jemput armada, dan notifikasi penimbangan.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div className="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                                <div className="flex items-center justify-between">
                                    <span className="font-extrabold text-slate-900 flex items-center gap-1.5">
                                        <i className="bi bi-whatsapp text-emerald-600" />
                                        <span>WhatsApp Gateway (Fonnte)</span>
                                    </span>
                                    <span className="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px]">
                                        🟢 Live
                                    </span>
                                </div>

                                <div className="space-y-2">
                                    <label className="block text-[11px] font-bold text-slate-700">Provider Name</label>
                                    <input
                                        type="text"
                                        name="wa_provider"
                                        value={waProvider}
                                        onChange={(e) => setWaProvider(e.target.value)}
                                        className="w-full p-2.5 rounded-xl bg-white border border-slate-200 text-xs"
                                    />
                                </div>

                                <div className="space-y-2">
                                    <label className="block text-[11px] font-bold text-slate-700">API Key / Token</label>
                                    <input
                                        type="password"
                                        name="wa_api_key"
                                        value={waApiKey}
                                        onChange={(e) => setWaApiKey(e.target.value)}
                                        className="w-full p-2.5 rounded-xl bg-white border border-slate-200 text-xs font-mono"
                                    />
                                </div>
                            </div>

                            <div className="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                                <div className="flex items-center justify-between">
                                    <span className="font-extrabold text-slate-900 flex items-center gap-1.5">
                                        <i className="bi bi-cloud-arrow-up-fill text-indigo-600" />
                                        <span>Cloud Storage & Backup</span>
                                    </span>
                                    <span className="px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-800 font-extrabold text-[10px]">
                                        Aktif
                                    </span>
                                </div>

                                <div className="space-y-2">
                                    <label className="block text-[11px] font-bold text-slate-700">Cloud Storage ID</label>
                                    <input
                                        type="text"
                                        name="cloud_id"
                                        value={cloudId}
                                        onChange={(e) => setCloudId(e.target.value)}
                                        className="w-full p-2.5 rounded-xl bg-white border border-slate-200 text-xs"
                                    />
                                </div>

                                <div className="space-y-2">
                                    <label className="block text-[11px] font-bold text-slate-700">Master Live API Key</label>
                                    <input
                                        type="password"
                                        name="api_key"
                                        value={apiKey}
                                        onChange={(e) => setApiKey(e.target.value)}
                                        className="w-full p-2.5 rounded-xl bg-white border border-slate-200 text-xs font-mono"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                )}

                {/* ─── TAB 5: SAKLAR FITUR ─── */}
                {activeTab === 'features' && (
                    <div className="space-y-5">
                        <div>
                            <h3 className="text-sm font-black text-slate-900">
                                Saklar Fitur Platform (Feature Flags)
                            </h3>
                            <p className="text-[11px] text-slate-400">
                                Aktifkan atau nonaktifkan modul platform secara fleksibel tanpa memerlukan deployment ulang.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {[
                                { key: 'project_ai', label: 'AI Scan Sampah & Chatbot Edukasi', desc: 'Pemindaian jenis sampah berbasis kecerdasan buatan.' },
                                { key: 'tukar_sampah', label: 'Request Penjemputan Sampah Mandiri', desc: 'Warga dapat menjadwalkan armada jemput sampah.' },
                                { key: 'dokumen', label: 'Verifikasi Dokumen Legalitas Mitra', desc: 'Wajib upload SK, KTP, dan foto fasilitas unit.' },
                                { key: 'hak_akses', label: 'Isolasi Ketat Multi-Role & Permissions', desc: 'Pemisahan rute Super Admin vs Admin Unit vs Petugas.' },
                            ].map((f) => (
                                <div
                                    key={f.key}
                                    onClick={() => handleToggle(f.key)}
                                    className={`p-4 rounded-2xl border cursor-pointer flex items-start justify-between gap-3 transition-all ${
                                        toggles[f.key]
                                            ? 'bg-emerald-50/50 border-emerald-300'
                                            : 'bg-slate-50 border-slate-200 hover:bg-slate-100'
                                    }`}
                                >
                                    <div className="space-y-1">
                                        <p className="font-extrabold text-slate-900">{f.label}</p>
                                        <p className="text-[11px] text-slate-500">{f.desc}</p>
                                    </div>
                                    <div className="pt-0.5">
                                        <input
                                            type="checkbox"
                                            name={`toggle_${f.key}`}
                                            checked={!!toggles[f.key]}
                                            onChange={() => {}}
                                            className="w-5 h-5 text-emerald-600 rounded-md focus:ring-emerald-400"
                                        />
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                )}

                {/* Submit Action */}
                <div className="pt-6 border-t border-slate-100 flex items-center justify-between">
                    <p className="text-[11px] text-slate-400 flex items-center gap-1">
                        <i className="bi bi-shield-lock text-emerald-600" />
                        <span>Seluruh perubahan konfigurasi akan dicatat ke dalam Audit Log Sistem.</span>
                    </p>

                    <button
                        type="submit"
                        className="px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs transition-all shadow-md shadow-emerald-600/20 active:scale-95 flex items-center gap-2"
                    >
                        <i className="bi bi-floppy-fill" />
                        <span>Simpan Perubahan Konfigurasi</span>
                    </button>
                </div>
            </form>
        </div>
    );
}
