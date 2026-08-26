import React from 'react';
import { Trash2, MapPin, Scale, Wallet, ArrowRight, Sparkles } from 'lucide-react';

export default function HowItWorksSection() {
    const steps = [
        {
            number: '01',
            icon: Trash2,
            title: 'Pilah Sampah di Rumah',
            description: 'Kumpulkan dan pisahkan jenis sampah bernilai ekonomis seperti plastik, kardus, kaleng, atau minyak jelantah.',
            badge: 'Langkah Pertama',
        },
        {
            number: '02',
            icon: MapPin,
            title: 'Minta Jemput via GPS',
            description: 'Tentukan titik penjemputan di peta interaktif dan pilih perkiraan berat sampah yang ingin disetorkan.',
            badge: 'Otomatisasi GPS',
        },
        {
            number: '03',
            icon: Scale,
            title: 'Penimbangan Akurat',
            description: 'Petugas armada datang ke lokasi, melakukan penimbangan digital dengan data terkunci anti-manipulasi.',
            badge: 'Terkunci Aman',
        },
        {
            number: '04',
            icon: Wallet,
            title: 'Saldo Cair Otomatis',
            description: 'Hasil konversi rupiah langsung masuk ke dompet SiSampah Pay dan dapat dicairkan kapan saja.',
            badge: 'Cair Instan',
        },
    ];

    return (
        <section id="cara-kerja" className="relative py-20 lg:py-28 bg-[#03110D] border-t border-white/[0.08] overflow-hidden">
            
            {/* Background lighting */}
            <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[350px] bg-emerald-500/5 rounded-full blur-[140px] pointer-events-none" />

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-14 relative z-10">
                
                {/* Section Header */}
                <div className="text-center max-w-3xl mx-auto space-y-4">
                    <div className="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold uppercase tracking-wider">
                        <Sparkles className="w-3.5 h-3.5" />
                        <span>ALUR KERJA PRAKTIS</span>
                    </div>
                    <h2 className="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight">
                        4 Langkah Mudah Mengubah <br className="hidden sm:block" />
                        <span className="text-[#22C55E]">Sampah Menjadi Berkah.</span>
                    </h2>
                    <p className="text-sm sm:text-base text-white/70 leading-relaxed">
                        Tanpa perlu repot mengantar sendiri, nikmati kemudahan penjemputan armada hingga ke depan pintu rumah Anda.
                    </p>
                </div>

                {/* 4 Step Cards Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 relative">
                    
                    {steps.map((step, idx) => {
                        const Icon = step.icon;
                        return (
                            <div 
                                key={idx}
                                className="relative rounded-3xl bg-[#061E17] border border-white/10 p-7 flex flex-col justify-between hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 shadow-xl group"
                            >
                                <div className="space-y-4">
                                    
                                    {/* Number & Icon Header */}
                                    <div className="flex items-center justify-between">
                                        <div className="w-12 h-12 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400 group-hover:scale-110 transition-transform">
                                            <Icon className="w-6 h-6" />
                                        </div>
                                        <span className="text-3xl font-black text-white/20 group-hover:text-emerald-500/40 transition-colors">
                                            {step.number}
                                        </span>
                                    </div>

                                    {/* Badge */}
                                    <span className="inline-block px-2.5 py-0.5 rounded-full bg-white/5 border border-white/5 text-[11px] font-semibold text-emerald-300">
                                        {step.badge}
                                    </span>

                                    {/* Title & Description */}
                                    <h3 className="text-lg sm:text-xl font-black text-white tracking-tight group-hover:text-emerald-300 transition-colors">
                                        {step.title}
                                    </h3>
                                    <p className="text-xs sm:text-sm text-white/70 leading-relaxed">
                                        {step.description}
                                    </p>

                                </div>

                                {/* Step bottom indicator */}
                                <div className="mt-6 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-white/40">
                                    <span>Langkah {step.number}</span>
                                    <ArrowRight className="w-3.5 h-3.5 group-hover:text-emerald-400 group-hover:translate-x-1 transition-all" />
                                </div>

                            </div>
                        );
                    })}

                </div>

            </div>
        </section>
    );
}
