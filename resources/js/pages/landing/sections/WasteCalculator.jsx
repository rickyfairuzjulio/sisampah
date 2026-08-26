import React, { useState, useMemo } from 'react';
import { Calculator, Sparkles, Leaf, Coins, ArrowRight, TreePine } from 'lucide-react';

export default function WasteCalculator({ categories = [] }) {
    // Fallback master categories if DB empty
    const fallbackCategories = [
        { id: 1, nama: 'Botol Plastik PET Bersih', harga_per_kg: 4500, satuan: 'kg' },
        { id: 2, nama: 'Kardus Box Cokelat', harga_per_kg: 2800, satuan: 'kg' },
        { id: 3, nama: 'Kaleng Minuman Aluminium', harga_per_kg: 14000, satuan: 'kg' },
        { id: 4, nama: 'Minyak Jelantah', harga_per_kg: 7500, satuan: 'kg' },
        { id: 5, nama: 'Besi Padat / Logam', harga_per_kg: 5000, satuan: 'kg' },
        { id: 6, nama: 'Kertas HVS / Arsip Putih', harga_per_kg: 3200, satuan: 'kg' },
    ];

    const activeCategories = categories.length > 0 ? categories : fallbackCategories;

    const [selectedCategoryId, setSelectedCategoryId] = useState(
        activeCategories[0]?.id || 1
    );
    const [weightKg, setWeightKg] = useState(15);

    const selectedCategory = useMemo(() => {
        return (
            activeCategories.find((c) => c.id === Number(selectedCategoryId)) ||
            activeCategories[0]
        );
    }, [activeCategories, selectedCategoryId]);

    const pricePerKg = selectedCategory?.harga_per_kg || 4000;
    const totalRupiah = weightKg * pricePerKg;
    const co2SavedKg = (weightKg * 1.25).toFixed(1);
    const treesEquivalent = (weightKg * 0.05).toFixed(1);

    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(amount);
    };

    return (
        <div className="rounded-3xl bg-[#061E17] border border-white/10 p-6 sm:p-8 space-y-6 shadow-2xl relative overflow-hidden">
            
            {/* Ambient subtle glow */}
            <div className="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none" />

            {/* Header */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-white/10 pb-5">
                <div>
                    <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-xs font-bold mb-1.5">
                        <Calculator className="w-3.5 h-3.5" />
                        <span>Kalkulator Cerdas Real-Time</span>
                    </div>
                    <h3 className="text-xl sm:text-2xl font-black text-white">
                        Simulasi Nilai Sampah Anda
                    </h3>
                </div>
                <span className="text-xs text-white/50 bg-white/5 px-3 py-1.5 rounded-xl border border-white/5 self-start sm:self-auto">
                    Master Harga Database Terkini
                </span>
            </div>

            {/* Controls Grid */}
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                
                {/* Category Dropdown */}
                <div className="space-y-2">
                    <label className="text-xs font-bold text-white/70 uppercase tracking-wider block">
                        Pilih Kategori Sampah
                    </label>
                    <select
                        value={selectedCategoryId}
                        onChange={(e) => setSelectedCategoryId(e.target.value)}
                        className="w-full bg-[#03110D] border border-white/15 rounded-xl px-4 py-3 text-white text-sm font-semibold focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-colors cursor-pointer"
                    >
                        {activeCategories.map((cat) => (
                            <option key={cat.id} value={cat.id} className="bg-[#03110D] text-white">
                                {cat.nama} ({formatCurrency(cat.harga_per_kg)}/{cat.satuan || 'kg'})
                            </option>
                        ))}
                    </select>
                </div>

                {/* Weight Input & Slider */}
                <div className="space-y-2">
                    <div className="flex justify-between items-center">
                        <label className="text-xs font-bold text-white/70 uppercase tracking-wider">
                            Perkiraan Berat:
                        </label>
                        <span className="text-base font-extrabold text-emerald-400 bg-emerald-500/10 px-2.5 py-0.5 rounded-lg border border-emerald-500/20">
                            {weightKg} Kg
                        </span>
                    </div>
                    <input
                        type="range"
                        min="1"
                        max="100"
                        step="1"
                        value={weightKg}
                        onChange={(e) => setWeightKg(Number(e.target.value))}
                        className="w-full h-2.5 bg-white/10 rounded-lg appearance-none cursor-pointer accent-emerald-500"
                    />
                    <div className="flex justify-between text-[11px] text-white/40">
                        <span>1 Kg</span>
                        <span>50 Kg</span>
                        <span>100 Kg</span>
                    </div>
                </div>

            </div>

            {/* Output Result Cards */}
            <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                
                {/* 1. Rupiah Earned */}
                <div className="p-4 rounded-2xl bg-gradient-to-br from-emerald-900/40 to-[#041611] border border-emerald-500/30 space-y-1">
                    <div className="flex items-center gap-1.5 text-xs font-bold text-emerald-400">
                        <Coins className="w-4 h-4" />
                        <span>Estimasi Saldo</span>
                    </div>
                    <p className="text-2xl font-black text-white tracking-tight">
                        {formatCurrency(totalRupiah)}
                    </p>
                    <span className="text-[10px] text-white/50 block">
                        @{formatCurrency(pricePerKg)} per kg
                    </span>
                </div>

                {/* 2. CO2 Prevented */}
                <div className="p-4 rounded-2xl bg-white/[0.03] border border-white/10 space-y-1">
                    <div className="flex items-center gap-1.5 text-xs font-bold text-teal-400">
                        <Leaf className="w-4 h-4" />
                        <span>Reduksi Emisi CO₂</span>
                    </div>
                    <p className="text-2xl font-black text-white tracking-tight">
                        {co2SavedKg} <span className="text-sm font-semibold text-white/70">kg CO₂</span>
                    </p>
                    <span className="text-[10px] text-white/50 block">
                        Mencegah polusi TPA
                    </span>
                </div>

                {/* 3. Trees Saved Equivalent */}
                <div className="p-4 rounded-2xl bg-white/[0.03] border border-white/10 space-y-1">
                    <div className="flex items-center gap-1.5 text-xs font-bold text-emerald-300">
                        <TreePine className="w-4 h-4" />
                        <span>Setara Pohon</span>
                    </div>
                    <p className="text-2xl font-black text-white tracking-tight">
                        {treesEquivalent} <span className="text-sm font-semibold text-white/70">Pohon</span>
                    </p>
                    <span className="text-[10px] text-white/50 block">
                        Dampak serapan emisi
                    </span>
                </div>

            </div>

            {/* Quick action button inside calculator */}
            <div className="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-white/10 text-xs text-white/60">
                <span>Ingin langsung mencairkan saldo sampah Anda?</span>
                <a
                    href="/register"
                    className="inline-flex items-center gap-1.5 font-bold text-emerald-400 hover:text-emerald-300 transition-colors"
                >
                    <span>Mulai Setor Sekarang</span>
                    <ArrowRight className="w-3.5 h-3.5" />
                </a>
            </div>

        </div>
    );
}
