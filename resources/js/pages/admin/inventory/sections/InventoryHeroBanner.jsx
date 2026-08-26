import React from 'react';
import { Boxes, Truck, Sparkles, Scale, DollarSign, Plus } from 'lucide-react';

export default function InventoryHeroBanner({
    authData = {},
    stockData = {},
    onOpenSaleModal,
    onOpenUpcyclingModal,
}) {
    const unitName = authData?.bank_sampah_name || 'Unit Melati Asri';
    const totalStockKg = Number(stockData?.total_stock_kg || 3450).toLocaleString('id-ID');
    const estimatedValuation = Number(stockData?.estimated_valuation || 12850000).toLocaleString('id-ID');
    const capacityPct = stockData?.warehouse_capacity_pct || 68;

    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-md p-6 sm:p-8 animate-slide-in select-none">
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

            <div className="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                
                {/* Left Side: Unit Info & Title */}
                <div className="space-y-3 max-w-2xl">
                    <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-emerald-100">
                        <Boxes className="w-4 h-4 text-emerald-200" />
                        <span>Manajemen Material & Logistik Gudang</span>
                    </div>

                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight">
                        Inventaris Gudang {unitName} 🏭
                    </h1>

                    <p className="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
                        Pantau timbunan fisik sampah per kategori, catat penjualan partai besar ke pabrik daur ulang, dan kelola karya daur ulang kreatif.
                    </p>

                    {/* Quick Action Buttons */}
                    <div className="pt-2 flex flex-wrap items-center gap-3">
                        <button
                            type="button"
                            onClick={onOpenSaleModal}
                            className="px-4 py-2.5 bg-white text-emerald-900 hover:bg-emerald-50 rounded-xl font-black text-xs transition-all shadow-md flex items-center gap-2 cursor-pointer hover:scale-105 active:scale-95"
                        >
                            <Truck className="w-4 h-4 text-blue-600" />
                            <span>+ Catat Jual ke Pengepul</span>
                        </button>

                        <button
                            type="button"
                            onClick={onOpenUpcyclingModal}
                            className="px-4 py-2.5 bg-emerald-950/50 hover:bg-emerald-950/70 text-white border border-white/20 rounded-xl font-bold text-xs transition-all shadow-sm flex items-center gap-2 cursor-pointer hover:scale-105 active:scale-95"
                        >
                            <Sparkles className="w-4 h-4 text-amber-300" />
                            <span>+ Catat Olah Karya / Kompos</span>
                        </button>
                    </div>
                </div>

                {/* Right Side: Quick Stats Glass Box */}
                <div className="p-5 rounded-2xl bg-black/20 backdrop-blur-md border border-white/15 grid grid-cols-2 gap-4 shrink-0 shadow-lg min-w-[280px]">
                    <div className="space-y-1">
                        <span className="text-[10px] uppercase font-bold tracking-wider text-emerald-200 flex items-center gap-1">
                            <Scale className="w-3.5 h-3.5 text-emerald-300" />
                            <span>Stok Gudang</span>
                        </span>
                        <p className="text-xl sm:text-2xl font-black text-white tracking-tight">
                            {totalStockKg} Kg
                        </p>
                        <span className="text-[10px] text-emerald-300 font-medium block">
                            Siap jual ke offtaker
                        </span>
                    </div>

                    <div className="space-y-1">
                        <span className="text-[10px] uppercase font-bold tracking-wider text-emerald-200 flex items-center gap-1">
                            <DollarSign className="w-3.5 h-3.5 text-emerald-300" />
                            <span>Estimasi Valuasi</span>
                        </span>
                        <p className="text-xl sm:text-2xl font-black text-white tracking-tight">
                            Rp {estimatedValuation}
                        </p>
                        <span className="text-[10px] text-emerald-300 font-medium block">
                            Nilai jual pabrik
                        </span>
                    </div>

                    {/* Capacity Indicator Full Width */}
                    <div className="col-span-2 pt-2 border-t border-white/10 space-y-1.5">
                        <div className="flex items-center justify-between text-[11px] font-bold text-emerald-100">
                            <span>Kapasitas Gudang Terpakai:</span>
                            <span className="font-black text-white">{capacityPct}% (Aman)</span>
                        </div>
                        <div className="w-full h-2 rounded-full bg-white/20 overflow-hidden">
                            <div
                                className="h-full bg-gradient-to-r from-emerald-300 to-teal-300 rounded-full"
                                style={{ width: `${capacityPct}%` }}
                            />
                        </div>
                    </div>
                </div>

            </div>

        </div>
    );
}
