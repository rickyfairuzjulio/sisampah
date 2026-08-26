import React from 'react';
import { ArrowLeft, MapPin, Phone, MessageCircle, CreditCard, ShieldCheck } from 'lucide-react';

export default function PickupNasabahInfoCard({ 
    targetNasabah = {} 
}) {
    return (
        <div className="space-y-4 select-none">
            
            {/* Header Navigation */}
            <div className="flex items-center gap-3">
                <a
                    href="/petugas/dashboard"
                    className="p-2.5 rounded-2xl bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 transition-colors shadow-2xs cursor-pointer"
                    title="Kembali ke Dashboard Manifes"
                >
                    <ArrowLeft className="w-5 h-5" />
                </a>
                <div>
                    <h1 className="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                        Input Timbangan Penjemputan ⚖️
                    </h1>
                    <p className="text-xs text-slate-500">
                        Verifikasi timbangan sampah di lokasi nasabah dan kreditkan saldo secara langsung.
                    </p>
                </div>
            </div>

            {/* Nasabah Target Info Card */}
            <div className="bg-white border border-slate-200 rounded-3xl p-5 sm:p-6 shadow-2xs">
                <div className="flex flex-col md:flex-row md:items-center justify-between gap-5">
                    
                    {/* Left: Avatar & Name */}
                    <div className="flex items-center gap-4">
                        {targetNasabah?.avatar_url ? (
                            <img
                                src={targetNasabah.avatar_url}
                                alt={targetNasabah.name}
                                className="w-14 h-14 rounded-2xl object-cover border-2 border-emerald-500 shadow-2xs shrink-0"
                            />
                        ) : (
                            <div className="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-black text-xl shadow-2xs shrink-0">
                                {targetNasabah?.name ? targetNasabah.name.charAt(0).toUpperCase() : 'N'}
                            </div>
                        )}

                        <div className="space-y-1 min-w-0">
                            <div className="flex flex-wrap items-center gap-2">
                                <h3 className="font-black text-base sm:text-lg text-slate-900 truncate">
                                    {targetNasabah?.name || 'Nasabah'}
                                </h3>
                                <span className="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold shadow-2xs">
                                    {targetNasabah?.bank_sampah_name || 'Unit Melati'}
                                </span>
                            </div>

                            <div className="flex items-center gap-1.5 text-xs text-slate-600">
                                <MapPin className="w-3.5 h-3.5 text-slate-400 shrink-0" />
                                <span className="truncate">{targetNasabah?.address || 'Alamat terdaftar'}</span>
                            </div>

                            <div className="flex items-center gap-3 text-[11px] text-slate-400 font-medium pt-0.5">
                                <div className="flex items-center gap-1 text-slate-700">
                                    <CreditCard className="w-3.5 h-3.5 text-emerald-600" />
                                    <span>Rekening SiSampay: <strong className="text-slate-900">{targetNasabah?.virtual_account}</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Right: Contact Nasabah */}
                    <div className="flex items-center gap-2 shrink-0 pt-2 md:pt-0 border-t md:border-t-0 border-slate-100">
                        {targetNasabah?.wa_link && (
                            <a
                                href={targetNasabah.wa_link}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-xl font-bold text-xs flex items-center gap-2 transition-colors shadow-2xs"
                            >
                                <MessageCircle className="w-4 h-4 text-emerald-600" />
                                <span>WhatsApp Nasabah</span>
                            </a>
                        )}
                    </div>

                </div>
            </div>

        </div>
    );
}
