import React, { useState } from 'react';
import { User, Mail, Phone, MapPin, Save, CheckCircle2, AlertCircle } from 'lucide-react';

export default function PetugasInfoForm({
    user = {},
    csrfToken = '',
    sessionStatus = '',
    errors = {},
    avatarFile = null,
}) {
    const [name, setName] = useState(user?.name || '');
    const [email, setEmail] = useState(user?.email || '');
    const [phone, setPhone] = useState(user?.nomor_telepon || '');
    const [address, setAddress] = useState(user?.alamat_lengkap || '');
    const [isSaving, setIsSaving] = useState(false);

    return (
        <form
            action="/profile"
            method="POST"
            encType="multipart/form-data"
            onSubmit={() => setIsSaving(true)}
            className="bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-5 select-none transition-colors duration-200"
        >
            <input type="hidden" name="_token" value={csrfToken} />
            <input type="hidden" name="_method" value="PATCH" />

            <div className="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <div className="flex items-center gap-2.5">
                    <div className="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 flex items-center justify-center font-black text-sm">
                        <User className="w-4 h-4" />
                    </div>
                    <div>
                        <h3 className="font-black text-base text-slate-900 dark:text-white tracking-tight">
                            Informasi Pribadi & Kontak
                        </h3>
                        <p className="text-xs text-slate-500 dark:text-slate-400">
                            Perbarui nama lengkap, nomor WhatsApp, dan alamat petugas
                        </p>
                    </div>
                </div>
            </div>

            {sessionStatus && (
                <div className="p-3.5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/80 text-emerald-800 dark:text-emerald-300 text-xs font-bold flex items-center gap-2">
                    <CheckCircle2 className="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" />
                    <span>{sessionStatus}</span>
                </div>
            )}

            <div className="space-y-4">
                
                {/* Nama Lengkap */}
                <div className="space-y-1.5">
                    <label className="block text-xs font-bold text-slate-700 dark:text-slate-300">
                        Nama Lengkap Petugas <span className="text-rose-500">*</span>
                    </label>
                    <div className="relative">
                        <input
                            type="text"
                            name="name"
                            value={name}
                            onChange={(e) => setName(e.target.value)}
                            required
                            placeholder="Contoh: Budi Santoso"
                            className={`w-full px-4 py-2.5 rounded-xl border ${
                                errors?.name ? 'border-rose-300 bg-rose-50/20' : 'border-slate-300 dark:border-slate-700 bg-white dark:bg-[#0D131F]'
                            } text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs placeholder-slate-400 dark:placeholder-slate-500`}
                        />
                    </div>
                    {errors?.name && (
                        <p className="text-[11px] font-bold text-rose-600 flex items-center gap-1">
                            <AlertCircle className="w-3 h-3" /> {errors.name}
                        </p>
                    )}
                </div>

                {/* Email & Phone Grid */}
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    {/* Email */}
                    <div className="space-y-1.5">
                        <label className="block text-xs font-bold text-slate-700 dark:text-slate-300">
                            Alamat Email <span className="text-rose-500">*</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            required
                            placeholder="petugas@sisampah.id"
                            className={`w-full px-4 py-2.5 rounded-xl border ${
                                errors?.email ? 'border-rose-300 bg-rose-50/20' : 'border-slate-300 dark:border-slate-700 bg-white dark:bg-[#0D131F]'
                            } text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs placeholder-slate-400 dark:placeholder-slate-500`}
                        />
                        {errors?.email && (
                            <p className="text-[11px] font-bold text-rose-600 flex items-center gap-1">
                                <AlertCircle className="w-3 h-3" /> {errors.email}
                            </p>
                        )}
                    </div>

                    {/* Nomor WhatsApp */}
                    <div className="space-y-1.5">
                        <label className="block text-xs font-bold text-slate-700 dark:text-slate-300">
                            Nomor WhatsApp / HP <span className="text-rose-500">*</span>
                        </label>
                        <input
                            type="tel"
                            name="nomor_telepon"
                            value={phone}
                            onChange={(e) => setPhone(e.target.value)}
                            placeholder="081234567890"
                            className="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-[#0D131F] text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs placeholder-slate-400 dark:placeholder-slate-500"
                        />
                    </div>

                </div>

                {/* Alamat Lengkap */}
                <div className="space-y-1.5">
                    <label className="block text-xs font-bold text-slate-700 dark:text-slate-300">
                        Alamat Lengkap Domisili
                    </label>
                    <textarea
                        name="alamat_lengkap"
                        rows="2"
                        value={address}
                        onChange={(e) => setAddress(e.target.value)}
                        placeholder="Jl. Melati No. 4, RT 01/RW 02..."
                        className="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-[#0D131F] text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs placeholder-slate-400 dark:placeholder-slate-500"
                    ></textarea>
                </div>

            </div>

            {/* Submit Button */}
            <div className="pt-2 flex justify-end">
                <button
                    type="submit"
                    disabled={isSaving}
                    className="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-xl font-bold text-xs shadow-sm hover:shadow transition-all flex items-center gap-2 cursor-pointer"
                >
                    <Save className="w-3.5 h-3.5" />
                    <span>{isSaving ? 'Menyimpan...' : 'Simpan Perubahan Profil'}</span>
                </button>
            </div>

        </form>
    );
}
