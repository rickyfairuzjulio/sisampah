import React from 'react';

export default function WasteMarquee({ categories = [] }) {
    // Default categories if database has none or few
    const defaultList = [
        'Botol Plastik PET',
        'Kardus Box Cokelat',
        'Kaleng Aluminium',
        'Minyak Jelantah',
        'Besi Tua & Logam',
        'Kertas Arsip & HVS',
        'Tembaga & Kuningan',
        'Aki Bekas',
        'Plastik Keras HDPE',
        'Kaca & Botol Beling',
    ];

    const categoryNames = categories.length > 0
        ? categories.map(c => c.nama)
        : defaultList;

    // Duplicate list 3 times to ensure infinite smooth marquee loop without stutter
    const fullItems = [...categoryNames, ...categoryNames, ...categoryNames];

    return (
        <div className="relative w-full bg-[#03110D] border-y border-white/[0.08] py-4 overflow-hidden select-none">

            {/* Left & Right gradient fade masks */}
            <div className="absolute left-0 inset-y-0 w-24 sm:w-40 bg-gradient-to-r from-[#03110D] to-transparent z-10 pointer-events-none" />
            <div className="absolute right-0 inset-y-0 w-24 sm:w-40 bg-gradient-to-l from-[#03110D] to-transparent z-10 pointer-events-none" />

            <div className="flex w-max animate-marquee hover:[animation-play-state:paused]">
                {fullItems.map((item, idx) => (
                    <div key={idx} className="flex items-center mx-5 sm:mx-8">
                        <span className="text-xs sm:text-sm font-extrabold uppercase tracking-widest text-white/80 whitespace-nowrap hover:text-emerald-400 transition-colors">
                            {item}
                        </span>
                        <span className="ml-5 sm:ml-8 w-2 h-2 rounded-full bg-[#22C55E] shadow-[0_0_8px_#22C55E]" />
                    </div>
                ))}
            </div>
        </div>
    );
}
