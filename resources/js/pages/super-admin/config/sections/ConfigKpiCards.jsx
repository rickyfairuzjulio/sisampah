import React from 'react';

export default function ConfigKpiCards({ configStats = {} }) {
    const kpis = [
        {
            label: 'Default Radius Layanan',
            value: `${((configStats.default_radius_m || 3000) / 1000).toFixed(1)} Km`,
            unit: `(${configStats.default_radius_m || 3000} m)`,
            desc: 'Acuan radius standar armada',
            icon: 'bi-broadcast-pin',
            color: 'text-sky-600 bg-sky-50 border-sky-200',
        },
        {
            label: 'Min. Penarikan Saldo',
            value: `Rp ${(configStats.min_withdrawal_rp || 10000).toLocaleString('id-ID')}`,
            unit: '',
            desc: 'Ambang batas dompet nasabah',
            icon: 'bi-wallet-fill',
            color: 'text-emerald-600 bg-emerald-50 border-emerald-200',
        },
        {
            label: 'Cakupan Wilayah Aktif',
            value: `${configStats.active_cities_count || 12}`,
            unit: 'Kota/Kabupaten',
            desc: 'Tersebar di 5 Provinsi utama',
            icon: 'bi-geo-alt-fill',
            color: 'text-indigo-600 bg-indigo-50 border-indigo-200',
        },
        {
            label: 'Gateway WhatsApp API',
            value: 'Terhubung',
            unit: 'Live',
            desc: 'Fonnte Notification Active',
            icon: 'bi-whatsapp',
            color: 'text-teal-600 bg-teal-50 border-teal-200',
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
