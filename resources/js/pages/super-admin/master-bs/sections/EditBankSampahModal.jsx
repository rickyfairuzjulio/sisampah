import React, { useState, useEffect } from 'react';

export default function EditBankSampahModal({
    isOpen,
    onClose,
    bankSampah = null,
    csrfToken = '',
}) {
    if (!isOpen || !bankSampah) return null;

    const [nama, setNama] = useState(bankSampah.nama || '');
    const [pj, setPj] = useState(bankSampah.penanggung_jawab || '');
    const [telepon, setTelepon] = useState(bankSampah.telepon_pj || '');
    const [email, setEmail] = useState(bankSampah.email_pj || '');
    const [alamat, setAlamat] = useState(bankSampah.alamat || '');
    const [desa, setDesa] = useState(bankSampah.desa || '');
    const [kecamatan, setKecamatan] = useState(bankSampah.kecamatan || '');
    const [kabupaten, setKabupaten] = useState(bankSampah.kabupaten || '');
    const [provinsi, setProvinsi] = useState(bankSampah.provinsi || '');
    const [kodePos, setKodePos] = useState(bankSampah.kode_pos || '');
    const [radius, setRadius] = useState(bankSampah.radius_layanan || 5.0);
    const [latitude, setLatitude] = useState(bankSampah.latitude || '-6.992823');
    const [longitude, setLongitude] = useState(bankSampah.longitude || '110.354129');

    useEffect(() => {
        if (bankSampah) {
            setNama(bankSampah.nama || '');
            setPj(bankSampah.penanggung_jawab || '');
            setTelepon(bankSampah.telepon_pj || '');
            setEmail(bankSampah.email_pj || '');
            setAlamat(bankSampah.alamat || '');
            setDesa(bankSampah.desa || '');
            setKecamatan(bankSampah.kecamatan || '');
            setKabupaten(bankSampah.kabupaten || '');
            setProvinsi(bankSampah.provinsi || '');
            setKodePos(bankSampah.kode_pos || '');
            setRadius(bankSampah.radius_layanan || 5.0);
            setLatitude(bankSampah.latitude || '-6.992823');
            setLongitude(bankSampah.longitude || '110.354129');
        }
    }, [bankSampah]);

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div className="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col overflow-hidden scale-in duration-200">
                {/* Header */}
                <div className="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/70 shrink-0">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center text-lg font-black border border-indigo-200">
                            ✏️
                        </div>
                        <div>
                            <h3 className="text-base font-black text-slate-900">
                                Edit Profil Unit: {bankSampah.nama}
                            </h3>
                            <p className="text-xs text-slate-500">
                                Perbarui data administratif, titik koordinat, dan wilayah operasional unit.
                            </p>
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

                {/* Form */}
                <form
                    method="POST"
                    action={`/super-admin/master-bank-sampah/${bankSampah.id}`}
                    className="p-6 overflow-y-auto space-y-4 text-xs"
                >
                    <input type="hidden" name="_token" value={csrfToken} />
                    <input type="hidden" name="_method" value="PUT" />

                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1">
                            <label className="block font-bold text-slate-800">Nama Unit Bank Sampah *</label>
                            <input
                                type="text"
                                name="nama"
                                required
                                value={nama}
                                onChange={(e) => setNama(e.target.value)}
                                className="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-indigo-400"
                            />
                        </div>

                        <div className="space-y-1">
                            <label className="block font-bold text-slate-800">Nama Penanggung Jawab (PJ) *</label>
                            <input
                                type="text"
                                name="penanggung_jawab"
                                required
                                value={pj}
                                onChange={(e) => setPj(e.target.value)}
                                className="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-indigo-400"
                            />
                        </div>

                        <div className="space-y-1">
                            <label className="block font-bold text-slate-800">Nomor WhatsApp PJ *</label>
                            <input
                                type="text"
                                name="telepon_pj"
                                required
                                value={telepon}
                                onChange={(e) => setTelepon(e.target.value)}
                                className="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-indigo-400"
                            />
                        </div>

                        <div className="space-y-1">
                            <label className="block font-bold text-slate-800">Email PJ / Unit</label>
                            <input
                                type="email"
                                name="email_pj"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                                className="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-indigo-400"
                            />
                        </div>
                    </div>

                    <div className="space-y-1">
                        <label className="block font-bold text-slate-800">Alamat Lengkap Unit *</label>
                        <textarea
                            name="alamat"
                            required
                            rows={2}
                            value={alamat}
                            onChange={(e) => setAlamat(e.target.value)}
                            className="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-indigo-400"
                        />
                    </div>

                    <div className="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div className="space-y-1">
                            <label className="block font-bold text-slate-800">Desa/Kelurahan</label>
                            <input
                                type="text"
                                name="desa"
                                value={desa}
                                onChange={(e) => setDesa(e.target.value)}
                                className="w-full p-2 rounded-xl bg-slate-50 border border-slate-200 text-xs"
                            />
                        </div>
                        <div className="space-y-1">
                            <label className="block font-bold text-slate-800">Kecamatan</label>
                            <input
                                type="text"
                                name="kecamatan"
                                value={kecamatan}
                                onChange={(e) => setKecamatan(e.target.value)}
                                className="w-full p-2 rounded-xl bg-slate-50 border border-slate-200 text-xs"
                            />
                        </div>
                        <div className="space-y-1">
                            <label className="block font-bold text-slate-800">Kota/Kabupaten</label>
                            <input
                                type="text"
                                name="kabupaten"
                                value={kabupaten}
                                onChange={(e) => setKabupaten(e.target.value)}
                                className="w-full p-2 rounded-xl bg-slate-50 border border-slate-200 text-xs"
                            />
                        </div>
                        <div className="space-y-1">
                            <label className="block font-bold text-slate-800">Provinsi</label>
                            <input
                                type="text"
                                name="provinsi"
                                value={provinsi}
                                onChange={(e) => setProvinsi(e.target.value)}
                                className="w-full p-2 rounded-xl bg-slate-50 border border-slate-200 text-xs"
                            />
                        </div>
                    </div>

                    {/* Coordinates & Radius */}
                    <div className="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                        <div className="grid grid-cols-3 gap-3">
                            <div className="space-y-1">
                                <label className="block text-[11px] text-slate-500 font-semibold">Latitude</label>
                                <input
                                    type="text"
                                    name="latitude"
                                    required
                                    value={latitude}
                                    onChange={(e) => setLatitude(e.target.value)}
                                    className="w-full p-2 rounded-lg bg-white border border-slate-200 font-mono text-xs"
                                />
                            </div>
                            <div className="space-y-1">
                                <label className="block text-[11px] text-slate-500 font-semibold">Longitude</label>
                                <input
                                    type="text"
                                    name="longitude"
                                    required
                                    value={longitude}
                                    onChange={(e) => setLongitude(e.target.value)}
                                    className="w-full p-2 rounded-lg bg-white border border-slate-200 font-mono text-xs"
                                />
                            </div>
                            <div className="space-y-1">
                                <label className="block text-[11px] text-slate-500 font-semibold">Radius Jemput (Km)</label>
                                <input
                                    type="number"
                                    step="0.1"
                                    name="radius_layanan"
                                    value={radius}
                                    onChange={(e) => setRadius(e.target.value)}
                                    className="w-full p-2 rounded-lg bg-white border border-slate-200 text-xs font-bold"
                                />
                            </div>
                        </div>
                    </div>

                    {/* Actions */}
                    <div className="pt-2 flex items-center justify-end gap-3 shrink-0">
                        <button
                            type="button"
                            onClick={onClose}
                            className="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition-colors"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            className="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold transition-all shadow-md shadow-indigo-600/20 active:scale-95 flex items-center gap-1.5"
                        >
                            <i className="bi bi-check-circle-fill text-xs" />
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
