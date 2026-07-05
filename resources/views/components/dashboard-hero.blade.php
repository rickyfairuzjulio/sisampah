@props([
    'title',
    'subtitle' => null,
    'gradient' => 'from-primary to-forest-emerald',
    'badge' => null,
])

<div class="mb-8 animate-fade-in">
    <div class="dashboard-hero bg-gradient-to-r {{ $gradient }}">
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                @if($badge)
                    <span class="inline-block px-3 py-1 text-xs font-semibold bg-white/20 backdrop-blur-sm rounded-full mb-3 border border-white/30">
                        {{ $badge }}
                    </span>
                @endif
                <h1 class="text-3xl sm:text-4xl font-bold mb-2">{{ $title }}</h1>
                @if($subtitle)
                    <p class="text-white/90 text-sm sm:text-base">{{ $subtitle }}</p>
                @endif
            </div>
            <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/30 self-start">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-semibold">{{ now()->translatedFormat('d F Y') }}</span>
            </div>
        </div>
    </div>
</div>
