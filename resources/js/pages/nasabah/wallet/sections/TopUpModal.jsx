import React, { useState } from 'react';
import { X, Plus, QrCode, Building2, CheckCircle2, Sparkles } from 'lucide-react';

export default function TopUpModal({
    isOpen = false,
    onClose,
    csrfToken = '',
}) {
    if (!isOpen) return null;

    const [nominal, setNominal] = useState('50000');
    const [metode, setMetode] = useState('qris');
    const [isSubmitting, setIsSubmitting] = useState(false);

    const presets = [20000, 50000, 100000, 200000, 500000];

    const numNominal = parseFloat(nominal) || 0;
    const isAmountValid = numNominal >= 10000;

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
            
            {/* Backdrop */}
            <div 
                className="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                onClick={onClose}
            />

            {/* Modal Box */}
            <div className="relative bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 max-w-lg w-full shadow-2xl z-10 animate-slide-in space-y-6">
                
                {/* Close Button */}
                <button
                    type="button"
                    onClick={onClose}
                    className="absolute top-5 right-5 text-slate-400 hover:text-slate-600 transition-colors p-1 focus:outline-none cursor-pointer"
                >
                    <X className="w-5 h-5" />
                </button>

                {/* Modal Header */}
                <div className="flex items-center gap-3.5 pb-4 border-b border-slate-100">
                    <div className="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center font-bold shrink-0 shadow-2xs">
                        <Plus className="w-6 h-6" />
                    </div>
                    <div>
                        <h3 className="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">
                            Top Up Saldo SiSampay
                        </h3>
                        <p className="text-xs text-slate-500 mt-0.5">
                            Isi saldo digital Anda secara instan untuk berbagai layanan.
                        </p>
                    </div>
                </div>

                {/* Form Action */}
                <form
                    method="POST"
                    action="/nasabah/topup"
                    onSubmit={() => setIsSubmitting(true)}
                    className="space-y-5"
                >
                    <input type="hidden" name="_token" value={csrfToken} />

                    {/* 1. Nominal Presets */}
                    <div>
                        <label className="block text-xs font-bold text-slate-700 mb-2">
                            Pilih Nominal Top Up <span className="text-emerald-600">*</span>
                        </label>
                        
                        <div className="grid grid-cols-3 gap-2">
                            {presets.map((amt) => (
                                <button
                                    key={amt}
                                    type="button"
                                    onClick={() => setNominal(String(amt))}
                                    className={`py-2.5 px-3 rounded-xl border text-xs font-extrabold transition-all cursor-pointer shadow-2xs ${
                                        nominal === String(amt)
                                            ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm'
                                            : 'bg-slate-50 border-slate-200 text-slate-700 hover:border-slate-300'
                                    }`}
                                >
                                    Rp {(amt / 1000).toLocaleString('id-ID')}rb
                                </button>
                            ))}
                        </div>

                        <div className="mt-3">
                            <label htmlFor="topup_nominal" className="block text-[11px] font-semibold text-slate-500 mb-1">
                                Atau Masukkan Nominal Lain (Min. Rp 10.000)
                            </label>
                            <input
                                id="topup_nominal"
                                name="nominal"
                                type="number"
                                min="10000"
                                step="1000"
                                required
                                value={nominal}
                                onChange={(e) => setNominal(e.target.value)}
                                className="w-full px-4 py-2.5 sm:py-3 bg-white text-slate-900 text-sm font-bold border border-slate-200 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all shadow-2xs"
                            />
                        </div>
                    </div>

                    {/* 2. Metode Pembayaran */}
                    <div>
                        <label className="block text-xs font-bold text-slate-700 mb-2">
                            Pilih Metode Pembayaran <span className="text-emerald-600">*</span>
                        </label>

                        <div className="grid grid-cols-2 gap-3">
                            <label
                                onClick={() => setMetode('qris')}
                                className={`p-3.5 rounded-2xl border text-left cursor-pointer transition-all flex items-center gap-3 shadow-2xs ${
                                    metode === 'qris'
                                        ? 'bg-emerald-50 border-emerald-500 text-emerald-950 font-bold'
                                        : 'bg-slate-50 border-slate-200 text-slate-600 hover:border-slate-300'
                                }`}
                            >
                                <input type="radio" name="metode" value="qris" checked={metode === 'qris'} onChange={() => setMetode('qris')} className="hidden" />
                                <QrCode className="w-5 h-5 text-emerald-600 shrink-0" />
                                <div>
                                    <span className="text-xs font-extrabold block">QRIS Instan</span>
                                    <span className="text-[10px] text-slate-400 font-normal">Semua Bank & E-Wallet</span>
                                </div>
                            </label>

                            <label
                                onClick={() => setMetode('va')}
                                className={`p-3.5 rounded-2xl border text-left cursor-pointer transition-all flex items-center gap-3 shadow-2xs ${
                                    metode === 'va'
                                        ? 'bg-emerald-50 border-emerald-500 text-emerald-950 font-bold'
                                        : 'bg-slate-50 border-slate-200 text-slate-600 hover:border-slate-300'
                                }`}
                            >
                                <input type="radio" name="metode" value="va" checked={metode === 'va'} onChange={() => setMetode('va')} className="hidden" />
                                <Building2 className="w-5 h-5 text-emerald-600 shrink-0" />
                                <div>
                                    <span className="text-xs font-extrabold block">Virtual Account</span>
                                    <span className="text-[10px] text-slate-400 font-normal">BCA, Mandiri, BRI, BNI</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {/* Action Buttons */}
                    <div className="flex items-center gap-3 pt-3 border-t border-slate-100">
                        <button
                            type="button"
                            onClick={onClose}
                            className="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition-colors cursor-pointer"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            disabled={!isAmountValid || isSubmitting}
                            className="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 disabled:bg-slate-300 disabled:cursor-not-allowed text-white rounded-xl font-bold text-xs shadow-sm hover:shadow-md transition-all cursor-pointer"
                        >
                            {isSubmitting ? 'Memproses...' : 'Lanjutkan Pembayaran'}
                        </button>
                    </div>

                </form>

            </div>

        </div>
    );
}
