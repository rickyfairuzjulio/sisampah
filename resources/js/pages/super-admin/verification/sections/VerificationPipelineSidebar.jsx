import React from 'react';

export default function VerificationPipelineSidebar({
    bankSampah = {},
    verifications = [],
    onOpenScheduleModal,
    onOpenRecordResultModal,
}) {
    const latestVerification = verifications.length > 0 ? verifications[0] : null;

    const timelineEvents = [
        {
            title: 'Permohonan Pendaftaran Diterima',
            time: bankSampah.created_at || 'Baru saja',
            desc: 'Formulir online dan berkas legalitas awal berhasil disubmit calon mitra.',
            icon: 'bi-inbox-fill',
            color: 'bg-sky-500 text-white',
        },
        ...(latestVerification?.scheduled_at ? [{
            title: `Pertemuan Ditetapkan (${latestVerification.method === 'online' ? 'Online' : 'Visitasi Fisik'})`,
            time: latestVerification.scheduled_at,
            desc: latestVerification.notes || 'Wawancara kesiapan pengelola dan fasilitas gudang.',
            icon: 'bi-calendar-event-fill',
            color: 'bg-indigo-500 text-white',
        }] : []),
        ...(latestVerification?.completed_at ? [{
            title: `Hasil Visitasi: ${latestVerification.result === 'verified' ? 'Layak' : 'Revisi/Ditolak'}`,
            time: latestVerification.completed_at,
            desc: latestVerification.notes || 'Hasil verifikasi lapangan telah dicatat verifikator.',
            icon: 'bi-clipboard-check-fill',
            color: latestVerification.result === 'verified' ? 'bg-emerald-500 text-white' : 'bg-amber-500 text-white',
        }] : []),
        ...(bankSampah.status_verifikasi === 'verified' || bankSampah.status === 'aktif' ? [{
            title: 'Unit Resmi Disetujui & Aktif',
            time: 'Resmi',
            desc: 'Kemitraan SiSampah aktif, akun admin unit diterbitkan.',
            icon: 'bi-patch-check-fill',
            color: 'bg-emerald-600 text-white',
        }] : []),
    ];

    return (
        <div className="space-y-6">
            {/* 1. Schedule Meeting Widget */}
            <div className="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div className="flex items-center gap-2.5">
                        <div className="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center font-bold text-sm">
                            📅
                        </div>
                        <h3 className="font-black text-slate-900 text-sm">
                            Jadwal Visitasi
                        </h3>
                    </div>
                    <button
                        type="button"
                        onClick={onOpenScheduleModal}
                        className="text-xs font-bold text-indigo-600 hover:text-indigo-800 hover:underline"
                    >
                        {latestVerification?.scheduled_at ? 'Ubah' : '+ Atur'}
                    </button>
                </div>

                {latestVerification?.scheduled_at ? (
                    <div className="p-4 rounded-2xl bg-indigo-50/60 border border-indigo-100 space-y-2 text-xs">
                        <div className="flex items-center justify-between">
                            <span className="font-extrabold text-indigo-950 capitalize flex items-center gap-1.5">
                                <i className={`bi ${latestVerification.method === 'online' ? 'bi-camera-video-fill' : 'bi-geo-alt-fill'} text-indigo-600`} />
                                <span>Metode {latestVerification.method}</span>
                            </span>
                            <span className="px-2 py-0.5 rounded-full bg-indigo-200/60 text-indigo-800 font-extrabold text-[10px]">
                                Terjadwal
                            </span>
                        </div>
                        <p className="font-bold text-slate-800 text-sm">
                            {latestVerification.scheduled_at}
                        </p>
                        {latestVerification.notes && (
                            <p className="text-slate-600 text-[11px] leading-relaxed pt-1 border-t border-indigo-100/80">
                                {latestVerification.notes}
                            </p>
                        )}
                    </div>
                ) : (
                    <div className="p-4 rounded-2xl bg-slate-50 border border-dashed border-slate-200 text-center space-y-2">
                        <p className="text-xs text-slate-500">
                            Belum ada jadwal visitasi lapangan atau pertemuan daring yang diatur.
                        </p>
                        <button
                            type="button"
                            onClick={onOpenScheduleModal}
                            className="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition-colors shadow-xs"
                        >
                            Jadwalkan Sekarang
                        </button>
                    </div>
                )}
            </div>

            {/* 2. Record Result Widget */}
            <div className="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div className="flex items-center gap-2.5">
                        <div className="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold text-sm">
                            📝
                        </div>
                        <h3 className="font-black text-slate-900 text-sm">
                            Hasil Verifikasi
                        </h3>
                    </div>
                    <button
                        type="button"
                        onClick={onOpenRecordResultModal}
                        className="text-xs font-bold text-amber-700 hover:text-amber-900 hover:underline"
                    >
                        {latestVerification?.completed_at ? 'Edit' : '+ Catat'}
                    </button>
                </div>

                {latestVerification?.completed_at ? (
                    <div className="p-4 rounded-2xl bg-amber-50/60 border border-amber-100 space-y-2 text-xs">
                        <div className="flex items-center justify-between">
                            <span className="font-extrabold text-amber-950">
                                Status: {latestVerification.result === 'verified' ? '✅ Memenuhi Syarat' : '⚠️ Perlu Revisi'}
                            </span>
                            <span className="text-[10px] text-slate-400 font-semibold">
                                {latestVerification.completed_at}
                            </span>
                        </div>
                        <p className="text-slate-700 text-xs leading-relaxed">
                            {latestVerification.notes || 'Hasil wawancara dan visitasi fisik selesai diperiksa.'}
                        </p>
                    </div>
                ) : (
                    <div className="p-4 rounded-2xl bg-slate-50 border border-dashed border-slate-200 text-center space-y-2">
                        <p className="text-xs text-slate-500">
                            Catat hasil wawancara kesiapan operasional setelah pertemuan selesai.
                        </p>
                        <button
                            type="button"
                            onClick={onOpenRecordResultModal}
                            className="px-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs transition-colors shadow-xs"
                        >
                            Input Hasil Penilaian
                        </button>
                    </div>
                )}
            </div>

            {/* 3. Audit Trail Timeline */}
            <div className="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                <div className="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                    <div className="w-8 h-8 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-sm">
                        ⏱️
                    </div>
                    <h3 className="font-black text-slate-900 text-sm">
                        Kronologi Audit Trail
                    </h3>
                </div>

                <div className="space-y-4 relative pl-3 text-xs before:absolute before:left-5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                    {timelineEvents.map((evt, idx) => (
                        <div key={idx} className="relative flex items-start gap-3.5 group">
                            <div className={`w-5 h-5 rounded-full flex items-center justify-center text-[10px] shrink-0 z-10 ${evt.color}`}>
                                <i className={`bi ${evt.icon}`} />
                            </div>
                            <div className="space-y-0.5">
                                <div className="flex flex-wrap items-center gap-2">
                                    <h4 className="font-extrabold text-slate-900 text-xs">{evt.title}</h4>
                                    <span className="text-[10px] text-slate-400 font-semibold">({evt.time})</span>
                                </div>
                                <p className="text-[11px] text-slate-500 leading-snug">
                                    {evt.desc}
                                </p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
}
