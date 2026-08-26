import React, { useState } from 'react';
import { X, Plus, Tag, DollarSign, Upload, Sparkles, CheckCircle2, ArrowRight } from 'lucide-react';

export default function CreatePriceCategoryModal({
    isOpen,
    onClose,
    onSuccess,
}) {
    if (!isOpen) return null;

    const [name, setName] = useState('');
    const [categoryGroup, setCategoryGroup] = useState('Plastik');
    const [unit, setUnit] = useState('Kg');
    const [pricePerKg, setPricePerKg] = useState(3500);
    const [kualitas, setKualitas] = useState('Grade A Bersih');
    const [description, setDescription] = useState('');
    const [isSubmitting, setIsSubmitting] = useState(false);

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsSubmitting(true);

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/trash-price';

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrf;
        form.appendChild(csrfInput);

        const fields = {
            nama: name,
            kategori: categoryGroup,
            satuan: unit,
            harga_per_kg: pricePerKg,
            kualitas: kualitas,
            deskripsi: description,
        };

        Object.entries(fields).forEach(([k, v]) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = k;
            input.value = v;
            form.appendChild(input);
        });

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
                            <Plus className="w-5 h-5" />
                        </div>
                        <div>
                            <h3 className="font-black text-lg text-white tracking-tight">
                                Tambah Kategori Sampah Baru
                            </h3>
                            <p className="text-xs text-emerald-100">
                                Daftarkan jenis material sampah baru di katalog unit
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
                    
                    {/* Name & Category Group */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Nama Material Sampah</label>
                            <input
                                type="text"
                                value={name}
                                onChange={(e) => setName(e.target.value)}
                                required
                                placeholder="Contoh: Botol Kaca Sirup"
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-emerald-600"
                            />
                        </div>

                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Kelompok Kategori</label>
                            <select
                                value={categoryGroup}
                                onChange={(e) => setCategoryGroup(e.target.value)}
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-emerald-600"
                            >
                                <option value="Plastik">🍾 Plastik</option>
                                <option value="Kertas">📦 Kertas & Karton</option>
                                <option value="Logam">🔩 Besi & Logam</option>
                                <option value="Kaca">🍶 Kaca & Beling</option>
                                <option value="Minyak">🛢️ Minyak Jelantah</option>
                                <option value="Organik">🍂 Sampah Organik</option>
                                <option value="Lainnya">🧴 Residu Bersih</option>
                            </select>
                        </div>
                    </div>

                    {/* Price & Unit */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Harga Beli Satuan (Rp)</label>
                            <input
                                type="number"
                                value={pricePerKg}
                                onChange={(e) => setPricePerKg(Number(e.target.value))}
                                required
                                min="100"
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-black text-slate-900 focus:outline-emerald-600"
                            />
                        </div>

                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Satuan Timbangan</label>
                            <select
                                value={unit}
                                onChange={(e) => setUnit(e.target.value)}
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-emerald-600"
                            >
                                <option value="Kg">Kilogram (Kg)</option>
                                <option value="Liter">Liter (L)</option>
                                <option value="Pcs">Buah / Pcs</option>
                            </select>
                        </div>
                    </div>

                    {/* Quality & Description */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Syarat / Kualitas Diterima</label>
                        <input
                            type="text"
                            value={kualitas}
                            onChange={(e) => setKualitas(e.target.value)}
                            placeholder="Contoh: Bersih, kering, tanpa label stiker"
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
                                    <span>Simpan Kategori</span>
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
