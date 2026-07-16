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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex">
        {{-- Left: Form Panel --}}
        <div class="flex-1 flex flex-col bg-[#0d1117] text-white min-h-screen">
            {{-- Top Nav --}}
            <header class="flex items-center justify-between px-6 sm:px-10 lg:px-16 py-6">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="SiSampah Logo" class="w-14 h-14 object-contain drop-shadow-sm group-hover:scale-110 transition-transform">
                    <span class="text-2xl font-semibold text-white">SiSampah<span class="text-primary">.</span></span>
                </a>
                <nav class="hidden sm:flex items-center gap-6 text-sm">
                    <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">Beranda</a>
                    @if(request()->routeIs('login'))
                        <a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition-colors">Daftar</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors">Masuk</a>
                    @endif
                </nav>
            </header>

            {{-- Form Content --}}
            <div class="flex-1 flex items-center justify-center px-6 sm:px-10 lg:px-16 pb-12">
                <div class="w-full max-w-md animate-fade-in">
                    {{ $slot }}
                </div>
            </div>

            {{-- Footer tagline --}}
            <div class="px-6 sm:px-10 lg:px-16 pb-8 text-center sm:text-left">
                <p class="text-xs text-gray-500">Bersih Desa, Sejahtera Bersama</p>
            </div>
        </div>

        {{-- Right: Sampah Background Panel --}}
        <div class="hidden lg:flex lg:w-[45%] xl:w-1/2 relative overflow-hidden auth-bg-panel">
            <div class="absolute inset-0 auth-bg-overlay"></div>

            {{-- Decorative dashed divider --}}
            <div class="absolute left-0 top-0 bottom-0 w-px border-l border-dashed border-white/10"></div>

            {{-- Content overlay --}}
            <div class="relative z-10 flex flex-col justify-between p-12 w-full">
                <div></div>

                @php
                    $nasabahAktif = Cache::remember('guest_stats_nasabah', 3600, fn() => \App\Models\User::role('nasabah')->count());
                    
                    $sampahTerolah = Cache::remember('guest_stats_sampah', 3600, fn() => \App\Models\Transaction::where('status', 'selesai')->sum('berat_kg'));
                    $sampahFormatted = $sampahTerolah >= 1000 ? number_format($sampahTerolah / 1000, 1) . ' Ton' : number_format($sampahTerolah, 1) . ' Kg';
                    
                    $transaksiSukses = Cache::remember('guest_stats_transaksi', 3600, fn() => \App\Models\Transaction::where('status', 'selesai')->count());
                @endphp

                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm text-white/90">
                        <svg class="w-4 h-4 text-forest-emerald" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Bank Sampah Digital
                    </div>
                    <h2 class="text-4xl xl:text-5xl font-bold text-white leading-tight">
                        Ubah Sampah<br>Menjadi <span class="text-forest-emerald">Berkah</span>
                    </h2>
                    <p class="text-white/70 text-lg max-w-md leading-relaxed">
                        Kelola sampah Anda dengan mudah, dapatkan penghasilan, dan jaga kebersihan desa bersama SiSampah.
                    </p>

                    {{-- Stats --}}
                    <div class="flex gap-8 pt-4">
                        <div>
                            <p class="text-3xl font-bold text-white">{{ number_format($nasabahAktif) }}+</p>
                            <p class="text-sm text-white/60">Nasabah Aktif</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-white">{{ $sampahFormatted }}</p>
                            <p class="text-sm text-white/60">Sampah Terolah</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-white">{{ number_format($transaksiSukses) }}</p>
                            <p class="text-sm text-white/60">Transaksi Sukses</p>
                        </div>
                    </div>
                </div>

                {{-- Bottom logo --}}
                <div class="flex justify-end">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/logo.png') }}" alt="SiSampah" class="w-10 h-10 object-contain drop-shadow-sm">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
