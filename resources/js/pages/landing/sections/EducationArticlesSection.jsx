import React from 'react';
import { BookOpen, Calendar, ArrowRight, Sparkles } from 'lucide-react';

export default function EducationArticlesSection({ articles = [] }) {
    // Fallback items if DB has no articles yet
    const fallbackArticles = [
        {
            id: 1,
            judul: 'Panduan Praktis Memilah Sampah Rumah Tangga',
            kategori: 'Tips & Panduan',
            tanggal: 'Terbaru',
            excerpt: 'Pelajari cara mudah memisahkan sampah organik dan anorganik bernilai tinggi agar siap disetorkan ke bank sampah.',
            image_url: 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=800&auto=format&fit=crop&q=80',
            url: '/edukasi',
        },
        {
            id: 2,
            judul: 'Mengubah Minyak Jelantah Menjadi Sumber Pendapatan',
            kategori: 'Ekonomi Sirkular',
            tanggal: 'Terbaru',
            excerpt: 'Jangan buang minyak bekas ke saluran air! Kumpulkan dan jual ke bank sampah desa untuk bahan baku biodiesel.',
            image_url: 'https://images.unsplash.com/photo-1607613009820-a29f7bb81c04?w=800&auto=format&fit=crop&q=80',
            url: '/edukasi',
        },
        {
            id: 3,
            judul: 'Mengenal Jenis Kode Plastik yang Bernilai Jual Tinggi',
            kategori: 'Daur Ulang',
            tanggal: 'Terbaru',
            excerpt: 'Kenali perbedaan plastik PET, HDPE, dan PP agar Anda bisa mendapatkan harga timbangan terbaik saat penjemputan.',
            image_url: 'https://images.unsplash.com/photo-1528323273322-d81458248d40?w=800&auto=format&fit=crop&q=80',
            url: '/edukasi',
        },
    ];

    const displayArticles = articles.length > 0 ? articles : fallbackArticles;

    return (
        <section id="edukasi" className="relative py-20 lg:py-28 bg-[#03110D] border-t border-white/[0.08] overflow-hidden">
            
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 sm:space-y-16 relative z-10">
                
                {/* Section Header */}
                <div className="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div className="space-y-4 max-w-2xl">
                        <div className="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold uppercase tracking-wider">
                            <BookOpen className="w-3.5 h-3.5" />
                            <span>LITERASI & EDUKASI LINGKUNGAN</span>
                        </div>
                        <h2 className="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight">
                            Wawasan Daur Ulang & <br className="hidden sm:block" />
                            <span className="text-[#22C55E]">Tips Ramah Lingkungan.</span>
                        </h2>
                        <p className="text-sm sm:text-base text-white/70 leading-relaxed">
                            Tingkatkan pemahaman Anda seputar pengelolaan limbah mandiri, gaya hidup minim sampah, dan ekonomi sirkular desa.
                        </p>
                    </div>

                    <a 
                        href="/edukasi"
                        className="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 text-white text-sm font-bold transition-colors self-start md:self-auto hover:border-emerald-500/40"
                    >
                        <span>Lihat Semua Artikel</span>
                        <ArrowRight className="w-4 h-4 text-emerald-400" />
                    </a>
                </div>

                {/* Articles 3-Column Grid */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    {displayArticles.map((article, idx) => (
                        <article 
                            key={article.id || idx}
                            className="rounded-3xl bg-[#061E17] border border-white/10 overflow-hidden flex flex-col justify-between hover:border-emerald-500/40 hover:-translate-y-1.5 transition-all duration-300 shadow-xl group"
                        >
                            <div>
                                {/* Image Cover */}
                                <div className="relative aspect-[16/10] overflow-hidden bg-black/40">
                                    <img 
                                        src={article.image_url || 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=800&auto=format&fit=crop&q=80'} 
                                        alt={article.judul}
                                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        onError={(e) => {
                                            e.target.onerror = null;
                                            e.target.src = 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=800&auto=format&fit=crop&q=80';
                                        }}
                                    />
                                    <div className="absolute top-4 left-4">
                                        <span className="px-3 py-1 rounded-full bg-[#051410]/80 backdrop-blur-md border border-white/10 text-[11px] font-bold text-emerald-300">
                                            {article.kategori || 'Edukasi'}
                                        </span>
                                    </div>
                                </div>

                                {/* Content */}
                                <div className="p-6 space-y-3">
                                    <div className="flex items-center gap-2 text-xs text-white/50">
                                        <Calendar className="w-3.5 h-3.5 text-emerald-400" />
                                        <span>{article.tanggal || 'Terbaru'}</span>
                                    </div>
                                    <h3 className="text-lg font-bold text-white group-hover:text-emerald-300 transition-colors line-clamp-2 leading-snug">
                                        {article.judul}
                                    </h3>
                                    <p className="text-xs sm:text-sm text-white/60 line-clamp-3 leading-relaxed">
                                        {article.excerpt}
                                    </p>
                                </div>
                            </div>

                            {/* Read More Link */}
                            <div className="px-6 pb-6 pt-2 border-t border-white/[0.06]">
                                <a 
                                    href={article.url || `/edukasi/${article.slug || ''}`}
                                    className="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-400 hover:text-emerald-300 group-hover:translate-x-1 transition-all"
                                >
                                    <span>Baca Selengkapnya</span>
                                    <ArrowRight className="w-3.5 h-3.5" />
                                </a>
                            </div>
                        </article>
                    ))}
                </div>

            </div>
        </section>
    );
}
