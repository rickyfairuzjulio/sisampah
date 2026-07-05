@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

  <x-role-nav role="nasabah" />

  <div class="mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-on-surface">Pusat Edukasi</h1>
    <p class="text-on-surface-variant mt-1">Pelajari cara mengelola sampah dan berkontribusi pada lingkungan desa</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
    @forelse($articles as $article)
      <x-article-card :article="$article" />
    @empty
      <div class="col-span-full text-center py-16 rounded-2xl border border-dashed border-outline-variant">
        <p class="text-on-surface-variant">Belum ada artikel yang dipublikasikan.</p>
      </div>
    @endforelse
  </div>

  @if($articles->hasPages())
    <div class="mt-10">{{ $articles->links() }}</div>
  @endif
</div>
@endsection
