import React from 'react';
import { Truck, Sparkles, Scale, ShieldCheck } from 'lucide-react';

export default function PickupHeroBanner() {
    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-sm p-6 sm:p-8 animate-slide-in select-none">
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

            <div className="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                
                {/* Text Content */}
                <div className="max-w-2xl space-y-2.5">
                    <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-emerald-100">
                        <Sparkles className="w-3.5 h-3.5 text-emerald-200" />
                        <span>Penjemputan Sampah Terjadwal</span>
                    </div>

                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight">
                        Layanan Jemput Sampah ke Rumah 🚛
                    </h1>

                    <p className="text-white/85 text-xs sm:text-sm lg:text-base leading-relaxed font-normal">
                        Petugas armada bank sampah siap menjemput sampah terpilah langsung dari depan pintu rumah Anda. Tentukan lokasi GPS dan perkiraan berat timbangan.
                    </p>
                </div>

                {/* Badges Right */}
                <div className="flex flex-wrap md:flex-col items-start md:items-end gap-2 shrink-0">
                    <div className="px-3.5 py-2 rounded-2xl bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-white flex items-center gap-2 shadow-sm">
                        <ShieldCheck className="w-4 h-4 text-emerald-300" />
                        <span>Armada Siap Melayani</span>
                    </div>
                    <div className="px-3 py-1.5 rounded-full bg-emerald-950/40 border border-emerald-400/30 text-emerald-200 text-xs font-semibold flex items-center gap-1.5">
                        <Scale className="w-3.5 h-3.5 text-emerald-300" />
                        <span>Minimal Total 5.0 Kg</span>
                    </div>
                </div>

            </div>

        </div>
    );
}
