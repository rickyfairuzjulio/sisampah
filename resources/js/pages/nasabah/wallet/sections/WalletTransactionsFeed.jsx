import React, { useState } from 'react';
import { ArrowDownLeft, ArrowUpRight, CheckCircle2, Clock, XCircle, AlertCircle, HelpCircle } from 'lucide-react';

export default function WalletTransactionsFeed({
    depositTransactions = [],
    withdrawals = [],
    csrfToken = '',
}) {
    const [activeTab, setActiveTab] = useState('all');
    const [confirmModalId, setConfirmModalId] = useState(null);
    const [disputeNote, setDisputeNote] = useState('');
    const [confirmAction, setConfirmAction] = useState('diterima');

    const formatCurrency = (val) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(val || 0);
    };

    // Combine deposits and withdrawals for 'all' tab
    const combinedAll = [
        ...depositTransactions.map((t) => ({ ...t, type: 'deposit' })),
        ...withdrawals.map((w) => ({ ...w, type: 'withdrawal' })),
    ].sort((a, b) => new Date(b.created_at || 0) - new Date(a.created_at || 0));

    const renderStatusBadge = (status, type) => {
        if (type === 'deposit') {
            return (
                <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold border border-emerald-200 dark:border-emerald-800/80">
                    <CheckCircle2 className="w-3 h-3" />
                    <span>Setoran Sukses</span>
                </span>
            );
        }

        switch (status) {
            case 'disetujui':
            case 'completed':
            case 'success':
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold border border-emerald-200 dark:border-emerald-800/80">
                        <CheckCircle2 className="w-3 h-3" />
                        <span>Selesai Dicairkan</span>
                    </span>
                );
            case 'ditolak':
            case 'rejected':
            case 'cancelled':
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 text-[10px] font-extrabold border border-rose-200 dark:border-rose-800/80">
                        <XCircle className="w-3 h-3" />
                        <span>Ditolak</span>
                    </span>
                );
            default:
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 text-[10px] font-extrabold border border-amber-200 dark:border-amber-800/80">
                        <Clock className="w-3 h-3" />
                        <span>Menunggu Proses</span>
                    </span>
                );
        }
    };

    return (
        <div className="bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6 select-none transition-colors duration-200">
            
            {/* Header & Tabs */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 className="font-extrabold text-base sm:text-lg text-slate-900 dark:text-white tracking-tight">
                        Riwayat Mutasi Tabungan Sampah
                    </h3>
                    <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Log arus kas masuk dari hasil penjualan sampah dan riwayat pencairan dana.
                    </p>
                </div>

                {/* Tabs */}
                <div className="flex items-center gap-1.5 p-1 rounded-2xl bg-slate-100 dark:bg-[#0D131F] border border-slate-200 dark:border-slate-800 self-start sm:self-auto overflow-x-auto max-w-full">
                    <button
                        type="button"
                        onClick={() => setActiveTab('all')}
                        className={`px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                            activeTab === 'all'
                                ? 'bg-white dark:bg-[#111827] text-slate-900 dark:text-white shadow-2xs'
                                : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'
                        }`}
                    >
                        Semua Mutasi ({combinedAll.length})
                    </button>
                    <button
                        type="button"
                        onClick={() => setActiveTab('deposit')}
                        className={`px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                            activeTab === 'deposit'
                                ? 'bg-white dark:bg-[#111827] text-slate-900 dark:text-white shadow-2xs'
                                : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'
                        }`}
                    >
                        📥 Pemasukan Setoran ({depositTransactions.length})
                    </button>
                    <button
                        type="button"
                        onClick={() => setActiveTab('withdrawal')}
                        className={`px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                            activeTab === 'withdrawal'
                                ? 'bg-white dark:bg-[#111827] text-slate-900 dark:text-white shadow-2xs'
                                : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'
                        }`}
                    >
                        📤 Penarikan Dana ({withdrawals.length})
                    </button>
                </div>
            </div>

            {/* List Feed */}
            <div className="divide-y divide-slate-100 dark:divide-slate-800">
                {activeTab === 'all' && (
                    combinedAll.length === 0 ? (
                        <div className="py-12 text-center text-slate-400 dark:text-slate-500 text-xs">
                            Belum ada riwayat mutasi tabungan di akun Anda.
                        </div>
                    ) : (
                        combinedAll.map((item, idx) => (
                            <div key={idx} className="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 group">
                                <div className="flex items-center gap-3.5 min-w-0 flex-1">
                                    <div className={`w-10 h-10 rounded-2xl flex items-center justify-center font-bold shrink-0 shadow-2xs ${
                                        item.type === 'deposit'
                                            ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/80'
                                            : 'bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800/80'
                                    }`}>
                                        {item.type === 'deposit' ? <ArrowDownLeft className="w-5 h-5" /> : <ArrowUpRight className="w-5 h-5" />}
                                    </div>
                                    <div className="min-w-0 flex-1">
                                        <h4 className="font-extrabold text-xs sm:text-sm text-slate-900 dark:text-white truncate">
                                            {item.type === 'deposit'
                                                ? `Setoran Sampah: ${item.kategori} (${item.berat_kg} Kg)`
                                                : `Tarik Dana (${(item.metode || 'tunai').toUpperCase()}) - ${item.nama_penerima || item.rekening_tujuan || 'Teller Basecamp'}`}
                                        </h4>
                                        <p className="text-[11px] text-slate-400 dark:text-slate-500 mt-0.5">
                                            {item.created_at_formatted || 'Tanggal mutasi'}
                                        </p>
                                    </div>
                                </div>

                                <div className="flex items-center justify-between sm:justify-end gap-3 shrink-0">
                                    <span className={`text-xs sm:text-sm font-black ${
                                        item.type === 'withdrawal' ? 'text-rose-600 dark:text-rose-400' : 'text-emerald-700 dark:text-emerald-400'
                                    }`}>
                                        {item.type === 'withdrawal' ? '-' : '+'} {formatCurrency(item.total_rp || item.nominal || 0)}
                                    </span>
                                    {renderStatusBadge(item.status, item.type)}
                                </div>
                            </div>
                        ))
                    )
                )}

                {activeTab === 'deposit' && (
                    depositTransactions.length === 0 ? (
                        <div className="py-12 text-center text-slate-400 dark:text-slate-500 text-xs">
                            Belum ada riwayat setoran sampah. Jadwalkan penjemputan sekarang!
                        </div>
                    ) : (
                        depositTransactions.map((item) => (
                            <div key={item.id} className="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div className="flex items-center gap-3.5 min-w-0 flex-1">
                                    <div className="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/80 flex items-center justify-center font-bold shrink-0">
                                        <ArrowDownLeft className="w-5 h-5" />
                                    </div>
                                    <div>
                                        <h4 className="font-extrabold text-xs sm:text-sm text-slate-900 dark:text-white">
                                            Setoran Sampah: {item.kategori} ({item.berat_kg} Kg)
                                        </h4>
                                        <p className="text-[11px] text-slate-400 dark:text-slate-500 mt-0.5">
                                            {item.created_at_formatted} • {formatCurrency(item.harga_per_kg)}/Kg
                                        </p>
                                    </div>
                                </div>

                                <div className="flex items-center justify-between sm:justify-end gap-3 shrink-0">
                                    <span className="text-xs sm:text-sm font-black text-emerald-700 dark:text-emerald-400">
                                        +{formatCurrency(item.total_rp)}
                                    </span>
                                    {renderStatusBadge(item.status, 'deposit')}
                                </div>
                            </div>
                        ))
                    )
                )}

                {activeTab === 'withdrawal' && (
                    withdrawals.length === 0 ? (
                        <div className="py-12 text-center text-slate-400 dark:text-slate-500 text-xs">
                            Belum ada riwayat penarikan dana saldo kas.
                        </div>
                    ) : (
                        withdrawals.map((item) => (
                            <div key={item.id} className="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div className="flex items-center gap-3.5 min-w-0 flex-1">
                                    <div className="w-10 h-10 rounded-2xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800/80 flex items-center justify-center font-bold shrink-0">
                                        <ArrowUpRight className="w-5 h-5" />
                                    </div>
                                    <div>
                                        <h4 className="font-extrabold text-xs sm:text-sm text-slate-900 dark:text-white">
                                            Tarik Dana: {(item.metode || 'tunai').toUpperCase()} ({item.nama_penerima || item.rekening_tujuan || 'Teller Basecamp'})
                                        </h4>
                                        <p className="text-[11px] text-slate-400 dark:text-slate-500 mt-0.5">
                                            {item.created_at_formatted} • Kode Trx: #{item.id}
                                        </p>
                                    </div>
                                </div>

                                <div className="flex items-center justify-between sm:justify-end gap-3 shrink-0">
                                    <span className="text-xs sm:text-sm font-black text-rose-600 dark:text-rose-400">
                                        -{formatCurrency(item.nominal)}
                                    </span>
                                    {renderStatusBadge(item.status, 'withdrawal')}
                                </div>
                            </div>
                        ))
                    )
                )}
            </div>

        </div>
    );
}
