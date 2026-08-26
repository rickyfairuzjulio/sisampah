import React from 'react';
import { BookOpen, CheckCircle2, FileEdit, Eye } from 'lucide-react';

export default function ArticlesKpiCards({
    statistics = {},
}) {
    const total = statistics?.total_articles || 12;
    const published = statistics?.published_count || 10;
    const draft = statistics?.draft_count || 2;
    const views = statistics?.total_views || 3420;

    const cards = [
        {
            title: 'Total Artikel Terdata',
            value: `${total} Konten`,
            subtitle: 'Seluruh materi edukasi unit',
            icon: BookOpen,
            accentColor: 'text-emerald-600',
            bgColor: 'bg-emerald-50',
            borderColor: 'border-emerald-200/80',
            badge: 'Pustaka Unit',
            badgeColor: 'bg-emerald-100 text-emerald-800 border-emerald-200',
        },
        {
            title: 'Artikel Diterbitkan',
            value: `${published} Terbit`,
            subtitle: 'Tayang di portal nasabah & publik',
            icon: CheckCircle2,
            accentColor: 'text-teal-600',
            bgColor: 'bg-teal-50',
            borderColor: 'border-teal-200/80',
            badge: 'Publik Aktif',
            badgeColor: 'bg-teal-100 text-teal-800 border-teal-200',
        },
        {
            title: 'Draf & Tinjauan',
            value: `${draft} Draf`,
            subtitle: 'Belum ditayangkan ke warga',
            icon: FileEdit,
            accentColor: 'text-amber-600',
            bgColor: 'bg-amber-50',
            borderColor: 'border-amber-200/80',
            badge: 'Penyusunan',
            badgeColor: 'bg-amber-100 text-amber-800 border-amber-200',
        },
        {
            title: 'Total Tayangan Pembaca',
            value: `${views.toLocaleString('id-ID')} Views`,
            subtitle: 'Tingkat keterbacaan materi',
            icon: Eye,
            accentColor: 'text-blue-600',
            bgColor: 'bg-blue-50',
            borderColor: 'border-blue-200/80',
            badge: 'Tinggi',
            badgeColor: 'bg-blue-100 text-blue-800 border-blue-200',
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
