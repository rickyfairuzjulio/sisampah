import React, { useState } from 'react';

export default function ScheduleMeetingModal({
    isOpen,
    onClose,
    bankSampah = {},
    onSaveSchedule,
}) {
    const [method, setMethod] = useState('online');
    const [scheduledAt, setScheduledAt] = useState('');
    const [notes, setNotes] = useState('');

    if (!isOpen) return null;

    const handleSubmit = (e) => {
        e.preventDefault();
        if (!scheduledAt) {
            alert('Silakan pilih tanggal dan waktu pertemuan.');
            return;
        }
        if (onSaveSchedule) {
            onSaveSchedule({ method, scheduled_at: scheduledAt, notes });
        }
        onClose();
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div className="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-lg w-full overflow-hidden scale-in duration-200">
                {/* Modal Header */}
                <div className="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center text-lg font-black border border-indigo-200">
                            📅
                        </div>
                        <div>
                            <h3 className="text-base font-black text-slate-900">
                                Jadwalkan Visitasi & Verifikasi
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

                {/* Modal Form */}
                <form onSubmit={handleSubmit} className="p-6 space-y-5 text-xs">
                    {/* Method Choice */}
                    <div className="space-y-2">
                        <label className="block font-bold text-slate-800">
                            Metode Validasi & Verifikasi:
                        </label>
                        <div className="grid grid-cols-2 gap-3">
                            <button
                                type="button"
                                onClick={() => setMethod('online')}
                                className={`p-3.5 rounded-2xl border text-left flex flex-col gap-1 transition-all ${
                                    method === 'online'
                                        ? 'bg-indigo-50 border-indigo-400 ring-2 ring-indigo-400/20 text-indigo-900'
                                        : 'bg-white border-slate-200 text-slate-700 hover:bg-slate-50'
                                }`}
                            >
                                <span className="font-extrabold flex items-center gap-1.5">
                                    <i className="bi bi-camera-video-fill text-indigo-600" />
                                    <span>Online (Zoom / Meet)</span>
                                </span>
                                <span className="text-[11px] text-slate-500">Wawancara via panggilan video daring</span>
                            </button>

                            <button
                                type="button"
                                onClick={() => setMethod('offline')}
                                className={`p-3.5 rounded-2xl border text-left flex flex-col gap-1 transition-all ${
                                    method === 'offline'
                                        ? 'bg-indigo-50 border-indigo-400 ring-2 ring-indigo-400/20 text-indigo-900'
                                        : 'bg-white border-slate-200 text-slate-700 hover:bg-slate-50'
                                }`}
                            >
                                <span className="font-extrabold flex items-center gap-1.5">
                                    <i className="bi bi-geo-alt-fill text-indigo-600" />
                                    <span>Kunjungan Lapangan</span>
                                </span>
                                <span className="text-[11px] text-slate-500">Survei fisik langsung ke gudang unit</span>
                            </button>
                        </div>
                    </div>

                    {/* Date & Time Input */}
                    <div className="space-y-1.5">
                        <label className="block font-bold text-slate-800">
                            Waktu Pelaksanaan (Tanggal & Jam):
                        </label>
                        <input
                            type="datetime-local"
                            value={scheduledAt}
                            onChange={(e) => setScheduledAt(e.target.value)}
                            required
                            className="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        />
                    </div>

                    {/* Notes */}
                    <div className="space-y-1.5">
                        <label className="block font-bold text-slate-800">
                            Tautan Pertemuan / Catatan Instruksi:
                        </label>
                        <textarea
                            rows={3}
                            value={notes}
                            onChange={(e) => setNotes(e.target.value)}
                            placeholder="Contoh: Link Zoom: https://zoom.us/j/12345678. Harap penanggung jawab dan bendahara unit hadir tepat waktu."
                            className="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        />
                    </div>

                    {/* Notification Info */}
                    <div className="p-3 rounded-2xl bg-indigo-50/70 border border-indigo-100 flex items-start gap-2 text-indigo-900 text-[11px]">
                        <i className="bi bi-info-circle-fill text-indigo-600 text-sm mt-0.5" />
                        <span>
                            Notifikasi jadwal akan otomatis dikirimkan ke WhatsApp PJ unit (<strong>{bankSampah.telepon_pj || '-'}</strong>) dan email resmi.
                        </span>
                    </div>

                    {/* Modal Actions */}
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
                            className="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold transition-all shadow-md shadow-indigo-600/20 active:scale-95"
                        >
                            Simpan & Kirim Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
