@props([
    'title',
    'subtitle' => null,
    'badge' => null,
])

<div class="mb-8 animate-fade-in">
    <div class="relative overflow-hidden bg-gradient-to-br from-[#0f4d38] via-primary to-forest-emerald rounded-[2rem] shadow-2xl shadow-primary/20 border border-white/10">
        <!-- Abstract Background Effects -->
        <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
        <div class="absolute bottom-0 left-10 w-56 h-56 bg-black/15 rounded-full blur-2xl -mb-20 pointer-events-none"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4IiBoZWlnaHQ9IjgiPgo8cmVjdCB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9IjAuMDUiLz4KPC9zdmc+')] opacity-20 mix-blend-overlay pointer-events-none"></div>
        
        <div class="relative z-10 p-7 sm:p-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            <div class="text-white max-w-2xl">
                @if($badge)
                    <h1 class="inline-flex items-center gap-2.5 px-4 py-1.5 text-[10px] sm:text-xs font-black text-emerald-50 bg-black/25 backdrop-blur-md rounded-full mb-5 border border-white/10 shadow-sm uppercase tracking-[0.2em]">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)] animate-pulse"></span>
                        {{ $badge }}
                    </h1>
                @endif
                
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black mb-3 tracking-tight drop-shadow-xl text-white leading-tight">
                    {{ $title }}
                </h2>
                
                @if($subtitle)
                    <p class="text-emerald-50/90 text-sm sm:text-base font-medium leading-relaxed border-l-4 border-emerald-400/50 pl-4 mt-4">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
            
            <div class="flex items-center gap-4 bg-black/20 hover:bg-black/30 transition-all duration-300 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/10 self-start lg:self-center text-white shadow-xl shadow-black/10 group cursor-default">
                <div class="p-2.5 bg-white/10 rounded-xl group-hover:bg-white/20 transition-colors">
                    <svg class="w-6 h-6 text-emerald-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] text-emerald-200/80 font-bold uppercase tracking-[0.15em] mb-0.5">Hari Ini</span>
                    <span class="text-sm sm:text-base font-bold tracking-wide">{{ now()->translatedFormat('d F Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
