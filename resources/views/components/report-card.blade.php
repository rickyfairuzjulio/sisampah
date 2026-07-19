@props(['severity' => 'green', 'title' => 'Report Title', 'date' => 'Just now'])

@php
    $accentColor = match($severity) {
        'red' => 'bg-error',
        'yellow' => 'bg-tertiary-fixed-dim',
        'green' => 'bg-primary',
        default => 'bg-surface-dim',
    };
@endphp

<div {{ $attributes->merge(['class' => 'relative bg-surface rounded-xl shadow-ambient overflow-hidden flex flex-row items-stretch']) }}>
    <!-- Vertical Accent Bar -->
    <div class="w-2 {{ $accentColor }} flex-shrink-0"></div>
    
    <div class="p-md flex-grow flex flex-col justify-center">
        <div class="flex justify-between items-start">
            <h3 class="text-headline-sm text-on-surface truncate">{{ $title }}</h3>
            <span class="text-body-md text-on-surface-variant whitespace-nowrap ml-2">{{ $date }}</span>
        </div>
        <div class="mt-sm text-body-md text-on-surface-variant line-clamp-2">
            {{ $slot }}
        </div>
    </div>
</div>
