<x-app-layout title="404 - Halaman Tidak Ditemukan">
    <div class="min-h-[85vh] flex items-center justify-center relative overflow-hidden py-16 px-4 sm:px-6 lg:px-8">
        
        <!-- Background Decorative Glow Effects -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-primary/20 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-forest-emerald/20 rounded-full blur-3xl pointer-events-none animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Floating SVG Waste & Eco Elements Background (Spreading Across the Screen) -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden select-none">
            <!-- Left Side Waste Icons -->
            <div class="animate-float text-primary/40" style="position: absolute; top: 15%; left: 6%;">
                <svg class="w-12 h-12 sm:w-16 sm:h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>
            
            <div class="animate-float-delayed text-amber-500/35" style="position: absolute; top: 48%; left: 4%;">
                <svg class="w-14 h-14 sm:w-18 sm:h-18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>

            <div class="animate-float-reverse text-emerald-500/40" style="position: absolute; top: 78%; left: 8%;">
                <svg class="w-10 h-10 sm:w-14 sm:h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4m6 17v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4M5 11l7-7 7 7M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>

            <div class="animate-float-delayed text-emerald-400/30 hidden md:block" style="position: absolute; top: 12%; left: 28%;">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            <!-- Right Side Waste Icons -->
            <div class="animate-float-reverse text-forest-emerald/40" style="position: absolute; top: 18%; right: 7%;">
                <svg class="w-12 h-12 sm:w-16 sm:h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            <div class="animate-float text-primary/40" style="position: absolute; top: 52%; right: 5%;">
                <svg class="w-14 h-14 sm:w-18 sm:h-18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>

            <div class="animate-float-delayed text-amber-500/35" style="position: absolute; top: 78%; right: 9%;">
                <svg class="w-10 h-10 sm:w-14 sm:h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>

            <div class="animate-float text-primary/30 hidden md:block" style="position: absolute; top: 12%; right: 28%;">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4m6 17v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4M5 11l7-7 7 7M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>

        <div class="max-w-2xl w-full text-center relative z-10 flex flex-col items-center justify-center space-y-6 sm:space-y-8">
            
            <!-- 404 Hero Visual Container -->
            <div class="flex flex-col items-center justify-center space-y-4">
                <!-- Large Animated 404 Text -->
                <h1 class="font-extrabold tracking-widest text-primary dark:text-emerald-400 drop-shadow-lg leading-none select-none flex items-center justify-center gap-1" style="font-size: clamp(4.5rem, 10vw, 8rem); line-height: 1;">
                    4<span class="inline-block animate-spin-slow text-forest-emerald">0</span>4
                </h1>
                
                <!-- Floating Badge -->
                <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-surface-container-high dark:bg-emerald-950/80 border border-primary/30 text-primary text-xs sm:text-sm font-bold shadow-sm backdrop-blur-md">
                    <svg class="w-4 h-4 text-forest-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Halaman Terdaur Ulang!</span>
                </div>
            </div>

            <!-- Error Message -->
            <div class="space-y-2.5 max-w-lg">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-on-surface">
                    Waduh! Halaman yang Anda Cari Tidak Ada
                </h2>
                <p class="text-on-surface-variant text-sm sm:text-base leading-relaxed">
                    Sama seperti sampah organik yang terurai, halaman ini mungkin telah berpindah tempat, dihapus, atau sedang dipilah oleh tim SiSampah.
                </p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 w-full sm:w-auto pt-2">
                <button onclick="window.history.back()" 
                        class="w-full sm:w-auto px-6 py-3.5 rounded-xl bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-semibold text-sm transition-all duration-300 flex items-center justify-center gap-2 border border-outline-variant hover:scale-105 active:scale-95 shadow-sm whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali Halaman Sebelumnya
                </button>

                <a href="{{ route('home') }}" 
                   class="w-full sm:w-auto min-w-[180px] px-8 py-3.5 rounded-xl bg-gradient-to-r from-primary to-forest-emerald hover:shadow-lg hover:shadow-primary/25 text-white font-bold text-sm transition-all duration-300 flex items-center justify-center gap-2 hover:scale-105 active:scale-95 shadow-md whitespace-nowrap">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Navigasi Pintas / Quick Links Cards -->
            <div class="pt-6 border-t border-outline-variant/60 w-full">
                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-4">
                    Atau Coba Akses Fitur Utama Berikut:
                </p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-left">
                    <!-- Link 1: Edukasi -->
                    <a href="{{ route('edukasi.index') }}" 
                       class="p-3.5 rounded-xl bg-surface-container/60 hover:bg-surface-container border border-outline-variant/80 hover:border-primary/50 transition-all duration-300 group flex flex-col gap-1.5 shadow-sm">
                        <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-on-surface group-hover:text-primary transition-colors">Artikel Edukasi</span>
                        <span class="text-[10px] text-on-surface-variant line-clamp-1">Tips pilah & daur ulang</span>
                    </a>

                    <!-- Link 2: Harga Sampah -->
                    <a href="{{ route('home') }}#harga" 
                       class="p-3.5 rounded-xl bg-surface-container/60 hover:bg-surface-container border border-outline-variant/80 hover:border-primary/50 transition-all duration-300 group flex flex-col gap-1.5 shadow-sm">
                        <div class="w-8 h-8 rounded-lg bg-forest-emerald/10 text-forest-emerald flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-on-surface group-hover:text-primary transition-colors">Daftar Harga</span>
                        <span class="text-[10px] text-on-surface-variant line-clamp-1">Kategori & harga per kg</span>
                    </a>

                    <!-- Link 3: Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       class="p-3.5 rounded-xl bg-surface-container/60 hover:bg-surface-container border border-outline-variant/80 hover:border-primary/50 transition-all duration-300 group flex flex-col gap-1.5 shadow-sm">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-on-surface group-hover:text-primary transition-colors">Dashboard Saya</span>
                        <span class="text-[10px] text-on-surface-variant line-clamp-1">Cek saldo & transaksi</span>
                    </a>

                    <!-- Link 4: Cara Kerja -->
                    <a href="{{ route('home') }}#cara-kerja" 
                       class="p-3.5 rounded-xl bg-surface-container/60 hover:bg-surface-container border border-outline-variant/80 hover:border-primary/50 transition-all duration-300 group flex flex-col gap-1.5 shadow-sm">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-on-surface group-hover:text-primary transition-colors">Cara Kerja</span>
                        <span class="text-[10px] text-on-surface-variant line-clamp-1">Panduan bank sampah</span>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- Custom Style for Floating & Spin Animations -->
    <style>
        @keyframes spinSlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-16px) rotate(8deg); }
        }
        @keyframes floatReverse {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(16px) rotate(-8deg); }
        }
        .animate-spin-slow {
            animation: spinSlow 12s linear infinite;
        }
        .animate-float {
            animation: float 5s ease-in-out infinite;
        }
        .animate-float-delayed {
            animation: float 7s ease-in-out infinite 2s;
        }
        .animate-float-reverse {
            animation: floatReverse 6s ease-in-out infinite 1s;
        }
    </style>
</x-app-layout>
