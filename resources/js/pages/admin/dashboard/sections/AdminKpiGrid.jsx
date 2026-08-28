import React from 'react';
import { Users, Truck, Scale, Banknote, TrendingUp } from 'lucide-react';

export default function AdminKpiGrid({
    metrics = {},
}) {
    const countNasabah = metrics?.count_nasabah || 1240;
    const countPetugas = metrics?.count_petugas || 8;
    const totalBerat = metrics?.total_berat || 45820.5;
    const totalPendapatan = metrics?.total_pendapatan || 137460000;

    const cards = [
        {
            title: 'Nasabah Terdaftar',
            value: `${Number(countNasabah).toLocaleString('id-ID')} Warga`,
            subtitle: 'Warga aktif bertransaksi di unit',
            icon: Users,
            accentColor: 'text-blue-600 dark:text-blue-400',
            bgColor: 'bg-blue-50 dark:bg-blue-950/60',
            borderColor: 'border-blue-200/80 dark:border-blue-800/60',
            badge: 'Warga Unit',
            badgeColor: 'bg-blue-100 dark:bg-blue-900/60 text-blue-800 dark:text-blue-300 border-blue-200 dark:border-blue-800',
        },
        {
            title: 'Petugas & Armada',
            value: `${countPetugas} Petugas`,
            subtitle: 'Armada jemput & teller aktif',
            icon: Truck,
            accentColor: 'text-amber-600 dark:text-amber-400',
            bgColor: 'bg-amber-50 dark:bg-amber-950/60',
            borderColor: 'border-amber-200/80 dark:border-amber-800/60',
            badge: 'Operasional',
            badgeColor: 'bg-amber-100 dark:bg-amber-900/60 text-amber-800 dark:text-amber-300 border-amber-200 dark:border-amber-800',
        },
        {
            title: 'Volume Sampah Kelolaan',
            value: `${Number(totalBerat).toLocaleString('id-ID', { minimumFractionDigits: 1, maximumFractionDigits: 1 })} Kg`,
            subtitle: 'Total tonase sampah terkelola',
            icon: Scale,
            accentColor: 'text-emerald-600 dark:text-emerald-400',
            bgColor: 'bg-emerald-50 dark:bg-emerald-950/60',
            borderColor: 'border-emerald-200/80 dark:border-emerald-800/60',
            badge: 'Tonase Riil',
            badgeColor: 'bg-emerald-100 dark:bg-emerald-900/60 text-emerald-800 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800',
        },
        {
            title: 'Perputaran Transaksi',
            value: `Rp ${(totalPendapatan / 1000000).toFixed(1)} Juta`,
            subtitle: `Rp ${Number(totalPendapatan).toLocaleString('id-ID')} disalurkan`,
            icon: Banknote,
            accentColor: 'text-teal-600 dark:text-teal-400',
            bgColor: 'bg-teal-50 dark:bg-teal-950/60',
            borderColor: 'border-teal-200/80 dark:border-teal-800/60',
            badge: 'Sirkulasi Nilai',
            badgeColor: 'bg-teal-100 dark:bg-teal-900/60 text-teal-800 dark:text-teal-300 border-teal-200 dark:border-teal-800',
        },
    ];

    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 select-none">
            {cards.map((item, idx) => {
                const IconComponent = item.icon;
                return (
                    <div
                        key={idx}
                        className={`bg-white dark:bg-[#111827] border ${item.borderColor} rounded-3xl p-5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between space-y-4`}
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
                            <h3 className="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                                {item.value}
                            </h3>
                            <p className="text-xs text-slate-400 dark:text-slate-500 font-medium truncate">
                                {item.subtitle}
                            </p>
                        </div>
                    </div>
                );
            })}
        </div>
    );
}
