import React from 'react';
import { Sprout, Recycle, AlertTriangle, CheckCircle2 } from 'lucide-react';

export default function SortingCheatSheetSection() {
    const buckets = [
        {
            title: 'Wadah Hijau: Organik',
            tagline: 'Dapat Terurai Alami (Biodegradable)',
            examples: 'Sisa makanan, kulit buah, sisa sayur, ampas kopi, dedaunan kering.',
            action: 'Olah menjadi kompos mandiri, pupuk cair, atau pakan maggot BSF di rumah.',
            icon: Sprout,
            border: 'border-emerald-200',
            bg: 'bg-emerald-50/60',
            textColor: 'text-emerald-950',
            iconColor: 'text-emerald-700 bg-emerald-100',
            badgeBg: 'bg-emerald-100 text-emerald-800 border-emerald-200',
        },
        {
            title: 'Wadah Kuning: Anorganik',
            tagline: 'Bernilai Ekonomi di Bank Sampah',
            examples: 'Botol plastik (PET/HDPE), kardus, kertas arsip, kaleng aluminium, logam.',
            action: 'Kumpulkan dalam keadaan bersih dan kering, lalu setor ke Bank Sampah SiSampah.',
            icon: Recycle,
            border: 'border-amber-200',
            bg: 'bg-amber-50/60',
            textColor: 'text-amber-950',
            iconColor: 'text-amber-700 bg-amber-100',
            badgeBg: 'bg-amber-100 text-amber-800 border-amber-200',
        },
        {
            title: 'Wadah Merah: Residu & B3',
            tagline: 'Perlu Penanganan Khusus',
            examples: 'Baterai bekas, bohlam lampu, obat kadaluarsa, kemasan aerosol beracun.',
            action: 'Pisahkan dalam wadah tertutup dan serahkan ke drop point B3 khusus kecamatan.',
            icon: AlertTriangle,
            border: 'border-red-200',
            bg: 'bg-red-50/60',
            textColor: 'text-red-950',
            iconColor: 'text-red-700 bg-red-100',
            badgeBg: 'bg-red-100 text-red-800 border-red-200',
        },
    ];

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6 select-none">
            <div className="space-y-1">
                <div className="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-extrabold">
                    <CheckCircle2 className="w-3.5 h-3.5" />
                    <span>Panduan Cepat Pemilahan 3W (Wadah)</span>
                </div>
                <h3 className="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">
                    Prinsip Dasar Pemilahan Sampah dari Rumah
                </h3>
                <p className="text-xs text-slate-500">
                    Memilah sampah dari sumbernya mempermudah proses daur ulang dan melipatgandakan nilai jual sampah Anda.
                </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5">
                {buckets.map((b, idx) => {
                    const IconComponent = b.icon;
                    return (
                        <div
                            key={idx}
                            className={`rounded-2xl p-5 border ${b.border} ${b.bg} flex flex-col justify-between space-y-3 shadow-2xs`}
                        >
                            <div className="space-y-2">
                                <div className="flex items-center justify-between">
                                    <div className={`w-9 h-9 rounded-xl flex items-center justify-center font-bold shrink-0 ${b.iconColor}`}>
                                        <IconComponent className="w-5 h-5" />
                                    </div>
                                    <span className={`px-2 py-0.5 rounded-full text-[10px] font-extrabold border ${b.badgeBg}`}>
                                        {b.tagline}
                                    </span>
                                </div>

                                <h4 className={`font-black text-sm ${b.textColor}`}>
                                    {b.title}
                                </h4>

                                <p className="text-[11px] text-slate-600 leading-relaxed">
                                    <span className="font-bold">Contoh:</span> {b.examples}
                                </p>
                            </div>

                            <div className="pt-2 border-t border-slate-200/60 text-[11px] text-slate-700 font-medium">
                                💡 <span className="font-semibold">{b.action}</span>
                            </div>
                        </div>
                    );
                })}
            </div>
        </div>
    );
}
