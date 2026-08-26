import React from 'react';
import { Lock, CheckCircle2, Award, Sparkles } from 'lucide-react';

export default function BadgesShowcaseSection({
    badges = [],
    stats = {},
}) {
    const currentWeight = stats.total_berat || 0;

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6 select-none print:hidden">
            
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                <div>
                    <div className="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-[11px] font-extrabold mb-1">
                        <Sparkles className="w-3 h-3" />
                        <span>Roadmap Gamifikasi Lingkungan</span>
                    </div>
                    <h3 className="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">
                        Etalase Lencana Penghargaan Nasabah
                    </h3>
                    <p className="text-xs text-slate-500 mt-0.5">
                        Tingkatkan setoran sampah terpilah untuk membuka lencana kehormatan eksklusif berikutnya.
                    </p>
                </div>

                <div className="text-left sm:text-right">
                    <span className="text-[11px] font-bold text-slate-400 block uppercase">Progres Saat Ini</span>
                    <span className="text-sm font-black text-emerald-700">
                        {currentWeight.toLocaleString('id-ID', { minimumFractionDigits: 1 })} Kg Sampah
                    </span>
                </div>
            </div>

            {/* Badges Grid */}
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {badges.map((badge) => {
                    const isUnlocked = badge.unlocked;
                    const progressPercent = Math.min(100, Math.round((currentWeight / badge.target_kg) * 100));

                    return (
                        <div
                            key={badge.id}
                            className={`rounded-3xl p-5 border transition-all relative overflow-hidden flex flex-col justify-between ${
                                isUnlocked
                                    ? 'bg-gradient-to-b from-emerald-50/50 to-white border-emerald-300 shadow-sm'
                                    : 'bg-slate-50/60 border-slate-200 opacity-80'
                            }`}
                        >
                            {/* Status Pill */}
                            <div className="flex items-center justify-between gap-2 mb-4">
                                <span className="text-2xl">{badge.icon}</span>
                                {isUnlocked ? (
                                    <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black border border-emerald-200">
                                        <CheckCircle2 className="w-3 h-3 text-emerald-600" />
                                        <span>Terbuka</span>
                                    </span>
                                ) : (
                                    <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-slate-200 text-slate-600 text-[10px] font-bold">
                                        <Lock className="w-3 h-3 text-slate-400" />
                                        <span>Terkunci</span>
                                    </span>
                                )}
                            </div>

                            {/* Badge Info */}
                            <div className="space-y-1 mb-4">
                                <h4 className="font-black text-sm text-slate-900 leading-tight">
                                    {badge.name}
                                </h4>
                                <span className="text-[10px] font-bold text-amber-700 uppercase tracking-wider block">
                                    Tingkat {badge.tier}
                                </span>
                                <p className="text-[11px] text-slate-500 leading-relaxed pt-1">
                                    {badge.description}
                                </p>
                            </div>

                            {/* Progress bar towards target */}
                            <div className="space-y-1.5 pt-2 border-t border-slate-100">
                                <div className="flex items-center justify-between text-[10px] font-bold">
                                    <span className={isUnlocked ? 'text-emerald-700' : 'text-slate-500'}>
                                        Target: {badge.target_kg} Kg
                                    </span>
                                    <span className="text-slate-600">
                                        {progressPercent}%
                                    </span>
                                </div>
                                <div className="w-full h-2 bg-slate-200 rounded-full overflow-hidden">
                                    <div
                                        className={`h-full rounded-full transition-all duration-500 ${
                                            isUnlocked ? 'bg-emerald-600' : 'bg-slate-400'
                                        }`}
                                        style={{ width: `${progressPercent}%` }}
                                    />
                                </div>
                            </div>
                        </div>
                    );
                })}
            </div>

        </div>
    );
}
