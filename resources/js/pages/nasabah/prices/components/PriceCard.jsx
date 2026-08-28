import React, { useState } from 'react';
import { Heart, TrendingUp, TrendingDown, Minus, Tag, Truck } from 'lucide-react';

export default function PriceCard({ item, onToggleFavorite }) {
    const [isFavorite, setIsFavorite] = useState(item?.is_favorite || false);
    const [isHovered, setIsHovered] = useState(false);

    const handleFavoriteClick = async (e) => {
        e.preventDefault();
        e.stopPropagation();
        const nextState = !isFavorite;
        setIsFavorite(nextState);

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const res = await fetch(`/nasabah/prices/${item.id}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || '',
                    'Accept': 'application/json',
                },
            });
            if (onToggleFavorite) {
                onToggleFavorite(item.id, nextState);
            }
        } catch (err) {
            console.error('Failed to toggle favorite:', err);
        }
    };

    const formatCurrency = (val) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(val || 0);
    };

    // Trend badge visual
    const trend = item?.status_harga || 'stabil';
    const trendPct = item?.perubahan_persen || 0;

    const getTrendBadge = () => {
        if (trend === 'naik' || trendPct > 0) {
            return (
                <span className="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/80 text-[11px] font-black">
                    <TrendingUp className="w-3 h-3 text-emerald-600 dark:text-emerald-400" />
                    <span>▲ +{Math.abs(trendPct).toFixed(1)}%</span>
                </span>
            );
        }
        if (trend === 'turun' || trendPct < 0) {
            return (
                <span className="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-red-50 dark:bg-rose-950/60 text-red-700 dark:text-rose-300 border border-red-200 dark:border-rose-800/80 text-[11px] font-black">
                    <TrendingDown className="w-3 h-3 text-red-600 dark:text-rose-400" />
                    <span>▼ -{Math.abs(trendPct).toFixed(1)}%</span>
                </span>
            );
        }
        return (
            <span className="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 text-[11px] font-bold">
                <Minus className="w-3 h-3 text-slate-400" />
                <span>▬ 0.0%</span>
            </span>
        );
    };

    const getCategoryBadgeColor = () => {
        switch (item?.kategori) {
            case 'organik':
                return 'bg-emerald-50 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800';
            case 'b3':
                return 'bg-amber-50 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 border-amber-200 dark:border-amber-800';
            default:
                return 'bg-teal-50 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border-teal-200 dark:border-teal-800';
        }
    };

    return (
        <div 
            className="bg-white dark:bg-[#111827] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md hover:border-emerald-500/50 hover:-translate-y-1 transition-all duration-300 relative group select-none"
            onMouseEnter={() => setIsHovered(true)}
            onMouseLeave={() => setIsHovered(false)}
        >
            
            {/* 1. Header Gambar (160px) */}
            <div className="relative h-40 bg-slate-100 dark:bg-slate-900 overflow-hidden">
                <img 
                    src={item.image_url} 
                    alt={item.nama}
                    className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    onError={(e) => {
                        e.target.onerror = null;
                        e.target.src = 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=400&auto=format&fit=crop&q=80';
                    }}
                />

                {/* Gradient overlay on image */}
                <div className="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-60 pointer-events-none" />

                {/* Badge Kategori (Pojok Kiri Atas) */}
                <div className="absolute top-3 left-3 flex flex-col gap-1 z-10">
                    <span className={`text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-md backdrop-blur-md border shadow-sm ${getCategoryBadgeColor()}`}>
                        {item.kategori}
                    </span>
                    {item.kualitas && (
                        <span className="text-[9px] font-bold bg-slate-900/80 text-white px-2 py-0.5 rounded backdrop-blur-md border border-white/10 w-fit">
                            {item.kualitas}
                        </span>
                    )}
                </div>

                {/* Tombol Favorit (Pojok Kanan Atas) */}
                <button
                    onClick={handleFavoriteClick}
                    className="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 dark:bg-[#111827]/90 backdrop-blur-md shadow-md flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-10 focus:outline-none cursor-pointer"
                    title={isFavorite ? 'Hapus dari Favorit' : 'Simpan ke Favorit'}
                >
                    <Heart 
                        className={`w-4 h-4 transition-colors ${
                            isFavorite 
                                ? 'text-red-500 fill-red-500' 
                                : 'text-slate-400 dark:text-slate-500 hover:text-red-400'
                        }`} 
                    />
                </button>
            </div>

            {/* 2. Body Informasi Komoditas */}
            <div className="p-4 sm:p-5 flex-1 flex flex-col justify-between space-y-3">
                <div>
                    <div className="flex items-center justify-between gap-2 mb-1">
                        <h3 className="font-bold text-sm sm:text-base text-slate-900 dark:text-white group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors line-clamp-1">
                            {item.nama}
                        </h3>
                        <span className="text-[10px] font-mono font-bold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-1.5 py-0.5 rounded shrink-0">
                            {item.kode}
                        </span>
                    </div>

                    <p className="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed font-normal">
                        {item.deskripsi}
                    </p>
                </div>

                {/* 3. Footer Harga & Status Tren */}
                <div className="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-end justify-between gap-2">
                    <div>
                        <p className="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            HARGA ACUAN
                        </p>
                        <p className="text-lg sm:text-xl font-black text-emerald-600 dark:text-emerald-400 leading-tight mt-0.5">
                            {formatCurrency(item.harga_per_kg)}
                            <span className="text-xs font-bold text-slate-400 dark:text-slate-500 font-sans ml-1">
                                /{item.satuan || 'Kg'}
                            </span>
                        </p>
                    </div>

                    <div className="shrink-0">
                        {getTrendBadge()}
                    </div>
                </div>
            </div>

        </div>
    );
}
