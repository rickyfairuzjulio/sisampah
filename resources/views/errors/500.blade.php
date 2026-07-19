<x-app-layout title="500 - Kesalahan Server">
    <div class="min-h-[85vh] flex items-center justify-center relative overflow-hidden py-16 px-4 sm:px-6 lg:px-8">
        
        <!-- Background Decorative Glow Effects -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-red-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-red-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Floating SVG Waste & Eco Elements Background (Spreading Across the Screen) -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden select-none">
            <!-- Left Side Waste Icons -->
            <div class="animate-float text-red-500/35" style="position: absolute; top: 15%; left: 6%;">
                <svg class="w-12 h-12 sm:w-16 sm:h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            
            <div class="animate-float-delayed text-amber-500/35" style="position: absolute; top: 48%; left: 4%;">
                <svg class="w-14 h-14 sm:w-18 sm:h-18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>

            <div class="animate-float-reverse text-emerald-500/35" style="position: absolute; top: 78%; left: 8%;">
                <svg class="w-10 h-10 sm:w-14 sm:h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>

            <!-- Right Side Waste Icons -->
            <div class="animate-float-reverse text-rose-500/35" style="position: absolute; top: 18%; right: 7%;">
                <svg class="w-12 h-12 sm:w-16 sm:h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            <div class="animate-float text-red-500/35" style="position: absolute; top: 52%; right: 5%;">
                <svg class="w-14 h-14 sm:w-18 sm:h-18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                </svg>
            </div>

            <div class="animate-float-delayed text-amber-500/35" style="position: absolute; top: 78%; right: 9%;">
                <svg class="w-10 h-10 sm:w-14 sm:h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4m6 17v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4M5 11l7-7 7 7M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>

        <div class="max-w-xl w-full text-center relative z-10 flex flex-col items-center justify-center space-y-6 sm:space-y-8">
            
            <!-- 500 Header Badge & Big Number -->
            <div class="flex flex-col items-center justify-center space-y-4">
                <h1 class="font-extrabold tracking-widest text-red-500 dark:text-rose-400 drop-shadow-lg leading-none select-none" style="font-size: clamp(4.5rem, 10vw, 8rem); line-height: 1;">
                    500
                </h1>
                <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-red-500/10 dark:bg-red-950/80 border border-red-500/30 text-red-600 dark:text-red-400 text-xs sm:text-sm font-bold shadow-sm backdrop-blur-md">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>Kesalahan Server</span>
                </div>
            </div>

            <!-- Error Description -->
            <div class="space-y-3 max-w-lg">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-on-surface">
                    Terjadi Kendala Teknis Sementara
                </h2>
                <p class="text-on-surface-variant text-sm sm:text-base leading-relaxed">
                    Sistem kami sedang mengalami kendala. Tim teknis sedang bekerja untuk menyelesaikannya. Silakan coba beberapa saat lagi.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 w-full sm:w-auto pt-2">
                <button onclick="window.location.reload()" 
                        class="w-full sm:w-auto min-w-[170px] px-6 py-3.5 rounded-xl bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-semibold text-sm transition-all duration-300 flex items-center justify-center gap-2 border border-outline-variant hover:scale-105 active:scale-95 shadow-sm whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Muat Ulang Halaman
                </button>

                <a href="{{ route('home') }}" 
                   class="w-full sm:w-auto min-w-[180px] px-8 py-3.5 rounded-xl bg-gradient-to-r from-primary to-forest-emerald hover:shadow-lg hover:shadow-primary/25 text-white font-bold text-sm transition-all duration-300 flex items-center justify-center gap-2 hover:scale-105 active:scale-95 shadow-md whitespace-nowrap">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <!-- Custom Style for Floating Animations -->
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-16px) rotate(8deg); }
        }
        @keyframes floatReverse {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(16px) rotate(-8deg); }
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
