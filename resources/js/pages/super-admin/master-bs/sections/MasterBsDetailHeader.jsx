import React from 'react';

export default function MasterBsDetailHeader({
    unitDetail = {},
    onOpenEditModal,
    onOpenStatusModal,
    onDeleteUnit,
}) {
    const getStatusBadge = (status) => {
        switch (status) {
            case 'aktif':
                return {
                    label: 'Aktif Beroperasi',
                    bg: 'bg-emerald-100 text-emerald-800 border-emerald-300',
                    dot: 'bg-emerald-500',
                };
            case 'libur':
                return {
                    label: 'Libur Sementara',
                    bg: 'bg-amber-100 text-amber-800 border-amber-300',
                    dot: 'bg-amber-500',
                };
            case 'nonaktif':
            default:
                return {
                    label: 'Nonaktif / Suspend',
                    bg: 'bg-rose-100 text-rose-800 border-rose-300',
                    dot: 'bg-rose-500',
                };
        }
    };

    const badge = getStatusBadge(unitDetail.status);

    return (
        <div className="bg-white rounded-3xl border border-slate-200/80 p-6 md:p-7 shadow-sm">
            <div className="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                {/* Left: Back Link & Unit Title */}
                <div className="space-y-3">
                    <div className="flex items-center gap-3">
                        <a
                            href="/super-admin/master-bank-sampah"
                            className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200/80 text-slate-700 font-bold text-xs transition-colors active:scale-95"
                        >
                            <i className="bi bi-arrow-left" />
                            <span>Direktori Master Data</span>
                        </a>
                        <span className={`inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border ${badge.bg}`}>
                            <span className={`w-2 h-2 rounded-full ${badge.dot}`} />
                            <span>{badge.label}</span>
                        </span>
                    </div>

                    <div>
                        <div className="flex items-center gap-3">
                            <h1 className="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                {unitDetail.nama}
                            </h1>
                            <span className="px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 font-mono font-extrabold text-xs border border-slate-200">
                                {unitDetail.kode_bank}
                            </span>
                        </div>
                        <p className="text-xs text-slate-500 mt-1 flex items-center gap-2">
                            <i className="bi bi-geo-alt-fill text-emerald-600" />
                            <span>{unitDetail.alamat}, {unitDetail.desa}, {unitDetail.kecamatan}, {unitDetail.kabupaten}</span>
                            <span>•</span>
                            <span className="font-mono text-slate-400">Lat: {unitDetail.latitude}, Lng: {unitDetail.longitude}</span>
                        </p>
                    </div>
                </div>

                {/* Right: Actions */}
                <div className="flex flex-wrap items-center gap-3">
                    <a
                        href="/super-admin/peta-sebaran"
                        className="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all active:scale-95"
                    >
                        <i className="bi bi-map-fill text-emerald-600" />
                        <span>Lihat di Peta</span>
                    </a>

                    <button
                        type="button"
                        onClick={onOpenStatusModal}
                        className="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 font-bold text-xs transition-all active:scale-95 shadow-xs"
                    >
                        <i className="bi bi-shield-lock-fill" />
                        <span>Ubah Status</span>
                    </button>

                    <button
                        type="button"
                        onClick={onOpenEditModal}
                        className="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 font-bold text-xs transition-all active:scale-95 shadow-xs"
                    >
                        <i className="bi bi-pencil-fill" />
                        <span>Edit Profil</span>
                    </button>

                    <button
                        type="button"
                        onClick={onDeleteUnit}
                        className="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-xs transition-all active:scale-95"
                        title="Hapus Unit"
                    >
                        <i className="bi bi-trash3-fill" />
                    </button>
                </div>
            </div>
        </div>
    );
}
