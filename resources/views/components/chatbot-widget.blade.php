<div x-data="aiAssistantWidget()" 
     class="fixed bottom-6 right-6 md:bottom-8 md:right-8 z-50 flex flex-col items-end"
     @keydown.escape.window="isOpen = false">
    
    <!-- Assistant Window -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-2xl w-[350px] sm:w-[400px] h-[500px] max-h-[80vh] flex flex-col mb-4 overflow-hidden"
         x-cloak>
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary to-forest-emerald p-4 flex items-center justify-between text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center backdrop-blur-sm border-2 border-primary-container p-1.5 shadow-sm">
                    <img src="{{ asset('images/chatbot-icon.png') }}" class="w-full h-full object-contain" alt="AI">
                </div>
                <div>
                    <h3 class="font-bold text-lg leading-tight">SiSampah AI</h3>
                    <p class="text-xs text-white/80">Asisten Daur Ulang Anda</p>
                </div>
            </div>
            <button @click="isOpen = false" class="text-white hover:text-white/70 transition-colors p-1 rounded-lg hover:bg-white/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Messages Area -->
        <div class="flex-1 p-4 overflow-y-auto bg-surface-container-lowest space-y-4" id="assistant-dialogue" x-ref="messagesBox">
            
            <!-- Welcome Message -->
            <div class="flex gap-3">
                <div class="w-8 h-8 rounded-full bg-white border-2 border-primary flex items-center justify-center flex-shrink-0 p-1">
                    <img src="{{ asset('images/chatbot-icon.png') }}" class="w-full h-full object-contain" alt="AI">
                </div>
                <div class="bg-surface-container rounded-2xl rounded-tl-none p-3 max-w-[85%] text-sm text-on-surface">
                    Halo! Saya SiSampah AI. Ada yang bisa saya bantu terkait pengelolaan sampah, harga, fitur aplikasi, atau daur ulang hari ini?
                </div>
            </div>

            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex gap-3" :class="msg.role === 'user' ? 'flex-row-reverse' : ''">
                    <!-- Avatar -->
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" 
                         :class="msg.role === 'user' ? 'bg-forest-emerald text-white' : 'bg-white border-2 border-primary p-1'">
                        <span x-show="msg.role === 'user'">👤</span>
                        <img x-show="msg.role !== 'user'" src="{{ asset('images/chatbot-icon.png') }}" class="w-full h-full object-contain" alt="AI">
                    </div>
                    
                    <!-- Bubble -->
                    <div class="p-3 text-sm rounded-2xl max-w-[85%]"
                         :class="msg.role === 'user' ? 'bg-forest-emerald text-white rounded-tr-none' : 'bg-surface-container text-on-surface rounded-tl-none'">
                        <!-- Render Markdown basic or Text -->
                        <div class="whitespace-pre-wrap" x-html="formatMessage(msg.text)"></div>
                    </div>
                </div>
            </template>

            <!-- Loading Indicator -->
            <div x-show="isLoading" class="flex gap-3" x-cloak>
                <div class="w-8 h-8 rounded-full bg-white border-2 border-primary flex items-center justify-center flex-shrink-0 p-1">
                    <img src="{{ asset('images/chatbot-icon.png') }}" class="w-full h-full object-contain" alt="AI">
                </div>
                <div class="bg-surface-container rounded-2xl rounded-tl-none p-4 flex gap-1 items-center max-w-[85%]">
                    <div class="w-2 h-2 bg-on-surface-variant rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                    <div class="w-2 h-2 bg-on-surface-variant rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                    <div class="w-2 h-2 bg-on-surface-variant rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-surface-container-lowest border-t border-outline-variant">
            <form @submit.prevent="sendMessage" class="flex items-end gap-2">
                <div class="flex-1 bg-surface-container rounded-2xl border border-outline-variant focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-all overflow-hidden relative">
                    <textarea x-model="inputText" 
                              @keydown.enter.prevent="if(!$event.shiftKey) sendMessage()"
                              rows="1" 
                              placeholder="Tanya seputar sampah..." 
                              class="w-full bg-transparent border-none focus:ring-0 resize-none py-3 px-4 text-sm text-on-surface max-h-[100px] min-h-[44px]"
                              style="scrollbar-width: none;"></textarea>
                </div>
                <button type="submit" 
                        :disabled="isLoading || inputText.trim() === ''"
                        class="w-11 h-11 rounded-full bg-primary hover:bg-primary-container text-white flex items-center justify-center transition-transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 flex-shrink-0 shadow-md">
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
            <div class="text-[10px] text-center text-on-surface-variant mt-2">
                AI dapat membuat kesalahan. Periksa info penting.
            </div>
        </div>
    </div>

    <!-- Toggle Button -->
    <button @click="isOpen = !isOpen" 
            class="w-14 h-14 rounded-full bg-white border-2 border-primary text-primary flex items-center justify-center shadow-2xl hover:shadow-primary/50 transition-all duration-300 hover:scale-110 relative z-50">
        
        <img x-show="!isOpen" src="{{ asset('images/chatbot-icon.png') }}" class="w-10 h-10 object-contain" alt="Assistant">

        <svg x-show="isOpen" class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>

        <!-- Notification Badge -->
        <span x-show="!isOpen && unreadCount > 0" class="absolute -top-1 -right-1 flex h-4 w-4">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 text-[9px] text-white items-center justify-center" x-text="unreadCount"></span>
        </span>
    </button>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('aiAssistantWidget', () => ({
            isOpen: false,
            isLoading: false,
            inputText: '',
            unreadCount: 0,
            messages: [],
            
            init() {
                this.$watch('isOpen', value => {
                    if (value) {
                        this.unreadCount = 0;
                        setTimeout(() => this.scrollToBottom(), 100);
                    }
                });
            },

            formatMessage(text) {
                // Simple markdown formatter for bold and lists
                let formatted = text
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/\*(.*?)\*/g, '<em>$1</em>')
                    .replace(/\n/g, '<br>');
                return formatted;
            },

            scrollToBottom() {
                if (this.$refs.messagesBox) {
                    this.$refs.messagesBox.scrollTop = this.$refs.messagesBox.scrollHeight;
                }
            },

            async sendMessage() {
                if (this.inputText.trim() === '' || this.isLoading) return;

                const userText = this.inputText.trim();
                this.inputText = '';
                
                // Add user message
                this.messages.push({ role: 'user', text: userText });
                this.scrollToBottom();

                this.isLoading = true;

                try {
                    const response = await fetch('/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            message: userText,
                            history: this.messages.slice(0, -1) // Send all previous messages except the current one
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.messages.push({ role: 'model', text: data.reply });
                        if (!this.isOpen) {
                            this.unreadCount++;
                        }
                    } else {
                        this.messages.push({ role: 'model', text: `⚠️ ${data.message}` });
                    }
                } catch (error) {
                    console.error('Chat error:', error);
                    this.messages.push({ role: 'model', text: '⚠️ Maaf, koneksi ke server terputus. Silakan coba lagi.' });
                } finally {
                    this.isLoading = false;
                    setTimeout(() => this.scrollToBottom(), 100);
                }
            }
        }));
    });
</script>
