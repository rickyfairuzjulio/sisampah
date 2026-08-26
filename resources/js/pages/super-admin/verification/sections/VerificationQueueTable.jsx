import React, { useState, useMemo } from 'react';

export default function VerificationQueueTable({
    registrations = [],
    stats = {},
    activeFilter = 'all',
    onSelectFilter,
}) {
    const [searchQuery, setSearchQuery] = useState('');

    const filterTabs = [
        { key: 'all', label: 'Semua Status', count: stats.all || registrations.length },
        { key: 'submitted', label: 'Permohonan Baru', count: stats.total_submitted || 0, color: 'text-sky-600' },
        { key: 'under_review', label: 'Sedang Ditinjau', count: stats.under_review || 0, color: 'text-amber-600' },
        { key: 'meeting_scheduled', label: 'Jadwal Pertemuan', count: stats.meeting_scheduled || 0, color: 'text-indigo-600' },
        { key: 'verified', label: 'Disetujui / Aktif', count: stats.verified || 0, color: 'text-emerald-600' },
        { key: 'rejected', label: 'Ditolak', count: stats.rejected || 0, color: 'text-rose-600' },
    ];

    const filteredData = useMemo(() => {
        return registrations.filter((item) => {
            // 1. Status Filter
            let matchStatus = true;
            if (activeFilter === 'submitted') matchStatus = item.status_verifikasi === 'submitted';
            else if (activeFilter === 'under_review') matchStatus = ['under_review', 'document_revision'].includes(item.status_verifikasi);
            else if (activeFilter === 'meeting_scheduled') matchStatus = item.status_verifikasi === 'meeting_scheduled';
            else if (activeFilter === 'verified') matchStatus = ['verified', 'active'].includes(item.status_verifikasi) || item.status === 'aktif';
            else if (activeFilter === 'rejected') matchStatus = item.status_verifikasi === 'rejected';

            // 2. Search Query Filter
            let matchSearch = true;
            if (searchQuery.trim() !== '') {
                const q = searchQuery.toLowerCase();
                matchSearch =
                    (item.nama && item.nama.toLowerCase().includes(q)) ||
                    (item.penanggung_jawab && item.penanggung_jawab.toLowerCase().includes(q)) ||
                    (item.nomor_registrasi && item.nomor_registrasi.toLowerCase().includes(q)) ||
                    (item.kabupaten && item.kabupaten.toLowerCase().includes(q)) ||
                    (item.desa && item.desa.toLowerCase().includes(q));
            }

            return matchStatus && matchSearch;
        });
    }, [registrations, activeFilter, searchQuery]);

    const getStatusBadge = (statusVerif, statusUnit) => {
        if (statusUnit === 'aktif' || statusVerif === 'verified') {
            return {
                label: 'Terverifikasi (Aktif)',
                bg: 'bg-emerald-50 text-emerald-700 border-emerald-200',
                dot: 'bg-emerald-500',
                icon: 'bi-check-circle-fill',
            };
        }
        switch (statusVerif) {
            case 'submitted':
                return {
                    label: 'Permohonan Baru',
                    bg: 'bg-sky-50 text-sky-700 border-sky-200',
                    dot: 'bg-sky-500',
                    icon: 'bi-inbox-fill',
                };
            case 'under_review':
                return {
                    label: 'Sedang Ditinjau',
                    bg: 'bg-amber-50 text-amber-700 border-amber-200',
                    dot: 'bg-amber-500',
                    icon: 'bi-hourglass-split',
                };
            case 'document_revision':
                return {
                    label: 'Revisi Berkas',
                    bg: 'bg-orange-50 text-orange-700 border-orange-200',
                    dot: 'bg-orange-500',
                    icon: 'bi-exclamation-triangle-fill',
                };
            case 'meeting_scheduled':
                return {
                    label: 'Jadwal Visitasi',
                    bg: 'bg-indigo-50 text-indigo-700 border-indigo-200',
                    dot: 'bg-indigo-500',
                    icon: 'bi-calendar-event-fill',
                };
            case 'rejected':
                return {
                    label: 'Ditolak',
                    bg: 'bg-rose-50 text-rose-700 border-rose-200',
                    dot: 'bg-rose-500',
                    icon: 'bi-x-circle-fill',
                };
            default:
                return {
                    label: 'Menunggu Review',
                    bg: 'bg-slate-50 text-slate-700 border-slate-200',
                    dot: 'bg-slate-400',
                    icon: 'bi-clock-fill',
                };
        }
    };

    return (
        <div className="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            {/* Header & Filter Controls */}
            <div className="p-6 md:p-7 border-b border-slate-100 space-y-5">
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 className="text-xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                            <span>Daftar Antrean Calon Mitra</span>
                            <span className="text-xs font-extrabold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                {filteredData.length} Calon Unit
                            </span>
                        </h2>
                        <p className="text-xs text-slate-500 mt-1">
                            Pilih salah satu unit untuk masuk ke workstation audit dokumen dan visitasi lapangan.
                        </p>
                    </div>

                    {/* Live Search Input */}
                    <div className="relative min-w-[260px] sm:w-72">
                        <i className="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm" />
                        <input
                            type="text"
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                            placeholder="Cari unit, PJ, no. reg..."
                            className="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200"
                        />
                        {searchQuery && (
                            <button
                                onClick={() => setSearchQuery('')}
                                className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs"
                            >
                                <i className="bi bi-x-circle-fill" />
                            </button>
                        )}
                    </div>
                </div>

                {/* Filter Tabs Pills */}
                <div className="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
                    {filterTabs.map((tab) => {
                        const isActive = activeFilter === tab.key;
                        return (
                            <button
                                key={tab.key}
                                onClick={() => onSelectFilter && onSelectFilter(tab.key)}
                                className={`flex items-center gap-2 px-4 py-2 rounded-2xl text-xs font-bold whitespace-nowrap transition-all duration-200 active:scale-95 ${
                                    isActive
                                        ? 'bg-slate-900 text-white shadow-sm'
                                        : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600'
                                }`}
                            >
                                <span>{tab.label}</span>
                                <span
                                    className={`px-2 py-0.5 rounded-full text-[10px] font-black ${
                                        isActive ? 'bg-white/20 text-white' : 'bg-white text-slate-700 shadow-2xs'
                                    }`}
                                >
                                    {tab.count}
                                </span>
                            </button>
                        );
                    })}
                </div>
            </div>

            {/* Table Area */}
            <div className="overflow-x-auto">
                <table className="w-full text-left border-collapse">
                    <thead>
                        <tr className="bg-slate-50/75 border-b border-slate-100 text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                            <th className="py-4 px-6">No. Registrasi</th>
                            <th className="py-4 px-6">Nama Unit Bank Sampah</th>
                            <th className="py-4 px-6">Penanggung Jawab & Kontak</th>
                            <th className="py-4 px-6">Dokumen Legalitas</th>
                            <th className="py-4 px-6">Status Pipeline</th>
                            <th className="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-100 text-xs">
                        {filteredData.length > 0 ? (
                            filteredData.map((item) => {
                                const badge = getStatusBadge(item.status_verifikasi, item.status);
                                return (
                                    <tr key={item.id} className="hover:bg-slate-50/80 transition-colors duration-150 group">
                                        {/* No Registrasi */}
                                        <td className="py-4 px-6 font-mono font-bold text-slate-700">
                                            <div className="flex flex-col">
                                                <span className="text-slate-900 font-extrabold">{item.nomor_registrasi}</span>
                                                <span className="text-[10px] text-slate-400 font-sans">{item.created_at_human}</span>
                                            </div>
                                        </td>

                                        {/* Nama Unit & Wilayah */}
                                        <td className="py-4 px-6">
                                            <div className="font-extrabold text-slate-900 text-sm group-hover:text-emerald-700 transition-colors">
                                                {item.nama}
                                            </div>
                                            <div className="text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5">
                                                <i className="bi bi-geo-alt-fill text-emerald-600 text-[10px]" />
                                                <span>
                                                    {item.desa ? `${item.desa}, ` : ''}{item.kecamatan ? `${item.kecamatan}, ` : ''}{item.kabupaten || item.provinsi}
                                                </span>
                                            </div>
                                        </td>

                                        {/* PJ & WA */}
                                        <td className="py-4 px-6">
                                            <div className="font-bold text-slate-800">{item.penanggung_jawab}</div>
                                            <div className="text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5">
                                                <i className="bi bi-whatsapp text-emerald-600 text-[10px]" />
                                                <a
                                                    href={`https://wa.me/${(item.telepon_pj || '').replace(/[^0-9]/g, '')}`}
                                                    target="_blank"
                                                    rel="noreferrer"
                                                    className="hover:underline font-mono text-[11px]"
                                                >
                                                    {item.telepon_pj || '-'}
                                                </a>
                                            </div>
                                        </td>

                                        {/* Dokumen Count */}
                                        <td className="py-4 px-6">
                                            <div className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 font-bold text-[11px] border border-slate-200">
                                                <i className="bi bi-file-earmark-check-fill text-emerald-600" />
                                                <span>{item.documents_count || 4}/4 Berkas Sah</span>
                                            </div>
                                        </td>

                                        {/* Status Badge */}
                                        <td className="py-4 px-6">
                                            <span className={`inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold border ${badge.bg}`}>
                                                <span className={`w-2 h-2 rounded-full ${badge.dot}`} />
                                                <span>{badge.label}</span>
                                            </span>
                                        </td>

                                        {/* Action Button */}
                                        <td className="py-4 px-6 text-right">
                                            <a
                                                href={`/super-admin/verifikasi-bank-sampah/${item.id}`}
                                                className="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition-all duration-200 shadow-sm hover:shadow active:scale-95"
                                            >
                                                <span>Audit & Periksa</span>
                                                <i className="bi bi-arrow-right text-[11px]" />
                                            </a>
                                        </td>
                                    </tr>
                                );
                            })
                        ) : (
                            <tr>
                                <td colSpan="6" className="py-12 px-6 text-center text-slate-400">
                                    <div className="flex flex-col items-center justify-center gap-2">
                                        <i className="bi bi-inbox text-4xl text-slate-300" />
                                        <p className="font-bold text-sm text-slate-600">Tidak ada permohonan yang sesuai kriteria filter.</p>
                                        <p className="text-xs text-slate-400">Coba ganti kata kunci pencarian atau tab status di atas.</p>
                                    </div>
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>
        </div>
    );
}
