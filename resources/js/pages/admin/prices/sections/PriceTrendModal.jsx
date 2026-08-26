import React from 'react';
import { X, BarChart2, TrendingUp, Sparkles, Calendar, DollarSign } from 'lucide-react';

export default function PriceTrendModal({
    isOpen,
    onClose,
    category = null,
}) {
    if (!isOpen || !category) return null;

    // Simulated 30-day history points
    const basePrice = category.price_per_kg || 4500;
    const historyPoints = [
        { day: '01 Agt', price: Math.round(basePrice * 0.92) },
        { day: '06 Agt', price: Math.round(basePrice * 0.94) },
        { day: '11 Agt', price: Math.round(basePrice * 0.97) },
        { day: '16 Agt', price: Math.round(basePrice * 0.96) },
        { day: '21 Agt', price: Math.round(basePrice * 1.02) },
        { day: '24 Agt', price: basePrice },
    ];

    const maxP = Math.max(...historyPoints.map((p) => p.price));
    const minP = Math.min(...historyPoints.map((p) => p.price));

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fade-in select-none">
            
            <div className="relative w-full max-w-lg bg-white border border-slate-200 rounded-3xl shadow-2xl overflow-hidden animate-slide-in">
                
                {/* Header */}
                <div className="p-6 bg-gradient-to-r from-blue-600 to-indigo-700 text-white flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center font-bold">
                            <BarChart2 className="w-5 h-5" />
                        </div>
                        <div>
                            <h3 className="font-black text-lg text-white tracking-tight">
                                Tren Fluktuasi Harga Pasar
                            </h3>
                            <p className="text-xs text-blue-100">
                                {category.name} ({category.code})
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

                {/* Body */}
                <div className="p-6 space-y-5">
                    
                    {/* Quick Stats */}
                    <div className="grid grid-cols-2 gap-3">
                        <div className="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-1">
                            <span className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Harga Terendah (30h)</span>
                            <p className="text-base font-black text-slate-800">Rp {minP.toLocaleString('id-ID')}</p>
                        </div>

                        <div className="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-1">
                            <span className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Harga Tertinggi (30h)</span>
                            <p className="text-base font-black text-emerald-700">Rp {maxP.toLocaleString('id-ID')}</p>
                        </div>
                    </div>

                    {/* Chart Visualization Bars */}
                    <div className="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                        <div className="flex items-center justify-between text-xs font-bold text-slate-700">
                            <span>Pergerakan 30 Hari Terakhir</span>
                            <span className="text-emerald-700 font-extrabold flex items-center gap-1">
                                <TrendingUp className="w-3.5 h-3.5" />
                                <span>+{category.perubahan_persen || 5}% vs Bulan Lalu</span>
                            </span>
                        </div>

                        <div className="h-32 flex items-end justify-between gap-2 pt-6">
                            {historyPoints.map((pt, idx) => {
                                const heightPct = Math.max(20, Math.round(((pt.price - minP * 0.8) / (maxP * 1.1 - minP * 0.8)) * 100));
                                return (
                                    <div key={idx} className="flex-1 flex flex-col items-center gap-1.5 h-full justify-end group">
                                        <span className="text-[9px] font-mono text-slate-500 opacity-0 group-hover:opacity-100 transition-opacity">
                                            {(pt.price / 1000).toFixed(1)}k
                                        </span>
                                        <div
                                            className="w-full bg-gradient-to-t from-blue-500 to-indigo-500 rounded-t-lg transition-all group-hover:from-emerald-500 group-hover:to-teal-500"
                                            style={{ height: `${heightPct}%` }}
                                        />
                                        <span className="text-[9px] font-bold text-slate-400 whitespace-nowrap">
                                            {pt.day}
                                        </span>
                                    </div>
                                );
                            })}
                        </div>
                    </div>

                    {/* AI Prediction Hint */}
                    <div className="p-3.5 rounded-2xl bg-indigo-50 border border-indigo-200 text-xs text-indigo-900 flex items-center gap-2.5">
                        <Sparkles className="w-4 h-4 text-indigo-600 shrink-0" />
                        <span>
                            <strong>AI Price Forecast:</strong> Permintaan pabrik daur ulang untuk <strong>{category.name}</strong> diprediksi akan tetap stabil dengan kenaikan moderat dalam 7 hari ke depan.
                        </span>
                    </div>

                    {/* Close Button */}
                    <div className="pt-2 flex justify-end">
                        <button
                            type="button"
                            onClick={onClose}
                            className="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl text-xs font-bold transition-colors cursor-pointer"
                        >
                            Tutup
                        </button>
                    </div>

                </div>

            </div>

        </div>
    );
}
