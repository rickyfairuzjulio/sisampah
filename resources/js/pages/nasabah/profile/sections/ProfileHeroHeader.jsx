import React from 'react';
import { Sparkles, Building2, Calendar, ShieldCheck, Camera } from 'lucide-react';

export default function ProfileHeroHeader({ authData = {}, onAvatarClick }) {
    const user = authData?.user || {};
    const bankSampahName = authData?.bank_sampah_name || 'Unit Bank Sampah Induk';

    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-sm p-6 sm:p-8 animate-slide-in select-none">
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

            <div className="relative z-10 flex flex-col sm:flex-row items-center sm:items-center gap-6">
                
                {/* 1. Large Avatar with Camera Upload Trigger */}
                <div className="relative group shrink-0">
                    <div className="w-22 h-22 sm:w-24 sm:h-24 rounded-3xl bg-white/20 p-1 backdrop-blur-md border-2 border-white/30 shadow-md overflow-hidden flex items-center justify-center">
                        <img 
                            src={user.avatar_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name || 'Nasabah')}&background=025e36&color=fff&size=128&bold=true`} 
                            alt={user.name}
                            className="w-full h-full object-cover rounded-2xl"
                            onError={(e) => {
                                e.target.onerror = null;
                                e.target.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name || 'Nasabah')}&background=025e36&color=fff&size=128&bold=true`;
                            }}
                        />
                    </div>
                    {onAvatarClick && (
                        <button
                            type="button"
                            onClick={onAvatarClick}
                            className="absolute -bottom-1.5 -right-1.5 w-8 h-8 rounded-full bg-white text-emerald-700 shadow-md flex items-center justify-center hover:scale-110 active:scale-95 transition-all border border-emerald-100 focus:outline-none"
                            title="Ganti Foto Profil"
                        >
                            <Camera className="w-4 h-4" />
                        </button>
                    )}
                </div>

                {/* 2. User Info & Badges */}
                <div className="text-center sm:text-left space-y-2 flex-1 min-w-0">
                    <div>
                        <h1 className="text-2xl sm:text-3xl font-black text-white tracking-tight truncate">
                            {user.name || 'Nasabah SiSampah'}
                        </h1>
                        <p className="text-emerald-100 text-xs sm:text-sm font-medium mt-0.5 truncate">
                            {user.email || 'nama@email.com'}
                        </p>
                    </div>

                    {/* Badges Row */}
                    <div className="flex flex-wrap items-center justify-center sm:justify-start gap-2 pt-1">
                        <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-bold shadow-2xs">
                            <ShieldCheck className="w-3.5 h-3.5 text-emerald-200" />
                            <span>Nasabah Terverifikasi</span>
                        </span>

                        <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-emerald-100 text-xs font-semibold shadow-2xs">
                            <Building2 className="w-3.5 h-3.5 text-emerald-300" />
                            <span>Unit: {bankSampahName}</span>
                        </span>

                        {user.created_at_formatted && (
                            <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/5 text-emerald-200 text-xs font-medium border border-white/10">
                                <Calendar className="w-3.5 h-3.5 text-emerald-300" />
                                <span>Bergabung sejak {user.created_at_formatted}</span>
                            </span>
                        )}
                    </div>
                </div>

            </div>

        </div>
    );
}
