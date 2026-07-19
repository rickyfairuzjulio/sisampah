@props(['title', 'value', 'trend' => null, 'trendUp' => true])

<div class="bg-surface rounded-xl p-6 shadow-ambient flex flex-col justify-between h-full border border-surface-container-high">
    <div class="flex items-start gap-4">
        <!-- Icon slot -->
        <div class="w-12 h-12 bg-primary-container/10 text-primary rounded-xl flex items-center justify-center shrink-0">
            {{ $slot }}
        </div>
        
        <div>
            <h3 class="text-sm font-semibold text-on-surface-variant mb-1">{{ $title }}</h3>
            <div class="flex items-baseline gap-1">
                <span class="text-3xl font-bold text-on-surface tracking-tight">{{ $value }}</span>
                @if(isset($unit))
                    <span class="text-sm font-semibold text-on-surface-variant">{{ $unit }}</span>
                @endif
            </div>
        </div>
    </div>
    
    @if($trend)
        <div class="mt-4 flex items-center gap-1.5">
            @if($trendUp)
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                <span class="text-xs font-bold text-primary">{{ $trend }}</span>
            @else
                <svg class="w-4 h-4 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                <span class="text-xs font-bold text-error">{{ $trend }}</span>
            @endif
        </div>
    @endif
</div>
