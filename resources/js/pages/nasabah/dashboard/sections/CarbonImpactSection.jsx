import React from 'react';
import { Link } from '@inertiajs/react';
import { 
    Award, 
    CloudRain, 
    TreePine, 
    Zap, 
    Droplets, 
    BarChart3, 
    ExternalLink,
    Sparkles
} from 'lucide-react';

export default function CarbonImpactSection({ impact = {}, chartData = {} }) {
    const co2 = impact?.co2 || 0;
    const pohon = impact?.pohon || 0;
    const energi = impact?.energi || 0;
    const air = impact?.air || 0;
    const isGreenStarter = impact?.isGreenStarter || false;

    const labels = chartData?.labels || ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
    const data = chartData?.data || [0, 0, 0, 0, 0, 0];

    const maxVal = Math.max(...data, 10);

    return (
        <section className="space-y-5">
            
            {/* Header Toolbar */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div className="flex items-center gap-3">
                    <h3 className="text-lg sm:text-xl font-bold text-slate-900 dark:text-white">
                        Dampak Lingkungan Anda
                    </h3>
                    {isGreenStarter && (
                        <span className="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 rounded-full text-xs font-bold border border-emerald-200 dark:border-emerald-800/80">
                            <span>🌿</span> Green Starter
                        </span>
                    )}
                </div>

                <Link
                    href="/nasabah/sertifikat"
                    className="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-xs font-bold rounded-xl shadow-md transition-all hover:scale-105 self-start sm:self-auto"
                >
                    <Award className="w-4 h-4" />
                    <span>Lihat Sertifikat Rapor</span>
                </Link>
            </div>

            {/* Content Grid (4 Counters Left + Bar Chart Right) */}
            <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                {/* 4 Counter Cards (4 Kolom Desktop) */}
                <div className="lg:col-span-4 grid grid-cols-2 gap-3.5">
                    
                    {/* 1. CO2 */}
                    <div className="bg-white dark:bg-[#111827] border-t-4 border-t-slate-600 dark:border-t-slate-400 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 flex flex-col justify-center text-center shadow-sm transition-colors duration-200">
                        <div className="mb-2 flex justify-center text-slate-600 dark:text-slate-400">
                            <CloudRain className="w-7 h-7" />
                        </div>
                        <p className="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                            {co2.toFixed(1)} <span className="text-xs font-bold text-slate-500 dark:text-slate-400">Kg</span>
                        </p>
                        <p className="text-[11px] text-slate-500 dark:text-slate-400 font-semibold mt-1">CO₂ Dikurangi</p>
                    </div>

                    {/* 2. Pohon */}
                    <div className="bg-white dark:bg-[#111827] border-t-4 border-t-emerald-600 dark:border-t-emerald-500 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 flex flex-col justify-center text-center shadow-sm transition-colors duration-200">
                        <div className="mb-2 flex justify-center text-emerald-600 dark:text-emerald-400">
                            <TreePine className="w-7 h-7" />
                        </div>
                        <p className="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                            {pohon.toFixed(2)}
                        </p>
                        <p className="text-[11px] text-slate-500 dark:text-slate-400 font-semibold mt-1">Pohon Diselamatkan</p>
                    </div>

                    {/* 3. Energi */}
                    <div className="bg-white dark:bg-[#111827] border-t-4 border-t-amber-500 dark:border-t-amber-400 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 flex flex-col justify-center text-center shadow-sm transition-colors duration-200">
                        <div className="mb-2 flex justify-center text-amber-500 dark:text-amber-400">
                            <Zap className="w-7 h-7" />
                        </div>
                        <p className="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                            {energi.toFixed(1)} <span className="text-xs font-bold text-slate-500 dark:text-slate-400">kWh</span>
                        </p>
                        <p className="text-[11px] text-slate-500 dark:text-slate-400 font-semibold mt-1">Energi Dihemat</p>
                    </div>

                    {/* 4. Air */}
                    <div className="bg-white dark:bg-[#111827] border-t-4 border-t-blue-500 dark:border-t-blue-400 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 flex flex-col justify-center text-center shadow-sm transition-colors duration-200">
                        <div className="mb-2 flex justify-center text-blue-500 dark:text-blue-400">
                            <Droplets className="w-7 h-7" />
                        </div>
                        <p className="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                            {air.toFixed(1)} <span className="text-xs font-bold text-slate-500 dark:text-slate-400">L</span>
                        </p>
                        <p className="text-[11px] text-slate-500 dark:text-slate-400 font-semibold mt-1">Air Dihemat</p>
                    </div>

                </div>

                {/* Monthly Activity Bar Chart (8 Kolom Desktop) */}
                <div className="lg:col-span-8 bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col justify-between transition-colors duration-200">
                    <div className="flex items-center justify-between mb-4">
                        <div className="flex items-center gap-2">
                            <BarChart3 className="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                            <h4 className="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                Aktivitas Setor Bulanan (Kg)
                            </h4>
                        </div>
                        <span className="text-[11px] text-slate-400 dark:text-slate-500 font-medium">6 Bulan Terakhir</span>
                    </div>

                    {/* Custom High-Fidelity SVG Bar Chart */}
                    <div className="w-full h-48 sm:h-52 flex items-end gap-3 sm:gap-6 pt-4 pb-2 border-b border-slate-100 dark:border-slate-800">
                        {labels.map((label, idx) => {
                            const val = data[idx] || 0;
                            const heightPct = Math.max(Math.round((val / maxVal) * 100), 6);

                            return (
                                <div key={idx} className="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                                    {/* Tooltip value */}
                                    <span className="text-[10px] font-bold text-emerald-700 dark:text-emerald-300 opacity-0 group-hover:opacity-100 transition-opacity bg-emerald-50 dark:bg-emerald-950 px-1.5 py-0.5 rounded border border-emerald-200 dark:border-emerald-800">
                                        {val} kg
                                    </span>
                                    {/* Bar Pillar */}
                                    <div
                                        className="w-full max-w-[36px] bg-emerald-600 dark:bg-emerald-500 group-hover:bg-emerald-500 dark:group-hover:bg-emerald-400 rounded-t-lg transition-all duration-300 shadow-sm"
                                        style={{ height: `${heightPct}%` }}
                                    />
                                    {/* Month Label */}
                                    <span className="text-[10px] sm:text-xs font-semibold text-slate-500 dark:text-slate-400 truncate max-w-full">
                                        {label.split(' ')[0]}
                                    </span>
                                </div>
                            );
                        })}
                    </div>

                    <div className="pt-3 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                        <span>Pilah rutin setiap minggu untuk meningkatkan rapor hijau.</span>
                        <span className="font-bold text-emerald-600 dark:text-emerald-400">Rapor Aktif</span>
                    </div>
                </div>

            </div>

        </section>
    );
}
