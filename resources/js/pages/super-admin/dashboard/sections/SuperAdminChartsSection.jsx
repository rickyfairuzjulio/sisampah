import React from 'react';
import { TrendingUp, PieChart, Sparkles } from 'lucide-react';

export default function SuperAdminChartsSection({
    charts = {},
}) {
    const monthlyTrend = charts?.monthly_trend || [
        { month: 'Mar', ton: 140 },
        { month: 'Apr', ton: 185 },
        { month: 'Mei', ton: 210 },
        { month: 'Jun', ton: 260 },
        { month: 'Jul', ton: 310 },
        { month: 'Agt', ton: 385 },
    ];

    const wasteCategories = charts?.waste_categories || [
        { label: 'Plastik PET & HDPE', percentage: 42, color: '#059669' },
        { label: 'Kardus & Kertas', percentage: 28, color: '#0D9488' },
        { label: 'Logam & Tembaga', percentage: 14, color: '#3B82F6' },
        { label: 'Minyak Jelantah', percentage: 10, color: '#F59E0B' },
        { label: 'Residu Daur Ulang', percentage: 6, color: '#64748B' },
    ];

    const maxTon = Math.max(...monthlyTrend.map(d => d.ton)) || 400;

    return (
        <div className="space-y-5 select-none h-full flex flex-col justify-between">
            
            {/* 1. Bar Chart: Growth of Waste Collection (6 Months) */}
            <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-2xs space-y-4">
                <div className="flex items-center justify-between">
                    <div className="flex items-center gap-2.5">
                        <div className="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold">
                            <TrendingUp className="w-4 h-4" />
                        </div>
                        <div>
                            <h4 className="font-extrabold text-sm text-slate-900">
                                Tren Pengumpulan Sampah Nasional 📈
                            </h4>
                            <p className="text-xs text-slate-500">
                                Pertumbuhan tonase agregasi 24 unit mitra (Mar - Agt 2026)
                            </p>
                        </div>
                    </div>

                    <span className="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200">
                        +175% Pertumbuhan
                    </span>
                </div>

                {/* Visual Bar Chart */}
                <div className="pt-6 grid grid-cols-6 gap-2 sm:gap-4 items-end h-40 border-b border-slate-100 pb-2">
                    {monthlyTrend.map((item, idx) => {
                        const heightPercent = Math.round((item.ton / maxTon) * 100);
                        return (
                            <div key={idx} className="flex flex-col items-center gap-1.5 group h-full justify-end">
                                <span className="text-[10px] font-extrabold text-slate-400 group-hover:text-emerald-600 transition-colors">
                                    {item.ton}T
                                </span>
                                <div className="w-full bg-slate-100 rounded-xl overflow-hidden h-28 flex items-end p-0.5">
                                    <div
                                        style={{ height: `${heightPercent}%` }}
                                        className="w-full bg-gradient-to-t from-emerald-600 to-teal-500 rounded-lg transition-all duration-500 group-hover:from-emerald-500 group-hover:to-teal-400 shadow-2xs"
                                    />
                                </div>
                                <span className="text-[11px] font-bold text-slate-700">
                                    {item.month}
                                </span>
                            </div>
                        );
                    })}
                </div>

                <div className="flex items-center justify-between text-[11px] text-slate-500 pt-1">
                    <span className="flex items-center gap-1 font-medium">
                        <Sparkles className="w-3 h-3 text-emerald-600" />
                        <span>Kenaikan rata-rata: +24,8% per bulan</span>
                    </span>
                    <span className="font-bold text-slate-800">Target 2026: 2.500 Ton</span>
                </div>
            </div>

            {/* 2. Donut / Progress Breakdown: National Waste Categories */}
            <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-2xs space-y-4">
                <div className="flex items-center gap-2.5">
                    <div className="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold">
                        <PieChart className="w-4 h-4" />
                    </div>
                    <div>
                        <h4 className="font-extrabold text-sm text-slate-900">
                            Komposisi Jenis Sampah Terbesar Nasional 🍩
                        </h4>
                        <p className="text-xs text-slate-500">
                            Persentase 5 kategori material daur ulang utama
                        </p>
                    </div>
                </div>

                {/* Progress Breakdown */}
                <div className="space-y-3 pt-2">
                    {wasteCategories.map((cat, idx) => (
                        <div key={idx} className="space-y-1">
                            <div className="flex items-center justify-between text-xs font-bold text-slate-700">
                                <span>{cat.label}</span>
                                <span className="text-slate-900">{cat.percentage}%</span>
                            </div>
                            <div className="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div
                                    style={{ width: `${cat.percentage}%`, backgroundColor: cat.color }}
                                    className="h-full rounded-full transition-all duration-500"
                                />
                            </div>
                        </div>
                    ))}
                </div>
            </div>

        </div>
    );
}
