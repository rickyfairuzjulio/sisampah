<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="SiSampah — Bank Sampah Digital. Ubah sampah menjadi berkah, kelola setoran, dan sejahterakan komunitas desa.">
    <meta name="keywords" content="bank sampah, sisampah, daur ulang, peduli lingkungan, sampah desa, ekonomi sirkular">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="{{ config('app.name', 'SiSampah') }} — Bank Sampah Digital">
    <meta property="og:description" content="SiSampah — Bank Sampah Digital. Ubah sampah menjadi berkah, kelola setoran, dan sejahterakan komunitas desa.">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

    <title>{{ config('app.name', 'SiSampah') }} — Bank Sampah Digital</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#051410] text-white overflow-x-hidden">
    @php
        $dashRoute = 'nasabah.dashboard';
        if (auth()->check()) {
            $dashRoute = auth()->user()->hasRole('admin') ? 'admin.dashboard'
                : (auth()->user()->hasRole('petugas') ? 'petugas.dashboard' : 'nasabah.dashboard');
        }
    @endphp
    {{-- Landing Nav --}}
    <header x-data="{ open: false, scrolled: false }"
            x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 30)"
            :class="scrolled ? 'bg-[#051410]/95 backdrop-blur-xl border-b border-white/10 shadow-xl py-1' : 'bg-transparent py-2'"
            class="fixed top-0 inset-x-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="SiSampah Logo" class="w-10 h-10 sm:w-11 sm:h-11 lg:w-12 lg:h-12 object-contain group-hover:scale-105 transition-transform drop-shadow">
                    <span class="text-lg sm:text-xl lg:text-2xl font-bold tracking-tight">SiSampah<span class="text-emerald">.</span></span>
                </a>

                <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold text-white/70">
                    <a href="#fitur" class="hover:text-emerald transition-colors">Fitur</a>
                    <a href="#cara-kerja" class="hover:text-emerald transition-colors">Cara Kerja</a>
                    <a href="#dampak" class="hover:text-emerald transition-colors">Dampak</a>
                    <a href="{{ route('edukasi.index') }}" class="hover:text-emerald transition-colors">Edukasi</a>
                </nav>

                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        <a href="{{ route($dashRoute) }}" class="px-6 py-2.5 bg-gradient-to-r from-primary to-emerald hover:shadow-lg hover:shadow-primary/20 text-white text-sm font-bold rounded-full transition-all">
                            Dashboard Saya
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-white/80 hover:text-white transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-white text-[#051410] text-sm font-bold rounded-full hover:bg-white/90 transition-all shadow-md">
                            Daftar Gratis
                        </a>
                    @endauth
                </div>

                <button @click="open = !open" class="lg:hidden p-2 rounded-xl text-white/80 hover:bg-white/10 transition-colors" aria-label="Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="lg:hidden bg-[#051410]/98 backdrop-blur-2xl border-b border-white/10 shadow-2xl">
            <div class="px-4 py-4 space-y-2">
                <a href="#fitur" @click="open=false" class="flex items-center justify-between px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 font-medium text-sm transition-colors">
                    <span>Fitur Unggulan</span>
                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="#cara-kerja" @click="open=false" class="flex items-center justify-between px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 font-medium text-sm transition-colors">
                    <span>Cara Kerja</span>
                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="#dampak" @click="open=false" class="flex items-center justify-between px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 font-medium text-sm transition-colors">
                    <span>Dampak Lingkungan</span>
                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('edukasi.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 font-medium text-sm transition-colors">
                    <span>Artikel Edukasi</span>
                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>

                <div class="pt-3 border-t border-white/10 flex flex-col gap-2.5">
                    @auth
                        <a href="{{ route($dashRoute) }}" class="block text-center py-3 bg-gradient-to-r from-primary to-emerald text-white rounded-xl font-bold text-sm shadow-md">
                            Buka Dashboard Saya
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block text-center py-3 border border-white/20 text-white rounded-xl font-semibold text-sm hover:bg-white/5 transition-colors">
                            Masuk Akun
                        </a>
                        <a href="{{ route('register') }}" class="block text-center py-3 bg-white text-[#051410] rounded-xl font-bold text-sm shadow-md">
                            Daftar Akun Gratis
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer Menyatu dengan Tema Utama (#051410) -->
    <footer class="bg-[#030e0b] border-t border-white/10 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12 mb-10">
                <div>
                    <div class="flex items-center gap-2.5 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="SiSampah Logo" class="w-10 h-10 object-contain drop-shadow">
                        <span class="text-xl font-bold text-white tracking-tight">SiSampah<span class="text-emerald">.</span></span>
                    </div>
                    <p class="text-white/60 text-xs sm:text-sm leading-relaxed mb-4">
                        Platform pintar pengelolaan bank sampah untuk menciptakan lingkungan yang lebih bersih, desa yang mandiri, dan menyejahterakan masyarakat.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-sm sm:text-base mb-4 text-emerald uppercase tracking-wider">Fitur Unggulan</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-white/70">
                        <li class="flex items-center gap-2"><span class="text-emerald">✓</span> Klasifikasi Sampah AI</li>
                        <li class="flex items-center gap-2"><span class="text-emerald">✓</span> Manifes Penjemputan Otomatis</li>
                        <li class="flex items-center gap-2"><span class="text-emerald">✓</span> Dompet Digital (Poin)</li>
                        <li class="flex items-center gap-2"><span class="text-emerald">✓</span> Edukasi Ramah Lingkungan</li>
                        <li class="flex items-center gap-2"><span class="text-emerald">✓</span> Chatbot Pintar SiSampah</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-sm sm:text-base mb-4 text-emerald uppercase tracking-wider">Teknologi Terapan</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-white/70">
                        <li>Laravel 11 & PHP 8.3</li>
                        <li>Tailwind CSS & Alpine.js</li>
                        <li>Gemini Vision AI</li>
                        <li>MySQL Relational DB</li>
                        <li>Chart.js Analytics</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-sm sm:text-base mb-4 text-emerald uppercase tracking-wider">Dikembangkan Oleh</h4>
                    <ul class="space-y-3 text-xs sm:text-sm text-white/70">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 flex-shrink-0 text-emerald mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <div>
                                <span class="block font-semibold text-white">Bodrex Developer</span>
                                <span class="text-[11px] text-white/50">Walisongo Science Competition</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 flex-shrink-0 text-emerald mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>Universitas Islam Negeri Walisongo (UIN Walisongo)</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-4 pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between text-white/50 text-xs gap-4">
                <p>&copy; {{ date('Y') }} Bodrex Developer. Semua hak cipta dilindungi.</p>
                <div class="flex items-center gap-3">
                    <span class="px-2.5 py-1 bg-white/5 border border-white/10 rounded-lg text-white/70">V 1.0.0</span>
                    <span class="px-2.5 py-1 bg-emerald/20 text-emerald font-bold rounded-lg border border-emerald/30">Kompetisi Edition</span>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
