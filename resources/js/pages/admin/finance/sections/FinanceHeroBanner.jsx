import React from 'react';
import { Wallet, Plus, ShieldCheck, ArrowUpRight, CheckCircle2, TrendingUp } from 'lucide-react';

export default function FinanceHeroBanner({
    authData = {},
    treasury = {},
    onOpenTopUp,
}) {
    const unitName = authData?.bank_sampah_name || 'Unit Melati Asri';
    const kasUnit = treasury?.kas_unit_formatted || 'Rp 18.750.000';
    const healthRatio = treasury?.health_ratio || '132%';
    const healthStatus = treasury?.health_status || 'SANGAT SEHAT';

    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-md p-6 sm:p-8 animate-slide-in select-none">
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

            <div className="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                
                {/* Left Side: Unit Info & Title */}
                <div className="space-y-3 max-w-2xl">
                    <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-emerald-100">
                        <Wallet className="w-4 h-4 text-emerald-200" />
                        <span>Perbendaharaan & Kas Operasional Unit</span>
                    </div>

                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight">
                        Kas Operasional & Keuangan {unitName} 💳
                    </h1>

                    <p className="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
                        Kelola likuiditas kas operasional unit, lakukan top-up modal kas, dan setujui permohonan penarikan tabungan warga nasabah secara transparan.
                    </p>

                    {/* Quick Action Button */}
                    <div className="pt-2 flex items-center gap-3">
                        <button
                            type="button"
                            onClick={onOpenTopUp}
                            className="px-4 py-2.5 bg-white text-emerald-900 hover:bg-emerald-50 rounded-xl font-black text-xs transition-all shadow-md flex items-center gap-2 cursor-pointer hover:scale-105 active:scale-95"
                        >
                            <Plus className="w-4 h-4 text-emerald-600" />
                            <span>+ Top-Up Modal Kas Unit</span>
                        </button>
                    </div>
                </div>

                {/* Right Side: Cash Position Card */}
                <div className="p-5 rounded-2xl bg-black/20 backdrop-blur-md border border-white/15 flex flex-col justify-between gap-4 shrink-0 shadow-lg min-w-[280px]">
                    <div className="space-y-1">
                        <span className="text-[10px] uppercase font-bold tracking-wider text-emerald-200 flex items-center gap-1">
                            <Wallet className="w-3.5 h-3.5 text-emerald-300" />
                            <span>Saldo Kas Operasional Unit</span>
                        </span>
                        <p className="text-2xl sm:text-3xl font-black text-white tracking-tight">
                            {kasUnit}
                        </p>
                        <span className="inline-flex items-center gap-1 text-[10px] text-emerald-300 font-bold bg-emerald-900/40 px-2 py-0.5 rounded-full">
                            <CheckCircle2 className="w-3 h-3 text-emerald-400" />
                            <span>Rasio Likuiditas {healthRatio} ({healthStatus})</span>
                        </span>
                    </div>

                    <div className="pt-2 border-t border-white/10 text-[11px] text-emerald-100/90 font-medium">
                        💡 Kas siap pakai mampu menutupi seluruh potensi penarikan nasabah dengan aman.
                    </div>
                </div>

            </div>

        </div>
    );
}
