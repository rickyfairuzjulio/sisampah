import React from 'react';

export default function AuditDiffModal({
    isOpen,
    onClose,
    log = null,
}) {
    if (!isOpen || !log) return null;

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div className="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col overflow-hidden scale-in duration-200">
                {/* Header */}
                <div className="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/70 shrink-0">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center text-lg font-black border border-indigo-200">
                            🔍
                        </div>
                        <div>
                            <h3 className="text-base font-black text-slate-900">
                                Detail Mutasi Data: {log.action} (#{log.entity_id})
                            </h3>
                            <p className="text-xs text-slate-500">
                                {log.created_at_formatted} • Aktor: {log.actor_name} ({log.actor_role}) • IP: {log.ip_address}
                            </p>
                        </div>
                    </div>
                    <button
                        type="button"
                        onClick={onClose}
                        className="w-8 h-8 rounded-full bg-white hover:bg-slate-100 text-slate-400 hover:text-slate-600 flex items-center justify-center border border-slate-200 transition-colors"
                    >
                        <i className="bi bi-x-lg text-xs" />
                    </button>
                </div>

                {/* Content */}
                <div className="p-6 overflow-y-auto space-y-4 text-xs">
                    {/* Alasan Resmi */}
                    <div className="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <span className="font-extrabold text-slate-900 block">Keterangan / Alasan Resmi:</span>
                        <p className="text-slate-600 leading-relaxed font-medium">
                            {log.reason || 'Tidak ada catatan tambahan.'}
                        </p>
                    </div>

                    {/* Side-by-side Old vs New Values */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {/* Old Values */}
                        <div className="p-4 rounded-2xl bg-rose-50/60 border border-rose-200 space-y-2">
                            <div className="flex items-center gap-2">
                                <span className="w-2 h-2 rounded-full bg-rose-500" />
                                <span className="font-extrabold text-rose-900">Nilai Sebelumnya (Old Values)</span>
                            </div>
                            <pre className="p-3 rounded-xl bg-white border border-rose-100 font-mono text-[11px] text-rose-800 overflow-x-auto">
                                {log.old_values ? JSON.stringify(log.old_values, null, 2) : '(Kosong / Data Baru)'}
                            </pre>
                        </div>

                        {/* New Values */}
                        <div className="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-200 space-y-2">
                            <div className="flex items-center gap-2">
                                <span className="w-2 h-2 rounded-full bg-emerald-500" />
                                <span className="font-extrabold text-emerald-900">Nilai Terbaru (New Values)</span>
                            </div>
                            <pre className="p-3 rounded-xl bg-white border border-emerald-100 font-mono text-[11px] text-emerald-800 overflow-x-auto">
                                {log.new_values ? JSON.stringify(log.new_values, null, 2) : '(Dihapus / Tidak Ada Nilai)'}
                            </pre>
                        </div>
                    </div>
                </div>

                {/* Footer */}
                <div className="px-6 py-4 border-t border-slate-100 bg-slate-50/70 flex justify-end shrink-0">
                    <button
                        type="button"
                        onClick={onClose}
                        className="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors"
                    >
                        Tutup Jendela
                    </button>
                </div>
            </div>
        </div>
    );
}
