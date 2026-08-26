import React from 'react';
import { Clock, CheckCircle2, Scale, ArrowUpRight } from 'lucide-react';

export default function PetugasKpiStats({ 
    kpiData = {} 
}) {
    const pendingCount = kpiData?.pending_count || 0;
    const completedToday = kpiData?.completed_today || 0;
    const totalWeightToday = kpiData?.total_weight_today || 0;

    const stats = [
        {
            title: 'Jemputan Menunggu',
            value: `${pendingCount} Permintaan`,
            subtitle: 'Siap dijemput & ditimbang',
            icon: Clock,
            accentColor: 'text-amber-600',
            bgColor: 'bg-amber-50',
            borderColor: 'border-amber-200/80',
            badge: 'Antrean Aktif',
            badgeColor: 'bg-amber-100 text-amber-800 border-amber-200',
        },
        {
            title: 'Selesai Hari Ini',
            value: `${completedToday} Transaksi`,
            subtitle: 'Berhasil diproses hari ini',
            icon: CheckCircle2,
            accentColor: 'text-emerald-600',
            bgColor: 'bg-emerald-50',
            borderColor: 'border-emerald-200/80',
            badge: 'Hari Ini',
            badgeColor: 'bg-emerald-100 text-emerald-800 border-emerald-200',
        },
        {
            title: 'Total Berat Sampah',
            value: `${Number(totalWeightToday).toLocaleString('id-ID', { minimumFractionDigits: 1, maximumFractionDigits: 1 })} Kg`,
            subtitle: 'Akumulasi timbangan hari ini',
            icon: Scale,
            accentColor: 'text-blue-600',
            bgColor: 'bg-blue-50',
            borderColor: 'border-blue-200/80',
            badge: 'Terkumpul',
            badgeColor: 'bg-blue-100 text-blue-800 border-blue-200',
        },
    ];

    return (
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5 select-none">
            {stats.map((item, idx) => {
                const IconComponent = item.icon;
                return (
                    <div
                        key={idx}
                        className={`bg-white border ${item.borderColor} rounded-3xl p-5 sm:p-6 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between space-y-4`}
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
                            <h3 className="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                {item.value}
                            </h3>
                            <p className="text-xs text-slate-400 font-medium">
                                {item.subtitle}
                            </p>
                        </div>
                    </div>
                );
            })}
        </div>
    );
}
