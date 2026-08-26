import React from 'react';
import { Clock, Check, X, ArrowUpRight, ShieldAlert, CreditCard } from 'lucide-react';

export default function PendingWithdrawalsCard({
    pendingWithdrawals = [],
}) {
    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-2xs space-y-4 select-none">
            
            <div className="flex items-center justify-between pb-2 border-b border-slate-100">
                <div className="flex items-center gap-2.5">
                    <div className="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        <Clock className="w-4 h-4" />
                    </div>
                    <div>
                        <h3 className="font-extrabold text-sm sm:text-base text-slate-900 tracking-tight">
                            Antrean Validasi Penarikan Saldo ⏳
                        </h3>
                        <p className="text-[11px] text-slate-400">
                            Permohonan pencairan dana nasabah menunggu persetujuan
                        </p>
                    </div>
                </div>

                <a
                    href="/admin/validasi-keuangan"
                    className="text-[11px] font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1"
                >
                    <span>Semua</span>
                    <ArrowUpRight className="w-3 h-3" />
                </a>
            </div>

            {(!pendingWithdrawals || pendingWithdrawals.length === 0) ? (
                <div className="py-8 text-center space-y-2">
                    <div className="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto">
                        <Check className="w-5 h-5" />
                    </div>
                    <p className="text-xs text-slate-500 font-medium">
                        Tidak ada antrean penarikan saldo pending. Seluruh payout telah selesai diproses!
                    </p>
                </div>
            ) : (
                <div className="space-y-3">
                    {pendingWithdrawals.map((item) => (
                        <div
                            key={item.id}
                            className="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70 hover:bg-emerald-50/20 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-3"
                        >
                            <div className="flex items-center gap-3 min-w-0">
                                {item.user_avatar ? (
                                    <img
                                        src={item.user_avatar}
                                        alt={item.user_name}
                                        className="w-10 h-10 rounded-xl object-cover border border-slate-300 shrink-0"
                                    />
                                ) : (
                                    <div className="w-10 h-10 rounded-xl bg-slate-200 text-slate-700 flex items-center justify-center font-black text-sm shrink-0">
                                        {item.user_name ? item.user_name.charAt(0).toUpperCase() : 'N'}
                                    </div>
                                )}

                                <div className="space-y-0.5 min-w-0">
                                    <p className="font-extrabold text-xs text-slate-900 truncate">
                                        {item.user_name}
                                    </p>
                                    <div className="flex items-center gap-1.5 text-[11px] text-slate-500">
                                        <CreditCard className="w-3 h-3 text-slate-400 shrink-0" />
                                        <span className="truncate">{item.metode} • {item.nomor_rekening}</span>
                                    </div>
                                </div>
                            </div>

                            <div className="flex items-center justify-between sm:justify-end gap-3 shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-200/60">
                                <div className="text-left sm:text-right">
                                    <p className="font-black text-xs sm:text-sm text-slate-900">
                                        {item.nominal_formatted}
                                    </p>
                                    <span className="text-[10px] text-slate-400 block">
                                        {item.created_at_formatted}
                                    </span>
                                </div>

                                <a
                                    href="/admin/validasi-keuangan"
                                    className="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-[11px] font-extrabold transition-colors shadow-2xs cursor-pointer flex items-center gap-1"
                                >
                                    <span>Validasi</span>
                                    <ArrowUpRight className="w-3 h-3" />
                                </a>
                            </div>
                        </div>
                    ))}
                </div>
            )}

        </div>
    );
}
