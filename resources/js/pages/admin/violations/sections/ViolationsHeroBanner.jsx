import React from 'react';
import { AlertTriangle, Plus, ShieldCheck, ShieldAlert, CheckCircle2 } from 'lucide-react';

export default function ViolationsHeroBanner({
    authData = {},
    statistics = {},
    onOpenCreate,
}) {
    const unitName = authData?.bank_sampah_name || 'Unit Melati Asri';
    const totalCases = statistics?.total_cases || 5;
    const resolvedCount = statistics?.resolved_count || 3;
    const inReviewCount = statistics?.in_review_count || 2;

    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-md p-6 sm:p-8 animate-slide-in select-none">
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

            <div className="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                
                {/* Left Side: Title & Action */}
                <div className="space-y-3 max-w-2xl">
                    <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-emerald-100">
                        <ShieldAlert className="w-4 h-4 text-amber-300" />
                        <span>Pengawasan Integritas & Kepatuhan SOP</span>
                    </div>

                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight">
                        Catatan Pelanggaran & Audit Operasional ⚠️
                    </h1>

                    <p className="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
                        Pantau kepatuhan pemilahan sampah warga binaan {unitName}, audit transaksi anomali bernilai besar, dan kelola catatan ketidakhadiran jadwal jemput.
                    </p>

                    <div className="pt-2 flex flex-wrap items-center gap-3">
                        <button
                            type="button"
                            onClick={onOpenCreate}
                            className="px-4 py-2.5 bg-white text-emerald-900 hover:bg-emerald-50 rounded-xl font-black text-xs transition-all shadow-md flex items-center gap-2 cursor-pointer hover:scale-105 active:scale-95"
                        >
                            <Plus className="w-4 h-4 text-amber-600" />
                            <span>+ Catat Kasus Pelanggaran</span>
                        </button>
                    </div>
                </div>

                {/* Right Side: Quick Stats Glass Box */}
                <div className="p-5 rounded-2xl bg-black/20 backdrop-blur-md border border-white/15 grid grid-cols-2 gap-4 shrink-0 shadow-lg min-w-[280px]">
                    <div className="space-y-1">
                        <span className="text-[10px] uppercase font-bold tracking-wider text-amber-200 flex items-center gap-1">
                            <AlertTriangle className="w-3.5 h-3.5 text-amber-300" />
                            <span>Dalam Tinjauan</span>
                        </span>
                        <p className="text-2xl sm:text-3xl font-black text-amber-300 tracking-tight">
                            {inReviewCount} Kasus
                        </p>
                        <span className="text-[10px] text-emerald-200 font-medium block">
                            Menunggu Klarifikasi
                        </span>
                    </div>

                    <div className="space-y-1">
                        <span className="text-[10px] uppercase font-bold tracking-wider text-emerald-200 flex items-center gap-1">
                            <CheckCircle2 className="w-3.5 h-3.5 text-emerald-300" />
                            <span>Selesai Ditangani</span>
                        </span>
                        <p className="text-2xl sm:text-3xl font-black text-white tracking-tight">
                            {resolvedCount} Kasus
                        </p>
                        <span className="text-[10px] text-emerald-300 font-medium block">
                            Dari {totalCases} Total Catatan
                        </span>
                    </div>

                    <div className="col-span-2 pt-2 border-t border-white/10 text-[11px] text-emerald-100 font-medium">
                        🛡️ Semua catatan terekam dalam audit trail sistem yang aman.
                    </div>
                </div>

            </div>

        </div>
    );
}
