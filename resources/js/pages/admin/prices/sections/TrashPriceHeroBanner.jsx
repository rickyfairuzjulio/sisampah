import React from 'react';
import { Tag, Plus, History, Sparkles, TrendingUp, DollarSign } from 'lucide-react';

export default function TrashPriceHeroBanner({
    authData = {},
    statistics = {},
    onOpenCreateModal,
}) {
    const unitName = authData?.bank_sampah_name || 'Unit Melati Asri';
    const highestPrice = statistics?.highest_price_formatted || 'Rp 15.000 / kg';
    const totalCategories = statistics?.total_categories || 18;

    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-md p-6 sm:p-8 animate-slide-in select-none">
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

            <div className="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                
                {/* Left Side: Title & Subtitle */}
                <div className="space-y-3 max-w-2xl">
                    <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-emerald-100">
                        <Tag className="w-4 h-4 text-emerald-200" />
                        <span>Katalog Acuan & Standar Nilai Tukar Unit</span>
                    </div>

                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight">
                        Katalog & Acuan Harga Sampah {unitName} 🏷️
                    </h1>

                    <p className="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
                        Kelola standar harga beli sampah dari warga nasabah, pantau tren fluktuasi pasar daur ulang, dan atur katalog jenis material yang diterima pos unit.
                    </p>

                    {/* Quick Action Buttons */}
                    <div className="pt-2 flex flex-wrap items-center gap-3">
                        <button
                            type="button"
                            onClick={onOpenCreateModal}
                            className="px-4 py-2.5 bg-white text-emerald-900 hover:bg-emerald-50 rounded-xl font-black text-xs transition-all shadow-md flex items-center gap-2 cursor-pointer hover:scale-105 active:scale-95"
                        >
                            <Plus className="w-4 h-4 text-emerald-600" />
                            <span>+ Tambah Kategori Sampah</span>
                        </button>

                        <a
                            href="/admin/trash-price/history"
                            className="px-4 py-2.5 bg-emerald-950/50 hover:bg-emerald-950/70 text-white border border-white/20 rounded-xl font-bold text-xs transition-all shadow-sm flex items-center gap-2"
                        >
                            <History className="w-4 h-4 text-amber-300" />
                            <span>📜 Riwayat Fluktuasi Harga</span>
                        </a>
                    </div>
                </div>

                {/* Right Side: Quick Highlight Card */}
                <div className="p-5 rounded-2xl bg-black/20 backdrop-blur-md border border-white/15 flex flex-col justify-between gap-3 shrink-0 shadow-lg min-w-[280px]">
                    <div className="space-y-1">
                        <span className="text-[10px] uppercase font-bold tracking-wider text-emerald-200 flex items-center gap-1">
                            <DollarSign className="w-3.5 h-3.5 text-emerald-300" />
                            <span>Harga Komoditas Tertinggi</span>
                        </span>
                        <p className="text-2xl sm:text-3xl font-black text-white tracking-tight">
                            {highestPrice}
                        </p>
                        <span className="text-[11px] text-emerald-300 font-medium block">
                            Tembaga & Logam Kuningan Super
                        </span>
                    </div>

                    <div className="pt-2 border-t border-white/10 flex items-center justify-between text-xs text-emerald-100">
                        <span>Total Jenis Terdaftar:</span>
                        <span className="font-black text-white">{totalCategories} Kategori Material</span>
                    </div>
                </div>

            </div>

        </div>
    );
}
