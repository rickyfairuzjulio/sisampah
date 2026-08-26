import React from 'react';

export default function VerificationKpiCards({ stats = {}, activeFilter = 'all', onSelectFilter }) {
    const kpiItems = [
        {
            key: 'submitted',
            label: 'Permohonan Baru',
            count: stats.total_submitted || 0,
            unit: 'Unit',
            subtitle: 'Menunggu peninjauan berkas SK & KTP',
            icon: 'bi-inbox-fill',
            color: 'from-sky-500 to-blue-600',
            bgColor: 'bg-sky-50',
            textColor: 'text-sky-700',
            borderColor: 'border-sky-200',
            badgeBg: 'bg-sky-100 text-sky-800',
        },
        {
            key: 'under_review',
            label: 'Sedang Ditinjau',
            count: stats.under_review || 0,
            unit: 'Unit',
            subtitle: 'Proses review berkas & revisi',
            icon: 'bi-search',
            color: 'from-amber-500 to-orange-600',
            bgColor: 'bg-amber-50',
            textColor: 'text-amber-700',
            borderColor: 'border-amber-200',
            badgeBg: 'bg-amber-100 text-amber-800',
        },
        {
            key: 'meeting_scheduled',
            label: 'Jadwal Pertemuan',
            count: stats.meeting_scheduled || 0,
            unit: 'Unit',
            subtitle: 'Terjadwal visitasi & wawancara',
            icon: 'bi-calendar-check-fill',
            color: 'from-indigo-500 to-violet-600',
            bgColor: 'bg-indigo-50',
            textColor: 'text-indigo-700',
            borderColor: 'border-indigo-200',
            badgeBg: 'bg-indigo-100 text-indigo-800',
        },
        {
            key: 'verified',
            label: 'Telah Terverifikasi',
            count: stats.verified || 0,
            unit: 'Unit',
            subtitle: 'Lolos akreditasi & aktif beroperasi',
            icon: 'bi-patch-check-fill',
            color: 'from-emerald-500 to-teal-600',
            bgColor: 'bg-emerald-50',
            textColor: 'text-emerald-700',
            borderColor: 'border-emerald-200',
            badgeBg: 'bg-emerald-100 text-emerald-800',
        },
    ];

    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {kpiItems.map((item) => {
                const isSelected = activeFilter === item.key;
                return (
                    <div
                        key={item.key}
                        onClick={() => onSelectFilter && onSelectFilter(item.key)}
                        className={`group relative overflow-hidden rounded-3xl p-6 bg-white border transition-all duration-300 cursor-pointer shadow-sm hover:shadow-lg ${
                            isSelected
                                ? 'border-emerald-500 ring-2 ring-emerald-500/20 bg-emerald-50/20 shadow-md'
                                : 'border-slate-200/80 hover:border-slate-300'
                        }`}
                    >
                        <div className="flex items-center justify-between mb-4">
                            <div className={`w-12 h-12 rounded-2xl flex items-center justify-center bg-gradient-to-br ${item.color} text-white shadow-md shadow-slate-900/10 group-hover:scale-105 transition-transform duration-200`}>
                                <i className={`bi ${item.icon} text-xl`} />
                            </div>
                            <span className={`text-[11px] font-extrabold px-2.5 py-1 rounded-full ${item.badgeBg}`}>
                                {item.unit}
                            </span>
                        </div>

                        <div className="space-y-1">
                            <p className="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {item.label}
                            </p>
                            <div className="flex items-baseline gap-2">
                                <span className="text-3xl font-black text-slate-900 tracking-tight">
                                    {item.count}
                                </span>
                                <span className="text-xs font-semibold text-slate-400">mitra</span>
                            </div>
                            <p className="text-xs text-slate-500 pt-1 leading-snug">
                                {item.subtitle}
                            </p>
                        </div>

                        {/* Bottom Active Pill Indicator */}
                        {isSelected && (
                            <div className="absolute bottom-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-500 to-teal-500" />
                        )}
                    </div>
                );
            })}
        </div>
    );
}
