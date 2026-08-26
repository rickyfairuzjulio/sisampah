import React, { useState } from 'react';
import { Printer, Share2, Check, Sparkles, Award } from 'lucide-react';

export default function CertificateHeroBanner({
    stats = {},
    certificateDetails = {},
}) {
    const [copied, setCopied] = useState(false);

    const handlePrint = () => {
        window.print();
    };

    const handleShare = () => {
        const url = certificateDetails?.verification_url || window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            setCopied(true);
            setTimeout(() => setCopied(false), 3000);
        });
    };

    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-md p-6 sm:p-8 animate-slide-in select-none print:hidden">
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

            <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                
                <div className="space-y-3 max-w-2xl">
                    <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-emerald-100">
                        <Award className="w-4 h-4 text-amber-300" />
                        <span>Penghargaan Resmi SiSampah 2026</span>
                    </div>

                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight">
                        Piagam & Sertifikat Dampak Lingkungan
                    </h1>

                    <p className="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
                        Apresiasi resmi atas dedikasi dan kontribusi nyata Anda dalam mereduksi emisi karbon, menyelamatkan pohon, dan mendorong ekonomi sirkular desa bersama SiSampah.
                    </p>

                    <div className="flex items-center gap-2 pt-1 text-xs text-emerald-200/90 font-mono">
                        <span>No. Registrasi: {certificateDetails.cert_number || 'SMP-CERT/2026/08/0001'}</span>
                        <span>•</span>
                        <span className="font-sans font-medium">{stats.level_text || 'Level 1'} ({stats.badge_name || 'Warga Peduli'})</span>
                    </div>
                </div>

                {/* Action Buttons */}
                <div className="flex flex-wrap sm:flex-nowrap items-center gap-3 shrink-0">
                    
                    <button
                        type="button"
                        onClick={handlePrint}
                        className="px-6 py-3.5 rounded-2xl bg-white text-emerald-800 hover:bg-emerald-50 active:bg-emerald-100 font-extrabold text-xs sm:text-sm shadow-sm hover:shadow-md transition-all flex items-center gap-2.5 cursor-pointer hover:-translate-y-0.5"
                    >
                        <Printer className="w-4 h-4 text-emerald-700" />
                        <span>Cetak / Unduh PDF</span>
                    </button>

                    <button
                        type="button"
                        onClick={handleShare}
                        className="px-5 py-3.5 rounded-2xl bg-white/15 hover:bg-white/25 text-white border border-white/20 font-bold text-xs sm:text-sm backdrop-blur-md transition-all flex items-center gap-2 hover:-translate-y-0.5 cursor-pointer"
                        title="Salin tautan sertifikat"
                    >
                        {copied ? <Check className="w-4 h-4 text-emerald-300" /> : <Share2 className="w-4 h-4 text-emerald-300" />}
                        <span>{copied ? 'Tautan Disalin!' : 'Bagikan'}</span>
                    </button>

                </div>

            </div>

        </div>
    );
}
