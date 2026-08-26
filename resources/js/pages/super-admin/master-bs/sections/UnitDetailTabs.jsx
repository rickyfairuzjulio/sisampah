import React, { useState } from 'react';

export default function UnitDetailTabs({
    unitDetail = {},
    admins = [],
    petugas = [],
    prices = [],
    transactions = [],
}) {
    const [activeTab, setActiveTab] = useState('profile');

    const tabs = [
        { key: 'profile', label: 'Profil Fisik & Operasional', icon: 'bi-building-fill' },
        { key: 'team', label: `Pengurus & Petugas (${admins.length + petugas.length})`, icon: 'bi-people-fill' },
        { key: 'prices', label: `Katalog Harga Unit (${prices.length})`, icon: 'bi-tags-fill' },
        { key: 'transactions', label: `Transaksi Terkini (${transactions.length})`, icon: 'bi-receipt-cutoff' },
    ];

    return (
        <div className="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden space-y-0">
            {/* Tab Navigation Header */}
            <div className="flex border-b border-slate-100 bg-slate-50/60 overflow-x-auto">
                {tabs.map((tab) => {
                    const isActive = activeTab === tab.key;
                    return (
                        <button
                            key={tab.key}
                            type="button"
                            onClick={() => setActiveTab(tab.key)}
                            className={`flex items-center gap-2 px-6 py-4 text-xs font-bold whitespace-nowrap transition-all border-b-2 ${
                                isActive
                                    ? 'border-emerald-600 text-emerald-800 bg-white shadow-2xs'
                                    : 'border-transparent text-slate-500 hover:text-slate-800 hover:bg-slate-100/60'
                            }`}
                        >
                            <i className={`bi ${tab.icon}`} />
                            <span>{tab.label}</span>
                        </button>
                    );
                })}
            </div>

            {/* Tab Contents */}
            <div className="p-6 md:p-7 text-xs">
                {/* ─── TAB 1: PROFIL FISIK & OPERASIONAL ─── */}
                {activeTab === 'profile' && (
                    <div className="space-y-6">
                        {unitDetail.deskripsi && (
                            <div className="p-4 rounded-2xl bg-slate-50 border border-slate-200/60 text-slate-700 leading-relaxed">
                                <span className="font-bold text-slate-900 block mb-1">Deskripsi Unit:</span>
                                {unitDetail.deskripsi}
                            </div>
                        )}

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {/* Alamat Fisik & Wilayah */}
                            <div className="p-5 rounded-2xl bg-slate-50/60 border border-slate-100 space-y-3">
                                <p className="font-extrabold text-slate-800 flex items-center gap-2">
                                    <i className="bi bi-geo-alt-fill text-emerald-600" />
                                    <span>Alamat Fisik & Cakupan Wilayah</span>
                                </p>
                                <div className="space-y-1.5 text-slate-600">
                                    <div className="flex justify-between py-1 border-b border-slate-200/40">
                                        <span className="text-slate-400">Alamat:</span>
                                        <span className="font-bold text-slate-800 text-right">{unitDetail.alamat}</span>
                                    </div>
                                    <div className="flex justify-between py-1 border-b border-slate-200/40">
                                        <span className="text-slate-400">Desa / Kelurahan:</span>
                                        <span className="font-bold text-slate-800">{unitDetail.desa}</span>
                                    </div>
                                    <div className="flex justify-between py-1 border-b border-slate-200/40">
                                        <span className="text-slate-400">Kecamatan:</span>
                                        <span className="font-bold text-slate-800">{unitDetail.kecamatan}</span>
                                    </div>
                                    <div className="flex justify-between py-1 border-b border-slate-200/40">
                                        <span className="text-slate-400">Kota / Kabupaten:</span>
                                        <span className="font-bold text-slate-800">{unitDetail.kabupaten}</span>
                                    </div>
                                    <div className="flex justify-between py-1">
                                        <span className="text-slate-400">Provinsi / Pos:</span>
                                        <span className="font-bold text-slate-800">{unitDetail.provinsi} ({unitDetail.kode_pos})</span>
                                    </div>
                                </div>
                            </div>

                            {/* Jadwal & Kontak (Read-Only) */}
                            <div className="p-5 rounded-2xl bg-slate-50/60 border border-slate-100 space-y-3">
                                <p className="font-extrabold text-slate-800 flex items-center gap-2">
                                    <i className="bi bi-clock-history text-indigo-600" />
                                    <span>Jadwal Operasional & Kontak PJ</span>
                                </p>
                                <div className="space-y-1.5 text-slate-600">
                                    <div className="flex justify-between py-1 border-b border-slate-200/40">
                                        <span className="text-slate-400">Penanggung Jawab:</span>
                                        <span className="font-bold text-slate-800">{unitDetail.penanggung_jawab}</span>
                                    </div>
                                    <div className="flex justify-between py-1 border-b border-slate-200/40">
                                        <span className="text-slate-400">WhatsApp PJ:</span>
                                        <a
                                            href={`https://wa.me/${(unitDetail.telepon_pj || '').replace(/[^0-9]/g, '')}`}
                                            target="_blank"
                                            rel="noreferrer"
                                            className="font-bold text-emerald-600 hover:underline flex items-center gap-1"
                                        >
                                            <i className="bi bi-whatsapp text-[10px]" />
                                            <span>{unitDetail.telepon_pj}</span>
                                        </a>
                                    </div>
                                    <div className="flex justify-between py-1 border-b border-slate-200/40">
                                        <span className="text-slate-400">Jam Layanan Unit:</span>
                                        <span className="font-bold text-slate-800">{unitDetail.jam_buka} - {unitDetail.jam_tutup} WIB</span>
                                    </div>
                                    <div className="flex justify-between py-1 border-b border-slate-200/40">
                                        <span className="text-slate-400">Hari Kerja:</span>
                                        <span className="font-bold text-slate-800">{unitDetail.hari_operasional}</span>
                                    </div>
                                    <div className="flex justify-between py-1">
                                        <span className="text-slate-400">Radius Jemput:</span>
                                        <span className="font-bold text-slate-800">{unitDetail.radius_layanan} Km</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                )}

                {/* ─── TAB 2: PENGURUS & PETUGAS ─── */}
                {activeTab === 'team' && (
                    <div className="space-y-6">
                        {/* Admin Unit */}
                        <div className="space-y-3">
                            <h3 className="font-black text-slate-900 text-sm flex items-center gap-2">
                                <i className="bi bi-shield-check text-emerald-600" />
                                <span>Akun Admin Unit Pengelola</span>
                            </h3>
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                {admins.map((adm) => (
                                    <div key={adm.id} className="p-4 rounded-2xl bg-emerald-50/40 border border-emerald-100 flex items-center justify-between">
                                        <div>
                                            <p className="font-black text-slate-900">{adm.name}</p>
                                            <p className="text-[11px] text-slate-500">{adm.email} • {adm.phone}</p>
                                        </div>
                                        <span className="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px]">
                                            Admin Unit
                                        </span>
                                    </div>
                                ))}
                            </div>
                        </div>

                        {/* Petugas Lapangan */}
                        <div className="space-y-3 pt-4 border-t border-slate-100">
                            <h3 className="font-black text-slate-900 text-sm flex items-center gap-2">
                                <i className="bi bi-truck text-indigo-600" />
                                <span>Petugas Timbangan & Jemput Sampah</span>
                            </h3>
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                {petugas.map((pet) => (
                                    <div key={pet.id} className="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                                        <div>
                                            <p className="font-bold text-slate-900">{pet.name}</p>
                                            <p className="text-[11px] text-slate-500">{pet.email} • {pet.phone}</p>
                                        </div>
                                        <span className="px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-800 font-extrabold text-[10px]">
                                            Petugas
                                        </span>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                )}

                {/* ─── TAB 3: KATALOG HARGA SAMPAH UNIT ─── */}
                {activeTab === 'prices' && (
                    <div className="space-y-4">
                        <div className="flex items-center justify-between">
                            <h3 className="font-black text-slate-900 text-sm">
                                Daftar Komoditas & Harga Beli Unit
                            </h3>
                            <span className="text-[11px] text-slate-400 font-medium">
                                *Ditetapkan mandiri oleh pengelola bank sampah
                            </span>
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            {prices.map((pr) => (
                                <div key={pr.id} className="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                                    <span className="text-[10px] uppercase font-bold text-slate-400">{pr.kategori}</span>
                                    <h4 className="font-extrabold text-slate-900 text-sm">{pr.nama}</h4>
                                    <p className="text-emerald-700 font-black text-base">{pr.harga_beli_formatted}</p>
                                </div>
                            ))}
                        </div>
                    </div>
                )}

                {/* ─── TAB 4: TRANSAKSI TERKINI ─── */}
                {activeTab === 'transactions' && (
                    <div className="space-y-3">
                        <h3 className="font-black text-slate-900 text-sm">
                            10 Transaksi Setoran Terkini
                        </h3>
                        <div className="divide-y divide-slate-100 border rounded-2xl border-slate-200 overflow-hidden">
                            {transactions.map((tr) => (
                                <div key={tr.id} className="p-3.5 flex items-center justify-between hover:bg-slate-50/60">
                                    <div className="space-y-0.5">
                                        <p className="font-bold text-slate-900">{tr.nasabah_name}</p>
                                        <p className="text-[11px] text-slate-500">
                                            {tr.category_name} ({tr.berat_kg} Kg) • Operator: {tr.petugas_name}
                                        </p>
                                    </div>
                                    <div className="text-right">
                                        <p className="font-extrabold text-emerald-700">{tr.total_rp_formatted}</p>
                                        <p className="text-[10px] text-slate-400">{tr.time_formatted}</p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
}
