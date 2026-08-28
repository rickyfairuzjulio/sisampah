import React from 'react';
import { Link } from '@inertiajs/react';
import { 
    Wallet, 
    ArrowUpRight, 
    Scale, 
    Star, 
    ArrowLeftRight, 
    Truck, 
    Tag, 
    BookOpen,
    Coins
} from 'lucide-react';

export default function WalletAndKpiSection({ kpiData = {} }) {
    const saldo = kpiData?.saldo || 0;
    const saldoFormatted = kpiData?.saldo_formatted || 'Rp 0';
    const totalBerat = kpiData?.total_berat || 0;
    const totalPoin = kpiData?.total_poin || 0;
    const totalTrx = kpiData?.total_transaksi || 0;

    const formatNumber = (num) => new Intl.NumberFormat('id-ID').format(num);

    const quickActions = [
        {
            title: 'Jemput',
            subtitle: 'GPS & Jadwal',
            icon: Truck,
            href: '/nasabah/jemput-sampah',
            color: 'emerald',
        },
        {
            title: 'Katalog',
            subtitle: 'Harga Acuan',
            icon: Tag,
            href: '/nasabah/prices',
            color: 'emerald',
        },
        {
            title: 'Dompet',
            subtitle: 'Kas & Riwayat',
            icon: Wallet,
            href: '/nasabah/dompet',
            color: 'emerald',
        },
        {
            title: 'Edukasi',
            subtitle: 'Tips Mandiri',
            icon: BookOpen,
            href: '/nasabah/edukasi',
            color: 'emerald',
        },
    ];

    return (
        <section className="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            
            {/* 1. Saldo Card SiSampah Pay (5 Kolom Desktop) */}
            <div className="lg:col-span-5 rounded-2xl bg-gradient-to-br from-emerald-600 via-emerald-700 to-[#0D4A35] dark:from-emerald-950 dark:via-[#093526] dark:to-[#041a12] p-6 text-white flex flex-col justify-between shadow-sm relative overflow-hidden border border-transparent dark:border-emerald-800/50">
                
                {/* Decorative glow */}
                <div className="absolute top-0 right-0 w-48 h-48 bg-white/10 dark:bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

                <div className="flex justify-between items-start mb-6 relative z-10">
                    <div>
                        <div className="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/15 dark:bg-emerald-500/20 backdrop-blur-md text-[11px] font-bold text-emerald-100 dark:text-emerald-300 mb-2 border border-white/10 dark:border-emerald-500/30">
                            <Coins className="w-3 h-3" />
                            <span>SiSampah Pay</span>
                        </div>
                        <p className="text-emerald-100/90 dark:text-emerald-200/80 text-xs font-medium">Total Saldo Kas Anda</p>
                        <h3 className="text-2xl sm:text-3xl font-black tracking-tight mt-1 text-white">
                            {saldoFormatted}
                        </h3>
                    </div>

                    <div className="w-10 h-10 rounded-xl bg-white/15 dark:bg-emerald-500/20 backdrop-blur-md flex items-center justify-center border border-white/20 dark:border-emerald-500/30">
                        <Wallet className="w-5 h-5 text-white" />
                    </div>
                </div>

                <div className="flex items-center justify-between mt-auto pt-4 border-t border-white/15 dark:border-emerald-800/40 relative z-10">
                    <span className="text-xs font-semibold text-emerald-100/90 dark:text-emerald-300">
                        Dompet Lingkungan Digital
                    </span>
                    <Link
                        href="/nasabah/dompet"
                        className="inline-flex items-center gap-1.5 px-4 py-2 bg-white dark:bg-emerald-500 text-emerald-800 dark:text-slate-950 text-xs font-bold rounded-xl hover:bg-emerald-50 dark:hover:bg-emerald-400 transition-all shadow-sm hover:scale-105"
                    >
                        <span>Tarik Dana</span>
                        <ArrowUpRight className="w-3.5 h-3.5" />
                    </Link>
                </div>

            </div>

            {/* 2. Mini KPI & Quick Actions (7 Kolom Desktop) */}
            <div className="lg:col-span-7 flex flex-col gap-4 justify-between">
                
                {/* 3 Mini KPI Tiles */}
                <div className="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                    
                    {/* Tile 1: Total Berat */}
                    <div className="bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-xl p-4 flex items-center gap-3.5 shadow-sm transition-colors duration-200">
                        <div className="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 border border-emerald-100 dark:border-emerald-800/60">
                            <Scale className="w-5 h-5" />
                        </div>
                        <div className="min-w-0">
                            <p className="text-base sm:text-lg font-black text-slate-900 dark:text-white leading-tight truncate">
                                {totalBerat.toFixed(1)} <span className="text-xs font-bold text-slate-500 dark:text-slate-400">Kg</span>
                            </p>
                            <p className="text-xs font-medium text-slate-500 dark:text-slate-400">Total Setor</p>
                        </div>
                    </div>

                    {/* Tile 2: Total Poin */}
                    <div className="bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-xl p-4 flex items-center gap-3.5 shadow-sm transition-colors duration-200">
                        <div className="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0 border border-amber-100 dark:border-amber-800/60">
                            <Star className="w-5 h-5" />
                        </div>
                        <div className="min-w-0">
                            <p className="text-base sm:text-lg font-black text-slate-900 dark:text-white leading-tight truncate">
                                {formatNumber(totalPoin)}
                            </p>
                            <p className="text-xs font-medium text-slate-500 dark:text-slate-400">Poin Lingkungan</p>
                        </div>
                    </div>

                    {/* Tile 3: Transaksi Selesai */}
                    <div className="bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-xl p-4 flex items-center gap-3.5 shadow-sm transition-colors duration-200">
                        <div className="w-10 h-10 rounded-xl bg-teal-50 dark:bg-teal-950/60 text-teal-600 dark:text-teal-400 flex items-center justify-center shrink-0 border border-teal-100 dark:border-teal-800/60">
                            <ArrowLeftRight className="w-5 h-5" />
                        </div>
                        <div className="min-w-0">
                            <p className="text-base sm:text-lg font-black text-slate-900 dark:text-white leading-tight truncate">
                                {totalTrx}
                            </p>
                            <p className="text-xs font-medium text-slate-500 dark:text-slate-400">Transaksi</p>
                        </div>
                    </div>

                </div>

                {/* 4 Quick Actions */}
                <div className="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                    {quickActions.map((action, idx) => {
                        const Icon = action.icon;
                        return (
                            <Link
                                key={idx}
                                href={action.href}
                                className="bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-xl p-3.5 sm:p-4 flex flex-col items-center justify-center text-center hover:border-emerald-500 dark:hover:border-emerald-500 hover:shadow-md transition-all group shadow-sm"
                            >
                                <div className="w-10 h-10 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900 transition-all border border-emerald-100 dark:border-emerald-800/60">
                                    <Icon className="w-5 h-5" />
                                </div>
                                <p className="font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-200 group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">
                                    {action.title}
                                </p>
                                <p className="text-[10px] text-slate-400 dark:text-slate-500 font-medium hidden sm:block mt-0.5">
                                    {action.subtitle}
                                </p>
                            </Link>
                        );
                    })}
                </div>

            </div>

        </section>
    );
}
