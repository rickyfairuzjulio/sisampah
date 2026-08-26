import React from 'react';
import { Clock, CheckCircle, Image as ImageIcon, Scale } from 'lucide-react';

export default function RecentWeighingHistory({ 
    recentWeighings = [] 
}) {
    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-2xs space-y-4 select-none">
            <div className="flex items-center justify-between pb-2 border-b border-slate-100">
                <div className="flex items-center gap-2">
                    <div className="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <CheckCircle className="w-4 h-4" />
                    </div>
                    <h3 className="font-extrabold text-sm sm:text-base text-slate-900 tracking-tight">
                        Riwayat Penimbangan Selesai
                    </h3>
                </div>
                <span className="text-[11px] font-bold text-slate-400">
                    Hari Ini
                </span>
            </div>

            {(!recentWeighings || recentWeighings.length === 0) ? (
                <div className="py-8 text-center space-y-2">
                    <Scale className="w-8 h-8 text-slate-300 mx-auto" />
                    <p className="text-xs text-slate-500 font-medium">
                        Belum ada transaksi penimbangan yang diselesaikan hari ini.
                    </p>
                </div>
            ) : (
                <div className="space-y-3">
                    {recentWeighings.map((item) => (
                        <div
                            key={item.id}
                            className="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/60 hover:bg-emerald-50/30 transition-colors flex items-center justify-between gap-3"
                        >
                            <div className="min-w-0 space-y-0.5">
                                <p className="font-extrabold text-xs text-slate-900 truncate">
                                    {item.user_name}
                                </p>
                                <div className="flex items-center gap-1.5 text-[11px] text-slate-500">
                                    <span className="font-semibold text-emerald-700">{item.category_name}</span>
                                    <span>•</span>
                                    <span>{Number(item.berat_kg).toFixed(1)} Kg</span>
                                </div>
                            </div>

                            <div className="text-right shrink-0 space-y-0.5">
                                <p className="font-black text-xs text-emerald-700">
                                    +{item.total_rp_formatted}
                                </p>
                                <div className="flex items-center justify-end gap-1 text-[10px] text-slate-400">
                                    <Clock className="w-3 h-3" />
                                    <span>{item.time_formatted}</span>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
}
