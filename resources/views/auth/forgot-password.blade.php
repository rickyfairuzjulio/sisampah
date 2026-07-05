<x-guest-layout>
    <!-- Modern Header with Gradient -->
    <div class="mb-8 animate-fade-in">
        <div class="bg-gradient-to-br from-primary to-forest-emerald rounded-2xl p-6 mb-6 shadow-lg">
            <h1 class="text-3xl font-bold text-white mb-2">Lupa Password?</h1>
            <p class="text-white/90 text-sm">Tenang, kami siap membantu Anda memulihkan akun</p>
        </div>
    </div>

    <!-- Session Status Alert -->
    @if (session('status'))
        <x-alert type="success" class="mb-6 animate-slide-in">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="font-semibold">Berhasil!</p>
                    <p class="text-sm">{{ session('status') }}</p>
                </div>
            </div>
        </x-alert>
    @endif

    <!-- Info Message -->
    <div class="bg-soft-mint border border-primary/20 rounded-xl p-4 mb-6 animate-slide-in">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-sm text-on-surface">Masukkan alamat email Anda, dan kami akan mengirimkan link untuk mengatur ulang password Anda.</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Field -->
        <div class="animate-slide-in" style="animation-delay: 100ms">
            <x-input-field
                label="Alamat Email"
                name="email"
                type="email"
                placeholder="nama@email.com"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="email"
                :error="$errors->has('email') ? $errors->first('email') : false"
            />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full py-3 px-6 bg-gradient-to-r from-primary to-forest-emerald hover:shadow-lg hover:scale-105 text-white font-bold rounded-xl transition-all duration-300 active:scale-95">
            <span class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Kirim Link Pemulihan
            </span>
        </button>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-outline-variant"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-surface-container-lowest text-on-surface-variant">Atau</span>
            </div>
        </div>

        <!-- Back to Login Link -->
        <div class="text-center">
            <a href="{{ route('login') }}" class="inline-block w-full py-3 px-6 border-2 border-primary text-primary font-bold rounded-xl hover:bg-primary/5 transition-all duration-300">
                Kembali ke Login
            </a>
        </div>

        <!-- Help Text -->
        <p class="text-xs text-on-surface-variant text-center">
            Masih memerlukan bantuan? 
            <a href="#" class="text-primary hover:underline font-semibold">Hubungi tim support kami</a>
        </p>
    </form>
</x-guest-layout>
