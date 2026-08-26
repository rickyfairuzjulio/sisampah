import React, { useState, useEffect } from 'react';
import { X, Edit3, Users, Truck, CheckCircle2, ArrowRight, Phone, MapPin } from 'lucide-react';

export default function EditUserModal({
    isOpen,
    onClose,
    user = null,
}) {
    if (!isOpen || !user) return null;

    const [name, setName] = useState(user.name || '');
    const [phone, setPhone] = useState(user.phone || '');
    const [rtRw, setRtRw] = useState(user.rt_rw || 'RT 01 / RW 02');
    const [address, setAddress] = useState(user.address || '');
    const [isActive, setIsActive] = useState(user.is_active ?? true);
    const [isSubmitting, setIsSubmitting] = useState(false);

    useEffect(() => {
        if (user) {
            setName(user.name || '');
            setPhone(user.phone || '');
            setRtRw(user.rt_rw || 'RT 01 / RW 02');
            setAddress(user.address || '');
            setIsActive(user.is_active ?? true);
        }
    }, [user]);

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsSubmitting(true);

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${user.id}`;

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrf;
        form.appendChild(csrfInput);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        const fields = {
            name: name,
            nomor_telepon: phone,
            alamat: address,
            is_active: isActive ? 1 : 0,
        };

        Object.entries(fields).forEach(([k, v]) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = k;
            input.value = v;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    };

    const isPetugas = user.role === 'petugas';

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fade-in select-none">
            
            <div className="relative w-full max-w-md bg-white border border-slate-200 rounded-3xl shadow-2xl overflow-hidden animate-slide-in">
                
                {/* Header */}
                <div className={`p-6 text-white flex items-center justify-between ${
                    isPetugas ? 'bg-gradient-to-r from-blue-600 to-indigo-700' : 'bg-gradient-to-r from-emerald-600 to-teal-700'
                }`}>
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center font-bold">
                            <Edit3 className="w-5 h-5" />
                        </div>
                        <div>
                            <h3 className="font-black text-lg text-white tracking-tight">
                                Edit Informasi Pengguna
                            </h3>
                            <p className="text-xs text-white/80">
                                {user.name} ({user.role_label})
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
                    
                    {/* Name */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Nama Lengkap</label>
                        <input
                            type="text"
                            value={name}
                            onChange={(e) => setName(e.target.value)}
                            required
                            className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-emerald-600"
                        />
                    </div>

                    {/* Phone */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Nomor Telepon / WhatsApp</label>
                        <input
                            type="text"
                            value={phone}
                            onChange={(e) => setPhone(e.target.value)}
                            required
                            className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-emerald-600"
                        />
                    </div>

                    {/* Address */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700">Alamat Domisili</label>
                        <input
                            type="text"
                            value={address}
                            onChange={(e) => setAddress(e.target.value)}
                            className="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-emerald-600"
                        />
                    </div>

                    {/* Active Status Switch */}
                    <div className="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div>
                            <span className="text-xs font-bold text-slate-800 block">Status Keaktifan Akun</span>
                            <span className="text-[10px] text-slate-500">Pengguna nonaktif tidak dapat login ke sistem</span>
                        </div>
                        <button
                            type="button"
                            onClick={() => setIsActive(!isActive)}
                            className={`w-12 h-6 rounded-full transition-colors p-1 cursor-pointer flex items-center ${
                                isActive ? 'bg-emerald-600 justify-end' : 'bg-slate-300 justify-start'
                            }`}
                        >
                            <div className="w-4 h-4 rounded-full bg-white shadow-md" />
                        </button>
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
                            className="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black transition-all shadow-md flex items-center gap-2 cursor-pointer disabled:opacity-50"
                        >
                            {isSubmitting ? (
                                <>
                                    <CheckCircle2 className="w-4 h-4 text-white animate-spin" />
                                    <span>Menyimpan...</span>
                                </>
                            ) : (
                                <>
                                    <span>Simpan Perubahan</span>
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
