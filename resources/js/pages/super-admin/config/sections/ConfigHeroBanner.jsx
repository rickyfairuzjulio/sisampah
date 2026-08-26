import React from 'react';

export default function ConfigHeroBanner() {
    return (
        <div className="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#047857] via-[#115E59] to-[#0F172A] p-7 md:p-8 text-white shadow-xl">
            {/* Background Decorative Circles */}
            <div className="absolute -top-12 -right-12 w-64 h-64 rounded-full bg-emerald-400/10 blur-2xl pointer-events-none" />
            <div className="absolute -bottom-16 -left-16 w-64 h-64 rounded-full bg-teal-400/10 blur-2xl pointer-events-none" />

            <div className="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div className="space-y-2.5 max-w-2xl">
                    <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 text-xs font-extrabold uppercase tracking-wider backdrop-blur-xs">
                        <span>⚙️</span>
                        <span>Tata Kelola Kebijakan & Parameter Global</span>
                    </div>

                    <h1 className="text-2xl sm:text-3xl font-black tracking-tight text-white flex items-center gap-3">
                        <span>Konfigurasi Wilayah & Parameter Sistem</span>
                        <span>⚙️</span>
                    </h1>

                    <p className="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
                        Atur standar jangkauan radius armada nasional, ambang batas penarikan saldo, gateway notifikasi WhatsApp, dan kontrol saklar modul fitur platform SiSampah.
                    </p>
                </div>

                <div className="flex flex-wrap items-center gap-3 shrink-0">
                    <a
                        href="/super-admin/audit-logs"
                        className="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/20 backdrop-blur-xs transition-all active:scale-95 shadow-xs"
                    >
                        <i className="bi bi-clock-history text-emerald-300" />
                        <span>Lihat Audit Log</span>
                    </a>
                </div>
            </div>
        </div>
    );
}
