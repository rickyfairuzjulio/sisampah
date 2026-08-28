import React, { useState, useRef, useEffect } from 'react';
import { Link } from '@inertiajs/react';
import { Menu, Sun, Moon, Bell, ChevronDown, User, LogOut, ShieldCheck } from 'lucide-react';
import NotificationDropdown from '@/components/NotificationDropdown';
import useTheme from '@/hooks/useTheme';

export default function PetugasTopNavBar({ 
    pageTitle = 'Dashboard Manifes', 
    authData = {}, 
    onOpenMobile 
}) {
    const user = authData?.user || {};
    const { isDark, toggleTheme } = useTheme();
    const [dropdownOpen, setDropdownOpen] = useState(false);
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
        <header className="sticky top-0 h-16 bg-white dark:bg-[#0D131F] border-b border-slate-200 dark:border-slate-800 flex justify-between items-center px-4 sm:px-6 lg:px-8 z-40 w-full select-none transition-colors duration-200">
            
            {/* ZONA KIRI: Mobile Menu & Judul Halaman */}
            <div className="flex items-center gap-3">
                <button
                    type="button"
                    onClick={onOpenMobile}
                    className="lg:hidden p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                >
                    <Menu className="w-5 h-5" />
                </button>

                <div className="flex items-center gap-2">
                    <span className="hidden sm:inline text-xs font-semibold text-slate-400 dark:text-slate-500">Petugas</span>
                    <span className="hidden sm:inline text-xs text-slate-300 dark:text-slate-600">/</span>
                    <h1 className="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white tracking-tight">
                        {pageTitle}
                    </h1>
                </div>
            </div>

            {/* ZONA TENGAH: Status Armada Bertugas */}
            <div className="hidden md:flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/60 text-xs font-bold shadow-2xs">
                <span className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Armada & Pos Aktif</span>
            </div>

            {/* ZONA KANAN: Theme Toggle, Notif & Profil Petugas */}
            <div className="flex items-center gap-2.5 sm:gap-3">
                
                {/* 1. Theme Toggle */}
                <button
                    type="button"
                    onClick={toggleTheme}
                    className="p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer"
                    title={isDark ? 'Beralih ke Light Mode' : 'Beralih ke Dark Mode'}
                >
                    {isDark ? <Sun className="w-4 h-4 text-amber-400" /> : <Moon className="w-4 h-4" />}
                </button>

                {/* 2. Notification Dropdown Component */}
                <NotificationDropdown />

                <div className="h-6 w-px bg-slate-200 dark:bg-slate-800 mx-0.5"></div>

                {/* 3. User Profile Dropdown */}
                <div className="relative" ref={dropdownRef}>
                    <button
                        type="button"
                        onClick={() => setDropdownOpen(!dropdownOpen)}
                        className="flex items-center gap-2 p-1.5 sm:px-2.5 sm:py-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 transition-all border border-transparent hover:border-slate-200 dark:hover:border-slate-700 cursor-pointer"
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
                        <span className="hidden sm:inline font-bold text-xs text-slate-800 dark:text-slate-200 truncate max-w-[120px]">
                            {firstName}
                        </span>
                        <ChevronDown className="w-3.5 h-3.5 text-slate-400" />
                    </button>

                    {/* Dropdown Menu Modal */}
                    {dropdownOpen && (
                        <div className="absolute right-0 mt-2 w-56 bg-white dark:bg-[#111827] rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800 py-2 z-50 animate-slide-in">
                            <div className="px-4 py-2 border-b border-slate-100 dark:border-slate-800">
                                <p className="text-xs font-bold text-slate-900 dark:text-white truncate">{user?.name || 'Petugas'}</p>
                                <p className="text-[11px] text-slate-500 dark:text-slate-400 truncate">{user?.email || 'petugas@sisampah.id'}</p>
                                <div className="mt-1.5 inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-400 text-[10px] font-bold border border-emerald-200 dark:border-emerald-800/80">
                                    <ShieldCheck className="w-3 h-3 text-emerald-600 dark:text-emerald-400" />
                                    <span>Petugas Lapangan</span>
                                </div>
                            </div>

                            <Link
                                href="/profile"
                                className="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/60 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors"
                            >
                                <User className="w-4 h-4 text-slate-400" />
                                <span>Profil Petugas</span>
                            </Link>

                            <div className="border-t border-slate-100 dark:border-slate-800 my-1"></div>

                            <button
                                type="button"
                                onClick={handleLogout}
                                className="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors cursor-pointer"
                            >
                                <LogOut className="w-4 h-4 text-rose-500" />
                                <span>Keluar Akun</span>
                            </button>
                        </div>
                    )}
                </div>

            </div>

        </header>
    );
}
