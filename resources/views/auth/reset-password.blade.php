<x-guest-layout>
    <!-- Modern Header with Gradient -->
    <div class="mb-8 animate-fade-in">
        <div class="bg-gradient-to-br from-primary to-forest-emerald rounded-2xl p-6 mb-6 shadow-lg">
            <div class="flex items-center gap-3 mb-3">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <h1 class="text-3xl font-bold text-white">Reset Password</h1>
            </div>
            <p class="text-white/90 text-sm">Buat password baru yang kuat dan aman untuk akun Anda</p>
        </div>
    </div>

    <!-- Progress Indicator -->
    <div class="flex items-center gap-2 mb-8">
        <div class="flex-1 h-1 bg-primary rounded-full"></div>
        <div class="flex-1 h-1 bg-outline-variant rounded-full"></div>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        @if ($errors->any())
            <x-alert type="error" title="Oops! Ada kesalahan" dismissible class="mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <!-- Email Field (Read-only) -->
        <div class="animate-slide-in" style="animation-delay: 100ms">
            <x-input-field
                label="Alamat Email"
                name="email"
                type="email"
                :value="old('email', $request->email)"
                placeholder="email@example.com"
                required
                autofocus
                autocomplete="username"
                readonly
                :error="$errors->has('email') ? $errors->first('email') : false"
            />
            <p class="mt-2 text-xs text-on-surface-variant flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                Email terdaftar pada akun Anda
            </p>
        </div>

        <!-- New Password Field -->
        <div class="animate-slide-in" style="animation-delay: 150ms">
            <x-password-input
                id="password"
                name="password"
                label="Password Baru"
                autocomplete="new-password"
                placeholder="Minimal 8 karakter"
                :error="$errors->has('password') ? $errors->first('password') : false"
            />
            <p class="mt-2 text-xs text-on-surface-variant flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                Gunakan kombinasi huruf, angka, dan simbol
            </p>
        </div>

        <!-- Confirm Password Field -->
        <div class="animate-slide-in" style="animation-delay: 200ms">
            <x-password-input
                id="password_confirmation"
                name="password_confirmation"
                label="Konfirmasi Password Baru"
                autocomplete="new-password"
                placeholder="Ulangi password baru Anda"
            />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full py-3 px-6 bg-gradient-to-r from-primary to-forest-emerald hover:shadow-lg hover:scale-105 text-white font-bold rounded-xl transition-all duration-300 active:scale-95 mt-6 animate-slide-in" style="animation-delay: 250ms">
            <span class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Reset Password Saya
            </span>
        </button>

        <!-- Info Box -->
        <div class="bg-primary/5 border border-primary/20 rounded-xl p-4">
            <p class="text-sm text-on-surface-variant">
                <svg class="w-4 h-4 inline mr-2 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 9a1 1 0 100-2 1 1 0 000 2zm5 0a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                Pastikan password baru berbeda dengan password sebelumnya untuk keamanan akun Anda.
            </p>
        </div>

        <!-- Back to Login -->
        <div class="text-center pt-4 border-t border-outline-variant">
            <p class="text-sm text-on-surface-variant mb-3">Kembali ke akun Anda?</p>
            <a href="{{ route('login') }}" class="text-primary hover:text-forest-emerald font-semibold transition-colors">
                Masuk ke Dashboard
            </a>
        </div>
    </form>
</x-guest-layout>
