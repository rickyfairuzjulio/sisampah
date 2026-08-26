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
                <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-extrabold border border-emerald-200">
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
                    <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-extrabold border border-emerald-200">
                        <CheckCircle2 className="w-3 h-3" />
                        <span>Selesai Dicairkan</span>
                    </span>
                );
            case 'ditolak':
            case 'rejected':
            case 'cancelled':
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-red-50 text-red-700 text-[10px] font-extrabold border border-red-200">
                        <XCircle className="w-3 h-3" />
                        <span>Ditolak</span>
                    </span>
                );
            default:
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-extrabold border border-amber-200">
                        <Clock className="w-3 h-3" />
                        <span>Menunggu Proses</span>
                    </span>
                );
        }
    };

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6 select-none">
            
            {/* Header & Tabs */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                <div>
                    <h3 className="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">
                        Riwayat Mutasi Tabungan Sampah
                    </h3>
                    <p className="text-xs text-slate-500 mt-0.5">
                        Log arus kas masuk dari hasil penjualan sampah dan riwayat pencairan dana.
                    </p>
                </div>

                {/* Tabs */}
                <div className="flex items-center gap-1.5 p-1 rounded-2xl bg-slate-100 border border-slate-200 self-start sm:self-auto overflow-x-auto max-w-full">
                    <button
                        type="button"
                        onClick={() => setActiveTab('all')}
                        className={`px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                            activeTab === 'all'
                                ? 'bg-white text-slate-900 shadow-2xs'
                                : 'text-slate-600 hover:text-slate-900'
                        }`}
                    >
                        Semua Mutasi ({combinedAll.length})
                    </button>
                    <button
                        type="button"
                        onClick={() => setActiveTab('deposit')}
                        className={`px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                            activeTab === 'deposit'
                                ? 'bg-white text-slate-900 shadow-2xs'
                                : 'text-slate-600 hover:text-slate-900'
                        }`}
                    >
                        📥 Pemasukan Setoran ({depositTransactions.length})
                    </button>
                    <button
                        type="button"
                        onClick={() => setActiveTab('withdrawal')}
                        className={`px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap ${
                            activeTab === 'withdrawal'
                                ? 'bg-white text-slate-900 shadow-2xs'
                                : 'text-slate-600 hover:text-slate-900'
                        }`}
                    >
                        📤 Penarikan Dana ({withdrawals.length})
                    </button>
                </div>
            </div>

            {/* List Feed */}
            <div className="divide-y divide-slate-100">
                {activeTab === 'all' && (
                    combinedAll.length === 0 ? (
                        <div className="py-12 text-center text-slate-400 text-xs">
                            Belum ada riwayat mutasi tabungan di akun Anda.
                        </div>
                    ) : (
                        combinedAll.map((item, idx) => (
                            <div key={idx} className="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 group">
                                <div className="flex items-center gap-3.5 min-w-0 flex-1">
                                    <div className={`w-10 h-10 rounded-2xl flex items-center justify-center font-bold shrink-0 shadow-2xs ${
                                        item.type === 'deposit'
                                            ? 'bg-emerald-50 text-emerald-600 border border-emerald-200'
                                            : 'bg-red-50 text-red-600 border border-red-200'
                                    }`}>
                                        {item.type === 'deposit' ? <ArrowDownLeft className="w-5 h-5" /> : <ArrowUpRight className="w-5 h-5" />}
                                    </div>
                                    <div className="min-w-0 flex-1">
                                        <h4 className="font-extrabold text-xs sm:text-sm text-slate-900 truncate">
                                            {item.type === 'deposit'
                                                ? `Setoran Sampah: ${item.kategori} (${item.berat_kg} Kg)`
                                                : `Tarik Dana (${item.metode.toUpperCase()}) - ${item.nama_penerima || item.rekening_tujuan || 'Teller Basecamp'}`}
                                        </h4>
                                        <p className="text-[11px] text-slate-400 mt-0.5">
                                            {item.created_at_formatted || 'Tanggal mutasi'}
                                        </p>
                                    </div>
                                </div>

                                <div className="flex items-center justify-between sm:justify-end gap-3 shrink-0">
                                    <span className={`text-xs sm:text-sm font-black ${
                                        item.type === 'withdrawal' ? 'text-red-600' : 'text-emerald-700'
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
                        <div className="py-12 text-center text-slate-400 text-xs">
                            Belum ada riwayat setoran sampah. Jadwalkan penjemputan sekarang!
                        </div>
                    ) : (
                        depositTransactions.map((item) => (
                            <div key={item.id} className="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div className="flex items-center gap-3.5 min-w-0 flex-1">
                                    <div className="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center font-bold shrink-0">
                                        <ArrowDownLeft className="w-5 h-5" />
                                    </div>
                                    <div>
                                        <h4 className="font-extrabold text-xs sm:text-sm text-slate-900">
                                            Setoran Sampah: {item.kategori} ({item.berat_kg} Kg)
                                        </h4>
                                        <p className="text-[11px] text-slate-400 mt-0.5">
                                            {item.created_at_formatted} • {formatCurrency(item.harga_per_kg)}/Kg
                                        </p>
                                    </div>
                                </div>
                                <div className="flex items-center justify-between sm:justify-end gap-3 shrink-0">
                                    <span className="text-xs sm:text-sm font-black text-emerald-700">
                                        + {formatCurrency(item.total_rp)}
                                    </span>
                                    {renderStatusBadge(item.status, 'deposit')}
                                </div>
                            </div>
                        ))
                    )
                )}

                {activeTab === 'withdrawal' && (
                    withdrawals.length === 0 ? (
                        <div className="py-12 text-center text-slate-400 text-xs">
                            Belum ada riwayat pengajuan penarikan dana.
                        </div>
                    ) : (
                        withdrawals.map((item) => (
                            <div key={item.id} className="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div className="flex items-center gap-3.5 min-w-0 flex-1">
                                    <div className="w-10 h-10 rounded-2xl bg-red-50 text-red-600 border border-red-200 flex items-center justify-center font-bold shrink-0">
                                        <ArrowUpRight className="w-5 h-5" />
                                    </div>
                                    <div>
                                        <h4 className="font-extrabold text-xs sm:text-sm text-slate-900">
                                            Penarikan ke {item.metode.toUpperCase()} ({item.rekening_tujuan || 'Teller Bank Sampah'})
                                        </h4>
                                        <p className="text-[11px] text-slate-400 mt-0.5">
                                            {item.created_at_formatted} • Penerima: {item.nama_penerima || '-'}
                                        </p>
                                    </div>
                                </div>

                                <div className="flex items-center justify-between sm:justify-end gap-3 shrink-0 flex-wrap">
                                    <span className="text-xs sm:text-sm font-black text-red-600">
                                        - {formatCurrency(item.nominal)}
                                    </span>
                                    {renderStatusBadge(item.status, 'withdrawal')}

                                    {/* Confirmation Button if status is disetujui and status_penerimaan pending */}
                                    {item.status === 'disetujui' && item.status_penerimaan === 'pending' && (
                                        <button
                                            type="button"
                                            onClick={() => setConfirmModalId(item.id)}
                                            className="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-[11px] shadow-2xs transition-colors cursor-pointer"
                                        >
                                            Konfirmasi Terima Dana
                                        </button>
                                    )}
                                </div>
                            </div>
                        ))
                    )
                )}
            </div>

            {/* Confirmation Modal Popup */}
            {confirmModalId && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div className="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onClick={() => setConfirmModalId(null)} />
                    <div className="relative bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 max-w-md w-full shadow-2xl z-10 animate-slide-in space-y-5">
                        <div className="flex items-center gap-3.5">
                            <div className="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold shrink-0">
                                <HelpCircle className="w-5 h-5" />
                            </div>
                            <div>
                                <h3 className="font-extrabold text-base text-slate-900">
                                    Konfirmasi Penerimaan Dana
                                </h3>
                                <p className="text-xs text-slate-500 mt-0.5">
                                    Apakah dana pencairan telah Anda terima?
                                </p>
                            </div>
                        </div>

                        <form method="POST" action={`/nasabah/withdrawal/${confirmModalId}/confirm`} className="space-y-4">
                            <input type="hidden" name="_token" value={csrfToken} />
                            
                            <div className="grid grid-cols-2 gap-3">
                                <label
                                    onClick={() => setConfirmAction('diterima')}
                                    className={`p-3 rounded-2xl border text-center cursor-pointer transition-all flex flex-col items-center gap-1 shadow-2xs ${
                                        confirmAction === 'diterima' ? 'bg-emerald-50 border-emerald-500 text-emerald-950 font-bold' : 'bg-slate-50 border-slate-200 text-slate-600'
                                    }`}
                                >
                                    <input type="radio" name="action" value="diterima" checked={confirmAction === 'diterima'} onChange={() => setConfirmAction('diterima')} className="hidden" />
                                    <CheckCircle2 className="w-5 h-5 text-emerald-600" />
                                    <span className="text-xs">Sudah Diterima</span>
                                </label>

                                <label
                                    onClick={() => setConfirmAction('disanggah')}
                                    className={`p-3 rounded-2xl border text-center cursor-pointer transition-all flex flex-col items-center gap-1 shadow-2xs ${
                                        confirmAction === 'disanggah' ? 'bg-red-50 border-red-500 text-red-950 font-bold' : 'bg-slate-50 border-slate-200 text-slate-600'
                                    }`}
                                >
                                    <input type="radio" name="action" value="disanggah" checked={confirmAction === 'disanggah'} onChange={() => setConfirmAction('disanggah')} className="hidden" />
                                    <AlertCircle className="w-5 h-5 text-red-600" />
                                    <span className="text-xs">Belum Masuk / Sanggah</span>
                                </label>
                            </div>

                            {confirmAction === 'disanggah' && (
                                <div>
                                    <label htmlFor="catatan" className="block text-xs font-bold text-slate-700 mb-1">
                                        Alasan Sanggahan
                                    </label>
                                    <textarea
                                        id="catatan"
                                        name="catatan"
                                        rows={2}
                                        value={disputeNote}
                                        onChange={(e) => setDisputeNote(e.target.value)}
                                        placeholder="Tuliskan alasan sanggahan (misal: mutasi bank belum bertambah)"
                                        className="w-full p-2.5 bg-white text-xs font-medium border border-slate-200 rounded-xl focus:border-red-500 outline-none"
                                    />
                                </div>
                            )}

                            <div className="flex items-center gap-3 pt-2">
                                <button type="button" onClick={() => setConfirmModalId(null)} className="flex-1 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-bold text-xs">
                                    Batal
                                </button>
                                <button type="submit" className="flex-1 py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-xs shadow-sm">
                                    Kirim Konfirmasi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

        </div>
    );
}
