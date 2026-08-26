import React from 'react';
import { Plus, Trash2, Scale, Sparkles, AlertCircle } from 'lucide-react';

export default function WeighingItemsRepeater({
    trashCategories = [],
    items = [],
    onAddItem,
    onRemoveItem,
    onUpdateItem,
}) {
    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-2xs space-y-5 select-none">
            
            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                <div className="flex items-center gap-2.5">
                    <div className="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-black text-sm">
                        1
                    </div>
                    <div>
                        <h3 className="font-black text-base text-slate-900 tracking-tight">
                            Rincian Timbangan Sampah
                        </h3>
                        <p className="text-xs text-slate-500">
                            Pilih kategori sampah dan masukkan berat timbangan riil (Kg)
                        </p>
                    </div>
                </div>

                <span className="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                    {items.length} Baris Timbangan
                </span>
            </div>

            {/* List of Item Rows */}
            <div className="space-y-4">
                {items.map((row, index) => {
                    const selectedCat = trashCategories.find((c) => String(c.id) === String(row.trash_category_id));
                    const pricePerKg = selectedCat ? Number(selectedCat.harga_per_kg) : 0;
                    const weight = parseFloat(row.berat_kg) || 0;
                    const subtotal = weight * pricePerKg;

                    return (
                        <div
                            key={row.id || index}
                            className="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/90 hover:border-emerald-500/40 transition-colors flex flex-col sm:flex-row items-stretch sm:items-end gap-4"
                        >
                            {/* Hidden index input for standard Laravel form submission */}
                            <input
                                type="hidden"
                                name={`items[${index}][trash_category_id]`}
                                value={row.trash_category_id || ''}
                            />
                            <input
                                type="hidden"
                                name={`items[${index}][berat_kg]`}
                                value={row.berat_kg || ''}
                            />

                            {/* Column 1: Kategori Sampah */}
                            <div className="flex-1 space-y-1.5">
                                <label className="block text-xs font-bold text-slate-700">
                                    Kategori Sampah <span className="text-rose-500">*</span>
                                </label>
                                <select
                                    value={row.trash_category_id || ''}
                                    onChange={(e) => onUpdateItem(index, 'trash_category_id', e.target.value)}
                                    required
                                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white text-xs sm:text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs cursor-pointer"
                                >
                                    <option value="" disabled>Pilih Kategori Sampah</option>
                                    {trashCategories.map((c) => (
                                        <option key={c.id} value={c.id}>
                                            {c.nama} — Rp {Number(c.harga_per_kg).toLocaleString('id-ID')}/Kg
                                        </option>
                                    ))}
                                </select>
                            </div>

                            {/* Column 2: Berat Kg */}
                            <div className="w-full sm:w-44 space-y-1.5">
                                <label className="block text-xs font-bold text-slate-700">
                                    Berat Riil (Kg) <span className="text-rose-500">*</span>
                                </label>
                                <div className="relative">
                                    <input
                                        type="number"
                                        step="0.1"
                                        min="0.1"
                                        placeholder="0.0"
                                        value={row.berat_kg || ''}
                                        onChange={(e) => onUpdateItem(index, 'berat_kg', e.target.value)}
                                        required
                                        className="w-full px-3.5 py-2.5 pr-10 rounded-xl border border-slate-300 bg-white text-xs sm:text-sm font-black text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs"
                                    />
                                    <span className="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400 pointer-events-none">
                                        Kg
                                    </span>
                                </div>
                            </div>

                            {/* Column 3: Subtotal Preview */}
                            <div className="w-full sm:w-40 space-y-1.5">
                                <label className="block text-xs font-bold text-slate-500">
                                    Subtotal (Rp)
                                </label>
                                <div className="px-3.5 py-2.5 rounded-xl bg-white border border-slate-200 text-xs sm:text-sm font-black text-emerald-700 shadow-2xs flex items-center justify-between">
                                    <span>Rp {subtotal.toLocaleString('id-ID')}</span>
                                </div>
                            </div>

                            {/* Column 4: Hapus Baris */}
                            {items.length > 1 && (
                                <button
                                    type="button"
                                    onClick={() => onRemoveItem(index)}
                                    className="p-2.5 rounded-xl text-rose-500 hover:text-rose-700 hover:bg-rose-50 border border-slate-200 hover:border-rose-200 transition-colors shadow-2xs cursor-pointer flex items-center justify-center"
                                    title="Hapus baris timbangan"
                                >
                                    <Trash2 className="w-4 h-4" />
                                </button>
                            )}
                        </div>
                    );
                })}
            </div>

            {/* Add Row Button */}
            <button
                type="button"
                onClick={onAddItem}
                className="w-full py-3 border-2 border-dashed border-emerald-300 hover:border-emerald-500 hover:bg-emerald-50 text-emerald-800 rounded-2xl font-extrabold text-xs transition-all flex items-center justify-center gap-2 cursor-pointer shadow-2xs"
            >
                <Plus className="w-4 h-4 text-emerald-600" />
                <span>Tambah Kategori Sampah Lain</span>
            </button>

        </div>
    );
}
