import React from 'react';
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
        <div className="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-sm space-y-4">
            
            {/* Header */}
            <div className="flex items-center justify-between border-b border-slate-100 pb-4">
                <div className="space-y-0.5">
                    <h3 className="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
                        <ArrowLeftRight className="w-4 h-4 text-emerald-600" />
                        <span>Riwayat Setoran Sampah</span>
                    </h3>
                    <p className="text-xs text-slate-500">Mutasi saldo dari hasil penimbangan sampah</p>
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
                                className="flex items-center justify-between p-3.5 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 transition-all flex-wrap gap-2"
                            >
                                <div className="flex items-center gap-3">
                                    <div className="w-9 h-9 rounded-xl bg-emerald-100/70 text-emerald-700 flex items-center justify-center shrink-0">
                                        <Scale className="w-4 h-4" />
                                    </div>
                                    <div>
                                        <p className="font-bold text-xs sm:text-sm text-slate-800">
                                            {categoryName}
                                        </p>
                                        <p className="text-[11px] text-slate-400">
                                            {trx.berat_kg} Kg • {dateStr}
                                        </p>
                                    </div>
                                </div>

                                <div className="text-right flex flex-col items-end gap-1">
                                    <span className="font-black text-xs sm:text-sm text-emerald-600">
                                        +{formatCurrency(trx.total_rp)}
                                    </span>
                                    <div className="flex items-center gap-2">
                                        {isSelesai && (
                                            <>
                                                {trx.rating ? (
                                                    <span className="text-[11px] text-amber-600 font-bold flex items-center gap-0.5 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                                                        <span>{trx.rating}</span>
                                                        <Star className="w-3 h-3 fill-amber-400 text-amber-400" />
                                                    </span>
                                                ) : (
                                                    <button
                                                        onClick={() => onOpenRatingModal(trx.id)}
                                                        className="text-[10px] text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 px-2 py-0.5 rounded font-bold transition-colors cursor-pointer"
                                                    >
                                                        Beri Ulasan
                                                    </button>
                                                )}
                                            </>
                                        )}

                                        <span
                                            className={`px-2 py-0.5 rounded text-[10px] font-bold ${
                                                isSelesai
                                                    ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                                                    : 'bg-amber-50 text-amber-700 border border-amber-200'
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
                    <div className="py-8 text-center text-slate-400 text-xs">
                        Belum ada transaksi penimbangan. Jadwalkan penjemputan sekarang!
                    </div>
                )}
            </div>

            {/* Footer link to wallet */}
            <div className="pt-2 border-t border-slate-100">
                <a
                    href="/nasabah/dompet"
                    className="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 transition-colors"
                >
                    <span>Lihat Semua Riwayat & Mutasi Kas Lengkap</span>
                    <ArrowRight className="w-3.5 h-3.5" />
                </a>
            </div>

        </div>
    );
}
