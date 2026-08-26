import React, { useState } from 'react';
import { Tag, TrendingUp, TrendingDown, Minus, Edit3, BarChart2, Archive, CheckCircle2, Sparkles } from 'lucide-react';

export default function TrashPriceCatalogGrid({
    categories = [],
    onEditPrice,
    onViewTrend,
}) {
    const [selectedGroup, setSelectedGroup] = useState('all');

    const defaultCategories = [
        {
            id: 1,
            name: 'Plastik PET Bening Bersih',
            code: 'TR-PL-001',
            category_group: 'Plastik',
            unit: 'Kg',
            price_per_kg: 4500,
            price_formatted: 'Rp 4.500 / Kg',
            status_harga: 'naik',
            perubahan_persen: 12.5,
            points_reward: '45 Pts / Kg',
            kualitas: 'Grade A (Tanpa Label)',
            emoji: '🍾',
            is_archived: false,
        },
        {
            id: 2,
            name: 'Kardus Box Cokelat Duplek',
            code: 'TR-KP-002',
            category_group: 'Kertas',
            unit: 'Kg',
            price_per_kg: 3000,
            price_formatted: 'Rp 3.000 / Kg',
            status_harga: 'stabil',
            perubahan_persen: 0,
            points_reward: '30 Pts / Kg',
            kualitas: 'Kering & Terikat',
            emoji: '📦',
            is_archived: false,
        },
        {
            id: 3,
            name: 'Besi Padu & Logam Konstruksi',
            code: 'TR-LG-003',
            category_group: 'Logam',
            unit: 'Kg',
            price_per_kg: 6500,
            price_formatted: 'Rp 6.500 / Kg',
            status_harga: 'naik',
            perubahan_persen: 8.3,
            points_reward: '65 Pts / Kg',
            kualitas: 'Besi Padat Bersih',
            emoji: '🔩',
            is_archived: false,
        },
        {
            id: 4,
            name: 'Minyak Jelantah (UCO)',
            code: 'TR-MJ-004',
            category_group: 'Minyak',
            unit: 'Liter',
            price_per_kg: 7000,
            price_formatted: 'Rp 7.000 / Liter',
            status_harga: 'turun',
            perubahan_persen: -3.5,
            points_reward: '70 Pts / Liter',
            kualitas: 'Tersaring Bebas Ampas',
            emoji: '🛢️',
            is_archived: false,
        },
        {
            id: 5,
            name: 'Sampah Organik Dedaunan',
            code: 'TR-OG-005',
            category_group: 'Organik',
            unit: 'Kg',
            price_per_kg: 800,
            price_formatted: 'Rp 800 / Kg',
            status_harga: 'stabil',
            perubahan_persen: 0,
            points_reward: '15 Pts / Kg',
            kualitas: 'Bahan Baku Kompos',
            emoji: '🍂',
            is_archived: false,
        },
        {
            id: 6,
            name: 'Tembaga Merah / Kabel Kupas',
            code: 'TR-TB-006',
            category_group: 'Logam',
            unit: 'Kg',
            price_per_kg: 15000,
            price_formatted: 'Rp 15.000 / Kg',
            status_harga: 'naik',
            perubahan_persen: 15.0,
            points_reward: '150 Pts / Kg',
            kualitas: 'Kualitas Super',
            emoji: '💎',
            is_archived: false,
        },
    ];

    const items = categories.length > 0 ? categories : defaultCategories;

    const filteredItems = items.filter((item) => {
        if (selectedGroup === 'all') return true;
        return (item.category_group || '').toLowerCase().includes(selectedGroup.toLowerCase());
    });

    return (
        <div className="space-y-5 select-none">
            
            {/* Header & Filter Pills */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h3 className="font-black text-lg text-slate-900 tracking-tight flex items-center gap-2">
                        <span>Daftar Katalog & Standar Harga Beli Sampah</span>
                        <span className="px-2 py-0.5 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800">
                            {filteredItems.length} Material
                        </span>
                    </h3>
                    <p className="text-xs text-slate-500">
                        Pilih kategori untuk memfilter material acuan timbangan pos unit
                    </p>
                </div>

                {/* Filter Pills */}
                <div className="flex flex-wrap items-center gap-1.5 bg-slate-100 p-1 rounded-2xl border border-slate-200/80">
                    <button
                        type="button"
                        onClick={() => setSelectedGroup('all')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer ${
                            selectedGroup === 'all' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        Semua ({items.length})
                    </button>

                    <button
                        type="button"
                        onClick={() => setSelectedGroup('plastik')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer ${
                            selectedGroup === 'plastik' ? 'bg-emerald-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        🍾 Plastik
                    </button>

                    <button
                        type="button"
                        onClick={() => setSelectedGroup('kertas')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer ${
                            selectedGroup === 'kertas' ? 'bg-blue-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        📦 Kertas
                    </button>

                    <button
                        type="button"
                        onClick={() => setSelectedGroup('logam')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer ${
                            selectedGroup === 'logam' ? 'bg-amber-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        🔩 Logam
                    </button>

                    <button
                        type="button"
                        onClick={() => setSelectedGroup('minyak')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer ${
                            selectedGroup === 'minyak' ? 'bg-purple-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        🛢️ Minyak
                    </button>
                </div>
            </div>

            {/* Grid 6/3 Cards */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                {filteredItems.map((cat) => (
                    <div
                        key={cat.id}
                        className="bg-white border border-slate-200 rounded-3xl p-5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between space-y-4 group"
                    >
                        {/* Top Info */}
                        <div className="flex items-start justify-between gap-2">
                            <div className="flex items-center gap-3">
                                <div className="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform shadow-2xs">
                                    {cat.emoji || '📦'}
                                </div>
                                <div>
                                    <h4 className="font-black text-sm text-slate-900 leading-tight">
                                        {cat.name}
                                    </h4>
                                    <span className="text-[10px] font-mono text-slate-400 font-semibold">
                                        {cat.code} • {cat.kualitas}
                                    </span>
                                </div>
                            </div>

                            {/* Trend Badge */}
                            {cat.status_harga === 'naik' ? (
                                <span className="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <TrendingUp className="w-3 h-3" />
                                    <span>+{cat.perubahan_persen}%</span>
                                </span>
                            ) : cat.status_harga === 'turun' ? (
                                <span className="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800 border border-rose-200">
                                    <TrendingDown className="w-3 h-3" />
                                    <span>{cat.perubahan_persen}%</span>
                                </span>
                            ) : (
                                <span className="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-600 border border-slate-200">
                                    <Minus className="w-3 h-3" />
                                    <span>Stabil</span>
                                </span>
                            )}
                        </div>

                        {/* Middle: Price & Rewards */}
                        <div className="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                            <div className="flex items-center justify-between">
                                <span className="text-xs font-bold text-slate-500">Harga Beli Standar:</span>
                                <span className="text-base font-black text-emerald-700">
                                    {cat.price_formatted}
                                </span>
                            </div>

                            <div className="flex items-center justify-between pt-1 border-t border-slate-200/60">
                                <span className="text-[11px] font-bold text-purple-700 flex items-center gap-1">
                                    <Sparkles className="w-3 h-3 text-purple-600" />
                                    <span>Reward Poin Warga:</span>
                                </span>
                                <span className="text-xs font-black text-purple-900">
                                    {cat.points_reward}
                                </span>
                            </div>
                        </div>

                        {/* Bottom Actions */}
                        <div className="flex items-center justify-between pt-1 border-t border-slate-100">
                            <button
                                type="button"
                                onClick={() => onViewTrend && onViewTrend(cat)}
                                className="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold transition-colors flex items-center gap-1.5 cursor-pointer"
                            >
                                <BarChart2 className="w-3.5 h-3.5 text-blue-600" />
                                <span>Grafik Tren</span>
                            </button>

                            <button
                                type="button"
                                onClick={() => onEditPrice && onEditPrice(cat)}
                                className="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold transition-colors flex items-center gap-1.5 cursor-pointer shadow-2xs"
                            >
                                <Edit3 className="w-3.5 h-3.5" />
                                <span>Ubah Harga</span>
                            </button>
                        </div>

                    </div>
                ))}
            </div>

        </div>
    );
}
