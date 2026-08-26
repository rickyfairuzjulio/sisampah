import React, { useState } from 'react';
import { AlertTriangle, ShieldAlert, CheckCircle2, Clock, Phone, MessageSquare, Check, Sparkles, UserX, AlertOctagon } from 'lucide-react';

export default function ViolationsAuditTable({
    violations = [],
    onResolveViolation,
}) {
    const [activeTab, setActiveTab] = useState('all');

    const filteredViolations = violations.filter((v) => {
        if (activeTab === 'all') return true;
        if (activeTab === 'unsegregated') return v.type === 'unsegregated';
        if (activeTab === 'suspicious') return v.type === 'suspicious';
        if (activeTab === 'missed_pickup') return v.type === 'missed_pickup';
        if (activeTab === 'resolved') return v.status === 'resolved';
        if (activeTab === 'pending') return v.status === 'pending';
        return true;
    });

    const unsegregatedCount = violations.filter((v) => v.type === 'unsegregated').length;
    const suspiciousCount = violations.filter((v) => v.type === 'suspicious').length;
    const resolvedCount = violations.filter((v) => v.status === 'resolved').length;
    const pendingCount = violations.filter((v) => v.status === 'pending').length;

    const handleOpenWhatsApp = (phone, userName, description) => {
        const cleanPhone = phone.replace(/[^0-9]/g, '');
        const targetPhone = cleanPhone.startsWith('0') ? '62' + cleanPhone.slice(1) : cleanPhone;
        const msg = encodeURIComponent(`Halo ${userName}, ini dari Admin Bank Sampah SiSampah. Mengenai catatan operasional terkait: "${description}", mohon konfirmasi dan koordinasinya. Terima kasih.`);
        window.open(`https://wa.me/${targetPhone}?text=${msg}`, '_blank');
    };

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-5 select-none">
            
            {/* Header & Filter Tabs */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div>
                    <h3 className="font-black text-lg text-slate-900 tracking-tight">
                        Catatan Kejadian & Audit Integritas 📋
                    </h3>
                    <p className="text-xs text-slate-500">
                        Daftar catatan ketidaksesuaian pemilahan, transaksi anomali, dan ketidakhadiran jadwal
                    </p>
                </div>

                {/* Filter Tabs */}
                <div className="flex flex-wrap items-center gap-1.5 bg-slate-100 p-1 rounded-2xl border border-slate-200/80">
                    <button
                        type="button"
                        onClick={() => setActiveTab('all')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer ${
                            activeTab === 'all' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        Semua ({violations.length})
                    </button>

                    <button
                        type="button"
                        onClick={() => setActiveTab('pending')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 ${
                            activeTab === 'pending' ? 'bg-amber-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        <Clock className="w-3.5 h-3.5" />
                        <span>Tinjauan ({pendingCount})</span>
                    </button>

                    <button
                        type="button"
                        onClick={() => setActiveTab('unsegregated')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 ${
                            activeTab === 'unsegregated' ? 'bg-amber-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        <AlertTriangle className="w-3.5 h-3.5" />
                        <span>Tidak Terpilah ({unsegregatedCount})</span>
                    </button>

                    <button
                        type="button"
                        onClick={() => setActiveTab('suspicious')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 ${
                            activeTab === 'suspicious' ? 'bg-rose-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        <ShieldAlert className="w-3.5 h-3.5" />
                        <span>Anomali ({suspiciousCount})</span>
                    </button>

                    <button
                        type="button"
                        onClick={() => setActiveTab('resolved')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 ${
                            activeTab === 'resolved' ? 'bg-emerald-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        <CheckCircle2 className="w-3.5 h-3.5" />
                        <span>Selesai ({resolvedCount})</span>
                    </button>
                </div>
            </div>

            {/* Table */}
            <div className="overflow-x-auto">
                <table className="w-full text-left text-xs">
                    <thead>
                        <tr className="border-b border-slate-200 text-slate-400 font-extrabold uppercase tracking-wider">
                            <th className="pb-3 px-3">Pihak Terkait</th>
                            <th className="pb-3 px-3">Jenis Kejadian & Kronologi</th>
                            <th className="pb-3 px-3">Tindakan / Sanksi</th>
                            <th className="pb-3 px-3">Status</th>
                            <th className="pb-3 px-3">Waktu</th>
                            <th className="pb-3 px-3 text-right">Aksi Koordinasi</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-100">
                        {filteredViolations.map((v) => {
                            const isPending = v.status === 'pending';
                            const isSuspicious = v.type === 'suspicious';

                            return (
                                <tr key={v.id} className="hover:bg-slate-50/80 transition-colors">
                                    {/* Pihak Terkait */}
                                    <td className="py-3.5 px-3">
                                        <div className="flex items-center gap-2.5">
                                            <div className={`w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 ${
                                                isSuspicious ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800'
                                            }`}>
                                                {v.user_name ? v.user_name.charAt(0).toUpperCase() : 'U'}
                                            </div>
                                            <div>
                                                <p className="font-extrabold text-xs text-slate-900 leading-tight">
                                                    {v.user_name}
                                                </p>
                                                <p className="text-[10px] text-slate-500 mt-0.5">
                                                    {v.user_role}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {/* Jenis & Kronologi */}
                                    <td className="py-3.5 px-3 max-w-xs">
                                        <span className={`inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-extrabold mb-1 border ${
                                            isSuspicious
                                                ? 'bg-rose-50 text-rose-800 border-rose-200'
                                                : 'bg-amber-50 text-amber-800 border-amber-200'
                                        }`}>
                                            {isSuspicious ? <ShieldAlert className="w-3 h-3 text-rose-600" /> : <AlertTriangle className="w-3 h-3 text-amber-600" />}
                                            <span>{v.type_label}</span>
                                        </span>
                                        <p className="text-xs text-slate-600 font-medium line-clamp-2">
                                            {v.description}
                                        </p>
                                    </td>

                                    {/* Sanksi / Tindakan */}
                                    <td className="py-3.5 px-3">
                                        <span className="text-xs font-semibold text-slate-800 block">
                                            {v.sanction}
                                        </span>
                                    </td>

                                    {/* Status */}
                                    <td className="py-3.5 px-3 whitespace-nowrap">
                                        {isPending ? (
                                            <span className="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-200 inline-flex items-center gap-1">
                                                <Clock className="w-3 h-3 text-amber-600" />
                                                <span>Dalam Tinjauan</span>
                                            </span>
                                        ) : (
                                            <span className="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1">
                                                <CheckCircle2 className="w-3 h-3 text-emerald-600" />
                                                <span>Selesai</span>
                                            </span>
                                        )}
                                    </td>

                                    {/* Waktu */}
                                    <td className="py-3.5 px-3 font-medium text-slate-500 whitespace-nowrap text-[11px]">
                                        {v.created_at_formatted}
                                    </td>

                                    {/* Aksi */}
                                    <td className="py-3.5 px-3 text-right whitespace-nowrap">
                                        <div className="flex items-center justify-end gap-1.5">
                                            {v.phone && (
                                                <button
                                                    type="button"
                                                    onClick={() => handleOpenWhatsApp(v.phone, v.user_name, v.description)}
                                                    className="px-2.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-[11px] transition-colors cursor-pointer flex items-center gap-1"
                                                    title="Hubungi via WhatsApp"
                                                >
                                                    <MessageSquare className="w-3.5 h-3.5" />
                                                    <span className="hidden sm:inline">Kirim WA</span>
                                                </button>
                                            )}

                                            {isPending && (
                                                <button
                                                    type="button"
                                                    onClick={() => onResolveViolation && onResolveViolation(v)}
                                                    className="px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-emerald-600 hover:text-white text-slate-700 font-bold text-[11px] transition-colors cursor-pointer flex items-center gap-1"
                                                    title="Tandai Selesai Ditangani"
                                                >
                                                    <Check className="w-3.5 h-3.5" />
                                                    <span>Selesaikan</span>
                                                </button>
                                            )}
                                        </div>
                                    </td>
                                </tr>
                            );
                        })}
                    </tbody>
                </table>
            </div>

        </div>
    );
}
