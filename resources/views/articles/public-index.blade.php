@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

  {{-- Hero Banner --}}
  <div class="mb-10 lg:mb-14 animate-fade-in">
    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#0f4d38] via-primary to-forest-emerald p-8 sm:p-12 lg:p-16 text-white shadow-2xl shadow-primary/20 border border-white/10">
      
      <!-- Abstract Ambient Glowing Effects -->
      <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
      <div class="absolute bottom-0 left-10 w-72 h-72 bg-black/25 rounded-full blur-2xl -mb-20 pointer-events-none"></div>
      <div class="absolute inset-0 opacity-15" style="background-image: url('/images/auth-bg-pattern.svg'); background-size: cover;"></div>

      <div class="relative z-10 max-w-3xl">
        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-black/25 backdrop-blur-md border border-white/15 text-emerald-300 text-xs font-bold uppercase tracking-widest mb-6 shadow-sm">
          <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.9)]"></span>
          Pusat Pengetahuan SiSampah
        </div>

        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight mb-5 leading-tight text-white drop-shadow-md">
          Edukasi Daur Ulang
        </h1>

        <p class="text-emerald-50/90 text-base sm:text-lg font-medium leading-relaxed border-l-4 border-emerald-400/60 pl-4 mb-8">
          Pelajari pengertian, manfaat, dan cara praktis mengelola sampah. Artikel ini membantu nasabah, petugas, dan masyarakat memahami pentingnya bank sampah untuk lingkungan dan ekonomi desa.
        </p>

        <!-- Feature Chips -->
        <div class="flex flex-wrap items-center gap-3">
          <div class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold text-white shadow-sm hover:bg-white/15 transition-colors cursor-default">
            <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            Pemilahan Sampah
          </div>
          <div class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold text-white shadow-sm hover:bg-white/15 transition-colors cursor-default">
            <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Ekonomi Sirkular
          </div>
          <div class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold text-white shadow-sm hover:bg-white/15 transition-colors cursor-default">
            <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Panduan Praktis
          </div>
        </div>
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
