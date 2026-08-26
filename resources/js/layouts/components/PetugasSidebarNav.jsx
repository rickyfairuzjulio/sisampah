import React from 'react';
import { 
    ClipboardCheck, 
    ArrowDownToLine, 
    Home, 
    ShieldCheck, 
    X,
    UserCircle2,
    MapPin
} from 'lucide-react';

export default function PetugasSidebarNav({ 
    activeMenu = 'manifest', 
    authData = {}, 
    onCloseMobile 
}) {
    const user = authData?.user || {};
    const bankSampahName = authData?.bank_sampah_name || 'Unit Melati Asri';

    const menuItems = [
        {
            key: 'manifest',
            label: 'Manifes Jemput',
            icon: ClipboardCheck,
            href: '/petugas/dashboard',
        },
        {
            key: 'self_deposit',
            label: 'Setor Mandiri',
            icon: ArrowDownToLine,
            href: '/petugas/setor-mandiri',
        },
    ];

    return (
        <aside className="h-full w-[260px] bg-white border-r border-slate-200 shadow-sm flex flex-col justify-between select-none">
            
            <div>
                {/* 1. Header Logo Brand */}
                <div className="h-16 flex items-center justify-between px-6 border-b border-slate-100">
                    <a href="/petugas/dashboard" className="flex items-center gap-2.5 group">
                        <img 
                            src="/images/logo.png" 
                            alt="SiSampah Logo" 
                            className="w-8 h-8 rounded-lg shadow-2xs group-hover:scale-105 transition-transform" 
                            onError={(e) => { e.target.style.display = 'none'; }}
                        />
                        <div className="flex flex-col">
                            <span className="font-extrabold text-base tracking-tight text-slate-900 leading-tight">
                                SiSampah
                            </span>
                            <span className="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">
                                Petugas Lapangan
                            </span>
                        </div>
                    </a>

                    {/* Tombol Tutup Mobile Drawer */}
                    {onCloseMobile && (
                        <button 
                            type="button"
                            onClick={onCloseMobile} 
                            className="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors"
                        >
                            <X className="w-5 h-5" />
                        </button>
                    )}
                </div>

                {/* 2. Kartu Profil Ringkas Petugas */}
                <div className="p-4 mx-3 my-3 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50/60 border border-emerald-100/80 shadow-2xs">
                    <div className="flex items-center gap-3">
                        {user?.avatar_url ? (
                            <img 
                                src={user.avatar_url} 
                                alt={user?.name || 'Petugas'} 
                                className="w-10 h-10 rounded-full object-cover border-2 border-emerald-500 shadow-2xs shrink-0" 
                            />
                        ) : (
                            <div className="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shadow-2xs shrink-0">
                                {user?.name ? user.name.charAt(0).toUpperCase() : 'P'}
                            </div>
                        )}
                        <div className="min-w-0 flex-1">
                            <h4 className="font-extrabold text-xs text-slate-900 truncate">
                                {user?.name || 'Petugas Lapangan'}
                            </h4>
                            <div className="flex items-center gap-1 text-[10px] text-emerald-800 font-semibold mt-0.5 truncate">
                                <MapPin className="w-3 h-3 text-emerald-600 shrink-0" />
                                <span className="truncate">{bankSampahName}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {/* 3. Daftar Navigasi Menu */}
                <nav className="px-3 space-y-1 mt-2">
                    <p className="px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2">
                        Menu Petugas
                    </p>

                    {menuItems.map((item) => {
                        const Icon = item.icon;
                        const isActive = activeMenu === item.key;

                        return (
                            <a
                                key={item.key}
                                href={item.href}
                                className={`flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all relative ${
                                    isActive
                                        ? 'bg-emerald-50 text-emerald-800 border-l-4 border-emerald-600 shadow-2xs'
                                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'
                                }`}
                            >
                                <Icon 
                                    className={`w-4 h-4 transition-colors ${
                                        isActive ? 'text-emerald-700' : 'text-slate-400 group-hover:text-slate-600'
                                    }`} 
                                />
                                <span className="flex-1">{item.label}</span>
                                {isActive && (
                                    <span className="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                )}
                            </a>
                        );
                    })}
                </nav>
            </div>

            {/* 4. Bagian Footer Navigasi Bawah */}
            <div className="p-3 border-t border-slate-100 space-y-2">
                <a
                    href="/"
                    className="flex items-center justify-center gap-2 w-full py-2 px-3 bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-xl font-bold text-xs transition-colors border border-slate-200/80 shadow-2xs"
                >
                    <Home className="w-3.5 h-3.5 text-slate-400" />
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

        </aside>
    );
}
