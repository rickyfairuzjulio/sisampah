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
            accentColor: 'text-amber-600 dark:text-amber-400',
            bgColor: 'bg-amber-50 dark:bg-amber-950/60',
            borderColor: 'border-amber-200/80 dark:border-amber-800/60',
            badge: 'Antrean Aktif',
            badgeColor: 'bg-amber-100 dark:bg-amber-900/60 text-amber-800 dark:text-amber-300 border-amber-200 dark:border-amber-800',
        },
        {
            title: 'Selesai Hari Ini',
            value: `${completedToday} Transaksi`,
            subtitle: 'Berhasil diproses hari ini',
            icon: CheckCircle2,
            accentColor: 'text-emerald-600 dark:text-emerald-400',
            bgColor: 'bg-emerald-50 dark:bg-emerald-950/60',
            borderColor: 'border-emerald-200/80 dark:border-emerald-800/60',
            badge: 'Hari Ini',
            badgeColor: 'bg-emerald-100 dark:bg-emerald-900/60 text-emerald-800 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800',
        },
        {
            title: 'Total Berat Sampah',
            value: `${Number(totalWeightToday).toLocaleString('id-ID', { minimumFractionDigits: 1, maximumFractionDigits: 1 })} Kg`,
            subtitle: 'Akumulasi timbangan hari ini',
            icon: Scale,
            accentColor: 'text-blue-600 dark:text-blue-400',
            bgColor: 'bg-blue-50 dark:bg-blue-950/60',
            borderColor: 'border-blue-200/80 dark:border-blue-800/60',
            badge: 'Terkumpul',
            badgeColor: 'bg-blue-100 dark:bg-blue-900/60 text-blue-800 dark:text-blue-300 border-blue-200 dark:border-blue-800',
        },
    ];

    return (
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5 select-none">
            {stats.map((item, idx) => {
                const IconComponent = item.icon;
                return (
                    <div
                        key={idx}
                        className={`bg-white dark:bg-[#111827] border ${item.borderColor} rounded-3xl p-5 sm:p-6 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between space-y-4`}
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
                            <p className="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                {item.title}
                            </p>
                            <h3 className="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                                {item.value}
                            </h3>
                            <p className="text-xs text-slate-400 dark:text-slate-500 font-medium">
                                {item.subtitle}
                            </p>
                        </div>
                    </div>
                );
            })}
        </div>
    );
}
