<nav x-data="{ open: false }" class="bg-surface-container-lowest shadow-ambient border-b border-surface-container">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-primary tracking-tight flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="SiSampah Logo" class="w-12 h-12 object-contain">
                        <span class="ml-1">SiSampah</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold tracking-wide transition-colors duration-200 {{ request()->routeIs('home') ? 'border-primary text-on-surface' : 'border-transparent text-on-surface-variant hover:text-on-surface hover:border-outline-variant' }}">
                        Beranda
                    </a>
                    <a href="{{ route('edukasi.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold tracking-wide transition-colors duration-200 {{ request()->routeIs('edukasi.*') ? 'border-primary text-on-surface' : 'border-transparent text-on-surface-variant hover:text-on-surface hover:border-outline-variant' }}">
                        Edukasi
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-2">
                <!-- Theme Toggle -->
                <x-theme-toggle />

                @auth
                    <x-notification-dropdown />
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-semibold rounded-full text-on-surface-variant bg-surface-container-low hover:text-on-surface hover:bg-surface-container transition ease-in-out duration-150">
                                <div class="flex items-center gap-2">
                                    <img src="{{ Auth::user()->avatar_url }}" class="w-6 h-6 rounded-full object-cover border border-outline-variant" alt="{{ Auth::user()->name }}">
                                    <span>{{ Auth::user()->name }}</span>
                                </div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(Auth::user()->hasRole('nasabah'))
                                <x-dropdown-link :href="route('nasabah.dashboard')">
                                    Dashboard Nasabah
                                </x-dropdown-link>
                            @elseif(Auth::user()->hasRole('petugas'))
                                <x-dropdown-link :href="route('petugas.dashboard')">
                                    Dashboard Petugas
                                </x-dropdown-link>
                            @elseif(Auth::user()->hasRole('admin'))
                                <x-dropdown-link :href="route('admin.dashboard')">
                                    Dashboard Admin
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('profile.edit')">
                                Profile
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Logout
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-semibold text-on-surface-variant hover:text-on-surface transition mr-2">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 bg-primary text-on-primary text-sm font-bold rounded-full hover:bg-primary-container active:scale-95 transition-all shadow-sm">
                        Daftar
                    </a>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden gap-2">
                <!-- Mobile Theme Toggle -->
                <x-theme-toggle />

                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-outline hover:text-on-surface hover:bg-surface-container focus:outline-none focus:bg-surface-container focus:text-on-surface transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="absolute top-16 left-0 w-full z-50 sm:hidden bg-surface-container-lowest border-b border-surface-container shadow-xl"
         style="display: none;">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Beranda
                </div>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('edukasi.index')" :active="request()->routeIs('edukasi.*')">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Edukasi
                </div>
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-surface-container">
            @auth
                <div class="px-4 flex items-center gap-3">
                    <img src="{{ Auth::user()->avatar_url }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="{{ Auth::user()->name }}">
                    <div>
                        <div class="font-medium text-base text-on-surface">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-on-surface-variant">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    @if(Auth::user()->hasRole('nasabah'))
                        <x-responsive-nav-link :href="route('nasabah.dashboard')">
                            Dashboard Nasabah
                        </x-responsive-nav-link>
                    @elseif(Auth::user()->hasRole('petugas'))
                        <x-responsive-nav-link :href="route('petugas.dashboard')">
                            Dashboard Petugas
                        </x-responsive-nav-link>
                    @elseif(Auth::user()->hasRole('admin'))
                        <x-responsive-nav-link :href="route('admin.dashboard')">
                            Dashboard Admin
                        </x-responsive-nav-link>
                    @endif

                    <x-responsive-nav-link :href="route('profile.edit')">
                        Profile
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            Logout
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        Masuk
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        Daftar
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
