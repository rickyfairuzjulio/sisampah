import React from 'react';

export default function BlankSpotInsights({ insights = [] }) {
    if (!insights || insights.length === 0) return null;

    return (
        <div className="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm space-y-4">
            <div className="flex items-center gap-3 pb-3 border-b border-slate-100">
                <div className="w-9 h-9 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center text-base font-black border border-amber-200">
                    💡
                </div>
                <div>
                    <h3 className="text-sm font-black text-slate-900">
                        Analisis Zona Cakupan & Rekomendasi Ekspansi Mitra
                    </h3>
                    <p className="text-[11px] text-slate-400">
                        Wilayah berpenduduk padat yang belum terlayani radius bank sampah aktif (*Blank Spots*).
                    </p>
                </div>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                {insights.map((item, idx) => (
                    <div
                        key={idx}
                        className="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2"
                    >
                        <div className="flex items-center gap-2">
                            <span className="w-2 h-2 rounded-full bg-amber-500" />
                            <h4 className="font-extrabold text-slate-900">{item.wilayah}</h4>
                        </div>
                        <p className="text-slate-600 leading-relaxed text-[11px]">
                            {item.deskripsi}
                        </p>
                        <div className="p-2.5 rounded-xl bg-amber-50/70 border border-amber-100 text-[11px] text-amber-900 font-semibold flex items-start gap-1.5">
                            <i className="bi bi-lightbulb-fill text-amber-600 mt-0.5" />
                            <span><strong>Saran Super Admin:</strong> {item.rekomendasi}</span>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}
