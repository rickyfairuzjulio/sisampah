import React from 'react';

export default function MasterBsKpiCards({
    stats = {},
    activeFilter = 'all',
    onSelectFilter,
}) {
    const kpis = [
        {
            key: 'all',
            label: 'Total Unit Terdaftar',
            value: stats.total || 0,
            unit: 'Unit',
            subtitle: 'Seluruh mitra resmi se-Indonesia',
            icon: 'bi-building-fill',
            color: 'text-sky-600 bg-sky-50 border-sky-200',
            activeRing: 'ring-sky-500 border-sky-400 bg-sky-50/50',
        },
        {
            key: 'aktif',
            label: 'Unit Aktif Beroperasi',
            value: stats.aktif || 0,
            unit: 'Unit',
            subtitle: 'Melayani setoran & jemput warga',
            icon: 'bi-check-circle-fill',
            color: 'text-emerald-600 bg-emerald-50 border-emerald-200',
            activeRing: 'ring-emerald-500 border-emerald-400 bg-emerald-50/50',
        },
        {
            key: 'libur',
            label: 'Libur / Tutup Sementara',
            value: stats.libur || 0,
            unit: 'Unit',
            subtitle: 'Pemeliharaan gudang / libur berkala',
            icon: 'bi-pause-circle-fill',
            color: 'text-amber-600 bg-amber-50 border-amber-200',
            activeRing: 'ring-amber-500 border-amber-400 bg-amber-50/50',
        },
        {
            key: 'nonaktif',
            label: 'Nonaktif / Ditangguhkan',
            value: stats.nonaktif || 0,
            unit: 'Unit',
            subtitle: 'Evaluasi khusus / audit pelanggaran',
            icon: 'bi-slash-circle-fill',
            color: 'text-rose-600 bg-rose-50 border-rose-200',
            activeRing: 'ring-rose-500 border-rose-400 bg-rose-50/50',
        },
    ];

    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {kpis.map((kpi) => {
                const isActive = activeFilter === kpi.key;
                return (
                    <button
                        key={kpi.key}
                        type="button"
                        onClick={() => onSelectFilter && onSelectFilter(kpi.key)}
                        className={`p-5 rounded-3xl bg-white border text-left transition-all duration-200 hover:shadow-md active:scale-98 ${
                            isActive
                                ? `ring-2 shadow-sm ${kpi.activeRing}`
                                : 'border-slate-200/80 hover:border-slate-300'
                        }`}
                    >
                        <div className="flex items-center justify-between">
                            <span className="text-xs font-bold text-slate-500">{kpi.label}</span>
                            <div className={`w-8 h-8 rounded-xl flex items-center justify-center text-sm border ${kpi.color}`}>
                                <i className={`bi ${kpi.icon}`} />
                            </div>
                        </div>

                        <div className="mt-3 flex items-baseline gap-1.5">
                            <span className="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                {kpi.value}
                            </span>
                            <span className="text-xs font-bold text-slate-400">{kpi.unit}</span>
                        </div>

                        <p className="mt-1 text-[11px] text-slate-500 font-medium truncate">
                            {kpi.subtitle}
                        </p>
                    </button>
                );
            })}
        </div>
    );
}
