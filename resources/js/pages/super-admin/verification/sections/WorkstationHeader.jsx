import React from 'react';

export default function WorkstationHeader({
    bankSampah = {},
    onOpenScheduleModal,
    onOpenRecordResultModal,
    onOpenApproveModal,
    onOpenRejectModal,
}) {
    const isApproved = bankSampah.status_verifikasi === 'verified' || bankSampah.status === 'aktif';
    const isRejected = bankSampah.status_verifikasi === 'rejected';

    const getStatusBadge = (statusVerif) => {
        if (isApproved) {
            return {
                label: 'Telah Terverifikasi & Aktif',
                bg: 'bg-emerald-100 text-emerald-800 border-emerald-300',
                dot: 'bg-emerald-500',
            };
        }
        if (isRejected) {
            return {
                label: 'Permohonan Ditolak',
                bg: 'bg-rose-100 text-rose-800 border-rose-300',
                dot: 'bg-rose-500',
            };
        }
        switch (statusVerif) {
            case 'submitted':
                return { label: 'Permohonan Baru', bg: 'bg-sky-100 text-sky-800 border-sky-300', dot: 'bg-sky-500' };
            case 'under_review':
                return { label: 'Sedang Ditinjau', bg: 'bg-amber-100 text-amber-800 border-amber-300', dot: 'bg-amber-500' };
            case 'document_revision':
                return { label: 'Revisi Berkas Diminta', bg: 'bg-orange-100 text-orange-800 border-orange-300', dot: 'bg-orange-500' };
            case 'meeting_scheduled':
                return { label: 'Jadwal Visitasi Lapangan', bg: 'bg-indigo-100 text-indigo-800 border-indigo-300', dot: 'bg-indigo-500' };
            default:
                return { label: 'Menunggu Audit', bg: 'bg-slate-100 text-slate-800 border-slate-300', dot: 'bg-slate-500' };
        }
    };

    const badge = getStatusBadge(bankSampah.status_verifikasi);

    return (
        <div className="bg-white rounded-3xl border border-slate-200/80 p-6 md:p-7 shadow-sm">
            <div className="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                {/* Left: Back & Unit Info */}
                <div className="space-y-3">
                    <div className="flex items-center gap-3">
                        <a
                            href="/super-admin/verifikasi-bank-sampah"
                            className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200/80 text-slate-700 font-bold text-xs transition-colors active:scale-95"
                        >
                            <i className="bi bi-arrow-left" />
                            <span>Antrean Verifikasi</span>
                        </a>
                        <span className={`inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border ${badge.bg}`}>
                            <span className={`w-2 h-2 rounded-full ${badge.dot}`} />
                            <span>{badge.label}</span>
                        </span>
                    </div>

                    <div>
                        <div className="flex items-center gap-3">
                            <h1 className="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                {bankSampah.nama}
                            </h1>
                            <span className="px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 font-mono font-extrabold text-xs border border-slate-200">
                                {bankSampah.nomor_registrasi || bankSampah.kode_bank}
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1 flex items-center gap-2">
                            <i className="bi bi-calendar-event text-slate-400" />
                            <span>Diajukan pada {bankSampah.created_at || 'Baru saja'}</span>
                            <span>•</span>
                            <i className="bi bi-geo-alt text-emerald-600" />
                            <span>{bankSampah.desa}, {bankSampah.kecamatan}, {bankSampah.kabupaten || bankSampah.provinsi}</span>
                        </p>
                    </div>
                </div>

                {/* Right: Decision Action Buttons */}
                <div className="flex flex-wrap items-center gap-3">
                    {!isApproved && !isRejected && (
                        <>
                            <button
                                type="button"
                                onClick={onOpenScheduleModal}
                                className="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 font-bold text-xs transition-all active:scale-95 shadow-xs"
                            >
                                <i className="bi bi-calendar-plus-fill" />
                                <span>Atur Visitasi</span>
                            </button>

                            <button
                                type="button"
                                onClick={onOpenRecordResultModal}
                                className="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 font-bold text-xs transition-all active:scale-95 shadow-xs"
                            >
                                <i className="bi bi-clipboard-check-fill" />
                                <span>Catat Hasil</span>
                            </button>

                            <button
                                type="button"
                                onClick={onOpenRejectModal}
                                className="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-xs transition-all active:scale-95 shadow-xs"
                            >
                                <i className="bi bi-x-circle-fill" />
                                <span>Tolak</span>
                            </button>

                            <button
                                type="button"
                                onClick={onOpenApproveModal}
                                className="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs transition-all active:scale-95 shadow-md shadow-emerald-600/20"
                            >
                                <span>🎉</span>
                                <span>Setujui & Aktifkan Unit</span>
                            </button>
                        </>
                    )}

                    {isApproved && (
                        <div className="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-emerald-50 text-emerald-800 border border-emerald-200 font-extrabold text-xs">
                            <i className="bi bi-patch-check-fill text-emerald-600 text-base" />
                            <span>Unit Resmi Terdaftar & Aktif Beroperasi</span>
                        </div>
                    )}

                    {isRejected && (
                        <div className="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-rose-50 text-rose-800 border border-rose-200 font-extrabold text-xs">
                            <i className="bi bi-x-circle-fill text-rose-600 text-base" />
                            <span>Permohonan Ditolak</span>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}
