<div x-data="notificationComponent()" x-init="fetchNotifications()" class="relative">
    <!-- Bell Button -->
    <button @click="toggleOpen()" class="relative w-9 h-9 rounded-xl bg-slate-800/80 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-700/80 flex items-center justify-center transition-all shadow-sm focus:outline-none">
        <i class="bi bi-bell text-base"></i>
        
        <!-- Red Badge if unread -->
        <template x-if="unreadCount > 0">
            <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 bg-rose-500 text-white font-extrabold text-[10px] rounded-full flex items-center justify-center shadow-md animate-pulse"
                  x-text="unreadCount > 99 ? '99+' : unreadCount"></span>
        </template>
    </button>

    <!-- Dropdown Panel -->
    <div x-show="open" 
         @click.outside="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
         class="absolute right-0 mt-3 w-80 sm:w-96 bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl z-50 overflow-hidden"
         style="display: none;">
        
        <!-- Header -->
        <div class="px-4 py-3 border-b border-slate-800 flex items-center justify-between bg-slate-900/90">
            <div class="flex items-center gap-2">
                <i class="bi bi-bell-fill text-emerald-400 text-sm"></i>
                <h3 class="text-xs font-bold text-white uppercase tracking-wider">Notifikasi</h3>
                <template x-if="unreadCount > 0">
                    <span class="px-2 py-0.5 bg-emerald-500/20 text-emerald-400 text-[10px] font-bold rounded-full border border-emerald-500/30" x-text="unreadCount + ' Baru'"></span>
                </template>
            </div>

            <button @click="markAllRead()" class="text-[11px] font-semibold text-slate-400 hover:text-emerald-400 transition-colors">
                Tandai Dibaca
            </button>
        </div>

        <!-- List Content -->
        <div class="max-h-80 overflow-y-auto divide-y divide-slate-800/60 custom-scrollbar">
            <template x-if="loading">
                <div class="p-6 text-center text-slate-400 text-xs flex items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memuat notifikasi...
                </div>
            </template>

            <template x-if="!loading && notifications.length === 0">
                <div class="p-8 text-center">
                    <i class="bi bi-bell-slash text-2xl text-slate-600 mb-2 block"></i>
                    <p class="text-xs text-slate-400 font-medium">Tidak ada notifikasi saat ini.</p>
                </div>
            </template>

            <template x-for="item in notifications" :key="item.id">
                <a :href="item.url" class="block p-3.5 hover:bg-slate-800/70 transition-colors group relative" :class="item.is_read ? 'opacity-70' : 'bg-slate-800/30'">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0" :class="item.bg">
                            <i :class="'bi ' + item.icon + ' text-sm'"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-1 mb-0.5">
                                <h4 class="text-xs font-bold text-white group-hover:text-emerald-400 transition-colors truncate" x-text="item.title"></h4>
                                <span class="text-[10px] text-slate-400 shrink-0" x-text="item.time"></span>
                            </div>
                            <p class="text-[11px] text-slate-300 line-clamp-2 leading-relaxed" x-text="item.message"></p>
                        </div>
                    </div>
                </a>
            </template>
        </div>
    </div>
</div>

<script>
    function notificationComponent() {
        return {
            open: false,
            loading: false,
            unreadCount: 0,
            notifications: [],

            toggleOpen() {
                this.open = !this.open;
                if (this.open) {
                    this.fetchNotifications();
                }
            },

            async fetchNotifications() {
                try {
                    const res = await fetch('{{ route("api.notifications") }}');
                    if (res.ok) {
                        const data = await res.json();
                        this.unreadCount = data.unread_count || 0;
                        this.notifications = data.notifications || [];
                    }
                } catch (e) {
                    console.error('Error fetching notifications:', e);
                }
            },

            async markAllRead() {
                try {
                    await fetch('{{ route("api.notifications.read") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    this.unreadCount = 0;
                    this.notifications.forEach(n => n.is_read = true);
                } catch (e) {
                    console.error('Error marking notifications read:', e);
                }
            }
        }
    }
</script>
