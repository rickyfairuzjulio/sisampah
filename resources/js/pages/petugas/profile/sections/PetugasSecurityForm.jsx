import React, { useState } from 'react';
import { Lock, Eye, EyeOff, KeyRound, AlertCircle } from 'lucide-react';

export default function PetugasSecurityForm({
    csrfToken = '',
    errors = {},
}) {
    const [currentPassword, setCurrentPassword] = useState('');
    const [password, setPassword] = useState('');
    const [passwordConfirmation, setPasswordConfirmation] = useState('');

    const [showCurrent, setShowCurrent] = useState(false);
    const [showNew, setShowNew] = useState(false);
    const [showConfirm, setShowConfirm] = useState(false);
    const [isUpdating, setIsUpdating] = useState(false);

    return (
        <form
            action="/password"
            method="POST"
            onSubmit={() => setIsUpdating(true)}
            className="bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-5 select-none transition-colors duration-200"
        >
            <input type="hidden" name="_token" value={csrfToken} />
            <input type="hidden" name="_method" value="PUT" />

            <div className="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <div className="flex items-center gap-2.5">
                    <div className="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 flex items-center justify-center font-black text-sm">
                        <Lock className="w-4 h-4" />
                    </div>
                    <div>
                        <h3 className="font-black text-base text-slate-900 dark:text-white tracking-tight">
                            Keamanan & Kata Sandi
                        </h3>
                        <p className="text-xs text-slate-500 dark:text-slate-400">
                            Pastikan akun Anda menggunakan kata sandi yang panjang dan aman
                        </p>
                    </div>
                </div>
            </div>

            <div className="space-y-4">
                
                {/* Sandi Saat Ini */}
                <div className="space-y-1.5">
                    <label className="block text-xs font-bold text-slate-700 dark:text-slate-300">
                        Kata Sandi Saat Ini <span className="text-rose-500">*</span>
                    </label>
                    <div className="relative">
                        <input
                            type={showCurrent ? 'text' : 'password'}
                            name="current_password"
                            value={currentPassword}
                            onChange={(e) => setCurrentPassword(e.target.value)}
                            required
                            placeholder="••••••••"
                            className="w-full px-4 py-2.5 pr-10 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-[#0D131F] text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs placeholder-slate-400 dark:placeholder-slate-500"
                        />
                        <button
                            type="button"
                            onClick={() => setShowCurrent(!showCurrent)}
                            className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors cursor-pointer"
                        >
                            {showCurrent ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                        </button>
                    </div>
                    {errors?.current_password && (
                        <p className="text-[11px] font-bold text-rose-600 flex items-center gap-1">
                            <AlertCircle className="w-3 h-3" /> {errors.current_password}
                        </p>
                    )}
                </div>

                {/* Sandi Baru & Konfirmasi */}
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    {/* Sandi Baru */}
                    <div className="space-y-1.5">
                        <label className="block text-xs font-bold text-slate-700 dark:text-slate-300">
                            Kata Sandi Baru <span className="text-rose-500">*</span>
                        </label>
                        <div className="relative">
                            <input
                                type={showNew ? 'text' : 'password'}
                                name="password"
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                                required
                                minLength="8"
                                placeholder="Min. 8 karakter"
                                className="w-full px-4 py-2.5 pr-10 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-[#0D131F] text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs placeholder-slate-400 dark:placeholder-slate-500"
                            />
                            <button
                                type="button"
                                onClick={() => setShowNew(!showNew)}
                                className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors cursor-pointer"
                            >
                                {showNew ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                            </button>
                        </div>
                    </div>

                    {/* Konfirmasi Sandi */}
                    <div className="space-y-1.5">
                        <label className="block text-xs font-bold text-slate-700 dark:text-slate-300">
                            Konfirmasi Kata Sandi Baru <span className="text-rose-500">*</span>
                        </label>
                        <div className="relative">
                            <input
                                type={showConfirm ? 'text' : 'password'}
                                name="password_confirmation"
                                value={passwordConfirmation}
                                onChange={(e) => setPasswordConfirmation(e.target.value)}
                                required
                                minLength="8"
                                placeholder="Ulangi kata sandi baru"
                                className="w-full px-4 py-2.5 pr-10 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-[#0D131F] text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs placeholder-slate-400 dark:placeholder-slate-500"
                            />
                            <button
                                type="button"
                                onClick={() => setShowConfirm(!showConfirm)}
                                className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors cursor-pointer"
                            >
                                {showConfirm ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                            </button>
                        </div>
                    </div>

                </div>

            </div>

            {/* Submit Button */}
            <div className="pt-2 flex justify-end">
                <button
                    type="submit"
                    disabled={isUpdating}
                    className="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-sm hover:shadow transition-all flex items-center gap-2 cursor-pointer"
                >
                    <KeyRound className="w-3.5 h-3.5" />
                    <span>{isUpdating ? 'Memperbarui...' : 'Perbarui Kata Sandi'}</span>
                </button>
            </div>

        </form>
    );
}
