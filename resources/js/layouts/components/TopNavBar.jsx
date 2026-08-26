import React, { useState, useRef, useEffect } from 'react';
import { Menu, Sun, Moon, Bell, ChevronDown, User, LogOut, Settings } from 'lucide-react';

export default function TopNavBar({ 
    pageTitle = 'Dashboard Nasabah', 
    authData = {}, 
    onOpenMobile 
}) {
    const user = authData?.user || {};
    const [dropdownOpen, setDropdownOpen] = useState(false);
    const [isDarkMode, setIsDarkMode] = useState(false);
    const dropdownRef = useRef(null);

    const firstName = user?.name ? user.name.split(' ')[0] : 'Nasabah';

    // Close dropdown on outside click
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
                {onOpenMobile && (
                    <button
                        onClick={onOpenMobile}
                        className="lg:hidden p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors focus:outline-none"
                        aria-label="Buka Menu"
                    >
                        <Menu className="w-5 h-5" />
                    </button>
                )}
                <h1 className="text-base sm:text-lg font-bold text-slate-800 tracking-tight">
                    {pageTitle}
                </h1>
            </div>

            {/* ZONA KANAN: Theme Toggle, Notifikasi, User Avatar (TANPA SEARCH BAR) */}
            <div className="flex items-center gap-2 sm:gap-3">
                
                {/* Theme Toggle Button */}
                <button
                    onClick={toggleTheme}
                    className="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors"
                    title={isDarkMode ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap'}
                >
                    {isDarkMode ? <Sun className="w-4 h-4 text-amber-500" /> : <Moon className="w-4 h-4" />}
                </button>

                {/* Notification Bell */}
                <button
                    className="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors relative"
                    title="Notifikasi"
                >
                    <Bell className="w-4 h-4" />
                    <span className="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white" />
                </button>

                {/* Vertical Divider */}
                <div className="h-6 w-px bg-slate-200 mx-1 hidden sm:block" />

                {/* User Profile Dropdown */}
                <div className="relative" ref={dropdownRef}>
                    <button
                        onClick={() => setDropdownOpen(!dropdownOpen)}
                        className="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 transition-colors focus:outline-none"
                    >
                        {user?.avatar_url ? (
                            <img
                                src={user.avatar_url}
                                alt={user.name || 'User'}
                                className="w-8 h-8 sm:w-9 sm:h-9 rounded-full object-cover border border-slate-200"
                                onError={(e) => {
                                    e.target.onerror = null;
                                    e.target.src = 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&auto=format&fit=crop&q=80';
                                }}
                            />
                        ) : (
                            <div className="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-emerald-100 border border-emerald-300 flex items-center justify-center text-emerald-800 font-bold text-xs">
                                {firstName.charAt(0).toUpperCase()}
                            </div>
                        )}
                        <span className="text-xs sm:text-sm font-bold text-slate-700 hidden sm:block">
                            {firstName}
                        </span>
                        <ChevronDown className={`w-3.5 h-3.5 text-slate-400 transition-transform duration-200 ${dropdownOpen ? 'rotate-180' : ''}`} />
                    </button>

                    {/* Dropdown Menu Popup */}
                    {dropdownOpen && (
                        <div className="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 animate-slide-in">
                            <div className="px-4 py-3 border-b border-slate-100">
                                <p className="text-xs font-bold text-slate-900 truncate">{user?.name || 'Nasabah'}</p>
                                <p className="text-[11px] text-slate-500 truncate">{user?.email || 'nasabah@sisampah.id'}</p>
                            </div>

                            <a
                                href="/profile"
                                className="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-emerald-600 transition-colors"
                            >
                                <Settings className="w-4 h-4 text-slate-400" />
                                <span>Pengaturan Profil</span>
                            </a>

                            <div className="pt-1 border-t border-slate-100">
                                <button
                                    onClick={handleLogout}
                                    className="flex items-center gap-2.5 w-full text-left px-4 py-2.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors"
                                >
                                    <LogOut className="w-4 h-4 text-red-500" />
                                    <span>Keluar / Logout</span>
                                </button>
                            </div>
                        </div>
                    )}
                </div>

            </div>

        </header>
    );
}
