import React from 'react';
import { Sparkles, ShoppingBag, Leaf, Flame, Bug, Tag, ArrowUpRight } from 'lucide-react';

export default function UpcyclingProductsGrid() {
    const products = [
        {
            id: 1,
            title: 'Tas Belanja Anyam Sachet',
            rawMaterial: '100 Kg Plastik Sachet Kopi',
            stockQty: '50 Pcs',
            priceEstimate: 'Rp 25.000/pcs',
            totalValuation: 'Rp 1.250.000',
            crafter: 'Kader PKK RW 02',
            badgeColor: 'bg-indigo-100 text-indigo-800 border-indigo-200',
            emoji: '🛍️',
        },
        {
            id: 2,
            title: 'Pupuk Kompos Organik Super',
            rawMaterial: '350 Kg Daun & Sisa Makanan',
            stockQty: '200 Kg',
            priceEstimate: 'Rp 5.000/Kg',
            totalValuation: 'Rp 1.000.000',
            crafter: 'Tim Kebun Hijau Unit',
            badgeColor: 'bg-emerald-100 text-emerald-800 border-emerald-200',
            emoji: '🌿',
        },
        {
            id: 3,
            title: 'Lilin Aromaterapi Jelantah',
            rawMaterial: '50 Liter Minyak Jelantah',
            stockQty: '80 Pcs',
            priceEstimate: 'Rp 15.000/pcs',
            totalValuation: 'Rp 1.200.000',
            crafter: 'Kelompok Pemuda Karang Taruna',
            badgeColor: 'bg-purple-100 text-purple-800 border-purple-200',
            emoji: '🕯️',
        },
        {
            id: 4,
            title: 'Pakan Maggot BSF Kering',
            rawMaterial: '400 Kg Buah & Sayur Busuk',
            stockQty: '120 Kg',
            priceEstimate: 'Rp 12.000/Kg',
            totalValuation: 'Rp 1.440.000',
            crafter: 'Unit Biokonversi Melati',
            badgeColor: 'bg-amber-100 text-amber-800 border-amber-200',
            emoji: '🪱',
        },
    ];

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-5 select-none">
            
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-2xl bg-purple-100 text-purple-800 flex items-center justify-center font-bold">
                        <Sparkles className="w-5 h-5" />
                    </div>
                    <div>
                        <h3 className="font-black text-lg text-slate-900 tracking-tight">
                            Katalog Produk Daur Ulang & Ekonomi Sirkular 🎨
                        </h3>
                        <p className="text-xs text-slate-500">
                            Produk bernilai tambah tinggi hasil olahan kelompok pengrajin & kader bank sampah unit
                        </p>
                    </div>
                </div>

                <span className="text-xs font-black text-purple-800 bg-purple-50 px-3 py-1.5 rounded-xl border border-purple-200 self-start sm:self-auto">
                    Total Nilai Tambah: Rp 4.890.000
                </span>
            </div>

            {/* Grid 4 Products */}
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {products.map((item) => (
                    <div
                        key={item.id}
                        className="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 hover:bg-purple-50/20 hover:border-purple-200 transition-all flex flex-col justify-between space-y-3 group"
                    >
                        <div className="space-y-2">
                            <div className="flex items-start justify-between">
                                <div className="text-3xl group-hover:scale-110 transition-transform">
                                    {item.emoji}
                                </div>
                                <span className={`px-2 py-0.5 rounded-full text-[9px] font-extrabold border ${item.badgeColor}`}>
                                    {item.stockQty} Siap Jual
                                </span>
                            </div>

                            <div>
                                <h4 className="font-black text-xs text-slate-900 group-hover:text-purple-900 transition-colors leading-tight">
                                    {item.title}
                                </h4>
                                <span className="text-[10px] text-slate-400 font-medium block mt-0.5">
                                    Bahan: {item.rawMaterial}
                                </span>
                            </div>
                        </div>

                        <div className="pt-2 border-t border-slate-200/60 space-y-1">
                            <div className="flex items-center justify-between text-[11px]">
                                <span className="font-semibold text-slate-500">Harga Satuan:</span>
                                <span className="font-bold text-slate-800">{item.priceEstimate}</span>
                            </div>
                            <div className="flex items-center justify-between text-[11px]">
                                <span className="font-bold text-purple-700">Valuasi Total:</span>
                                <span className="font-black text-purple-900">{item.totalValuation}</span>
                            </div>
                            <span className="text-[9px] text-slate-400 block pt-0.5 truncate">
                                👥 Pengolah: {item.crafter}
                            </span>
                        </div>
                    </div>
                ))}
            </div>

        </div>
    );
}
