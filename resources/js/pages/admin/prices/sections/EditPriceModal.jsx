import React, { useState, useEffect } from 'react';
import { X, Edit3, Tag, DollarSign, CheckCircle2, ArrowRight, TrendingUp, TrendingDown } from 'lucide-react';

export default function EditPriceModal({
    isOpen,
    onClose,
    category = null,
}) {
    if (!isOpen || !category) return null;

    const [price, setPrice] = useState(category.price_per_kg || 0);
    const [reason, setReason] = useState('Penyesuaian berkala harga pasar industri daur ulang.');
    const [isSubmitting, setIsSubmitting] = useState(false);

    useEffect(() => {
        if (category) {
            setPrice(category.price_per_kg || 0);
        }
    }, [category]);

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsSubmitting(true);

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/trash-price/${category.id}`;

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrf;
        form.appendChild(csrfInput);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        const priceInput = document.createElement('input');
        priceInput.type = 'hidden';
        priceInput.name = 'harga_per_kg';
        priceInput.value = price;
        form.appendChild(priceInput);

        const reasonInput = document.createElement('input');
        reasonInput.type = 'hidden';
        reasonInput.name = 'alasan';
        reasonInput.value = reason;
        form.appendChild(reasonInput);

        document.body.appendChild(form);
        form.submit();
    };

    const priceDiff = price - (category.price_per_kg || 0);

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fade-in select-none">
            
            <div className="relative w-full max-w-md bg-white border border-slate-200 rounded-3xl shadow-2xl overflow-hidden animate-slide-in">
                
                {/* Header */}
                <div className="p-6 bg-gradient-to-r from-emerald-600 to-teal-700 text-white flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center font-bold">
                            <Edit3 className="w-5 h-5" />
                        </div>
                        <div>
                            <h3 className="font-black text-lg text-white tracking-tight">
                                Ubah Harga Satuan
                            </h3>
                            <p className="text-xs text-emerald-100">
                                {category.name} ({category.code})
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

                {/* Form */}
                <form onSubmit={handleSubmit} className="p-6 space-y-4">
                    
                    {/* Current Price Reference */}
                    <div className="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <span className="text-xs font-bold text-slate-500">Harga Saat Ini:</span>
                        <span className="text-sm font-black text-slate-900">{category.price_formatted}</span>
                    </div>

                    {/* New Price Input */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Harga Baru (Rp per {category.unit || 'Kg'})</label>
                        <input
                            type="number"
                            value={price}
                            onChange={(e) => setPrice(Number(e.target.value))}
                            required
                            min="100"
                            className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-base font-black text-emerald-700 focus:outline-emerald-600"
                        />
                    </div>

                    {/* Diff Indicator */}
                    {priceDiff !== 0 && (
                        <div className={`p-3 rounded-xl border text-xs font-bold flex items-center justify-between ${
                            priceDiff > 0 ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-rose-50 text-rose-800 border-rose-200'
                        }`}>
                            <span>Selisih Perubahan:</span>
                            <span className="flex items-center gap-1 font-black">
                                {priceDiff > 0 ? <TrendingUp className="w-3.5 h-3.5" /> : <TrendingDown className="w-3.5 h-3.5" />}
                                {priceDiff > 0 ? `+Rp ${priceDiff.toLocaleString('id-ID')}` : `-Rp ${Math.abs(priceDiff).toLocaleString('id-ID')}`}
                            </span>
                        </div>
                    )}

                    {/* Reason */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Alasan Penyesuaian</label>
                        <textarea
                            value={reason}
                            onChange={(e) => setReason(e.target.value)}
                            rows={2}
                            className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-emerald-600"
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
                            className="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black transition-all shadow-md flex items-center gap-2 cursor-pointer disabled:opacity-50"
                        >
                            {isSubmitting ? (
                                <>
                                    <CheckCircle2 className="w-4 h-4 text-white animate-spin" />
                                    <span>Menyimpan...</span>
                                </>
                            ) : (
                                <>
                                    <span>Simpan Perubahan</span>
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
