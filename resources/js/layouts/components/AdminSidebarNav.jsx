import React from 'react';
import { Link } from '@inertiajs/react';
import {
    LayoutDashboard,
    ShieldCheck,
    Boxes,
    CreditCard,
    Tag,
    Users,
    BookOpen,
    AlertTriangle,
    MapPin,
    FileSpreadsheet,
    ArrowLeft,
    X
} from 'lucide-react';

export default function AdminSidebarNav({
    activeMenu = 'dashboard',
    authData = {},
    onCloseMobile,
}) {
    const user = authData?.user || {};
    const bankSampahName = authData?.bank_sampah_name || 'Unit Melati Asri';
    const isSuperAdmin = authData?.is_super_admin ?? false;

    const superAdminNavItems = [
        {
            key: 'dashboard',
            label: 'Dashboard Nasional',
            href: '/super-admin/dashboard',
            icon: LayoutDashboard,
            badge: 'Pusat',
        },
        {
            key: 'verification',
            label: 'Verifikasi Bank Sampah',
            href: '/super-admin/verifikasi-bank-sampah',
            icon: ShieldCheck,
            badge: 'Mitra',
        },
        {
            key: 'master_bs',
            label: 'Master Bank Sampah',
            href: '/super-admin/master-bank-sampah',
            icon: Boxes,
        },
        {
            key: 'map',
            label: 'Peta Sebaran',
            href: '/super-admin/peta-sebaran',
            icon: MapPin,
        },
        {
            key: 'articles',
            label: 'Edukasi & Artikel',
            href: '/super-admin/artikel',
            icon: BookOpen,
        },
        {
            key: 'region',
            label: 'Konfigurasi Wilayah',
            href: '/super-admin/konfigurasi-wilayah',
            icon: Tag,
        },
        {
            key: 'audit_logs',
            label: 'Audit Log Sistem',
            href: '/super-admin/audit-logs',
            icon: FileSpreadsheet,
        },
    ];

    const adminUnitNavItems = [
        {
            key: 'dashboard',
            label: 'Dashboard Operasional',
            href: '/admin/dashboard',
            icon: LayoutDashboard,
            badge: 'Utama',
        },
        {
            key: 'inventory',
            label: 'Inventaris',
            href: '/admin/inventaris',
            icon: Boxes,
            badge: 'Gudang',
        },
        {
            key: 'finance',
            label: 'Keuangan',
            href: '/admin/keuangan',
            icon: CreditCard,
        },
        {
            key: 'prices',
            label: 'Harga',
            href: '/admin/harga',
            icon: Tag,
        },
        {
            key: 'users',
            label: 'Pengguna',
            href: '/admin/pengguna',
            icon: Users,
        },
        {
            key: 'violations',
            label: 'Pelanggaran',
            href: '/admin/pelanggaran',
            icon: AlertTriangle,
        },
        {
            key: 'reports',
            label: 'Laporan',
            href: '/admin/laporan',
            icon: FileSpreadsheet,
        },
    ];

    const navItems = isSuperAdmin ? superAdminNavItems : adminUnitNavItems;

    return (
        <aside className="h-full w-[260px] bg-white dark:bg-[#0D131F] border-r border-slate-200 dark:border-slate-800 shadow-sm flex flex-col justify-between select-none transition-colors duration-200">
            
            <div className="flex flex-col flex-1 min-h-0">
                {/* 1. Header Logo SiSampah */}
                <div className="h-16 px-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between shrink-0">
                    <Link
                        href={isSuperAdmin ? '/super-admin/dashboard' : '/admin/dashboard'}
                        className="flex items-center gap-2.5 group"
                    >
                        <img
                            src="/images/logo.png"
                            alt="Logo SiSampah"
                            className="w-8 h-8 rounded-xl object-contain shadow-2xs group-hover:scale-105 transition-transform"
                            onError={(e) => {
                                e.target.onerror = null;
                                e.target.src = 'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/sprout.svg';
                            }}
                        />
                        <div className="flex flex-col">
                            <div className="font-black text-base tracking-tight text-slate-900 dark:text-white flex items-center">
                                <span>SiSampah</span>
                                <span className="text-emerald-500 font-extrabold">.</span>
                            </div>
                            <span className="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider -mt-1">
                                {isSuperAdmin ? 'Super Admin' : 'Admin Unit'}
                            </span>
                        </div>
                    </Link>

                    {onCloseMobile && (
                        <button
                            onClick={onCloseMobile}
                            className="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer"
                        >
                            <X className="w-5 h-5" />
                        </button>
                    )}
                </div>

                {/* 2. Admin Info Box */}
                <div className="mx-4 my-3 p-3 bg-slate-50 dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-xl flex items-center gap-3 shrink-0">
                    {user?.avatar_url ? (
                        <img
                            src={user.avatar_url}
                            alt={user.name}
                            className="w-10 h-10 rounded-full object-cover border-2 border-emerald-500 shrink-0"
                        />
                    ) : (
                        <div className="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-950 border-2 border-emerald-500 flex items-center justify-center text-emerald-800 dark:text-emerald-300 font-bold text-sm shrink-0">
                            {user?.name ? user.name.charAt(0).toUpperCase() : 'A'}
                        </div>
                    )}
                    <div className="min-w-0 flex-1">
                        <p className="font-bold text-[13px] text-slate-900 dark:text-white leading-tight truncate">
                            {user?.name || 'Administrator'}
                        </p>
                        <span className="text-[10px] bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/80 px-1.5 py-0.5 rounded inline-block mt-1 font-semibold truncate max-w-full">
                            {isSuperAdmin ? '👑 Super Admin' : `🏢 ${bankSampahName}`}
                        </span>
                    </div>
                </div>

                {/* 3. Section Title */}
                <div className="pt-2 pb-1.5 px-6 shrink-0">
                    <span className="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        {isSuperAdmin ? 'PENGATURAN PUSAT' : 'MENU UTAMA'}
                    </span>
                </div>

                {/* 4. Navigation Menu Items (Scrollable if overflow) */}
                <div className="px-3 space-y-1 overflow-y-auto flex-1">
                    {navItems.map((item) => {
                        const IconComponent = item.icon;
                        const isActive = activeMenu === item.key;

                        return (
                            <Link
                                key={item.key}
                                href={item.href}
                                className={`flex items-center justify-between px-3.5 py-2.5 rounded-xl font-bold text-xs transition-all duration-200 ${
                                    isActive
                                        ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 border-l-4 border-emerald-600 dark:border-emerald-500 shadow-2xs font-extrabold pl-3'
                                        : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800/60'
                                }`}
                            >
                                <div className="flex items-center gap-2.5 min-w-0">
                                    <IconComponent className={`w-4 h-4 shrink-0 ${isActive ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500'}`} />
                                    <span className="truncate">{item.label}</span>
                                </div>

                                {item.badge && (
                                    <span className={`text-[10px] px-1.5 py-0.2 rounded-md font-bold shrink-0 ${
                                        isActive
                                            ? 'bg-emerald-200 dark:bg-emerald-900 text-emerald-900 dark:text-emerald-200'
                                            : 'bg-slate-200/80 dark:bg-slate-800 text-slate-600 dark:text-slate-400'
                                    }`}>
                                        {item.badge}
                                    </span>
                                )}
                            </Link>
                        );
                    })}
                </div>
            </div>

            {/* 5. Footer Sidebar: Kembali ke Beranda */}
            <div className="p-4 border-t border-slate-100 dark:border-slate-800 bg-white dark:bg-[#0D131F] shrink-0">
                <a
                    href="/"
                    className="w-full border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 text-xs py-2.5 rounded-xl flex items-center justify-center gap-2 font-semibold transition-colors shadow-2xs cursor-pointer"
                >
                    <ArrowLeft className="w-4 h-4 text-slate-400 dark:text-slate-500" />
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

        </aside>
    );
}
