import React from 'react';
import { Building2, Users, Scale, Coins } from 'lucide-react';

export default function SuperAdminKpiCards({
    statistics = {},
}) {
    const totalUnits = statistics?.total_units || 24;
    const activeUnits = statistics?.active_units || 18;
    const pendingUnits = statistics?.pending_units || 6;
    const totalCitizens = statistics?.total_citizens || 14850;
    const totalWaste = statistics?.total_waste_tons || '1.240,5 Ton';
    const circularTurnover = statistics?.circular_turnover_formatted || 'Rp 3,85 Miliar';

    const cards = [
        {
            title: 'Bank Sampah Mitra',
            value: `${totalUnits} Unit`,
            subtitle: `${activeUnits} Aktif Beroperasi • ${pendingUnits} Verifikasi`,
            icon: Building2,
            accentColor: 'text-amber-600',
            bgColor: 'bg-amber-50',
            borderColor: 'border-amber-200/80',
            badge: 'Mitra Nasional',
            badgeColor: 'bg-amber-100 text-amber-900 border-amber-300',
        },
        {
            title: 'Total Warga Nasabah',
            value: `${totalCitizens.toLocaleString('id-ID')} Warga`,
            subtitle: 'Tersebar di 5 Wilayah Binaan',
            icon: Users,
            accentColor: 'text-blue-600',
            bgColor: 'bg-blue-50',
            borderColor: 'border-blue-200/80',
            badge: 'Populasi Aktif',
            badgeColor: 'bg-blue-100 text-blue-800 border-blue-200',
        },
        {
            title: 'Sampah Daur Ulang Nasional',
            value: totalWaste,
            subtitle: 'Teralihkan dari Tempat Pembuangan Akhir',
            icon: Scale,
            accentColor: 'text-emerald-600',
            bgColor: 'bg-emerald-50',
            borderColor: 'border-emerald-200/80',
            badge: 'Dampak Ekologis',
            badgeColor: 'bg-emerald-100 text-emerald-800 border-emerald-200',
        },
        {
            title: 'Perputaran Uang Sirkular',
            value: circularTurnover,
            subtitle: 'Total manfaat ekonomi masyarakat',
            icon: Coins,
            accentColor: 'text-teal-600',
            bgColor: 'bg-teal-50',
            borderColor: 'border-teal-200/80',
            badge: 'Nilai Transaksi',
            badgeColor: 'bg-teal-100 text-teal-800 border-teal-200',
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
