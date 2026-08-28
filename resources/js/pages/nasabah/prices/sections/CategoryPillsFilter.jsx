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
                            className={`px-4 py-2.5 rounded-full whitespace-nowrap font-bold text-xs sm:text-sm transition-all flex items-center gap-2 border cursor-pointer ${
                                isActive
                                    ? 'bg-rose-500 text-white border-rose-600 shadow-sm'
                                    : 'bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300 hover:bg-rose-100 dark:hover:bg-rose-900/60 border-rose-200 dark:border-rose-800 shadow-sm'
                            }`}
                        >
                            <IconComponent className={`w-4 h-4 ${isActive ? 'text-white fill-white' : 'text-rose-500 fill-rose-500'}`} />
                            <span>{tab.label}</span>
                            <span className={`px-2 py-0.5 rounded-full text-[11px] font-black ${
                                isActive ? 'bg-white/20 text-white' : 'bg-rose-200 dark:bg-rose-900 text-rose-800 dark:text-rose-200'
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
                        className={`px-4 py-2.5 rounded-full whitespace-nowrap font-bold text-xs sm:text-sm transition-all flex items-center gap-2 border cursor-pointer ${
                            isActive
                                ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm'
                                : 'bg-white dark:bg-[#111827] text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 border-slate-200 dark:border-slate-800 shadow-sm'
                        }`}
                    >
                        <IconComponent className={`w-4 h-4 ${isActive ? 'text-white' : 'text-slate-500 dark:text-slate-400'}`} />
                        <span>{tab.label}</span>
                        <span className={`px-2 py-0.5 rounded-full text-[11px] font-black ${
                            isActive ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400'
                        }`}>
                            {tab.count}
                        </span>
                    </button>
                );
            })}
        </div>
    );
}
