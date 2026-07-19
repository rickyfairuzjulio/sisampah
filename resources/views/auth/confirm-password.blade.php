<x-guest-layout>
    <div class="mb-8">
        <div class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <h2 class="text-2xl font-bold text-on-surface mb-1">Konfirmasi Password</h2>
        <p class="text-sm text-on-surface-variant">Area aman. Mohon konfirmasi password sebelum melanjutkan.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <x-password-input
            id="password"
            name="password"
            label="Password"
            autocomplete="current-password"
            placeholder="Masukkan password kamu"
            class="@error('password') border-error border-2 @enderror"
        />

        <button type="submit" class="btn-primary btn-full py-3 text-base">
            Konfirmasi
        </button>
    </form>
</x-guest-layout>
