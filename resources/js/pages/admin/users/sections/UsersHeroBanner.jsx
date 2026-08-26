import React from 'react';
import { Users, UserPlus, Truck, ShieldCheck, Sparkles } from 'lucide-react';

export default function UsersHeroBanner({
    authData = {},
    statistics = {},
    onOpenCreatePetugas,
    onOpenCreateNasabah,
}) {
    const unitName = authData?.bank_sampah_name || 'Unit Melati Asri';
    const totalNasabah = statistics?.total_nasabah || 128;
    const totalPetugas = statistics?.total_petugas || 4;

    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-md p-6 sm:p-8 animate-slide-in select-none">
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

            <div className="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                
                {/* Left Side: Title & Subtitle */}
                <div className="space-y-3 max-w-2xl">
                    <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-emerald-100">
                        <Users className="w-4 h-4 text-emerald-200" />
                        <span>Manajemen Ekosistem & Sumber Daya Manusia</span>
                    </div>

                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight">
                        Petugas Lapangan & Warga Nasabah {unitName} 👥
                    </h1>

                    <p className="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
                        Kelola armada operasional penjemputan sampah harian dan pantau data partisipasi warga nasabah binaan unit bank sampah.
                    </p>

                    {/* Quick Action Buttons */}
                    <div className="pt-2 flex flex-wrap items-center gap-3">
                        <button
                            type="button"
                            onClick={onOpenCreatePetugas}
                            className="px-4 py-2.5 bg-white text-emerald-900 hover:bg-emerald-50 rounded-xl font-black text-xs transition-all shadow-md flex items-center gap-2 cursor-pointer hover:scale-105 active:scale-95"
                        >
                            <Truck className="w-4 h-4 text-blue-600" />
                            <span>+ Daftarkan Petugas Lapangan</span>
                        </button>

                        <button
                            type="button"
                            onClick={onOpenCreateNasabah}
                            className="px-4 py-2.5 bg-emerald-950/50 hover:bg-emerald-950/70 text-white border border-white/20 rounded-xl font-bold text-xs transition-all shadow-sm flex items-center gap-2 cursor-pointer hover:scale-105 active:scale-95"
                        >
                            <UserPlus className="w-4 h-4 text-emerald-300" />
                            <span>+ Registrasi Warga Nasabah</span>
                        </button>
                    </div>
                </div>

                {/* Right Side: Quick Stats Glass Box */}
                <div className="p-5 rounded-2xl bg-black/20 backdrop-blur-md border border-white/15 grid grid-cols-2 gap-4 shrink-0 shadow-lg min-w-[280px]">
                    <div className="space-y-1">
                        <span className="text-[10px] uppercase font-bold tracking-wider text-emerald-200 flex items-center gap-1">
                            <Users className="w-3.5 h-3.5 text-emerald-300" />
                            <span>Warga Nasabah</span>
                        </span>
                        <p className="text-2xl sm:text-3xl font-black text-white tracking-tight">
                            {totalNasabah}
                        </p>
                        <span className="text-[10px] text-emerald-300 font-medium block">
                            Terdaftar di RT 01-06
                        </span>
                    </div>

                    <div className="space-y-1">
                        <span className="text-[10px] uppercase font-bold tracking-wider text-emerald-200 flex items-center gap-1">
                            <Truck className="w-3.5 h-3.5 text-blue-300" />
                            <span>Armada Petugas</span>
                        </span>
                        <p className="text-2xl sm:text-3xl font-black text-white tracking-tight">
                            {totalPetugas}
                        </p>
                        <span className="text-[10px] text-emerald-300 font-medium block">
                            Semua Siap Tugas
                        </span>
                    </div>

                    <div className="col-span-2 pt-2 border-t border-white/10 text-[11px] text-emerald-100 font-medium">
                        💡 Data disinkronisasi realtime dengan aplikasi mobile nasabah & petugas.
                    </div>
                </div>

            </div>

        </div>
    );
}
