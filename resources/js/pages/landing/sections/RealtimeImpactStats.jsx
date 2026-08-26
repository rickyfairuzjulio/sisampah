import React from 'react';
import { Users, Scale, CheckCircle2, Truck, Sparkles, TrendingUp } from 'lucide-react';

export default function RealtimeImpactStats({ stats = {} }) {
    const nasabahCount = stats?.nasabah ?? 0;
    const sampahFormatted = stats?.sampah_formatted ?? (stats?.sampah_kg ? `${stats.sampah_kg} Kg` : '0 Kg');
    const transaksiCount = stats?.transaksi ?? 0;
    const petugasCount = stats?.petugas ?? 0;

    const statItems = [
        {
            icon: Users,
            value: `${nasabahCount}+`,
            label: 'Nasabah Aktif',
            description: 'Warga desa terdaftar dan aktif memilah sampah mandiri.',
            color: 'emerald',
        },
        {
            icon: Scale,
            value: sampahFormatted,
            label: 'Sampah Dikelola',
            description: 'Total tonase sampah anorganik yang berhasil diselamatkan dari TPA.',
            color: 'teal',
        },
        {
            icon: CheckCircle2,
            value: `${transaksiCount}+`,
            label: 'Transaksi Sukses',
            description: 'Penimbangan dan setoran sampah selesai divalidasi sistem.',
            color: 'emerald',
        },
        {
            icon: Truck,
            value: `${petugasCount}+`,
            label: 'Petugas Siaga',
            description: 'Armada penjemputan siap melayani area pemukiman warga.',
            color: 'teal',
        },
    ];

    return (
        <section id="dampak" className="relative py-20 lg:py-28 bg-[#051410] border-t border-white/[0.08] overflow-hidden">
            
            {/* Background lighting */}
            <div className="absolute -bottom-20 -left-20 w-[500px] h-[500px] bg-emerald-500/10 rounded-full blur-[140px] pointer-events-none" />

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 sm:space-y-16 relative z-10">
                
                {/* Section Header */}
                <div className="text-center max-w-3xl mx-auto space-y-4">
                    <div className="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold uppercase tracking-wider">
                        <TrendingUp className="w-3.5 h-3.5" />
                        <span>DATA DATABASE REAL-TIME</span>
                    </div>
                    <h2 className="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight">
                        Dampak Nyata Bersama <br className="hidden sm:block" />
                        <span className="text-[#22C55E]">Komunitas Warga SiSampah.</span>
                    </h2>
                    <p className="text-sm sm:text-base text-white/70 leading-relaxed">
                        Setiap kilogram sampah yang Anda pilah berkontribusi langsung pada kelestarian bumi dan perputaran ekonomi sirkular desa.
                    </p>
                </div>

                {/* 4 Stats Metric Grid */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    {statItems.map((item, idx) => {
                        const Icon = item.icon;
                        return (
                            <div 
                                key={idx}
                                className="rounded-3xl bg-[#061E17] border border-white/10 p-7 flex flex-col justify-between hover:border-emerald-500/40 transition-all duration-300 shadow-xl group"
                            >
                                <div className="space-y-4">
                                    <div className="w-12 h-12 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400 group-hover:scale-110 transition-transform">
                                        <Icon className="w-6 h-6" />
                                    </div>
                                    <div>
                                        <p className="text-3xl sm:text-4xl font-black text-white tracking-tight group-hover:text-emerald-300 transition-colors">
                                            {item.value}
                                        </p>
                                        <h3 className="text-sm font-bold text-emerald-400 uppercase tracking-wider mt-1">
                                            {item.label}
                                        </h3>
                                    </div>
                                    <p className="text-xs text-white/60 leading-relaxed">
                                        {item.description}
                                    </p>
                                </div>

                                <div className="mt-6 pt-4 border-t border-white/10 flex items-center gap-1.5 text-[11px] text-white/40">
                                    <span className="w-2 h-2 rounded-full bg-emerald-400 animate-pulse" />
                                    <span>Tersinkronisasi Database</span>
                                </div>
                            </div>
                        );
                    })}
                </div>

            </div>
        </section>
    );
}
