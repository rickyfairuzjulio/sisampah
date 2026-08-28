import React from 'react';
import { Link } from '@inertiajs/react';
import { Tag, ArrowRight } from 'lucide-react';

export default function LivePricesMiniTable({ prices = [] }) {
    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(amount);
    };

    const displayPrices = prices.slice(0, 5);

    return (
        <div className="bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm space-y-4 transition-colors duration-200">
            
            {/* Header */}
            <div className="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <div className="space-y-0.5">
                    <h3 className="text-base sm:text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <Tag className="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                        <span>Harga Sampah Terkini</span>
                    </h3>
                    <p className="text-xs text-slate-500 dark:text-slate-400">Harga acuan per kilogram di unit domisili hari ini</p>
                </div>
                <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/80 text-[10px] font-bold">
                    <span className="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse" />
                    LIVE
                </span>
            </div>

            {/* Table */}
            <div className="overflow-x-auto">
                <table className="w-full text-left text-xs sm:text-sm">
                    <thead>
                        <tr className="border-b border-slate-100 dark:border-slate-800 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            <th className="py-2.5 px-2">Jenis Komoditas</th>
                            <th className="py-2.5 px-2 text-right">Harga Satuan</th>
                            <th className="py-2.5 px-2 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-100 dark:divide-slate-800">
                        {displayPrices.length > 0 ? (
                            displayPrices.map((item) => (
                                <tr key={item.id} className="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors">
                                    <td className="py-3 px-2 font-bold text-slate-800 dark:text-slate-200">
                                        {item.nama}
                                    </td>
                                    <td className="py-3 px-2 text-right font-black text-emerald-600 dark:text-emerald-400">
                                        {formatCurrency(item.harga_per_kg)}
                                        <span className="text-[10px] font-normal text-slate-400 dark:text-slate-500 ml-1">/{item.satuan || 'kg'}</span>
                                    </td>
                                    <td className="py-3 px-2 text-center">
                                        <span className="px-2 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 text-[10px] font-bold border border-emerald-100 dark:border-emerald-800/60">
                                            Aktif
                                        </span>
                                    </td>
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td colSpan="3" className="py-6 text-center text-slate-400 dark:text-slate-500 text-xs">
                                    Belum ada data harga komoditas
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>

            {/* Footer link to catalog */}
            <div className="pt-2 border-t border-slate-100 dark:border-slate-800">
                <Link
                    href="/nasabah/prices"
                    className="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors"
                >
                    <span>Lihat Semua Katalog Harga Lengkap</span>
                    <ArrowRight className="w-3.5 h-3.5" />
                </Link>
            </div>

        </div>
    );
}
