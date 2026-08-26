import React from 'react';
import { TrendingUp, PieChart, BarChart3, Calendar } from 'lucide-react';

export default function AdminChartsSection({
    chartSetoran = { labels: [], data: [] },
    chartJenisSampah = { labels: [], data: [] },
}) {
    const setoranLabels = chartSetoran.labels || ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
    const setoranData = chartSetoran.data || [140, 260, 210, 310, 380, 490, 420];
    const maxSetoran = Math.max(...setoranData, 500);

    const categories = [
        { label: 'Plastik (PET/HDPE)', percentage: 42, color: 'bg-emerald-500', hex: '#10B981', weight: '19.240 Kg' },
        { label: 'Kertas & Kardus', percentage: 28, color: 'bg-blue-500', hex: '#3B82F6', weight: '12.830 Kg' },
        { label: 'Logam & Aluminium', percentage: 12, color: 'bg-amber-500', hex: '#F59E0B', weight: '5.490 Kg' },
        { label: 'Minyak Jelantah (UCO)', percentage: 8, color: 'bg-purple-500', hex: '#8B5CF6', weight: '3.660 L' },
        { label: 'Organik & Dedaunan', percentage: 6, color: 'bg-teal-500', hex: '#14B8A6', weight: '2.750 Kg' },
        { label: 'Residu Bersih', percentage: 4, color: 'bg-slate-400', hex: '#94A3B8', weight: '1.850 Kg' },
    ];

    return (
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 select-none">
            
            {/* Left 7 Cols: Grafik Tren Setoran Harian */}
            <div className="lg:col-span-7 bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-6 flex flex-col justify-between">
                
                <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div className="flex items-center gap-2.5">
                        <div className="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                            <TrendingUp className="w-4 h-4" />
                        </div>
                        <div>
                            <h3 className="font-extrabold text-sm sm:text-base text-slate-900 tracking-tight">
                                Tren Setoran Sampah Harian (Kg)
                            </h3>
                            <p className="text-[11px] text-slate-400">
                                7 hari terakhir akumulasi jemput & setor mandiri
                            </p>
                        </div>
                    </div>

                    <span className="text-[11px] font-bold text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full flex items-center gap-1">
                        <Calendar className="w-3 h-3" />
                        <span>Minggu Ini</span>
                    </span>
                </div>

                {/* Interactive Bar Chart Visualization */}
                <div className="h-52 flex items-end justify-between gap-2 sm:gap-4 pt-4 px-2">
                    {setoranData.map((val, idx) => {
                        const heightPct = Math.round((val / maxSetoran) * 100);
                        const isMax = val === Math.max(...setoranData);

                        return (
                            <div key={idx} className="flex-1 flex flex-col items-center gap-2 group h-full justify-end">
                                <span className={`text-[10px] font-black transition-opacity ${
                                    isMax ? 'text-emerald-700 opacity-100' : 'text-slate-500 opacity-0 group-hover:opacity-100'
                                }`}>
                                    {val}k
                                </span>
                                
                                <div className="w-full max-w-[42px] bg-slate-100 rounded-2xl overflow-hidden h-36 flex items-end p-1">
                                    <div
                                        className={`w-full rounded-xl transition-all duration-500 group-hover:scale-y-105 ${
                                            isMax
                                                ? 'bg-gradient-to-t from-emerald-600 to-teal-400 shadow-sm'
                                                : 'bg-gradient-to-t from-slate-400 to-blue-400 group-hover:from-emerald-500 group-hover:to-teal-400'
                                        }`}
                                        style={{ height: `${heightPct}%` }}
                                    />
                                </div>

                                <span className={`text-[11px] font-bold ${
                                    isMax ? 'text-emerald-700 font-black' : 'text-slate-500'
                                }`}>
                                    {setoranLabels[idx]}
                                </span>
                            </div>
                        );
                    })}
                </div>

                <div className="pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Rata-rata Harian: <strong className="text-slate-800">315.7 Kg/Hari</strong></span>
                    <span className="text-emerald-700 font-bold">▲ +18.4% vs Minggu Lalu</span>
                </div>

            </div>

            {/* Right 5 Cols: Grafik Komposisi Kategori Sampah */}
            <div className="lg:col-span-5 bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-5 flex flex-col justify-between">
                
                <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div className="flex items-center gap-2.5">
                        <div className="w-8 h-8 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold">
                            <PieChart className="w-4 h-4" />
                        </div>
                        <div>
                            <h3 className="font-extrabold text-sm sm:text-base text-slate-900 tracking-tight">
                                Komposisi Kategori Sampah
                            </h3>
                            <p className="text-[11px] text-slate-400">
                                Distribusi proporsi material terkelola
                            </p>
                        </div>
                    </div>
                </div>

                {/* Progress breakdown bars */}
                <div className="space-y-3">
                    {categories.map((cat, idx) => (
                        <div key={idx} className="space-y-1">
                            <div className="flex items-center justify-between text-xs">
                                <div className="flex items-center gap-2">
                                    <span className={`w-2.5 h-2.5 rounded-full ${cat.color}`}></span>
                                    <span className="font-bold text-slate-800">{cat.label}</span>
                                </div>
                                <div className="flex items-center gap-2 text-slate-500 font-medium">
                                    <span>{cat.weight}</span>
                                    <span className="font-black text-slate-900">{cat.percentage}%</span>
                                </div>
                            </div>

                            <div className="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                                <div
                                    className={`h-full ${cat.color} rounded-full transition-all duration-700`}
                                    style={{ width: `${cat.percentage}%` }}
                                />
                            </div>
                        </div>
                    ))}
                </div>

                <div className="pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span>Dominan: <strong className="text-emerald-700">Plastik (42%)</strong></span>
                    <span>Total Kategori: <strong className="text-slate-700">6 Jenis</strong></span>
                </div>

            </div>

        </div>
    );
}
