<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <!-- Primary Meta Tags -->
    <title>{{ config('app.name', 'SiSampah') }} - Bersih Desa, Sejahtera Bersama</title>
    <meta name="title" content="{{ config('app.name', 'SiSampah') }} - Bersih Desa, Sejahtera Bersama">
    <meta name="description" content="Sistem Informasi Manajemen Bank Sampah (SiSampah) untuk mewujudkan lingkungan desa yang bersih, hijau, dan memberikan nilai ekonomis bagi masyarakat.">
    <meta name="keywords" content="bank sampah, sisampah, daur ulang, peduli lingkungan, sampah desa, ekonomi sirkular">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="{{ config('app.name', 'SiSampah') }} - Bersih Desa, Sejahtera Bersama">
    <meta property="og:description" content="Sistem Informasi Manajemen Bank Sampah (SiSampah) untuk mewujudkan lingkungan desa yang bersih, hijau, dan memberikan nilai ekonomis bagi masyarakat.">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/introjs.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-background text-on-surface overflow-x-hidden transition-colors duration-300">
    <div class="min-h-screen flex flex-col bg-background">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-gradient-to-r from-surface-container-lowest to-surface-container border-b border-outline-variant shadow-sm">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    <div class="animate-fade-in">
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endisset

        <main class="flex-1 w-full bg-background">
            @yield('content')
            {{ $slot ?? '' }}
        </main>

        @if (request()->routeIs('home', 'edukasi.*'))
            <!-- Fat Footer untuk Halaman Publik (Kompetisi Version) -->
            <footer class="bg-[#1a1c1b] dark:bg-[#0d0f0e] text-white border-t border-outline-variant dark:border-white/10 py-12 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
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
                            <h4 class="font-bold text-lg mb-4 text-emerald">Fitur Unggulan</h4>
                            <ul class="space-y-2 text-sm text-white/70">
                                <li>Klasifikasi Sampah AI</li>
                                <li>Manifes Penjemputan Otomatis</li>
                                <li>Dompet Digital (Poin)</li>
                                <li>Edukasi Ramah Lingkungan</li>
                                <li>Chatbot Pintar SiSampah</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-4 text-emerald">Teknologi Terapan</h4>
                            <ul class="space-y-2 text-sm text-white/70">
                                <li>Laravel 11 & PHP 8.2</li>
                                <li>Tailwind CSS & Alpine.js</li>
                                <li>Gemini Vision AI</li>
                                <li>MySQL Relational DB</li>
                                <li>Chart.js Analytics</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-4 text-emerald">Dikembangkan Oleh</h4>
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
                                    <span>Universitas Islam Negeri Walisongo (UIN)</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-t border-white/20 pt-8 mt-4 flex flex-col md:flex-row items-center justify-between text-white/50 text-xs">
                        <p>&copy; {{ date('Y') }} Bodrex Developer. Semua hak cipta dilindungi.</p>
                        <div class="mt-4 md:mt-0 flex gap-4">
                            <span class="px-2 py-1 bg-white/10 rounded">V 1.0.0</span>
                            <span class="px-2 py-1 bg-primary/20 text-primary font-bold rounded">Kompetisi Edition</span>
                        </div>
                    </div>
                </div>
            </footer>
        @else
            <!-- Micro Footer untuk Halaman Internal/Dashboard -->
            <footer class="mt-auto py-6 px-4 border-t border-outline-variant bg-background">
                <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-xs text-on-surface-variant text-center md:text-left">
                        &copy; {{ date('Y') }} SiSampah. Dikembangkan oleh <span class="font-bold text-primary">Bodrex Developer</span> untuk <span class="font-semibold">Walisongo Science Competition</span>.
                    </p>
                    <div class="flex items-center gap-4 text-xs text-on-surface-variant font-medium">
                        <span class="flex items-center gap-1"><svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg> UIN Walisongo</span>
                        <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Ke Beranda</a>
                    </div>
                </div>
            </footer>
        @endif
    </div>
    <x-chatbot-widget />
    <x-toast />
    @stack('scripts')
    
    @if(session('welcome'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Halo!',
                text: "{{ session('welcome') }}",
                icon: 'success',
                confirmButtonText: 'Lanjut',
                confirmButtonColor: '#059669', // emerald
                background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#f8fafc' : '#0f172a',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl shadow-md font-bold'
                }
            });
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#ef4444',
                background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#f8fafc' : '#0f172a',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl shadow-md font-bold'
                }
            });
        });
    </script>
    @endif
</body>
</html>
