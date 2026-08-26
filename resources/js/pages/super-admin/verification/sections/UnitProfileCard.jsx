import React from 'react';

export default function UnitProfileCard({ bankSampah = {} }) {
    return (
        <div className="bg-white rounded-3xl border border-slate-200/80 p-6 md:p-7 shadow-sm space-y-6">
            <div className="flex items-center justify-between pb-4 border-b border-slate-100">
                <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-lg font-black border border-emerald-200">
                        🏢
                    </div>
                    <div>
                        <h2 className="text-lg font-black text-slate-900 tracking-tight">
                            Profil Calon Unit Bank Sampah
                        </h2>
                        <p className="text-xs text-slate-500">
                            Data identitas dan wilayah cakupan operasional yang didaftarkan.
                        </p>
                    </div>
                </div>

                <span className="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-xl">
                    Radius: {bankSampah.radius_layanan || 5} Km
                </span>
            </div>

            {/* Description */}
            {bankSampah.deskripsi && (
                <div className="p-4 rounded-2xl bg-slate-50 border border-slate-200/60 text-xs text-slate-700 leading-relaxed">
                    <span className="font-bold text-slate-900 block mb-1">Deskripsi Singkat Unit:</span>
                    {bankSampah.deskripsi}
                </div>
            )}

            {/* Grid Detail Info */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs">
                {/* 1. Alamat & Wilayah */}
                <div className="space-y-3 p-4 rounded-2xl bg-slate-50/60 border border-slate-100">
                    <p className="font-extrabold text-slate-800 flex items-center gap-2">
                        <i className="bi bi-geo-alt-fill text-emerald-600" />
                        <span>Alamat & Lokasi Fisik</span>
                    </p>

                    <div className="space-y-1 text-slate-600">
                        <div className="flex justify-between py-1 border-b border-slate-200/40">
                            <span className="text-slate-400 font-medium">Alamat:</span>
                            <span className="font-bold text-slate-800 text-right max-w-[200px]">{bankSampah.alamat || '-'}</span>
                        </div>
                        <div className="flex justify-between py-1 border-b border-slate-200/40">
                            <span className="text-slate-400 font-medium">RT / RW:</span>
                            <span className="font-bold text-slate-800">RT {bankSampah.rt || '-'} / RW {bankSampah.rw || '-'}</span>
                        </div>
                        <div className="flex justify-between py-1 border-b border-slate-200/40">
                            <span className="text-slate-400 font-medium">Desa / Kelurahan:</span>
                            <span className="font-bold text-slate-800">{bankSampah.desa || '-'}</span>
                        </div>
                        <div className="flex justify-between py-1 border-b border-slate-200/40">
                            <span className="text-slate-400 font-medium">Kecamatan:</span>
                            <span className="font-bold text-slate-800">{bankSampah.kecamatan || '-'}</span>
                        </div>
                        <div className="flex justify-between py-1 border-b border-slate-200/40">
                            <span className="text-slate-400 font-medium">Kabupaten / Kota:</span>
                            <span className="font-bold text-slate-800">{bankSampah.kabupaten || '-'}</span>
                        </div>
                        <div className="flex justify-between py-1">
                            <span className="text-slate-400 font-medium">Provinsi / Kode Pos:</span>
                            <span className="font-bold text-slate-800">{bankSampah.provinsi || '-'} {bankSampah.kode_pos ? `(${bankSampah.kode_pos})` : ''}</span>
                        </div>
                    </div>
                </div>

                {/* 2. Kontak Penanggung Jawab & Operasional */}
                <div className="space-y-3 p-4 rounded-2xl bg-slate-50/60 border border-slate-100">
                    <p className="font-extrabold text-slate-800 flex items-center gap-2">
                        <i className="bi bi-person-badge-fill text-indigo-600" />
                        <span>Penanggung Jawab & Operasional</span>
                    </p>

                    <div className="space-y-1 text-slate-600">
                        <div className="flex justify-between py-1 border-b border-slate-200/40">
                            <span className="text-slate-400 font-medium">Nama PJ:</span>
                            <span className="font-bold text-slate-800">{bankSampah.penanggung_jawab || '-'}</span>
                        </div>
                        <div className="flex justify-between py-1 border-b border-slate-200/40">
                            <span className="text-slate-400 font-medium">WhatsApp / Telp:</span>
                            <a
                                href={`https://wa.me/${(bankSampah.telepon_pj || '').replace(/[^0-9]/g, '')}`}
                                target="_blank"
                                rel="noreferrer"
                                className="font-bold text-emerald-600 hover:underline flex items-center gap-1"
                            >
                                <i className="bi bi-whatsapp text-[10px]" />
                                <span>{bankSampah.telepon_pj || '-'}</span>
                            </a>
                        </div>
                        <div className="flex justify-between py-1 border-b border-slate-200/40">
                            <span className="text-slate-400 font-medium">Email PJ:</span>
                            <span className="font-bold text-slate-800">{bankSampah.email_pj || '-'}</span>
                        </div>
                        <div className="flex justify-between py-1 border-b border-slate-200/40">
                            <span className="text-slate-400 font-medium">Hari Operasional:</span>
                            <span className="font-bold text-slate-800">{bankSampah.hari_operasional || 'Senin - Sabtu'}</span>
                        </div>
                        <div className="flex justify-between py-1 border-b border-slate-200/40">
                            <span className="text-slate-400 font-medium">Jam Buka:</span>
                            <span className="font-bold text-slate-800">{bankSampah.jam_buka || '08:00'} - {bankSampah.jam_tutup || '16:00'} WIB</span>
                        </div>
                        <div className="flex justify-between py-1">
                            <span className="text-slate-400 font-medium">Titik Koordinat:</span>
                            <span className="font-mono text-[11px] text-slate-700 font-bold">
                                {bankSampah.latitude || '-'}, {bankSampah.longitude || '-'}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
