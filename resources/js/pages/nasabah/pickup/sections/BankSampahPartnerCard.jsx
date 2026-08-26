import React from 'react';
import { Building2, MapPin, Phone, Compass, CheckCircle2 } from 'lucide-react';

export default function BankSampahPartnerCard({ bankSampah = {} }) {
    return (
        <div className="bg-white border border-slate-200 p-5 sm:p-6 rounded-3xl shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-5 select-none">
            
            {/* 1. Unit Info */}
            <div className="flex items-start gap-4 min-w-0 flex-1">
                <div className="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center font-bold text-xl shrink-0 shadow-2xs">
                    <Building2 className="w-6 h-6" />
                </div>
                <div className="min-w-0 flex-1">
                    <div className="flex items-center gap-2 flex-wrap">
                        <h2 className="font-extrabold text-slate-900 text-base sm:text-lg tracking-tight">
                            {bankSampah.nama || 'Unit Bank Sampah'}
                        </h2>
                        <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-2xs">
                            <CheckCircle2 className="w-3 h-3" />
                            <span>Unit Domisili Penjemputan</span>
                        </span>
                    </div>

                    <p className="text-xs text-slate-500 flex items-center gap-1.5 mt-1">
                        <MapPin className="w-3.5 h-3.5 text-slate-400 shrink-0" />
                        <span className="line-clamp-1">
                            {bankSampah.alamat || 'Alamat Basecamp Unit'} (Kec. {bankSampah.kecamatan || '-'})
                        </span>
                    </p>
                </div>
            </div>

            {/* 2. Hotline & Radius Specs */}
            <div className="flex items-center gap-3 w-full md:w-auto shrink-0 flex-wrap sm:flex-nowrap pt-3 md:pt-0 border-t md:border-t-0 border-slate-100">
                
                {/* Radius Spec */}
                <div className="px-3.5 py-2 rounded-2xl bg-slate-50 border border-slate-200 flex items-center gap-2 text-xs shadow-2xs">
                    <Compass className="w-4 h-4 text-emerald-600 shrink-0" />
                    <div>
                        <span className="text-[10px] font-bold text-slate-400 block uppercase">Jangkauan</span>
                        <span className="font-extrabold text-slate-900">Maks. {bankSampah.radius_layanan || 5} KM</span>
                    </div>
                </div>

                {/* WhatsApp Hotline */}
                {bankSampah.telepon && (
                    <a
                        href={`https://wa.me/${bankSampah.telepon.replace(/[^0-9]/g, '')}`}
                        target="_blank"
                        rel="noreferrer"
                        className="px-3.5 py-2 rounded-2xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 flex items-center gap-2 text-xs text-emerald-800 font-bold transition-colors shadow-2xs"
                    >
                        <Phone className="w-4 h-4 text-emerald-600 shrink-0" />
                        <div>
                            <span className="text-[10px] font-bold text-emerald-600 block uppercase">Hotline WA</span>
                            <span className="font-extrabold">{bankSampah.telepon}</span>
                        </div>
                    </a>
                )}

            </div>

        </div>
    );
}
