import React from 'react';
import { Clock, ArrowRight, Sparkles, BookOpen } from 'lucide-react';

export default function FeaturedArticleCard({
    article = null,
    onReadArticle,
}) {
    if (!article) return null;

    return (
        <div className="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-all group select-none">
            <div className="grid grid-cols-1 lg:grid-cols-12 items-stretch">
                
                {/* Cover Image (5 Kolom Desktop) */}
                <div className="lg:col-span-5 relative min-h-[220px] lg:min-h-[300px] overflow-hidden bg-slate-100">
                    <img
                        src={article.image_url}
                        alt={article.judul}
                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        onError={(e) => {
                            e.target.onerror = null;
                            e.target.src = 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=800&auto=format&fit=crop&q=80';
                        }}
                    />
                    <div className="absolute top-4 left-4 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-600/90 backdrop-blur-md text-white text-[11px] font-extrabold shadow-sm">
                        <Sparkles className="w-3 h-3 text-amber-300" />
                        <span>Panduan Utama Pilihan</span>
                    </div>
                </div>

                {/* Content Details (7 Kolom Desktop) */}
                <div className="lg:col-span-7 p-6 sm:p-8 flex flex-col justify-between space-y-4">
                    
                    <div className="space-y-3">
                        <div className="flex flex-wrap items-center gap-2">
                            <span className="px-3 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold">
                                {article.kategori}
                            </span>
                            <span className="text-slate-300">•</span>
                            <div className="flex items-center gap-1 text-slate-400 text-xs font-medium">
                                <Clock className="w-3.5 h-3.5" />
                                <span>{article.read_time || '4 Menit Baca'}</span>
                            </div>
                        </div>

                        <h2 className="text-xl sm:text-2xl font-black text-slate-900 tracking-tight group-hover:text-emerald-700 transition-colors leading-snug">
                            {article.judul}
                        </h2>

                        <p className="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3">
                            {article.excerpt}
                        </p>
                    </div>

                    <div className="pt-2 flex items-center justify-between border-t border-slate-100">
                        <span className="text-[11px] text-slate-400 font-medium">
                            {article.created_at_formatted || 'Dipublikasikan baru-baru ini'}
                        </span>

                        <button
                            type="button"
                            onClick={() => onReadArticle(article)}
                            className="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-xl font-bold text-xs shadow-sm hover:shadow transition-all cursor-pointer hover:translate-x-0.5"
                        >
                            <span>Baca Panduan Lengkap</span>
                            <ArrowRight className="w-3.5 h-3.5" />
                        </button>
                    </div>

                </div>

            </div>
        </div>
    );
}
