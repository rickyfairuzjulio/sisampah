import React, { useState, useRef, useEffect } from 'react';
import { Link } from '@inertiajs/react';
import { Bell, Moon, Sun, ShieldCheck, ChevronRight, ChevronDown, Settings, LogOut, User } from 'lucide-react';
import NotificationDropdown from '@/components/NotificationDropdown';
import useTheme from '@/hooks/useTheme';

export default function AdminTopNavBar({
    pageTitle = 'Dashboard Operasional',
    authData = {},
}) {
    const user = authData?.user || {};
    const bankSampahName = authData?.bank_sampah_name || 'Unit Melati Asri';
    const isSuperAdmin = authData?.is_super_admin ?? false;
    const { isDark, toggleTheme } = useTheme();
    const [dropdownOpen, setDropdownOpen] = useState(false);
    const dropdownRef = useRef(null);

    const firstName = user?.name ? user.name.split(' ')[0] : 'Admin';

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

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    return (
        <header className="h-16 bg-white dark:bg-[#0D131F] border-b border-slate-200 dark:border-slate-800 px-6 flex items-center justify-between sticky top-0 z-20 select-none transition-colors duration-200">
            
            {/* Left: Breadcrumbs */}
            <div className="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 font-medium">
                <span className="hover:text-slate-800 dark:hover:text-slate-200 transition-colors">
                    {isSuperAdmin ? 'Super Admin' : 'Admin'}
                </span>
                <ChevronRight className="w-3.5 h-3.5 text-slate-400 dark:text-slate-600" />
                <span className="font-extrabold text-slate-900 dark:text-white">{pageTitle}</span>
            </div>

            {/* Right: Role Badge, Theme Toggle, Notification, and User Profile Dropdown */}
            <div className="flex items-center gap-2 sm:gap-3">
                
                {/* Role Badge */}
                <div className="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60 text-xs font-bold shadow-2xs">
                    <ShieldCheck className="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" />
                    <span>{isSuperAdmin ? '👑 Super Admin Platform' : `🏢 ${bankSampahName}`}</span>
                </div>

                {/* Dark/Light Theme Toggle */}
                <button
                    type="button"
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
                        type="button"
                        onClick={() => setDropdownOpen(!dropdownOpen)}
                        className="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors focus:outline-none cursor-pointer"
                    >
                        {user?.avatar_url ? (
                            <img
                                src={user.avatar_url}
                                alt={user.name || 'Admin'}
                                className="w-8 h-8 sm:w-9 sm:h-9 rounded-full object-cover border-2 border-emerald-500"
                            />
                        ) : (
                            <div className="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-emerald-100 dark:bg-emerald-950 border-2 border-emerald-500 flex items-center justify-center text-emerald-800 dark:text-emerald-300 font-bold text-xs">
                                {firstName.charAt(0).toUpperCase()}
                            </div>
                        )}
                        <span className="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200 hidden sm:block">
                            {firstName}
                        </span>
                        <ChevronDown className={`w-3.5 h-3.5 text-slate-400 transition-transform duration-200 ${dropdownOpen ? 'rotate-180' : ''}`} />
                    </button>

                    {/* Dropdown Menu Popup */}
                    {dropdownOpen && (
                        <div className="absolute right-0 mt-2 w-60 bg-white dark:bg-[#111827] rounded-2xl shadow-xl border border-slate-100 dark:border-slate-800 py-2 z-50 animate-slide-in">
                            {/* User Header in Dropdown */}
                            <div className="px-4 py-3 border-b border-slate-100 dark:border-slate-800 space-y-1">
                                <p className="text-xs font-bold text-slate-900 dark:text-white truncate">
                                    {user?.name || 'Administrator'}
                                </p>
                                <p className="text-[11px] text-slate-500 dark:text-slate-400 font-mono truncate">
                                    {user?.email || 'admin@sisampah.id'}
                                </p>
                                <span className="inline-block text-[10px] font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded border border-emerald-200 dark:border-emerald-800/80 mt-1">
                                    {isSuperAdmin ? '👑 Super Admin Platform' : `🏢 ${bankSampahName}`}
                                </span>
                            </div>

                            {/* Menu Link: Profile */}
                            <div className="py-1">
                                <Link
                                    href="/profile"
                                    className="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/60 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors"
                                >
                                    <Settings className="w-4 h-4 text-slate-400" />
                                    <span>Pengaturan Profil</span>
                                </Link>
                            </div>

                            {/* Menu Action: Logout */}
                            <div className="pt-1 border-t border-slate-100 dark:border-slate-800">
                                <form method="POST" action="/logout" className="w-full">
                                    <input type="hidden" name="_token" value={csrfToken} />
                                    <button
                                        type="submit"
                                        className="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors cursor-pointer"
                                    >
                                        <LogOut className="w-4 h-4 text-rose-500" />
                                        <span>Keluar (Logout)</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    )}
                </div>

            </div>

        </header>
    );
}
