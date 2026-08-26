import React from 'react';

export default function UnitMapDrawer({
    unit = null,
    onClose,
}) {
    if (!unit) {
        return (
            <div className="h-full bg-white rounded-3xl border border-slate-200/80 p-8 flex flex-col items-center justify-center text-center space-y-3">
                <div className="w-16 h-16 rounded-3xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl border border-emerald-100">
                    🗺️
                </div>
                <h3 className="font-black text-slate-900 text-sm">
                    Pilih Titik Bank Sampah di Peta
                </h3>
                <p className="text-xs text-slate-400 max-w-xs leading-relaxed">
                    Klik salah satu pin marker di peta interaktif untuk melihat profil operasional, kontak PJ, dan statistik cakupan radius wilayah.
                </p>
            </div>
        );
    }

    const getStatusBadge = (status) => {
        switch (status) {
            case 'aktif':
                return { label: 'Aktif Beroperasi', bg: 'bg-emerald-100 text-emerald-800 border-emerald-300' };
            case 'libur':
                return { label: 'Libur Sementara', bg: 'bg-amber-100 text-amber-800 border-amber-300' };
            case 'nonaktif':
            default:
                return { label: 'Nonaktif / Suspend', bg: 'bg-rose-100 text-rose-800 border-rose-300' };
        }
    };

    const badge = getStatusBadge(unit.status);

    return (
        <div className="h-full bg-white rounded-3xl border border-slate-200/80 p-6 flex flex-col justify-between shadow-sm space-y-5">
            <div className="space-y-4">
                {/* Header Unit */}
                <div className="flex items-start justify-between gap-3">
                    <div className="space-y-1">
                        <span className="font-mono text-[10px] font-extrabold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-200">
                            {unit.kode_bank}
                        </span>
                        <h2 className="font-black text-slate-900 text-base leading-snug">
                            {unit.nama}
                        </h2>
                    </div>

                    <button
                        type="button"
                        onClick={onClose}
                        className="w-7 h-7 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center shrink-0 transition-colors"
                    >
                        <i className="bi bi-x-lg text-xs" />
                    </button>
                </div>

                {/* Status Badge */}
                <div className="flex items-center gap-2">
                    <span className={`inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border ${badge.bg}`}>
                        <span>{badge.label}</span>
                    </span>
                    <span className="text-[11px] font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">
                        Radius: {unit.radius_layanan || 5} Km
                    </span>
                </div>

                {/* Alamat Fisik */}
                <div className="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5 text-xs text-slate-600">
                    <p className="font-extrabold text-slate-900 flex items-center gap-1.5">
                        <i className="bi bi-geo-alt-fill text-emerald-600" />
                        <span>Lokasi Fisik Unit</span>
                    </p>
                    <p className="leading-snug">{unit.alamat}, {unit.desa}, {unit.kecamatan}, {unit.kabupaten}</p>
                    <p className="font-mono text-[11px] text-slate-400">
                        Lat: {unit.latitude} • Lng: {unit.longitude}
                    </p>
                </div>

                {/* Penanggung Jawab & WhatsApp */}
                <div className="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2 text-xs">
                    <div className="flex justify-between items-center">
                        <span className="text-slate-500">Penanggung Jawab:</span>
                        <span className="font-bold text-slate-900">{unit.penanggung_jawab}</span>
                    </div>
                    <div className="flex justify-between items-center">
                        <span className="text-slate-500">WhatsApp PJ:</span>
                        <a
                            href={`https://wa.me/${(unit.telepon_pj || '').replace(/[^0-9]/g, '')}`}
                            target="_blank"
                            rel="noreferrer"
                            className="font-bold text-emerald-600 hover:underline flex items-center gap-1"
                        >
                            <i className="bi bi-whatsapp text-xs" />
                            <span>{unit.telepon_pj || '-'}</span>
                        </a>
                    </div>
                    <div className="flex justify-between items-center">
                        <span className="text-slate-500">Jam Layanan:</span>
                        <span className="font-bold text-slate-800">{unit.jam_buka || '08:00'} - {unit.jam_tutup || '16:00'} WIB</span>
                    </div>
                </div>

                {/* Metrik Komunitas */}
                <div className="grid grid-cols-2 gap-2 text-center text-xs">
                    <div className="p-3 rounded-2xl bg-sky-50/70 border border-sky-100">
                        <span className="text-[10px] font-bold text-sky-600 block">Warga Terlayani</span>
                        <span className="font-black text-slate-900 text-sm">{unit.nasabah_count || 0} Warga</span>
                    </div>
                    <div className="p-3 rounded-2xl bg-indigo-50/70 border border-indigo-100">
                        <span className="text-[10px] font-bold text-indigo-600 block">Petugas Armada</span>
                        <span className="font-black text-slate-900 text-sm">{unit.petugas_count || 0} Petugas</span>
                    </div>
                </div>
            </div>

            {/* Bottom Button */}
            <div className="pt-2">
                <a
                    href={`/super-admin/master-bank-sampah/${unit.id}`}
                    className="w-full inline-flex items-center justify-center gap-2 p-3 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs transition-all active:scale-95 shadow-md shadow-slate-900/10"
                >
                    <span>Buka di Master Bank Sampah</span>
                    <i className="bi bi-arrow-right text-xs" />
                </a>
            </div>
        </div>
    );
}
