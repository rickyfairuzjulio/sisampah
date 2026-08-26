import React from 'react';

export default function MapKpiCards({ gisStats = {} }) {
    const kpis = [
        {
            label: 'Total Titik Terplot',
            value: gisStats.total_units || 24,
            unit: 'Lokasi Fisik',
            desc: 'Unit terdaftar resmi se-Indonesia',
            icon: 'bi-geo-alt-fill',
            color: 'text-sky-600 bg-sky-50 border-sky-200',
        },
        {
            label: 'Total Cakupan Wilayah',
            value: `~${gisStats.total_coverage_km2 || 485.4}`,
            unit: 'Km² Total',
            desc: 'Akumulasi radius layanan armada',
            icon: 'bi-globe-americas',
            color: 'text-teal-600 bg-teal-50 border-teal-200',
        },
        {
            label: 'Estimasi Warga Terjangkau',
            value: (gisStats.total_citizens_covered || 14850).toLocaleString('id-ID'),
            unit: 'Warga',
            desc: 'Dalam radius operasional aktif',
            icon: 'bi-people-fill',
            color: 'text-indigo-600 bg-indigo-50 border-indigo-200',
        },
        {
            label: 'Unit Aktif Buka Hari Ini',
            value: gisStats.active_units || 18,
            unit: 'Lokasi Buka',
            desc: 'Siap melayani setoran & jemput',
            icon: 'bi-check-circle-fill',
            color: 'text-emerald-600 bg-emerald-50 border-emerald-200',
        },
    ];

    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {kpis.map((kpi, idx) => (
                <div
                    key={idx}
                    className="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-3"
                >
                    <div className="flex items-center justify-between">
                        <span className="text-xs font-bold text-slate-500">{kpi.label}</span>
                        <div className={`w-8 h-8 rounded-xl flex items-center justify-center text-sm border ${kpi.color}`}>
                            <i className={`bi ${kpi.icon}`} />
                        </div>
                    </div>

                    <div className="flex items-baseline gap-1.5">
                        <span className="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                            {kpi.value}
                        </span>
                        {kpi.unit && <span className="text-xs font-bold text-slate-400">{kpi.unit}</span>}
                    </div>

                    <p className="text-[11px] text-slate-400 font-medium">
                        {kpi.desc}
                    </p>
                </div>
            ))}
        </div>
    );
}
