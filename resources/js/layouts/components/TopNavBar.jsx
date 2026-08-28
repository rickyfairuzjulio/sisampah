import React, { useState, useRef, useEffect } from 'react';
import { Link } from '@inertiajs/react';
import { Menu, Sun, Moon, Bell, ChevronDown, User, LogOut, Settings } from 'lucide-react';
import NotificationDropdown from '@/components/NotificationDropdown';
import useTheme from '@/hooks/useTheme';

export default function TopNavBar({ 
    pageTitle = 'Dashboard Nasabah', 
    authData = {}, 
    onOpenMobile 
}) {
    const user = authData?.user || {};
    const { isDark, toggleTheme } = useTheme();
    const [dropdownOpen, setDropdownOpen] = useState(false);
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
                {onOpenMobile && (
                    <button
                        onClick={onOpenMobile}
                        className="lg:hidden p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors focus:outline-none"
                        aria-label="Buka Menu"
                    >
                        <Menu className="w-5 h-5" />
                    </button>
                )}
                <h1 className="text-base sm:text-lg font-bold text-slate-800 dark:text-white tracking-tight">
                    {pageTitle}
                </h1>
            </div>

            {/* ZONA KANAN: Theme Toggle, Notifikasi, User Avatar */}
            <div className="flex items-center gap-2 sm:gap-3">
                
                {/* Theme Toggle Button */}
                <button
                    onClick={toggleTheme}
                    className="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer"
                    title={isDark ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap'}
                >
                    {isDark ? <Sun className="w-4 h-4 text-amber-400" /> : <Moon className="w-4 h-4" />}
                </button>

                {/* Notification Dropdown Component */}
                <NotificationDropdown />

                {/* Vertical Divider */}
                <div className="h-6 w-px bg-slate-200 dark:bg-slate-800 mx-1 hidden sm:block" />

                {/* User Profile Dropdown */}
                <div className="relative" ref={dropdownRef}>
                    <button
                        onClick={() => setDropdownOpen(!dropdownOpen)}
                        className="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors focus:outline-none cursor-pointer"
                    >
                        {user?.avatar_url ? (
                            <img
                                src={user.avatar_url}
                                alt={user.name || 'User'}
                                className="w-8 h-8 sm:w-9 sm:h-9 rounded-full object-cover border border-slate-200 dark:border-slate-700"
                                onError={(e) => {
                                    e.target.onerror = null;
                                    e.target.src = 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&auto=format&fit=crop&q=80';
                                }}
                            />
                        ) : (
                            <div className="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-emerald-100 dark:bg-emerald-950 border border-emerald-300 dark:border-emerald-700 flex items-center justify-center text-emerald-800 dark:text-emerald-300 font-bold text-xs">
                                {firstName.charAt(0).toUpperCase()}
                            </div>
                        )}
                        <span className="text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-200 hidden sm:block">
                            {firstName}
                        </span>
                        <ChevronDown className={`w-3.5 h-3.5 text-slate-400 transition-transform duration-200 ${dropdownOpen ? 'rotate-180' : ''}`} />
                    </button>

                    {/* Dropdown Menu Popup */}
                    {dropdownOpen && (
                        <div className="absolute right-0 mt-2 w-56 bg-white dark:bg-[#111827] rounded-2xl shadow-xl border border-slate-100 dark:border-slate-800 py-2 z-50 animate-slide-in">
                            <div className="px-4 py-3 border-b border-slate-100 dark:border-slate-800">
                                <p className="text-xs font-bold text-slate-900 dark:text-white truncate">{user?.name || 'Nasabah'}</p>
                                <p className="text-[11px] text-slate-500 dark:text-slate-400 truncate">{user?.email || 'nasabah@sisampah.id'}</p>
                            </div>

                            <Link
                                href="/profile"
                                className="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/60 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors"
                            >
                                <Settings className="w-4 h-4 text-slate-400" />
                                <span>Pengaturan Profil</span>
                            </Link>

                            <div className="pt-1 border-t border-slate-100 dark:border-slate-800">
                                <button
                                    onClick={handleLogout}
                                    className="flex items-center gap-2.5 w-full text-left px-4 py-2.5 text-xs font-semibold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors cursor-pointer"
                                >
                                    <LogOut className="w-4 h-4 text-rose-500" />
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
