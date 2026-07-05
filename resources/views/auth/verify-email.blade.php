<x-guest-layout>
    <!-- Modern Header with Gradient -->
    <div class="mb-8 animate-fade-in">
        <div class="bg-gradient-to-br from-primary to-forest-emerald rounded-2xl p-6 mb-6 shadow-lg">
            <div class="flex items-center gap-3 mb-3">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <h1 class="text-3xl font-bold text-white">Verifikasi Email</h1>
            </div>
            <p class="text-white/90 text-sm">Kami telah mengirimkan link verifikasi ke email Anda</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="space-y-6">
        @if (session('status') == 'verification-link-sent')
            <x-alert type="success" title="Berhasil!" dismissible class="animate-slide-in">
                Link verifikasi baru telah dikirim ke alamat email Anda. Silakan cek inbox atau folder spam.
            </x-alert>
        @else
            <x-alert type="info" title="Langkah Berikutnya" dismissible class="animate-slide-in">
                Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik link yang telah kami kirimkan. Jika Anda tidak menerima email, kami dengan senang hati akan mengirimkannya kembali.
            </x-alert>
        @endif

        <!-- Email Verification Card -->
        <div class="bg-white rounded-2xl border-2 border-primary/10 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-on-surface mb-1">Periksa Email Anda</h3>
                    <p class="text-sm text-on-surface-variant mb-4">
                        Link verifikasi telah dikirim. Buka email Anda dan klik link untuk mengaktifkan akun Anda.
                    </p>
                    <ul class="text-sm text-on-surface-variant space-y-2">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Cek folder Inbox
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Periksa folder Spam jika tidak ketemu
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Klik link untuk verifikasi
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <!-- Resend Email Form -->
            <form method="POST" action="{{ route('verification.send') }}" class="animate-slide-in" style="animation-delay: 100ms">
                @csrf
                <button type="submit" class="w-full py-3 px-6 bg-gradient-to-r from-primary to-forest-emerald hover:shadow-lg text-white font-bold rounded-xl transition-all duration-300 hover:scale-105 active:scale-95 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}" class="animate-slide-in" style="animation-delay: 150ms">
                @csrf
                <button type="submit" class="w-full py-3 px-6 bg-surface-container-high hover:bg-surface-container-high/80 text-on-surface font-bold rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar dari Akun
                </button>
            </form>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <p class="text-sm text-blue-800 flex items-start gap-2">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 9a1 1 0 100-2 1 1 0 000 2zm5 0a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                <span>
                    <strong>Perlu bantuan?</strong> Email verifikasi mungkin memerlukan beberapa menit untuk sampai. Pastikan Anda menggunakan alamat email yang benar saat mendaftar.
                </span>
            </p>
        </div>
    </div>
</x-guest-layout>
