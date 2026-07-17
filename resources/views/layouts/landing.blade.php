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
            x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 40)"
            :class="scrolled ? 'bg-[#051410]/90 backdrop-blur-lg border-b border-white/10 shadow-lg' : 'bg-transparent'"
            class="fixed top-0 inset-x-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <img src="{{ asset('images/logo.png') }}" alt="SiSampah Logo" class="w-14 h-14 lg:w-16 lg:h-16 object-contain group-hover:scale-110 transition-transform">
                    <span class="text-xl lg:text-2xl font-bold ml-1">SiSampah<span class="text-forest-emerald">.</span></span>
                </a>

                <nav class="hidden lg:flex items-center gap-8 text-sm font-medium text-white/70">
                    <a href="#fitur" class="hover:text-white transition-colors">Fitur</a>
                    <a href="#cara-kerja" class="hover:text-white transition-colors">Cara Kerja</a>
                    <a href="#dampak" class="hover:text-white transition-colors">Dampak</a>
                    <a href="{{ route('edukasi.index') }}" class="hover:text-white transition-colors">Edukasi</a>
                </nav>

                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        <a href="{{ route($dashRoute) }}" class="px-5 py-2.5 bg-primary hover:bg-primary-container text-white text-sm font-bold rounded-full transition-all">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-white/80 hover:text-white transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-white text-[#051410] text-sm font-bold rounded-full hover:bg-white/90 transition-all">
                            Daftar Gratis
                        </a>
                    @endauth
                </div>

                <button @click="open = !open" class="lg:hidden p-2 rounded-lg text-white/80 hover:bg-white/10" aria-label="Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="open" x-transition class="lg:hidden bg-[#0a1f17]/95 backdrop-blur-lg border-t border-white/10">
            <div class="px-4 py-4 space-y-1">
                <a href="#fitur" @click="open=false" class="block px-4 py-3 rounded-xl text-white/80 hover:bg-white/5">Fitur</a>
                <a href="#cara-kerja" @click="open=false" class="block px-4 py-3 rounded-xl text-white/80 hover:bg-white/5">Cara Kerja</a>
                <a href="#dampak" @click="open=false" class="block px-4 py-3 rounded-xl text-white/80 hover:bg-white/5">Dampak</a>
                <a href="{{ route('edukasi.index') }}" class="block px-4 py-3 rounded-xl text-white/80 hover:bg-white/5">Edukasi</a>
                <div class="pt-3 flex flex-col gap-2">
                    @auth
                        <a href="{{ route($dashRoute) }}" class="block text-center py-3 bg-primary rounded-xl font-bold">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block text-center py-3 border border-white/20 rounded-xl font-semibold">Masuk</a>
                        <a href="{{ route('register') }}" class="block text-center py-3 bg-white text-[#051410] rounded-xl font-bold">Daftar Gratis</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-[#1a1c1b] dark:bg-[#0d0f0e] border-t border-white/10 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="SiSampah Logo" class="w-12 h-12 object-contain drop-shadow-sm">
                        <span class="text-2xl font-bold ml-1 text-primary">SiSampah</span>
                    </div>
                    <p class="text-white/70 text-sm leading-relaxed mb-4">
                        Platform pintar pengelolaan bank sampah untuk menciptakan lingkungan yang lebih bersih, desa yang mandiri, dan menyejahterakan masyarakat.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4 text-forest-emerald">Fitur Unggulan</h4>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li>Klasifikasi Sampah AI</li>
                        <li>Manifes Penjemputan Otomatis</li>
                        <li>Dompet Digital (Poin)</li>
                        <li>Edukasi Ramah Lingkungan</li>
                        <li>Chatbot Pintar SiSampah</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4 text-forest-emerald">Teknologi Terapan</h4>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li>Laravel 11 & PHP 8.2</li>
                        <li>Tailwind CSS & Alpine.js</li>
                        <li>Gemini Vision AI</li>
                        <li>MySQL Relational DB</li>
                        <li>Chart.js Analytics</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4 text-forest-emerald">Dikembangkan Oleh</h4>
                    <ul class="space-y-3 text-sm text-white/70">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 flex-shrink-0 text-primary mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <div>
                                <span class="block font-semibold text-white">Bodrex Developer</span>
                                <span class="text-xs">Walisongo Science Competition</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 flex-shrink-0 text-primary mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>Universitas Islam Negeri Walisongo (UIN Walisongo)</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-4 pt-8 border-t border-white/20 flex flex-col md:flex-row items-center justify-between text-white/50 text-xs">
                <p>&copy; {{ date('Y') }} Bodrex Developer. Semua hak cipta dilindungi.</p>
                <div class="mt-4 md:mt-0 flex gap-4">
                    <span class="px-2 py-1 bg-white/10 rounded">V 1.0.0</span>
                    <span class="px-2 py-1 bg-primary/20 text-primary font-bold rounded">Kompetisi Edition</span>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
