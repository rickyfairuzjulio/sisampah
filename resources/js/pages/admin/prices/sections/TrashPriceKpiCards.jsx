import React from 'react';
import { Tag, DollarSign, TrendingUp, TrendingDown } from 'lucide-react';

export default function TrashPriceKpiCards({
    statistics = {},
}) {
    const totalCategories = statistics?.total_categories || 18;
    const highestPrice = statistics?.highest_price_formatted || 'Rp 15.000 / kg';
    const priceUp = statistics?.price_up_count || 4;
    const priceDown = statistics?.price_down_count || 2;

    const cards = [
        {
            title: 'Total Kategori Sampah',
            value: `${totalCategories} Jenis`,
            subtitle: 'Material terdaftar di pos unit',
            icon: Tag,
            accentColor: 'text-emerald-600',
            bgColor: 'bg-emerald-50',
            borderColor: 'border-emerald-200/80',
            badge: 'Katalog Aktif',
            badgeColor: 'bg-emerald-100 text-emerald-800 border-emerald-200',
        },
        {
            title: 'Harga Beli Tertinggi',
            value: highestPrice,
            subtitle: 'Komoditas nilai ekonomis puncak',
            icon: DollarSign,
            accentColor: 'text-purple-600',
            bgColor: 'bg-purple-50',
            borderColor: 'border-purple-200/80',
            badge: 'Logam Super',
            badgeColor: 'bg-purple-100 text-purple-800 border-purple-200',
        },
        {
            title: 'Komoditas Tren Naik',
            value: `${priceUp} Kategori`,
            subtitle: 'Kenaikan harga minggu ini',
            icon: TrendingUp,
            accentColor: 'text-emerald-600',
            bgColor: 'bg-emerald-50',
            borderColor: 'border-emerald-200/80',
            badge: '▲ Pasar Naik',
            badgeColor: 'bg-emerald-100 text-emerald-800 border-emerald-200',
        },
        {
            title: 'Komoditas Tren Turun',
            value: `${priceDown} Kategori`,
            subtitle: 'Penyesuaian pabrik offtaker',
            icon: TrendingDown,
            accentColor: 'text-rose-600',
            bgColor: 'bg-rose-50',
            borderColor: 'border-rose-200/80',
            badge: '▼ Pasar Turun',
            badgeColor: 'bg-rose-100 text-rose-800 border-rose-200',
        },
    ];

    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 select-none">
            {cards.map((item, idx) => {
                const IconComponent = item.icon;
                return (
                    <div
                        key={idx}
                        className={`bg-white border ${item.borderColor} rounded-3xl p-5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between space-y-4`}
                    >
                        <div className="flex items-center justify-between">
                            <div className={`w-11 h-11 rounded-2xl flex items-center justify-center font-bold ${item.bgColor} ${item.accentColor} shadow-2xs`}>
                                <IconComponent className="w-5 h-5" />
                            </div>
                            <span className={`px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border ${item.badgeColor}`}>
                                {item.badge}
                            </span>
                        </div>

                        <div className="space-y-1">
                            <p className="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {item.title}
                            </p>
                            <h3 className="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                                {item.value}
                            </h3>
                            <p className="text-xs text-slate-400 font-medium truncate">
                                {item.subtitle}
                            </p>
                        </div>
                    </div>
                );
            })}
        </div>
    );
}
