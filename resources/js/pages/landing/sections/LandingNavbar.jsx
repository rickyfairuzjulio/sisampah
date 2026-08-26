import React, { useState, useEffect } from 'react';
import { Menu, X, ArrowRight, User as UserIcon, LogIn, Sparkles, Building2, Search } from 'lucide-react';

export default function LandingNavbar({ authData }) {
    const [isScrolled, setIsScrolled] = useState(false);
    const [mobileOpen, setMobileOpen] = useState(false);

    useEffect(() => {
        const handleScroll = () => {
            setIsScrolled(window.scrollY > 30);
        };
        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    const user = authData?.user;
    const isAuthenticated = authData?.is_authenticated;

    return (
        <header 
            className={`fixed top-0 inset-x-0 z-50 transition-all duration-300 ${
                isScrolled 
                    ? 'bg-[#051410]/95 backdrop-blur-xl border-b border-white/10 shadow-2xl py-1.5' 
                    : 'bg-transparent py-3'
            }`}
        >
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex items-center justify-between h-16 lg:h-18">
                    
                    {/* ZONA KIRI: Brand Logo */}
                    <a href="/" className="flex items-center gap-2.5 sm:gap-3 group">
                        <img 
                            src="/images/logo.png" 
                            alt="SiSampah Logo" 
                            className="w-10 h-10 sm:w-11 sm:h-11 object-contain group-hover:scale-105 transition-transform duration-200 drop-shadow-md"
                            onError={(e) => {
                                e.target.onerror = null;
                                e.target.src = 'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/sprout.svg';
                            }}
                        />
                        <span className="text-xl sm:text-2xl font-black text-white tracking-tight">
                            SiSampah<span className="text-[#22C55E]">.</span>
                        </span>
                    </a>

                    {/* ZONA TENGAH: 5 Nav Links Sesuai Spesifikasi */}
                    <nav className="hidden lg:flex items-center gap-8 text-sm font-semibold text-white/70">
                        <a href="#fitur" className="hover:text-[#34D399] transition-colors duration-200">Fitur</a>
                        <a href="#cara-kerja" className="hover:text-[#34D399] transition-colors duration-200">Cara Kerja</a>
                        <a href="#dampak" className="hover:text-[#34D399] transition-colors duration-200">Dampak</a>
                        <a href="#edukasi" className="hover:text-[#34D399] transition-colors duration-200">Edukasi</a>
                        <a href="#faq" className="hover:text-[#34D399] transition-colors duration-200">FAQ</a>
                    </nav>

                    {/* ZONA KANAN: Action Buttons / Auth State */}
                    <div className="hidden lg:flex items-center gap-4">
                        {isAuthenticated ? (
                            <div className="flex items-center gap-3">
                                <a 
                                    href={user?.dashboard_url || '/dashboard'}
                                    className="inline-flex items-center gap-2 px-5 py-2.5 bg-[#22C55E] hover:bg-emerald-400 text-white text-sm font-bold rounded-full transition-all shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30"
                                >
                                    {user?.avatar_url ? (
                                        <img src={user.avatar_url} alt={user.name} className="w-5 h-5 rounded-full object-cover border border-white/40" />
                                    ) : (
                                        <UserIcon className="w-4 h-4" />
                                    )}
                                    <span>Dashboard ({user?.name?.split(' ')[0] || 'Saya'})</span>
                                    <ArrowRight className="w-4 h-4" />
                                </a>
                            </div>
                        ) : (
                            <>
                                <a 
                                    href="/login" 
                                    className="text-sm font-bold text-white/80 hover:text-white transition-colors px-3 py-2"
                                >
                                    Masuk
                                </a>
                                <a 
                                    href="/register" 
                                    className="inline-flex items-center gap-2 px-6 py-2.5 bg-[#22C55E] hover:bg-emerald-400 text-white text-sm font-bold rounded-full transition-all shadow-lg shadow-emerald-500/20 hover:scale-[1.02]"
                                >
                                    <span>Mulai Gratis</span>
                                    <ArrowRight className="w-4 h-4" />
                                </a>
                            </>
                        )}
                    </div>

                    {/* Mobile Hamburger Button */}
                    <button 
                        onClick={() => setMobileOpen(!mobileOpen)} 
                        className="lg:hidden p-2 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-colors focus:outline-none"
                        aria-label="Toggle Menu"
                    >
                        {mobileOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
                    </button>
                </div>
            </div>

            {/* Mobile Navigation Drawer */}
            {mobileOpen && (
                <div className="lg:hidden bg-[#051410]/98 backdrop-blur-2xl border-b border-white/10 shadow-2xl px-4 py-5 space-y-3 animate-fade-in">
                    <div className="space-y-1">
                        <a 
                            href="#fitur" 
                            onClick={() => setMobileOpen(false)}
                            className="flex items-center justify-between px-4 py-2.5 rounded-xl text-white/90 hover:bg-white/10 font-medium text-sm transition-colors"
                        >
                            <span>Fitur Unggulan</span>
                            <ArrowRight className="w-4 h-4 opacity-50" />
                        </a>
                        <a 
                            href="#cara-kerja" 
                            onClick={() => setMobileOpen(false)}
                            className="flex items-center justify-between px-4 py-2.5 rounded-xl text-white/90 hover:bg-white/10 font-medium text-sm transition-colors"
                        >
                            <span>Cara Kerja</span>
                            <ArrowRight className="w-4 h-4 opacity-50" />
                        </a>
                        <a 
                            href="#dampak" 
                            onClick={() => setMobileOpen(false)}
                            className="flex items-center justify-between px-4 py-2.5 rounded-xl text-white/90 hover:bg-white/10 font-medium text-sm transition-colors"
                        >
                            <span>Dampak Lingkungan</span>
                            <ArrowRight className="w-4 h-4 opacity-50" />
                        </a>
                        <a 
                            href="#edukasi" 
                            onClick={() => setMobileOpen(false)}
                            className="flex items-center justify-between px-4 py-2.5 rounded-xl text-white/90 hover:bg-white/10 font-medium text-sm transition-colors"
                        >
                            <span>Artikel Edukasi</span>
                            <ArrowRight className="w-4 h-4 opacity-50" />
                        </a>
                        <a 
                            href="#faq" 
                            onClick={() => setMobileOpen(false)}
                            className="flex items-center justify-between px-4 py-2.5 rounded-xl text-white/90 hover:bg-white/10 font-medium text-sm transition-colors"
                        >
                            <span>Tanya Jawab (FAQ)</span>
                            <ArrowRight className="w-4 h-4 opacity-50" />
                        </a>
                    </div>

                    <div className="pt-3 border-t border-white/10 space-y-2.5">
                        <a 
                            href="/daftar-bank-sampah" 
                            className="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl border border-emerald-500/30 text-emerald-400 hover:bg-emerald-500/10 text-sm font-semibold transition-colors"
                        >
                            <Building2 className="w-4 h-4" />
                            <span>Daftarkan Bank Sampah</span>
                        </a>
                        <a 
                            href="/lacak-pendaftaran" 
                            className="flex items-center justify-center gap-2 w-full py-2 px-4 rounded-xl text-white/70 hover:text-white text-xs font-medium transition-colors"
                        >
                            <Search className="w-3.5 h-3.5" />
                            <span>Lacak Status Pendaftaran Mitra</span>
                        </a>

                        {isAuthenticated ? (
                            <a 
                                href={user?.dashboard_url || '/dashboard'} 
                                className="flex items-center justify-center gap-2 w-full py-3 bg-[#22C55E] text-white rounded-xl font-bold text-sm shadow-md"
                            >
                                <span>Buka Dashboard Saya</span>
                                <ArrowRight className="w-4 h-4" />
                            </a>
                        ) : (
                            <div className="grid grid-cols-2 gap-2 pt-1">
                                <a 
                                    href="/login" 
                                    className="flex items-center justify-center py-2.5 border border-white/20 text-white rounded-xl font-semibold text-sm hover:bg-white/5 transition-colors"
                                >
                                    Masuk
                                </a>
                                <a 
                                    href="/register" 
                                    className="flex items-center justify-center py-2.5 bg-[#22C55E] text-white rounded-xl font-bold text-sm shadow-md"
                                >
                                    Mulai Gratis
                                </a>
                            </div>
                        )}
                    </div>
                </div>
            )}
        </header>
    );
}
