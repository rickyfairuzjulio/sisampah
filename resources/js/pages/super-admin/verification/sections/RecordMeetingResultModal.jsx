import React, { useState } from 'react';

export default function RecordMeetingResultModal({
    isOpen,
    onClose,
    bankSampah = {},
    onSaveResult,
}) {
    const [result, setResult] = useState('verified');
    const [notes, setNotes] = useState('');

    if (!isOpen) return null;

    const handleSubmit = (e) => {
        e.preventDefault();
        if (onSaveResult) {
            onSaveResult({ result, notes });
        }
        onClose();
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div className="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-lg w-full overflow-hidden scale-in duration-200">
                {/* Header */}
                <div className="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center text-lg font-black border border-amber-200">
                            📝
                        </div>
                        <div>
                            <h3 className="text-base font-black text-slate-900">
                                Catat Hasil Wawancara & Visitasi
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
                <form onSubmit={handleSubmit} className="p-6 space-y-5 text-xs">
                    {/* Decision Selection */}
                    <div className="space-y-2">
                        <label className="block font-bold text-slate-800">
                            Kesimpulan Hasil Evaluasi Lapangan:
                        </label>
                        <div className="grid grid-cols-3 gap-2.5">
                            <button
                                type="button"
                                onClick={() => setResult('verified')}
                                className={`p-3 rounded-2xl border text-center font-bold flex flex-col items-center gap-1 transition-all ${
                                    result === 'verified'
                                        ? 'bg-emerald-50 border-emerald-400 ring-2 ring-emerald-400/20 text-emerald-800'
                                        : 'bg-white border-slate-200 text-slate-700 hover:bg-slate-50'
                                }`}
                            >
                                <i className="bi bi-check-circle-fill text-emerald-600 text-base" />
                                <span>Layak / Lolos</span>
                            </button>

                            <button
                                type="button"
                                onClick={() => setResult('revision')}
                                className={`p-3 rounded-2xl border text-center font-bold flex flex-col items-center gap-1 transition-all ${
                                    result === 'revision'
                                        ? 'bg-amber-50 border-amber-400 ring-2 ring-amber-400/20 text-amber-800'
                                        : 'bg-white border-slate-200 text-slate-700 hover:bg-slate-50'
                                }`}
                            >
                                <i className="bi bi-pencil-square text-amber-600 text-base" />
                                <span>Perlu Revisi</span>
                            </button>

                            <button
                                type="button"
                                onClick={() => setResult('rejected')}
                                className={`p-3 rounded-2xl border text-center font-bold flex flex-col items-center gap-1 transition-all ${
                                    result === 'rejected'
                                        ? 'bg-rose-50 border-rose-400 ring-2 ring-rose-400/20 text-rose-800'
                                        : 'bg-white border-slate-200 text-slate-700 hover:bg-slate-50'
                                }`}
                            >
                                <i className="bi bi-x-circle-fill text-rose-600 text-base" />
                                <span>Tidak Layak</span>
                            </button>
                        </div>
                    </div>

                    {/* Notes */}
                    <div className="space-y-1.5">
                        <label className="block font-bold text-slate-800">
                            Catatan Rinci Hasil Pemeriksaan Fisik & SDM:
                        </label>
                        <textarea
                            rows={4}
                            value={notes}
                            onChange={(e) => setNotes(e.target.value)}
                            required
                            placeholder="Contoh: Lokasi gudang tertata rapi, timbangan digital berfungsi baik, memiliki 4 pengurus aktif dan 1 armada gerobak motor roda 3."
                            className="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-400"
                        />
                    </div>

                    {/* Actions */}
                    <div className="flex items-center justify-end gap-3 pt-2">
                        <button
                            type="button"
                            onClick={onClose}
                            className="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition-colors"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            className="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold transition-all shadow-md shadow-amber-600/20 active:scale-95"
                        >
                            Simpan Hasil Verifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
