<section class="space-y-5">

    <button
        class="btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        Hapus Akun
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-start gap-4 mb-6">
                <div class="w-12 h-12 bg-error-container rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-on-error-container" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-headline-sm text-on-surface">Hapus Akun Secara Permanen?</h2>
                    <p class="mt-1 text-sm text-on-surface-variant">
                        Tindakan ini tidak dapat dibatalkan. Semua data, saldo, dan poin kamu akan hilang selamanya.
                    </p>
                </div>
            </div>

            <div class="space-y-4">
                <x-password-input
                    id="modal_password"
                    name="password"
                    label="Konfirmasi dengan Password Kamu"
                    autocomplete="current-password"
                    placeholder="Masukkan password untuk konfirmasi"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />

                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-2">
                    <button type="button" class="btn-secondary" x-on:click="$dispatch('close')">
                        Batal
                    </button>
                    <button type="submit" class="btn-danger">
                        Ya, Hapus Akun Saya
                    </button>
                </div>
            </div>
        </form>
    </x-modal>
</section>
