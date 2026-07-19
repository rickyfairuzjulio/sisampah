<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SiSampah') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-surface text-on-surface">
    <div class="flex h-screen overflow-hidden bg-surface-dim">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-primary text-on-primary flex flex-col justify-between hidden md:flex shrink-0 shadow-xl z-20">
            <div>
                <!-- Logo -->
                <div class="h-20 flex items-center px-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-primary font-bold">
                            <!-- Placeholder icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold leading-tight">SiSampah Desa</h2>
                            <p class="text-[10px] text-on-primary-container leading-tight">Bersih Desa, Sejahtera Bersama</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-4 px-4 space-y-1">
                    <p class="px-2 text-xs font-semibold text-primary-fixed-dim uppercase tracking-wider mb-2">Menu Utama</p>
                    
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-full bg-primary-container text-white shadow-sm transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="font-semibold text-sm">Beranda</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-full text-primary-fixed-dim hover:bg-primary-container hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="font-semibold text-sm">Edukasi</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-full text-primary-fixed-dim hover:bg-primary-container hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span class="font-semibold text-sm">AI Waste Assistant</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-full text-primary-fixed-dim hover:bg-primary-container hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-semibold text-sm">Tabungan Sampah</span>
                    </a>
                    
                    <p class="px-2 text-xs font-semibold text-primary-fixed-dim uppercase tracking-wider mb-2 mt-6">Pengelolaan</p>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-full text-primary-fixed-dim hover:bg-primary-container hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="font-semibold text-sm">Kader & BSU</span>
                    </a>
                </nav>
            </div>

            <!-- User Profile Bottom -->
            <div class="p-4 border-t border-primary-container">
                <div class="flex items-center gap-3 mb-4 cursor-pointer hover:bg-primary-container p-2 rounded-xl transition">
                    <div class="w-10 h-10 bg-white rounded-full overflow-hidden flex-shrink-0 flex items-center justify-center">
                        <span class="text-primary font-bold">AF</span>
                    </div>
                    <div class="flex-grow overflow-hidden">
                        <p class="text-sm font-bold truncate">{{ Auth::user()->name ?? 'Ahmad Fauzi' }}</p>
                        <p class="text-xs text-primary-fixed-dim truncate">Kepala Desa</p>
                    </div>
                    <svg class="w-4 h-4 text-primary-fixed-dim" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-sm text-primary-fixed-dim hover:text-white transition px-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Header -->
            <header class="h-20 bg-surface shadow-sm flex items-center justify-between px-8 shrink-0 z-10">
                <div>
                    <h1 class="text-2xl font-bold text-on-surface">@yield('title', 'Beranda Desa')</h1>
                    <p class="text-sm text-on-surface-variant">@yield('subtitle', 'Kelola sampah, tingkatkan lingkungan, sejahterakan warga.')</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2 bg-surface-container px-4 py-2 rounded-full border border-surface-variant">
                        <svg class="w-4 h-4 text-outline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-sm font-semibold text-on-surface">{{ now()->translatedFormat('d F Y') }}</span>
                    </div>
                    <button class="relative p-2 text-on-surface hover:bg-surface-container rounded-full transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-error rounded-full ring-2 ring-surface"></span>
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto bg-surface-dim p-8">
                <div class="max-w-[1600px] mx-auto">
                    @yield('content')
                </div>
            </div>
        </main>

    </div>
</body>
</html>
