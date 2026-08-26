import React from 'react';
import { Layers, Sprout, RefreshCw, Zap, Heart } from 'lucide-react';

export default function CategoryPillsFilter({
    activeCategory = 'all',
    categoryCounts = {},
    onSelectCategory,
}) {
    const tabs = [
        {
            key: 'all',
            label: 'Semua Kategori',
            icon: Layers,
            count: categoryCounts?.all || 0,
        },
        {
            key: 'organik',
            label: 'Organik',
            icon: Sprout,
            count: categoryCounts?.organik || 0,
        },
        {
            key: 'anorganik',
            label: 'Anorganik',
            icon: RefreshCw,
            count: categoryCounts?.anorganik || 0,
        },
        {
            key: 'b3',
            label: 'B3 & Elektronik',
            icon: Zap,
            count: categoryCounts?.b3 || 0,
        },
        {
            key: 'favorites',
            label: 'Favorit Saya',
            icon: Heart,
            count: categoryCounts?.favorites || 0,
            isFavorite: true,
        },
    ];

    const handleCategoryClick = (key) => {
        if (onSelectCategory) {
            onSelectCategory(key);
        } else {
            const params = new URLSearchParams(window.location.search);
            if (key === 'all') {
                params.delete('kategori');
            } else {
                params.set('kategori', key);
            }
            window.location.search = params.toString();
        }
    };

    return (
        <div className="w-full flex items-center gap-2.5 overflow-x-auto pb-1 no-scrollbar select-none">
            {tabs.map((tab) => {
                const IconComponent = tab.icon;
                const isActive = activeCategory === tab.key;

                if (tab.isFavorite) {
                    return (
                        <button
                            key={tab.key}
                            onClick={() => handleCategoryClick(tab.key)}
                            className={`px-4 py-2.5 rounded-full whitespace-nowrap font-bold text-xs sm:text-sm transition-all flex items-center gap-2 border ${
                                isActive
                                    ? 'bg-red-500 text-white border-red-600 shadow-sm'
                                    : 'bg-red-50 text-red-700 hover:bg-red-100 border-red-200 shadow-sm'
                            }`}
                        >
                            <IconComponent className={`w-4 h-4 ${isActive ? 'text-white fill-white' : 'text-red-500 fill-red-500'}`} />
                            <span>{tab.label}</span>
                            <span className={`px-2 py-0.5 rounded-full text-[11px] font-black ${
                                isActive ? 'bg-white/20 text-white' : 'bg-red-200 text-red-800'
                            }`}>
                                {tab.count}
                            </span>
                        </button>
                    );
                }

                return (
                    <button
                        key={tab.key}
                        onClick={() => handleCategoryClick(tab.key)}
                        className={`px-4 py-2.5 rounded-full whitespace-nowrap font-bold text-xs sm:text-sm transition-all flex items-center gap-2 border ${
                            isActive
                                ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm'
                                : 'bg-white text-slate-700 hover:bg-slate-50 border-slate-200 shadow-sm'
                        }`}
                    >
                        <IconComponent className={`w-4 h-4 ${isActive ? 'text-white' : 'text-slate-500'}`} />
                        <span>{tab.label}</span>
                        <span className={`px-2 py-0.5 rounded-full text-[11px] font-black ${
                            isActive ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600'
                        }`}>
                            {tab.count}
                        </span>
                    </button>
                );
            })}
        </div>
    );
}
