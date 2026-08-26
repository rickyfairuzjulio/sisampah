import React from 'react';
import { PackageOpen, Sparkles } from 'lucide-react';
import PriceCard from '../components/PriceCard';

export default function PriceCardGrid({
    prices = [],
    activeCategory = 'all',
    onToggleFavorite,
}) {
    if (!prices || prices.length === 0) {
        return (
            <div className="bg-white border border-slate-200 rounded-3xl p-12 text-center max-w-md mx-auto shadow-sm my-8">
                <div className="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                    <PackageOpen className="w-8 h-8" />
                </div>
                <h3 className="text-base font-bold text-slate-800 mb-1">
                    Belum Ada Komoditas Sampah
                </h3>
                <p className="text-xs text-slate-500 max-w-xs mx-auto mb-6">
                    {activeCategory === 'favorites'
                        ? 'Anda belum menyimpan sampah ke daftar favorit. Klik ikon hati pada kartu harga untuk menambahkannya.'
                        : 'Belum ada data harga sampah untuk unit atau kategori ini.'}
                </p>
                {activeCategory === 'favorites' && (
                    <a
                        href="/nasabah/prices"
                        className="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors"
                    >
                        <Sparkles className="w-4 h-4" />
                        <span>Lihat Semua Katalog</span>
                    </a>
                )}
            </div>
        );
    }

    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            {prices.map((item) => (
                <PriceCard
                    key={item.id}
                    item={item}
                    onToggleFavorite={onToggleFavorite}
                />
            ))}
        </div>
    );
}
