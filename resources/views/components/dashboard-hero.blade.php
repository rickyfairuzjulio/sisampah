@props([
    'title',
    'subtitle' => null,
    'badge' => null,
])

<div class="mb-6 animate-fade-in">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 sm:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6 shadow-sm">
        <div class="text-white max-w-2xl">
            @if($badge)
                <div class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold text-emerald-400 bg-emerald-500/10 rounded-lg mb-3 border border-emerald-500/20 uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    {{ $badge }}
                </div>
            @endif
            
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight">
                {{ $title }}
            </h2>
            
            @if($subtitle)
                <p class="text-slate-300 text-sm font-medium mt-2 leading-relaxed">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
        
        <div class="flex items-center gap-3 bg-slate-800/80 px-4 py-3 rounded-xl border border-slate-700/60 text-white shrink-0 self-start md:self-center">
            <div class="p-2 bg-slate-700/80 rounded-lg text-emerald-400">
                <i class="bi bi-calendar-event text-base"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Hari Ini</span>
                <span class="text-xs font-bold text-slate-200">{{ now()->translatedFormat('d F Y') }}</span>
            </div>
        </div>
    </div>
</div>
