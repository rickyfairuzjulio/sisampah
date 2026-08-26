import React from 'react';

export default function VerificationHeroBanner({ totalPending = 0 }) {
    return (
        <div className="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#047857] via-[#115E59] to-[#0F172A] p-7 md:p-9 text-white shadow-xl shadow-emerald-950/10 border border-emerald-500/20">
            {/* Background Aesthetic Orbs & Patterns */}
            <div className="absolute top-0 right-0 -mr-16 -mt-16 w-80 h-80 rounded-full bg-emerald-400/10 blur-3xl pointer-events-none" />
            <div className="absolute bottom-0 right-1/4 -mb-20 w-64 h-64 rounded-full bg-teal-400/10 blur-2xl pointer-events-none" />

            <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div className="max-w-2xl">
                    <div className="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/30 text-xs font-bold mb-3 tracking-wide">
                        <span>🛡️</span>
                        <span>Otorisasi & Akreditasi Unit Mitra</span>
                        {totalPending > 0 && (
                            <span className="ml-1 px-2 py-0.5 rounded-full bg-amber-400 text-slate-900 font-extrabold text-[10px]">
                                {totalPending} Perlu Tindakan
                            </span>
                        )}
                    </div>
                    
                    <h1 className="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight leading-tight mb-2">
                        Antrean Verifikasi Bank Sampah 📋
                    </h1>
                    
                    <p className="text-emerald-100/90 text-sm md:text-base leading-relaxed">
                        Tinjau legalitas dokumen SK, kelayakan fasilitas gudang & timbangan digital, jadwalkan visitasi lapangan, dan otorisasi permohonan kemitraan unit bank sampah baru.
                    </p>
                </div>

                <div className="flex flex-wrap items-center gap-3">
                    <a
                        href="/super-admin/master-bank-sampah"
                        className="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-sm backdrop-blur-md border border-white/20 transition-all duration-200 shadow-sm active:scale-95"
                    >
                        <span>🏢</span>
                        <span>Master Bank Sampah</span>
                    </a>
                    <a
                        href="/super-admin/peta-sebaran"
                        className="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-sm transition-all duration-200 shadow-lg shadow-emerald-500/25 active:scale-95"
                    >
                        <span>🗺️</span>
                        <span>Peta Sebaran</span>
                    </a>
                </div>
            </div>
        </div>
    );
}
