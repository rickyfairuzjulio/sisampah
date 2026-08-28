import React, { useState, useEffect } from 'react';
import { X, Truck, DollarSign, Upload, CheckCircle2, Building, Scale, ArrowRight, AlertCircle } from 'lucide-react';

export default function RecordOfftakerSaleModal({
    isOpen,
    onClose,
    selectedCategory = null,
    categories = [],
    csrfToken = '',
    onSuccess,
}) {
    if (!isOpen) return null;

    const defaultCat = selectedCategory || categories[0] || { id: 1, name: 'Plastik PET & Campur', stock_kg: 500, price_per_kg: 4500 };
    const [categoryId, setCategoryId] = useState(defaultCat.category_id || defaultCat.id || 1);
    const [weightKg, setWeightKg] = useState(defaultCat.stock_kg || 500);
    const [pricePerKg, setPricePerKg] = useState(defaultCat.price_per_kg || 4500);
    const [buyerName, setBuyerName] = useState('PT Daur Ulang Nusantara');
    const [notes, setNotes] = useState('Pengangkutan berkala truk pabrik daur ulang partai besar.');
    const [fotoNota, setFotoNota] = useState(null);
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [errorMessage, setErrorMessage] = useState('');

    useEffect(() => {
        if (selectedCategory) {
            setCategoryId(selectedCategory.category_id || selectedCategory.id);
            setWeightKg(selectedCategory.stock_kg || 500);
            setPricePerKg(selectedCategory.price_per_kg || 4500);
        }
    }, [selectedCategory]);

    const handleCategoryChange = (e) => {
        const id = parseInt(e.target.value, 10);
        setCategoryId(id);
        const found = categories.find((c) => (c.category_id || c.id) === id);
        if (found) {
            if (found.stock_kg) setWeightKg(found.stock_kg);
            if (found.price_per_kg) setPricePerKg(found.price_per_kg);
        }
    };

    const totalRevenue = (Number(weightKg) || 0) * (Number(pricePerKg) || 0);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsSubmitting(true);
        setErrorMessage('');

        const formData = new FormData();
        formData.append('trash_category_id', categoryId);
        formData.append('nama_pembeli', buyerName);
        formData.append('berat_kg', weightKg);
        formData.append('harga_per_kg', pricePerKg);
        formData.append('catatan', notes);
        if (fotoNota) {
            formData.append('foto_nota', fotoNota);
        }

        try {
            const token = csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const response = await fetch('/admin/inventaris/jual-pengepul', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token || '',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const resData = await response.json();
            if (response.ok && resData.success) {
                if (onSuccess) onSuccess(resData.message);
                onClose();
            } else {
                setErrorMessage(resData.message || 'Gagal mencatat penjualan ke pengepul.');
            }
        } catch (err) {
            console.error('Error submitting offtaker sale:', err);
            setErrorMessage('Terjadi kesalahan jaringan atau server.');
        } finally {
            setIsSubmitting(false);
        }
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
                                Transaksi partai besar akan otomatis mengurangi stok & menambah saldo Kas Unit
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
                    {errorMessage && (
                        <div className="p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl flex items-center gap-2 font-medium">
                            <AlertCircle className="w-4 h-4 shrink-0" />
                            <span>{errorMessage}</span>
                        </div>
                    )}
                    
                    {/* Category & Buyer */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Kategori Material Sampah</label>
                            <select
                                value={categoryId}
                                onChange={handleCategoryChange}
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-emerald-600"
                            >
                                {categories.map((c) => (
                                    <option key={c.category_id || c.id} value={c.category_id || c.id}>
                                        {c.name || c.nama} {c.stock_kg ? `(${Number(c.stock_kg).toLocaleString('id-ID')} Kg)` : ''}
                                    </option>
                                ))}
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
                                min="1"
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
                                min="100"
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

                    {/* Upload Foto Nota & Notes */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Upload Foto Nota / Surat Jalan</label>
                            <input
                                type="file"
                                accept="image/*"
                                onChange={(e) => setFotoNota(e.target.files[0])}
                                className="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 file:mr-3 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            />
                        </div>

                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Catatan Pengangkutan</label>
                            <input
                                type="text"
                                value={notes}
                                onChange={(e) => setNotes(e.target.value)}
                                placeholder="Keterangan ritase / armada..."
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-900 focus:outline-emerald-600"
                            />
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
                            disabled={isSubmitting}
                            className="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-black transition-all shadow-md flex items-center gap-2 cursor-pointer disabled:opacity-50"
                        >
                            {isSubmitting ? (
                                <>
                                    <CheckCircle2 className="w-4 h-4 text-white animate-spin" />
                                    <span>Menyimpan ke Database...</span>
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
