import React, { useState, useEffect } from 'react';
import { X, Edit3, BookOpen, CheckCircle2, ArrowRight, Globe } from 'lucide-react';

export default function EditArticleModal({
    isOpen,
    onClose,
    article = null,
}) {
    if (!isOpen || !article) return null;

    const [title, setTitle] = useState(article.title || '');
    const [category, setCategory] = useState(article.category || 'Organik & Kompos');
    const [content, setContent] = useState(article.content || article.excerpt || '');
    const [isPublished, setIsPublished] = useState(article.is_published ?? true);
    const [isSubmitting, setIsSubmitting] = useState(false);

    useEffect(() => {
        if (article) {
            setTitle(article.title || '');
            setCategory(article.category || 'Organik & Kompos');
            setContent(article.content || article.excerpt || '');
            setIsPublished(article.is_published ?? true);
        }
    }, [article]);

    const categories = [
        'Organik & Kompos',
        'Plastik & Anorganik',
        'Kreasi Daur Ulang',
        'Tips Zero Waste',
        'Ekonomi Sirkular',
    ];

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsSubmitting(true);

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/super-admin/articles/${article.id}`;
        form.enctype = 'multipart/form-data';

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrf;
        form.appendChild(csrfInput);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        const fields = {
            judul: title,
            kategori: category,
            konten: content,
            is_published: isPublished ? 1 : 0,
        };

        Object.entries(fields).forEach(([k, v]) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = k;
            input.value = v;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fade-in select-none">
            
            <div className="relative w-full max-w-xl bg-white border border-slate-200 rounded-3xl shadow-2xl overflow-hidden animate-slide-in">
                
                {/* Header */}
                <div className="p-6 bg-gradient-to-r from-emerald-600 to-teal-700 text-white flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center font-bold">
                            <Edit3 className="w-5 h-5" />
                        </div>
                        <div>
                            <h3 className="font-black text-lg text-white tracking-tight">
                                Edit Artikel Edukasi ✏️
                            </h3>
                            <p className="text-xs text-white/80 truncate max-w-sm">
                                {article.title}
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        onClick={onClose}
                        className="p-2 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-colors cursor-pointer"
                    >
                        <X className="w-5 h-5" />
                    </button>
                </div>

                {/* Form */}
                <form onSubmit={handleSubmit} className="p-6 space-y-4">
                    
                    {/* Judul Artikel */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Judul Artikel Edukasi</label>
                        <input
                            type="text"
                            value={title}
                            onChange={(e) => setTitle(e.target.value)}
                            required
                            className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-emerald-600"
                        />
                    </div>

                    {/* Kategori */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Kategori Topik</label>
                        <select
                            value={category}
                            onChange={(e) => setCategory(e.target.value)}
                            className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-emerald-600 cursor-pointer"
                        >
                            {categories.map((c, idx) => (
                                <option key={idx} value={c}>{c}</option>
                            ))}
                        </select>
                    </div>

                    {/* Konten Lengkap */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Isi Konten & Panduan</label>
                        <textarea
                            value={content}
                            onChange={(e) => setContent(e.target.value)}
                            required
                            rows={6}
                            className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-900 focus:outline-emerald-600 leading-relaxed resize-none"
                        />
                    </div>

                    {/* Status Publish Switch */}
                    <div className="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div className="flex items-center gap-2.5">
                            <Globe className="w-4 h-4 text-emerald-600" />
                            <div>
                                <span className="text-xs font-bold text-slate-800 block">Status Terbit</span>
                                <span className="text-[10px] text-slate-500">Artikel akan langsung terlihat oleh warga saat aktif</span>
                            </div>
                        </div>
                        <button
                            type="button"
                            onClick={() => setIsPublished(!isPublished)}
                            className={`w-12 h-6 rounded-full transition-colors p-1 cursor-pointer flex items-center ${
                                isPublished ? 'bg-emerald-600 justify-end' : 'bg-slate-300 justify-start'
                            }`}
                        >
                            <div className="w-4 h-4 rounded-full bg-white shadow-md" />
                        </button>
                    </div>

                    {/* Actions */}
                    <div className="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button
                            type="button"
                            onClick={onClose}
                            className="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            disabled={isSubmitting}
                            className="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black transition-all shadow-md flex items-center gap-2 cursor-pointer disabled:opacity-50"
                        >
                            {isSubmitting ? (
                                <>
                                    <CheckCircle2 className="w-4 h-4 text-white animate-spin" />
                                    <span>Menyimpan...</span>
                                </>
                            ) : (
                                <>
                                    <span>Simpan Perubahan</span>
                                    <ArrowRight className="w-4 h-4" />
                                </>
                            )}
                        </button>
                    </div>

                </form>

            </div>

        </div>
    );
}
