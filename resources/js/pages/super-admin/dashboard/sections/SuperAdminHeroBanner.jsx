import React from 'react';
import { Link } from '@inertiajs/react';
import { ShieldCheck, MapPin, Award, CheckCircle2, ArrowRight } from 'lucide-react';

export default function SuperAdminHeroBanner({
    authData = {},
    statistics = {},
}) {
    const totalUnits = statistics?.total_units || 24;
    const activeUnits = statistics?.active_units || 18;
    const pendingUnits = statistics?.pending_units || 6;
    const totalCitizens = statistics?.total_citizens || 14850;

    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-br from-[#047857] via-[#115E59] to-[#0F172A] dark:from-emerald-950 dark:via-[#0c2f2c] dark:to-[#041a12] text-white shadow-md p-6 sm:p-8 animate-slide-in select-none border border-transparent dark:border-emerald-800/50">
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-amber-400/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/15 rounded-full blur-2xl pointer-events-none" />

            <div className="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                
                {/* Left Side: Title & Subtitle */}
                <div className="space-y-3 max-w-2xl">
                    <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/20 backdrop-blur-md border border-amber-300/30 text-xs font-black text-amber-200">
                        <Award className="w-4 h-4 text-amber-300" />
                        <span>👑 Pusat Komando & Pengawasan Nasional</span>
                    </div>

                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight">
                        Dashboard Agregator Bank Sampah Nasional 🇮🇩
                    </h1>

                    <p className="text-xs sm:text-sm text-emerald-100/90 dark:text-emerald-200/90 leading-relaxed">
                        Pantau pertumbuhan ekosistem ekonomi sirkular dari {totalUnits} unit bank sampah mitra se-Indonesia, audit performa unit mitra, dan kelola antrean verifikasi legalitas bank sampah baru.
                    </p>

                    {/* Quick Action Buttons */}
                    <div className="pt-2 flex flex-wrap items-center gap-3">
                        <Link
                            href="/super-admin/verifikasi-bank-sampah"
                            className="px-4 py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl font-black text-xs transition-all shadow-md flex items-center gap-2 cursor-pointer hover:scale-105 active:scale-95"
                        >
                            <ShieldCheck className="w-4 h-4 text-slate-950" />
                            <span>🛡️ Tinjau Verifikasi Mitra ({pendingUnits} Pending)</span>
                        </Link>

                        <Link
                            href="/super-admin/peta-sebaran"
                            className="px-4 py-2.5 bg-white/15 dark:bg-emerald-950/60 hover:bg-white/25 dark:hover:bg-emerald-900/80 text-white border border-white/20 dark:border-emerald-800/80 rounded-xl font-bold text-xs transition-all shadow-sm flex items-center gap-2 cursor-pointer hover:scale-105 active:scale-95"
                        >
                            <MapPin className="w-4 h-4 text-emerald-300" />
                            <span>🗺️ Buka Peta Sebaran Nasional</span>
                        </Link>
                    </div>
                </div>

                {/* Right Side: Quick Stats Glass Box */}
                <div className="p-5 rounded-2xl bg-black/30 dark:bg-black/50 backdrop-blur-md border border-white/15 dark:border-emerald-800/40 grid grid-cols-2 gap-4 shrink-0 shadow-lg min-w-[280px]">
                    <div className="space-y-1">
                        <span className="text-[10px] uppercase font-bold tracking-wider text-amber-200 flex items-center gap-1">
                            <ShieldCheck className="w-3.5 h-3.5 text-amber-300" />
                            <span>Unit Aktif</span>
                        </span>
                        <p className="text-2xl sm:text-3xl font-black text-white tracking-tight">
                            {activeUnits} Unit
                        </p>
                        <span className="text-[10px] text-emerald-300 font-medium block">
                            Dari {totalUnits} Bank Sampah
                        </span>
                    </div>

                    <div className="space-y-1">
                        <span className="text-[10px] uppercase font-bold tracking-wider text-emerald-200 flex items-center gap-1">
                            <CheckCircle2 className="w-3.5 h-3.5 text-emerald-300" />
                            <span>Partisipasi Warga</span>
                        </span>
                        <p className="text-2xl sm:text-3xl font-black text-white tracking-tight">
                            {totalCitizens.toLocaleString('id-ID')}
                        </p>
                        <span className="text-[10px] text-emerald-300 font-medium block">
                            Nasabah Terdaftar
                        </span>
                    </div>

                    <div className="col-span-2 pt-2 border-t border-white/10 dark:border-emerald-800/40 text-[11px] text-emerald-100 font-medium">
                        👑 Terintegrasi dengan 5 Wilayah Kota/Kabupaten Binaan.
                    </div>
                </div>

            </div>

        </div>
    );
}
