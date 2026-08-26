import React from 'react';
import { Award, ShieldCheck, CheckCircle2, QrCode } from 'lucide-react';

export default function DigitalCertificateCanvas({
    authData = {},
    stats = {},
    impact = {},
    certificateDetails = {},
}) {
    const user = authData?.user || {};
    const bankSampahName = authData?.bank_sampah_name || 'Unit Melati Asri';

    return (
        <div id="certificate-canvas-wrapper" className="bg-white border border-slate-200 rounded-3xl p-4 sm:p-8 shadow-sm overflow-hidden select-none print:p-0 print:border-none print:shadow-none print:bg-white">

            {/* Action/Heading Header for Web View */}
            <div className="flex items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100 print:hidden">
                <div>
                    <h3 className="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">
                        Pratinjau Lembar Piagam Resmi
                    </h3>
                    <p className="text-xs text-slate-500 mt-0.5">
                        Format cetak standar A4 siap diprint atau disimpan sebagai dokumen PDF resmi.
                    </p>
                </div>

                <div className="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-bold">
                    <ShieldCheck className="w-4 h-4 text-emerald-600" />
                    <span>Dokumen Terotentikasi</span>
                </div>
            </div>

            {/* A4 CERTIFICATE CANVAS CONTAINER */}
            <div className="w-full overflow-x-auto pb-4 flex justify-center print:overflow-visible print:p-0 print:m-0">
                <div
                    id="certificate-print-area"
                    className="w-[794px] min-h-[1080px] bg-[#FCFDFE] text-slate-800 p-10 sm:p-12 relative flex flex-col justify-between shadow-lg rounded-2xl border-8 border-emerald-800/90 print:shadow-none print:m-0 print:w-full print:border-8 print:border-emerald-800 print:rounded-none"
                    style={{
                        backgroundImage: 'radial-gradient(#E2E8F0 0.75px, transparent 0.75px)',
                        backgroundSize: '24px 24px',
                    }}
                >
                    {/* Inner Golden Double Border */}
                    <div className="absolute inset-3.5 border-2 border-amber-500/60 rounded-lg pointer-events-none" />
                    <div className="absolute inset-5 border border-emerald-600/30 rounded pointer-events-none" />

                    {/* Corner Ornaments */}
                    <div className="absolute top-6 left-6 w-8 h-8 border-t-2 border-l-2 border-amber-600 pointer-events-none" />
                    <div className="absolute top-6 right-6 w-8 h-8 border-t-2 border-r-2 border-amber-600 pointer-events-none" />
                    <div className="absolute bottom-6 left-6 w-8 h-8 border-b-2 border-l-2 border-amber-600 pointer-events-none" />
                    <div className="absolute bottom-6 right-6 w-8 h-8 border-b-2 border-r-2 border-amber-600 pointer-events-none" />

                    {/* Center Watermark Logo */}
                    <div className="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.035]">
                        <img src="/images/logo.png" alt="Watermark" className="w-[450px] h-[450px] object-contain" />
                    </div>

                    {/* Top Content Area */}
                    <div className="relative z-10 space-y-8">

                        {/* Header Lembaga & Nomor Piagam */}
                        <div className="flex items-center justify-between border-b-2 border-emerald-700/80 pb-5">
                            <div className="flex items-center gap-3">
                                <img
                                    src="/images/logo.png"
                                    alt="SiSampah"
                                    className="w-12 h-12 object-contain"
                                    onError={(e) => {
                                        e.target.onerror = null;
                                        e.target.src = 'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/sprout.svg';
                                    }}
                                />
                                <div>
                                    <div className="flex items-center gap-1">
                                        <span className="font-black text-2xl tracking-tight text-slate-900">SiSampah</span>
                                        <span className="w-2 h-2 rounded-full bg-emerald-600 inline-block mb-1" />
                                    </div>
                                    <p className="text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                                        Sistem Informasi Sampah
                                    </p>
                                </div>
                            </div>

                            <div className="text-right space-y-0.5">
                                <span className="inline-block text-[10px] font-extrabold uppercase tracking-widest text-emerald-800 bg-emerald-100/80 px-2.5 py-0.5 rounded-full border border-emerald-200">
                                    TAHUN {certificateDetails.year || '2026'}
                                </span>
                                <p className="text-[11px] font-mono font-bold text-slate-600">
                                    {certificateDetails.cert_number || 'SMP-CERT/2026/08/0001'}
                                </p>
                            </div>
                        </div>

                        {/* Title & Recipient */}
                        <div className="text-center space-y-3 pt-2">
                            <p className="text-xs font-extrabold tracking-[0.25em] text-amber-700 uppercase">
                                PIAGAM PENGHARGAAN KEHORMATAN
                            </p>

                            <h2 className="text-2xl sm:text-3xl font-black tracking-tight text-emerald-950 uppercase font-serif">
                                SERTIFIKAT DAMPAK LINGKUNGAN
                            </h2>

                            <div className="w-24 h-1 bg-gradient-to-r from-amber-400 via-emerald-600 to-amber-400 mx-auto rounded-full mt-2" />

                            <p className="text-xs text-slate-500 font-medium tracking-wide uppercase pt-2">
                                Diberikan dengan bangga dan rasa hormat kepada:
                            </p>

                            <h1 className="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight py-2 font-serif underline decoration-amber-400/80 decoration-2 underline-offset-8">
                                {user?.name || 'Ahmad Fauzi'}
                            </h1>

                            <div className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-800 mt-1">
                                <span>Nasabah Aktif {bankSampahName}</span>
                                <span>•</span>
                                <span>Peringkat #{stats.rank || 1} ({stats.badge_name || 'Warga Peduli'})</span>
                            </div>

                            <p className="max-w-xl mx-auto text-xs sm:text-sm text-slate-600 leading-relaxed pt-3">
                                Atas dedikasi berkelanjutan, partisipasi aktif, dan kontribusi nyata dalam pengelolaan sampah pilahan serta pelestarian lingkungan hidup demi bumi yang lebih hijau dan lestari.
                            </p>
                        </div>

                        {/* Summary Metrics Grid */}
                        <div className="grid grid-cols-4 gap-3 pt-2 max-w-2xl mx-auto">
                            <div className="bg-slate-50/90 border border-slate-200/90 rounded-2xl p-3.5 text-center">
                                <span className="text-[10px] font-bold text-slate-500 uppercase block">Sampah Terkelola</span>
                                <span className="text-base sm:text-lg font-black text-slate-900">
                                    {(stats.total_berat || 0).toLocaleString('id-ID', { minimumFractionDigits: 1 })} Kg
                                </span>
                            </div>

                            <div className="bg-slate-50/90 border border-slate-200/90 rounded-2xl p-3.5 text-center">
                                <span className="text-[10px] font-bold text-slate-500 uppercase block">Reduksi CO₂</span>
                                <span className="text-base sm:text-lg font-black text-emerald-700">
                                    {(impact.co2 || 0).toLocaleString('id-ID', { minimumFractionDigits: 1 })} Kg
                                </span>
                            </div>

                            <div className="bg-slate-50/90 border border-slate-200/90 rounded-2xl p-3.5 text-center">
                                <span className="text-[10px] font-bold text-slate-500 uppercase block">Pohon Selamat</span>
                                <span className="text-base sm:text-lg font-black text-teal-700">
                                    {(impact.pohon || 0).toLocaleString('id-ID', { minimumFractionDigits: 1 })} Pohon
                                </span>
                            </div>

                            <div className="bg-slate-50/90 border border-slate-200/90 rounded-2xl p-3.5 text-center">
                                <span className="text-[10px] font-bold text-slate-500 uppercase block">Hemat Energi</span>
                                <span className="text-base sm:text-lg font-black text-amber-700">
                                    {(impact.energi || 0).toLocaleString('id-ID', { minimumFractionDigits: 1 })} kWh
                                </span>
                            </div>
                        </div>

                    </div>

                    {/* Bottom Legal, Seal & Signatures Area */}
                    <div className="relative z-10 pt-8 mt-6 border-t border-slate-200/80 flex items-end justify-between gap-6">

                        {/* QR Code Validation */}
                        <div className="flex items-center gap-3.5">
                            <div className="w-20 h-20 bg-white border border-slate-300 rounded-xl p-1.5 shadow-2xs flex items-center justify-center">
                                <svg className="w-full h-full text-slate-900" viewBox="0 0 100 100" fill="currentColor">
                                    <rect x="10" y="10" width="30" height="30" fill="none" stroke="currentColor" strokeWidth="6" />
                                    <rect x="18" y="18" width="14" height="14" />
                                    <rect x="60" y="10" width="30" height="30" fill="none" stroke="currentColor" strokeWidth="6" />
                                    <rect x="68" y="18" width="14" height="14" />
                                    <rect x="10" y="60" width="30" height="30" fill="none" stroke="currentColor" strokeWidth="6" />
                                    <rect x="18" y="68" width="14" height="14" />
                                    <path d="M50 10h6v20h-6zM60 50h30v6H60zM10 50h40v6H10zM50 60h6v30h-6zM60 65h10v10H60zM80 80h10v10H80z" />
                                </svg>
                            </div>
                            <div className="space-y-0.5">
                                <span className="text-[10px] font-extrabold uppercase text-slate-700 block">
                                    Pindai QR Validasi
                                </span>
                                <p className="text-[9px] text-slate-500 leading-tight max-w-[140px]">
                                    Pindai kode QR untuk verifikasi keaslian piagam di portal resmi SiSampah.
                                </p>
                            </div>
                        </div>

                        {/* Official Green Stamp Seal */}
                        <div className="w-24 h-24 rounded-full border-2 border-dashed border-emerald-700 bg-emerald-50/90 text-emerald-800 flex flex-col items-center justify-center p-1 text-center shadow-inner relative transform -rotate-6">
                            <ShieldCheck className="w-7 h-7 text-emerald-700" />
                            <span className="text-[8px] font-black uppercase tracking-tighter mt-0.5">TERVERIFIKASI</span>
                            <span className="text-[7px] font-bold text-emerald-900">SISAMPAH 2026</span>
                        </div>

                        {/* Signature Area */}
                        <div className="text-center space-y-1 w-44">
                            <p className="text-[10px] text-slate-500 font-medium">
                                Diterbitkan, {certificateDetails.issued_date || '23 Agustus 2026'}
                            </p>
                            <div className="h-12 flex items-center justify-center">
                                <span className="font-serif italic text-base text-slate-800 font-bold tracking-wider">
                                    Pengelola Unit
                                </span>
                            </div>
                            <div className="border-t border-slate-400 pt-1">
                                <p className="text-xs font-bold text-slate-900">
                                    {bankSampahName}
                                </p>
                                <p className="text-[10px] text-slate-500">
                                    Komite Lingkungan Hidup
                                </p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    );
}
