import React from 'react';
import { Building2, MapPin, Wallet, ArrowUpRight, CheckCircle2, ShieldCheck, Plus } from 'lucide-react';

export default function AdminHeroBanner({
    authData = {},
    metrics = {},
    onOpenTopUp,
}) {
    const unitName = authData?.bank_sampah_name || 'Unit Melati Asri';
    const unitAddress = authData?.unit_address || 'Desa Sukamaju, RT 01 / RW 02, Kec. Ngaliyan, Kota Semarang';
    const isSuperAdmin = authData?.is_super_admin ?? false;
    const unitKas = metrics?.unit_kas_formatted || 'Rp 18.750.000';

    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-md p-6 sm:p-8 animate-slide-in select-none">
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

            <div className="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                
                {/* Left Side: Unit Info */}
                <div className="space-y-3 max-w-2xl">
                    <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-emerald-100">
                        <Building2 className="w-4 h-4 text-emerald-200" />
                        <span>{isSuperAdmin ? 'Pusat Pengawasan Platform Nasional' : 'Kantor Bank Sampah Unit'}</span>
                    </div>

                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight">
                        {isSuperAdmin ? 'Pusat Kendali Ekosistem SiSampah 📊' : `Pusat Kendali Operasional ${unitName} 📊`}
                    </h1>

                    <div className="flex items-center gap-1.5 text-xs text-emerald-100/90 font-medium">
                        <MapPin className="w-3.5 h-3.5 text-emerald-300 shrink-0" />
                        <span className="truncate">{unitAddress}</span>
                    </div>
                </div>

                {/* Right Side: Cash Position & Quick Action Card */}
                <div className="p-5 rounded-2xl bg-black/20 backdrop-blur-md border border-white/15 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shrink-0 shadow-lg">
                    <div className="space-y-1">
                        <span className="text-[11px] uppercase font-bold tracking-wider text-emerald-200 flex items-center gap-1.5">
                            <Wallet className="w-3.5 h-3.5 text-emerald-300" />
                            <span>Saldo Kas Operasional Unit</span>
                        </span>
                        <p className="text-2xl sm:text-3xl font-black text-white tracking-tight">
                            {unitKas}
                        </p>
                        <span className="inline-flex items-center gap-1 text-[10px] text-emerald-300 font-bold bg-emerald-900/40 px-2 py-0.5 rounded-full">
                            <CheckCircle2 className="w-3 h-3 text-emerald-400" />
                            <span>Likuiditas Kas Sangat Aman</span>
                        </span>
                    </div>

                    <div className="flex flex-wrap sm:flex-col gap-2 w-full sm:w-auto">
                        <a
                            href="/admin/validasi-keuangan"
                            className="px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-900 rounded-xl font-black text-xs transition-colors flex items-center justify-center gap-1.5 shadow-sm cursor-pointer"
                        >
                            <span>Validasi Payout</span>
                            <ArrowUpRight className="w-3.5 h-3.5" />
                        </a>
                    </div>
                </div>

            </div>

        </div>
    );
}
