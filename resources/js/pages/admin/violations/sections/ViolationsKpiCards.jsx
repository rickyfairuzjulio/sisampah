import React from 'react';
import { AlertTriangle, ShieldAlert, Clock, CheckCircle2 } from 'lucide-react';

export default function ViolationsKpiCards({
    statistics = {},
}) {
    const total = statistics?.total_cases || 5;
    const suspicious = statistics?.suspicious_count || 2;
    const inReview = statistics?.in_review_count || 2;
    const resolved = statistics?.resolved_count || 3;

    const cards = [
        {
            title: 'Total Kasus Terdata',
            value: `${total} Catatan`,
            subtitle: 'Bulan berjalan (Agustus 2026)',
            icon: AlertTriangle,
            accentColor: 'text-amber-600',
            bgColor: 'bg-amber-50',
            borderColor: 'border-amber-200/80',
            badge: 'Bulan Ini',
            badgeColor: 'bg-amber-100 text-amber-800 border-amber-200',
        },
        {
            title: 'Transaksi Anomali',
            value: `${suspicious} Transaksi`,
            subtitle: 'Bobot >100kg atau nilai >Rp 1 Juta',
            icon: ShieldAlert,
            accentColor: 'text-rose-600',
            bgColor: 'bg-rose-50',
            borderColor: 'border-rose-200/80',
            badge: 'Perlu Validasi',
            badgeColor: 'bg-rose-100 text-rose-800 border-rose-200',
        },
        {
            title: 'Dalam Proses Tinjauan',
            value: `${inReview} Kasus`,
            subtitle: 'Menunggu konfirmasi nasabah / pos',
            icon: Clock,
            accentColor: 'text-orange-600',
            bgColor: 'bg-orange-50',
            borderColor: 'border-orange-200/80',
            badge: 'Pending',
            badgeColor: 'bg-orange-100 text-orange-800 border-orange-200',
        },
        {
            title: 'Selesai Ditindaklanjuti',
            value: `${resolved} Kasus`,
            subtitle: 'Telah diberikan pembinaan & sanksi',
            icon: CheckCircle2,
            accentColor: 'text-emerald-600',
            bgColor: 'bg-emerald-50',
            borderColor: 'border-emerald-200/80',
            badge: 'Tertangani',
            badgeColor: 'bg-emerald-100 text-emerald-800 border-emerald-200',
        },
    ];

    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 select-none">
            {cards.map((item, idx) => {
                const IconComponent = item.icon;
                return (
                    <div
                        key={idx}
                        className={`bg-white border ${item.borderColor} rounded-3xl p-5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between space-y-4`}
                    >
                        <div className="flex items-center justify-between">
                            <div className={`w-11 h-11 rounded-2xl flex items-center justify-center font-bold ${item.bgColor} ${item.accentColor} shadow-2xs`}>
                                <IconComponent className="w-5 h-5" />
                            </div>
                            <span className={`px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border ${item.badgeColor}`}>
                                {item.badge}
                            </span>
                        </div>

                        <div className="space-y-1">
                            <p className="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {item.title}
                            </p>
                            <h3 className="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                                {item.value}
                            </h3>
                            <p className="text-xs text-slate-400 font-medium truncate">
                                {item.subtitle}
                            </p>
                        </div>
                    </div>
                );
            })}
        </div>
    );
}
