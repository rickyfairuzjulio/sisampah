import React from 'react';
import { Link } from '@inertiajs/react';
import { ArrowLeftRight, Star, Scale, ArrowRight } from 'lucide-react';

export default function RecentTransactionsList({ 
    recentTransactions = [], 
    onOpenRatingModal 
}) {
    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(amount);
    };

    return (
        <div className="bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm space-y-4 transition-colors duration-200">
            
            {/* Header */}
            <div className="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <div className="space-y-0.5">
                    <h3 className="text-base sm:text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <ArrowLeftRight className="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                        <span>Riwayat Setoran Sampah</span>
                    </h3>
                    <p className="text-xs text-slate-500 dark:text-slate-400">Mutasi saldo dari hasil penimbangan sampah</p>
                </div>
            </div>

            {/* Transactions Feed */}
            <div className="space-y-3">
                {recentTransactions.length > 0 ? (
                    recentTransactions.map((trx) => {
                        const isSelesai = trx.status === 'selesai';
                        const categoryName = trx.trash_category?.nama || trx.kategori?.nama || 'Setoran Sampah';
                        const dateStr = trx.created_at ? new Date(trx.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : 'Baru saja';

                        return (
                            <div
                                key={trx.id}
                                className="flex items-center justify-between p-3.5 rounded-xl bg-slate-50 dark:bg-[#0D131F] border border-slate-100 dark:border-slate-800 hover:border-slate-200 dark:hover:border-slate-700 transition-all flex-wrap gap-2"
                            >
                                <div className="flex items-center gap-3">
                                    <div className="w-9 h-9 rounded-xl bg-emerald-100/70 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center shrink-0 border border-transparent dark:border-emerald-800/40">
                                        <Scale className="w-4 h-4" />
                                    </div>
                                    <div>
                                        <p className="font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-200">
                                            {categoryName}
                                        </p>
                                        <p className="text-[11px] text-slate-400 dark:text-slate-500">
                                            {trx.berat_kg} Kg • {dateStr}
                                        </p>
                                    </div>
                                </div>

                                <div className="text-right flex flex-col items-end gap-1">
                                    <span className="font-black text-xs sm:text-sm text-emerald-600 dark:text-emerald-400">
                                        +{formatCurrency(trx.total_rp)}
                                    </span>
                                    <div className="flex items-center gap-2">
                                        {isSelesai && (
                                            <>
                                                {trx.rating ? (
                                                    <span className="text-[11px] text-amber-600 dark:text-amber-400 font-bold flex items-center gap-0.5 bg-amber-50 dark:bg-amber-950/60 px-2 py-0.5 rounded border border-amber-200 dark:border-amber-800/80">
                                                        <span>{trx.rating}</span>
                                                        <Star className="w-3 h-3 fill-amber-400 text-amber-400" />
                                                    </span>
                                                ) : (
                                                    <button
                                                        onClick={() => onOpenRatingModal(trx.id)}
                                                        className="text-[10px] text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/60 hover:bg-amber-100 dark:hover:bg-amber-900/60 border border-amber-200 dark:border-amber-800 px-2 py-0.5 rounded font-bold transition-colors cursor-pointer"
                                                    >
                                                        Beri Ulasan
                                                    </button>
                                                )}
                                            </>
                                        )}

                                        <span
                                            className={`px-2 py-0.5 rounded text-[10px] font-bold ${
                                                isSelesai
                                                    ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/80'
                                                    : 'bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800/80'
                                            }`}
                                        >
                                            {isSelesai ? 'Selesai' : 'Diproses'}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        );
                    })
                ) : (
                    <div className="py-8 text-center text-slate-400 dark:text-slate-500 text-xs">
                        Belum ada transaksi penimbangan. Jadwalkan penjemputan sekarang!
                    </div>
                )}
            </div>

            {/* Footer link to wallet */}
            <div className="pt-2 border-t border-slate-100 dark:border-slate-800">
                <Link
                    href="/nasabah/dompet"
                    className="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors"
                >
                    <span>Lihat Semua Riwayat & Mutasi Kas Lengkap</span>
                    <ArrowRight className="w-3.5 h-3.5" />
                </Link>
            </div>

        </div>
    );
}
