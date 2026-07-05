@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-[12px] border-surface-dim bg-surface text-on-surface shadow-sm focus:border-[2px] focus:border-forest-emerald focus:ring-0 transition-colors duration-200 ease-in-out px-4 py-3']) !!}>
