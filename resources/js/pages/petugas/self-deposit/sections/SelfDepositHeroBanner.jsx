import React from 'react';
import { ArrowDownToLine, MapPin, ShieldCheck, UserCheck } from 'lucide-react';

export default function SelfDepositHeroBanner({
    authData = {},
}) {
    const bankSampahName = authData?.bank_sampah_name || 'Unit Melati Asri';
    const officerName = authData?.user?.name || 'Petugas Teller';

    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-md p-6 sm:p-8 animate-slide-in select-none">
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

            <div className="relative z-10 space-y-3 max-w-3xl">
                <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-emerald-100">
                    <ArrowDownToLine className="w-4 h-4 text-emerald-200" />
                    <span>Mode Teller Pos Bank Sampah Unit</span>
                </div>

                <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight">
                    Penerimaan Setor Mandiri 🏢
                </h1>

                <p className="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
                    Input dan timbang sampah nasabah yang datang langsung ke kantor/pos Bank Sampah. Saldo otomatis terkredit ke dompet SiSampay nasabah atau diselesaikan secara tunai.
                </p>

                <div className="pt-1 flex flex-wrap items-center gap-2">
                    <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-black/15 text-xs font-semibold backdrop-blur-xs text-white/90">
                        <MapPin className="w-3.5 h-3.5 text-emerald-300" />
                        <span>{bankSampahName}</span>
                    </div>
                    <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-black/15 text-xs font-semibold backdrop-blur-xs text-white/90">
                        <ShieldCheck className="w-3.5 h-3.5 text-teal-300" />
                        <span>Teller: {officerName}</span>
                    </div>
                </div>
            </div>

        </div>
    );
}
