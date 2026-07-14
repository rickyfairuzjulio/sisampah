@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

  <a href="{{ route('edukasi.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:text-primary-container mb-6 transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    Kembali ke Pusat Edukasi
  </a>

  <article class="bg-surface-container-lowest rounded-2xl lg:rounded-3xl border border-outline-variant overflow-hidden shadow-ambient animate-fade-in">
    @if($article->image_url)
      <div class="relative h-56 sm:h-72 lg:h-96">
        <img src="{{ $article->image_url }}" alt="{{ $article->judul }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8">
          <span class="inline-block px-3 py-1 text-xs font-bold bg-white/90 text-primary rounded-full mb-3">{{ $article->kategori }}</span>
          <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white leading-tight">{{ $article->judul }}</h1>
        </div>
      </div>
    @else
      <div class="p-6 sm:p-8 border-b border-outline-variant">
        <span class="inline-block px-3 py-1 text-xs font-bold bg-primary/10 text-primary rounded-full mb-3">{{ $article->kategori }}</span>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-on-surface">{{ $article->judul }}</h1>
      </div>
    @endif

    <div class="px-6 sm:px-8 lg:px-10 py-6 border-b border-outline-variant flex flex-wrap items-center gap-4 text-sm text-on-surface-variant">
      <span class="flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        {{ $article->creator->name ?? 'Tim SiSampah' }}
      </span>
      <span>{{ $article->created_at->translatedFormat('d F Y') }}</span>
    </div>

    <div class="px-6 sm:px-8 lg:px-10 py-8 lg:py-10">
      <div class="mb-8 p-5 sm:p-6 rounded-2xl bg-primary/5 border border-primary/15">
        <h2 class="text-sm font-bold text-primary uppercase tracking-wider mb-2">Pengertian Singkat</h2>
        <p class="text-on-surface leading-relaxed">{{ $article->excerpt }}</p>
      </div>

      <div class="prose prose-sm sm:prose-base max-w-none text-on-surface">
        <h2 class="text-xl font-bold text-on-surface mb-4">Penjelasan Lengkap</h2>
        @foreach(preg_split('/\n\s*\n/', trim($article->konten)) as $paragraph)
          @if(trim($paragraph))
            <p class="text-on-surface-variant leading-relaxed mb-4">{{ trim($paragraph) }}</p>
          @endif
        @endforeach
      </div>
    </div>
  </article>

  @if($relatedArticles->count())
    <div class="mt-12 lg:mt-16">
      <h3 class="text-xl font-bold text-on-surface mb-6">Artikel Terkait</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($relatedArticles as $related)
          <x-article-card :article="$related" />
        @endforeach
      </div>
    </div>
  @endif
</div>
@endsection
