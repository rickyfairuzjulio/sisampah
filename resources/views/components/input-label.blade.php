@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-xs tracking-wider text-on-surface mb-1']) }}>
    {{ $value ?? $slot }}
</label>
