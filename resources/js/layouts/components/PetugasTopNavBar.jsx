import React, { useState, useRef, useEffect } from 'react';
import { Menu, Sun, Moon, Bell, ChevronDown, User, LogOut, ShieldCheck } from 'lucide-react';

export default function PetugasTopNavBar({ 
    pageTitle = 'Dashboard Manifes', 
    authData = {}, 
    onOpenMobile 
}) {
    const user = authData?.user || {};
    const [dropdownOpen, setDropdownOpen] = useState(false);
    const [isDarkMode, setIsDarkMode] = useState(false);
    const dropdownRef = useRef(null);

    const firstName = user?.name ? user.name.split(' ')[0] : 'Petugas';

    useEffect(() => {
        const handleClickOutside = (event) => {
            if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
                setDropdownOpen(false);
            }
        };
        document.addEventListener('mousedown', handleClickOutside);
        return () => document.removeEventListener('mousedown', handleClickOutside);
    }, []);

    const toggleTheme = () => {
        const nextMode = !isDarkMode;
        setIsDarkMode(nextMode);
        if (nextMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    };

    const handleLogout = (e) => {
        e.preventDefault();
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/logout';

        if (csrfToken) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = '_token';
            input.value = csrfToken;
            form.appendChild(input);
        }

        document.body.appendChild(form);
        form.submit();
    };

    return (
        <header className="sticky top-0 h-16 bg-white border-b border-slate-200 flex justify-between items-center px-4 sm:px-6 lg:px-8 z-40 w-full select-none">
            
            {/* ZONA KIRI: Mobile Menu & Judul Halaman */}
            <div className="flex items-center gap-3">
                <button
                    type="button"
                    onClick={onOpenMobile}
                    className="lg:hidden p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors"
                >
                    <Menu className="w-5 h-5" />
                </button>

                <div className="flex items-center gap-2">
                    <span className="hidden sm:inline text-xs font-semibold text-slate-400">Petugas</span>
                    <span className="hidden sm:inline text-xs text-slate-300">/</span>
                    <h1 className="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight">
                        {pageTitle}
                    </h1>
                </div>
            </div>

            {/* ZONA TENGAH: Status Armada Bertugas */}
            <div className="hidden md:flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200/80 text-xs font-bold shadow-2xs">
                <span className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Armada & Pos Aktif</span>
            </div>

            {/* ZONA KANAN: Theme Toggle, Notif & Profil Petugas (TANPA SEARCH BAR) */}
            <div className="flex items-center gap-2.5 sm:gap-3">
                
                {/* 1. Theme Toggle */}
                <button
                    type="button"
                    onClick={toggleTheme}
                    className="p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors"
                    title={isDarkMode ? 'Beralih ke Light Mode' : 'Beralih ke Dark Mode'}
                >
                    {isDarkMode ? <Sun className="w-4 h-4 text-amber-500" /> : <Moon className="w-4 h-4" />}
                </button>

                {/* 2. Notification Bell */}
                <div className="relative">
                    <button
                        type="button"
                        className="p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors relative"
                    >
                        <Bell className="w-4 h-4" />
                        <span className="absolute top-1.5 right-1.5 w-2 h-2 bg-emerald-500 rounded-full ring-2 ring-white"></span>
                    </button>
                </div>

                <div className="h-6 w-px bg-slate-200 mx-0.5"></div>

                {/* 3. User Profile Dropdown */}
                <div className="relative" ref={dropdownRef}>
                    <button
                        type="button"
                        onClick={() => setDropdownOpen(!dropdownOpen)}
                        className="flex items-center gap-2 p-1.5 sm:px-2.5 sm:py-1.5 rounded-xl hover:bg-slate-100 text-slate-700 transition-all border border-transparent hover:border-slate-200 cursor-pointer"
                    >
                        {user?.avatar_url ? (
                            <img
                                src={user.avatar_url}
                                alt={user.name}
                                className="w-8 h-8 rounded-lg object-cover border border-emerald-500/30"
                            />
                        ) : (
                            <div className="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-xs">
                                {user?.name ? user.name.charAt(0).toUpperCase() : 'P'}
                            </div>
                        )}
                        <span className="hidden sm:inline font-bold text-xs text-slate-800 truncate max-w-[120px]">
                            {firstName}
                        </span>
                        <ChevronDown className="w-3.5 h-3.5 text-slate-400" />
                    </button>

                    {/* Dropdown Menu Modal */}
                    {dropdownOpen && (
                        <div className="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 z-50 animate-slide-in">
                            <div className="px-4 py-2 border-b border-slate-100">
                                <p className="text-xs font-bold text-slate-900 truncate">{user?.name || 'Petugas'}</p>
                                <p className="text-[11px] text-slate-500 truncate">{user?.email || 'petugas@sisampah.id'}</p>
                                <div className="mt-1.5 inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-800 text-[10px] font-bold">
                                    <ShieldCheck className="w-3 h-3 text-emerald-600" />
                                    <span>Petugas Lapangan</span>
                                </div>
                            </div>

                            <a
                                href="/profile"
                                className="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-emerald-700 transition-colors"
                            >
                                <User className="w-4 h-4 text-slate-400" />
                                <span>Profil Petugas</span>
                            </a>

                            <div className="border-t border-slate-100 my-1"></div>

                            <button
                                type="button"
                                onClick={handleLogout}
                                className="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs font-bold text-red-600 hover:bg-red-50 transition-colors cursor-pointer"
                            >
                                <LogOut className="w-4 h-4 text-red-500" />
                                <span>Keluar Akun</span>
                            </button>
                        </div>
                    )}
                </div>

            </div>

        </header>
    );
}
