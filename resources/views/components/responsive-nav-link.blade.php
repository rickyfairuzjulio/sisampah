@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-4 pe-4 py-3 border-l-4 border-primary text-start text-base font-bold text-primary bg-primary/10 focus:outline-none focus:text-primary-container focus:bg-primary/20 focus:border-primary-container transition duration-150 ease-in-out'
            : 'block w-full ps-4 pe-4 py-3 border-l-4 border-transparent text-start text-base font-semibold text-on-surface-variant hover:text-on-surface hover:bg-surface-container hover:border-outline-variant focus:outline-none focus:text-on-surface focus:bg-surface-container focus:border-outline-variant transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
