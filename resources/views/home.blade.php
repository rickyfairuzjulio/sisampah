@extends('layouts.landing')

@php
    $dash = 'nasabah.dashboard';
    if (auth()->check()) {
        $dash = auth()->user()->hasRole('admin') ? 'admin.dashboard'
            : (auth()->user()->hasRole('petugas') ? 'petugas.dashboard' : 'nasabah.dashboard');
    }
@endphp

@section('content')

{{-- ═══════════════ HERO ═══════════════ --}}
<section class="relative min-h-[100dvh] flex items-center overflow-hidden bg-[#051410]">
    <div class="landing-blob w-[500px] h-[500px] bg-emerald-500/20 -top-32 -left-32 blur-[100px]"></div>
    <div class="landing-blob w-[400px] h-[400px] bg-emerald-500/15 top-1/2 right-0 blur-[100px] animation-delay-2000" style="animation-delay: 2s"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-16 lg:pt-36 lg:pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            
            <!-- Left Hero Content -->
            <div class="text-left">
                <!-- Top Badge Pill -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-semibold mb-6">
                    <i class="bi bi-buildings text-sm"></i>
                    Bank Sampah Digital #1 untuk Desa
                </div>

                <!-- Main Headline -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-[1.12] tracking-tight mb-6">
                    Sampah Hari Ini,<br>
                    <span class="text-emerald-400">Manfaat untuk Nanti.</span>
                </h1>

                <!-- Subtitle Text -->
                <p class="text-base sm:text-lg text-white/70 leading-relaxed max-w-xl mb-8">
                    SiSampah menghubungkan nasabah, petugas, dan admin dalam satu ekosistem digital untuk lingkungan yang lebih bersih dan berkelanjutan.
                </p>

                <!-- 3 Feature Badges -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-9 max-w-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
                            <i class="bi bi-sprout text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white leading-tight">Setor Sampah</h4>
                            <p class="text-[11px] text-white/50 mt-0.5">Mudah &amp; Praktis</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
                            <i class="bi bi-geo-alt text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white leading-tight">Jemput via GPS</h4>
                            <p class="text-[11px] text-white/50 mt-0.5">Cepat &amp; Tepat</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
                            <i class="bi bi-shield-check text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white leading-tight">Dampak Nyata</h4>
                            <p class="text-[11px] text-white/50 mt-0.5">Untuk Bumi Kita</p>
                        </div>
                    </div>
                </div>

                <!-- Primary Action Buttons -->
                <div class="flex flex-wrap items-center gap-4 mb-8">
                    @auth
                        <a href="{{ route($dash) }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-emerald-500 hover:bg-emerald-400 text-white font-bold rounded-full transition-all shadow-lg shadow-emerald-500/25">
                            Buka Dashboard <i class="bi bi-arrow-right text-base"></i>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-emerald-500 hover:bg-emerald-400 text-white font-bold rounded-full transition-all shadow-lg shadow-emerald-500/25">
                            Mulai Gratis <i class="bi bi-arrow-right text-base"></i>
                        </a>
                        <a href="{{ route('pendaftaran_bank_sampah.index') }}" class="inline-flex items-center justify-center gap-2.5 px-7 py-3.5 bg-transparent border border-emerald-500/40 hover:bg-emerald-500/10 text-white font-bold rounded-full transition-all">
                            <i class="bi bi-buildings text-emerald-400"></i> Daftarkan Bank Sampah
                        </a>
                    @endauth
                </div>

                <!-- Bottom Checkmarks -->
                <div class="flex items-center gap-6 text-xs font-semibold text-white/70">
                    <span class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs"><i class="bi bi-check-lg"></i></span>
                        Gratis untuk nasabah
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs"><i class="bi bi-check-lg"></i></span>
                        Jemput via GPS
                    </span>
                </div>
            </div>

            <!-- Right Hero Card Mockup -->
            <div class="relative flex justify-center lg:justify-end">
                <div class="relative w-full max-w-md">
                    <!-- Glow Background Effect -->
                    <div class="absolute -inset-2 bg-emerald-500/20 rounded-[34px] blur-2xl"></div>

                    <!-- Saldo Nasabah Card -->
                    <div class="relative bg-[#061e17]/90 border border-emerald-500/30 p-7 sm:p-8 rounded-[28px] shadow-2xl backdrop-blur-xl space-y-6">
                        
                        <!-- Top Saldo Row -->
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[11px] font-bold text-emerald-400 uppercase tracking-widest">SALDO NASABAH</p>
                                <h3 class="text-4xl sm:text-5xl font-black text-white tracking-tight mt-1">Rp 245.000</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
                                <i class="bi bi-wallet2 text-xl"></i>
                            </div>
                        </div>

                        <!-- 3 Items List -->
                        <div class="space-y-3">
                            <!-- Plastik -->
                            <div class="flex items-center justify-between p-3.5 rounded-2xl bg-[#041611]/90 border border-white/10 hover:border-emerald-500/40 transition-all cursor-pointer group">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-xl bg-blue-500/15 border border-blue-500/30 text-blue-400 flex items-center justify-center shrink-0">
                                        <i class="bi bi-cup-straw text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-white group-hover:text-emerald-400 transition-colors">Plastik</h4>
                                        <p class="text-xs text-white/50 mt-0.5">12.5 Kg</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-black text-emerald-400">+Rp 18.750</span>
                                    <i class="bi bi-chevron-right text-xs text-white/40 group-hover:text-emerald-400 transition-colors"></i>
                                </div>
                            </div>

                            <!-- Kertas -->
                            <div class="flex items-center justify-between p-3.5 rounded-2xl bg-[#041611]/90 border border-white/10 hover:border-emerald-500/40 transition-all cursor-pointer group">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-xl bg-amber-500/15 border border-amber-500/30 text-amber-400 flex items-center justify-center shrink-0">
                                        <i class="bi bi-file-earmark-text text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-white group-hover:text-emerald-400 transition-colors">Kertas</h4>
                                        <p class="text-xs text-white/50 mt-0.5">8.0 Kg</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-black text-emerald-400">+Rp 12.000</span>
                                    <i class="bi bi-chevron-right text-xs text-white/40 group-hover:text-emerald-400 transition-colors"></i>
                                </div>
                            </div>

                            <!-- Organik -->
                            <div class="flex items-center justify-between p-3.5 rounded-2xl bg-[#041611]/90 border border-white/10 hover:border-emerald-500/40 transition-all cursor-pointer group">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 flex items-center justify-center shrink-0">
                                        <i class="bi bi-tree text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-white group-hover:text-emerald-400 transition-colors">Organik</h4>
                                        <p class="text-xs text-white/50 mt-0.5">5.5 Kg</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-black text-emerald-400">+Rp 8.250</span>
                                    <i class="bi bi-chevron-right text-xs text-white/40 group-hover:text-emerald-400 transition-colors"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Badge Pill Row -->
                        <div class="p-3.5 rounded-2xl bg-[#041611]/90 border border-white/10 flex items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500/15 text-emerald-400 flex items-center justify-center shrink-0">
                                    <i class="bi bi-leaf text-base"></i>
                                </div>
                                <div>
                                    <h5 class="font-bold text-white text-xs">+120 poin lingkungan</h5>
                                    <p class="text-[10px] text-white/50">Terus tingkatkan kontribusimu!</p>
                                </div>
                            </div>
                            <div class="h-8 w-px bg-white/10"></div>
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-amber-500/15 text-amber-400 flex items-center justify-center shrink-0">
                                    <i class="bi bi-trophy text-base"></i>
                                </div>
                                <div>
                                    <h5 class="font-bold text-white text-xs">Naik peringkat #3</h5>
                                    <p class="text-[10px] text-white/50">Ayo kejar posisi #1!</p>
                                </div>
                                <i class="bi bi-chevron-right text-xs text-white/40"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════ MARQUEE ═══════════════ --}}
