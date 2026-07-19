@props([
    'status' => 'pending', // pending, completed, rejected, active
    'label',
])

@php
$statusClasses = match($status) {
    'pending' => 'bg-yellow-100 text-yellow-800',
    'completed' => 'bg-green-100 text-green-800',
    'rejected' => 'bg-red-100 text-red-800',
    'active' => 'bg-blue-100 text-blue-800',
    'draft' => 'bg-gray-100 text-gray-800',
    default => 'bg-gray-100 text-gray-800',
};

$icon = match($status) {
    'pending' => '⏳',
    'completed' => '✓',
    'rejected' => '✕',
    'active' => '●',
    'draft' => '◯',
    default => '●',
};
@endphp

<span {{ $attributes->merge(['class' => "{$statusClasses} inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold"]) }}>
    <span>{{ $icon }}</span>
    <span>{{ $label }}</span>
</span>
