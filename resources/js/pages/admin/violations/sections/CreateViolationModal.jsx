import React, { useState } from 'react';
import { X, AlertTriangle, ShieldAlert, CheckCircle2, ArrowRight, AlertCircle, Upload } from 'lucide-react';

export default function CreateViolationModal({
    isOpen,
    onClose,
    usersDropdown = [],
    csrfToken = '',
    onSuccess,
}) {
    if (!isOpen) return null;

    const [selectedUserId, setSelectedUserId] = useState('');
    const [userName, setUserName] = useState('');
    const [userRole, setUserRole] = useState('Warga Nasabah');
    const [phone, setPhone] = useState('');
    const [type, setType] = useState('unsegregated');
    const [description, setDescription] = useState('');
    const [sanction, setSanction] = useState('Teguran Lisan 1 + Pengurangan 50 Poin');
    const [penaltyPoints, setPenaltyPoints] = useState(50);
    const [buktiFoto, setBuktiFoto] = useState(null);
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [errorMessage, setErrorMessage] = useState('');

    const handleUserSelect = (e) => {
        const val = e.target.value;
        setSelectedUserId(val);
        const found = usersDropdown.find((u) => u.id.toString() === val);
        if (found) {
            setUserName(found.name);
            setUserRole(found.role_label || 'Warga Nasabah');
            setPhone(found.phone || '');
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsSubmitting(true);
        setErrorMessage('');

        const formData = new FormData();
        if (selectedUserId) formData.append('user_id', selectedUserId);
        formData.append('user_name', userName);
        formData.append('user_role', userRole);
        formData.append('phone', phone);
        formData.append('tipe', type);
        formData.append('deskripsi', description);
        formData.append('sanksi', sanction);
        formData.append('poin_penalti', penaltyPoints);
        if (buktiFoto) {
            formData.append('bukti_foto', buktiFoto);
        }

        try {
            const token = csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const response = await fetch('/admin/pelanggaran', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token || '',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const resData = await response.json();
            if (response.ok && resData.success) {
                if (onSuccess) onSuccess(resData.message);
                onClose();
            } else {
                setErrorMessage(resData.message || 'Gagal menyimpan catatan pelanggaran.');
            }
        } catch (err) {
            console.error('Error reporting violation:', err);
            setErrorMessage('Terjadi kesalahan jaringan.');
        } finally {
            setIsSubmitting(false);
        }
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
                                Rekam ketidaksesuaian operasional ke dalam audit trail database
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
                <form onSubmit={handleSubmit} className="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                    {errorMessage && (
                        <div className="p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl flex items-center gap-2 font-medium">
                            <AlertCircle className="w-4 h-4 shrink-0" />
                            <span>{errorMessage}</span>
                        </div>
                    )}

                    {/* Pilih Cepat Pengguna Terdaftar */}
                    {usersDropdown.length > 0 && (
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Pilih dari Warga/Petugas Terdaftar (Opsional)</label>
                            <select
                                value={selectedUserId}
                                onChange={handleUserSelect}
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-900 focus:outline-amber-600"
                            >
                                <option value="">-- Ketik manual atau pilih dari daftar --</option>
                                {usersDropdown.map((u) => (
                                    <option key={u.id} value={u.id}>
                                        {u.name} ({u.role_label})
                                    </option>
                                ))}
                            </select>
                        </div>
                    )}
                    
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
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Jenis Pelanggaran</label>
                            <select
                                value={type}
                                onChange={(e) => setType(e.target.value)}
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-amber-600 cursor-pointer"
                            >
                                <option value="unsegregated">Sampah Tidak Terpilah / Residu Basah</option>
                                <option value="suspicious">Transaksi Anomali (&gt;100kg / &gt;Rp 1 jt)</option>
                                <option value="missed_pickup">Ketidakhadiran Jadwal Jemput</option>
                                <option value="hazardous_material">Limbah Berbahaya / Pecahan B3</option>
                                <option value="other">Pelanggaran Lainnya</option>
                            </select>
                        </div>

                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-slate-700">Poin Penalti Reward</label>
                            <input
                                type="number"
                                min="0"
                                max="500"
                                value={penaltyPoints}
                                onChange={(e) => setPenaltyPoints(parseInt(e.target.value, 10) || 0)}
                                placeholder="50"
                                className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:outline-amber-600"
                            />
                        </div>
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

                    {/* Upload Bukti Foto */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Upload Foto Bukti Temuan (Opsional)</label>
                        <input
                            type="file"
                            accept="image/*"
                            onChange={(e) => setBuktiFoto(e.target.files[0])}
                            className="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 file:mr-3 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100"
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
                                    <span>Menyimpan ke Database...</span>
                                </>
                            ) : (
                                <>
                                    <span>Simpan Catatan Pelanggaran</span>
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
