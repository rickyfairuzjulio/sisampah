<x-guest-layout>
    <div class="mb-8">
        <p class="text-xs font-semibold tracking-widest text-gray-500 uppercase mb-3">Mulai Gratis</p>
        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-2">
            Buat akun baru<span class="text-primary">.</span>
        </h2>
        <p class="text-gray-400 text-sm">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-primary hover:text-forest-emerald font-semibold transition-colors">Masuk di sini</a>
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5 animate-slide-in">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}"
                   placeholder="Ahmad Fauzi" required autofocus autocomplete="name"
                   class="auth-input @error('name') border-red-500 @enderror">
            @error('name')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}"
                   placeholder="nama@email.com" required autocomplete="username"
                   class="auth-input @error('email') border-red-500 @enderror">
            @error('email')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
            <div class="relative">
                <input id="password" name="password" type="password" required autocomplete="new-password"
                       placeholder="Minimal 8 karakter"
                       class="auth-input pr-12 @error('password') border-red-500 @enderror">
                <button type="button" onclick="togglePassword('password', 'eyeIcon1')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition-colors">
                    <svg id="eyeIcon1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Konfirmasi Password</label>
            <div class="relative">
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                       placeholder="Ulangi password"
                       class="auth-input pr-12">
                <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition-colors">
                    <svg id="eyeIcon2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <a href="{{ route('login') }}"
               class="flex-1 py-3.5 px-4 text-center text-sm font-semibold text-gray-300 bg-[#1a1f2e] hover:bg-[#222836] rounded-xl border border-gray-700 transition-colors">
                Ganti metode
            </a>
            <button type="submit"
                    class="flex-1 py-3.5 px-4 text-sm font-bold text-white bg-gradient-to-r from-primary to-forest-emerald hover:from-forest-emerald hover:to-primary rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-primary/30 hover:-translate-y-0.5">
                Buat Akun
            </button>
        </div>

        <p class="text-xs text-gray-500 text-center pt-2">
            Dengan mendaftar, Anda menyetujui
            <a href="#" class="text-primary hover:underline">Ketentuan Layanan</a>
            dan
            <a href="#" class="text-primary hover:underline">Kebijakan Privasi</a>
        </p>
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
