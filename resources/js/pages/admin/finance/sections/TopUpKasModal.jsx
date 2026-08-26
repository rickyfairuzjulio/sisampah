import React, { useState } from 'react';
import { X, Plus, Wallet, DollarSign, CheckCircle2, ArrowRight } from 'lucide-react';

export default function TopUpKasModal({
    isOpen,
    onClose,
    onSuccess,
}) {
    if (!isOpen) return null;

    const [nominal, setNominal] = useState(5000000);
    const [sumberDana, setSumberDana] = useState('Dana APBDes / BUMDes');
    const [catatan, setCatatan] = useState('Top-up modal operasional kas unit untuk kesiapan payout tabungan warga.');
    const [isSubmitting, setIsSubmitting] = useState(false);

    const presets = [1000000, 2500000, 5000000, 10000000];

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsSubmitting(true);

        // Submit via native form or fetch POST to /admin/validasi-keuangan/topup-kas
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/validasi-keuangan/topup-kas';

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrf;
        form.appendChild(csrfInput);

        const nomInput = document.createElement('input');
        nomInput.type = 'hidden';
        nomInput.name = 'nominal';
        nomInput.value = nominal;
        form.appendChild(nomInput);

        const sumberInput = document.createElement('input');
        sumberInput.type = 'hidden';
        sumberInput.name = 'sumber_dana';
        sumberInput.value = sumberDana;
        form.appendChild(sumberInput);

        const catInput = document.createElement('input');
        catInput.type = 'hidden';
        catInput.name = 'catatan';
        catInput.value = catatan;
        form.appendChild(catInput);

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
                            <Wallet className="w-5 h-5" />
                        </div>
                        <div>
                            <h3 className="font-black text-lg text-white tracking-tight">
                                Top-Up Saldo Kas Operasional Unit
                            </h3>
                            <p className="text-xs text-emerald-100">
                                Tambah likuiditas kas tunai & bank unit
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
                    
                    {/* Nominal Presets */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Pilih Nominal Top-Up</label>
                        <div className="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            {presets.map((val) => (
                                <button
                                    key={val}
                                    type="button"
                                    onClick={() => setNominal(val)}
                                    className={`py-2 px-3 rounded-xl text-xs font-black transition-all cursor-pointer ${
                                        nominal === val
                                            ? 'bg-emerald-600 text-white shadow-2xs'
                                            : 'bg-slate-100 text-slate-700 hover:bg-slate-200'
                                    }`}
                                >
                                    Rp {(val / 1000000).toFixed(val % 1000000 === 0 ? 0 : 1)} Jt
                                </button>
                            ))}
                        </div>
                    </div>

                    {/* Custom Nominal Input */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Nominal Kustom (Rp)</label>
                        <input
                            type="number"
                            value={nominal}
                            onChange={(e) => setNominal(Number(e.target.value))}
                            required
                            min="10000"
                            className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-black text-slate-900 focus:outline-emerald-600"
                        />
                    </div>

                    {/* Sumber Dana */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Sumber Dana</label>
                        <select
                            value={sumberDana}
                            onChange={(e) => setSumberDana(e.target.value)}
                            className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-emerald-600"
                        >
                            <option value="Dana APBDes / BUMDes">🏛️ Dana APBDes / Alokasi BUMDes</option>
                            <option value="Swadaya / Modal Mandiri Pengurus">👥 Swadaya / Modal Mandiri Pengurus</option>
                            <option value="Hasil Penjualan Pengepul">🚛 Hasil Penjualan Sampah Pengepul</option>
                            <option value="Hibah / CSR Perusahaan">🏢 Hibah / CSR Mitra Lingkungan</option>
                        </select>
                    </div>

                    {/* Catatan */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Catatan / Keterangan</label>
                        <textarea
                            value={catatan}
                            onChange={(e) => setCatatan(e.target.value)}
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
                                    <span>Memproses...</span>
                                </>
                            ) : (
                                <>
                                    <span>Tambah Saldo Kas</span>
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
