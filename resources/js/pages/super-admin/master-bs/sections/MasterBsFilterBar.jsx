import React from 'react';

export default function MasterBsFilterBar({
    activeFilter = 'all',
    onSelectFilter,
    stats = {},
    searchQuery = '',
    onSearchChange,
    selectedProvinsi = '',
    onProvinsiChange,
    provinsiList = [],
}) {
    const tabs = [
        { key: 'all', label: 'Semua Status', count: stats.total || 0 },
        { key: 'aktif', label: 'Aktif Beroperasi', count: stats.aktif || 0 },
        { key: 'libur', label: 'Libur Sementara', count: stats.libur || 0 },
        { key: 'nonaktif', label: 'Nonaktif / Suspend', count: stats.nonaktif || 0 },
    ];

    return (
        <div className="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-sm space-y-4">
            <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
                {/* 1. Status Filter Pills */}
                <div className="flex flex-wrap items-center gap-2">
                    {tabs.map((t) => {
                        const isActive = activeFilter === t.key;
                        return (
                            <button
                                key={t.key}
                                type="button"
                                onClick={() => onSelectFilter(t.key)}
                                className={`inline-flex items-center gap-2 px-3.5 py-2 rounded-2xl text-xs font-bold transition-all ${
                                    isActive
                                        ? 'bg-slate-900 text-white shadow-xs'
                                        : 'bg-slate-100 hover:bg-slate-200/70 text-slate-700'
                                }`}
                            >
                                <span>{t.label}</span>
                                <span
                                    className={`px-2 py-0.5 rounded-full text-[10px] font-extrabold ${
                                        isActive ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700'
                                    }`}
                                >
                                    {t.count}
                                </span>
                            </button>
                        );
                    })}
                </div>

                {/* 2. Province Filter & Live Search */}
                <div className="flex flex-wrap items-center gap-3">
                    {provinsiList.length > 0 && (
                        <select
                            value={selectedProvinsi}
                            onChange={(e) => onProvinsiChange(e.target.value)}
                            className="px-3.5 py-2 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-400"
                        >
                            <option value="">Semua Provinsi</option>
                            {provinsiList.map((p, idx) => (
                                <option key={idx} value={p}>
                                    {p}
                                </option>
                            ))}
                        </select>
                    )}

                    <div className="relative min-w-[220px]">
                        <i className="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs" />
                        <input
                            type="text"
                            value={searchQuery}
                            onChange={(e) => onSearchChange(e.target.value)}
                            placeholder="Cari unit, kode, PJ..."
                            className="w-full pl-9 pr-3.5 py-2 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400"
                        />
                    </div>
                </div>
            </div>
        </div>
    );
}
