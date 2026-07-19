@props([
    'title',
    'description' => '',
    'action' => null,
    'icon' => null,
    'items' => [],
])

<div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-black/50 p-4 {{ $attributes->get('hidden') ? 'hidden' : '' }}" @click.self="hidden = !hidden">
    <div class="w-full sm:max-w-md bg-surface-container-lowest rounded-2xl shadow-2xl transform transition-all">
        <!-- Header -->
        <div class="border-b border-outline-variant px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3 flex-1">
                @if($icon)
                    <div class="text-primary">{{ $icon }}</div>
                @endif
                <div class="flex-1">
                    <h2 class="text-lg font-bold text-on-surface">{{ $title }}</h2>
                    @if($description)
                        <p class="text-sm text-on-surface-variant mt-0.5">{{ $description }}</p>
                    @endif
                </div>
            </div>
            <button @click="hidden = true" class="text-on-surface-variant hover:text-on-surface transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="px-6 py-4">
            {{ $slot }}
        </div>

        <!-- Footer (Action) -->
        @if($action)
            <div class="border-t border-outline-variant px-6 py-4 flex gap-2 justify-end">
                {{ $action }}
            </div>
        @endif
    </div>
</div>
