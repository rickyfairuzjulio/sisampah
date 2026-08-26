import React, { useState } from 'react';

export default function ToggleStatusModal({
    isOpen,
    onClose,
    bankSampah = null,
    csrfToken = '',
}) {
    if (!isOpen || !bankSampah) return null;

    const [status, setStatus] = useState(bankSampah.status || 'aktif');
    const [reason, setReason] = useState('');

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div className="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-md w-full overflow-hidden scale-in duration-200">
                {/* Header */}
                <div className="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center text-lg font-black border border-amber-200">
                            🛡️
                        </div>
                        <div>
                            <h3 className="text-base font-black text-slate-900">
                                Kontrol Status Kemitraan
                            </h3>
                            <p className="text-xs text-slate-500">{bankSampah.nama}</p>
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

                {/* Form */}
                <form
                    method="POST"
                    action={`/super-admin/master-bank-sampah/${bankSampah.id}/toggle-status`}
                    className="p-6 space-y-4 text-xs"
                >
                    <input type="hidden" name="_token" value={csrfToken} />

                    <div className="space-y-2">
                        <label className="block font-bold text-slate-800">
                            Pilih Status Kemitraan & Akreditasi:
                        </label>
                        
                        <div className="space-y-2">
                            {/* Option 1: Aktif */}
                            <label
                                className={`flex items-start gap-3 p-3 rounded-2xl border cursor-pointer transition-all ${
                                    status === 'aktif'
                                        ? 'bg-emerald-50/60 border-emerald-400 ring-2 ring-emerald-400/20'
                                        : 'bg-white border-slate-200 hover:bg-slate-50'
                                }`}
                            >
                                <input
                                    type="radio"
                                    name="status"
                                    value="aktif"
                                    checked={status === 'aktif'}
                                    onChange={(e) => setStatus(e.target.value)}
                                    className="mt-1 text-emerald-600"
                                />
                                <div>
                                    <span className="font-extrabold text-slate-900 block">
                                        🟢 Terakreditasi & Aktif Beroperasi
                                    </span>
                                    <span className="text-[11px] text-slate-500 leading-tight block mt-0.5">
                                        Unit berstatus resmi aktif di platform SiSampah dan terdaftar di direktori.
                                    </span>
                                </div>
                            </label>

                            {/* Option 2: Libur Sementara */}
                            <label
                                className={`flex items-start gap-3 p-3 rounded-2xl border cursor-pointer transition-all ${
                                    status === 'libur'
                                        ? 'bg-amber-50/60 border-amber-400 ring-2 ring-amber-400/20'
                                        : 'bg-white border-slate-200 hover:bg-slate-50'
                                }`}
                            >
                                <input
                                    type="radio"
                                    name="status"
                                    value="libur"
                                    checked={status === 'libur'}
                                    onChange={(e) => setStatus(e.target.value)}
                                    className="mt-1 text-amber-600"
                                />
                                <div>
                                    <span className="font-extrabold text-slate-900 block">
                                        🟡 Libur / Tutup Sementara
                                    </span>
                                    <span className="text-[11px] text-slate-500 leading-tight block mt-0.5">
                                        Unit ditandai tutup sementara untuk renovasi fasilitas gudang atau cuti.
                                    </span>
                                </div>
                            </label>

                            {/* Option 3: Nonaktif / Suspend */}
                            <label
                                className={`flex items-start gap-3 p-3 rounded-2xl border cursor-pointer transition-all ${
                                    status === 'nonaktif'
                                        ? 'bg-rose-50/60 border-rose-400 ring-2 ring-rose-400/20'
                                        : 'bg-white border-slate-200 hover:bg-slate-50'
                                }`}
                            >
                                <input
                                    type="radio"
                                    name="status"
                                    value="nonaktif"
                                    checked={status === 'nonaktif'}
                                    onChange={(e) => setStatus(e.target.value)}
                                    className="mt-1 text-rose-600"
                                />
                                <div>
                                    <span className="font-extrabold text-slate-900 block">
                                        🔴 Ditangguhkan / Suspended
                                    </span>
                                    <span className="text-[11px] text-slate-500 leading-tight block mt-0.5">
                                        Unit dibekukan sementara karena evaluasi pelanggaran SOP atau audit kas.
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div className="space-y-1">
                        <label className="block font-bold text-slate-800">
                            Catatan Audit Super Admin:
                        </label>
                        <textarea
                            name="reason"
                            rows={2}
                            value={reason}
                            onChange={(e) => setReason(e.target.value)}
                            placeholder="Tuliskan catatan pertimbangan perubahan status kemitraan..."
                            className="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-800 focus:ring-2 focus:ring-amber-400"
                        />
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
                            className="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold transition-all shadow-md active:scale-95"
                        >
                            Terapkan Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
