import React, { useRef } from 'react';
import { Camera, ShieldCheck, MapPin, Calendar, Mail, Phone } from 'lucide-react';

export default function PetugasProfileHeroCard({
    user = {},
    bankSampahName = 'Unit Melati Asri',
    avatarPreview = null,
    onAvatarChange,
}) {
    const fileInputRef = useRef(null);

    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-md p-6 sm:p-8 animate-slide-in select-none">
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

            <div className="relative z-10 flex flex-col sm:flex-row items-center sm:items-start gap-6">
                
                {/* Avatar with Camera Button */}
                <div className="relative group shrink-0">
                    <div className="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl overflow-hidden border-4 border-white/30 shadow-xl bg-white/10 flex items-center justify-center">
                        {avatarPreview || user?.avatar_url ? (
                            <img
                                src={avatarPreview || user.avatar_url}
                                alt={user?.name || 'Petugas'}
                                className="w-full h-full object-cover"
                            />
                        ) : (
                            <span className="text-4xl font-black text-white">
                                {user?.name ? user.name.charAt(0).toUpperCase() : 'P'}
                            </span>
                        )}
                    </div>

                    <button
                        type="button"
                        onClick={() => fileInputRef.current?.click()}
                        className="absolute -bottom-2 -right-2 p-2.5 rounded-2xl bg-white text-emerald-800 hover:bg-emerald-50 transition-all shadow-lg hover:scale-110 cursor-pointer"
                        title="Ubah Foto Profil"
                    >
                        <Camera className="w-4 h-4" />
                    </button>

                    <input
                        ref={fileInputRef}
                        type="file"
                        name="avatar"
                        accept="image/*"
                        onChange={onAvatarChange}
                        className="hidden"
                    />
                </div>

                {/* Info Text */}
                <div className="space-y-2 text-center sm:text-left min-w-0 flex-1">
                    <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-emerald-100">
                        <ShieldCheck className="w-3.5 h-3.5 text-emerald-200" />
                        <span>Petugas Lapangan & Teller Pos</span>
                    </div>

                    <h1 className="text-2xl sm:text-3xl font-black tracking-tight text-white leading-tight truncate">
                        {user?.name || 'Petugas SiSampah'}
                    </h1>

                    <div className="flex flex-wrap items-center justify-center sm:justify-start gap-3 text-xs text-emerald-100/90 font-medium">
                        <div className="flex items-center gap-1">
                            <Mail className="w-3.5 h-3.5 text-emerald-300" />
                            <span>{user?.email || 'petugas@sisampah.id'}</span>
                        </div>
                        {user?.nomor_telepon && (
                            <>
                                <span>•</span>
                                <div className="flex items-center gap-1">
                                    <Phone className="w-3.5 h-3.5 text-teal-300" />
                                    <span>{user.nomor_telepon}</span>
                                </div>
                            </>
                        )}
                    </div>

                    <div className="pt-2 flex flex-wrap items-center justify-center sm:justify-start gap-2">
                        <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-black/15 text-xs font-semibold backdrop-blur-xs text-white/90">
                            <MapPin className="w-3.5 h-3.5 text-emerald-300" />
                            <span>{bankSampahName}</span>
                        </div>
                        <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-black/15 text-xs font-semibold backdrop-blur-xs text-white/90">
                            <Calendar className="w-3.5 h-3.5 text-amber-300" />
                            <span>Bergabung: {user?.created_at_formatted || 'Mei 2026'}</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    );
}
