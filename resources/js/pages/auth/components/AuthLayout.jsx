import React from 'react';
import AuthRightPanel from './AuthRightPanel';

export default function AuthLayout({ children, isLogin = true }) {
    return (
        <div className="min-h-screen lg:h-screen lg:overflow-hidden flex bg-[#F8FAFC] font-sans antialiased text-slate-800">
            
            {/* 1. Left Form Panel (Light Mode #FFFFFF - Independent Scroll) */}
            <div className="flex-1 flex flex-col bg-white min-h-screen lg:min-h-0 lg:h-full lg:overflow-y-auto w-full lg:max-w-[55%] xl:max-w-[50%] shadow-sm z-10">
                
                {/* Header Navbar */}
                <header className="flex items-center justify-between px-6 sm:px-10 lg:px-14 py-6 border-b border-slate-100">
                    <a href="/" className="flex items-center gap-3 group">
                        <img 
                            src="/images/logo.png" 
                            alt="SiSampah Logo" 
                            className="w-10 h-10 object-contain drop-shadow-sm group-hover:scale-105 transition-transform"
                            onError={(e) => {
                                e.target.onerror = null;
                                e.target.src = 'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/sprout.svg';
                            }}
                        />
                        <span className="text-2xl font-bold text-slate-900 tracking-tight">
                            SiSampah<span className="text-[#16A34A]">.</span>
                        </span>
                    </a>

                    <nav className="flex items-center gap-5 text-sm font-semibold">
                        <a 
                            href="/" 
                            className="text-slate-500 hover:text-slate-900 transition-colors"
                        >
                            Beranda
                        </a>
                        {isLogin ? (
                            <a 
                                href="/register" 
                                className="px-3.5 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 transition-colors"
                            >
                                Daftar
                            </a>
                        ) : (
                            <a 
                                href="/login" 
                                className="px-3.5 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 transition-colors"
                            >
                                Masuk
                            </a>
                        )}
                    </nav>
                </header>

                {/* Form Content Slot */}
                <div className="flex-1 flex items-center justify-center px-6 sm:px-10 lg:px-14 py-10 sm:py-12">
                    <div className="w-full max-w-md animate-slide-in">
                        {children}
                    </div>
                </div>

                {/* Footer Tagline */}
                <footer className="px-6 sm:px-10 lg:px-14 py-5 border-t border-slate-100 text-center sm:text-left">
                    <p className="text-xs text-slate-400 font-medium">
                        Bersih Desa, Sejahtera Bersama • SiSampah Digital
                    </p>
                </footer>

            </div>

            {/* 2. Right Branding Panel (With Photo Background & No Stat Cards) */}
            <AuthRightPanel />

        </div>
    );
}
