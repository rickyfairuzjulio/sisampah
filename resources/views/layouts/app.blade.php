<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SiSampah') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/introjs.min.css">
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

        <footer class="bg-[#1a1c1b] dark:bg-[#0d0f0e] text-white border-t border-outline-variant dark:border-white/10 py-12 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <img src="{{ asset('images/logo.png') }}" alt="SiSampah Logo" class="w-12 h-12 object-contain drop-shadow-sm">
                            <span class="text-2xl font-bold ml-1">SiSampah</span>
                        </div>
                        <p class="text-white/70 text-sm">Mengubah sampah menjadi berkah bagi semua orang</p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Produk</h4>
                        <ul class="space-y-2 text-sm text-white/70">
                            <li><a href="#" class="hover:text-white transition-colors">Untuk Nasabah</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Untuk Petugas</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Untuk Admin</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Perusahaan</h4>
                        <ul class="space-y-2 text-sm text-white/70">
                            <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                            <li><a href="{{ route('edukasi.index') }}" class="hover:text-white transition-colors">Edukasi</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Kontak</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Hubungi</h4>
                        <ul class="space-y-2 text-sm text-white/70">
                            <li>hello@sisampah.id</li>
                            <li>+62 822 1234 5678</li>
                            <li>Jakarta, Indonesia</li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-white/20 pt-8 text-center text-white/70 text-sm">
                    <p>&copy; {{ date('Y') }} SiSampah. Semua hak cipta dilindungi. | Bersih Desa, Sejahtera Bersama.</p>
                </div>
            </div>
        </footer>
    </div>
    <x-chatbot-widget />
    <x-toast />
    <x-intro-onboarding />
    @stack('scripts')
</body>
</html>
