import React, { useState } from 'react';

export default function RejectUnitModal({
    isOpen,
    onClose,
    bankSampah = {},
    csrfToken = '',
}) {
    const [reason, setReason] = useState('');

    if (!isOpen) return null;

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div className="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-md w-full overflow-hidden scale-in duration-200">
                {/* Header Graphic */}
                <div className="p-7 text-center bg-gradient-to-b from-rose-50 to-white border-b border-rose-100">
                    <div className="w-16 h-16 rounded-3xl bg-rose-600 text-white flex items-center justify-center text-3xl mx-auto mb-4 shadow-lg shadow-rose-600/30">
                        ❌
                    </div>
                    <h3 className="text-lg font-black text-slate-900">
                        Tolak Permohonan Pendaftaran
                    </h3>
                    <p className="text-xs text-slate-500 mt-1 max-w-xs mx-auto">
                        Permohonan untuk <strong>{bankSampah.nama}</strong> akan ditolak dan statusnya dinonaktifkan.
                    </p>
                </div>

                {/* Form */}
                <form
                    method="POST"
                    action={`/super-admin/verifikasi-bank-sampah/${bankSampah.id}/reject`}
                    className="p-6 space-y-4 text-xs"
                >
                    <input type="hidden" name="_token" value={csrfToken} />

                    <div className="space-y-1.5">
                        <label className="block font-bold text-slate-800">
                            Alasan Resmi Penolakan:
                        </label>
                        <textarea
                            name="reason"
                            rows={3}
                            value={reason}
                            onChange={(e) => setReason(e.target.value)}
                            required
                            placeholder="Contoh: Dokumen legalitas tidak valid setelah 3x permintaan revisi dan fasilitas fisik tidak memenuhi standar kelayakan penimbangan."
                            className="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-400"
                        />
                    </div>

                    <div className="p-3.5 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-900 text-[11px] leading-relaxed">
                        <p className="font-bold flex items-center gap-1.5">
                            <i className="bi bi-exclamation-octagon-fill text-rose-600" />
                            <span>Peringatan Tindakan:</span>
                        </p>
                        <p className="text-rose-800/90 mt-1">
                            Alasan penolakan ini akan dicatat ke dalam audit log dan dikirimkan kepada calon pengelola unit.
                        </p>
                    </div>

                    {/* Actions */}
                    <div className="pt-2 flex items-center justify-end gap-3">
                        <button
                            type="button"
                            onClick={onClose}
                            className="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition-colors"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            className="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold transition-all shadow-md shadow-rose-600/25 active:scale-95 flex items-center gap-1.5"
                        >
                            <i className="bi bi-x-circle text-sm" />
                            <span>Tolak Permohonan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
