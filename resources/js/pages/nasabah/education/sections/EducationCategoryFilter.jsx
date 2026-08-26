import React from 'react';
import { Sparkles, Sprout, Wine, Lightbulb, Globe } from 'lucide-react';

export default function EducationCategoryFilter({
    categories = [],
    selectedCategory = 'all',
    onSelectCategory,
}) {
    const getCategoryIcon = (id) => {
        switch (id) {
            case 'organik':
                return Sprout;
            case 'plastik':
                return Wine;
            case 'kreasi':
                return Lightbulb;
            case 'zerowaste':
                return Globe;
            default:
                return Sparkles;
        }
    };

    return (
        <div className="flex items-center gap-2 overflow-x-auto pb-2 custom-scrollbar select-none">
            {categories.map((cat) => {
                const IconComponent = getCategoryIcon(cat.id);
                const isActive = selectedCategory === cat.id;

                return (
                    <button
                        key={cat.id}
                        type="button"
                        onClick={() => onSelectCategory(cat.id)}
                        className={`flex items-center gap-2 px-4 py-2.5 rounded-2xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap shadow-2xs ${
                            isActive
                                ? 'bg-emerald-600 text-white shadow-md hover:bg-emerald-700'
                                : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 hover:text-slate-900'
                        }`}
                    >
                        <IconComponent className={`w-3.5 h-3.5 ${isActive ? 'text-white' : 'text-emerald-600'}`} />
                        <span>{cat.name}</span>
                        <span
                            className={`px-1.5 py-0.2 rounded-full text-[10px] font-extrabold ${
                                isActive ? 'bg-emerald-800/60 text-white' : 'bg-slate-100 text-slate-500'
                            }`}
                        >
                            {cat.count || 0}
                        </span>
                    </button>
                );
            })}
        </div>
    );
}
