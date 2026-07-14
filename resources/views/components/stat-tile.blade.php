@props([
    'badge' => null, // Menampilkan label kecil
    'title',
    'subtitle' => null,
    'icon' => null,
    'trend' => null, // 'up', 'down', null
    'trendValue' => null,
])

@php
$trendColor = $trend === 'up' ? 'text-green-600' : ($trend === 'down' ? 'text-red-600' : '');
@endphp

<x-card class="!p-4" hover="true">
    <div class="space-y-3">
        <div class="flex items-start justify-between">
            <div class="space-y-1 flex-1">
                @if($badge)
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-primary bg-primary/10 rounded-full">
                        {{ $badge }}
                    </span>
                @endif
                <h3 class="text-sm font-medium text-on-surface-variant">{{ $subtitle ?? 'Statistik' }}</h3>
                <p class="text-2xl font-bold text-on-surface">{{ $title }}</p>
            </div>
            @if($icon)
                <div class="text-primary bg-primary/10 p-3 rounded-lg flex-shrink-0">
                    {!! $icon !!}
                </div>
            @endif
        </div>

        @if($trend && $trendValue)
            <div class="flex items-center gap-2 text-xs font-semibold {{ $trendColor }}">
                @if($trend === 'up')
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414-1.414L13.586 7H12z" clip-rule="evenodd" />
                    </svg>
                @else
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12 13a1 1 0 110 2H7a1 1 0 01-1-1V9a1 1 0 112 0v3.586l4.293-4.293a1 1 0 011.414 1.414L9.414 13H12z" clip-rule="evenodd" />
                    </svg>
                @endif
                <span>{{ $trendValue }}</span>
            </div>
        @endif
    </div>
</x-card>
