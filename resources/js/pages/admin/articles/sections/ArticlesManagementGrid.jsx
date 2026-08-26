import React, { useState } from 'react';
import { BookOpen, Eye, Edit3, Trash2, Globe, FileEdit, CheckCircle2, AlertCircle, ExternalLink } from 'lucide-react';

export default function ArticlesManagementGrid({
    articles = [],
    onEditArticle,
    onTogglePublish,
    onDeleteArticle,
}) {
    const [selectedCategory, setSelectedCategory] = useState('all');

    const defaultArticles = [
        {
            id: 1,
            title: 'Panduan Lengkap Memilah Sampah Rumah Tangga',
            slug: 'panduan-lengkap-memilah-sampah',
            category: 'Organik & Kompos',
            excerpt: 'Pelajari metode pemilahan 3 wadah praktis di rumah agar sampah bernilai ekonomis tinggi saat disetor ke bank sampah.',
            image_url: 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=600&auto=format&fit=crop&q=80',
            is_published: true,
            views_count: 850,
            creator_name: 'Admin Unit',
            created_at_formatted: '15 Jan 2026',
        },
        {
            id: 2,
            title: 'Inovasi Daur Ulang Plastik HDPE Menjadi Paving Block',
            slug: 'inovasi-daur-ulang-plastik-hdpe',
            category: 'Plastik & Anorganik',
            excerpt: 'Bagaimana cacahan tutup botol dan botol detergen dapat diolah kembali menjadi produk konstruksi bernilai jual tinggi.',
            image_url: 'https://images.unsplash.com/photo-1567095761054-7a02e69e5c43?w=600&auto=format&fit=crop&q=80',
            is_published: true,
            views_count: 620,
            creator_name: 'Admin Unit',
            created_at_formatted: '18 Jan 2026',
        },
        {
            id: 3,
            title: 'Kreasi Pot Bunga Estetik dari Galon Bekas',
            slug: 'kreasi-pot-bunga-galon-bekas',
            category: 'Kreasi Daur Ulang',
            excerpt: 'Tutorial langkah demi langkah membuat kerajinan upcycling pot tanaman hias untuk mempercantik pekarangan rumah.',
            image_url: 'https://images.unsplash.com/photo-1588880331179-bc9b93a8cb5e?w=600&auto=format&fit=crop&q=80',
            is_published: true,
            views_count: 430,
            creator_name: 'Admin Unit',
            created_at_formatted: '20 Jan 2026',
        },
        {
            id: 4,
            title: 'Tips Hidup Minim Sampah (Zero Waste) untuk Pemula',
            slug: 'tips-hidup-minim-sampah-zero-waste',
            category: 'Tips Zero Waste',
            excerpt: 'Mulai dari membawa tas belanja sendiri hingga membuat eko-enzim dari sisa kulit buah segar.',
            image_url: 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=600&auto=format&fit=crop&q=80',
            is_published: false,
            views_count: 120,
            creator_name: 'Admin Unit',
            created_at_formatted: '22 Jan 2026',
        },
    ];

    const articleList = articles.length > 0 ? articles : defaultArticles;

    const filteredArticles = articleList.filter((a) => {
        if (selectedCategory === 'all') return true;
        if (selectedCategory === 'draft') return !a.is_published;
        if (selectedCategory === 'published') return a.is_published;
        return a.category.toLowerCase().includes(selectedCategory.toLowerCase());
    });

    const categories = [
        { id: 'all', label: `Semua (${articleList.length})` },
        { id: 'published', label: `🌐 Terbit (${articleList.filter(a => a.is_published).length})` },
        { id: 'draft', label: `📑 Draf (${articleList.filter(a => !a.is_published).length})` },
        { id: 'organik', label: '🍂 Organik' },
        { id: 'plastik', label: '🍾 Plastik' },
        { id: 'kreasi', label: '🎨 Kreasi' },
        { id: 'zero', label: '🌿 Zero Waste' },
    ];

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-6 select-none">
            
            {/* Header & Filter Pill Tabs */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div>
                    <h3 className="font-black text-lg text-slate-900 tracking-tight">
                        Katalog Konten & Artikel Edukasi 📚
                    </h3>
                    <p className="text-xs text-slate-500">
                        Kelola publikasi materi literasi sirkular yang dapat diakses oleh nasabah unit
                    </p>
                </div>

                {/* Filter Tabs */}
                <div className="flex flex-wrap items-center gap-1.5 bg-slate-100 p-1 rounded-2xl border border-slate-200/80">
                    {categories.map((cat) => (
                        <button
                            key={cat.id}
                            type="button"
                            onClick={() => setSelectedCategory(cat.id)}
                            className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer ${
                                selectedCategory === cat.id
                                    ? 'bg-emerald-600 text-white shadow-2xs'
                                    : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60'
                            }`}
                        >
                            {cat.label}
                        </button>
                    ))}
                </div>
            </div>

            {/* Grid of Articles */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                {filteredArticles.map((article) => (
                    <div
                        key={article.id}
                        className="bg-slate-50/70 border border-slate-200 rounded-2xl overflow-hidden hover:shadow-md transition-all flex flex-col justify-between group"
                    >
                        <div>
                            {/* Thumbnail Cover */}
                            <div className="relative h-44 w-full bg-slate-200 overflow-hidden">
                                <img
                                    src={article.image_url || 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=600&auto=format&fit=crop&q=80'}
                                    alt={article.title}
                                    className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    onError={(e) => {
                                        e.target.onerror = null;
                                        e.target.src = 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=600&auto=format&fit=crop&q=80';
                                    }}
                                />

                                {/* Category Tag */}
                                <span className="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-black bg-white/90 backdrop-blur-md text-emerald-800 shadow-sm border border-white/50">
                                    {article.category}
                                </span>

                                {/* Status Tag */}
                                <span className={`absolute top-3 right-3 px-2.5 py-1 rounded-full text-[10px] font-black backdrop-blur-md shadow-sm border ${
                                    article.is_published
                                        ? 'bg-emerald-600/90 text-white border-emerald-400'
                                        : 'bg-amber-600/90 text-white border-amber-400'
                                }`}>
                                    {article.is_published ? '🌐 Terbit' : '📑 Draf'}
                                </span>
                            </div>

                            {/* Body Content */}
                            <div className="p-4 space-y-2">
                                <h4 className="font-black text-sm text-slate-900 leading-snug line-clamp-2">
                                    {article.title}
                                </h4>

                                <p className="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {article.excerpt}
                                </p>

                                <div className="pt-2 flex items-center justify-between text-[11px] text-slate-400 font-medium border-t border-slate-200/60">
                                    <span className="flex items-center gap-1 text-slate-600 font-semibold">
                                        <Eye className="w-3.5 h-3.5 text-slate-400" />
                                        <span>{article.views_count.toLocaleString('id-ID')} Views</span>
                                    </span>
                                    <span>{article.created_at_formatted}</span>
                                </div>
                            </div>
                        </div>

                        {/* Action Buttons Footer */}
                        <div className="p-3 bg-white border-t border-slate-200 flex items-center justify-between gap-2">
                            <button
                                type="button"
                                onClick={() => onTogglePublish && onTogglePublish(article)}
                                className={`px-2.5 py-1.5 rounded-xl text-[11px] font-bold transition-colors cursor-pointer flex items-center gap-1 ${
                                    article.is_published
                                        ? 'bg-slate-100 hover:bg-amber-50 text-slate-600 hover:text-amber-700'
                                        : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-700'
                                }`}
                                title={article.is_published ? 'Tarik Kembali ke Draf' : 'Terbitkan Artikel'}
                            >
                                <Globe className="w-3.5 h-3.5" />
                                <span>{article.is_published ? 'Jadikan Draf' : 'Terbitkan'}</span>
                            </button>

                            <div className="flex items-center gap-1">
                                <button
                                    type="button"
                                    onClick={() => onEditArticle && onEditArticle(article)}
                                    className="p-1.5 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 transition-colors cursor-pointer"
                                    title="Edit Artikel"
                                >
                                    <Edit3 className="w-4 h-4" />
                                </button>

                                <button
                                    type="button"
                                    onClick={() => onDeleteArticle && onDeleteArticle(article)}
                                    className="p-1.5 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-400 hover:text-rose-600 transition-colors cursor-pointer"
                                    title="Hapus Artikel"
                                >
                                    <Trash2 className="w-4 h-4" />
                                </button>
                            </div>
                        </div>

                    </div>
                ))}
            </div>

        </div>
    );
}
