@props(['status', 'percent'])

@php
    $bgClass = match($status) {
        'naik' => 'bg-green-100 text-green-800 border-green-200',
        'turun' => 'bg-red-100 text-red-800 border-red-200',
        default => 'bg-gray-100 text-gray-800 border-gray-200'
    };
    
    $icon = match($status) {
        'naik' => '↑',
        'turun' => '↓',
        default => '→'
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold border $bgClass"]) }}>
    <span>{{ $icon }}</span>
    <span>{{ abs($percent) }}%</span>
</span>
