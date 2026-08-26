import React, { useState } from 'react';
import { X, ArrowUpRight, Building2, Smartphone, Banknote, AlertCircle, CheckCircle2, ShieldAlert } from 'lucide-react';

export default function WithdrawalModal({
    isOpen = false,
    onClose,
    saldo = 0,
    csrfToken = '',
}) {
    if (!isOpen) return null;

    const [metode, setMetode] = useState('transfer');
    const [nominal, setNominal] = useState('');
    const [rekeningTujuan, setRekeningTujuan] = useState('');
    const [namaPenerima, setNamaPenerima] = useState('');
    const [isSubmitting, setIsSubmitting] = useState(false);

    const formatCurrency = (val) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(val || 0);
    };

    const numNominal = parseFloat(nominal) || 0;
    const isAmountValid = numNominal >= 10000 && numNominal <= saldo;

    const handlePresetClick = (amount) => {
        if (amount === 'all') {
            setNominal(String(saldo));
        } else {
            setNominal(String(amount));
        }
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
            
            {/* Backdrop */}
            <div 
                className="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                onClick={onClose}
            />

            {/* Modal Box */}
            <div className="relative bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 max-w-lg w-full shadow-2xl z-10 animate-slide-in max-h-[90vh] overflow-y-auto space-y-6">
                
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
                        <ArrowUpRight className="w-6 h-6" />
                    </div>
                    <div>
                        <h3 className="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">
                            Tarik Saldo SiSampay
                        </h3>
                        <p className="text-xs text-slate-500 mt-0.5">
                            Saldo aktif tersedia: <strong className="text-emerald-700">{formatCurrency(saldo)}</strong>
                        </p>
                    </div>
                </div>

                {/* Form Action */}
                <form
                    method="POST"
                    action="/nasabah/withdrawal"
                    onSubmit={() => setIsSubmitting(true)}
                    className="space-y-5"
                >
                    <input type="hidden" name="_token" value={csrfToken} />

                    {/* 1. Pilih Metode Penarikan */}
                    <div>
                        <label className="block text-xs font-bold text-slate-700 mb-2">
                            Pilih Metode Pencairan <span className="text-emerald-600">*</span>
                        </label>
                        
                        <div className="grid grid-cols-3 gap-2.5">
                            
                            {/* Transfer Bank */}
                            <label
                                onClick={() => setMetode('transfer')}
                                className={`p-3 rounded-2xl border text-center cursor-pointer transition-all flex flex-col items-center gap-1.5 shadow-2xs ${
                                    metode === 'transfer'
                                        ? 'bg-emerald-50 border-emerald-500 text-emerald-950 font-bold'
                                        : 'bg-slate-50 border-slate-200 text-slate-600 hover:border-slate-300'
                                }`}
                            >
                                <input type="radio" name="metode" value="transfer" checked={metode === 'transfer'} onChange={() => setMetode('transfer')} className="hidden" />
                                <Building2 className="w-5 h-5 text-emerald-600" />
                                <span className="text-xs">Transfer Bank</span>
                            </label>

                            {/* E-Wallet */}
                            <label
                                onClick={() => setMetode('ewallet')}
                                className={`p-3 rounded-2xl border text-center cursor-pointer transition-all flex flex-col items-center gap-1.5 shadow-2xs ${
                                    metode === 'ewallet'
                                        ? 'bg-emerald-50 border-emerald-500 text-emerald-950 font-bold'
                                        : 'bg-slate-50 border-slate-200 text-slate-600 hover:border-slate-300'
                                }`}
                            >
                                <input type="radio" name="metode" value="ewallet" checked={metode === 'ewallet'} onChange={() => setMetode('ewallet')} className="hidden" />
                                <Smartphone className="w-5 h-5 text-emerald-600" />
                                <span className="text-xs">E-Wallet</span>
                            </label>

                            {/* Tunai Teller */}
                            <label
                                onClick={() => setMetode('tunai')}
                                className={`p-3 rounded-2xl border text-center cursor-pointer transition-all flex flex-col items-center gap-1.5 shadow-2xs ${
                                    metode === 'tunai'
                                        ? 'bg-emerald-50 border-emerald-500 text-emerald-950 font-bold'
                                        : 'bg-slate-50 border-slate-200 text-slate-600 hover:border-slate-300'
                                }`}
                            >
                                <input type="radio" name="metode" value="tunai" checked={metode === 'tunai'} onChange={() => setMetode('tunai')} className="hidden" />
                                <Banknote className="w-5 h-5 text-emerald-600" />
                                <span className="text-xs">Tunai Teller</span>
                            </label>

                        </div>
                    </div>

                    {/* 2. Nominal Penarikan & Presets */}
                    <div>
                        <div className="flex items-center justify-between mb-1.5">
                            <label htmlFor="nominal" className="block text-xs font-bold text-slate-700">
                                Nominal Penarikan (Rp) <span className="text-emerald-600">*</span>
                            </label>
                            <span className="text-[11px] text-slate-400 font-semibold">Min. Rp 10.000</span>
                        </div>

                        <input
                            id="nominal"
                            name="nominal"
                            type="number"
                            min="10000"
                            max={saldo}
                            step="1000"
                            required
                            value={nominal}
                            onChange={(e) => setNominal(e.target.value)}
                            placeholder="Contoh: 50000"
                            className="w-full px-4 py-3 bg-white text-slate-900 text-sm font-bold border border-slate-200 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all shadow-2xs"
                        />

                        {/* Preset Quick Buttons */}
                        <div className="flex flex-wrap items-center gap-2 mt-2">
                            {[25000, 50000, 100000].map((amt) => (
                                <button
                                    key={amt}
                                    type="button"
                                    onClick={() => handlePresetClick(amt)}
                                    className="px-3 py-1 rounded-lg bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 text-slate-600 text-xs font-bold transition-colors cursor-pointer"
                                >
                                    Rp {(amt / 1000).toLocaleString('id-ID')}rb
                                </button>
                            ))}
                            <button
                                type="button"
                                onClick={() => handlePresetClick('all')}
                                className="px-3 py-1 rounded-lg bg-emerald-100 hover:bg-emerald-200 text-emerald-800 text-xs font-extrabold transition-colors cursor-pointer"
                            >
                                Tarik Semua Saldo
                            </button>
                        </div>
                    </div>

                    {/* 3. Detail Rekening / No. HP (Jika Bukan Tunai) */}
                    {metode !== 'tunai' && (
                        <div className="space-y-4 pt-1">
                            <div>
                                <label htmlFor="rekening_tujuan" className="block text-xs font-bold text-slate-700 mb-1.5">
                                    {metode === 'transfer' ? 'Nama Bank & No. Rekening' : 'Pilihan E-Wallet & No. HP'} <span className="text-emerald-600">*</span>
                                </label>
                                <input
                                    id="rekening_tujuan"
                                    name="rekening_tujuan"
                                    type="text"
                                    required
                                    value={rekeningTujuan}
                                    onChange={(e) => setRekeningTujuan(e.target.value)}
                                    placeholder={metode === 'transfer' ? 'BCA - 1234567890' : 'GoPay / DANA - 081234567890'}
                                    className="w-full px-4 py-2.5 sm:py-3 bg-white text-slate-900 text-xs sm:text-sm font-medium border border-slate-200 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all shadow-2xs"
                                />
                            </div>

                            <div>
                                <label htmlFor="nama_penerima" className="block text-xs font-bold text-slate-700 mb-1.5">
                                    Nama Lengkap Pemilik Rekening / Akun <span className="text-emerald-600">*</span>
                                </label>
                                <input
                                    id="nama_penerima"
                                    name="nama_penerima"
                                    type="text"
                                    required
                                    value={namaPenerima}
                                    onChange={(e) => setNamaPenerima(e.target.value)}
                                    placeholder="Ahmad Fauzi"
                                    className="w-full px-4 py-2.5 sm:py-3 bg-white text-slate-900 text-xs sm:text-sm font-medium border border-slate-200 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all shadow-2xs"
                                />
                            </div>
                        </div>
                    )}

                    {/* Security Notice */}
                    <div className="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-600 flex items-start gap-2.5">
                        <ShieldAlert className="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" />
                        <span>
                            Penarikan akan diverifikasi oleh Admin Bank Sampah Unit dalam 1x24 jam kerja.
                        </span>
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
                            {isSubmitting ? 'Memproses...' : 'Ajukan Penarikan'}
                        </button>
                    </div>

                </form>

            </div>

        </div>
    );
}
