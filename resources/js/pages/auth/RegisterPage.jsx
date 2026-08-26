import React, { useState } from 'react';
import { User, Mail, Building2, Lock, Eye, EyeOff, ArrowRight, AlertCircle } from 'lucide-react';
import AuthLayout from './components/AuthLayout';

export default function RegisterPage({
    csrfToken = '',
    oldData = {},
    errors = {},
    bankSampahs = [],
}) {
    const [name, setName] = useState(oldData?.name || '');
    const [email, setEmail] = useState(oldData?.email || '');
    const [bankSampahId, setBankSampahId] = useState(oldData?.bank_sampah_id || '');
    const [password, setPassword] = useState('');
    const [passwordConfirmation, setPasswordConfirmation] = useState('');
    const [showPassword, setShowPassword] = useState(false);
    const [showConfirmPassword, setShowConfirmPassword] = useState(false);
    const [isLoading, setIsLoading] = useState(false);

    const nameError = errors?.name;
    const emailError = errors?.email;
    const bankError = errors?.bank_sampah_id;
    const passwordError = errors?.password;

    const handleSubmit = () => {
        setIsLoading(true);
    };

    return (
        <AuthLayout isLogin={false}>
            
            {/* Top Heading */}
            <div className="mb-6">
                <p className="text-xs font-bold tracking-widest text-slate-400 uppercase mb-2">
                    MULAI GRATIS
                </p>
                <h1 className="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mb-2">
                    Buat akun baru<span className="text-[#16A34A]">.</span>
                </h1>
                <p className="text-sm text-slate-500 font-medium">
                    Sudah punya akun?{' '}
                    <a 
                        href="/login" 
                        className="text-[#16A34A] hover:text-emerald-700 font-bold transition-colors underline decoration-emerald-200 underline-offset-4"
                    >
                        Masuk di sini
                    </a>
                </p>
            </div>

            {/* General Errors Alert */}
            {Object.keys(errors).length > 0 && (
                <div className="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs sm:text-sm font-semibold flex items-center gap-2.5 animate-slide-in">
                    <AlertCircle className="w-4 h-4 text-red-500 shrink-0" />
                    <span>Mohon periksa kembali isian formulir di bawah ini.</span>
                </div>
            )}

            {/* Native Laravel Registration Form */}
            <form 
                method="POST" 
                action="/register" 
                onSubmit={handleSubmit}
                className="space-y-4"
            >
                {/* CSRF Token */}
                <input type="hidden" name="_token" value={csrfToken} />

                {/* 1. Nama Lengkap */}
                <div>
                    <label 
                        htmlFor="name" 
                        className="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5"
                    >
                        Nama Lengkap
                    </label>
                    <div className="relative">
                        <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <User className="w-4 h-4" />
                        </div>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            required
                            autoFocus
                            value={name}
                            onChange={(e) => setName(e.target.value)}
                            placeholder="Ahmad Fauzi"
                            className={`w-full pl-10 pr-4 py-2.5 sm:py-3 bg-white text-slate-900 text-sm font-medium border rounded-xl outline-none transition-all ${
                                nameError 
                                    ? 'border-red-400 focus:border-red-500 focus:ring-2 focus:ring-red-500/20' 
                                    : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20'
                            }`}
                        />
                    </div>
                    {nameError && (
                        <p className="mt-1 text-xs font-semibold text-red-500">{nameError}</p>
                    )}
                </div>

                {/* 2. Email */}
                <div>
                    <label 
                        htmlFor="email" 
                        className="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5"
                    >
                        Alamat Email
                    </label>
                    <div className="relative">
                        <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
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
                            className={`w-full pl-10 pr-4 py-2.5 sm:py-3 bg-white text-slate-900 text-sm font-medium border rounded-xl outline-none transition-all ${
                                emailError 
                                    ? 'border-red-400 focus:border-red-500 focus:ring-2 focus:ring-red-500/20' 
                                    : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20'
                            }`}
                        />
                    </div>
                    {emailError && (
                        <p className="mt-1 text-xs font-semibold text-red-500">{emailError}</p>
                    )}
                </div>

                {/* 3. Bank Sampah Unit Selection */}
                <div>
                    <label 
                        htmlFor="bank_sampah_id" 
                        className="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5"
                    >
                        Pilih Bank Sampah Unit Domisili
                    </label>
                    <div className="relative">
                        <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <Building2 className="w-4 h-4" />
                        </div>
                        <select
                            id="bank_sampah_id"
                            name="bank_sampah_id"
                            required
                            value={bankSampahId}
                            onChange={(e) => setBankSampahId(e.target.value)}
                            className={`w-full pl-10 pr-10 py-2.5 sm:py-3 bg-white text-slate-900 text-sm font-medium border rounded-xl outline-none transition-all cursor-pointer ${
                                bankError 
                                    ? 'border-red-400 focus:border-red-500 focus:ring-2 focus:ring-red-500/20' 
                                    : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20'
                            }`}
                        >
                            <option value="">-- Pilih Unit Bank Sampah Terdekat --</option>
                            {bankSampahs.map((bs) => (
                                <option key={bs.id} value={bs.id}>
                                    {bs.nama} {bs.kecamatan ? `(Kec. ${bs.kecamatan})` : ''}
                                </option>
                            ))}
                        </select>
                    </div>
                    {bankError && (
                        <p className="mt-1 text-xs font-semibold text-red-500">{bankError}</p>
                    )}
                </div>

                {/* 4. Password Field */}
                <div>
                    <label 
                        htmlFor="password" 
                        className="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5"
                    >
                        Kata Sandi (Password)
                    </label>
                    <div className="relative">
                        <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <Lock className="w-4 h-4" />
                        </div>
                        <input
                            id="password"
                            name="password"
                            type={showPassword ? 'text' : 'password'}
                            required
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                            placeholder="Minimal 8 karakter"
                            className={`w-full pl-10 pr-12 py-2.5 sm:py-3 bg-white text-slate-900 text-sm font-medium border rounded-xl outline-none transition-all ${
                                passwordError 
                                    ? 'border-red-400 focus:border-red-500 focus:ring-2 focus:ring-red-500/20' 
                                    : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20'
                            }`}
                        />
                        <button
                            type="button"
                            onClick={() => setShowPassword(!showPassword)}
                            className="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none"
                            tabIndex={-1}
                        >
                            {showPassword ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                        </button>
                    </div>
                    {passwordError && (
                        <p className="mt-1 text-xs font-semibold text-red-500">{passwordError}</p>
                    )}
                </div>

                {/* 5. Konfirmasi Password Field */}
                <div>
                    <label 
                        htmlFor="password_confirmation" 
                        className="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5"
                    >
                        Konfirmasi Kata Sandi
                    </label>
                    <div className="relative">
                        <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <Lock className="w-4 h-4" />
                        </div>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type={showConfirmPassword ? 'text' : 'password'}
                            required
                            value={passwordConfirmation}
                            onChange={(e) => setPasswordConfirmation(e.target.value)}
                            placeholder="Ulangi kata sandi"
                            className="w-full pl-10 pr-12 py-2.5 sm:py-3 bg-white text-slate-900 text-sm font-medium border border-slate-200 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all"
                        />
                        <button
                            type="button"
                            onClick={() => setShowConfirmPassword(!showConfirmPassword)}
                            className="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none"
                            tabIndex={-1}
                        >
                            {showConfirmPassword ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                        </button>
                    </div>
                </div>

                {/* 6. Action Buttons Row */}
                <div className="flex items-center gap-3 pt-3">
                    <a
                        href="/login"
                        className="flex-1 py-3 px-4 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold text-xs sm:text-sm text-center transition-colors shadow-sm"
                    >
                        Kembali Masuk
                    </a>
                    <button
                        type="submit"
                        disabled={isLoading}
                        className="flex-1 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 hover:-translate-y-0.5 disabled:opacity-75 disabled:cursor-not-allowed"
                    >
                        {isLoading ? (
                            <span>Mendaftar...</span>
                        ) : (
                            <>
                                <span>Buat Akun</span>
                                <ArrowRight className="w-4 h-4" />
                            </>
                        )}
                    </button>
                </div>

                {/* 7. Disclaimer */}
                <p className="text-[11px] text-slate-400 text-center pt-2">
                    Dengan mendaftar, Anda menyetujui{' '}
                    <a href="#" className="text-emerald-600 hover:underline">Ketentuan Layanan</a>{' '}
                    dan{' '}
                    <a href="#" className="text-emerald-600 hover:underline">Kebijakan Privasi</a>{' '}
                    SiSampah.
                </p>

            </form>

        </AuthLayout>
    );
}
