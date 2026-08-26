import React, { useState } from 'react';

export default function CreateBankSampahModal({
    isOpen,
    onClose,
    csrfToken = '',
}) {
    if (!isOpen) return null;

    const [nama, setNama] = useState('');
    const [pj, setPj] = useState('');
    const [telepon, setTelepon] = useState('');
    const [email, setEmail] = useState('');
    const [alamat, setAlamat] = useState('');
    const [desa, setDesa] = useState('');
    const [kecamatan, setKecamatan] = useState('');
    const [kabupaten, setKabupaten] = useState('');
    const [provinsi, setProvinsi] = useState('Jawa Tengah');
    const [kodePos, setKodePos] = useState('');
    const [radius, setRadius] = useState(5.0);
    const [latitude, setLatitude] = useState('-6.992823');
    const [longitude, setLongitude] = useState('110.354129');
    const [jamBuka, setJamBuka] = useState('08:00');
    const [jamTutup, setJamTutup] = useState('16:00');

    const handleGetLocation = () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    setLatitude(pos.coords.latitude.toFixed(6));
                    setLongitude(pos.coords.longitude.toFixed(6));
                },
                () => alert('Gagal membaca koordinat GPS dari browser.')
            );
        }
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div className="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col overflow-hidden scale-in duration-200">
                {/* Modal Header */}
                <div className="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/70 shrink-0">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-lg font-black border border-emerald-200">
                            🏢
                        </div>
                        <div>
                            <h3 className="text-base font-black text-slate-900">
                                Daftarkan Unit Bank Sampah Baru
                            </h3>
                            <p className="text-xs text-slate-500">
                                Tambahkan unit bank sampah resmi baru ke dalam database master nasional.
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

                {/* Form Body */}
                <form method="POST" action="/super-admin/master-bank-sampah" className="p-6 overflow-y-auto space-y-4 text-xs">
                    <input type="hidden" name="_token" value={csrfToken} />

                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1">
                            <label className="block font-bold text-slate-800">Nama Unit Bank Sampah *</label>
                            <input
                                type="text"
                                name="nama"
                                required
                                value={nama}
                                onChange={(e) => setNama(e.target.value)}
                                placeholder="Contoh: Bank Sampah Melati Asri"
                                className="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-emerald-400"
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
                                placeholder="Contoh: Hendra Gunawan"
                                className="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-emerald-400"
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
                                placeholder="081234567890"
                                className="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-emerald-400"
                            />
                        </div>

                        <div className="space-y-1">
                            <label className="block font-bold text-slate-800">Email PJ / Unit</label>
                            <input
                                type="email"
                                name="email_pj"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                                placeholder="admin.melati@sisampah.id"
                                className="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-emerald-400"
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
                            placeholder="Jl. Melati Raya No. 12, RT 01 / RW 02"
                            className="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-emerald-400"
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
                                placeholder="Sukamaju"
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
                                placeholder="Ngaliyan"
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
                                placeholder="Kota Semarang"
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
                                placeholder="Jawa Tengah"
                                className="w-full p-2 rounded-xl bg-slate-50 border border-slate-200 text-xs"
                            />
                        </div>
                    </div>

                    {/* Coordinates & Radius */}
                    <div className="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                        <div className="flex items-center justify-between">
                            <span className="font-bold text-slate-800 flex items-center gap-1.5">
                                <i className="bi bi-geo-alt-fill text-emerald-600" />
                                <span>Titik Koordinat GPS & Radius Layanan</span>
                            </span>
                            <button
                                type="button"
                                onClick={handleGetLocation}
                                className="text-[11px] font-bold text-emerald-700 hover:underline flex items-center gap-1"
                            >
                                <i className="bi bi-crosshair" />
                                <span>GPS Browser</span>
                            </button>
                        </div>

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

                    {/* Operational Hours */}
                    <div className="grid grid-cols-2 gap-3">
                        <div className="space-y-1">
                            <label className="block font-bold text-slate-800">Jam Buka Awal</label>
                            <input
                                type="text"
                                name="jam_buka"
                                value={jamBuka}
                                onChange={(e) => setJamBuka(e.target.value)}
                                placeholder="08:00"
                                className="w-full p-2 rounded-xl bg-slate-50 border border-slate-200 text-xs"
                            />
                        </div>
                        <div className="space-y-1">
                            <label className="block font-bold text-slate-800">Jam Tutup Awal</label>
                            <input
                                type="text"
                                name="jam_tutup"
                                value={jamTutup}
                                onChange={(e) => setJamTutup(e.target.value)}
                                placeholder="16:00"
                                className="w-full p-2 rounded-xl bg-slate-50 border border-slate-200 text-xs"
                            />
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
                            className="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold transition-all shadow-md shadow-emerald-600/20 active:scale-95 flex items-center gap-1.5"
                        >
                            <i className="bi bi-check-circle-fill text-xs" />
                            <span>Simpan & Daftarkan Unit</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
