import React, { useState } from 'react';
import { X, Sparkles, Package, Users, Calendar, ArrowRight, CheckCircle2 } from 'lucide-react';

export default function RecordUpcyclingModal({
    isOpen,
    onClose,
    onSuccess,
}) {
    if (!isOpen) return null;

    const [rawCategory, setRawCategory] = useState('Plastik Sachet & Residu');
    const [rawWeightKg, setRawWeightKg] = useState(100);
    const [productType, setProductType] = useState('Tas Belanja Kreatif Daur Ulang');
    const [outputQty, setOutputQty] = useState(50);
    const [outputUnit, setOutputUnit] = useState('pcs');
    const [crafterTeam, setCrafterTeam] = useState('Kelompok Kader PKK Unit Melati');
    const [isSubmitted, setIsSubmitted] = useState(false);

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsSubmitted(true);
        setTimeout(() => {
            setIsSubmitted(false);
            if (onSuccess) onSuccess({ rawCategory, rawWeightKg, productType, outputQty, outputUnit, crafterTeam });
            onClose();
        }, 1200);
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fade-in select-none">
            
            <div className="relative w-full max-w-xl bg-white border border-slate-200 rounded-3xl shadow-2xl overflow-hidden animate-slide-in">
                
                {/* Modal Header */}
                <div className="p-6 bg-gradient-to-r from-purple-600 to-indigo-700 text-white flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center font-bold">
                            <Sparkles className="w-5 h-5" />
                        </div>
                        <div>
                            <h3 className="font-black text-lg text-white tracking-tight">
                                Catat Transformasi Karya & Kompos
                            </h3>
                            <p className="text-xs text-purple-100">
                                Alihkan sampah menjadi produk bernilai tambah dan ekonomi sirkular
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
                    
                    {/* Raw Material & Weight */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Sampah Bahan Baku</label>
                            <select
                                value={rawCategory}
                                onChange={(e) => setRawCategory(e.target.value)}
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-purple-600"
                            >
                                <option value="Plastik Sachet & Residu">🧴 Plastik Sachet / Kemasan Kopi</option>
                                <option value="Sampah Organik & Daun">🍂 Sampah Organik / Dedaunan</option>
                                <option value="Minyak Jelantah (UCO)">🛢️ Minyak Jelantah Bekas</option>
                                <option value="Kardus & Kertas">📦 Kertas & Kardus Bekas</option>
                            </select>
                        </div>

                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Berat Dialihkan (Kg/Liter)</label>
                            <input
                                type="number"
                                step="any"
                                value={rawWeightKg}
                                onChange={(e) => setRawWeightKg(e.target.value)}
                                required
                                placeholder="Contoh: 100"
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-purple-600"
                            />
                        </div>
                    </div>

                    {/* Output Product & Quantity */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Jenis Produk Hasil Olahan</label>
                            <select
                                value={productType}
                                onChange={(e) => setProductType(e.target.value)}
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-purple-600"
                            >
                                <option value="Tas Belanja Kreatif Daur Ulang">🛍️ Tas Belanja Kreatif Daur Ulang</option>
                                <option value="Pupuk Kompos Organik Padat">🌿 Pupuk Kompos Organik Padat</option>
                                <option value="Lilin Aromaterapi Jelantah">🕯️ Lilin Aromaterapi Jelantah</option>
                                <option value="Pakan Maggot BSF">🪱 Pakan Maggot BSF</option>
                                <option value="Paving Block Ecobrick">🧱 Paving Block Ecobrick</option>
                            </select>
                        </div>

                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Target Output ({outputUnit})</label>
                            <div className="flex items-center gap-2">
                                <input
                                    type="number"
                                    value={outputQty}
                                    onChange={(e) => setOutputQty(e.target.value)}
                                    required
                                    placeholder="Contoh: 50"
                                    className="flex-1 px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-purple-600"
                                />
                                <select
                                    value={outputUnit}
                                    onChange={(e) => setOutputUnit(e.target.value)}
                                    className="w-24 px-2 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-purple-600"
                                >
                                    <option value="pcs">pcs</option>
                                    <option value="Kg">Kg</option>
                                    <option value="botol">botol</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {/* Crafter / Artisan Team */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Tim Pengrajin / Kelompok Pengolah</label>
                        <input
                            type="text"
                            value={crafterTeam}
                            onChange={(e) => setCrafterTeam(e.target.value)}
                            required
                            placeholder="Contoh: Kelompok Kader PKK RW 02"
                            className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-purple-600"
                        />
                    </div>

                    {/* Summary Info */}
                    <div className="p-3.5 rounded-2xl bg-purple-50 border border-purple-200 text-xs text-purple-900 flex items-center gap-2.5">
                        <Sparkles className="w-4 h-4 text-purple-600 shrink-0" />
                        <span>
                            Stok <strong>{rawCategory}</strong> di gudang akan otomatis dipindahkan statusnya ke <strong>Alur Upcycling</strong>.
                        </span>
                    </div>

                    {/* Action Buttons */}
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
                            className="px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-black transition-all shadow-md flex items-center gap-2 cursor-pointer disabled:opacity-50"
                        >
                            {isSubmitted ? (
                                <>
                                    <CheckCircle2 className="w-4 h-4 text-white animate-spin" />
                                    <span>Menyimpan...</span>
                                </>
                            ) : (
                                <>
                                    <span>Catat Proses Upcycling</span>
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
