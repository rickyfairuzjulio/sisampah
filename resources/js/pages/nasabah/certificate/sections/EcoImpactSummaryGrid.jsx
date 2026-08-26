import React from 'react';
import { Scale, Wind, Trees, Zap } from 'lucide-react';

export default function EcoImpactSummaryGrid({
    stats = {},
    impact = {},
}) {
    const cards = [
        {
            title: 'Total Sampah Terkelola',
            value: `${(stats.total_berat || 0).toLocaleString('id-ID', { minimumFractionDigits: 1, maximumFractionDigits: 1 })} Kg`,
            subtitle: `Dari ${stats.total_transaksi || 0} kali transaksi penimbangan`,
            icon: Scale,
            bgIcon: 'bg-emerald-50 text-emerald-700 border-emerald-200',
        },
        {
            title: 'Reduksi Emisi Karbon',
            value: `${(impact.co2 || 0).toLocaleString('id-ID', { minimumFractionDigits: 1, maximumFractionDigits: 1 })} Kg CO₂e`,
            subtitle: 'Mencegah pemanasan global dari gas metana TPA',
            icon: Wind,
            bgIcon: 'bg-blue-50 text-blue-700 border-blue-200',
        },
        {
            title: 'Pohon Terselamatkan',
            value: `${(impact.pohon || 0).toLocaleString('id-ID', { minimumFractionDigits: 1, maximumFractionDigits: 1 })} Pohon`,
            subtitle: 'Setara menyerap karbon pohon hutan dewasa',
            icon: Trees,
            bgIcon: 'bg-teal-50 text-teal-700 border-teal-200',
        },
        {
            title: 'Energi Bersih Terhemat',
            value: `${(impact.energi || 0).toLocaleString('id-ID', { minimumFractionDigits: 1, maximumFractionDigits: 1 })} kWh`,
            subtitle: 'Efisiensi energi dari proses daur ulang sirkular',
            icon: Zap,
            bgIcon: 'bg-amber-50 text-amber-700 border-amber-200',
        },
    ];

    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 select-none print:hidden">
            {cards.map((card, idx) => {
                const IconComponent = card.icon;
                return (
                    <div
                        key={idx}
                        className="bg-white border border-slate-200 rounded-3xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-shadow space-y-3"
                    >
                        <div className="flex items-center justify-between">
                            <span className="text-xs font-bold text-slate-500 line-clamp-1">
                                {card.title}
                            </span>
                            <div className={`w-10 h-10 rounded-2xl border flex items-center justify-center font-bold shrink-0 shadow-2xs ${card.bgIcon}`}>
                                <IconComponent className="w-5 h-5" />
                            </div>
                        </div>

                        <div>
                            <div className="text-2xl font-black text-slate-900 tracking-tight">
                                {card.value}
                            </div>
                            <p className="text-[11px] text-slate-400 font-medium mt-1 line-clamp-1">
                                {card.subtitle}
                            </p>
                        </div>
                    </div>
                );
            })}
        </div>
    );
}
