@props(['title', 'subtitle' => null, 'actionText' => null, 'actionUrl' => '#'])

<div {{ $attributes->merge(['class' => 'bg-surface rounded-xl shadow-ambient border border-surface-container-high overflow-hidden flex flex-col h-full']) }}>
    <div class="p-5 border-b border-surface-container flex justify-between items-center bg-white/50">
        <div>
            <h3 class="text-lg font-bold text-on-surface">{{ $title }}</h3>
            @if($subtitle)
                <p class="text-xs font-medium text-on-surface-variant mt-0.5">{{ $subtitle }}</p>
            @endif
        </div>
        @if($actionText)
            <a href="{{ $actionUrl }}" class="text-xs font-bold text-primary hover:text-primary-container transition">
                {{ $actionText }}
            </a>
        @endif
    </div>
    <div class="p-5 flex-1 flex flex-col bg-surface">
        {{ $slot }}
    </div>
</div>
