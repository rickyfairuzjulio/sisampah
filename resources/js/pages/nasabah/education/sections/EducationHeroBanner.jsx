import React from 'react';
import { BookOpen, Sparkles, Sprout, Recycle, Globe2 } from 'lucide-react';

export default function EducationHeroBanner() {
    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-md p-6 sm:p-8 animate-slide-in select-none">
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

            <div className="relative z-10 space-y-4 max-w-3xl">
                
                <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-emerald-100">
                    <BookOpen className="w-4 h-4 text-emerald-200" />
                    <span>Pusat Literasi & Panduan Praktis SiSampah</span>
                </div>

                <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight">
                    Pusat Edukasi & Panduan Daur Ulang
                </h1>

                <p className="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
                    Tingkatkan wawasan seputar teknik pemilahan sampah organik & anorganik, pembuatan pupuk kompos mandiri dari dapur, budidaya maggot BSF, dan tips kreatif daur ulang bernilai ekonomi.
                </p>

                {/* 3 Quick Highlight Tags */}
                <div className="pt-2 flex flex-wrap items-center gap-2.5">
                    <div className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/10 border border-white/15 text-xs font-semibold backdrop-blur-sm text-emerald-100">
                        <Sprout className="w-3.5 h-3.5 text-emerald-300" />
                        <span>Kompos & Organik Mandiri</span>
                    </div>
                    <div className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/10 border border-white/15 text-xs font-semibold backdrop-blur-sm text-emerald-100">
                        <Recycle className="w-3.5 h-3.5 text-teal-300" />
                        <span>Teknik Daur Ulang Plastik</span>
                    </div>
                    <div className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/10 border border-white/15 text-xs font-semibold backdrop-blur-sm text-emerald-100">
                        <Globe2 className="w-3.5 h-3.5 text-amber-300" />
                        <span>Gaya Hidup Zero Waste</span>
                    </div>
                </div>

            </div>

        </div>
    );
}