<section class="py-4 border-y border-white/10 bg-[#0a1f17]/50 overflow-hidden">
    <div class="landing-marquee">
        @foreach(array_merge(['Plastik', 'Kertas', 'Kardus', 'Logam', 'Kaca', 'Organik', 'E-Waste', 'Botol PET'], ['Plastik', 'Kertas', 'Kardus', 'Logam', 'Kaca', 'Organik', 'E-Waste', 'Botol PET']) as $kategori)
            <span class="flex items-center gap-3 px-6 text-sm font-semibold text-white/40 whitespace-nowrap">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald"></span>
                {{ $kategori }}
            </span>
        @endforeach
    </div>
</section>

{{-- ═══════════════ FITUR BENTO ═══════════════ --}}
<section id="fitur" class="py-16 sm:py-20 lg:py-28" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
         class="transition-all duration-1000 ease-out opacity-0 translate-y-8">
        <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
            <p class="text-emerald text-sm font-semibold uppercase tracking-widest mb-3">Fitur Lengkap</p>
            <h2 class="landing-section-title font-bold mb-4">Satu Platform, Tiga Peran</h2>
            <p class="text-white/50 text-base sm:text-lg">Dirancang khusus untuk ekosistem bank sampah desa — dari setoran hingga laporan admin.</p>
        </div>

        <div class="landing-bento">
            <div class="landing-card landing-bento-item-lg group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald/10 rounded-full blur-3xl group-hover:bg-emerald/20 transition-colors"></div>
                <span class="inline-block px-3 py-1 text-xs font-bold bg-emerald/20 text-emerald rounded-full mb-4">Nasabah</span>
                <h3 class="text-xl lg:text-2xl font-bold mb-3">Setor, Pantau, Tarik</h3>
                <p class="text-white/50 text-sm leading-relaxed mb-6">Dashboard saldo real-time, jadwal jemput dengan GPS, riwayat transaksi, penarikan tunai/transfer, dan papan peringkat komunitas.</p>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-white/60">
                    <li class="flex items-center gap-2"><span class="text-emerald">✓</span> Penjemputan GPS</li>
                    <li class="flex items-center gap-2"><span class="text-emerald">✓</span> Dompet digital</li>
                    <li class="flex items-center gap-2"><span class="text-emerald">✓</span> Sistem poin</li>
                    <li class="flex items-center gap-2"><span class="text-emerald">✓</span> Edukasi daur ulang</li>
                </ul>
            </div>

            <div class="landing-card landing-bento-item-md">
                <span class="inline-block px-3 py-1 text-xs font-bold bg-blue-500/20 text-blue-300 rounded-full mb-4">Petugas</span>
                <h3 class="text-lg lg:text-xl font-bold mb-2">Manifes & Timbangan</h3>
                <p class="text-white/50 text-sm leading-relaxed">Kelola jemputan pending, input timbangan dengan snapshot harga, setor mandiri, dan foto bukti transaksi.</p>
            </div>

            <div class="landing-card landing-bento-item-sm">
                <span class="inline-block px-3 py-1 text-xs font-bold bg-amber-500/20 text-amber-300 rounded-full mb-4">Admin</span>
                <h3 class="text-lg font-bold mb-2">Kontrol Penuh</h3>
                <p class="text-white/50 text-sm">Harga sampah, validasi penarikan, laporan RT/RW, ekspor CSV.</p>
            </div>

            <div class="landing-card landing-bento-item-wide flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="w-14 h-14 bg-primary/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-1">Laporan & Visualisasi RT</h3>
                    <p class="text-white/50 text-sm">Bandingkan kontribusi sampah antar RT, filter tanggal, dan ekspor data ke CSV.</p>
                </div>
            </div>

            <div class="landing-card landing-bento-item-narrow !bg-gradient-to-br from-primary/20 to-forest-emerald/10 !border-primary/30 flex flex-col justify-center items-center text-center">
                <p class="landing-stat-value font-black text-forest-emerald">{{ number_format($stats['sampah_kg'], 0) }}+</p>
                <p class="text-sm text-white/50 mt-2">Kg Sampah Terkelola</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ CARA KERJA ═══════════════ --}}
