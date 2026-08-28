import React, { useState, useRef } from 'react';
import { User, Mail, Phone, Home, MapPin, CheckCircle2, Upload, AlertCircle, Save } from 'lucide-react';

export default function PersonalInfoForm({
    user = {},
    csrfToken = '',
    errors = {},
}) {
    const [name, setName] = useState(user.name || '');
    const [email, setEmail] = useState(user.email || '');
    const [nomorTelepon, setNomorTelepon] = useState(user.nomor_telepon || '');
    const [rt, setRt] = useState(user.rt || '');
    const [rw, setRw] = useState(user.rw || '');
    const [alamatLengkap, setAlamatLengkap] = useState(user.alamat_lengkap || '');
    const [avatarPreview, setAvatarPreview] = useState(user.avatar_url || null);
    const [isSubmitting, setIsSubmitting] = useState(false);

    const fileInputRef = useRef(null);

    const handleFileChange = (e) => {
        const file = e.target.files?.[0];
        if (file) {
            const url = URL.createObjectURL(file);
            setAvatarPreview(url);
        }
    };

    const triggerFileInput = () => {
        fileInputRef.current?.click();
    };

    const nameError = errors?.name;
    const emailError = errors?.email;
    const phoneError = errors?.nomor_telepon;
    const avatarError = errors?.avatar;

    return (
        <div className="bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6 transition-colors duration-200">
            
            {/* Header Section */}
            <div className="flex items-center gap-3.5 pb-5 border-b border-slate-100 dark:border-slate-800">
                <div className="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/80 flex items-center justify-center font-bold shrink-0">
                    <User className="w-5 h-5" />
                </div>
                <div>
                    <h2 className="font-extrabold text-base sm:text-lg text-slate-900 dark:text-white tracking-tight">
                        Informasi Data Pribadi
                    </h2>
                    <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Perbarui identitas diri, kontak, dan alamat domisili untuk layanan penjemputan sampah.
                    </p>
                </div>
            </div>

            {/* Native Laravel Form for Profile Update */}
            <form 
                method="POST" 
                action="/profile" 
                encType="multipart/form-data"
                onSubmit={() => setIsSubmitting(true)}
                className="space-y-6"
            >
                <input type="hidden" name="_token" value={csrfToken} />
                <input type="hidden" name="_method" value="PATCH" />

                {/* 1. Avatar Upload Box */}
                <div className="p-4 sm:p-5 rounded-2xl bg-slate-50 dark:bg-[#0D131F] border border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center gap-5 justify-between">
                    <div className="flex items-center gap-4">
                        <div className="w-16 h-16 rounded-2xl bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-2xs shrink-0 flex items-center justify-center">
                            <img 
                                src={avatarPreview || `https://ui-avatars.com/api/?name=${encodeURIComponent(name || 'Nasabah')}&background=025e36&color=fff&size=128&bold=true`} 
                                alt={name}
                                className="w-full h-full object-cover"
                            />
                        </div>
                        <div>
                            <h4 className="font-bold text-xs sm:text-sm text-slate-900 dark:text-white">
                                Foto Profil Akun
                            </h4>
                            <p className="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">
                                Format JPG, PNG, atau WebP. Maksimal 2MB.
                            </p>
                        </div>
                    </div>

                    <input 
                        type="file" 
                        name="avatar" 
                        ref={fileInputRef} 
                        onChange={handleFileChange} 
                        accept="image/*" 
                        className="hidden" 
                    />

                    <button
                        type="button"
                        onClick={triggerFileInput}
                        className="px-4 py-2 bg-white dark:bg-[#111827] hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 rounded-xl font-bold text-xs shadow-2xs flex items-center gap-2 transition-colors cursor-pointer"
                    >
                        <Upload className="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" />
                        <span>Pilih Gambar Baru</span>
                    </button>
                </div>
                {avatarError && (
                    <p className="text-xs font-semibold text-rose-500">{avatarError}</p>
                )}

                {/* 2. Grid Form Fields */}
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    
                    {/* Nama Lengkap */}
                    <div>
                        <label htmlFor="name" className="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Nama Lengkap <span className="text-emerald-600 dark:text-emerald-400">*</span>
                        </label>
                        <div className="relative">
                            <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <User className="w-4 h-4" />
                            </div>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                required
                                value={name}
                                onChange={(e) => setName(e.target.value)}
                                placeholder="Ahmad Fauzi"
                                className="w-full pl-10 pr-4 py-2.5 sm:py-3 bg-white dark:bg-[#0D131F] text-slate-900 dark:text-white text-xs sm:text-sm font-medium border border-slate-200 dark:border-slate-800 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all placeholder-slate-400 dark:placeholder-slate-500"
                            />
                        </div>
                        {nameError && (
                            <p className="mt-1 text-xs font-semibold text-rose-500">{nameError}</p>
                        )}
                    </div>

                    {/* Alamat Email */}
                    <div>
                        <div className="flex items-center justify-between mb-1.5">
                            <label htmlFor="email" className="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                Alamat Email <span className="text-emerald-600 dark:text-emerald-400">*</span>
                            </label>
                            {user.email_verified && (
                                <span className="inline-flex items-center gap-1 text-[10px] font-extrabold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-full border border-emerald-200 dark:border-emerald-800/80">
                                    <CheckCircle2 className="w-3 h-3 text-emerald-600 dark:text-emerald-400" />
                                    <span>Terverifikasi</span>
                                </span>
                            )}
                        </div>
                        <div className="relative">
                            <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <Mail className="w-4 h-4" />
                            </div>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                required
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                                placeholder="nama@email.com"
                                className="w-full pl-10 pr-4 py-2.5 sm:py-3 bg-white dark:bg-[#0D131F] text-slate-900 dark:text-white text-xs sm:text-sm font-medium border border-slate-200 dark:border-slate-800 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all placeholder-slate-400 dark:placeholder-slate-500"
                            />
                        </div>
                        {emailError && (
                            <p className="mt-1 text-xs font-semibold text-rose-500">{emailError}</p>
                        )}
                    </div>

                    {/* Nomor WhatsApp */}
                    <div>
                        <label htmlFor="nomor_telepon" className="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Nomor Telepon / WhatsApp
                        </label>
                        <div className="relative">
                            <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <Phone className="w-4 h-4" />
                            </div>
                            <input
                                id="nomor_telepon"
                                name="nomor_telepon"
                                type="text"
                                value={nomorTelepon}
                                onChange={(e) => setNomorTelepon(e.target.value)}
                                placeholder="0812-3456-7890"
                                className="w-full pl-10 pr-4 py-2.5 sm:py-3 bg-white dark:bg-[#0D131F] text-slate-900 dark:text-white text-xs sm:text-sm font-medium border border-slate-200 dark:border-slate-800 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all placeholder-slate-400 dark:placeholder-slate-500"
                            />
                        </div>
                        {phoneError && (
                            <p className="mt-1 text-xs font-semibold text-rose-500">{phoneError}</p>
                        )}
                    </div>

                    {/* RT & RW (2 Mini Columns) */}
                    <div className="grid grid-cols-2 gap-3">
                        <div>
                            <label htmlFor="rt" className="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                Rukun Tetangga (RT)
                            </label>
                            <input
                                id="rt"
                                name="rt"
                                type="text"
                                value={rt}
                                onChange={(e) => setRt(e.target.value)}
                                placeholder="03"
                                className="w-full px-3.5 py-2.5 sm:py-3 bg-white dark:bg-[#0D131F] text-slate-900 dark:text-white text-xs sm:text-sm font-medium border border-slate-200 dark:border-slate-800 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-center placeholder-slate-400 dark:placeholder-slate-500"
                            />
                        </div>

                        <div>
                            <label htmlFor="rw" className="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                Rukun Warga (RW)
                            </label>
                            <input
                                id="rw"
                                name="rw"
                                type="text"
                                value={rw}
                                onChange={(e) => setRw(e.target.value)}
                                placeholder="05"
                                className="w-full px-3.5 py-2.5 sm:py-3 bg-white dark:bg-[#0D131F] text-slate-900 dark:text-white text-xs sm:text-sm font-medium border border-slate-200 dark:border-slate-800 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-center placeholder-slate-400 dark:placeholder-slate-500"
                            />
                        </div>
                    </div>

                    {/* Alamat Lengkap Domisili (Full Width) */}
                    <div className="sm:col-span-2">
                        <label htmlFor="alamat_lengkap" className="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Alamat Lengkap / Patokan Rumah
                        </label>
                        <div className="relative">
                            <textarea
                                id="alamat_lengkap"
                                name="alamat_lengkap"
                                rows={3}
                                value={alamatLengkap}
                                onChange={(e) => setAlamatLengkap(e.target.value)}
                                placeholder="Jl. Melati No. 14, RT 03 / RW 05, Blok C (Pagar Hitam Depan Masjid)"
                                className="w-full p-3.5 bg-white dark:bg-[#0D131F] text-slate-900 dark:text-white text-xs sm:text-sm font-medium border border-slate-200 dark:border-slate-800 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all resize-none placeholder-slate-400 dark:placeholder-slate-500"
                            />
                        </div>
                    </div>

                </div>

                {/* Footer Action */}
                <div className="pt-4 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p className="text-[11px] text-slate-400 dark:text-slate-500 text-center sm:text-left">
                        Perubahan disimpan secara aman di database server SiSampah.
                    </p>
                    <button
                        type="submit"
                        disabled={isSubmitting}
                        className="w-full sm:w-auto px-6 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center gap-2 hover:-translate-y-0.5 disabled:opacity-75 cursor-pointer"
                    >
                        <Save className="w-4 h-4" />
                        <span>{isSubmitting ? 'Menyimpan...' : 'Simpan Perubahan Data'}</span>
                    </button>
                </div>

            </form>

        </div>
    );
}
