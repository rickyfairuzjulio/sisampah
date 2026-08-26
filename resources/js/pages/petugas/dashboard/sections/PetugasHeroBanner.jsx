import React from 'react';
import { Truck, ArrowDownToLine, MapPin, ShieldCheck, Sparkles } from 'lucide-react';

export default function PetugasHeroBanner({ 
    authData = {},
}) {
    const bankSampahName = authData?.bank_sampah_name || 'Unit Melati Asri';
    const officerName = authData?.user?.name || 'Petugas Lapangan';

    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-md p-6 sm:p-8 animate-slide-in select-none">
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

            <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                
                {/* Left Info Column */}
                <div className="space-y-3 max-w-2xl">
                    <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-emerald-100">
                        <Truck className="w-4 h-4 text-emerald-200" />
                        <span>Manifes Penjemputan & Pos Teller</span>
                    </div>

                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight">
                        Dashboard Manifes Penjemputan
                    </h1>

                    <p className="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
                        Kelola rute penjemputan sampah nasabah secara realtime, verifikasi timbangan di lokasi, dan proses transaksi setoran langsung di pos unit.
                    </p>

                    <div className="pt-1 flex flex-wrap items-center gap-2">
                        <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-black/15 text-xs font-semibold backdrop-blur-xs text-white/90">
                            <MapPin className="w-3.5 h-3.5 text-emerald-300" />
                            <span>{bankSampahName}</span>
                        </div>
                        <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-black/15 text-xs font-semibold backdrop-blur-xs text-white/90">
                            <ShieldCheck className="w-3.5 h-3.5 text-teal-300" />
                            <span>Bertugas: {officerName}</span>
                        </div>
                    </div>
                </div>

                {/* Right Action Column */}
                <div className="shrink-0 flex flex-col sm:flex-row md:flex-col gap-3">
                    <a
                        href="/petugas/setor-mandiri"
                        className="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-white hover:bg-emerald-50 text-emerald-800 font-extrabold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all hover:scale-[1.02] cursor-pointer"
                    >
                        <ArrowDownToLine className="w-4 h-4 text-emerald-600" />
                        <span>Input Setor Mandiri (Teller) ➔</span>
                    </a>
                </div>

            </div>

        </div>
    );
}
