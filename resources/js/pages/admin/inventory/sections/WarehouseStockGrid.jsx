import React from 'react';
import { Package, Truck, Sparkles, Tag, CheckCircle2, Flame, ArrowUpRight } from 'lucide-react';

export default function WarehouseStockGrid({
    categories = [],
    onSellCategory,
}) {
    const defaultCategories = [
        {
            id: 1,
            name: 'Plastik PET & Campur',
            stock_kg: 1250,
            unit: 'Kg',
            price_per_kg: 4500,
            valuation: 5625000,
            status: 'Siap Angkut Pengepul',
            badgeColor: 'bg-emerald-100 text-emerald-800 border-emerald-200',
            iconColor: 'bg-emerald-50 text-emerald-600',
            emoji: '🍾',
            capacityPct: 75,
        },
        {
            id: 2,
            name: 'Kardus & Kertas Duplek',
            stock_kg: 980,
            unit: 'Kg',
            price_per_kg: 3000,
            valuation: 2940000,
            status: 'Siap Angkut Pengepul',
            badgeColor: 'bg-blue-100 text-blue-800 border-blue-200',
            iconColor: 'bg-blue-50 text-blue-600',
            emoji: '📦',
            capacityPct: 60,
        },
        {
            id: 3,
            name: 'Besi, Logam & Kaleng',
            stock_kg: 320,
            unit: 'Kg',
            price_per_kg: 9000,
            valuation: 2880000,
            status: 'Siap Angkut Pengepul',
            badgeColor: 'bg-amber-100 text-amber-800 border-amber-200',
            iconColor: 'bg-amber-50 text-amber-600',
            emoji: '🔩',
            capacityPct: 45,
        },
        {
            id: 4,
            name: 'Minyak Jelantah (UCO)',
            stock_kg: 150,
            unit: 'Liter',
            price_per_kg: 7000,
            valuation: 1050000,
            status: 'Siap Jual Biodiesel',
            badgeColor: 'bg-purple-100 text-purple-800 border-purple-200',
            iconColor: 'bg-purple-50 text-purple-600',
            emoji: '🛢️',
            capacityPct: 50,
        },
        {
            id: 5,
            name: 'Sampah Organik & Daun',
            stock_kg: 450,
            unit: 'Kg',
            price_per_kg: 0,
            valuation: 0,
            status: 'Fermentasi Kompos',
            badgeColor: 'bg-teal-100 text-teal-800 border-teal-200',
            iconColor: 'bg-teal-50 text-teal-600',
            emoji: '🍂',
            capacityPct: 80,
        },
        {
            id: 6,
            name: 'Plastik Sachet & Residu',
            stock_kg: 300,
            unit: 'Kg',
            price_per_kg: 0,
            valuation: 0,
            status: 'Bahan Kerajinan Tas',
            badgeColor: 'bg-indigo-100 text-indigo-800 border-indigo-200',
            iconColor: 'bg-indigo-50 text-indigo-600',
            emoji: '🧴',
            capacityPct: 40,
        },
    ];

    const items = categories.length > 0 ? categories : defaultCategories;

    return (
        <div className="space-y-4 select-none">
            
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h3 className="font-black text-lg text-slate-900 tracking-tight flex items-center gap-2">
                        <span>Stok Fisik Gudang per Kategori Material</span>
                        <span className="px-2 py-0.5 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800">
                            {items.length} Kategori
                        </span>
                    </h3>
                    <p className="text-xs text-slate-500">
                        Timbangan fisik yang tersimpan di pos gudang penampungan sementara
                    </p>
                </div>
            </div>

            {/* Grid 6 Cards */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                {items.map((cat) => (
                    <div
                        key={cat.id || cat.name}
                        className="bg-white border border-slate-200 rounded-3xl p-5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between space-y-4 group"
                    >
                        {/* Top Icon & Badge */}
                        <div className="flex items-start justify-between gap-2">
                            <div className="flex items-center gap-3">
                                <div className="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform shadow-2xs">
                                    {cat.emoji || '📦'}
                                </div>
                                <div>
                                    <h4 className="font-black text-sm text-slate-900 leading-tight">
                                        {cat.name}
                                    </h4>
                                    <span className="text-[11px] text-slate-400 font-medium">
                                        {cat.price_per_kg > 0 ? `Harga Pabrik: Rp ${cat.price_per_kg.toLocaleString('id-ID')}/${cat.unit || 'Kg'}` : 'Material Khusus Olahan'}
                                    </span>
                                </div>
                            </div>

                            <span className={`px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border ${cat.badgeColor || 'bg-slate-100 text-slate-700'}`}>
                                {cat.status}
                            </span>
                        </div>

                        {/* Middle: Stock Weight & Valuation */}
                        <div className="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                            <div className="flex items-center justify-between">
                                <span className="text-xs font-bold text-slate-500">Berat Tersimpan:</span>
                                <span className="text-lg font-black text-slate-900">
                                    {Number(cat.stock_kg).toLocaleString('id-ID')} {cat.unit || 'Kg'}
                                </span>
                            </div>

                            {cat.valuation > 0 ? (
                                <div className="flex items-center justify-between pt-1 border-t border-slate-200/60">
                                    <span className="text-[11px] font-bold text-emerald-700">Estimasi Valuasi:</span>
                                    <span className="text-xs font-black text-emerald-800">
                                        Rp {Number(cat.valuation).toLocaleString('id-ID')}
                                    </span>
                                </div>
                            ) : (
                                <div className="flex items-center justify-between pt-1 border-t border-slate-200/60">
                                    <span className="text-[11px] font-bold text-teal-700">Alur Pemanfaatan:</span>
                                    <span className="text-xs font-black text-teal-800">
                                        {cat.status}
                                    </span>
                                </div>
                            )}
                        </div>

                        {/* Bottom Action */}
                        <div className="flex items-center justify-between pt-1">
                            <div className="w-28 space-y-1">
                                <div className="flex items-center justify-between text-[9px] font-bold text-slate-400">
                                    <span>Tampungan</span>
                                    <span>{cat.capacityPct || 50}%</span>
                                </div>
                                <div className="w-full h-1.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div
                                        className="h-full bg-emerald-500 rounded-full"
                                        style={{ width: `${cat.capacityPct || 50}%` }}
                                    />
                                </div>
                            </div>

                            {cat.price_per_kg > 0 ? (
                                <button
                                    type="button"
                                    onClick={() => onSellCategory && onSellCategory(cat)}
                                    className="px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-extrabold transition-colors flex items-center gap-1 cursor-pointer"
                                >
                                    <Truck className="w-3.5 h-3.5 text-blue-600" />
                                    <span>Jual Pengepul</span>
                                </button>
                            ) : (
                                <button
                                    type="button"
                                    className="px-3 py-1.5 rounded-xl bg-purple-50 text-purple-700 text-xs font-extrabold flex items-center gap-1"
                                >
                                    <Sparkles className="w-3.5 h-3.5 text-purple-600" />
                                    <span>Proses Olah</span>
                                </button>
                            )}
                        </div>

                    </div>
                ))}
            </div>

        </div>
    );
}
