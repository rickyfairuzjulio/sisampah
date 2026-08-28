import React, { useState } from 'react';
import { ArrowDownLeft, ArrowUpRight, Sparkles, FileText, CheckCircle2, Clock, Filter, Inbox } from 'lucide-react';

export default function MaterialLedgerTable({
    ledgerData = [],
}) {
    const [activeTab, setActiveTab] = useState('all');

    const filteredData = ledgerData.filter((item) => {
        if (activeTab === 'all') return true;
        return item.type === activeTab;
    });

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-5 select-none">
            
            {/* Header & Filter Tabs */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div>
                    <h3 className="font-black text-lg text-slate-900 tracking-tight">
                        Buku Besar Sirkulasi Material & Log Gudang 📜
                    </h3>
                    <p className="text-xs text-slate-500">
                        Audit trail pergerakan keluar-masuk sampah (Inbound Warga, Penjualan Pengepul, dan Alokasi Karya)
                    </p>
                </div>

                {/* Filter Pills */}
                <div className="flex flex-wrap items-center gap-1.5 bg-slate-100 p-1 rounded-2xl border border-slate-200/80">
                    <button
                        type="button"
                        onClick={() => setActiveTab('all')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer ${
                            activeTab === 'all' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        Semua ({ledgerData.length})
                    </button>

                    <button
                        type="button"
                        onClick={() => setActiveTab('inbound')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer ${
                            activeTab === 'inbound' ? 'bg-emerald-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        📥 Inbound Warga
                    </button>

                    <button
                        type="button"
                        onClick={() => setActiveTab('sale')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer ${
                            activeTab === 'sale' ? 'bg-blue-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        🚛 Jual Pengepul
                    </button>

                    <button
                        type="button"
                        onClick={() => setActiveTab('upcycling')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer ${
                            activeTab === 'upcycling' ? 'bg-purple-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        🎨 Olah Karya
                    </button>
                </div>
            </div>

            {/* Table */}
            {filteredData.length === 0 ? (
                <div className="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200 text-xs text-slate-500 space-y-2">
                    <Inbox className="w-8 h-8 mx-auto text-slate-400" />
                    <p className="font-bold text-slate-700">Belum ada mutasi material yang tercatat.</p>
                </div>
            ) : (
                <div className="overflow-x-auto">
                    <table className="w-full text-left text-xs">
                        <thead>
                            <tr className="border-b border-slate-200 text-slate-400 font-extrabold uppercase tracking-wider">
                                <th className="pb-3 px-3">Tanggal & Waktu</th>
                                <th className="pb-3 px-3">Tipe Mutasi</th>
                                <th className="pb-3 px-3">Kategori Material</th>
                                <th className="pb-3 px-3">Berat (Kg)</th>
                                <th className="pb-3 px-3">Nilai / Output</th>
                                <th className="pb-3 px-3">Pihak Terkait</th>
                                <th className="pb-3 px-3 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-slate-100">
                            {filteredData.map((row) => (
                                <tr key={row.id} className="hover:bg-slate-50/80 transition-colors">
                                    <td className="py-3.5 px-3 font-semibold text-slate-500 whitespace-nowrap">
                                        {row.date}
                                    </td>
                                    <td className="py-3.5 px-3">
                                        <div className="flex items-center gap-1.5">
                                            {row.type === 'sale' && (
                                                <span className="p-1 rounded-lg bg-blue-50 text-blue-600">
                                                    <ArrowUpRight className="w-3.5 h-3.5" />
                                                </span>
                                            )}
                                            {row.type === 'inbound' && (
                                                <span className="p-1 rounded-lg bg-emerald-50 text-emerald-600">
                                                    <ArrowDownLeft className="w-3.5 h-3.5" />
                                                </span>
                                            )}
                                            {row.type === 'upcycling' && (
                                                <span className="p-1 rounded-lg bg-purple-50 text-purple-600">
                                                    <Sparkles className="w-3.5 h-3.5" />
                                                </span>
                                            )}
                                            <span className="font-bold text-slate-800">{row.typeLabel}</span>
                                        </div>
                                    </td>
                                    <td className="py-3.5 px-3 font-bold text-slate-900">
                                        {row.category}
                                    </td>
                                    <td className="py-3.5 px-3 font-black text-slate-900">
                                        {Number(row.weightKg).toLocaleString('id-ID')} Kg
                                    </td>
                                    <td className="py-3.5 px-3">
                                        <span className={`font-black ${
                                            row.type === 'sale' ? 'text-blue-700' : row.type === 'inbound' ? 'text-emerald-700' : 'text-purple-700'
                                        }`}>
                                            {row.amountFormatted}
                                        </span>
                                    </td>
                                    <td className="py-3.5 px-3 font-medium text-slate-600">
                                        {row.party}
                                    </td>
                                    <td className="py-3.5 px-3 text-right">
                                        <span className={`px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border ${row.statusColor || 'bg-slate-100 text-slate-800 border-slate-200'}`}>
                                            {row.status}
                                        </span>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            )}

        </div>
    );
}
