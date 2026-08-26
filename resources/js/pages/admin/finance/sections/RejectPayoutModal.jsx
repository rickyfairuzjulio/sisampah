import React, { useState } from 'react';
import { X, AlertTriangle, ArrowRight, CheckCircle2 } from 'lucide-react';

export default function RejectPayoutModal({
    isOpen,
    onClose,
    withdrawal = null,
}) {
    if (!isOpen || !withdrawal) return null;

    const [reason, setReason] = useState('Nomor rekening bank / nomor e-wallet tidak valid atau tidak dapat ditemukan.');
    const [isSubmitting, setIsSubmitting] = useState(false);

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsSubmitting(true);

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/validasi-keuangan/${withdrawal.id}/reject`;

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrf;
        form.appendChild(csrfInput);

        const reasonInput = document.createElement('input');
        reasonInput.type = 'hidden';
        reasonInput.name = 'catatan';
        reasonInput.value = reason;
        form.appendChild(reasonInput);

        document.body.appendChild(form);
        form.submit();
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fade-in select-none">
            
            <div className="relative w-full max-w-lg bg-white border border-slate-200 rounded-3xl shadow-2xl overflow-hidden animate-slide-in">
                
                {/* Header */}
                <div className="p-6 bg-gradient-to-r from-rose-600 to-red-700 text-white flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center font-bold">
                            <AlertTriangle className="w-5 h-5" />
                        </div>
                        <div>
                            <h3 className="font-black text-lg text-white tracking-tight">
                                Tolak Permohonan Penarikan Saldo
                            </h3>
                            <p className="text-xs text-rose-100">
                                Saldo akan dikembalikan penuh ke dompet digital nasabah
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
                    <div className="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                        <div className="flex items-center justify-between">
                            <span className="text-xs font-bold text-slate-500">Nama Nasabah:</span>
                            <span className="text-xs font-black text-slate-900">{withdrawal.user_name}</span>
                        </div>
                        <div className="flex items-center justify-between">
                            <span className="text-xs font-bold text-slate-500">Nominal:</span>
                            <span className="text-sm font-black text-rose-700">{withdrawal.nominal_formatted}</span>
                        </div>
                        <div className="flex items-center justify-between">
                            <span className="text-xs font-bold text-slate-500">Rekening Tujuan:</span>
                            <span className="text-xs font-mono font-bold text-slate-900">{withdrawal.metode} • {withdrawal.nomor_rekening}</span>
                        </div>
                    </div>

                    {/* Alasan Penolakan */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Alasan Penolakan (Akan dibaca oleh Nasabah)</label>
                        <textarea
                            value={reason}
                            onChange={(e) => setReason(e.target.value)}
                            required
                            rows={3}
                            placeholder="Tuliskan alasan penolakan..."
                            className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-rose-600"
                        />
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
                            className="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-black transition-all shadow-md flex items-center gap-2 cursor-pointer disabled:opacity-50"
                        >
                            {isSubmitting ? (
                                <>
                                    <CheckCircle2 className="w-4 h-4 text-white animate-spin" />
                                    <span>Memproses...</span>
                                </>
                            ) : (
                                <>
                                    <span>Tolak & Kembalikan Saldo</span>
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
