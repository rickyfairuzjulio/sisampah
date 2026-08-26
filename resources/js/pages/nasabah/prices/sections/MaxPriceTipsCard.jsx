import React from 'react';
import { Lightbulb, CheckCircle, ArrowRight } from 'lucide-react';

export default function MaxPriceTipsCard() {
    const tips = [
        {
            title: 'Kering & Bersih',
            desc: 'Pastikan sampah dalam keadaan kering dan terbebas dari sisa makanan atau minyak.',
        },
        {
            title: 'Pisahkan Tutup & Label',
            desc: 'Untuk botol plastik PET, pisahkan tutup botol dan segel plastik labelnya.',
        },
        {
            title: 'Pipihkan & Ikat Rapi',
            desc: 'Lipat kardus/karton secara pipih dan ikat dengan rapi untuk memudahkan penimbangan.',
        },
    ];

    return (
        <div className="bg-gradient-to-br from-emerald-50 to-teal-50/50 border border-emerald-200 rounded-3xl p-6 sm:p-8 shadow-sm select-none">
            <div className="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                
                {/* Header Left */}
                <div className="flex items-start gap-4 max-w-md">
                    <div className="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xl shrink-0 shadow-md">
                        <Lightbulb className="w-6 h-6 text-emerald-100" />
                    </div>
                    <div>
                        <h3 className="font-extrabold text-slate-900 text-base sm:text-lg tracking-tight">
                            Tips Nilai Timbangan Maksimal 💡
                        </h3>
                        <p className="text-xs text-slate-600 mt-1 leading-relaxed">
                            Ikuti langkah pemilahan standar SNI berikut agar setoran sampah Anda dinilai dengan grade harga tertinggi.
                        </p>
                    </div>
                </div>

                {/* 3 Tips Columns */}
                <div className="grid grid-cols-1 sm:grid-cols-3 gap-3.5 flex-1 w-full">
                    {tips.map((tip, idx) => (
                        <div 
                            key={idx}
                            className="bg-white/80 backdrop-blur-sm border border-emerald-200/80 p-3.5 rounded-2xl shadow-2xs flex flex-col justify-between"
                        >
                            <div className="flex items-center gap-2 mb-1">
                                <span className="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black flex items-center justify-center shrink-0">
                                    {idx + 1}
                                </span>
                                <h4 className="font-bold text-xs text-slate-900 line-clamp-1">
                                    {tip.title}
                                </h4>
                            </div>
                            <p className="text-[11px] text-slate-500 leading-relaxed">
                                {tip.desc}
                            </p>
                        </div>
                    ))}
                </div>

            </div>
        </div>
    );
}
