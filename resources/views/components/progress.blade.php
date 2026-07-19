@props([
    'value' => 0, // 0-100
    'color' => 'primary', // primary, success, warning, error
    'showLabel' => true,
    'animated' => true,
])

@php
$colorClasses = match($color) {
    'success' => 'bg-green-500',
    'warning' => 'bg-yellow-500',
    'error' => 'bg-red-500',
    'primary' => 'bg-primary',
    default => 'bg-primary',
};

$animatedClass = $animated ? 'transition-all duration-500 ease-out' : '';
@endphp

<div {{ $attributes->merge(['class' => 'w-full']) }}>
    <div class="w-full bg-surface-container-high rounded-full h-2 overflow-hidden">
        <div class="{{ $colorClasses }} h-full rounded-full {{ $animatedClass }}" style="width: {{ min($value, 100) }}%"></div>
    </div>
    @if($showLabel)
        <p class="text-xs text-on-surface-variant mt-1">{{ $value }}%</p>
    @endif
</div>
