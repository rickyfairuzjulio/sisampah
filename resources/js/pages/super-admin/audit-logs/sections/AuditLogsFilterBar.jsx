import React from 'react';

export default function AuditLogsFilterBar({
    selectedAction = 'all',
    onActionChange,
    selectedPeriod = 'all',
    onPeriodChange,
    searchQuery = '',
    onSearchChange,
}) {
    return (
        <div className="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-sm space-y-4">
            <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
                {/* Filters */}
                <div className="flex flex-wrap items-center gap-3">
                    <select
                        value={selectedAction}
                        onChange={(e) => onActionChange(e.target.value)}
                        className="px-3.5 py-2 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-emerald-400"
                    >
                        <option value="all">Semua Tipe Aksi</option>
                        <option value="BANK_SAMPAH">Otorisasi Bank Sampah</option>
                        <option value="WITHDRAWAL">Pencairan Kas Nasabah</option>
                        <option value="TRASH_PRICE">Perubahan Harga Sampah</option>
                        <option value="SETTINGS">Konfigurasi Sistem</option>
                    </select>

                    <select
                        value={selectedPeriod}
                        onChange={(e) => onPeriodChange(e.target.value)}
                        className="px-3.5 py-2 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-emerald-400"
                    >
                        <option value="all">Semua Waktu</option>
                        <option value="today">Hari Ini</option>
                        <option value="7days">7 Hari Terakhir</option>
                        <option value="30days">30 Hari Terakhir</option>
                    </select>
                </div>

                {/* Live Search */}
                <div className="relative min-w-[260px]">
                    <i className="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs" />
                    <input
                        type="text"
                        value={searchQuery}
                        onChange={(e) => onSearchChange(e.target.value)}
                        placeholder="Cari nama pelaku, IP, entitas..."
                        className="w-full pl-9 pr-3.5 py-2 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-400"
                    />
                </div>
            </div>
        </div>
    );
}
