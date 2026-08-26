import React from 'react';
import { Plus, Trash2, Scale, AlertCircle, CheckCircle2, Coins } from 'lucide-react';

export default function TrashItemsRepeater({
    items = [],
    trashCategories = [],
    onAddItem,
    onRemoveItem,
    onItemChange,
}) {
    const formatCurrency = (val) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(val || 0);
    };

    // Calculate total weight and estimated payout
    const totalWeight = items.reduce((sum, it) => sum + (parseFloat(it.perkiraan_berat) || 0), 0);

    const totalEstimatedEarnings = items.reduce((sum, it) => {
        const cat = trashCategories.find((c) => String(c.id) === String(it.trash_category_id));
        const price = cat ? cat.harga_per_kg : 0;
        const weight = parseFloat(it.perkiraan_berat) || 0;
        return sum + price * weight;
    }, 0);

    const isWeightValid = totalWeight >= 5.0;

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
            
            {/* Step Header */}
            <div className="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                <div className="w-10 h-10 rounded-2xl bg-emerald-600 text-white font-black text-base flex items-center justify-center shrink-0 shadow-md">
                    1
                </div>
                <div>
                    <h3 className="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">
                        Daftar Sampah & Estimasi Berat
                    </h3>
                    <p className="text-xs text-slate-500 mt-0.5">
                        Pilih jenis sampah dan masukkan perkiraan berat. Minimal total penjemputan armada adalah <strong>5.0 Kg</strong>.
                    </p>
                </div>
            </div>

            {/* Items Dynamic Rows */}
            <div className="space-y-4">
                {items.map((item, idx) => {
                    const selectedCat = trashCategories.find((c) => String(c.id) === String(item.trash_category_id));
                    const rowPrice = selectedCat ? selectedCat.harga_per_kg : 0;
                    const rowWeight = parseFloat(item.perkiraan_berat) || 0;
                    const rowSubtotal = rowPrice * rowWeight;

                    return (
                        <div 
                            key={idx}
                            className="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-start sm:items-end gap-4 relative group hover:border-emerald-300 transition-colors"
                        >
                            {/* Hidden inputs for native form submission */}
                            <input 
                                type="hidden" 
                                name={`items[${idx}][trash_category_id]`} 
                                value={item.trash_category_id} 
                            />
                            <input 
                                type="hidden" 
                                name={`items[${idx}][perkiraan_berat]`} 
                                value={item.perkiraan_berat} 
                            />

                            {/* 1. Category Selector */}
                            <div className="flex-1 w-full">
                                <label className="block text-xs font-bold text-slate-700 mb-1.5">
                                    Jenis Sampah #{idx + 1} <span className="text-emerald-600">*</span>
                                </label>
                                <select
                                    value={item.trash_category_id}
                                    onChange={(e) => onItemChange(idx, 'trash_category_id', e.target.value)}
                                    className="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none cursor-pointer transition-all shadow-2xs"
                                    required
                                >
                                    <option value="" disabled>-- Pilih Kategori Sampah --</option>
                                    {trashCategories.map((cat) => (
                                        <option key={cat.id} value={cat.id}>
                                            {cat.nama} ({formatCurrency(cat.harga_per_kg)}/{cat.satuan || 'Kg'})
                                        </option>
                                    ))}
                                </select>
                            </div>

                            {/* 2. Weight Input (Kg) */}
                            <div className="w-full sm:w-44">
                                <label className="block text-xs font-bold text-slate-700 mb-1.5">
                                    Perkiraan Berat (Kg) <span className="text-emerald-600">*</span>
                                </label>
                                <div className="relative">
                                    <input
                                        type="number"
                                        min="0.1"
                                        step="0.5"
                                        value={item.perkiraan_berat}
                                        onChange={(e) => onItemChange(idx, 'perkiraan_berat', e.target.value)}
                                        placeholder="Contoh: 3.5"
                                        className="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm font-bold text-slate-900 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all shadow-2xs pr-10"
                                        required
                                    />
                                    <span className="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400 pointer-events-none">
                                        Kg
                                    </span>
                                </div>
                            </div>

                            {/* 3. Subtotal Preview */}
                            <div className="hidden sm:block text-right pb-2 min-w-[110px]">
                                <span className="text-[10px] font-bold text-slate-400 block uppercase">Subtotal</span>
                                <span className="font-extrabold text-emerald-700 text-xs sm:text-sm">
                                    {formatCurrency(rowSubtotal)}
                                </span>
                            </div>

                            {/* 4. Remove Button */}
                            {items.length > 1 && (
                                <button
                                    type="button"
                                    onClick={() => onRemoveItem(idx)}
                                    className="p-2.5 rounded-xl bg-white hover:bg-red-50 text-slate-400 hover:text-red-600 border border-slate-200 hover:border-red-200 transition-colors shadow-2xs shrink-0 self-end sm:self-auto"
                                    title="Hapus baris ini"
                                >
                                    <Trash2 className="w-4 h-4" />
                                </button>
                            )}
                        </div>
                    );
                })}
            </div>

            {/* Add More Item Button */}
            <button
                type="button"
                onClick={onAddItem}
                className="w-full py-3 px-4 border-2 border-dashed border-emerald-300 hover:border-emerald-500 bg-emerald-50/40 hover:bg-emerald-50 text-emerald-700 font-bold text-xs sm:text-sm rounded-2xl transition-all flex items-center justify-center gap-2 cursor-pointer shadow-2xs"
            >
                <Plus className="w-4 h-4" />
                <span>Tambah Jenis Sampah Lain</span>
            </button>

            {/* Live Calculation Bar */}
            <div className="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-slate-50 to-emerald-50/30 border border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                
                {/* Total Weight Status */}
                <div className="flex items-center gap-3">
                    <div className={`w-10 h-10 rounded-xl flex items-center justify-center font-bold shrink-0 ${
                        isWeightValid ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'
                    }`}>
                        <Scale className="w-5 h-5" />
                    </div>
                    <div>
                        <div className="flex items-center gap-2">
                            <span className="text-xs font-bold text-slate-600">Total Akumulasi:</span>
                            <span className="text-base sm:text-lg font-black text-slate-900">
                                {totalWeight.toFixed(1)} Kg
                            </span>
                        </div>
                        <p className="text-[11px] text-slate-500 font-medium">
                            {isWeightValid ? (
                                <span className="text-emerald-700 font-bold flex items-center gap-1">
                                    <CheckCircle2 className="w-3.5 h-3.5" />
                                    <span>Memenuhi syarat penjemputan armada (≥ 5 Kg)</span>
                                </span>
                            ) : (
                                <span className="text-amber-700 font-bold flex items-center gap-1">
                                    <AlertCircle className="w-3.5 h-3.5" />
                                    <span>Kurang {(5.0 - totalWeight).toFixed(1)} Kg lagi untuk mencapai minimal 5 Kg</span>
                                </span>
                            )}
                        </p>
                    </div>
                </div>

                {/* Total Estimated Earnings */}
                <div className="text-left sm:text-right border-t sm:border-t-0 pt-3 sm:pt-0 w-full sm:w-auto">
                    <span className="text-[10px] font-bold text-slate-400 block uppercase tracking-wider">
                        ESTIMASI PENDAPATAN
                    </span>
                    <span className="text-lg sm:text-xl font-black text-emerald-600">
                        {formatCurrency(totalEstimatedEarnings)}
                    </span>
                </div>

            </div>

        </div>
    );
}
