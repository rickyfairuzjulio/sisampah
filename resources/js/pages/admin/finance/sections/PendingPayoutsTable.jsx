import React, { useState } from 'react';
import { Clock, Check, X, Zap, CreditCard, ArrowUpRight, CheckCircle2, AlertCircle, User } from 'lucide-react';

export default function PendingPayoutsTable({
    pendingWithdrawals = [],
    approvedWithdrawals = [],
    rejectedWithdrawals = [],
    onApproveManual,
    onApproveGateway,
    onReject,
}) {
    const [activeTab, setActiveTab] = useState('pending');

    const getDisplayedList = () => {
        if (activeTab === 'pending') return pendingWithdrawals;
        if (activeTab === 'approved') return approvedWithdrawals;
        return rejectedWithdrawals;
    };

    const currentList = getDisplayedList();

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-5 select-none">
            
            {/* Header & Tab Buttons */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div>
                    <h3 className="font-black text-lg text-slate-900 tracking-tight">
                        Antrean Validasi Penarikan Saldo (Payout) 📋
                    </h3>
                    <p className="text-xs text-slate-500">
                        Permohonan pencairan dana tabungan yang diajukan warga nasabah unit
                    </p>
                </div>

                {/* Filter Tab Pills */}
                <div className="flex flex-wrap items-center gap-1.5 bg-slate-100 p-1 rounded-2xl border border-slate-200/80">
                    <button
                        type="button"
                        onClick={() => setActiveTab('pending')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 ${
                            activeTab === 'pending'
                                ? 'bg-amber-500 text-white shadow-2xs'
                                : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        <Clock className="w-3.5 h-3.5" />
                        <span>Menunggu ({pendingWithdrawals.length})</span>
                    </button>

                    <button
                        type="button"
                        onClick={() => setActiveTab('approved')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 ${
                            activeTab === 'approved'
                                ? 'bg-emerald-600 text-white shadow-2xs'
                                : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        <Check className="w-3.5 h-3.5" />
                        <span>Disetujui ({approvedWithdrawals.length})</span>
                    </button>

                    <button
                        type="button"
                        onClick={() => setActiveTab('rejected')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 ${
                            activeTab === 'rejected'
                                ? 'bg-rose-600 text-white shadow-2xs'
                                : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        <X className="w-3.5 h-3.5" />
                        <span>Ditolak ({rejectedWithdrawals.length})</span>
                    </button>
                </div>
            </div>

            {/* Table or Empty State */}
            {currentList.length === 0 ? (
                <div className="py-12 text-center space-y-2">
                    <div className="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                        <CheckCircle2 className="w-6 h-6" />
                    </div>
                    <p className="text-xs text-slate-500 font-medium">
                        {activeTab === 'pending'
                            ? 'Tidak ada antrean penarikan saldo yang menunggu persetujuan.'
                            : activeTab === 'approved'
                            ? 'Belum ada riwayat penarikan saldo yang disetujui.'
                            : 'Tidak ada permohonan penarikan saldo yang ditolak.'}
                    </p>
                </div>
            ) : (
                <div className="overflow-x-auto">
                    <table className="w-full text-left text-xs">
                        <thead>
                            <tr className="border-b border-slate-200 text-slate-400 font-extrabold uppercase tracking-wider">
                                <th className="pb-3 px-3">Nasabah & Wilayah</th>
                                <th className="pb-3 px-3">Nominal Tarik</th>
                                <th className="pb-3 px-3">Metode & Rekening Tujuan</th>
                                <th className="pb-3 px-3">Waktu Diajukan</th>
                                <th className="pb-3 px-3 text-right">Aksi Otorisasi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-slate-100">
                            {currentList.map((item) => (
                                <tr key={item.id} className="hover:bg-slate-50/80 transition-colors">
                                    {/* Nasabah */}
                                    <td className="py-3.5 px-3">
                                        <div className="flex items-center gap-3">
                                            {item.user_avatar ? (
                                                <img
                                                    src={item.user_avatar}
                                                    alt={item.user_name}
                                                    className="w-10 h-10 rounded-xl object-cover border border-slate-200 shrink-0"
                                                />
                                            ) : (
                                                <div className="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs shrink-0">
                                                    {item.user_name ? item.user_name.charAt(0).toUpperCase() : 'N'}
                                                </div>
                                            )}
                                            <div>
                                                <p className="font-extrabold text-xs text-slate-900 leading-tight">
                                                    {item.user_name}
                                                </p>
                                                <span className="text-[10px] text-slate-500 font-medium block">
                                                    {item.user_rt_rw} • Saldo: {item.user_saldo_formatted}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    {/* Nominal */}
                                    <td className="py-3.5 px-3 font-black text-sm text-slate-900">
                                        {item.nominal_formatted}
                                    </td>

                                    {/* Metode & Rekening */}
                                    <td className="py-3.5 px-3">
                                        <div className="space-y-0.5">
                                            <span className="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-800 text-[10px] font-bold">
                                                <CreditCard className="w-3 h-3 text-slate-500" />
                                                <span>{item.metode}</span>
                                            </span>
                                            <p className="font-mono text-xs font-semibold text-slate-700">
                                                {item.nomor_rekening}
                                            </p>
                                            <span className="text-[10px] text-slate-400 block">
                                                a.n. {item.atas_nama}
                                            </span>
                                        </div>
                                    </td>

                                    {/* Waktu */}
                                    <td className="py-3.5 px-3 text-slate-500 font-medium whitespace-nowrap">
                                        <span className="block font-semibold text-slate-700">{item.created_at_formatted}</span>
                                        <span className="text-[10px] text-slate-400">{item.created_at_full}</span>
                                    </td>

                                    {/* Aksi */}
                                    <td className="py-3.5 px-3 text-right">
                                        {activeTab === 'pending' ? (
                                            <div className="flex items-center justify-end gap-1.5">
                                                {/* Manual Approve */}
                                                <button
                                                    type="button"
                                                    onClick={() => onApproveManual && onApproveManual(item)}
                                                    className="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-[11px] font-extrabold transition-colors shadow-2xs flex items-center gap-1 cursor-pointer"
                                                    title="Setujui dan upload bukti transfer manual"
                                                >
                                                    <Check className="w-3.5 h-3.5" />
                                                    <span>Setujui</span>
                                                </button>

                                                {/* Auto Gateway */}
                                                <button
                                                    type="button"
                                                    onClick={() => onApproveGateway && onApproveGateway(item)}
                                                    className="px-2.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-[11px] font-extrabold transition-colors shadow-2xs flex items-center gap-1 cursor-pointer"
                                                    title="Kirim instan via Payment Gateway Iris Midtrans"
                                                >
                                                    <Zap className="w-3.5 h-3.5 text-amber-300" />
                                                    <span>Gateway</span>
                                                </button>

                                                {/* Reject */}
                                                <button
                                                    type="button"
                                                    onClick={() => onReject && onReject(item)}
                                                    className="p-1.5 bg-slate-100 hover:bg-rose-50 text-slate-500 hover:text-rose-600 rounded-xl transition-colors cursor-pointer"
                                                    title="Tolak permohonan"
                                                >
                                                    <X className="w-4 h-4" />
                                                </button>
                                            </div>
                                        ) : activeTab === 'approved' ? (
                                            <span className="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                ✅ Berhasil Dicairkan
                                            </span>
                                        ) : (
                                            <span className="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800 border border-rose-200">
                                                ❌ Ditolak Admin
                                            </span>
                                        )}
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
