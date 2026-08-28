import React, { useState } from 'react';
import { X, Sparkles, Package, Users, Calendar, ArrowRight, CheckCircle2, AlertCircle } from 'lucide-react';

export default function RecordUpcyclingModal({
    isOpen,
    onClose,
    categories = [],
    csrfToken = '',
    onSuccess,
}) {
    if (!isOpen) return null;

    const defaultCatId = categories[0]?.category_id || categories[0]?.id || 1;
    const [categoryId, setCategoryId] = useState(defaultCatId);
    const [rawWeightKg, setRawWeightKg] = useState(50);
    const [productName, setProductName] = useState('Tas Belanja Kreatif Daur Ulang');
    const [outputQty, setOutputQty] = useState(25);
    const [outputUnit, setOutputUnit] = useState('Pcs');
    const [unitPrice, setUnitPrice] = useState(25000);
    const [crafterTeam, setCrafterTeam] = useState('Kader PKK RW 02');
    const [description, setDescription] = useState('Dibuat dari kemasan sachet plastik kopi daur ulang.');
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [errorMessage, setErrorMessage] = useState('');

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsSubmitting(true);
        setErrorMessage('');

        const payload = {
            trash_category_id: categoryId,
            nama_produk: productName,
            jumlah_bahan_kg: rawWeightKg,
            stok_qty: outputQty,
            satuan: outputUnit,
            harga_satuan: unitPrice,
            pengrajin: crafterTeam,
            deskripsi: description,
        };

        try {
            const token = csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const response = await fetch('/admin/inventaris/olah-karya', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token || '',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const resData = await response.json();
            if (response.ok && resData.success) {
                if (onSuccess) onSuccess(resData.message);
                onClose();
            } else {
                setErrorMessage(resData.message || 'Gagal menyimpan pengalihan upcycling.');
            }
        } catch (err) {
            console.error('Error submitting upcycling:', err);
            setErrorMessage('Terjadi kesalahan jaringan atau server.');
        } finally {
            setIsSubmitting(false);
        }
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
                    {errorMessage && (
                        <div className="p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl flex items-center gap-2 font-medium">
                            <AlertCircle className="w-4 h-4 shrink-0" />
                            <span>{errorMessage}</span>
                        </div>
                    )}
                    
                    {/* Raw Material & Weight */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Sampah Bahan Baku</label>
                            <select
                                value={categoryId}
                                onChange={(e) => setCategoryId(parseInt(e.target.value, 10))}
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-purple-600"
                            >
                                {categories.map((c) => (
                                    <option key={c.category_id || c.id} value={c.category_id || c.id}>
                                        {c.name || c.nama} {c.stock_kg ? `(Tersedia ${Number(c.stock_kg).toLocaleString('id-ID')} Kg)` : ''}
                                    </option>
                                ))}
                            </select>
                        </div>

                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Berat Dialihkan (Kg/Liter)</label>
                            <input
                                type="number"
                                step="any"
                                min="1"
                                value={rawWeightKg}
                                onChange={(e) => setRawWeightKg(e.target.value)}
                                required
                                placeholder="Contoh: 50"
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-purple-600"
                            />
                        </div>
                    </div>

                    {/* Output Product & Quantity */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Nama Produk Hasil Olahan</label>
                            <input
                                type="text"
                                value={productName}
                                onChange={(e) => setProductName(e.target.value)}
                                required
                                placeholder="Contoh: Tas Belanja Kreatif Daur Ulang"
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-purple-600"
                            />
                        </div>

                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Target Output & Satuan</label>
                            <div className="flex items-center gap-2">
                                <input
                                    type="number"
                                    min="1"
                                    value={outputQty}
                                    onChange={(e) => setOutputQty(e.target.value)}
                                    required
                                    placeholder="Contoh: 25"
                                    className="flex-1 px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-purple-600"
                                />
                                <select
                                    value={outputUnit}
                                    onChange={(e) => setOutputUnit(e.target.value)}
                                    className="w-24 px-2 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-purple-600"
                                >
                                    <option value="Pcs">Pcs</option>
                                    <option value="Kg">Kg</option>
                                    <option value="Botol">Botol</option>
                                    <option value="Paket">Paket</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {/* Price & Crafter */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Estimasi Harga Jual (Rp/{outputUnit})</label>
                            <input
                                type="number"
                                min="0"
                                value={unitPrice}
                                onChange={(e) => setUnitPrice(e.target.value)}
                                required
                                placeholder="Contoh: 25000"
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-purple-600"
                            />
                        </div>

                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Tim Pengrajin / Kelompok</label>
                            <input
                                type="text"
                                value={crafterTeam}
                                onChange={(e) => setCrafterTeam(e.target.value)}
                                required
                                placeholder="Contoh: Kader PKK RW 02"
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-purple-600"
                            />
                        </div>
                    </div>

                    {/* Summary Info */}
                    <div className="p-3.5 rounded-2xl bg-purple-50 border border-purple-200 text-xs text-purple-900 flex items-center gap-2.5">
                        <Sparkles className="w-4 h-4 text-purple-600 shrink-0" />
                        <span>
                            Stok bahan baku di gudang otomatis dikurangi dan produk baru akan masuk ke katalog circular.
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
                            disabled={isSubmitting}
                            className="px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-black transition-all shadow-md flex items-center gap-2 cursor-pointer disabled:opacity-50"
                        >
                            {isSubmitting ? (
                                <>
                                    <CheckCircle2 className="w-4 h-4 text-white animate-spin" />
                                    <span>Menyimpan ke Database...</span>
                                </>
                            ) : (
                                <>
                                    <span>Simpan Produk Upcycling</span>
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
