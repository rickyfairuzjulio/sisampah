<div x-data="{ toasts: [] }" 
     @notify.window="toasts.push({
        id: Date.now(),
        type: $event.detail.type,
        message: $event.detail.message,
        show: true
     }); setTimeout(() => { toasts[toasts.length - 1].show = false; setTimeout(() => toasts.shift(), 300) }, 3000)"
     class="fixed bottom-4 right-4 z-50 flex flex-col gap-2 pointer-events-none">
    
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.show" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="max-w-sm w-full bg-surface-container-high shadow-lg rounded-xl pointer-events-auto overflow-hidden border border-outline-variant backdrop-blur-md">
            <div class="p-4 flex items-start gap-3">
                <div class="flex-shrink-0">
                    <!-- Success Icon -->
                    <svg x-show="toast.type === 'success'" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <!-- Error Icon -->
                    <svg x-show="toast.type === 'error'" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <!-- Info Icon -->
                    <svg x-show="toast.type === 'info' || !toast.type" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p x-text="toast.message" class="text-sm font-medium text-on-surface"></p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button @click="toast.show = false" class="inline-flex text-on-surface-variant hover:text-on-surface focus:outline-none">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
