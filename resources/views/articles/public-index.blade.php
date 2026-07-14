@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

  {{-- Hero --}}
  <div class="mb-10 lg:mb-14 animate-fade-in">
    <div class="relative overflow-hidden rounded-2xl lg:rounded-3xl bg-gradient-to-br from-primary to-forest-emerald p-8 sm:p-12 lg:p-16 text-white">
      <div class="absolute inset-0 opacity-10" style="background-image: url('/images/auth-bg-pattern.svg'); background-size: cover;"></div>
      <div class="relative z-10 max-w-3xl">
        <p class="text-white/70 text-sm font-semibold uppercase tracking-widest mb-3">Pusat Pengetahuan</p>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4">Edukasi Daur Ulang</h1>
        <p class="text-white/80 text-base sm:text-lg leading-relaxed">
          Pelajari pengertian, manfaat, dan cara praktis mengelola sampah. Artikel ini membantu nasabah, petugas, dan masyarakat memahami pentingnya bank sampah untuk lingkungan dan ekonomi desa.
        </p>
      </div>
    </div>
  </div>

  {{-- Pengertian singkat --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-12 lg:mb-16 animate-slide-in">
    @foreach([
      ['Apa itu Bank Sampah?', 'Sistem pengumpulan sampah terpilah dari masyarakat yang ditimbang, dicatat, dan ditukar dengan nilai ekonomi atau saldo digital.', 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'],
      ['Mengapa Daur Ulang?', 'Mengurangi sampah ke TPA, menghemat sumber daya alam, mencegah polusi, dan menciptakan lapangan kerja hijau di tingkat RT/RW.', 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
      ['Peran SiSampah', 'Platform digital yang menghubungkan nasabah, petugas, dan admin agar proses setor, jemput, dan pencairan dana berjalan transparan.', 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
    ] as [$title, $desc, $icon])
      <div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant hover:border-primary/20 transition-colors">
        <div class="w-11 h-11 bg-primary/10 rounded-xl flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
        </div>
        <h3 class="font-bold text-on-surface mb-2">{{ $title }}</h3>
        <p class="text-sm text-on-surface-variant leading-relaxed">{{ $desc }}</p>
      </div>
    @endforeach
  </div>

  {{-- Artikel --}}
  <div class="mb-8">
    <h2 class="text-2xl font-bold text-on-surface mb-2">Artikel & Panduan</h2>
    <p class="text-on-surface-variant text-sm">Baca penjelasan lengkap beserta ilustrasi untuk setiap topik edukasi.</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 animate-slide-in items-stretch">
    @forelse($articles as $article)
      <x-article-card :article="$article" />
    @empty
      <div class="col-span-full text-center py-16 rounded-2xl border border-dashed border-outline-variant">
        <p class="text-on-surface-variant">Belum ada artikel edukasi yang dipublikasikan.</p>
      </div>
    @endforelse
  </div>

  <div class="mt-10">{{ $articles->links() }}</div>
</div>
@endsection
