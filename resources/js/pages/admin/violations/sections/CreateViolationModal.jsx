import React, { useState } from 'react';
import { X, AlertTriangle, ShieldAlert, CheckCircle2, ArrowRight } from 'lucide-react';

export default function CreateViolationModal({
    isOpen,
    onClose,
}) {
    if (!isOpen) return null;

    const [userName, setUserName] = useState('');
    const [userRole, setUserRole] = useState('Warga Nasabah');
    const [phone, setPhone] = useState('');
    const [type, setType] = useState('unsegregated');
    const [description, setDescription] = useState('');
    const [sanction, setSanction] = useState('Teguran Lisan 1 + Edukasi Pemilahan');
    const [isSubmitting, setIsSubmitting] = useState(false);

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsSubmitting(true);

        setTimeout(() => {
            alert('Catatan pelanggaran berhasil disimpan ke dalam audit log.');
            setIsSubmitting(false);
            onClose();
            window.location.reload();
        }, 500);
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fade-in select-none">
            
            <div className="relative w-full max-w-lg bg-white border border-slate-200 rounded-3xl shadow-2xl overflow-hidden animate-slide-in">
                
                {/* Header */}
                <div className="p-6 bg-gradient-to-r from-amber-600 to-rose-700 text-white flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center font-bold">
                            <AlertTriangle className="w-5 h-5" />
                        </div>
                        <div>
                            <h3 className="font-black text-lg text-white tracking-tight">
                                Catat Kejadian Pelanggaran ⚠️
                            </h3>
                            <p className="text-xs text-white/80">
                                Rekam ketidaksesuaian operasional ke dalam audit trail
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        onClick={onClose}
                        className="p-2 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-colors cursor-pointer"
                    >
                        <X className="w-5 h-5" />
                    </button>
                </div>

                {/* Form */}
                <form onSubmit={handleSubmit} className="p-6 space-y-4">
                    
                    {/* Nama Warga / Petugas & No HP */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Nama Pihak Terkait</label>
                            <input
                                type="text"
                                value={userName}
                                onChange={(e) => setUserName(e.target.value)}
                                required
                                placeholder="Contoh: Budi Santoso (RT 02)"
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-amber-600"
                            />
                        </div>

                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Nomor Telepon / WhatsApp</label>
                            <input
                                type="text"
                                value={phone}
                                onChange={(e) => setPhone(e.target.value)}
                                placeholder="081234567890"
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-amber-600"
                            />
                        </div>
                    </div>

                    {/* Jenis Pelanggaran */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Jenis Pelanggaran</label>
                        <select
                            value={type}
                            onChange={(e) => setType(e.target.value)}
                            className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-amber-600 cursor-pointer"
                        >
                            <option value="unsegregated">Sampah Tidak Terpilah / Tercampur Residu Basah</option>
                            <option value="suspicious">Transaksi Anomali (&gt;100kg / &gt;Rp 1.000.000)</option>
                            <option value="missed_pickup">Ketidakhadiran Jadwal Jemput Tanpa Konfirmasi</option>
                            <option value="hazardous">Limbah Berbahaya / B3 Tanpa Pengaman</option>
                        </select>
                    </div>

                    {/* Deskripsi Kronologi */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Kronologi & Deskripsi Kejadian</label>
                        <textarea
                            value={description}
                            onChange={(e) => setDescription(e.target.value)}
                            required
                            rows={3}
                            placeholder="Jelaskan detail ketidaksesuaian yang ditemukan saat penimbangan atau penjemputan..."
                            className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-900 focus:outline-amber-600 resize-none"
                        />
                    </div>

                    {/* Tindakan / Sanksi */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Tindakan / Sanksi yang Diberikan</label>
                        <input
                            type="text"
                            value={sanction}
                            onChange={(e) => setSanction(e.target.value)}
                            required
                            placeholder="Contoh: Teguran Lisan 1 + Pengurangan 50 Poin"
                            className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-amber-600"
                        />
                    </div>

                    {/* Actions */}
                    <div className="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button
                            type="button"
                            onClick={onClose}
                            className="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            disabled={isSubmitting}
                            className="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-black transition-all shadow-md flex items-center gap-2 cursor-pointer disabled:opacity-50"
                        >
                            {isSubmitting ? (
                                <>
                                    <CheckCircle2 className="w-4 h-4 text-white animate-spin" />
                                    <span>Menyimpan...</span>
                                </>
                            ) : (
                                <>
                                    <span>Simpan Catatan</span>
                                    <ArrowRight className="w-4 h-4" />
                                </>
                            )}
                        </button>
                    </div>

                </form>

            </div>

        </div>
    );
}
