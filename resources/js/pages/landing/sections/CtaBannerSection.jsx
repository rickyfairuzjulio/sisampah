import React from 'react';
import { ArrowRight, Building2, Search, Sparkles, CheckCircle } from 'lucide-react';

export default function CtaBannerSection({ authData }) {
    const isAuthenticated = authData?.is_authenticated;
    const user = authData?.user;

    return (
        <section className="relative py-16 sm:py-24 bg-[#051410] border-t border-white/[0.08] overflow-hidden">
            
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                
                {/* Banner Gradient Card */}
                <div className="relative rounded-3xl bg-gradient-to-br from-emerald-600 via-emerald-700 to-[#0D4A35] p-8 sm:p-12 lg:p-16 overflow-hidden shadow-2xl">
                    
                    {/* Background Light Pattern */}
                    <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
                    <div className="absolute -bottom-20 -left-20 w-80 h-80 bg-teal-300/15 rounded-full blur-3xl pointer-events-none" />

                    <div className="relative z-10 max-w-3xl space-y-6 text-left">
                        
                        <div className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-white text-xs font-bold uppercase tracking-wider">
                            <Sparkles className="w-3.5 h-3.5 text-emerald-200" />
                            <span>BERGABUNG BERSAMA GERAKAN HIJAU</span>
                        </div>

                        <h2 className="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight tracking-tight">
                            Siap Mewujudkan Desa Bersih, <br className="hidden sm:block" />
                            Sehat, dan Mandiri Finansial?
                        </h2>

                        <p className="text-base sm:text-lg text-emerald-50 leading-relaxed max-w-2xl">
                            Daftarkan diri Anda sebagai nasabah atau daftarkan organisasi bank sampah unit Anda untuk membangun ekonomi sirkular desa berbasis teknologi digital.
                        </p>

                        {/* CTA Buttons */}
                        <div className="flex flex-wrap items-center gap-4 pt-2">
                            {isAuthenticated ? (
                                <a 
                                    href={user?.dashboard_url || '/dashboard'}
                                    className="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-[#051410] font-black text-sm rounded-full shadow-xl hover:bg-emerald-50 transition-all hover:scale-[1.02]"
                                >
                                    <span>Buka Dashboard ({user?.name?.split(' ')[0]})</span>
                                    <ArrowRight className="w-4 h-4 text-[#051410]" />
                                </a>
                            ) : (
                                <>
                                    <a 
                                        href="/register"
                                        className="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-[#051410] font-black text-sm rounded-full shadow-xl hover:bg-emerald-50 transition-all hover:scale-[1.02]"
                                    >
                                        <span>Daftar Gratis Sekarang</span>
                                        <ArrowRight className="w-4 h-4 text-[#051410]" />
                                    </a>
                                    <a 
                                        href="/daftar-bank-sampah"
                                        className="inline-flex items-center justify-center gap-2 px-7 py-4 bg-emerald-900/40 hover:bg-emerald-900/60 border border-white/30 text-white font-bold text-sm rounded-full transition-all backdrop-blur-md"
                                    >
                                        <Building2 className="w-4 h-4 text-emerald-200" />
                                        <span>Daftarkan Bank Sampah</span>
                                    </a>
                                </>
                            )}
                        </div>

                        {/* Sub-link track */}
                        <div className="pt-2 flex items-center gap-6 text-xs text-emerald-100/80">
                            <span className="flex items-center gap-1.5">
                                <CheckCircle className="w-4 h-4 text-emerald-200" />
                                Gratis & Tanpa Iuran
                            </span>
                            <a 
                                href="/lacak-pendaftaran"
                                className="inline-flex items-center gap-1 hover:text-white transition-colors underline underline-offset-4"
                            >
                                <Search className="w-3.5 h-3.5" />
                                <span>Lacak Status Pendaftaran Mitra Unit &rarr;</span>
                            </a>
                        </div>

                    </div>

                </div>

            </div>
        </section>
    );
}