<section id="cara-kerja" class="py-16 sm:py-20 lg:py-28 bg-[#03110d] border-y border-white/5 relative overflow-hidden" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
         class="transition-all duration-1000 ease-out opacity-0 translate-y-8">
        <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
            <p class="text-forest-emerald text-xs sm:text-sm font-semibold uppercase tracking-widest mb-3">Mudah & Cepat</p>
            <h2 class="landing-section-title font-bold mb-4">Cara Kerja SiSampah</h2>
            <p class="text-white/60 text-sm sm:text-base">Empat langkah sederhana menuju desa bersih dan warga sejahtera.</p>
        </div>

        <!-- 4 Step Cards with High-End Vector SVG Icons -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
            <!-- Step 1: Kumpulkan -->
            <div class="landing-card flex flex-col justify-between group relative border border-white/10 hover:border-forest-emerald/60 hover:bg-white/[0.08] transition-all duration-300">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-forest-emerald/20 border border-forest-emerald/30 text-forest-emerald text-xs font-bold tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-forest-emerald animate-pulse"></span>
                            01
                        </span>
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-forest-emerald/30 to-primary/10 border border-forest-emerald/40 flex items-center justify-center text-forest-emerald shadow-lg shadow-forest-emerald/10 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg lg:text-xl font-bold mb-2.5 group-hover:text-forest-emerald transition-colors">Kumpulkan Sampah</h3>
                    <p class="text-xs sm:text-sm text-white/60 leading-relaxed">Pisahkan sampah sesuai kategori (plastik, kertas, logam, organik) langsung dari rumah Anda.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-white/40">
                    <span>Tahap 1 dari 4</span>
                    <span class="hidden lg:inline-flex items-center gap-1 text-forest-emerald font-bold">Lanjut <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></span>
                </div>
            </div>

            <!-- Step 2: Jadwalkan Penjemputan -->
            <div class="landing-card flex flex-col justify-between group relative border border-white/10 hover:border-blue-400/60 hover:bg-white/[0.08] transition-all duration-300">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-blue-500/20 border border-blue-500/30 text-blue-400 text-xs font-bold tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                            02
                        </span>
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500/30 to-primary/10 border border-blue-500/40 flex items-center justify-center text-blue-400 shadow-lg shadow-blue-500/10 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg lg:text-xl font-bold mb-2.5 group-hover:text-blue-400 transition-colors">Jadwalkan Jemput</h3>
                    <p class="text-xs sm:text-sm text-white/60 leading-relaxed">Pesan layanan penjemputan via aplikasi dengan penentuan titik lokasi GPS otomatis.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-white/40">
                    <span>Tahap 2 dari 4</span>
                    <span class="hidden lg:inline-flex items-center gap-1 text-blue-400 font-bold">Lanjut <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></span>
                </div>
            </div>

            <!-- Step 3: Penimbangan -->
            <div class="landing-card flex flex-col justify-between group relative border border-white/10 hover:border-amber-400/60 hover:bg-white/[0.08] transition-all duration-300">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-amber-500/20 border border-amber-500/30 text-amber-400 text-xs font-bold tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                            03
                        </span>
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500/30 to-primary/10 border border-amber-500/40 flex items-center justify-center text-amber-400 shadow-lg shadow-amber-500/10 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l9-4 9 4M3 6v14a1 1 0 001 1h16a1 1 0 001-1V6M3 6l9 6 9-6M12 12v9"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg lg:text-xl font-bold mb-2.5 group-hover:text-amber-400 transition-colors">Timbang & Verifikasi</h3>
                    <p class="text-xs sm:text-sm text-white/60 leading-relaxed">Petugas menimbang sampah di lokasi, upload foto bukti, dan saldo/poin langsung masuk.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-white/40">
                    <span>Tahap 3 dari 4</span>
                    <span class="hidden lg:inline-flex items-center gap-1 text-amber-400 font-bold">Lanjut <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></span>
                </div>
            </div>

            <!-- Step 4: Tarik Saldo -->
            <div class="landing-card flex flex-col justify-between group relative border border-white/10 hover:border-emerald-400/60 hover:bg-white/[0.08] transition-all duration-300">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-emerald-400/20 border border-emerald-400/30 text-emerald-300 text-xs font-bold tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                            04
                        </span>
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-400/30 to-primary/10 border border-emerald-400/40 flex items-center justify-center text-emerald-300 shadow-lg shadow-emerald-400/10 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg lg:text-xl font-bold mb-2.5 group-hover:text-emerald-300 transition-colors">Tarik Saldo Tunai</h3>
                    <p class="text-xs sm:text-sm text-white/60 leading-relaxed">Ajukan penarikan saldo Anda kapan saja secara tunai di bank sampah atau transfer rekening.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-white/40">
                    <span>Tahap 4 dari 4</span>
                    <span class="inline-flex items-center gap-1 text-emerald-300 font-bold">Selesai <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ DAMPAK / STATS ═══════════════ --}}
