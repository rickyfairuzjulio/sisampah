import React, { useState } from 'react';

export default function DocumentAuditCard({
    documents = [],
    bankSampah = {},
    csrfToken = '',
    onUpdateDocStatus,
}) {
    const [activeDocForRevision, setActiveDocForRevision] = useState(null);
    const [revisionNote, setRevisionNote] = useState('');

    const handleApproveDoc = (doc) => {
        if (onUpdateDocStatus) {
            onUpdateDocStatus(doc.id, 'approved', 'Dokumen sah dan terverifikasi valid.');
        }
    };

    const handleRejectDoc = (doc) => {
        if (onUpdateDocStatus) {
            onUpdateDocStatus(doc.id, 'rejected', 'Dokumen tidak valid atau tidak memenuhi syarat.');
        }
    };

    const submitRevision = (docId) => {
        if (!revisionNote.trim()) {
            alert('Silakan tuliskan catatan revisi dokumen.');
            return;
        }
        if (onUpdateDocStatus) {
            onUpdateDocStatus(docId, 'revision_requested', revisionNote);
        }
        setActiveDocForRevision(null);
        setRevisionNote('');
    };

    const getDocIcon = (type) => {
        switch (type) {
            case 'sk_pendirian':
                return { icon: 'bi-file-earmark-ruled-fill', color: 'text-indigo-600 bg-indigo-50 border-indigo-200' };
            case 'ktp_pj':
                return { icon: 'bi-person-vcard-fill', color: 'text-amber-600 bg-amber-50 border-amber-200' };
            case 'foto_lokasi':
                return { icon: 'bi-building-fill-check', color: 'text-emerald-600 bg-emerald-50 border-emerald-200' };
            default:
                return { icon: 'bi-credit-card-2-front-fill', color: 'text-sky-600 bg-sky-50 border-sky-200' };
        }
    };

    const getReviewBadge = (status) => {
        switch (status) {
            case 'approved':
                return {
                    label: 'Sah / Terverifikasi',
                    bg: 'bg-emerald-100 text-emerald-800 border-emerald-300',
                    icon: 'bi-check-circle-fill text-emerald-600',
                };
            case 'revision_requested':
                return {
                    label: 'Diminta Revisi',
                    bg: 'bg-amber-100 text-amber-800 border-amber-300',
                    icon: 'bi-exclamation-triangle-fill text-amber-600',
                };
            case 'rejected':
                return {
                    label: 'Ditolak',
                    bg: 'bg-rose-100 text-rose-800 border-rose-300',
                    icon: 'bi-x-circle-fill text-rose-600',
                };
            default:
                return {
                    label: 'Menunggu Audit',
                    bg: 'bg-slate-100 text-slate-700 border-slate-300',
                    icon: 'bi-clock-fill text-slate-500',
                };
        }
    };

    return (
        <div className="bg-white rounded-3xl border border-slate-200/80 p-6 md:p-7 shadow-sm space-y-6">
            <div className="flex items-center justify-between pb-4 border-b border-slate-100">
                <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center text-lg font-black border border-indigo-200">
                        📑
                    </div>
                    <div>
                        <h2 className="text-lg font-black text-slate-900 tracking-tight">
                            Audit Dokumen & Legalitas Mitra
                        </h2>
                        <p className="text-xs text-slate-500">
                            Periksa keaslian dokumen SK, KTP, dan kelayakan fasilitas sebelum memberikan otorisasi.
                        </p>
                    </div>
                </div>

                <span className="text-xs font-extrabold text-indigo-700 bg-indigo-50 px-3 py-1 rounded-xl border border-indigo-200">
                    {documents.filter((d) => d.status_review === 'approved').length} / {documents.length} Disetujui
                </span>
            </div>

            {/* Document Items List */}
            <div className="space-y-4">
                {documents.map((doc, idx) => {
                    const docStyle = getDocIcon(doc.jenis_dokumen);
                    const reviewBadge = getReviewBadge(doc.status_review);
                    const isRevising = activeDocForRevision === doc.id;

                    return (
                        <div
                            key={doc.id || idx}
                            className={`p-5 rounded-2xl border transition-all duration-200 ${
                                doc.status_review === 'approved'
                                    ? 'bg-emerald-50/20 border-emerald-200'
                                    : doc.status_review === 'revision_requested'
                                    ? 'bg-amber-50/20 border-amber-200'
                                    : 'bg-slate-50/70 border-slate-200'
                            }`}
                        >
                            <div className="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                {/* Doc Title & File Info */}
                                <div className="flex items-start gap-3.5">
                                    <div className={`w-11 h-11 rounded-2xl flex items-center justify-center text-xl shrink-0 border ${docStyle.color}`}>
                                        <i className={`bi ${docStyle.icon}`} />
                                    </div>
                                    <div className="space-y-1">
                                        <div className="flex flex-wrap items-center gap-2">
                                            <h3 className="font-extrabold text-slate-900 text-sm">
                                                {doc.nama_dokumen || `Dokumen ${doc.jenis_dokumen}`}
                                            </h3>
                                            <span className={`inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold border ${reviewBadge.bg}`}>
                                                <i className={`bi ${reviewBadge.icon}`} />
                                                <span>{reviewBadge.label}</span>
                                            </span>
                                        </div>

                                        <p className="text-xs text-slate-500">
                                            Format: <strong className="text-slate-700">{doc.file_type || 'PDF'}</strong> • Ukuran: <strong className="text-slate-700">{doc.file_size || '1.5 MB'}</strong>
                                        </p>

                                        {doc.catatan && (
                                            <div className="mt-2 p-2.5 rounded-xl bg-white border border-slate-200/80 text-xs text-slate-700">
                                                <span className="font-bold text-slate-900">Catatan Super Admin: </span>
                                                {doc.catatan}
                                            </div>
                                        )}
                                    </div>
                                </div>

                                {/* Right: File View & Actions */}
                                <div className="flex flex-wrap items-center gap-2 self-end sm:self-start shrink-0">
                                    {doc.file_url && doc.file_url !== '#' ? (
                                        <a
                                            href={doc.file_url}
                                            target="_blank"
                                            rel="noreferrer"
                                            className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs border border-slate-200 transition-colors shadow-2xs"
                                        >
                                            <i className="bi bi-box-arrow-up-right text-[11px]" />
                                            <span>Lihat Berkas</span>
                                        </a>
                                    ) : (
                                        <button
                                            type="button"
                                            onClick={() => alert(`Simulasi membuka berkas: ${doc.nama_dokumen}`)}
                                            className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs border border-slate-200 transition-colors shadow-2xs"
                                        >
                                            <i className="bi bi-eye-fill text-[11px]" />
                                            <span>Pratinjau Berkas</span>
                                        </button>
                                    )}

                                    {/* Action Buttons */}
                                    <button
                                        type="button"
                                        onClick={() => handleApproveDoc(doc)}
                                        className="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition-colors shadow-xs"
                                        title="Sahkan Dokumen"
                                    >
                                        <i className="bi bi-check-lg" />
                                        <span>Sah</span>
                                    </button>

                                    <button
                                        type="button"
                                        onClick={() => {
                                            setActiveDocForRevision(isRevising ? null : doc.id);
                                            setRevisionNote(doc.catatan || '');
                                        }}
                                        className="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs transition-colors shadow-xs"
                                        title="Minta Revisi Dokumen"
                                    >
                                        <i className="bi bi-pencil-square" />
                                        <span>Revisi</span>
                                    </button>

                                    <button
                                        type="button"
                                        onClick={() => handleRejectDoc(doc)}
                                        className="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs transition-colors shadow-xs"
                                        title="Tolak Dokumen"
                                    >
                                        <i className="bi bi-x-lg" />
                                    </button>
                                </div>
                            </div>

                            {/* Inline Revision Form */}
                            {isRevising && (
                                <div className="mt-4 pt-4 border-t border-slate-200/80 space-y-3">
                                    <label className="block text-xs font-bold text-slate-800">
                                        Tuliskan Instruksi Revisi Berkas untuk Calon Pengelola:
                                    </label>
                                    <textarea
                                        rows={2}
                                        value={revisionNote}
                                        onChange={(e) => setRevisionNote(e.target.value)}
                                        placeholder="Contoh: Dokumen SK belum memiliki stempel basah kelurahan. Mohon unggah ulang SK berstempel resmi."
                                        className="w-full p-3 rounded-xl bg-white border border-amber-300 text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-400"
                                    />
                                    <div className="flex items-center justify-between">
                                        <p className="text-[11px] text-amber-700 flex items-center gap-1 font-semibold">
                                            <i className="bi bi-whatsapp" />
                                            <span>Notifikasi WhatsApp otomatis akan disiapkan untuk pengelola.</span>
                                        </p>
                                        <div className="flex items-center gap-2">
                                            <button
                                                type="button"
                                                onClick={() => setActiveDocForRevision(null)}
                                                className="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs"
                                            >
                                                Batal
                                            </button>
                                            <button
                                                type="button"
                                                onClick={() => submitRevision(doc.id)}
                                                className="px-4 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow-xs"
                                            >
                                                Kirim Permintaan Revisi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            )}
                        </div>
                    );
                })}
            </div>
        </div>
    );
}
