import React, { useState } from 'react';
import { User, Mail, CreditCard, ShieldCheck, Wallet, Banknote, CheckCircle2 } from 'lucide-react';

export default function NasabahLookupSection({
    registeredNasabahs = [],
    selectedEmail = '',
    onSelectEmail,
}) {
    const selectedNasabah = registeredNasabahs.find(
        (n) => (n.email || '').toLowerCase() === (selectedEmail || '').toLowerCase()
    );

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-2xs space-y-5 select-none">
            
            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                <div className="flex items-center gap-2.5">
                    <div className="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-black text-sm">
                        1
                    </div>
                    <div>
                        <h3 className="font-black text-base text-slate-900 tracking-tight">
                            Identifikasi Akun Nasabah
                        </h3>
                        <p className="text-xs text-slate-500">
                            Pilih atau masukkan email / nomor rekening nasabah yang menyetor
                        </p>
                    </div>
                </div>
            </div>

            {/* Email / Nasabah Selection Input */}
            <div className="space-y-2">
                <label className="block text-xs font-bold text-slate-700">
                    Pilih / Masukkan Email Nasabah Terdaftar <span className="text-rose-500">*</span>
                </label>

                <div className="relative">
                    <input
                        type="email"
                        name="user_email"
                        list="nasabah-list"
                        value={selectedEmail}
                        onChange={(e) => onSelectEmail(e.target.value)}
                        placeholder="Contoh: nasabah@email.com"
                        required
                        className="w-full px-4 py-3 rounded-2xl border border-slate-300 bg-white text-xs sm:text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs"
                    />
                    <datalist id="nasabah-list">
                        {registeredNasabahs.map((nasabah) => (
                            <option key={nasabah.id} value={nasabah.email}>
                                {nasabah.name} — {nasabah.virtual_account} ({nasabah.bank_sampah_name})
                            </option>
                        ))}
                    </datalist>
                </div>
                <p className="text-[11px] text-slate-400">
                    💡 Ketik email atau nama nasabah untuk memilih dari daftar akun terdaftar.
                </p>
            </div>

            {/* Identified Nasabah Card */}
            {selectedNasabah ? (
                <div className="p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-slate-50 to-emerald-50/30 border border-emerald-200/80 space-y-4">
                    <div className="flex items-center gap-4">
                        {selectedNasabah.avatar_url ? (
                            <img
                                src={selectedNasabah.avatar_url}
                                alt={selectedNasabah.name}
                                className="w-12 h-12 rounded-2xl object-cover border-2 border-emerald-500 shadow-2xs shrink-0"
                            />
                        ) : (
                            <div className="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-black text-lg shadow-2xs shrink-0">
                                {selectedNasabah.name ? selectedNasabah.name.charAt(0).toUpperCase() : 'N'}
                            </div>
                        )}

                        <div className="space-y-1 min-w-0 flex-1">
                            <div className="flex flex-wrap items-center gap-2">
                                <h4 className="font-black text-sm sm:text-base text-slate-900 truncate">
                                    {selectedNasabah.name}
                                </h4>
                                <span className="px-2 py-0.2 rounded-md bg-white border border-slate-200 text-[10px] font-bold text-slate-600 shadow-2xs">
                                    {selectedNasabah.bank_sampah_name}
                                </span>
                            </div>

                            <div className="flex flex-wrap items-center gap-3 text-xs text-slate-600">
                                <span>Rekening: <strong>{selectedNasabah.virtual_account}</strong></span>
                                <span>•</span>
                                <span>Saldo Aktif: <strong>Rp {Number(selectedNasabah.saldo).toLocaleString('id-ID')}</strong></span>
                            </div>
                        </div>
                    </div>

                    {/* Payment Method Badge */}
                    <div className="pt-2 border-t border-slate-200/60">
                        {selectedNasabah.is_followed_bank ? (
                            <div className="flex items-center gap-2 p-2.5 rounded-xl bg-emerald-100/70 border border-emerald-200 text-emerald-900 text-xs font-bold">
                                <Wallet className="w-4 h-4 text-emerald-700 shrink-0" />
                                <span>Nasabah Unit Sendiri $\rightarrow$ Saldo dikreditkan otomatis ke dompet digital SiSampay</span>
                            </div>
                        ) : (
                            <div className="flex items-center gap-2 p-2.5 rounded-xl bg-amber-100/70 border border-amber-200 text-amber-900 text-xs font-bold">
                                <Banknote className="w-4 h-4 text-amber-700 shrink-0" />
                                <span>Nasabah Luar Unit $\rightarrow$ Pembayaran CASH Tunai di Tempat (Kas Unit berkurang, Poin Lingkungan nasabah bertambah)</span>
                            </div>
                        )}
                    </div>
                </div>
            ) : selectedEmail ? (
                <div className="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-500 font-medium">
                    ⚠️ Nasabah dengan email "{selectedEmail}" belum ditemukan di daftar cepat, sistem akan memverifikasi saat submit.
                </div>
            ) : null}

        </div>
    );
}
