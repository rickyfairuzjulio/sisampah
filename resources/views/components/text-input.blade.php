@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-xl border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:border-[2px] focus:ring-0 focus:outline-none transition-colors duration-200 py-3 px-4 w-full']) }}>
