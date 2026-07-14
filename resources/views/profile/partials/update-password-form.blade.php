<section class="space-y-6">

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <x-password-input
            id="update_password_current_password"
            name="current_password"
            label="Password Saat Ini"
            autocomplete="current-password"
            placeholder="Password kamu saat ini"
        />
        @if($errors->updatePassword->get('current_password'))
            <p class="mt-1.5 text-xs font-medium text-error">{{ $errors->updatePassword->get('current_password')[0] }}</p>
        @endif

        <x-password-input
            id="update_password_password"
            name="password"
            label="Password Baru"
            autocomplete="new-password"
            placeholder="Min. 8 karakter"
        />
        @if($errors->updatePassword->get('password'))
            <p class="mt-1.5 text-xs font-medium text-error">{{ $errors->updatePassword->get('password')[0] }}</p>
        @endif

        <x-password-input
            id="update_password_password_confirmation"
            name="password_confirmation"
            label="Konfirmasi Password Baru"
            autocomplete="new-password"
            placeholder="Ulangi password baru"
        />
        @if($errors->updatePassword->get('password_confirmation'))
            <p class="mt-1.5 text-xs font-medium text-error">{{ $errors->updatePassword->get('password_confirmation')[0] }}</p>
        @endif

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="btn-primary">Simpan Password</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm font-semibold text-primary flex items-center gap-1">
                   <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                   Tersimpan!
                </p>
            @endif
        </div>
    </form>
</section>
