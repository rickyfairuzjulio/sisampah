import React, { useState } from 'react';
import { Lock, Eye, EyeOff, KeyRound, ShieldAlert, Check } from 'lucide-react';

export default function PasswordSecurityForm({
    csrfToken = '',
    errors = {},
}) {
    const [currentPassword, setCurrentPassword] = useState('');
    const [password, setPassword] = useState('');
    const [passwordConfirmation, setPasswordConfirmation] = useState('');
    const [showCurrent, setShowCurrent] = useState(false);
    const [showNew, setShowNew] = useState(false);
    const [showConfirm, setShowConfirm] = useState(false);
    const [isSubmitting, setIsSubmitting] = useState(false);

    const currentPasswordError = errors?.current_password;
    const passwordError = errors?.password;

    return (
        <div className="bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6 transition-colors duration-200">
            
            {/* Header Section */}
            <div className="flex items-center gap-3.5 pb-5 border-b border-slate-100 dark:border-slate-800">
                <div className="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/80 flex items-center justify-center font-bold shrink-0">
                    <KeyRound className="w-5 h-5" />
                </div>
                <div>
                    <h2 className="font-extrabold text-base sm:text-lg text-slate-900 dark:text-white tracking-tight">
                        Keamanan Kata Sandi
                    </h2>
                    <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Pastikan akun Anda menggunakan kombinasi sandi yang kuat dan aman.
                    </p>
                </div>
            </div>

            {/* Native Laravel Password Update Form */}
            <form 
                method="POST" 
                action="/password" 
                onSubmit={() => setIsSubmitting(true)}
                className="space-y-5"
            >
                <input type="hidden" name="_token" value={csrfToken} />
                <input type="hidden" name="_method" value="PUT" />

                {/* 1. Kata Sandi Saat Ini */}
                <div>
                    <label htmlFor="current_password" className="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Kata Sandi Saat Ini <span className="text-emerald-600 dark:text-emerald-400">*</span>
                    </label>
                    <div className="relative">
                        <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <Lock className="w-4 h-4" />
                        </div>
                        <input
                            id="current_password"
                            name="current_password"
                            type={showCurrent ? 'text' : 'password'}
                            required
                            value={currentPassword}
                            onChange={(e) => setCurrentPassword(e.target.value)}
                            placeholder="Masukkan sandi saat ini"
                            className={`w-full pl-10 pr-12 py-2.5 sm:py-3 bg-white dark:bg-[#0D131F] text-slate-900 dark:text-white text-xs sm:text-sm font-medium border rounded-xl outline-none transition-all placeholder-slate-400 dark:placeholder-slate-500 ${
                                currentPasswordError
                                    ? 'border-red-400 focus:border-red-500 focus:ring-2 focus:ring-red-500/20'
                                    : 'border-slate-200 dark:border-slate-800 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20'
                            }`}
                        />
                        <button
                            type="button"
                            onClick={() => setShowCurrent(!showCurrent)}
                            className="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 transition-colors focus:outline-none cursor-pointer"
                        >
                            {showCurrent ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                        </button>
                    </div>
                    {currentPasswordError && (
                        <p className="mt-1 text-xs font-semibold text-rose-500">{currentPasswordError}</p>
                    )}
                </div>

                {/* 2. Sandi Baru & Konfirmasi Sandi */}
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    
                    {/* Sandi Baru */}
                    <div>
                        <label htmlFor="password" className="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Kata Sandi Baru <span className="text-emerald-600 dark:text-emerald-400">*</span>
                        </label>
                        <div className="relative">
                            <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <Lock className="w-4 h-4" />
                            </div>
                            <input
                                id="password"
                                name="password"
                                type={showNew ? 'text' : 'password'}
                                required
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                                placeholder="Minimal 8 karakter"
                                className={`w-full pl-10 pr-12 py-2.5 sm:py-3 bg-white dark:bg-[#0D131F] text-slate-900 dark:text-white text-xs sm:text-sm font-medium border rounded-xl outline-none transition-all placeholder-slate-400 dark:placeholder-slate-500 ${
                                    passwordError
                                        ? 'border-red-400 focus:border-red-500 focus:ring-2 focus:ring-red-500/20'
                                        : 'border-slate-200 dark:border-slate-800 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20'
                                }`}
                            />
                            <button
                                type="button"
                                onClick={() => setShowNew(!showNew)}
                                className="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 transition-colors focus:outline-none cursor-pointer"
                            >
                                {showNew ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                            </button>
                        </div>
                        {passwordError && (
                            <p className="mt-1 text-xs font-semibold text-rose-500">{passwordError}</p>
                        )}
                    </div>

                    {/* Konfirmasi Sandi Baru */}
                    <div>
                        <label htmlFor="password_confirmation" className="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Konfirmasi Kata Sandi Baru <span className="text-emerald-600 dark:text-emerald-400">*</span>
                        </label>
                        <div className="relative">
                            <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <Lock className="w-4 h-4" />
                            </div>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type={showConfirm ? 'text' : 'password'}
                                required
                                value={passwordConfirmation}
                                onChange={(e) => setPasswordConfirmation(e.target.value)}
                                placeholder="Ulangi kata sandi baru"
                                className="w-full pl-10 pr-12 py-2.5 sm:py-3 bg-white dark:bg-[#0D131F] text-slate-900 dark:text-white text-xs sm:text-sm font-medium border border-slate-200 dark:border-slate-800 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all placeholder-slate-400 dark:placeholder-slate-500"
                            />
                            <button
                                type="button"
                                onClick={() => setShowConfirm(!showConfirm)}
                                className="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 transition-colors focus:outline-none cursor-pointer"
                            >
                                {showConfirm ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                            </button>
                        </div>
                    </div>

                </div>

                {/* Footer Action */}
                <div className="pt-4 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p className="text-[11px] text-slate-400 dark:text-slate-500 text-center sm:text-left">
                        Gunakan minimal 8 karakter dengan kombinasi angka dan huruf.
                    </p>
                    <button
                        type="submit"
                        disabled={isSubmitting}
                        className="w-full sm:w-auto px-6 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center gap-2 hover:-translate-y-0.5 disabled:opacity-75 cursor-pointer"
                    >
                        <Check className="w-4 h-4" />
                        <span>{isSubmitting ? 'Memperbarui...' : 'Perbarui Kata Sandi'}</span>
                    </button>
                </div>

            </form>

        </div>
    );
}
