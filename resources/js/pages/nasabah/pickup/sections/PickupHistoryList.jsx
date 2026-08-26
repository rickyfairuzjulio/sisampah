import React from 'react';
import { History, Clock, CheckCircle2, Truck, AlertCircle, XCircle, ChevronRight } from 'lucide-react';

export default function PickupHistoryList({ pickupHistory = [] }) {
    if (!pickupHistory || pickupHistory.length === 0) {
        return null;
    }

    const getStatusBadge = (status) => {
        switch (status) {
            case 'completed':
            case 'selesai':
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-black border border-emerald-200">
                        <CheckCircle2 className="w-3.5 h-3.5" />
                        <span>Selesai Ditimbang</span>
                    </span>
                );
            case 'in_progress':
            case 'on_the_way':
            case 'otw':
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 text-[11px] font-black border border-blue-200 animate-pulse">
                        <Truck className="w-3.5 h-3.5" />
                        <span>Armada Menuju Lokasi</span>
                    </span>
                );
            case 'scheduled':
            case 'dijadwalkan':
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-800 text-[11px] font-black border border-indigo-200">
                        <Clock className="w-3.5 h-3.5" />
                        <span>Dijadwalkan Petugas</span>
                    </span>
                );
            case 'cancelled':
            case 'batal':
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-100 text-red-800 text-[11px] font-black border border-red-200">
                        <XCircle className="w-3.5 h-3.5" />
                        <span>Dibatalkan</span>
                    </span>
                );
            default:
                return (
                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 text-[11px] font-black border border-amber-200">
                        <Clock className="w-3.5 h-3.5" />
                        <span>Menunggu Konfirmasi</span>
                    </span>
                );
        }
    };

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-5">
            
            {/* Header */}
            <div className="flex items-center justify-between gap-4 pb-4 border-b border-slate-100">
                <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center font-bold shrink-0">
                        <History className="w-5 h-5" />
                    </div>
                    <div>
                        <h3 className="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">
                            Riwayat & Status Penjemputan Terakhir
                        </h3>
                        <p className="text-xs text-slate-500 mt-0.5">
                            Pantau status real-time pesanan penjemputan sampah Anda.
                        </p>
                    </div>
                </div>
            </div>

            {/* List */}
            <div className="divide-y divide-slate-100">
                {pickupHistory.map((item) => (
                    <div 
                        key={item.id}
                        className="py-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 group"
                    >
                        <div className="space-y-1 min-w-0 flex-1">
                            <div className="flex items-center gap-2.5 flex-wrap">
                                <span className="font-mono text-xs font-black text-slate-900 bg-slate-100 px-2 py-0.5 rounded-md">
                                    {item.code}
                                </span>
                                <span className="text-xs text-slate-400">•</span>
                                <span className="text-xs font-semibold text-slate-600">
                                    {item.scheduled_at || item.created_at}
                                </span>
                            </div>
                            <p className="text-xs text-slate-500 truncate">
                                📍 {item.address} (Est. {item.estimasi_berat} Kg)
                            </p>
                        </div>

                        <div className="shrink-0 flex items-center gap-3 self-end sm:self-auto">
                            {getStatusBadge(item.status)}
                        </div>
                    </div>
                ))}
            </div>

        </div>
    );
}
