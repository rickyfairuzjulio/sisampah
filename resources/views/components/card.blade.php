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

$shadowClasses = $shadow ? 'shadow-sm shadow-black/5 hover:shadow-md transition-shadow duration-300' : '';
$borderClasses = 'border border-slate-200/80 dark:border-white/10';
$hoverClasses = $hover ? 'hover:-translate-y-0.5 hover:border-emerald-500/40 hover:shadow-lg transition-all duration-300 cursor-pointer' : '';

$classes = "rounded-2xl {$paddingClasses} {$shadowClasses} {$borderClasses} {$hoverClasses}";
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
