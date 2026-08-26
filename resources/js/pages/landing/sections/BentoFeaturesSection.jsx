import React from 'react';
import { 
    Users, 
    Truck, 
    ShieldAlert, 
    BarChart3, 
    MapPin, 
    Sparkles, 
    Wallet, 
    Scale, 
    Award, 
    ArrowRight 
} from 'lucide-react';
import WasteCalculator from './WasteCalculator';

export default function BentoFeaturesSection({ categories = [] }) {
    return (
        <section id="fitur" className="relative py-20 lg:py-28 bg-[#051410] overflow-hidden">
            
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 sm:space-y-16 relative z-10">
                
                {/* Section Header */}
                <div className="text-center max-w-3xl mx-auto space-y-4">
                    <div className="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold uppercase tracking-wider">
                        <Sparkles className="w-3.5 h-3.5" />
                        <span>FITUR EKOSISTEM SISAMPAH</span>
                    </div>
                    <h2 className="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight">
                        Satu Ekosistem Digital untuk <br className="hidden sm:block" />
                        <span className="text-[#22C55E]">Semua Peran Komunitas Desa.</span>
                    </h2>
                    <p className="text-sm sm:text-base text-white/70 leading-relaxed">
                        Mengintegrasikan nasabah rumah tangga, petugas operasional armada jemputan, hingga admin pengelola unit bank sampah dalam satu alur kerja yang transparan.
                    </p>
                </div>

                {/* Asymmetric Bento Grid */}
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                    
                    {/* Bento Card 1: Nasabah (7 Kolom) */}
                    <div className="lg:col-span-7 rounded-3xl bg-[#061E17] border border-white/10 p-7 sm:p-8 flex flex-col justify-between hover:border-emerald-500/40 transition-all duration-300 shadow-xl group">
                        <div className="space-y-4">
                            <div className="w-12 h-12 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400">
                                <Users className="w-6 h-6" />
                            </div>
                            <span className="text-xs font-bold text-emerald-400 tracking-wider uppercase block">
                                MODUL WARGA & NASABAH
                            </span>
                            <h3 className="text-2xl sm:text-3xl font-black text-white tracking-tight group-hover:text-emerald-300 transition-colors">
                                Penjemputan Sampah GPS & Tabungan Kas Desa
                            </h3>
                            <p className="text-sm text-white/70 leading-relaxed">
                                Warga cukup memasukkan titik koordinat rumah via peta interaktif. Petugas armada akan menerima notifikasi penjemputan dan saldo langsung otomatis tercatat ke rekening kas digital nasabah.
                            </p>
                        </div>

                        <div className="mt-8 grid grid-cols-2 gap-3 pt-6 border-t border-white/10">
                            <div className="p-3.5 rounded-xl bg-white/[0.03] border border-white/[0.06]">
                                <span className="text-xs font-bold text-white block">Jemput Sampah GPS</span>
                                <span className="text-[11px] text-white/50">Radius hingga 25 KM</span>
                            </div>
                            <div className="p-3.5 rounded-xl bg-white/[0.03] border border-white/[0.06]">
                                <span className="text-xs font-bold text-white">Gamifikasi Poin & Sertifikat</span>
                                <span className="text-[11px] text-white/50">Level XP & Rapor Hijau</span>
                            </div>
                        </div>
                    </div>

                    {/* Bento Card 2: Petugas Armada (5 Kolom) */}
                    <div className="lg:col-span-5 rounded-3xl bg-[#061E17] border border-white/10 p-7 sm:p-8 flex flex-col justify-between hover:border-emerald-500/40 transition-all duration-300 shadow-xl group">
                        <div className="space-y-4">
                            <div className="w-12 h-12 rounded-2xl bg-teal-500/15 border border-teal-500/30 flex items-center justify-center text-teal-400">
                                <Truck className="w-6 h-6" />
                            </div>
                            <span className="text-xs font-bold text-teal-400 tracking-wider uppercase block">
                                MODUL PETUGAS LAPANGAN
                            </span>
                            <h3 className="text-2xl sm:text-3xl font-black text-white tracking-tight group-hover:text-teal-300 transition-colors">
                                Manifes Digital & Timbangan Terkunci
                            </h3>
                            <p className="text-sm text-white/70 leading-relaxed">
                                Petugas mendapatkan rute efisien, scan kode setoran, dan mencatat berat aktual yang langsung terkunci aman tanpa risiko manipulasi harga timbangan.
                            </p>
                        </div>

                        <div className="mt-8 p-4 rounded-2xl bg-[#041611] border border-white/5 flex items-center justify-between">
                            <div className="flex items-center gap-3">
                                <Scale className="w-5 h-5 text-emerald-400" />
                                <div>
                                    <span className="text-xs font-bold text-white block">Timbangan Terkunci Otomatis</span>
                                    <span className="text-[10px] text-white/50">Validasi barcode anti-curang</span>
                                </div>
                            </div>
                            <span className="text-xs font-extrabold text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded-full">
                                Akurat
                            </span>
                        </div>
                    </div>

                    {/* Bento Card 3: Interactive Live Calculator (Full 12 Kolom) */}
                    <div className="lg:col-span-12">
                        <WasteCalculator categories={categories} />
                    </div>

                    {/* Bento Card 4: Admin Bank Sampah Unit (6 Kolom) */}
                    <div className="lg:col-span-6 rounded-3xl bg-[#061E17] border border-white/10 p-7 sm:p-8 flex flex-col justify-between hover:border-emerald-500/40 transition-all duration-300 shadow-xl">
                        <div className="space-y-4">
                            <div className="w-12 h-12 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400">
                                <BarChart3 className="w-6 h-6" />
                            </div>
                            <span className="text-xs font-bold text-emerald-400 tracking-wider uppercase block">
                                MODUL ADMIN UNIT & KEUANGAN
                            </span>
                            <h3 className="text-xl sm:text-2xl font-black text-white tracking-tight">
                                Neraca Kas Desa & Validasi Penarikan Saldo
                            </h3>
                            <p className="text-sm text-white/70 leading-relaxed">
                                Pantau perputaran tonase sampah harian, neraca keuangan unit bank sampah desa, atur harga komoditas terkini, serta validasi pencairan dana nasabah secara transparan.
                            </p>
                        </div>

                        <div className="mt-6 flex items-center gap-4 text-xs text-white/60">
                            <span className="flex items-center gap-1.5">
                                <Award className="w-4 h-4 text-emerald-400" />
                                Laporan Mutasi Otomatis
                            </span>
                            <span className="flex items-center gap-1.5">
                                <Wallet className="w-4 h-4 text-emerald-400" />
                                Audit Ledger Kas
                            </span>
                        </div>
                    </div>

                    {/* Bento Card 5: Peta GIS & Pendaftaran Terbuka (6 Kolom) */}
                    <div className="lg:col-span-6 rounded-3xl bg-[#061E17] border border-white/10 p-7 sm:p-8 flex flex-col justify-between hover:border-emerald-500/40 transition-all duration-300 shadow-xl">
                        <div className="space-y-4">
                            <div className="w-12 h-12 rounded-2xl bg-teal-500/15 border border-teal-500/30 flex items-center justify-center text-teal-400">
                                <MapPin className="w-6 h-6" />
                            </div>
                            <span className="text-xs font-bold text-teal-400 tracking-wider uppercase block">
                                PETA SEBARAN & MITRA NASIONAL
                            </span>
                            <h3 className="text-xl sm:text-2xl font-black text-white tracking-tight">
                                Peta Interaktif & Pendaftaran Mitra Unit Baru
                            </h3>
                            <p className="text-sm text-white/70 leading-relaxed">
                                Siapapun komunitas, pengurus RW, atau karang taruna dapat mendaftarkan bank sampah baru secara daring dengan verifikasi legalitas cepat dalam 1x24 jam.
                            </p>
                        </div>

                        <div className="mt-6 pt-4 border-t border-white/10 flex items-center justify-between">
                            <a 
                                href="/daftar-bank-sampah"
                                className="inline-flex items-center gap-2 text-xs font-bold text-emerald-400 hover:text-emerald-300 transition-colors"
                            >
                                <span>Daftarkan Unit Anda Sekarang</span>
                                <ArrowRight className="w-3.5 h-3.5" />
                            </a>
                            <a 
                                href="/lacak-pendaftaran"
                                className="text-xs font-medium text-white/50 hover:text-white transition-colors"
                            >
                                Lacak Berkas &rarr;
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    );
}
