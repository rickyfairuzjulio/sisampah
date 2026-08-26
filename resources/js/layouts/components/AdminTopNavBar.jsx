import React, { useState, useRef, useEffect } from 'react';
import { Bell, Moon, Sun, ShieldCheck, ChevronRight, ChevronDown, Settings, LogOut, User } from 'lucide-react';

export default function AdminTopNavBar({
    pageTitle = 'Dashboard Operasional',
    authData = {},
}) {
    const user = authData?.user || {};
    const bankSampahName = authData?.bank_sampah_name || 'Unit Melati Asri';
    const isSuperAdmin = authData?.is_super_admin ?? false;
    const [isDark, setIsDark] = useState(false);
    const [dropdownOpen, setDropdownOpen] = useState(false);
    const dropdownRef = useRef(null);

    const firstName = user?.name ? user.name.split(' ')[0] : 'Admin';

    const toggleTheme = () => {
        setIsDark(!isDark);
        document.documentElement.classList.toggle('dark');
    };

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
        <header className="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between sticky top-0 z-20 select-none">
            
            {/* Left: Breadcrumbs */}
            <div className="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <span className="hover:text-slate-800 transition-colors">
                    {isSuperAdmin ? 'Super Admin' : 'Admin'}
                </span>
                <ChevronRight className="w-3.5 h-3.5 text-slate-400" />
                <span className="font-extrabold text-slate-900">{pageTitle}</span>
            </div>

            {/* Right: Role Badge, Theme Toggle, Notification, and User Profile Dropdown (TANPA SEARCH BAR) */}
            <div className="flex items-center gap-2 sm:gap-3">
                
                {/* Role Badge */}
                <div className="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold shadow-2xs">
                    <ShieldCheck className="w-3.5 h-3.5 text-emerald-600" />
                    <span>{isSuperAdmin ? '👑 Super Admin Platform' : `🏢 ${bankSampahName}`}</span>
                </div>

                {/* Dark/Light Theme Toggle */}
                <button
                    type="button"
                    onClick={toggleTheme}
                    className="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors cursor-pointer"
                    title={isDark ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap'}
                >
                    {isDark ? <Sun className="w-4 h-4 text-amber-500" /> : <Moon className="w-4 h-4" />}
                </button>

                {/* Notification Bell */}
                <div className="relative">
                    <button
                        type="button"
                        className="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors cursor-pointer"
                        title="Notifikasi Sistem"
                    >
                        <Bell className="w-4 h-4" />
                    </button>
                    <span className="absolute top-2 right-2 w-2 h-2 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                </div>

                {/* Vertical Divider */}
                <div className="h-6 w-px bg-slate-200 mx-1 hidden sm:block" />

                {/* User Profile Dropdown (Identik dengan Nasabah & Petugas) */}
                <div className="relative" ref={dropdownRef}>
                    <button
                        type="button"
                        onClick={() => setDropdownOpen(!dropdownOpen)}
                        className="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 transition-colors focus:outline-none cursor-pointer"
                    >
                        {user?.avatar_url ? (
                            <img
                                src={user.avatar_url}
                                alt={user.name || 'Admin'}
                                className="w-8 h-8 sm:w-9 sm:h-9 rounded-full object-cover border-2 border-emerald-500"
                            />
                        ) : (
                            <div className="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-emerald-100 border-2 border-emerald-500 flex items-center justify-center text-emerald-800 font-bold text-xs">
                                {firstName.charAt(0).toUpperCase()}
                            </div>
                        )}
                        <span className="text-xs sm:text-sm font-bold text-slate-800 hidden sm:block">
                            {firstName}
                        </span>
                        <ChevronDown className={`w-3.5 h-3.5 text-slate-400 transition-transform duration-200 ${dropdownOpen ? 'rotate-180' : ''}`} />
                    </button>

                    {/* Dropdown Menu Popup */}
                    {dropdownOpen && (
                        <div className="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 animate-slide-in">
                            {/* User Header in Dropdown */}
                            <div className="px-4 py-3 border-b border-slate-100 space-y-1">
                                <p className="text-xs font-bold text-slate-900 truncate">
                                    {user?.name || 'Administrator'}
                                </p>
                                <p className="text-[11px] text-slate-500 font-mono truncate">
                                    {user?.email || 'admin@sisampah.id'}
                                </p>
                                <span className="inline-block text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 mt-1">
                                    {isSuperAdmin ? '👑 Super Admin Platform' : `🏢 ${bankSampahName}`}
                                </span>
                            </div>

                            {/* Menu Link: Profile */}
                            <div className="py-1">
                                <a
                                    href="/profile"
                                    className="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-emerald-700 transition-colors"
                                >
                                    <Settings className="w-4 h-4 text-slate-400" />
                                    <span>Pengaturan Profil</span>
                                </a>
                            </div>

                            {/* Menu Action: Logout */}
                            <div className="pt-1 border-t border-slate-100">
                                <form method="POST" action="/logout" className="w-full">
                                    <input type="hidden" name="_token" value={csrfToken} />
                                    <button
                                        type="submit"
                                        className="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer"
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
