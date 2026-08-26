import React from 'react';

export default function AuditLogsKpiCards({
    auditStats = {},
    activeCategory = 'all',
    onSelectCategory,
}) {
    const kpis = [
        {
            key: 'all',
            label: 'Total Aktivitas Terekam',
            value: (auditStats.total_logs || 1420).toLocaleString('id-ID'),
            unit: 'Log Event',
            desc: 'Rekam jejak mutasi data penuh',
            icon: 'bi-journal-code',
            color: 'text-sky-600 bg-sky-50 border-sky-200',
            activeRing: 'ring-sky-500 border-sky-400 bg-sky-50/50',
        },
        {
            key: 'auth',
            label: 'Otorisasi & Akreditasi',
            value: auditStats.auth_events || 28,
            unit: 'Aksi Mitra',
            desc: 'Verifikasi & persetujuan unit',
            icon: 'bi-shield-check',
            color: 'text-emerald-600 bg-emerald-50 border-emerald-200',
            activeRing: 'ring-emerald-500 border-emerald-400 bg-emerald-50/50',
        },
        {
            key: 'finance',
            label: 'Mutasi Finansial & Kas',
            value: (auditStats.finance_events || 342).toLocaleString('id-ID'),
            unit: 'Transaksi',
            desc: 'Validasi & pencairan saldo',
            icon: 'bi-cash-stack',
            color: 'text-amber-600 bg-amber-50 border-amber-200',
            activeRing: 'ring-amber-500 border-amber-400 bg-amber-50/50',
        },
        {
            key: 'config',
            label: 'Perubahan Parameter',
            value: auditStats.config_events || 19,
            unit: 'Mutasi',
            desc: 'Harga & konfigurasi sistem',
            icon: 'bi-sliders',
            color: 'text-indigo-600 bg-indigo-50 border-indigo-200',
            activeRing: 'ring-indigo-500 border-indigo-400 bg-indigo-50/50',
        },
    ];

    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {kpis.map((kpi) => {
                const isActive = activeCategory === kpi.key;
                return (
                    <button
                        key={kpi.key}
                        type="button"
                        onClick={() => onSelectCategory && onSelectCategory(kpi.key)}
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
                            {kpi.desc}
                        </p>
                    </button>
                );
            })}
        </div>
    );
}
