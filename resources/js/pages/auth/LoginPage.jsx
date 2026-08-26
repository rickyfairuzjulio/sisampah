import React, { useState } from 'react';
import { Eye, EyeOff, Mail, Lock, ArrowRight, AlertCircle, CheckCircle2 } from 'lucide-react';
import AuthLayout from './components/AuthLayout';

export default function LoginPage({
    csrfToken = '',
    oldEmail = '',
    errors = {},
    status = '',
}) {
    const [email, setEmail] = useState(oldEmail || '');
    const [password, setPassword] = useState('');
    const [remember, setRemember] = useState(false);
    const [showPassword, setShowPassword] = useState(false);
    const [isLoading, setIsLoading] = useState(false);

    const emailError = errors?.email || (typeof errors === 'string' ? errors : null);
    const passwordError = errors?.password;

    const handleSubmit = () => {
        setIsLoading(true);
    };

    return (
        <AuthLayout isLogin={true}>
            
            {/* Top Heading */}
            <div className="mb-8">
                <p className="text-xs font-bold tracking-widest text-slate-400 uppercase mb-2">
                    SELAMAT DATANG KEMBALI
                </p>
                <h1 className="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mb-2">
                    Masuk ke akun<span className="text-[#16A34A]">.</span>
                </h1>
                <p className="text-sm text-slate-500 font-medium">
                    Belum punya akun?{' '}
                    <a 
                        href="/register" 
                        className="text-[#16A34A] hover:text-emerald-700 font-bold transition-colors underline decoration-emerald-200 underline-offset-4"
                    >
                        Daftar sekarang
                    </a>
                </p>
            </div>

            {/* Session Status Alert */}
            {status && (
                <div className="mb-6 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center gap-2.5 animate-slide-in">
                    <CheckCircle2 className="w-4 h-4 text-emerald-600 shrink-0" />
                    <span>{status}</span>
                </div>
            )}

            {/* General / Auth Errors Alert */}
            {emailError && (
                <div className="mb-6 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs sm:text-sm font-semibold flex items-center gap-2.5 animate-slide-in">
                    <AlertCircle className="w-4 h-4 text-red-500 shrink-0" />
                    <span>{emailError}</span>
                </div>
            )}

            {/* Native Laravel Auth Form */}
            <form 
                method="POST" 
                action="/login" 
                onSubmit={handleSubmit}
                className="space-y-5"
            >
                {/* CSRF Token */}
                <input type="hidden" name="_token" value={csrfToken} />

                {/* Email Field */}
                <div>
                    <label 
                        htmlFor="email" 
                        className="block text-xs sm:text-sm font-bold text-slate-700 mb-2"
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
                            autoFocus
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            placeholder="nama@email.com"
                            className={`w-full pl-10 pr-4 py-3 bg-white text-slate-900 text-sm font-medium border rounded-xl outline-none transition-all ${
                                emailError 
                                    ? 'border-red-400 focus:border-red-500 focus:ring-2 focus:ring-red-500/20' 
                                    : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20'
                            }`}
                        />
                    </div>
                </div>

                {/* Password Field */}
                <div>
                    <label 
                        htmlFor="password" 
                        className="block text-xs sm:text-sm font-bold text-slate-700 mb-2"
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
                            placeholder="••••••••"
                            className={`w-full pl-10 pr-12 py-3 bg-white text-slate-900 text-sm font-medium border rounded-xl outline-none transition-all ${
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
                            {showPassword ? (
                                <EyeOff className="w-4 h-4" />
                            ) : (
                                <Eye className="w-4 h-4" />
                            )}
                        </button>
                    </div>
                    {passwordError && (
                        <p className="mt-1.5 text-xs font-semibold text-red-500">{passwordError}</p>
                    )}
                </div>

                {/* Remember Me & Forgot Password Row */}
                <div className="flex items-center justify-between text-xs sm:text-sm pt-1">
                    <label 
                        htmlFor="remember_me" 
                        className="inline-flex items-center gap-2 cursor-pointer select-none"
                    >
                        <input
                            id="remember_me"
                            name="remember"
                            type="checkbox"
                            checked={remember}
                            onChange={(e) => setRemember(e.target.checked)}
                            className="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500/30 cursor-pointer"
                        />
                        <span className="text-slate-600 font-medium">Ingat saya</span>
                    </label>

                    <a
                        href="/forgot-password"
                        className="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition-colors"
                    >
                        Lupa password?
                    </a>
                </div>

                {/* Submit Button */}
                <button
                    type="submit"
                    disabled={isLoading}
                    className="w-full py-3.5 px-4 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 hover:-translate-y-0.5 disabled:opacity-75 disabled:cursor-not-allowed mt-3"
                >
                    {isLoading ? (
                        <span>Memproses Masuk...</span>
                    ) : (
                        <>
                            <span>Masuk ke Dashboard</span>
                            <ArrowRight className="w-4 h-4" />
                        </>
                    )}
                </button>

            </form>

        </AuthLayout>
    );
}
