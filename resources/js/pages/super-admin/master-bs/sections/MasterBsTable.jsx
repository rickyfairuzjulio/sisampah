import React from 'react';

export default function MasterBsTable({
    bankSampahs = [],
    onOpenEditModal,
    onOpenStatusModal,
}) {
    const getStatusBadge = (status) => {
        switch (status) {
            case 'aktif':
                return {
                    label: 'Aktif Beroperasi',
                    bg: 'bg-emerald-50 text-emerald-800 border-emerald-300',
                    dot: 'bg-emerald-500',
                };
            case 'libur':
                return {
                    label: 'Libur Sementara',
                    bg: 'bg-amber-50 text-amber-800 border-amber-300',
                    dot: 'bg-amber-500',
                };
            case 'nonaktif':
            default:
                return {
                    label: 'Nonaktif / Suspend',
                    bg: 'bg-rose-50 text-rose-800 border-rose-300',
                    dot: 'bg-rose-500',
                };
        }
    };

    if (bankSampahs.length === 0) {
        return (
            <div className="bg-white rounded-3xl border border-slate-200/80 p-12 text-center space-y-3">
                <div className="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto">
                    🏢
                </div>
                <h3 className="text-base font-black text-slate-800">
                    Tidak Ditemukan Unit Bank Sampah
                </h3>
                <p className="text-xs text-slate-500 max-w-sm mx-auto">
                    Tidak ada unit bank sampah yang sesuai dengan filter atau kata kunci pencarian Anda.
                </p>
            </div>
        );
    }

    return (
        <div className="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
            <div className="overflow-x-auto">
                <table className="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr className="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-black uppercase tracking-wider text-slate-500">
                            <th className="py-4 px-5">Kode & Unit</th>
                            <th className="py-4 px-5">Wilayah & Radius</th>
                            <th className="py-4 px-5">Penanggung Jawab</th>
                            <th className="py-4 px-5">Statistik Unit</th>
                            <th className="py-4 px-5 text-center">Status</th>
                            <th className="py-4 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-100 font-medium text-slate-700">
                        {bankSampahs.map((bs) => {
                            const badge = getStatusBadge(bs.status);
                            return (
                                <tr key={bs.id} className="hover:bg-slate-50/60 transition-colors group">
                                    {/* 1. Kode & Unit */}
                                    <td className="py-4 px-5">
                                        <div className="space-y-1">
                                            <span className="font-mono text-[11px] font-extrabold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-200">
                                                {bs.kode_bank}
                                            </span>
                                            <a
                                                href={`/super-admin/master-bank-sampah/${bs.id}`}
                                                className="block font-black text-slate-900 hover:text-emerald-700 text-sm tracking-tight transition-colors"
                                            >
                                                {bs.nama}
                                            </a>
                                            <p className="text-[11px] text-slate-400">
                                                Gabung: {bs.created_at_formatted || '12 Jan 2025'}
                                            </p>
                                        </div>
                                    </td>

                                    {/* 2. Wilayah & Radius */}
                                    <td className="py-4 px-5">
                                        <div className="space-y-1">
                                            <p className="font-bold text-slate-800 flex items-center gap-1">
                                                <i className="bi bi-geo-alt-fill text-emerald-600 text-xs" />
                                                <span>{bs.kecamatan}, {bs.kabupaten}</span>
                                            </p>
                                            <p className="text-[11px] text-slate-500">
                                                {bs.desa}, {bs.provinsi}
                                            </p>
                                            <span className="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-[10px] font-extrabold text-slate-600">
                                                <i className="bi bi-broadcast text-[9px]" />
                                                <span>Radius: {bs.radius_layanan} Km</span>
                                            </span>
                                        </div>
                                    </td>

                                    {/* 3. Penanggung Jawab */}
                                    <td className="py-4 px-5">
                                        <div className="space-y-1">
                                            <p className="font-bold text-slate-900">{bs.penanggung_jawab}</p>
                                            <a
                                                href={`https://wa.me/${(bs.telepon_pj || '').replace(/[^0-9]/g, '')}`}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="text-[11px] text-emerald-600 hover:underline flex items-center gap-1 font-semibold"
                                            >
                                                <i className="bi bi-whatsapp text-[10px]" />
                                                <span>{bs.telepon_pj || '-'}</span>
                                            </a>
                                            <p className="text-[10px] text-slate-400 truncate max-w-[140px]">
                                                {bs.email_pj || '-'}
                                            </p>
                                        </div>
                                    </td>

                                    {/* 4. Statistik Unit */}
                                    <td className="py-4 px-5">
                                        <div className="space-y-1">
                                            <p className="text-[11px] text-slate-800 font-bold flex items-center gap-1.5">
                                                <i className="bi bi-people-fill text-sky-600" />
                                                <span>{bs.nasabah_count} Warga</span>
                                                <span className="text-slate-300">•</span>
                                                <i className="bi bi-truck text-indigo-600" />
                                                <span>{bs.petugas_count} Petugas</span>
                                            </p>
                                            <p className="text-[11px] text-slate-600 font-medium">
                                                Sampah: <strong className="text-slate-900">{bs.total_berat_ton || '38 Ton'}</strong>
                                            </p>
                                            <p className="text-[11px] text-emerald-700 font-bold">
                                                Kas: {bs.kas_unit_formatted || 'Rp 18.750.000'}
                                            </p>
                                        </div>
                                    </td>

                                    {/* 5. Status Badge */}
                                    <td className="py-4 px-5 text-center">
                                        <span className={`inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border ${badge.bg}`}>
                                            <span className={`w-1.5 h-1.5 rounded-full ${badge.dot}`} />
                                            <span>{badge.label}</span>
                                        </span>
                                    </td>

                                    {/* 6. Aksi Cepat */}
                                    <td className="py-4 px-5 text-right">
                                        <div className="inline-flex items-center gap-1.5">
                                            <a
                                                href={`/super-admin/master-bank-sampah/${bs.id}`}
                                                className="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition-colors"
                                                title="Lihat Detail & Profil Unit"
                                            >
                                                <i className="bi bi-eye-fill text-xs" />
                                            </a>

                                            <button
                                                type="button"
                                                onClick={() => onOpenEditModal(bs)}
                                                className="p-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold transition-colors"
                                                title="Edit Profil Unit"
                                            >
                                                <i className="bi bi-pencil-fill text-xs" />
                                            </button>

                                            <button
                                                type="button"
                                                onClick={() => onOpenStatusModal(bs)}
                                                className="p-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold transition-colors"
                                                title="Ubah Status Kemitraan"
                                            >
                                                <i className="bi bi-shield-lock-fill text-xs" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            );
                        })}
                    </tbody>
                </table>
            </div>
        </div>
    );
}
