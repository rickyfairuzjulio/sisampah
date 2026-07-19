@props(['id' => 'password', 'name' => 'password', 'label' => 'Password', 'autocomplete' => 'current-password', 'placeholder' => ''])

<div>
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <div class="password-wrapper">
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="password"
            autocomplete="{{ $autocomplete }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->except(['id','name','label','autocomplete','placeholder'])->merge(['class' => 'form-input pr-12']) }}
        >
        <button
            type="button"
            class="password-toggle"
            onclick="togglePassword('{{ $id }}', this)"
            aria-label="Show password"
        >
            <!-- Eye icon (shown when password is hidden) -->
            <svg id="{{ $id }}-eye-show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="transition-all duration-200">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <!-- Eye-off icon (shown when password is visible) -->
            <svg id="{{ $id }}-eye-hide" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="hidden transition-all duration-200">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
            </svg>
        </button>
    </div>
    @error($name)
        <p class="mt-1.5 text-xs font-medium text-error flex items-center gap-1">
            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            {{ $message }}
        </p>
    @enderror
</div>
