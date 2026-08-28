import React from 'react';
import { ArrowDownLeft, CheckCircle2, Clock } from 'lucide-react';

export default function WalletSummaryKpi({ walletStats = {} }) {
    const formatCurrency = (val) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(val || 0);
    };

    const cards = [
        {
            title: 'Total Pemasukan Sampah',
            value: formatCurrency(walletStats.total_pemasukan || 0),
            subtitle: 'Akumulasi rupiah dari penjualan sampah',
            icon: ArrowDownLeft,
            bgIcon: 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800/80',
        },
        {
            title: 'Total Saldo Ditarik',
            value: formatCurrency(walletStats.total_ditarik || 0),
            subtitle: 'Dana sukses dicairkan ke rekening/tunai',
            icon: CheckCircle2,
            bgIcon: 'bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border-blue-200 dark:border-blue-800/80',
        },
        {
            title: 'Penarikan Dalam Proses',
            value: formatCurrency(walletStats.penarikan_pending || 0),
            subtitle: 'Sedang diverifikasi oleh bendahara unit',
            icon: Clock,
            bgIcon: 'bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-800/80',
        },
    ];

    return (
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5 select-none">
            {cards.map((card, idx) => {
                const IconComponent = card.icon;
                return (
                    <div
                        key={idx}
                        className="bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-3xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all space-y-3"
                    >
                        <div className="flex items-center justify-between">
                            <span className="text-xs font-bold text-slate-500 dark:text-slate-400 line-clamp-1">
                                {card.title}
                            </span>
                            <div className={`w-10 h-10 rounded-2xl border flex items-center justify-center font-bold shrink-0 shadow-2xs ${card.bgIcon}`}>
                                <IconComponent className="w-5 h-5" />
                            </div>
                        </div>

                        <div>
                            <div className="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                                {card.value}
                            </div>
                            <p className="text-[11px] text-slate-400 dark:text-slate-500 font-medium mt-1">
                                {card.subtitle}
                            </p>
                        </div>
                    </div>
                );
            })}
        </div>
    );
}
