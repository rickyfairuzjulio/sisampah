import React from 'react';
import { Sparkles, CheckCircle2 } from 'lucide-react';

export default function AuthRightPanel() {
    return (
        <div className="hidden lg:flex lg:w-[45%] xl:w-1/2 relative overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-[#0D4A35] select-none">

            {/* 1. Subtle Radial Glow */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute bottom-0 left-0 w-80 h-80 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

            {/* 2. Decorative Vertical Dashed Divider */}
            <div className="absolute left-0 top-0 bottom-0 w-px border-l border-dashed border-white/20" />

            {/* 3. Main Content (Sleek Gradient & Clean Typography - Tanpa Foto & Tanpa Kartu Statistik) */}
            <div className="relative z-10 flex flex-col justify-between p-12 xl:p-16 w-full h-full">

                {/* Top Badge */}
                <div>
                    <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-white shadow-sm">
                        <Sparkles className="w-3.5 h-3.5 text-emerald-200" />
                        <span>Bank Sampah Digital Desa</span>
                    </div>
                </div>

                {/* Center Headline & Subtitle */}
                <div className="space-y-6 my-auto max-w-lg">
                    <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/15 text-sm font-semibold text-emerald-100">
                        <CheckCircle2 className="w-4 h-4 text-emerald-300" />
                        <span>Ekosistem Bersih & Terpercaya</span>
                    </div>

                    <h2 className="text-4xl xl:text-5xl font-black text-white leading-tight tracking-tight">
                        Ubah Sampah<br />
                        Menjadi <span className="text-emerald-300">Berkah</span>
                    </h2>

                    <p className="text-white/80 text-base sm:text-lg leading-relaxed font-normal">
                        Kelola sampah Anda dengan mudah, dapatkan saldo kas langsung, dan wujudkan desa yang asri bersama SiSampah.
                    </p>
                </div>

                {/* Bottom Logo & Copyright */}
                <div className="flex items-center justify-between pt-8 border-t border-white/15">
                    <p className="text-xs text-emerald-100/70 font-medium">
                        © Copytight 2026 SiSampah. Hak Cipta Dilindungi.
                        <br /> By Bodrex Developer
                        <br /> For Super Walisongo Information Technology Festival 2026
                    </p>
                    <div className="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center shadow-lg">
                        <img
                            src="/images/logo.png"
                            alt="SiSampah"
                            className="w-7 h-7 object-contain drop-shadow-sm"
                            onError={(e) => {
                                e.target.onerror = null;
                                e.target.src = 'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/sprout.svg';
                            }}
                        />
                    </div>
                </div>

            </div>

        </div>
    );
}
