<div x-data="{ toasts: [] }" 
     @notify.window="
        let id = Date.now();
        toasts.push({
            id: id,
            type: $event.detail.type || 'info',
            message: $event.detail.message,
            show: true
        }); 
        setTimeout(() => { 
            let index = toasts.findIndex(t => t.id === id);
            if(index > -1) toasts[index].show = false; 
            setTimeout(() => {
                toasts = toasts.filter(t => t.id !== id);
            }, 300);
        }, 3000)
     "
     class="fixed bottom-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none">
    
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.show" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:translate-x-8"
             x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 translate-x-8"
             class="max-w-sm w-full bg-surface-container-highest shadow-2xl rounded-2xl pointer-events-auto overflow-hidden border backdrop-blur-xl relative"
             :class="{
                'border-green-500/30 shadow-green-500/10': toast.type === 'success',
                'border-red-500/30 shadow-red-500/10': toast.type === 'error',
                'border-blue-500/30 shadow-blue-500/10': toast.type === 'info'
             }">
            
            <div class="p-4 flex items-start gap-3">
                <div class="flex-shrink-0 mt-0.5">
                    <!-- Success Icon -->
                    <div x-show="toast.type === 'success'" class="w-8 h-8 rounded-full bg-green-500/10 flex items-center justify-center">
                        <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <!-- Error Icon -->
                    <div x-show="toast.type === 'error'" class="w-8 h-8 rounded-full bg-red-500/10 flex items-center justify-center">
                        <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <!-- Info Icon -->
                    <div x-show="toast.type === 'info'" class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center">
                        <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-2 w-0 flex-1 pt-1">
                    <p class="text-xs font-bold uppercase tracking-wider mb-0.5" 
                       :class="{
                           'text-green-500': toast.type === 'success',
                           'text-red-500': toast.type === 'error',
                           'text-blue-500': toast.type === 'info'
                       }" 
                       x-text="toast.type === 'success' ? 'Berhasil' : (toast.type === 'error' ? 'Gagal' : 'Informasi')">
                    </p>
                    <p x-text="toast.message" class="text-sm font-semibold text-on-surface leading-tight"></p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button @click="toast.show = false" class="inline-flex text-on-surface-variant hover:text-on-surface focus:outline-none bg-surface-container hover:bg-surface-container-high rounded-full p-1.5 transition-colors">
                        <span class="sr-only">Close</span>
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="absolute bottom-0 left-0 h-1 bg-surface-container w-full">
                <div class="h-full rounded-r-full"
                     style="animation: toast-progress 3s linear forwards;"
                     :class="{
                        'bg-green-500': toast.type === 'success',
                        'bg-red-500': toast.type === 'error',
                        'bg-blue-500': toast.type === 'info'
                     }">
                </div>
            </div>
        </div>
    </template>
</div>
<style>
@keyframes toast-progress {
    0% { width: 100%; }
    100% { width: 0%; }
}
</style>
