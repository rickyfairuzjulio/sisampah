<section class="space-y-5">

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl text-emerald-400 text-xs font-semibold flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-base"></i>
            {{ session('success') }}
        </div>
    @endif

    <form method="post" action="{{ route('profile.update') }}" class="space-y-4" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Foto Profil Upload --}}
        <div class="flex items-center gap-4 mb-6 p-4 rounded-2xl bg-surface-container-low border border-outline-variant">
            <div class="shrink-0 relative group">
                <img id="avatar-preview" class="w-16 h-16 rounded-2xl object-cover border-2 border-primary shadow-sm" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                <label for="avatar" class="absolute inset-0 flex items-center justify-center bg-black/60 text-white rounded-2xl opacity-0 group-hover:opacity-100 cursor-pointer transition-all">
                    <i class="bi bi-camera-fill text-lg"></i>
                </label>
            </div>
            <div class="flex-1">
                <label class="block text-xs font-bold text-on-surface uppercase tracking-wider mb-1" for="avatar">Foto Profil</label>
                <input class="block w-full text-xs text-on-surface-variant file:mr-4 file:py-1.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary/20 file:text-primary hover:file:bg-primary/30 transition-colors" type="file" name="avatar" id="avatar" accept="image/*" onchange="document.getElementById('avatar-preview').src = window.URL.createObjectURL(this.files[0])">
                <x-input-error class="mt-1 text-xs" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block text-xs font-bold text-on-surface uppercase tracking-wider mb-1">Nama Lengkap *</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                       required autocomplete="name" class="w-full px-4 py-2.5 bg-surface border border-outline-variant rounded-xl text-xs font-semibold focus:ring-2 focus:ring-primary">
                <x-input-error class="mt-1 text-xs" :messages="$errors->get('name')" />
            </div>

            <div>
                <label for="email" class="block text-xs font-bold text-on-surface uppercase tracking-wider mb-1">Email *</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                       required autocomplete="username" class="w-full px-4 py-2.5 bg-surface border border-outline-variant rounded-xl text-xs font-semibold focus:ring-2 focus:ring-primary">
                <x-input-error class="mt-1 text-xs" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="alert alert-warning mt-2 text-xs">
                        <div>
                            Email belum diverifikasi.
                            <button form="send-verification" class="font-bold underline ml-1">Kirim ulang link verifikasi</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="nomor_telepon" class="block text-xs font-bold text-on-surface uppercase tracking-wider mb-1">Nomor Telepon / WA</label>
                <input id="nomor_telepon" name="nomor_telepon" type="text" value="{{ old('nomor_telepon', $user->nomor_telepon) }}"
                       placeholder="0812..." class="w-full px-4 py-2.5 bg-surface border border-outline-variant rounded-xl text-xs font-semibold focus:ring-2 focus:ring-primary">
                <x-input-error class="mt-1 text-xs" :messages="$errors->get('nomor_telepon')" />
            </div>

            <div>
                <label for="rt" class="block text-xs font-bold text-on-surface uppercase tracking-wider mb-1">Rukun Tetangga (RT)</label>
                <input id="rt" name="rt" type="text" value="{{ old('rt', $user->rt) }}"
                       placeholder="01" class="w-full px-4 py-2.5 bg-surface border border-outline-variant rounded-xl text-xs font-semibold focus:ring-2 focus:ring-primary">
                <x-input-error class="mt-1 text-xs" :messages="$errors->get('rt')" />
            </div>

            <div>
                <label for="rw" class="block text-xs font-bold text-on-surface uppercase tracking-wider mb-1">Rukun Warga (RW)</label>
                <input id="rw" name="rw" type="text" value="{{ old('rw', $user->rw) }}"
                       placeholder="02" class="w-full px-4 py-2.5 bg-surface border border-outline-variant rounded-xl text-xs font-semibold focus:ring-2 focus:ring-primary">
                <x-input-error class="mt-1 text-xs" :messages="$errors->get('rw')" />
            </div>
        </div>

        <div>
            <label for="alamat_lengkap" class="block text-xs font-bold text-on-surface uppercase tracking-wider mb-1">Alamat Lengkap</label>
            <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" placeholder="Jl. Raya No. 123..." class="w-full px-4 py-2.5 bg-surface border border-outline-variant rounded-xl text-xs font-semibold focus:ring-2 focus:ring-primary">{{ old('alamat_lengkap', $user->alamat_lengkap) }}</textarea>
            <x-input-error class="mt-1 text-xs" :messages="$errors->get('alamat_lengkap')" />
        </div>

        {{-- Main Save Button --}}
        <div class="flex items-center justify-between pt-4 border-t border-outline-variant">
            <button type="submit" class="px-6 py-3 bg-primary hover:bg-forest-emerald text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all text-xs flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Perubahan Profil
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                   class="text-xs font-bold text-emerald-500 flex items-center gap-1">
                   <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                   Perubahan Berhasil Disimpan!
                </p>
            @endif
        </div>
    </form>
</section>