<section id="dampak" class="py-16 sm:py-20 lg:py-28 relative overflow-hidden" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
         class="transition-all duration-1000 ease-out opacity-0 translate-y-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach([
                [$stats['nasabah'], 'Nasabah Aktif', 'Masyarakat peduli lingkungan'],
                [$stats['petugas'], 'Petugas Lapangan', 'Kader pengelola sampah'],
                [number_format($stats['sampah_kg'], 0), 'Kg Terkelola', 'Sampah berhasil didaur ulang'],
                [$stats['transaksi'], 'Transaksi', 'Setoran tercatat digital'],
            ] as [$value, $label, $sub])
                <div class="landing-card text-center !p-5 sm:!p-8 border border-white/10 hover:border-forest-emerald/50">
                    <p class="landing-stat-value font-black text-white mb-2">{{ $value }}</p>
                    <p class="font-semibold text-sm sm:text-base text-forest-emerald mb-1">{{ $label }}</p>
                    <p class="text-xs text-white/40 hidden sm:block">{{ $sub }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ═══════════════ EDUKASI ═══════════════ --}}
@if($articles->count())
<section class="py-16 sm:py-20 lg:py-28 bg-[#03110d] border-y border-white/5 relative overflow-hidden" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
         class="transition-all duration-1000 ease-out opacity-0 translate-y-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10 lg:mb-12">
            <div>
                <p class="text-forest-emerald text-xs sm:text-sm font-semibold uppercase tracking-widest mb-3">Edukasi & Literasi</p>
                <h2 class="landing-section-title font-bold">Tips Daur Ulang Sampah</h2>
            </div>
            <a href="{{ route('edukasi.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-forest-emerald hover:text-white transition-colors">
                Lihat Semua Artikel
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articles as $article)
                <article class="landing-card group flex flex-col h-full !p-0 overflow-hidden border border-white/10 hover:border-emerald-400/50 transition-all">
                    <!-- Image Banner -->
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $article->image_url }}" alt="{{ $article->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                        <div class="absolute top-3 left-3">
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-emerald-500 text-white rounded-full shadow-md">{{ $article->kategori }}</span>
                        </div>
                    </div>
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-white mb-3 group-hover:text-emerald-400 transition-colors line-clamp-2 min-h-[56px]">{{ $article->judul }}</h3>
                        <p class="text-sm text-white/60 leading-relaxed flex-1 line-clamp-3 min-h-[60px]">{{ Str::limit(strip_tags($article->konten), 120) }}</p>
                        <div class="flex items-center justify-between mt-5 pt-4 border-t border-white/10">
                            <span class="text-xs text-white/40">{{ $article->created_at->translatedFormat('d M Y') }}</span>
                            <a href="{{ route('edukasi.show', $article->slug) }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-400 hover:text-emerald-300 group-hover:gap-3 transition-all">
                                Baca artikel
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ═══════════════ FAQ ═══════════════ --}}
<section class="py-16 sm:py-20 lg:py-28 relative overflow-hidden" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
         class="transition-all duration-1000 ease-out opacity-0 translate-y-8">
        <div class="text-center mb-12 lg:mb-16">
            <p class="text-forest-emerald text-xs sm:text-sm font-semibold uppercase tracking-widest mb-3">FAQ</p>
            <h2 class="landing-section-title font-bold">Pertanyaan Umum</h2>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            @foreach([
                ['Apakah daftar SiSampah gratis?', 'Ya, pendaftaran untuk nasabah sepenuhnya gratis tanpa dipungut biaya apapun.'],
                ['Bagaimana cara kerja penjemputan sampah?', 'Anda cukup masuk ke aplikasi, pilih jadwal penjemputan, dan petugas kami akan datang ke lokasi Anda sesuai koordinat GPS yang dikirimkan.'],
                ['Kapan saya bisa menarik saldo?', 'Saldo dapat ditarik kapan saja (tunai atau transfer bank) selama mencapai batas minimum penarikan yang ditetapkan oleh Admin.'],
                ['Apa saja jenis sampah yang diterima?', 'Kami menerima sampah Plastik, Kertas, Kardus, Logam, Kaca, Organik, E-Waste (Elektronik), dan Minyak Jelantah.'],
            ] as $index => [$question, $answer])
                <div class="landing-card !p-0 overflow-hidden border border-white/10 hover:border-forest-emerald/40 transition-colors">
                    <button @click="active = active === {{ $index }} ? null : {{ $index }}" class="w-full flex items-center justify-between p-5 sm:p-6 text-left focus:outline-none">
                        <span class="font-bold text-base sm:text-lg pr-4">{{ $question }}</span>
                        <svg class="w-5 h-5 text-forest-emerald transition-transform flex-shrink-0" :class="active === {{ $index }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="active === {{ $index }}" x-collapse class="px-5 sm:px-6 pb-6 text-sm sm:text-base text-white/60 leading-relaxed border-t border-white/5 pt-4">
                        {{ $answer }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════ CTA ═══════════════ --}}
