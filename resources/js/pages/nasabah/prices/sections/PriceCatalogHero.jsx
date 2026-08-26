import React from 'react';
import { Tag, Sparkles, ShieldCheck } from 'lucide-react';

export default function PriceCatalogHero() {
    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-sm p-6 sm:p-8 animate-slide-in select-none">
            
            {/* Background Pattern Effects */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />
            
            <div className="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                
                {/* Text Content */}
                <div className="max-w-2xl space-y-2.5">
                    <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-emerald-100">
                        <Sparkles className="w-3.5 h-3.5 text-emerald-200" />
                        <span>Transparansi Komoditas Sampah</span>
                    </div>

                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight">
                        Katalog Harga Sampah Terkini 🏷️
                    </h1>

                    <p className="text-white/85 text-xs sm:text-sm lg:text-base leading-relaxed font-normal">
                        Cek harga beli timbangan sebelum Anda menyetor atau memesan jemputan. Pilah sampah dari rumah dengan benar untuk mendapatkan nilai ekonomis tertinggi.
                    </p>
                </div>

                {/* Badge Right */}
                <div className="hidden lg:flex flex-col items-end gap-2 shrink-0">
                    <div className="px-4 py-2.5 rounded-2xl bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-white flex items-center gap-2 shadow-sm">
                        <ShieldCheck className="w-4 h-4 text-emerald-300" />
                        <span>Update Real-Time per Unit</span>
                    </div>
                    <span className="text-[11px] text-emerald-200/80 font-medium">
                        Standar SNI & Pengepul Lokal
                    </span>
                </div>

            </div>

        </div>
    );
}
