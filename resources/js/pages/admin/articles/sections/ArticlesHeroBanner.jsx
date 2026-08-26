import React from 'react';
import { BookOpen, Plus, Eye, FileText, CheckCircle2 } from 'lucide-react';

export default function ArticlesHeroBanner({
    authData = {},
    statistics = {},
    onOpenCreate,
}) {
    const unitName = authData?.bank_sampah_name || 'Unit Melati Asri';
    const totalArticles = statistics?.total_articles || 12;
    const publishedCount = statistics?.published_count || 10;
    const totalViews = statistics?.total_views || 3420;

    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-md p-6 sm:p-8 animate-slide-in select-none">
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

            <div className="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                
                {/* Left Side: Title & Action */}
                <div className="space-y-3 max-w-2xl">
                    <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-emerald-100">
                        <BookOpen className="w-4 h-4 text-emerald-200" />
                        <span>Publikasi Edukasi & Literasi Sirkular</span>
                    </div>

                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight">
                        Artikel & Panduan Edukasi {unitName} 📚
                    </h1>

                    <p className="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
                        Tulis panduan pemilahan sampah, tutorial daur ulang kreatif, dan tips gaya hidup zero waste untuk disebarluaskan kepada seluruh warga nasabah.
                    </p>

                    <div className="pt-2 flex flex-wrap items-center gap-3">
                        <button
                            type="button"
                            onClick={onOpenCreate}
                            className="px-4 py-2.5 bg-white text-emerald-900 hover:bg-emerald-50 rounded-xl font-black text-xs transition-all shadow-md flex items-center gap-2 cursor-pointer hover:scale-105 active:scale-95"
                        >
                            <Plus className="w-4 h-4 text-emerald-600" />
                            <span>+ Tulis Artikel Edukasi Baru</span>
                        </button>
                    </div>
                </div>

                {/* Right Side: Quick Stats Glass Box */}
                <div className="p-5 rounded-2xl bg-black/20 backdrop-blur-md border border-white/15 grid grid-cols-2 gap-4 shrink-0 shadow-lg min-w-[280px]">
                    <div className="space-y-1">
                        <span className="text-[10px] uppercase font-bold tracking-wider text-emerald-200 flex items-center gap-1">
                            <CheckCircle2 className="w-3.5 h-3.5 text-emerald-300" />
                            <span>Artikel Terbit</span>
                        </span>
                        <p className="text-2xl sm:text-3xl font-black text-white tracking-tight">
                            {publishedCount}
                        </p>
                        <span className="text-[10px] text-emerald-300 font-medium block">
                            Dari {totalArticles} Total Artikel
                        </span>
                    </div>

                    <div className="space-y-1">
                        <span className="text-[10px] uppercase font-bold tracking-wider text-emerald-200 flex items-center gap-1">
                            <Eye className="w-3.5 h-3.5 text-teal-300" />
                            <span>Total Pembaca</span>
                        </span>
                        <p className="text-2xl sm:text-3xl font-black text-white tracking-tight">
                            {totalViews.toLocaleString('id-ID')}
                        </p>
                        <span className="text-[10px] text-emerald-300 font-medium block">
                            Akumulasi Tayangan
                        </span>
                    </div>

                    <div className="col-span-2 pt-2 border-t border-white/10 text-[11px] text-emerald-100 font-medium">
                        💡 Artikel langsung tayang di portal nasabah dan halaman publik.
                    </div>
                </div>

            </div>

        </div>
    );
}
