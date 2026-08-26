import React from 'react';

export default function MapFilterControls({
    statusFilter = 'all',
    onStatusChange,
    showRadius = true,
    onToggleRadius,
    searchQuery = '',
    onSearchChange,
    selectedProvinsi = '',
    onProvinsiChange,
    provinsiList = [],
    onLocateMe,
}) {
    return (
        <div className="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-sm space-y-4">
            <div className="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                {/* 1. Status Filter Pills */}
                <div className="flex flex-wrap items-center gap-2">
                    {[
                        { key: 'all', label: 'Semua Status' },
                        { key: 'aktif', label: '🟢 Aktif Saja' },
                        { key: 'libur', label: '🟡 Libur Sementara' },
                        { key: 'nonaktif', label: '🔴 Nonaktif / Suspend' },
                    ].map((s) => {
                        const isActive = statusFilter === s.key;
                        return (
                            <button
                                key={s.key}
                                type="button"
                                onClick={() => onStatusChange(s.key)}
                                className={`px-3.5 py-2 rounded-2xl text-xs font-bold transition-all ${
                                    isActive
                                        ? 'bg-slate-900 text-white shadow-xs'
                                        : 'bg-slate-100 hover:bg-slate-200 text-slate-700'
                                }`}
                            >
                                {s.label}
                            </button>
                        );
                    })}
                </div>

                {/* 2. Radius Layer Toggle, Location, Search */}
                <div className="flex flex-wrap items-center gap-3">
                    {/* Toggle Radius */}
                    <button
                        type="button"
                        onClick={() => onToggleRadius(!showRadius)}
                        className={`inline-flex items-center gap-2 px-3.5 py-2 rounded-2xl text-xs font-bold border transition-all ${
                            showRadius
                                ? 'bg-emerald-50 text-emerald-800 border-emerald-300'
                                : 'bg-slate-100 text-slate-500 border-slate-200'
                        }`}
                    >
                        <i className={`bi ${showRadius ? 'bi-check-circle-fill text-emerald-600' : 'bi-circle'}`} />
                        <span>Radius Lingkaran (Km)</span>
                    </button>

                    {/* GPS Locate Me */}
                    <button
                        type="button"
                        onClick={onLocateMe}
                        className="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors"
                        title="Deteksi Lokasi GPS Anda"
                    >
                        <i className="bi bi-crosshair" />
                        <span>Lokasi Saya</span>
                    </button>

                    {/* Province dropdown */}
                    {provinsiList.length > 0 && (
                        <select
                            value={selectedProvinsi}
                            onChange={(e) => onProvinsiChange(e.target.value)}
                            className="px-3 py-2 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-emerald-400"
                        >
                            <option value="">Semua Provinsi</option>
                            {provinsiList.map((p, idx) => (
                                <option key={idx} value={p}>
                                    {p}
                                </option>
                            ))}
                        </select>
                    )}

                    {/* Search */}
                    <div className="relative min-w-[200px]">
                        <i className="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs" />
                        <input
                            type="text"
                            value={searchQuery}
                            onChange={(e) => onSearchChange(e.target.value)}
                            placeholder="Cari lokasi di peta..."
                            className="w-full pl-8 pr-3 py-2 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-400"
                        />
                    </div>
                </div>
            </div>
        </div>
    );
}