<section class="py-16 sm:py-20 lg:py-28" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
         class="transition-all duration-1000 ease-out opacity-0 translate-y-8">
        <div class="relative overflow-hidden rounded-3xl lg:rounded-[2rem]">
            <div class="absolute inset-0 bg-gradient-to-br from-primary via-[#0d4a35] to-[#051410]"></div>
            <div class="absolute inset-0 opacity-20" style="background-image: url('/images/auth-bg-pattern.svg'); background-size: cover;"></div>
            <div class="relative z-10 px-6 py-12 sm:px-12 sm:py-16 lg:px-20 lg:py-20 text-center">
                <h2 class="landing-section-title font-bold mb-4 max-w-2xl mx-auto">
                    Siap Mengubah Sampah Menjadi Berkah?
                </h2>
                <p class="text-white/60 text-base sm:text-lg max-w-xl mx-auto mb-8 lg:mb-10">
                    Bergabung dengan {{ $stats['nasabah'] }}+ nasabah yang sudah merasakan manfaatnya. Gratis, mudah, dan ramah untuk semua perangkat.
                </p>
                @guest
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-[#051410] font-bold rounded-2xl hover:bg-white/90 transition-all min-h-[52px]">
                            Daftar Sebagai Nasabah
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 border border-white/30 text-white font-semibold rounded-2xl hover:bg-white/10 transition-all min-h-[52px]">
                            Sudah Punya Akun
                        </a>
                    </div>
                @else
                    <a href="{{ route($dash) }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-[#051410] font-bold rounded-2xl hover:bg-white/90 transition-all min-h-[52px]">
                        Ke Dashboard Saya
                    </a>
                @endguest
            </div>
        </div>
    </div>
</section>

@endsection
