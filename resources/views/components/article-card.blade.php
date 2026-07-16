@props(['article'])

<article class="group bg-surface-container-lowest rounded-3xl border border-outline-variant overflow-hidden hover:shadow-xl hover:border-primary/40 hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full w-full">
    <div class="relative h-48 sm:h-52 overflow-hidden">
        @if($article->image_url)
            <img src="{{ $article->image_url }}" alt="{{ $article->judul }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
                 loading="lazy">
        @else
            <div class="w-full h-full bg-gradient-to-br from-primary to-forest-emerald flex items-center justify-center">
                <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        @endif
        <div class="absolute top-3 left-3">
            <span class="inline-block px-3 py-1 text-xs font-bold bg-white/90 text-primary rounded-full shadow-sm">{{ $article->kategori }}</span>
        </div>
    </div>

    <div class="p-5 sm:p-6 flex flex-col flex-1">
        <h3 class="text-lg font-bold text-on-surface mb-2 group-hover:text-primary transition-colors line-clamp-2 min-h-[56px]">{{ $article->judul }}</h3>
        <p class="text-sm text-on-surface-variant leading-relaxed flex-1 line-clamp-3 min-h-[60px]">{{ $article->excerpt }}</p>
        <div class="flex items-center justify-between mt-5 pt-4 border-t border-outline-variant">
            <span class="text-xs text-on-surface-variant">{{ $article->created_at->translatedFormat('d M Y') }}</span>
            <a href="{{ route('edukasi.show', $article->slug) }}" class="inline-flex items-center gap-1 text-sm font-bold text-primary hover:gap-2 transition-all">
                Baca
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</article>
