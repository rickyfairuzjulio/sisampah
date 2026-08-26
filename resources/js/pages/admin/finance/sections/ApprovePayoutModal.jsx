import React, { useState } from 'react';
import { X, Check, CreditCard, Upload, CheckCircle2, ArrowRight } from 'lucide-react';

export default function ApprovePayoutModal({
    isOpen,
    onClose,
    withdrawal = null,
}) {
    if (!isOpen || !withdrawal) return null;

    const [isSubmitting, setIsSubmitting] = useState(false);

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsSubmitting(true);

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/validasi-keuangan/${withdrawal.id}`;

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrf;
        form.appendChild(csrfInput);

        document.body.appendChild(form);
        form.submit();
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fade-in select-none">
            
            <div className="relative w-full max-w-lg bg-white border border-slate-200 rounded-3xl shadow-2xl overflow-hidden animate-slide-in">
                
                {/* Header */}
                <div className="p-6 bg-gradient-to-r from-emerald-600 to-teal-700 text-white flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center font-bold">
                            <Check className="w-5 h-5" />
                        </div>
                        <div>
                            <h3 className="font-black text-lg text-white tracking-tight">
                                Konfirmasi Persetujuan Pencairan Dana
                            </h3>
                            <p className="text-xs text-emerald-100">
                                Pastikan dana telah ditransfer ke rekening nasabah
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        onClick={onClose}
                        className="p-2 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-colors cursor-pointer"
                    >
                        <X className="w-5 h-5" />
                    </button>
                </div>

                {/* Body */}
                <form onSubmit={handleSubmit} className="p-6 space-y-4">
                    
                    {/* Detail Card */}
                    <div className="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                        <div className="flex items-center justify-between pb-2 border-b border-slate-200/80">
                            <span className="text-xs font-bold text-slate-500">Nama Nasabah:</span>
                            <span className="text-xs font-black text-slate-900">{withdrawal.user_name} ({withdrawal.user_rt_rw})</span>
                        </div>

                        <div className="flex items-center justify-between pb-2 border-b border-slate-200/80">
                            <span className="text-xs font-bold text-slate-500">Nominal Dicairkan:</span>
                            <span className="text-base font-black text-emerald-700">{withdrawal.nominal_formatted}</span>
                        </div>

                        <div className="flex items-center justify-between pb-2 border-b border-slate-200/80">
                            <span className="text-xs font-bold text-slate-500">Metode & Rekening:</span>
                            <span className="text-xs font-mono font-bold text-slate-900">{withdrawal.metode} • {withdrawal.nomor_rekening}</span>
                        </div>

                        <div className="flex items-center justify-between">
                            <span className="text-xs font-bold text-slate-500">Atas Nama:</span>
                            <span className="text-xs font-bold text-slate-900">{withdrawal.atas_nama}</span>
                        </div>
                    </div>

                    {/* Upload Struk Bukti Transfer */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Unggah Bukti Struk Transfer (Opsional)</label>
                        <div className="w-full px-3.5 py-3 rounded-xl bg-slate-50 border border-dashed border-slate-300 text-xs text-slate-500 flex items-center justify-center gap-2 cursor-pointer hover:bg-slate-100 transition-colors">
                            <Upload className="w-4 h-4 text-slate-400" />
                            <span>Pilih file foto bukti struk transfer...</span>
                        </div>
                    </div>

                    {/* Actions */}
                    <div className="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button
                            type="button"
                            onClick={onClose}
                            className="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            disabled={isSubmitting}
                            className="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black transition-all shadow-md flex items-center gap-2 cursor-pointer disabled:opacity-50"
                        >
                            {isSubmitting ? (
                                <>
                                    <CheckCircle2 className="w-4 h-4 text-white animate-spin" />
                                    <span>Memproses...</span>
                                </>
                            ) : (
                                <>
                                    <span>Ya, Setujui & Cairkan</span>
                                    <ArrowRight className="w-4 h-4" />
                                </>
                            )}
                        </button>
                    </div>

                </form>

            </div>

        </div>
    );
}
