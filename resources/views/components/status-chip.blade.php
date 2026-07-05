@props(['status' => 'info'])

@php
    $statusClasses = match($status) {
        'hazardous' => 'bg-error-container text-on-error-container',
        'warning' => 'bg-tertiary-fixed text-on-tertiary-fixed-variant',
        'success' => 'bg-primary-container text-on-primary-container',
        'info' => 'bg-secondary-container text-on-secondary-container',
        default => 'bg-surface-variant text-on-surface-variant',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-3 py-1 rounded-full text-label-md font-semibold $statusClasses"]) }}>
    {{ $slot }}
</span>
