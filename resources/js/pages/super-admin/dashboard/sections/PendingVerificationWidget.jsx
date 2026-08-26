import React from 'react';
import { ShieldAlert, ArrowRight, Building2, MapPin, FileCheck, Clock } from 'lucide-react';

export default function PendingVerificationWidget({
    pendingVerifications = [],
}) {
    const defaultList = [
        {
            id: 1,
            nama: 'Bank Sampah Berkah Mandiri',
            kota: 'Kota Semarang',
            provinsi: 'Jawa Tengah',
            pendaftar_nama: 'H. Suwarno',
            document_status: 'Dokumen Lengkap (3/3)',
            created_at_formatted: '24 Agt 2026',
        },
        {
            id: 2,
            nama: 'Bank Sampah Sejahtera Abadi',
            kota: 'Kota Surabaya',
            provinsi: 'Jawa Timur',
            pendaftar_nama: 'Ir. Hendra',
            document_status: 'Menunggu Review SK',
            created_at_formatted: '22 Agt 2026',
        },
        {
            id: 3,
            nama: 'Bank Sampah Asri Sukajadi',
            kota: 'Kota Bandung',
            provinsi: 'Jawa Barat',
            pendaftar_nama: 'Ibu Ratna',
            document_status: 'Dokumen Lengkap (3/3)',
            created_at_formatted: '20 Agt 2026',
        },
        {
            id: 4,
            nama: 'Bank Sampah Berdaya Bersama',
            kota: 'Kota Yogyakarta',
            provinsi: 'DIY',
            pendaftar_nama: 'Bambang Kusumo',
            document_status: 'Menunggu Verifikasi KTP',
            created_at_formatted: '18 Agt 2026',
        },
    ];

    const list = pendingVerifications.length > 0 ? pendingVerifications : defaultList;

    return (
        <div className="bg-white border border-amber-200/80 rounded-3xl p-6 shadow-2xs space-y-5 select-none h-full flex flex-col justify-between">
            
            <div className="space-y-4">
                {/* Header */}
                <div className="flex items-center justify-between pb-3 border-b border-amber-100">
                    <div className="flex items-center gap-2.5">
                        <div className="w-10 h-10 rounded-2xl bg-amber-100 text-amber-900 flex items-center justify-center font-bold">
                            <ShieldAlert className="w-5 h-5 text-amber-700" />
                        </div>
                        <div>
                            <h3 className="font-black text-sm text-slate-900 leading-tight">
                                Antrean Verifikasi Mitra Baru 🛡️
                            </h3>
                            <p className="text-[11px] text-slate-500">
                                6 permohonan kemitraan menunggu audit
                            </p>
                        </div>
                    </div>

                    <span className="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-900 border border-amber-300">
                        6 Pending
                    </span>
                </div>

                {/* Vertical Stacked Cards */}
                <div className="space-y-3">
                    {list.slice(0, 4).map((item) => (
                        <div
                            key={item.id}
                            className="bg-amber-50/40 border border-amber-200/60 rounded-2xl p-3.5 space-y-2 hover:bg-amber-50/80 transition-colors"
                        >
                            <div className="flex items-start justify-between gap-2">
                                <div>
                                    <h4 className="font-black text-xs text-slate-900 leading-snug">
                                        {item.nama}
                                    </h4>
                                    <span className="text-[10px] text-slate-500 flex items-center gap-1 mt-0.5">
                                        <MapPin className="w-2.5 h-2.5 text-slate-400" />
                                        <span>{item.kota}, {item.provinsi}</span>
                                    </span>
                                </div>
                                <span className="text-[9px] text-slate-400 font-medium">
                                    {item.created_at_formatted}
                                </span>
                            </div>

                            <div className="flex items-center justify-between pt-1.5 border-t border-amber-200/40 text-[10px]">
                                <span className="inline-flex items-center gap-1 font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.2 rounded border border-emerald-200">
                                    <FileCheck className="w-2.5 h-2.5 text-emerald-600" />
                                    <span>{item.document_status}</span>
                                </span>

                                <a
                                    href={`/super-admin/verifikasi-bank-sampah/${item.id}`}
                                    className="font-bold text-amber-800 hover:text-amber-900 flex items-center gap-1 cursor-pointer"
                                >
                                    <span>Tinjau</span>
                                    <ArrowRight className="w-3 h-3" />
                                </a>
                            </div>
                        </div>
                    ))}
                </div>
            </div>

            {/* Bottom Button */}
            <div className="pt-2">
                <a
                    href="/super-admin/verifikasi-bank-sampah"
                    className="w-full py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs rounded-xl transition-all shadow-2xs flex items-center justify-center gap-1.5 cursor-pointer"
                >
                    <span>Buka Stasiun Verifikasi Bank Sampah</span>
                    <ArrowRight className="w-3.5 h-3.5" />
                </a>
            </div>

        </div>
    );
}
