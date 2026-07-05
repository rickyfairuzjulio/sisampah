<!DOCTYPE html>
<html lang="{{ str_replace('_', ''-'', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SiSampah') }} - Bank Sampah Digital</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    @vite([''resources/css/app.css'', ''resources/css/animations.css'', ''resources/js/app.js''])
</head>
<body class="font-sans antialiased bg-background text-on-surface overflow-x-hidden">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-outline-variant sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-forest-emerald rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-lg text-on-surface">SiSampah</span>
                </a>

                <!-- Auth Links -->
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-primary hover:text-primary-container font-semibold transition-colors">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="py-2 px-6 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition-colors">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-on-surface hover:text-primary font-semibold transition-colors">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="py-2 px-6 bg-gradient-to-r from-primary to-forest-emerald hover:shadow-lg text-white font-bold rounded-lg transition-all duration-300">
                            Daftar Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-primary via-forest-emerald to-primary/90 relative overflow-hidden py-20 md:py-32">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute w-72 h-72 bg-white rounded-full mix-blend-multiply filter blur-3xl -top-20 -left-20"></div>
            <div class="absolute w-72 h-72 bg-white rounded-full mix-blend-multiply filter blur-3xl -bottom-20 -right-20"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 animate-fade-in">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <div>
                        <h1 class="text-5xl md:text-6xl font-bold text-white mb-4 leading-tight">
                            Ubah Sampah Jadi <span class="text-yellow-300">Berkah</span>
                        </h1>
                        <p class="text-xl text-white/90">
                            SiSampah adalah platform digital untuk bank sampah yang mengubah limbah menjadi nilai ekonomi bagi komunitas.
                        </p>
                    </div>

                    <div class="flex gap-4 flex-wrap">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-white text-primary font-bold rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-300">
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-primary font-bold rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-300">
                                Mulai Sekarang
                            </a>
                            <a href="{{ route('login') }}" class="px-8 py-4 border-2 border-white text-white font-bold rounded-xl hover:bg-white/10 transition-all duration-300">
                                Saya Sudah Punya Akun
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="relative h-96 hidden md:flex items-center justify-center">
                    <div class="w-64 h-64 bg-white/20 rounded-3xl backdrop-blur-sm p-8 border border-white/30">
                        <svg class="w-full h-full text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.707 5.293a1 1 0 00-1.414 0L11 13.586V5a2 2 0 10-4 0v9.5m10-9l-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 md:py-32 bg-background">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 animate-fade-in">
                <h2 class="text-4xl font-bold text-on-surface mb-4">Fitur Unggulan</h2>
                <p class="text-xl text-on-surface-variant">Platform yang dirancang untuk kemudahan dan efisiensi</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 animate-slide-in">
                <!-- Feature 1 -->
                <div class="p-8 rounded-2xl bg-soft-mint border-2 border-primary/20 hover:shadow-xl hover:scale-105 transition-all duration-300">
                    <div class="w-14 h-14 bg-primary/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-on-surface mb-2">Kelola Saldo</h3>
                    <p class="text-on-surface-variant">Lacak saldo aktif Anda dan tukarkan dengan uang tunai atau hadiah menarik</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 rounded-2xl bg-blue-50 border-2 border-blue-200 hover:shadow-xl hover:scale-105 transition-all duration-300">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-on-surface mb-2">Jemput Cepat</h3>
                    <p class="text-on-surface-variant">Pesan jemput sampah langsung dari rumah Anda dengan mudah</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 rounded-2xl bg-amber-50 border-2 border-amber-200 hover:shadow-xl hover:scale-105 transition-all duration-300">
                    <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-on-surface mb-2">Laporan Real-time</h3>
                    <p class="text-on-surface-variant">Pantau statistik sampah dan dampak lingkungan Anda secara langsung</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 md:py-32 bg-gradient-to-r from-primary to-forest-emerald">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center animate-fade-in">
                    <div class="text-4xl md:text-5xl font-bold text-white mb-2">10K+</div>
                    <p class="text-white/90">Nasabah Aktif</p>
                </div>
                <div class="text-center animate-fade-in" style="animation-delay: 100ms">
                    <div class="text-4xl md:text-5xl font-bold text-white mb-2">500T+</div>
                    <p class="text-white/90">Sampah Terolah</p>
                </div>
                <div class="text-center animate-fade-in" style="animation-delay: 200ms">
                    <div class="text-4xl md:text-5xl font-bold text-white mb-2">100+</div>
                    <p class="text-white/90">Bank Sampah Bermitra</p>
                </div>
                <div class="text-center animate-fade-in" style="animation-delay: 300ms">
                    <div class="text-4xl md:text-5xl font-bold text-white mb-2">1M+</div>
                    <p class="text-white/90">Uang Terkumpul</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 md:py-32 bg-background">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-slide-in">
            <div class="bg-gradient-to-br from-primary/10 to-forest-emerald/10 border-2 border-primary/20 rounded-3xl p-12 md:p-16">
                <h2 class="text-4xl font-bold text-on-surface mb-4">Siap Memulai?</h2>
                <p class="text-xl text-on-surface-variant mb-8">Bergabunglah dengan ribuan pengguna yang telah mengubah sampah menjadi berkah</p>
                
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-block px-12 py-4 bg-gradient-to-r from-primary to-forest-emerald hover:shadow-lg hover:scale-105 text-white font-bold rounded-xl transition-all duration-300">
                        Buka Dashboard Saya
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-block px-12 py-4 bg-gradient-to-r from-primary to-forest-emerald hover:shadow-lg hover:scale-105 text-white font-bold rounded-xl transition-all duration-300">
                        Daftar Gratis Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-on-background text-white py-12 border-t border-outline-variant">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold">SiSampah</span>
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
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Hubungi</h4>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li>?? hello@sisampah.id</li>
                        <li>?? +62 822 1234 5678</li>
                        <li>?? Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/20 pt-8 text-center text-white/70 text-sm">
                <p>&copy; {{ date('Y') }} SiSampah. Semua hak cipta dilindungi. | Bersih Desa, Sejahtera Bersama.</p>
            </div>
        </div>
    </footer>
</body>
</html>
