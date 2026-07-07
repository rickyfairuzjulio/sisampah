<div x-data="themeToggle()" class="relative" @click.away="isOpen = false">
    <button @click="isOpen = !isOpen" type="button" class="flex items-center justify-center w-10 h-10 rounded-full text-on-surface hover:bg-surface-container transition-colors focus:outline-none focus:ring-2 focus:ring-primary" aria-label="Toggle Theme">
        <!-- Sun Icon (Light Mode) -->
        <svg x-show="theme === 'light'" x-cloak class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        
        <!-- Moon Icon (Dark Mode) -->
        <svg x-show="theme === 'dark'" x-cloak class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
        
        <!-- System/Auto Icon (Auto Mode) -->
        <svg x-show="theme === 'auto'" x-cloak class="w-5 h-5 text-outline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
    </button>

    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-36 rounded-xl shadow-lg bg-surface-container-lowest ring-1 ring-black/5 divide-y divide-surface-container z-50 py-1"
         x-cloak>
        <button @click="setTheme('light')" class="w-full text-left px-4 py-2 text-sm text-on-surface hover:bg-surface-container flex items-center gap-2" :class="{'text-primary font-semibold': theme === 'light'}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Light
        </button>
        <button @click="setTheme('dark')" class="w-full text-left px-4 py-2 text-sm text-on-surface hover:bg-surface-container flex items-center gap-2" :class="{'text-primary font-semibold': theme === 'dark'}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            Dark
        </button>
        <button @click="setTheme('auto')" class="w-full text-left px-4 py-2 text-sm text-on-surface hover:bg-surface-container flex items-center gap-2" :class="{'text-primary font-semibold': theme === 'auto'}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            System
        </button>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('themeToggle', () => ({
            isOpen: false,
            theme: localStorage.getItem('theme') || 'auto',
            
            init() {
                // Watch for system changes if auto
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                    if (this.theme === 'auto') {
                        this.applyTheme(e.matches ? 'dark' : 'light');
                    }
                });
            },

            setTheme(newTheme) {
                this.theme = newTheme;
                localStorage.setItem('theme', newTheme);
                this.isOpen = false;
                
                if (newTheme === 'auto') {
                    const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    this.applyTheme(systemDark ? 'dark' : 'light');
                } else {
                    this.applyTheme(newTheme);
                }
            },

            applyTheme(activeTheme) {
                if (activeTheme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        }));
    });
</script>
