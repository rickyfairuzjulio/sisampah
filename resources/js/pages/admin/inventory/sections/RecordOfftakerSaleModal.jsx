import React, { useState } from 'react';
import { X, Truck, DollarSign, Upload, CheckCircle2, Building, Scale, ArrowRight } from 'lucide-react';

export default function RecordOfftakerSaleModal({
    isOpen,
    onClose,
    selectedCategory = null,
    onSuccess,
}) {
    if (!isOpen) return null;

    const [category, setCategory] = useState(selectedCategory?.name || 'Plastik PET & Campur');
    const [weightKg, setWeightKg] = useState(selectedCategory?.stock_kg || 1000);
    const [pricePerKg, setPricePerKg] = useState(selectedCategory?.price_per_kg || 4500);
    const [buyerName, setBuyerName] = useState('PT Daur Ulang Nusantara');
    const [paymentMethod, setPaymentMethod] = useState('Transfer Rekening Unit');
    const [notes, setNotes] = useState('Pengangkutan berkala truk pabrik daur ulang partai besar.');
    const [isSubmitted, setIsSubmitted] = useState(false);

    const totalRevenue = (Number(weightKg) || 0) * (Number(pricePerKg) || 0);

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsSubmitted(true);
        setTimeout(() => {
            setIsSubmitted(false);
            if (onSuccess) onSuccess({ category, weightKg, pricePerKg, totalRevenue, buyerName });
            onClose();
        }, 1200);
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fade-in select-none">
            
            <div className="relative w-full max-w-xl bg-white border border-slate-200 rounded-3xl shadow-2xl overflow-hidden animate-slide-in">
                
                {/* Modal Header */}
                <div className="p-6 bg-gradient-to-r from-blue-600 to-indigo-700 text-white flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center font-bold">
                            <Truck className="w-5 h-5" />
                        </div>
                        <div>
                            <h3 className="font-black text-lg text-white tracking-tight">
                                Catat Penjualan ke Pengepul / Pabrik
                            </h3>
                            <p className="text-xs text-blue-100">
                                Transaksi partai besar akan otomatis menambah saldo Kas Unit
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

                {/* Form Body */}
                <form onSubmit={handleSubmit} className="p-6 space-y-4">
                    
                    {/* Category & Buyer */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Kategori Material Sampah</label>
                            <select
                                value={category}
                                onChange={(e) => setCategory(e.target.value)}
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-emerald-600"
                            >
                                <option value="Plastik PET & Campur">🍾 Plastik PET & Campur</option>
                                <option value="Kardus & Kertas Duplek">📦 Kardus & Kertas Duplek</option>
                                <option value="Besi, Logam & Kaleng">🔩 Besi, Logam & Kaleng</option>
                                <option value="Minyak Jelantah (UCO)">🛢️ Minyak Jelantah (UCO)</option>
                            </select>
                        </div>

                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Nama Pengepul / Pabrik Mitra</label>
                            <input
                                type="text"
                                value={buyerName}
                                onChange={(e) => setBuyerName(e.target.value)}
                                required
                                placeholder="Contoh: PT Daur Ulang Nusantara"
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-emerald-600"
                            />
                        </div>
                    </div>

                    {/* Weight & Price per Kg */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Berat Muatan Ditimbang (Kg)</label>
                            <input
                                type="number"
                                step="any"
                                value={weightKg}
                                onChange={(e) => setWeightKg(e.target.value)}
                                required
                                placeholder="Contoh: 1000"
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-emerald-600"
                            />
                        </div>

                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Harga Jual Satuan (Rp/Kg)</label>
                            <input
                                type="number"
                                value={pricePerKg}
                                onChange={(e) => setPricePerKg(e.target.value)}
                                required
                                placeholder="Contoh: 4500"
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-emerald-600"
                            />
                        </div>
                    </div>

                    {/* Calculation Summary Box */}
                    <div className="p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200 flex items-center justify-between">
                        <div>
                            <span className="text-[11px] font-bold text-emerald-800 uppercase tracking-wider block">
                                Total Kas Masuk Unit:
                            </span>
                            <span className="text-xs text-emerald-700 font-medium">
                                {Number(weightKg).toLocaleString('id-ID')} Kg × Rp {Number(pricePerKg).toLocaleString('id-ID')}
                            </span>
                        </div>
                        <p className="text-xl sm:text-2xl font-black text-emerald-950">
                            +Rp {totalRevenue.toLocaleString('id-ID')}
                        </p>
                    </div>

                    {/* Payment Method & Notes */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Metode Pembayaran Pengepul</label>
                            <select
                                value={paymentMethod}
                                onChange={(e) => setPaymentMethod(e.target.value)}
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-emerald-600"
                            >
                                <option value="Transfer Rekening Unit">💳 Transfer ke Rekening Kas Unit</option>
                                <option value="Tunai Kas Unit">💵 Tunai Kasir Unit</option>
                            </select>
                        </div>

                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Upload Foto Nota Timbang (Opsional)</label>
                            <div className="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-dashed border-slate-300 text-xs text-slate-500 flex items-center gap-2 cursor-pointer hover:bg-slate-100 transition-colors">
                                <Upload className="w-4 h-4 text-slate-400 shrink-0" />
                                <span className="truncate">Pilih file nota pabrik...</span>
                            </div>
                        </div>
                    </div>

                    {/* Submit Button */}
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
                            disabled={isSubmitted}
                            className="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-black transition-all shadow-md flex items-center gap-2 cursor-pointer disabled:opacity-50"
                        >
                            {isSubmitted ? (
                                <>
                                    <CheckCircle2 className="w-4 h-4 text-white animate-spin" />
                                    <span>Menyimpan...</span>
                                </>
                            ) : (
                                <>
                                    <span>Simpan & Tambah Kas Unit</span>
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
