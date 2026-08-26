import React, { useEffect } from 'react';
import { X, Clock, Calendar, User, Share2, Sparkles, Check } from 'lucide-react';

export default function ArticleReaderModal({
    isOpen = false,
    article = null,
    onClose,
}) {
    const [copied, setCopied] = React.useState(false);

    useEffect(() => {
        const handleKeyDown = (e) => {
            if (e.key === 'Escape') onClose();
        };
        if (isOpen) {
            document.body.style.overflow = 'hidden';
            window.addEventListener('keydown', handleKeyDown);
        } else {
            document.body.style.overflow = 'unset';
        }
        return () => {
            document.body.style.overflow = 'unset';
            window.removeEventListener('keydown', handleKeyDown);
        };
    }, [isOpen, onClose]);

    if (!isOpen || !article) return null;

    const handleShare = () => {
        navigator.clipboard.writeText(window.location.href).then(() => {
            setCopied(true);
            setTimeout(() => setCopied(false), 2500);
        });
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto select-none">
            {/* Backdrop */}
            <div
                className="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                onClick={onClose}
            />

            {/* Modal Content Window */}
            <div className="relative bg-white rounded-3xl border border-slate-200 w-full max-w-3xl max-h-[90vh] overflow-y-auto shadow-2xl z-10 animate-slide-in custom-scrollbar">
                
                {/* Sticky Header Bar with Close Button */}
                <div className="sticky top-0 z-20 bg-white/95 backdrop-blur-md px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div className="flex items-center gap-2">
                        <span className="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold">
                            {article.kategori}
                        </span>
                        <div className="flex items-center gap-1 text-slate-400 text-xs font-medium">
                            <Clock className="w-3.5 h-3.5" />
                            <span>{article.read_time || '3 Menit'}</span>
                        </div>
                    </div>

                    <div className="flex items-center gap-2">
                        <button
                            type="button"
                            onClick={handleShare}
                            className="p-2 rounded-xl text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 transition-colors cursor-pointer"
                            title="Salin tautan artikel"
                        >
                            {copied ? <Check className="w-4 h-4 text-emerald-600" /> : <Share2 className="w-4 h-4" />}
                        </button>
                        <button
                            type="button"
                            onClick={onClose}
                            className="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors cursor-pointer"
                        >
                            <X className="w-5 h-5" />
                        </button>
                    </div>
                </div>

                {/* Article Header Image */}
                <div className="relative h-64 sm:h-80 overflow-hidden bg-slate-100">
                    <img
                        src={article.image_url}
                        alt={article.judul}
                        className="w-full h-full object-cover"
                        onError={(e) => {
                            e.target.onerror = null;
                            e.target.src = 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=800&auto=format&fit=crop&q=80';
                        }}
                    />
                </div>

                {/* Article Body */}
                <div className="p-6 sm:p-10 space-y-6">
                    
                    <div className="space-y-3">
                        <h1 className="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-snug">
                            {article.judul}
                        </h1>

                        <div className="flex flex-wrap items-center gap-4 text-xs text-slate-500 font-medium pt-1 border-b border-slate-100 pb-4">
                            <div className="flex items-center gap-1.5">
                                <User className="w-4 h-4 text-slate-400" />
                                <span>{article.author_name || 'Tim Edukasi SiSampah'}</span>
                            </div>
                            <span>•</span>
                            <div className="flex items-center gap-1.5">
                                <Calendar className="w-4 h-4 text-slate-400" />
                                <span>{article.created_at_formatted || '2026'}</span>
                            </div>
                        </div>
                    </div>

                    {/* Content Text (Formatted Prose) */}
                    <div className="prose prose-slate max-w-none text-xs sm:text-sm text-slate-700 leading-relaxed space-y-4">
                        {article.konten ? (
                            article.konten.split('\n').map((paragraph, index) => {
                                const trimmed = paragraph.trim();
                                if (!trimmed) return null;
                                return (
                                    <p key={index} className="leading-relaxed">
                                        {trimmed}
                                    </p>
                                );
                            })
                        ) : (
                            <p>{article.excerpt}</p>
                        )}
                    </div>

                    {/* Bottom CTA */}
                    <div className="p-5 rounded-2xl bg-emerald-50 border border-emerald-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-8">
                        <div className="space-y-0.5">
                            <h4 className="font-extrabold text-xs sm:text-sm text-emerald-950">
                                Ingin Mempraktikkan Panduan Ini?
                            </h4>
                            <p className="text-[11px] text-emerald-800">
                                Mulai pilah sampah dari rumah dan jadwalkan penjemputan sekarang.
                            </p>
                        </div>
                        <a
                            href="/nasabah/jemput-sampah"
                            className="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-sm transition-colors text-center shrink-0"
                        >
                            Jadwalkan Jemput Sampah ➔
                        </a>
                    </div>

                </div>

            </div>
        </div>
    );
}
