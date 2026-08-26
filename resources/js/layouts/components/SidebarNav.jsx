import React from 'react';
import { 
    LayoutGrid, 
    Tag, 
    Truck, 
    Wallet, 
    Award, 
    BookOpen, 
    ArrowLeft, 
    X,
    User
} from 'lucide-react';

export default function SidebarNav({ activeMenu = 'dashboard', authData = {}, onCloseMobile }) {
    const user = authData?.user || {};
    const bankSampahName = authData?.bank_sampah_name || 'Unit Melati';

    const menuItems = [
        {
            key: 'dashboard',
            label: 'Dashboard',
            icon: LayoutGrid,
            href: '/nasabah/dashboard',
        },
        {
            key: 'prices',
            label: 'Katalog Harga',
            icon: Tag,
            href: '/nasabah/prices',
        },
        {
            key: 'pickup',
            label: 'Jemput Sampah',
            icon: Truck,
            href: '/nasabah/jemput-sampah',
        },
        {
            key: 'wallet',
            label: 'SiSampay',
            icon: Wallet,
            href: '/nasabah/dompet',
        },
        {
            key: 'certificate',
            label: 'Sertifikat',
            icon: Award,
            href: '/nasabah/sertifikat',
        },
        {
            key: 'edukasi',
            label: 'Edukasi',
            icon: BookOpen,
            href: '/nasabah/edukasi',
        },
    ];

    return (
        <aside className="h-full w-[260px] bg-white border-r border-slate-200 shadow-sm flex flex-col justify-between select-none">
            
            <div>
                {/* 1. Header Logo */}
                <div className="h-16 flex items-center justify-between px-6 border-b border-slate-100">
                    <a href="/" className="flex items-center gap-2.5 group">
                        <img 
                            src="/images/logo.png" 
                            alt="SiSampah Logo" 
                            className="w-8 h-8 object-contain rounded-full drop-shadow-sm group-hover:scale-105 transition-transform"
                            onError={(e) => {
                                e.target.onerror = null;
                                e.target.src = 'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/sprout.svg';
                            }}
                        />
                        <span className="text-xl font-bold text-slate-900 tracking-tight">
                            SiSampah<span className="text-[#22C55E]">.</span>
                        </span>
                    </a>

                    {onCloseMobile && (
                        <button 
                            onClick={onCloseMobile}
                            className="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100"
                        >
                            <X className="w-5 h-5" />
                        </button>
                    )}
                </div>

                {/* 2. Mini Profil Nasabah Box */}
                <div className="mx-4 my-4 p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-3">
                    {user?.avatar_url ? (
                        <img 
                            src={user.avatar_url} 
                            alt={user.name || 'Nasabah Avatar'} 
                            className="w-10 h-10 rounded-full object-cover border-2 border-emerald-500 shrink-0"
                            onError={(e) => {
                                e.target.onerror = null;
                                e.target.src = 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&auto=format&fit=crop&q=80';
                            }}
                        />
                    ) : (
                        <div className="w-10 h-10 rounded-full bg-emerald-100 border-2 border-emerald-500 flex items-center justify-center text-emerald-700 font-bold shrink-0">
                            {user?.name ? user.name.charAt(0).toUpperCase() : 'N'}
                        </div>
                    )}
                    <div className="min-w-0 flex-1">
                        <p className="font-bold text-[13px] text-slate-900 leading-tight truncate">
                            {user?.name || 'Ahmad Fauzi'}
                        </p>
                        <span className="text-[10px] bg-emerald-50 text-emerald-700 border border-emerald-200 px-1.5 py-0.5 rounded inline-block mt-1 font-medium truncate max-w-full">
                            Nasabah {bankSampahName}
                        </span>
                    </div>
                </div>

                {/* 3. Label Menu */}
                <p className="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 px-6 mb-2">
                    MENU UTAMA
                </p>

                {/* 4. Menu Items Navigation */}
                <nav className="flex flex-col gap-1 px-3">
                    {menuItems.map((item) => {
                        const Icon = item.icon;
                        const isActive = activeMenu === item.key;

                        return (
                            <a
                                key={item.key}
                                href={item.href}
                                className={`flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all duration-200 ${
                                    isActive
                                        ? 'bg-emerald-50 text-emerald-700 font-bold border-l-4 border-emerald-600 shadow-sm'
                                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-semibold'
                                }`}
                            >
                                <Icon className={`w-4 h-4 shrink-0 ${isActive ? 'text-emerald-600' : 'text-slate-400'}`} />
                                <span className="truncate">{item.label}</span>
                            </a>
                        );
                    })}
                </nav>
            </div>

            {/* 5. Footer Sidebar */}
            <div className="p-4 border-t border-slate-100">
                <a
                    href="/"
                    className="w-full border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs py-2.5 rounded-xl flex items-center justify-center gap-2 font-semibold transition-colors shadow-sm"
                >
                    <ArrowLeft className="w-4 h-4 text-slate-400" />
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

        </aside>
    );
}
