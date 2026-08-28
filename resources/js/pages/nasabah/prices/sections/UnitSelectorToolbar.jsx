import React from 'react';
import { Building2, MapPin, Compass, ChevronDown, Check } from 'lucide-react';

export default function UnitSelectorToolbar({
    selectedBankSampah = {},
    nearbyBankSampahs = [],
    radiusKm = 5,
    selectedBsId = 1,
    activeCategory = 'all',
}) {
    const handleRadiusChange = (e) => {
        const newRadius = e.target.value;
        const params = new URLSearchParams(window.location.search);
        params.set('radius', newRadius);
        window.location.search = params.toString();
    };

    const handleBankSampahChange = (e) => {
        const newBsId = e.target.value;
        const params = new URLSearchParams(window.location.search);
        params.set('bank_sampah_id', newBsId);
        window.location.search = params.toString();
    };

    return (
        <div className="bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 p-4 sm:p-5 rounded-2xl shadow-sm flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 select-none transition-colors duration-200">
            
            {/* 1. Left: Selected Unit Info */}
            <div className="flex items-center gap-3.5 min-w-0 flex-1">
                <div className="w-11 h-11 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/80 flex items-center justify-center font-bold text-lg shrink-0 shadow-xs">
                    <Building2 className="w-5 h-5" />
                </div>
                <div className="min-w-0 flex-1">
                    <div className="flex items-center gap-2 flex-wrap">
                        <h2 className="font-extrabold text-slate-900 dark:text-white text-sm sm:text-base tracking-tight truncate">
                            {selectedBankSampah?.nama || 'Unit Bank Sampah'}
                        </h2>
                        {selectedBankSampah?.is_my_unit && (
                            <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/80 shadow-2xs">
                                <Check className="w-3 h-3" />
                                <span>Unit Domisili Anda</span>
                            </span>
                        )}
                    </div>
                    <p className="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1 mt-0.5 truncate">
                        <MapPin className="w-3.5 h-3.5 text-slate-400 dark:text-slate-500 shrink-0" />
                        <span className="truncate">
                            {selectedBankSampah?.alamat || 'Alamat Unit'} (Kec. {selectedBankSampah?.kecamatan || '-'})
                        </span>
                    </p>
                </div>
            </div>

            {/* 2. Right: Controls Toolbar */}
            <div className="flex items-center gap-3 w-full lg:w-auto shrink-0 justify-end flex-wrap sm:flex-nowrap">
                
                {/* Dynamic Radius Selector */}
                <div className="relative flex items-center bg-slate-50 dark:bg-[#0D131F] hover:bg-slate-100/80 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs transition-colors shadow-2xs">
                    <Compass className="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0 mr-1.5" />
                    <span className="font-bold text-slate-500 dark:text-slate-400 mr-1">Radius:</span>
                    <select
                        value={radiusKm}
                        onChange={handleRadiusChange}
                        className="bg-transparent font-extrabold text-slate-900 dark:text-white focus:outline-none cursor-pointer pr-4 appearance-none outline-none border-none py-0"
                    >
                        <option value="3">3 KM</option>
                        <option value="5">5 KM (Default)</option>
                        <option value="10">10 KM</option>
                        <option value="999">Semua Unit</option>
                    </select>
                    <ChevronDown className="w-3.5 h-3.5 text-slate-400 pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2" />
                </div>

                {/* Switch Bank Sampah Unit */}
                <div className="relative flex-1 sm:flex-initial min-w-[200px] sm:min-w-[240px]">
                    <select
                        value={selectedBsId}
                        onChange={handleBankSampahChange}
                        className="w-full pl-3.5 pr-8 py-2 bg-slate-50 dark:bg-[#0D131F] hover:bg-slate-100/80 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none cursor-pointer transition-all appearance-none shadow-2xs truncate"
                    >
                        {nearbyBankSampahs.map((bs) => (
                            <option key={bs.id} value={bs.id}>
                                {bs.nama} {bs.is_my_unit ? '★ (Domisili)' : ''}
                            </option>
                        ))}
                    </select>
                    <ChevronDown className="w-3.5 h-3.5 text-slate-400 pointer-events-none absolute right-3 top-1/2 -translate-y-1/2" />
                </div>

            </div>

        </div>
    );
}
