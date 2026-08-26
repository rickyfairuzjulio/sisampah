import React from 'react';

export default function AuditLogsTable({
    logs = [],
    onOpenDiffModal,
}) {
    const getActionBadge = (action) => {
        if (action.includes('BANK_SAMPAH')) {
            return { label: '🛡️ Otorisasi Mitra', bg: 'bg-emerald-50 text-emerald-800 border-emerald-200' };
        }
        if (action.includes('WITHDRAWAL')) {
            return { label: '💰 Mutasi Kas', bg: 'bg-amber-50 text-amber-800 border-amber-200' };
        }
        if (action.includes('PRICE')) {
            return { label: '🏷️ Update Harga', bg: 'bg-sky-50 text-sky-800 border-sky-200' };
        }
        return { label: '⚙️ Konfigurasi', bg: 'bg-indigo-50 text-indigo-800 border-indigo-200' };
    };

    if (logs.length === 0) {
        return (
            <div className="bg-white rounded-3xl border border-slate-200/80 p-12 text-center space-y-3">
                <div className="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto">
                    📜
                </div>
                <h3 className="text-base font-black text-slate-800">
                    Tidak Ditemukan Log Aktivitas
                </h3>
                <p className="text-xs text-slate-500 max-w-sm mx-auto">
                    Tidak ada aktivitas sistem yang sesuai dengan filter atau kata kunci pencarian Anda.
                </p>
            </div>
        );
    }

    return (
        <div className="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
            <div className="overflow-x-auto">
                <table className="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr className="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-black uppercase tracking-wider text-slate-500">
                            <th className="py-4 px-5">Waktu & IP Address</th>
                            <th className="py-4 px-5">Aktor Pelaku</th>
                            <th className="py-4 px-5">Aksi & Entitas</th>
                            <th className="py-4 px-5">Deskripsi Alasan</th>
                            <th className="py-4 px-5 text-right">Inspeksi</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-100 font-medium text-slate-700">
                        {logs.map((log) => {
                            const badge = getActionBadge(log.action);
                            return (
                                <tr key={log.id} className="hover:bg-slate-50/60 transition-colors group">
                                    {/* 1. Waktu & IP */}
                                    <td className="py-4 px-5">
                                        <div className="space-y-0.5">
                                            <p className="font-bold text-slate-900">{log.created_at_formatted}</p>
                                            <p className="text-[11px] text-slate-400 font-mono">
                                                IP: {log.ip_address} • {log.time_ago}
                                            </p>
                                        </div>
                                    </td>

                                    {/* 2. Aktor Pelaku */}
                                    <td className="py-4 px-5">
                                        <div className="space-y-0.5">
                                            <p className="font-extrabold text-slate-900">{log.actor_name}</p>
                                            <span className="inline-flex items-center px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-extrabold text-[10px]">
                                                {log.actor_role}
                                            </span>
                                        </div>
                                    </td>

                                    {/* 3. Aksi & Entitas */}
                                    <td className="py-4 px-5">
                                        <div className="space-y-1">
                                            <span className={`inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold border ${badge.bg}`}>
                                                {badge.label}
                                            </span>
                                            <p className="font-mono text-[10px] text-slate-400">
                                                {log.entity_type} #{log.entity_id}
                                            </p>
                                        </div>
                                    </td>

                                    {/* 4. Deskripsi Alasan */}
                                    <td className="py-4 px-5 max-w-sm">
                                        <p className="text-slate-600 leading-relaxed text-xs line-clamp-2">
                                            {log.reason}
                                        </p>
                                    </td>

                                    {/* 5. Inspeksi Diff */}
                                    <td className="py-4 px-5 text-right">
                                        <button
                                            type="button"
                                            onClick={() => onOpenDiffModal(log)}
                                            className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors"
                                        >
                                            <i className="bi bi-search text-xs" />
                                            <span>Lihat Diff</span>
                                        </button>
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
