import React from 'react';
import { 
    Clock, 
    MapPin, 
    MessageCircle, 
    Scale, 
    ArrowRight, 
    CheckCircle2, 
    Boxes, 
    User 
} from 'lucide-react';

export default function PickupManifestList({ 
    pickupManifest = [] 
}) {
    if (!pickupManifest || pickupManifest.length === 0) {
        return (
            <div className="bg-white border border-slate-200 rounded-3xl p-8 sm:p-12 text-center space-y-4 shadow-2xs select-none">
                <div className="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto shadow-2xs">
                    <CheckCircle2 className="w-7 h-7" />
                </div>
                <div className="space-y-1">
                    <h3 className="text-base sm:text-lg font-black text-slate-900">
                        Tidak Ada Antrean Penjemputan
                    </h3>
                    <p className="text-xs text-slate-500 max-w-md mx-auto">
                        Semua permintaan penjemputan sampah dari nasabah telah selesai diproses. Istirahat sejenak atau buka menu Setor Mandiri jika ada nasabah walk-in.
                    </p>
                </div>
                <div className="pt-2">
                    <a
                        href="/petugas/setor-mandiri"
                        className="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition-all"
                    >
                        <span>Buka Menu Setor Mandiri</span>
                        <ArrowRight className="w-3.5 h-3.5" />
                    </a>
                </div>
            </div>
        );
    }

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-5 select-none">
            
            {/* Card Header */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-2 border-b border-slate-100">
                <div>
                    <h2 className="text-lg font-black text-slate-900 tracking-tight">
                        Manifes Antrean Penjemputan
                    </h2>
                    <p className="text-xs text-slate-500 mt-0.5">
                        Daftar permintaan jemput sampah aktif yang menunggu konfirmasi & timbangan di lokasi
                    </p>
                </div>
                <div className="self-start sm:self-auto">
                    <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold shadow-2xs">
                        <span className="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <span>{pickupManifest.length} Menunggu Timbangan</span>
                    </span>
                </div>
            </div>

            {/* List of Pending Manifest Items */}
            <div className="space-y-4">
                {pickupManifest.map((item, idx) => (
                    <div
                        key={idx}
                        className="p-5 rounded-2xl bg-slate-50/70 border border-slate-200/80 hover:border-emerald-500/50 hover:bg-emerald-50/20 hover:shadow-md transition-all flex flex-col lg:flex-row lg:items-center justify-between gap-5 group"
                    >
                        {/* Left: Nasabah Info & Address */}
                        <div className="flex items-start gap-4 min-w-0 flex-1">
                            {item.avatar_url ? (
                                <img
                                    src={item.avatar_url}
                                    alt={item.user_name}
                                    className="w-12 h-12 rounded-2xl object-cover border-2 border-slate-200 group-hover:border-emerald-500 transition-colors shrink-0 shadow-2xs"
                                />
                            ) : (
                                <div className="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-black text-base shrink-0 shadow-2xs">
                                    {item.user_name ? item.user_name.charAt(0).toUpperCase() : 'N'}
                                </div>
                            )}

                            <div className="space-y-1.5 min-w-0">
                                <div className="flex flex-wrap items-center gap-2">
                                    <h3 className="font-extrabold text-sm sm:text-base text-slate-900 group-hover:text-emerald-700 transition-colors truncate">
                                        {item.user_name}
                                    </h3>
                                    <span className="px-2 py-0.2 rounded-md bg-white border border-slate-200 text-[10px] font-bold text-slate-600 shadow-2xs">
                                        {item.bank_sampah_name}
                                    </span>
                                </div>

                                <div className="flex items-start gap-1.5 text-xs text-slate-600">
                                    <MapPin className="w-3.5 h-3.5 text-slate-400 shrink-0 mt-0.5" />
                                    <span className="line-clamp-2 leading-relaxed">
                                        {item.address}
                                    </span>
                                </div>

                                <div className="flex flex-wrap items-center gap-3 text-[11px] text-slate-400 font-medium pt-0.5">
                                    <div className="flex items-center gap-1 text-amber-700 font-semibold">
                                        <Clock className="w-3.5 h-3.5 text-amber-500" />
                                        <span>Diminta {item.created_at_formatted}</span>
                                    </div>
                                    <span>•</span>
                                    <div className="flex items-center gap-1 text-slate-600 font-semibold">
                                        <Scale className="w-3.5 h-3.5 text-slate-500" />
                                        <span>Est. {Number(item.total_berat).toFixed(1)} Kg</span>
                                    </div>
                                    <span>•</span>
                                    <div className="flex items-center gap-1 text-slate-600">
                                        <Boxes className="w-3.5 h-3.5 text-slate-400" />
                                        <span>{item.total_items} Kategori Pilahan</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Right: Actions (WhatsApp & Timbang Button) */}
                        <div className="flex flex-wrap sm:flex-nowrap items-center gap-2.5 shrink-0 pt-2 lg:pt-0 border-t lg:border-t-0 border-slate-200/60">
                            {item.wa_link && (
                                <a
                                    href={item.wa_link}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="px-3.5 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-xl font-bold text-xs flex items-center gap-1.5 transition-colors shadow-2xs"
                                    title="Hubungi Nasabah via WhatsApp"
                                >
                                    <MessageCircle className="w-4 h-4 text-emerald-600" />
                                    <span className="hidden sm:inline">WhatsApp</span>
                                </a>
                            )}

                            <a
                                href={item.weighing_url}
                                className="flex-1 sm:flex-initial px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-extrabold text-xs flex items-center justify-center gap-2 shadow-sm hover:shadow transition-all group-hover:scale-[1.02] cursor-pointer"
                            >
                                <Scale className="w-4 h-4 text-emerald-200" />
                                <span>Timbang & Proses ➔</span>
                            </a>
                        </div>
                    </div>
                ))}
            </div>

        </div>
    );
}
