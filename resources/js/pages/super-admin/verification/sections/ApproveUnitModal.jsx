import React from 'react';

export default function ApproveUnitModal({
    isOpen,
    onClose,
    bankSampah = {},
    csrfToken = '',
}) {
    if (!isOpen) return null;

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div className="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-md w-full overflow-hidden scale-in duration-200">
                {/* Header Graphic */}
                <div className="p-7 text-center bg-gradient-to-b from-emerald-50 to-white border-b border-emerald-100">
                    <div className="w-16 h-16 rounded-3xl bg-emerald-600 text-white flex items-center justify-center text-3xl mx-auto mb-4 shadow-lg shadow-emerald-600/30">
                        🎉
                    </div>
                    <h3 className="text-lg font-black text-slate-900">
                        Otorisasi & Aktifkan Unit Mitra
                    </h3>
                    <p className="text-xs text-slate-500 mt-1 max-w-xs mx-auto">
                        Anda akan menyetujui permohonan pendaftaran resmi untuk <strong>{bankSampah.nama}</strong>.
                    </p>
                </div>

                {/* Body Information */}
                <div className="p-6 space-y-4 text-xs">
                    <div className="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2.5">
                        <div className="flex justify-between">
                            <span className="text-slate-500">Nomor Registrasi:</span>
                            <span className="font-mono font-bold text-slate-800">{bankSampah.nomor_registrasi || bankSampah.kode_bank}</span>
                        </div>
                        <div className="flex justify-between">
                            <span className="text-slate-500">Penanggung Jawab:</span>
                            <span className="font-bold text-slate-800">{bankSampah.penanggung_jawab}</span>
                        </div>
                        <div className="flex justify-between">
                            <span className="text-slate-500">Wilayah Unit:</span>
                            <span className="font-bold text-slate-800">{bankSampah.desa}, {bankSampah.kabupaten}</span>
                        </div>
                    </div>

                    <div className="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-900 space-y-1 text-[11px] leading-relaxed">
                        <p className="font-bold flex items-center gap-1.5">
                            <i className="bi bi-shield-check text-emerald-600" />
                            <span>Dampak Keputusan Persetujuan:</span>
                        </p>
                        <ul className="list-disc list-inside space-y-0.5 text-emerald-800/90 pl-1">
                            <li>Status unit berubah menjadi <strong>Aktif (Beroperasi)</strong>.</li>
                            <li>Akun Admin Unit otomatis diberikan hak akses operasional.</li>
                            <li>Unit akan muncul di Direktori Master Bank Sampah & Peta Nasional.</li>
                        </ul>
                    </div>

                    {/* Action Form */}
                    <form
                        method="POST"
                        action={`/super-admin/verifikasi-bank-sampah/${bankSampah.id}/approve`}
                        className="pt-2 flex items-center justify-end gap-3"
                    >
                        <input type="hidden" name="_token" value={csrfToken} />
                        <button
                            type="button"
                            onClick={onClose}
                            className="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition-colors"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            className="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black transition-all shadow-md shadow-emerald-600/25 active:scale-95 flex items-center gap-1.5"
                        >
                            <i className="bi bi-check2-circle text-sm" />
                            <span>Konfirmasi & Setujui</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    );
}
