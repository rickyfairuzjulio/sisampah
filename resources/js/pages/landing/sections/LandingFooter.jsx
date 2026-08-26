import React from 'react';
import { Sprout, Check, ShieldCheck, Heart, Award } from 'lucide-react';

export default function LandingFooter() {
    const currentYear = new Date().getFullYear();

    return (
        <footer className="bg-[#030E0B] border-t border-white/10 text-white relative overflow-hidden">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 relative z-10 space-y-10">
                
                {/* Top 4-Column Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                    
                    {/* Column 1: Brand Info */}
                    <div className="space-y-4">
                        <div className="flex items-center gap-2.5">
                            <img 
                                src="/images/logo.png" 
                                alt="SiSampah Logo" 
                                className="w-10 h-10 object-contain drop-shadow"
                                onError={(e) => {
                                    e.target.onerror = null;
                                    e.target.src = 'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/sprout.svg';
                                }}
                            />
                            <span className="text-2xl font-black text-white tracking-tight">
                                SiSampah<span className="text-[#22C55E]">.</span>
                            </span>
                        </div>
                        <p className="text-white/60 text-xs sm:text-sm leading-relaxed">
                            Platform pintar tata kelola bank sampah digital terintegrasi untuk mewujudkan desa yang bersih, mandiri energi, dan menyejahterakan masyarakat.
                        </p>
                        <div className="pt-2 flex items-center gap-2 text-xs text-emerald-400">
                            <ShieldCheck className="w-4 h-4" />
                            <span className="font-semibold">Transparan & Terenkripsi Aman</span>
                        </div>
                    </div>

                    {/* Column 2: Fitur Platform */}
                    <div className="space-y-4">
                        <h4 className="font-extrabold text-sm uppercase tracking-wider text-emerald-400">
                            Fitur Ekosistem
                        </h4>
                        <ul className="space-y-2.5 text-xs sm:text-sm text-white/70">
                            <li className="flex items-center gap-2">
                                <span className="text-emerald-400">✓</span> Penjemputan Berbasis GPS
                            </li>
                            <li className="flex items-center gap-2">
                                <span className="text-emerald-400">✓</span> Timbangan Digital Terkunci
                            </li>
                            <li className="flex items-center gap-2">
                                <span className="text-emerald-400">✓</span> Dompet Kas SiSampah Pay
                            </li>
                            <li className="flex items-center gap-2">
                                <span className="text-emerald-400">✓</span> Rapor Emisi Karbon & XP
                            </li>
                            <li className="flex items-center gap-2">
                                <span className="text-emerald-400">✓</span> Portal Registrasi Mitra Unit
                            </li>
                        </ul>
                    </div>

                    {/* Column 3: Navigasi Cepat */}
                    <div className="space-y-4">
                        <h4 className="font-extrabold text-sm uppercase tracking-wider text-emerald-400">
                            Tautan Penting
                        </h4>
                        <ul className="space-y-2.5 text-xs sm:text-sm text-white/70">
                            <li>
                                <a href="#fitur" className="hover:text-emerald-400 transition-colors">Fitur Unggulan</a>
                            </li>
                            <li>
                                <a href="#cara-kerja" className="hover:text-emerald-400 transition-colors">Cara Kerja</a>
                            </li>
                            <li>
                                <a href="#dampak" className="hover:text-emerald-400 transition-colors">Dampak Lingkungan</a>
                            </li>
                            <li>
                                <a href="/edukasi" className="hover:text-emerald-400 transition-colors">Artikel Edukasi</a>
                            </li>
                            <li>
                                <a href="/daftar-bank-sampah" className="hover:text-emerald-400 transition-colors">Daftar Mitra Bank Sampah</a>
                            </li>
                            <li>
                                <a href="/lacak-pendaftaran" className="hover:text-emerald-400 transition-colors">Lacak Berkas Pendaftaran</a>
                            </li>
                        </ul>
                    </div>

                    {/* Column 4: Pengembang */}
                    <div className="space-y-4">
                        <h4 className="font-extrabold text-sm uppercase tracking-wider text-emerald-400">
                            Karya Pengembang
                        </h4>
                        <div className="space-y-3 text-xs sm:text-sm text-white/70">
                            <div className="p-3.5 rounded-2xl bg-white/[0.03] border border-white/[0.06] space-y-1">
                                <span className="font-bold text-white block">Bodrex Developer</span>
                                <span className="text-[11px] text-white/50 block">Walisongo Science Competition</span>
                                <span className="text-[11px] text-emerald-300 block">UIN Walisongo Semarang</span>
                            </div>
                            <p className="text-[11px] text-white/50 leading-relaxed">
                                Didedikasikan untuk memajukan pengelolaan limbah berkelanjutan di Indonesia.
                            </p>
                        </div>
                    </div>

                </div>

                {/* Bottom Copyright Bar */}
                <div className="pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between text-white/50 text-xs gap-4">
                    <p>&copy; {currentYear} SiSampah — Bodrex Developer. Hak cipta dilindungi undang-undang.</p>
                    <div className="flex items-center gap-3">
                        <span className="px-2.5 py-1 bg-white/5 border border-white/10 rounded-lg text-white/70">
                            v2.0 React Edition
                        </span>
                        <span className="px-2.5 py-1 bg-emerald-500/20 text-emerald-400 font-bold rounded-lg border border-emerald-500/30 flex items-center gap-1">
                            <Award className="w-3.5 h-3.5" />
                            <span>Kompetisi Edition</span>
                        </span>
                    </div>
                </div>

            </div>
        </footer>
    );
}
