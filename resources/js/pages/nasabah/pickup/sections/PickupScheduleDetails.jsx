import React, { useState } from 'react';
import { Home, Clock, MessageSquare, Truck, ArrowRight, ShieldCheck, AlertCircle } from 'lucide-react';

export default function PickupScheduleDetails({
    user = {},
    items = [],
    trashCategories = [],
    isSubmitting = false,
}) {
    const [alamatLengkap, setAlamatLengkap] = useState(user.alamat_lengkap || '');
    const [sesiWaktu, setSesiWaktu] = useState('pagi');
    const [catatan, setCatatan] = useState('');

    const totalWeight = items.reduce((sum, it) => sum + (parseFloat(it.perkiraan_berat) || 0), 0);
    const isWeightValid = totalWeight >= 5.0;

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
            
            {/* Step Header */}
            <div className="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                <div className="w-10 h-10 rounded-2xl bg-emerald-600 text-white font-black text-base flex items-center justify-center shrink-0 shadow-md">
                    3
                </div>
                <div>
                    <h3 className="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">
                        Alamat, Sesi Waktu & Catatan Penjemputan
                    </h3>
                    <p className="text-xs text-slate-500 mt-0.5">
                        Tentukan alamat detail patokan rumah dan waktu sesi kunjungan armada.
                    </p>
                </div>
            </div>

            <div className="space-y-5">
                
                {/* 1. Alamat Lengkap / Patokan Rumah */}
                <div>
                    <label htmlFor="alamat_lengkap" className="block text-xs font-bold text-slate-700 mb-1.5">
                        Alamat Lengkap / Patokan Rumah <span className="text-emerald-600">*</span>
                    </label>
                    <div className="relative">
                        <div className="absolute top-3 left-3.5 flex items-center pointer-events-none text-slate-400">
                            <Home className="w-4 h-4" />
                        </div>
                        <textarea
                            id="alamat_lengkap"
                            name="alamat_lengkap"
                            rows={3}
                            required
                            value={alamatLengkap}
                            onChange={(e) => setAlamatLengkap(e.target.value)}
                            placeholder="Jl. Melati No. 14, RT 03 / RW 05, Blok C (Pagar Hitam Depan Masjid Al-Hidayah)"
                            className="w-full pl-10 pr-4 py-3 bg-white text-slate-900 text-xs sm:text-sm font-medium border border-slate-200 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all resize-none shadow-2xs"
                        />
                    </div>
                </div>

                {/* 2. Pilihan Sesi Waktu Penjemputan */}
                <div>
                    <label className="block text-xs font-bold text-slate-700 mb-2">
                        Pilih Sesi Waktu Kunjungan Armada <span className="text-emerald-600">*</span>
                    </label>
                    
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        
                        {/* Sesi Pagi */}
                        <label 
                            onClick={() => setSesiWaktu('pagi')}
                            className={`p-4 rounded-2xl border-2 cursor-pointer transition-all flex items-center gap-3.5 shadow-2xs ${
                                sesiWaktu === 'pagi'
                                    ? 'bg-emerald-50/70 border-emerald-500 text-emerald-950 shadow-sm'
                                    : 'bg-white border-slate-200 text-slate-700 hover:border-slate-300'
                            }`}
                        >
                            <input 
                                type="radio" 
                                name="sesi_waktu" 
                                value="pagi" 
                                checked={sesiWaktu === 'pagi'} 
                                onChange={() => setSesiWaktu('pagi')}
                                className="hidden" 
                            />
                            <div className={`w-9 h-9 rounded-xl flex items-center justify-center font-bold shrink-0 ${
                                sesiWaktu === 'pagi' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-500'
                            }`}>
                                <Clock className="w-5 h-5" />
                            </div>
                            <div>
                                <h4 className="font-extrabold text-xs sm:text-sm">
                                    🌅 Sesi Pagi
                                </h4>
                                <p className="text-[11px] text-slate-500 mt-0.5">
                                    Pukul 08:30 - 11:30 WIB
                                </p>
                            </div>
                        </label>

                        {/* Sesi Siang */}
                        <label 
                            onClick={() => setSesiWaktu('siang')}
                            className={`p-4 rounded-2xl border-2 cursor-pointer transition-all flex items-center gap-3.5 shadow-2xs ${
                                sesiWaktu === 'siang'
                                    ? 'bg-emerald-50/70 border-emerald-500 text-emerald-950 shadow-sm'
                                    : 'bg-white border-slate-200 text-slate-700 hover:border-slate-300'
                            }`}
                        >
                            <input 
                                type="radio" 
                                name="sesi_waktu" 
                                value="siang" 
                                checked={sesiWaktu === 'siang'} 
                                onChange={() => setSesiWaktu('siang')}
                                className="hidden" 
                            />
                            <div className={`w-9 h-9 rounded-xl flex items-center justify-center font-bold shrink-0 ${
                                sesiWaktu === 'siang' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-500'
                            }`}>
                                <Clock className="w-5 h-5" />
                            </div>
                            <div>
                                <h4 className="font-extrabold text-xs sm:text-sm">
                                    ☀️ Sesi Siang
                                </h4>
                                <p className="text-[11px] text-slate-500 mt-0.5">
                                    Pukul 13:30 - 16:00 WIB
                                </p>
                            </div>
                        </label>

                    </div>
                </div>

                {/* 3. Catatan Tambahan untuk Driver */}
                <div>
                    <label htmlFor="catatan" className="block text-xs font-bold text-slate-700 mb-1.5">
                        Catatan Tambahan untuk Petugas / Driver (Opsional)
                    </label>
                    <div className="relative">
                        <div className="absolute top-3 left-3.5 flex items-center pointer-events-none text-slate-400">
                            <MessageSquare className="w-4 h-4" />
                        </div>
                        <textarea
                            id="catatan"
                            name="catatan"
                            rows={2}
                            value={catatan}
                            onChange={(e) => setCatatan(e.target.value)}
                            placeholder="Contoh: Sampah diletakkan di dalam 2 karung goni di garasi, harap hubungi via WA saat sampai gerbang komplek."
                            className="w-full pl-10 pr-4 py-2.5 sm:py-3 bg-white text-slate-900 text-xs sm:text-sm font-medium border border-slate-200 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all resize-none shadow-2xs"
                        />
                    </div>
                </div>

            </div>

            {/* Submit Action Box */}
            <div className="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div className="flex items-center gap-2 text-xs text-slate-500 text-center sm:text-left">
                    <ShieldCheck className="w-4 h-4 text-emerald-600 shrink-0" />
                    <span>Petugas membawa timbangan digital resmi terkalibrasi.</span>
                </div>

                <button
                    type="submit"
                    disabled={!isWeightValid || isSubmitting}
                    className="w-full sm:w-auto px-8 py-3.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 disabled:bg-slate-300 disabled:cursor-not-allowed text-white font-bold text-xs sm:text-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2.5 hover:-translate-y-0.5 cursor-pointer"
                >
                    <Truck className="w-4 h-4" />
                    <span>{isSubmitting ? 'Mengirim Permintaan...' : 'Konfirmasi & Kirim Pesanan Jemput'}</span>
                    <ArrowRight className="w-4 h-4" />
                </button>
            </div>

        </div>
    );
}
