<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <title>{{ config('app.name', 'SiSampah') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
<body class="font-sans antialiased bg-background text-text-primary overflow-hidden transition-colors duration-300">
    
    <div class="flex h-screen w-full bg-background" x-data="{ sidebarOpen: false }">
        
        <!-- Desktop Sidebar -->
        <div class="hidden lg:block h-full">
            @include('layouts.sidebar')
        </div>

        <!-- Mobile Sidebar Backdrop Overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden"
             @click="sidebarOpen = false"
             x-cloak></div>

        <!-- Mobile Sidebar Drawer -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 z-50 w-[260px] bg-[#041A12] lg:hidden h-full"
             x-cloak>
            @include('layouts.sidebar')
        </div>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col h-full overflow-hidden relative z-0">
            
            <!-- Dashboard Navbar / Top Header -->
            <nav class="bg-[#041A12]/90 backdrop-blur-md border-b border-white/5 h-[72px] flex items-center justify-between px-4 sm:px-6 sticky top-0 z-30 transition-colors duration-300">
                
                <!-- Mobile Menu Button & Logo -->
                <div class="flex items-center gap-3 lg:hidden">
                    <button @click="sidebarOpen = !sidebarOpen" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 text-[#8BA39A] hover:text-white flex items-center justify-center transition-colors">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8">
                        <span class="font-bold text-white text-base sm:hidden">SiSampah</span>
                    </a>
                </div>

                <!-- Header Title for Desktop -->
                <div class="hidden lg:block">
                    @isset($header)
                        <h1 class="text-xl font-bold text-white tracking-tight">{{ $header }}</h1>
                    @endisset
                </div>

                <!-- Search Bar Center (Tablet & Desktop) -->
                <div class="flex-1 max-w-md mx-auto hidden md:block px-4">
                    <div class="relative group">
                        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-[#8BA39A] group-focus-within:text-primary transition-colors"></i>
                        <input type="text" placeholder="Pencarian cepat..." class="w-full pl-11 pr-4 py-2.5 bg-white/5 border border-white/10 rounded-full text-white placeholder:text-[#8BA39A] focus:bg-white/10 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-sm font-medium">
                    </div>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-2 sm:gap-4">
                    
                    <x-theme-toggle />

                    <button class="relative w-10 h-10 rounded-full flex items-center justify-center text-[#8BA39A] hover:bg-white/5 hover:text-white transition-all">
                        <i class="bi bi-bell-fill text-lg"></i>
                        <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-danger rounded-full border-2 border-[#041A12]"></span>
                    </button>

                    <div class="w-[1px] h-6 bg-white/10 mx-1 hidden sm:block"></div>

                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-3 group cursor-pointer hover:bg-white/5 p-1 rounded-full sm:pr-4 transition-colors border border-transparent hover:border-white/10">
                                    <img src="{{ Auth::user()->avatar_url }}" class="w-9 h-9 rounded-full object-cover border-2 border-primary" alt="{{ Auth::user()->name }}">
                                    <div class="hidden sm:block text-left">
                                        <p class="text-sm font-bold text-white leading-none">{{ Auth::user()->name }}</p>
                                        <p class="text-[10px] text-primary font-bold mt-1.5 uppercase tracking-wide">{{ Auth::user()->roles->first()->name ?? 'User' }}</p>
                                    </div>
                                    <i class="bi bi-chevron-down text-[#8BA39A] text-xs ml-1 group-hover:text-white transition-colors hidden sm:block"></i>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')" class="!text-sm !font-bold">
                                    <i class="bi bi-person mr-2 text-primary"></i> Profil Saya
                                </x-dropdown-link>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="!text-sm !font-bold !text-danger hover:bg-danger/10">
                                        <i class="bi bi-box-arrow-right mr-2"></i> Keluar
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @endauth
                </div>
            </nav>

            <!-- Page Content (Scrollable) -->
            <div class="flex-1 overflow-y-auto custom-scrollbar relative z-0">
                <div class="p-4 sm:p-6 lg:p-8 pb-28 sm:pb-28 lg:pb-28 max-w-[1600px] mx-auto min-h-full flex flex-col">
                    @yield('content')
                    {{ $slot ?? '' }}
                    
                    <!-- Dashboard Footer -->
                    <footer class="mt-auto pt-8 pb-2 text-center">
                        <p class="text-[11px] font-semibold text-text-muted">
                            &copy; {{ date('Y') }} SiSampah Enterprise Dashboard. Dikembangkan oleh <span class="text-primary font-bold">Bodrex Developer</span>.
                        </p>
                    </footer>
                </div>
            </div>

        </main>
    </div>

    <x-chatbot-widget />
    <x-toast />
    
    <!-- Render scripts pushed by components -->
    @stack('scripts')
    
    @if(session('welcome'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Halo!',
                text: "{{ session('welcome') }}",
                icon: 'success',
                confirmButtonText: 'Lanjut',
                confirmButtonColor: '#22C55E',
                background: document.documentElement.classList.contains('dark') ? '#0B2A1F' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#0F172A',
                customClass: { popup: 'rounded-[24px]', confirmButton: 'rounded-[16px] px-8 shadow-soft font-bold' }
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
                confirmButtonColor: '#EF4444',
                background: document.documentElement.classList.contains('dark') ? '#0B2A1F' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#0F172A',
                customClass: { popup: 'rounded-[24px]', confirmButton: 'rounded-[16px] px-8 shadow-soft font-bold' }
            });
        });
    </script>
    @endif

</body>
</html>
