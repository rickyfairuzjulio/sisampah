import React from 'react';
import { Filter, Calendar, MapPin, RefreshCw } from 'lucide-react';

export default function ReportsFilterToolbar({
    startDate,
    setStartDate,
    endDate,
    setEndDate,
    selectedRt,
    setSelectedRt,
    selectedRw,
    setSelectedRw,
    rtList = [],
    rwList = [],
    onApplyFilter,
    onResetFilter,
}) {
    const handleQuickPeriod = (days) => {
        const end = new Date();
        const start = new Date();
        start.setDate(end.getDate() - days);

        setStartDate(start.toISOString().split('T')[0]);
        setEndDate(end.toISOString().split('T')[0]);
    };

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-5 sm:p-6 shadow-2xs space-y-4 select-none">
            
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div className="flex items-center gap-2">
                    <Filter className="w-4 h-4 text-emerald-600" />
                    <h4 className="font-extrabold text-sm text-slate-900">
                        Filter Periode & Wilayah Laporan
                    </h4>
                </div>

                {/* Quick Period Buttons */}
                <div className="flex flex-wrap items-center gap-1.5 bg-slate-100 p-1 rounded-2xl border border-slate-200/80">
                    <button
                        type="button"
                        onClick={() => handleQuickPeriod(7)}
                        className="px-2.5 py-1 rounded-xl text-[11px] font-bold text-slate-600 hover:text-slate-900 hover:bg-white transition-all cursor-pointer"
                    >
                        7 Hari Terakhir
                    </button>
                    <button
                        type="button"
                        onClick={() => handleQuickPeriod(30)}
                        className="px-2.5 py-1 rounded-xl text-[11px] font-bold text-slate-600 hover:text-slate-900 hover:bg-white transition-all cursor-pointer"
                    >
                        30 Hari
                    </button>
                    <button
                        type="button"
                        onClick={() => handleQuickPeriod(90)}
                        className="px-2.5 py-1 rounded-xl text-[11px] font-bold text-slate-600 hover:text-slate-900 hover:bg-white transition-all cursor-pointer"
                    >
                        Triwulan
                    </button>
                    <button
                        type="button"
                        onClick={() => handleQuickPeriod(365)}
                        className="px-2.5 py-1 rounded-xl text-[11px] font-bold text-slate-600 hover:text-slate-900 hover:bg-white transition-all cursor-pointer"
                    >
                        1 Tahun
                    </button>
                </div>
            </div>

            {/* Input Controls Grid */}
            <form onSubmit={onApplyFilter} className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
                
                {/* Tanggal Mulai */}
                <div className="space-y-1">
                    <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1">
                        <Calendar className="w-3 h-3 text-slate-400" />
                        <span>Dari Tanggal</span>
                    </label>
                    <input
                        type="date"
                        value={startDate}
                        onChange={(e) => setStartDate(e.target.value)}
                        className="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 focus:outline-emerald-600"
                    />
                </div>

                {/* Tanggal Akhir */}
                <div className="space-y-1">
                    <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1">
                        <Calendar className="w-3 h-3 text-slate-400" />
                        <span>Sampai Tanggal</span>
                    </label>
                    <input
                        type="date"
                        value={endDate}
                        onChange={(e) => setEndDate(e.target.value)}
                        className="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 focus:outline-emerald-600"
                    />
                </div>

                {/* Filter RT */}
                <div className="space-y-1">
                    <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1">
                        <MapPin className="w-3 h-3 text-slate-400" />
                        <span>Wilayah RT</span>
                    </label>
                    <select
                        value={selectedRt}
                        onChange={(e) => setSelectedRt(e.target.value)}
                        className="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-800 focus:outline-emerald-600 cursor-pointer"
                    >
                        <option value="">Semua RT (RT 01-06)</option>
                        {rtList.map((rt, idx) => (
                            <option key={idx} value={rt}>RT {rt}</option>
                        ))}
                    </select>
                </div>

                {/* Filter RW */}
                <div className="space-y-1">
                    <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1">
                        <MapPin className="w-3 h-3 text-slate-400" />
                        <span>Wilayah RW</span>
                    </label>
                    <select
                        value={selectedRw}
                        onChange={(e) => setSelectedRw(e.target.value)}
                        className="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-800 focus:outline-emerald-600 cursor-pointer"
                    >
                        <option value="">Semua RW (RW 02)</option>
                        {rwList.map((rw, idx) => (
                            <option key={idx} value={rw}>RW {rw}</option>
                        ))}
                    </select>
                </div>

                {/* Actions */}
                <div className="flex items-center gap-2">
                    <button
                        type="submit"
                        className="flex-1 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1.5"
                    >
                        <Filter className="w-3.5 h-3.5" />
                        <span>Terapkan</span>
                    </button>

                    <button
                        type="button"
                        onClick={onResetFilter}
                        className="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors cursor-pointer"
                        title="Reset Filter"
                    >
                        <RefreshCw className="w-4 h-4" />
                    </button>
                </div>

            </form>

        </div>
    );
}
