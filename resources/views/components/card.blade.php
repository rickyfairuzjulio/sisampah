@props([
    'hover' => false,
    'padding' => 'md', // sm, md, lg
    'border' => false,
    'shadow' => true,
])

@php
$paddingClasses = match($padding) {
    'sm' => 'p-3',
    'md' => 'p-4 md:p-6',
    'lg' => 'p-6 md:p-8',
    default => 'p-4 md:p-6',
};

$shadowClasses = $shadow ? 'shadow-ambient' : '';
$borderClasses = $border ? 'border border-outline-variant' : '';
$hoverClasses = $hover ? 'hover:shadow-lg transition-shadow duration-200 cursor-pointer' : '';

$classes = "bg-surface-container-lowest rounded-xl {$paddingClasses} {$shadowClasses} {$borderClasses} {$hoverClasses}";
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
