import React from 'react';
import { Clock, ArrowRight, BookOpen } from 'lucide-react';

export default function ArticleCardsGrid({
    articles = [],
    onReadArticle,
}) {
    if (!articles || articles.length === 0) {
        return (
            <div className="bg-white border border-slate-200 rounded-3xl p-12 text-center space-y-3 shadow-sm select-none">
                <div className="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto text-slate-400">
                    <BookOpen className="w-6 h-6" />
                </div>
                <h4 className="text-base font-bold text-slate-800">Belum ada artikel pada topik ini</h4>
                <p className="text-xs text-slate-500 max-w-sm mx-auto">
                    Silakan pilih kategori topik lain untuk melihat panduan dan artikel daur ulang lainnya.
                </p>
            </div>
        );
    }

    const getBadgeStyle = (categoryName = '') => {
        const cat = (categoryName || '').toLowerCase();
        if (cat.includes('organik') || cat.includes('kompos')) {
            return 'bg-emerald-50 text-emerald-800 border-emerald-200';
        }
        if (cat.includes('plastik') || cat.includes('anorganik')) {
            return 'bg-blue-50 text-blue-800 border-blue-200';
        }
        if (cat.includes('kreasi') || cat.includes('daur ulang')) {
            return 'bg-amber-50 text-amber-800 border-amber-200';
        }
        return 'bg-teal-50 text-teal-800 border-teal-200';
    };

    return (
        <div className="space-y-4 select-none">
            <div className="flex items-center justify-between">
                <h3 className="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">
                    Koleksi Artikel & Panduan Edukatif ({articles.length})
                </h3>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                {articles.map((item) => (
                    <div
                        key={item.id}
                        className="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col justify-between group"
                    >
                        <div>
                            {/* Image Thumbnail */}
                            <div className="relative h-44 overflow-hidden bg-slate-100">
                                <img
                                    src={item.image_url}
                                    alt={item.judul}
                                    className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    onError={(e) => {
                                        e.target.onerror = null;
                                        e.target.src = 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=800&auto=format&fit=crop&q=80';
                                    }}
                                />
                                <div className="absolute top-3 left-3">
                                    <span className={`px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border backdrop-blur-md shadow-2xs ${getBadgeStyle(item.kategori)}`}>
                                        {item.kategori}
                                    </span>
                                </div>
                            </div>

                            {/* Card Body */}
                            <div className="p-5 sm:p-6 space-y-2.5">
                                <div className="flex items-center gap-1.5 text-slate-400 text-[11px] font-medium">
                                    <Clock className="w-3.5 h-3.5" />
                                    <span>{item.read_time || '3 Menit Baca'}</span>
                                    <span>•</span>
                                    <span>{item.created_at_formatted || 'Baru'}</span>
                                </div>

                                <h4 className="font-extrabold text-sm sm:text-base text-slate-900 group-hover:text-emerald-700 transition-colors line-clamp-2 leading-snug">
                                    {item.judul}
                                </h4>

                                <p className="text-xs text-slate-500 leading-relaxed line-clamp-2">
                                    {item.excerpt}
                                </p>
                            </div>
                        </div>

                        {/* Card Footer */}
                        <div className="p-5 sm:p-6 pt-0">
                            <button
                                type="button"
                                onClick={() => onReadArticle(item)}
                                className="w-full py-2.5 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-700 text-slate-700 border border-slate-200 hover:border-emerald-300 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer group-hover:bg-emerald-600 group-hover:text-white group-hover:border-emerald-600 shadow-2xs"
                            >
                                <span>Baca Panduan</span>
                                <ArrowRight className="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" />
                            </button>
                        </div>

                    </div>
                ))}
            </div>
        </div>
    );
}
