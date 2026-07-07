<nav x-data="{ open: false }" class="bg-surface-container-lowest shadow-ambient border-b border-surface-container">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-primary tracking-tight flex items-center gap-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        SiSampah
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold tracking-wide transition-colors duration-200 {{ request()->routeIs('home') ? 'border-primary text-on-surface' : 'border-transparent text-on-surface-variant hover:text-on-surface hover:border-outline-variant' }}">
                        Beranda
                    </a>
                    <a href="{{ route('edukasi.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold tracking-wide transition-colors duration-200 {{ request()->routeIs('edukasi.*') ? 'border-primary text-on-surface' : 'border-transparent text-on-surface-variant hover:text-on-surface hover:border-outline-variant' }}">
                        Edukasi
                    </a>
                    @auth
                        @if(Auth::user()->hasRole('nasabah'))
                            <a href="{{ route('nasabah.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold tracking-wide transition-colors duration-200 {{ request()->routeIs('nasabah.*') ? 'border-primary text-on-surface' : 'border-transparent text-on-surface-variant hover:text-on-surface hover:border-outline-variant' }}">
                                Dashboard
                            </a>
                        @elseif(Auth::user()->hasRole('petugas'))
                            <a href="{{ route('petugas.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold tracking-wide transition-colors duration-200 {{ request()->routeIs('petugas.*') ? 'border-primary text-on-surface' : 'border-transparent text-on-surface-variant hover:text-on-surface hover:border-outline-variant' }}">
                                Dashboard
                            </a>
                        @elseif(Auth::user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold tracking-wide transition-colors duration-200 {{ request()->routeIs('admin.*') ? 'border-primary text-on-surface' : 'border-transparent text-on-surface-variant hover:text-on-surface hover:border-outline-variant' }}">
                                Dashboard
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-2">
                <!-- Theme Toggle -->
                <x-theme-toggle />

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-semibold rounded-full text-on-surface-variant bg-surface-container-low hover:text-on-surface hover:bg-surface-container transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
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

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-surface-container-lowest border-t border-surface-container">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                Beranda
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('edukasi.index')" :active="request()->routeIs('edukasi.*')">
                Edukasi
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-surface-container">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-on-surface">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-on-surface-variant">{{ Auth::user()->email }}</div>
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
