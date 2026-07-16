<x-guest-layout>
    <div class="mb-8">
        <p class="text-xs font-semibold tracking-widest text-gray-500 uppercase mb-3">Mulai Gratis</p>
        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-2">
            Masuk ke akun<span class="text-primary">.</span>
        </h2>
        <p class="text-gray-400 text-sm">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-primary hover:text-forest-emerald font-semibold transition-colors">Daftar sekarang</a>
        </p>
    </div>

    @if(session('status'))
        <div class="mb-6 px-4 py-3 rounded-xl bg-primary/20 border border-primary/30 text-primary text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5 animate-slide-in">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}"
                   placeholder="nama@email.com" required autofocus autocomplete="username"
                   class="auth-input @error('email') border-red-500 @enderror">
            @error('email')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
            <div class="relative">
                <input id="password" name="password" type="password" required autocomplete="current-password"
                       placeholder="••••••••"
                       class="auth-input pr-12 @error('password') border-red-500 @enderror">
                <button type="button" onclick="togglePassword('password', 'eyeIcon')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition-colors">
                    <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                       class="w-4 h-4 rounded border-gray-600 bg-[#1a1f2e] text-primary focus:ring-primary/30">
                <span class="text-sm text-gray-400">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-primary hover:text-forest-emerald transition-colors">
                    Lupa password?
                </a>
            @endif
        </div>

        <button type="submit"
                class="w-full py-3.5 px-4 text-sm font-bold text-white bg-gradient-to-r from-primary to-forest-emerald hover:from-forest-emerald hover:to-primary rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-primary/30 mt-2 hover:-translate-y-0.5">
            Masuk ke Dashboard
        </button>
    </form>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }
    </script>
</x-guest-layout>
