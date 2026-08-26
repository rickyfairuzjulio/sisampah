import React from 'react';
import { 
    ArrowRight, 
    Building2, 
    Check, 
    Sprout, 
    MapPin, 
    ShieldCheck, 
    Wallet, 
    TrendingUp, 
    Search,
    Sparkles,
    Scale
} from 'lucide-react';

export default function HeroSection({ authData, stats }) {
    const isAuthenticated = authData?.is_authenticated;
    const user = authData?.user;

    return (
        <section className="relative min-h-[92vh] flex items-center overflow-hidden bg-[#051410] pt-28 pb-16 lg:pt-36 lg:pb-24">
            
            {/* Atmospheric Background Glow Blobs */}
            <div className="absolute -top-32 -left-32 w-[550px] h-[550px] bg-emerald-500/20 rounded-full mix-blend-screen filter blur-[120px] pointer-events-none animate-float" />
            <div className="absolute top-1/2 -right-20 w-[450px] h-[450px] bg-emerald-500/15 rounded-full mix-blend-screen filter blur-[100px] pointer-events-none animate-float-delayed" />
            
            <div className="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                    
                    {/* ZONA KIRI: Teks & Aksi Utama (7 Kolom Desktop) */}
                    <div className="lg:col-span-7 text-left space-y-7">
                        
                        {/* Top Pill Badge */}
                        <div className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-semibold shadow-inner">
                            <Sparkles className="w-3.5 h-3.5 text-emerald-400" />
                            <span>Bank Sampah Digital #1 untuk Desa</span>
                        </div>

                        {/* Headline */}
                        <h1 className="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-[1.12] tracking-tight">
                            Sampah Hari Ini,<br />
                            <span className="text-[#22C55E] relative inline-block">
                                Manfaat untuk Nanti.
                                <svg 
                                    className="absolute w-full h-3 -bottom-1.5 left-0 text-emerald-400 opacity-60 pointer-events-none" 
                                    preserveAspectRatio="none" 
                                    viewBox="0 0 100 10"
                                >
                                    <path d="M0 5 Q 50 10 100 5" fill="transparent" stroke="currentColor" strokeWidth="2.5" />
                                </svg>
                            </span>
                        </h1>

                        {/* Subtitle */}
                        <p className="text-base sm:text-lg text-white/70 leading-relaxed max-w-xl">
                            SiSampah menghubungkan warga nasabah, petugas armada, dan pengelola bank sampah dalam satu ekosistem digital untuk lingkungan yang lebih bersih dan ekonomi desa yang sejahtera.
                        </p>

                        {/* 3 Quick Benefit Tiles */}
                        <div className="grid grid-cols-1 sm:grid-cols-3 gap-3.5 max-w-xl pt-1">
                            <div className="flex items-center gap-3 p-2.5 rounded-xl bg-white/[0.03] border border-white/[0.06]">
                                <div className="w-9 h-9 rounded-lg bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
                                    <Sprout className="w-4 h-4" />
                                </div>
                                <div>
                                    <h4 className="text-xs font-bold text-white leading-tight">Setor Sampah</h4>
                                    <p className="text-[11px] text-white/50 mt-0.5">Mudah & Praktis</p>
                                </div>
                            </div>

                            <div className="flex items-center gap-3 p-2.5 rounded-xl bg-white/[0.03] border border-white/[0.06]">
                                <div className="w-9 h-9 rounded-lg bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
                                    <MapPin className="w-4 h-4" />
                                </div>
                                <div>
                                    <h4 className="text-xs font-bold text-white leading-tight">Jemput via GPS</h4>
                                    <p className="text-[11px] text-white/50 mt-0.5">Cepat & Tepat</p>
                                </div>
                            </div>

                            <div className="flex items-center gap-3 p-2.5 rounded-xl bg-white/[0.03] border border-white/[0.06]">
                                <div className="w-9 h-9 rounded-lg bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
                                    <ShieldCheck className="w-4 h-4" />
                                </div>
                                <div>
                                    <h4 className="text-xs font-bold text-white leading-tight">Dampak Nyata</h4>
                                    <p className="text-[11px] text-white/50 mt-0.5">Bumi Lestari</p>
                                </div>
                            </div>
                        </div>

                        {/* CTA Button Group */}
                        <div className="flex flex-wrap items-center gap-4 pt-2">
                            {isAuthenticated ? (
                                <a 
                                    href={user?.dashboard_url || '/dashboard'}
                                    className="inline-flex items-center justify-center gap-2.5 px-8 py-3.5 bg-[#22C55E] hover:bg-emerald-400 text-white font-bold rounded-full transition-all shadow-xl shadow-emerald-500/25 hover:scale-[1.02]"
                                >
                                    <span>Buka Dashboard ({user?.name?.split(' ')[0]})</span>
                                    <ArrowRight className="w-4 h-4" />
                                </a>
                            ) : (
                                <>
                                    <a 
                                        href="/register" 
                                        className="inline-flex items-center justify-center gap-2.5 px-8 py-3.5 bg-[#22C55E] hover:bg-emerald-400 text-white font-bold rounded-full transition-all shadow-xl shadow-emerald-500/25 hover:scale-[1.02]"
                                    >
                                        <span>Mulai Gratis</span>
                                        <ArrowRight className="w-4 h-4" />
                                    </a>
                                    <a 
                                        href="/daftar-bank-sampah" 
                                        className="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-white/5 hover:bg-white/10 border border-emerald-500/40 text-white font-bold rounded-full transition-all hover:border-emerald-400"
                                    >
                                        <Building2 className="w-4 h-4 text-emerald-400" />
                                        <span>Daftarkan Bank Sampah</span>
                                    </a>
                                </>
                            )}
                        </div>

                        {/* Trust Checkmarks & Track Link */}
                        <div className="flex flex-wrap items-center gap-6 text-xs font-semibold text-white/70 pt-2 border-t border-white/[0.08]">
                            <span className="flex items-center gap-1.5">
                                <span className="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px]">
                                    <Check className="w-3 h-3" />
                                </span>
                                100% Gratis untuk Nasabah
                            </span>
                            <span className="flex items-center gap-1.5">
                                <span className="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px]">
                                    <Check className="w-3 h-3" />
                                </span>
                                Penimbangan Akurat via GPS
                            </span>
                            <a 
                                href="/lacak-pendaftaran" 
                                className="inline-flex items-center gap-1 text-emerald-400 hover:text-emerald-300 transition-colors ml-auto text-xs"
                            >
                                <Search className="w-3 h-3" />
                                <span>Lacak Pendaftaran Mitra &rarr;</span>
                            </a>
                        </div>

                    </div>

                    {/* ZONA KANAN: Mockup Card Interaktif (5 Kolom Desktop) */}
                    <div className="lg:col-span-5 relative">
                        
                        {/* Decorative Outer Glow Ring */}
                        <div className="absolute -inset-1 bg-gradient-to-r from-emerald-500/30 via-emerald-400/20 to-teal-500/30 rounded-3xl blur-xl opacity-75 animate-pulse" />
                        
                        {/* Master Glassmorphic Mockup Container */}
                        <div className="relative rounded-3xl bg-[#061E17]/90 border border-white/10 backdrop-blur-xl p-6 sm:p-7 shadow-2xl space-y-5">
                            
                            {/* Card Header: Brand Wallet */}
                            <div className="flex items-center justify-between border-b border-white/10 pb-4">
                                <div className="flex items-center gap-2.5">
                                    <div className="w-9 h-9 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400">
                                        <Wallet className="w-5 h-5" />
                                    </div>
                                    <div>
                                        <h3 className="text-sm font-bold text-white leading-tight">SiSampah Pay</h3>
                                        <p className="text-[11px] text-white/50">Dompet Lingkungan Digital</p>
                                    </div>
                                </div>
                                <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 text-[10px] font-bold">
                                    <span className="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping" />
                                    TERVERIFIKASI
                                </span>
                            </div>

                            {/* Saldo Simulation / Live View */}
                            <div className="p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-emerald-950/60 to-[#041611] border border-emerald-500/20 space-y-2">
                                <span className="text-[11px] font-medium text-emerald-300/80 uppercase tracking-wider">
                                    Estimasi Tabungan Sampah
                                </span>
                                <div className="flex items-baseline justify-between">
                                    <span className="text-3xl sm:text-4xl font-black text-white tracking-tight">
                                        Rp 284.500
                                    </span>
                                    <span className="inline-flex items-center gap-1 text-xs font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-md">
                                        <TrendingUp className="w-3 h-3" />
                                        +14.2%
                                    </span>
                                </div>
                                <div className="pt-2 flex items-center justify-between text-xs text-white/60 border-t border-white/5">
                                    <span>Total Terkumpul: <strong className="text-white">42.8 Kg</strong></span>
                                    <span>Reduksi: <strong className="text-emerald-400">53.5 kg CO₂</strong></span>
                                </div>
                            </div>

                            {/* Live Transaction Mini Feed */}
                            <div className="space-y-2.5">
                                <span className="text-[11px] font-bold text-white/50 uppercase tracking-wider block">
                                    Aktivitas Penjemputan Terkini
                                </span>
                                
                                <div className="flex items-center justify-between p-3 rounded-xl bg-white/[0.03] border border-white/[0.06] hover:border-emerald-500/30 transition-colors">
                                    <div className="flex items-center gap-3">
                                        <div className="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                                            <Scale className="w-4 h-4" />
                                        </div>
                                        <div>
                                            <p className="text-xs font-bold text-white">Setoran Botol PET & Kardus</p>
                                            <p className="text-[10px] text-white/50">Unit Bank Sampah Melati • 12.5 Kg</p>
                                        </div>
                                    </div>
                                    <span className="text-xs font-black text-emerald-400">+Rp 48.000</span>
                                </div>

                                <div className="flex items-center justify-between p-3 rounded-xl bg-white/[0.03] border border-white/[0.06] hover:border-emerald-500/30 transition-colors">
                                    <div className="flex items-center gap-3">
                                        <div className="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                                            <MapPin className="w-4 h-4" />
                                        </div>
                                        <div>
                                            <p className="text-xs font-bold text-white">Armada Tiba di Lokasi</p>
                                            <p className="text-[10px] text-white/50">RT 04 / RW 02 • Jemputan Selesai</p>
                                        </div>
                                    </div>
                                    <span className="px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-bold border border-emerald-500/20">
                                        Selesai
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    );
}
