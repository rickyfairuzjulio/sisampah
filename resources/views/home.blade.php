@extends('layouts.landing')

@php
    $dash = 'nasabah.dashboard';
    if (auth()->check()) {
        $dash = auth()->user()->hasRole('admin') ? 'admin.dashboard'
            : (auth()->user()->hasRole('petugas') ? 'petugas.dashboard' : 'nasabah.dashboard');
    }
@endphp

@section('content')

{{-- ═══════════════ HERO ═══════════════ --}}
<section class="relative min-h-[100dvh] flex items-center overflow-hidden">
    <div class="landing-blob w-[500px] h-[500px] bg-primary/30 -top-32 -left-32"></div>
    <div class="landing-blob w-[400px] h-[400px] bg-forest-emerald/20 top-1/2 right-0 animation-delay-2000" style="animation-delay: 2s"></div>
    <div class="landing-blob w-[300px] h-[300px] bg-amber-500/10 bottom-0 left-1/3" style="animation-delay: 4s"></div>

    <div class="absolute inset-0 opacity-[0.04]" style="background-image: url('/images/auth-bg-pattern.svg'); background-size: cover;"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-16 lg:pt-32 lg:pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            <div class="text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-xs sm:text-sm font-medium text-white/90 mb-6 lg:mb-8">
                    <span class="w-2 h-2 bg-forest-emerald rounded-full animate-pulse"></span>
                    Bank Sampah Digital #1 untuk Desa
                </div>

                <h1 class="landing-hero-title font-black mb-6">
                    Sampah Jadi
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-forest-emerald to-emerald-300"> Berkah</span>
                </h1>

                <p class="text-base sm:text-lg text-white/60 leading-relaxed max-w-xl mx-auto lg:mx-0 mb-8 lg:mb-10">
                    Setor sampah, dapatkan saldo, dan bantu desa lebih bersih. SiSampah menghubungkan nasabah, petugas, dan admin dalam satu ekosistem digital.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center lg:justify-start">
                    @auth
                        <a href="{{ route($dash) }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-primary hover:bg-primary-container text-white font-bold rounded-2xl transition-all hover:shadow-lg hover:shadow-primary/25 min-h-[52px]">
                            Buka Dashboard
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-[#051410] font-bold rounded-2xl hover:bg-white/90 transition-all min-h-[52px]">
                            Mulai Gratis
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 border border-white/20 text-white font-semibold rounded-2xl hover:bg-white/10 transition-all min-h-[52px]">
                            Masuk
                        </a>
                    @endauth
                </div>

                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-6 mt-10 text-sm text-white/50">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-forest-emerald" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Gratis untuk nasabah
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-forest-emerald" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Jemput via GPS
                    </span>
                </div>
            </div>

            {{-- Hero Card Mockup --}}
            <div class="relative flex justify-center lg:justify-end">
                <div class="relative w-full max-w-sm lg:max-w-md">
                    <div class="absolute -inset-4 bg-gradient-to-br from-primary/40 to-forest-emerald/20 rounded-3xl blur-2xl"></div>
                    <div class="relative landing-card !bg-[#0a1f17]/80 !p-6 sm:!p-8 shadow-2xl">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <p class="text-xs text-white/50 uppercase tracking-wider">Saldo Nasabah</p>
                                <p class="text-2xl sm:text-3xl font-bold mt-1">Rp 245.000</p>
                            </div>
                            <div class="w-12 h-12 bg-primary/20 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-forest-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                        <div class="space-y-3">
                            @foreach([['Plastik', '12.5 Kg', '+Rp 18.750', 'bg-blue-500/20 text-blue-300'], ['Kertas', '8.0 Kg', '+Rp 12.000', 'bg-amber-500/20 text-amber-300'], ['Organik', '5.5 Kg', '+Rp 8.250', 'bg-green-500/20 text-green-300']] as [$jenis, $berat, $nominal, $color])
                                <div class="flex items-center justify-between p-3 rounded-xl bg-white/5 border border-white/5">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-lg {{ $color }} flex items-center justify-center text-xs font-bold">{{ substr($jenis, 0, 1) }}</span>
                                        <div>
                                            <p class="text-sm font-semibold">{{ $jenis }}</p>
                                            <p class="text-xs text-white/40">{{ $berat }}</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-forest-emerald">{{ $nominal }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between">
                            <span class="text-xs text-white/40">+120 poin lingkungan</span>
                            <span class="text-xs font-semibold text-forest-emerald">Naik peringkat #3</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ MARQUEE ═══════════════ --}}
<section class="py-4 border-y border-white/10 bg-[#0a1f17]/50 overflow-hidden">
    <div class="landing-marquee">
        @foreach(array_merge(['Plastik', 'Kertas', 'Kardus', 'Logam', 'Kaca', 'Organik', 'E-Waste', 'Botol PET'], ['Plastik', 'Kertas', 'Kardus', 'Logam', 'Kaca', 'Organik', 'E-Waste', 'Botol PET']) as $kategori)
            <span class="flex items-center gap-3 px-6 text-sm font-semibold text-white/40 whitespace-nowrap">
                <span class="w-1.5 h-1.5 rounded-full bg-forest-emerald"></span>
                {{ $kategori }}
            </span>
        @endforeach
    </div>
</section>

{{-- ═══════════════ FITUR BENTO ═══════════════ --}}
<section id="fitur" class="py-16 sm:py-20 lg:py-28" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
         class="transition-all duration-1000 ease-out opacity-0 translate-y-8">
        <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
            <p class="text-forest-emerald text-sm font-semibold uppercase tracking-widest mb-3">Fitur Lengkap</p>
            <h2 class="landing-section-title font-bold mb-4">Satu Platform, Tiga Peran</h2>
            <p class="text-white/50 text-base sm:text-lg">Dirancang khusus untuk ekosistem bank sampah desa — dari setoran hingga laporan admin.</p>
        </div>

        <div class="landing-bento">
            <div class="landing-card landing-bento-item-lg group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-forest-emerald/10 rounded-full blur-3xl group-hover:bg-forest-emerald/20 transition-colors"></div>
                <span class="inline-block px-3 py-1 text-xs font-bold bg-forest-emerald/20 text-forest-emerald rounded-full mb-4">Nasabah</span>
                <h3 class="text-xl lg:text-2xl font-bold mb-3">Setor, Pantau, Tarik</h3>
                <p class="text-white/50 text-sm leading-relaxed mb-6">Dashboard saldo real-time, jadwal jemput dengan GPS, riwayat transaksi, penarikan tunai/transfer, dan papan peringkat komunitas.</p>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-white/60">
                    <li class="flex items-center gap-2"><span class="text-forest-emerald">✓</span> Penjemputan GPS</li>
                    <li class="flex items-center gap-2"><span class="text-forest-emerald">✓</span> Dompet digital</li>
                    <li class="flex items-center gap-2"><span class="text-forest-emerald">✓</span> Sistem poin</li>
                    <li class="flex items-center gap-2"><span class="text-forest-emerald">✓</span> Edukasi daur ulang</li>
                </ul>
            </div>

            <div class="landing-card landing-bento-item-md">
                <span class="inline-block px-3 py-1 text-xs font-bold bg-blue-500/20 text-blue-300 rounded-full mb-4">Petugas</span>
                <h3 class="text-lg lg:text-xl font-bold mb-2">Manifes & Timbangan</h3>
                <p class="text-white/50 text-sm leading-relaxed">Kelola jemputan pending, input timbangan dengan snapshot harga, setor mandiri, dan foto bukti transaksi.</p>
            </div>

            <div class="landing-card landing-bento-item-sm">
                <span class="inline-block px-3 py-1 text-xs font-bold bg-amber-500/20 text-amber-300 rounded-full mb-4">Admin</span>
                <h3 class="text-lg font-bold mb-2">Kontrol Penuh</h3>
                <p class="text-white/50 text-sm">Harga sampah, validasi penarikan, laporan RT/RW, ekspor CSV.</p>
            </div>

            <div class="landing-card landing-bento-item-wide flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="w-14 h-14 bg-primary/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-1">Laporan & Visualisasi RT</h3>
                    <p class="text-white/50 text-sm">Bandingkan kontribusi sampah antar RT, filter tanggal, dan ekspor data ke CSV.</p>
                </div>
            </div>

            <div class="landing-card landing-bento-item-narrow !bg-gradient-to-br from-primary/20 to-forest-emerald/10 !border-primary/30 flex flex-col justify-center items-center text-center">
                <p class="landing-stat-value font-black text-forest-emerald">{{ number_format($stats['sampah_kg'], 0) }}+</p>
                <p class="text-sm text-white/50 mt-2">Kg Sampah Terkelola</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ CARA KERJA ═══════════════ --}}
<section id="cara-kerja" class="py-16 sm:py-20 lg:py-28 bg-[#0a1f17]/50" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
         class="transition-all duration-1000 ease-out opacity-0 translate-y-8">
        <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
            <p class="text-forest-emerald text-sm font-semibold uppercase tracking-widest mb-3">Mudah & Cepat</p>
            <h2 class="landing-section-title font-bold mb-4">Cara Kerja SiSampah</h2>
            <p class="text-white/50">Empat langkah sederhana menuju desa bersih dan warga sejahtera.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-4">
            @foreach([
                ['01', 'Kumpulkan', 'Pisahkan sampah sesuai kategori yang ditetapkan bank sampah.'],
                ['02', 'Jadwalkan', 'Pesan jemput via aplikasi dengan deteksi GPS otomatis.'],
                ['03', 'Timbang', 'Petugas timbang, foto bukti, saldo & poin langsung masuk.'],
                ['04', 'Tarik', 'Ajukan penarikan dana tunai atau transfer kapan saja.'],
            ] as $index => [$step, $title, $desc])
                <div class="relative text-center lg:text-left">
                    @if($index < 3)
                        <div class="landing-step-line"></div>
                    @endif
                    <div class="inline-flex w-16 h-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary to-forest-emerald text-xl font-black mb-5 mx-auto lg:mx-0">
                        {{ $step }}
                    </div>
                    <h3 class="text-lg font-bold mb-2">{{ $title }}</h3>
                    <p class="text-sm text-white/50 leading-relaxed">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════ DAMPAK / STATS ═══════════════ --}}
<section id="dampak" class="py-16 sm:py-20 lg:py-28" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
         class="transition-all duration-1000 ease-out opacity-0 translate-y-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach([
                [$stats['nasabah'], 'Nasabah Aktif', 'Masyarakat peduli lingkungan'],
                [$stats['petugas'], 'Petugas Lapangan', 'Kader pengelola sampah'],
                [number_format($stats['sampah_kg'], 0), 'Kg Terkelola', 'Sampah berhasil didaur ulang'],
                [$stats['transaksi'], 'Transaksi', 'Setoran tercatat digital'],
            ] as [$value, $label, $sub])
                <div class="landing-card text-center !p-5 sm:!p-8">
                    <p class="landing-stat-value font-black text-white mb-2">{{ $value }}</p>
                    <p class="font-semibold text-sm sm:text-base mb-1">{{ $label }}</p>
                    <p class="text-xs text-white/40 hidden sm:block">{{ $sub }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════ KALKULATOR ESTIMASI ═══════════════ --}}
<section id="kalkulator" class="py-16 sm:py-20 lg:py-28" x-data="kalkulatorSampah()" x-intersect.once.margin.-100px="shown = true">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
         class="transition-all duration-1000 ease-out opacity-0 translate-y-8">
        
        <div class="landing-card !p-8 sm:!p-12 !bg-gradient-to-br from-[#0a1f17] to-[#051410] border-forest-emerald/30 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 text-center mb-10">
                <p class="text-forest-emerald text-sm font-semibold uppercase tracking-widest mb-3">Kalkulator</p>
                <h2 class="text-3xl sm:text-4xl font-bold mb-4">Cek Potensi Penghasilanmu</h2>
                <p class="text-white/50">Hitung estimasi saldo yang akan kamu dapatkan dari menyetor sampah.</p>
            </div>

            <div class="relative z-10 grid grid-cols-1 sm:grid-cols-2 gap-6 items-start">
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-white/80 mb-2">Pilih Jenis Sampah</label>
                        <div class="relative">
                            <select x-model="kategoriId" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3.5 text-white appearance-none focus:outline-none focus:border-forest-emerald focus:ring-1 focus:ring-forest-emerald transition-colors">
                                <option value="" class="bg-[#051410] text-white">-- Pilih Jenis --</option>
                                <template x-for="cat in categories" :key="cat.id">
                                    <option :value="cat.id" x-text="cat.nama + ' (Rp ' + formatRupiah(cat.harga_per_kg) + ' / ' + cat.satuan + ')'" class="bg-[#051410] text-white"></option>
                                </template>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-white/80 mb-2">Berat (Kg)</label>
                        <input type="number" x-model.number="berat" min="0" step="0.1" placeholder="Contoh: 5.5" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3.5 text-white focus:outline-none focus:border-forest-emerald focus:ring-1 focus:ring-forest-emerald transition-colors">
                    </div>
                </div>

                <div class="bg-primary/10 border border-primary/20 rounded-2xl p-6 sm:p-8 flex flex-col justify-center h-full text-center sm:text-left">
                    <p class="text-sm font-semibold text-primary mb-2">Estimasi Saldo Didapat</p>
                    <p class="text-4xl sm:text-5xl font-black text-white tracking-tight mb-2" x-text="formatEstimasi"></p>
                    <p class="text-sm text-white/50" x-show="kategoriId && berat > 0" x-transition>
                        Berdasarkan <span x-text="berat" class="font-bold text-white"></span> Kg <span x-text="selectedCatName" class="font-bold text-white"></span>
                    </p>
                    <p class="text-sm text-white/50" x-show="!kategoriId || !berat">Masukkan kategori dan berat untuk melihat hasil.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('kalkulatorSampah', () => ({
            shown: false,
            kategoriId: '',
            berat: '',
            categories: @json($categories),
            
            get estimasi() {
                if(!this.kategoriId || !this.berat || this.berat <= 0) return 0;
                const cat = this.categories.find(c => c.id == this.kategoriId);
                return cat ? cat.harga_per_kg * this.berat : 0;
            },
            
            get formatEstimasi() {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(this.estimasi);
            },
            
            get selectedCatName() {
                if(!this.kategoriId) return '';
                const cat = this.categories.find(c => c.id == this.kategoriId);
                return cat ? cat.nama : '';
            },

            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }
        }))
    })
</script>
@endpush

{{-- ═══════════════ EDUKASI ═══════════════ --}}
@if($articles->count())
<section class="py-16 sm:py-20 lg:py-28 bg-[#0a1f17]/50" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
         class="transition-all duration-1000 ease-out opacity-0 translate-y-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10 lg:mb-12">
            <div>
                <p class="text-forest-emerald text-sm font-semibold uppercase tracking-widest mb-3">Edukasi</p>
                <h2 class="landing-section-title font-bold">Tips Daur Ulang</h2>
            </div>
            <a href="{{ route('edukasi.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-forest-emerald hover:text-white transition-colors">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articles as $article)
                <article class="landing-card group flex flex-col h-full !p-0 overflow-hidden">
                    <div class="p-6 flex-1 flex flex-col">
                        <span class="inline-block self-start px-3 py-1 text-xs font-bold bg-primary/20 text-forest-emerald rounded-full mb-4">{{ $article->kategori }}</span>
                        <h3 class="text-lg font-bold mb-3 group-hover:text-forest-emerald transition-colors line-clamp-2">{{ $article->judul }}</h3>
                        <p class="text-sm text-white/50 leading-relaxed flex-1 line-clamp-3">{{ Str::limit(strip_tags($article->konten), 120) }}</p>
                        <a href="{{ route('edukasi.show', $article->slug) }}" class="inline-flex items-center gap-2 text-sm font-bold text-forest-emerald mt-5 group-hover:gap-3 transition-all">
                            Baca artikel
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════ TESTIMONI ═══════════════ --}}
<section class="py-16 sm:py-20 lg:py-28" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
         class="transition-all duration-1000 ease-out opacity-0 translate-y-8">
        <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
            <p class="text-forest-emerald text-sm font-semibold uppercase tracking-widest mb-3">Testimoni Warga</p>
            <h2 class="landing-section-title font-bold mb-4">Apa Kata Mereka?</h2>
            <p class="text-white/50 text-base sm:text-lg">Kisah sukses warga desa dalam mengelola sampah menjadi berkah.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                ['Budi Santoso', 'Nasabah Aktif', 'Sangat memudahkan! Dulu malas ke bank sampah karena jauh, sekarang tinggal jadwalkan jemputan di aplikasi. Saldo juga transparan.'],
                ['Siti Aminah', 'Petugas Lapangan', 'Input timbangan jadi sangat cepat. Tinggal klik-klik, harga otomatis terhitung, dan foto bukti langsung tersimpan. Tidak perlu catat manual lagi.'],
                ['Pak Kades', 'Admin', 'Laporan statistik per RT sangat membantu desa dalam mengambil kebijakan lingkungan. Sistemnya rapi dan profesional.'],
            ] as [$name, $role, $quote])
                <div class="landing-card !p-8 flex flex-col justify-between">
                    <p class="text-white/80 italic mb-6">"{{ $quote }}"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center text-forest-emerald font-bold text-lg">
                            {{ substr($name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-white">{{ $name }}</p>
                            <p class="text-xs text-white/50">{{ $role }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════ FAQ ═══════════════ --}}
<section class="py-16 sm:py-20 lg:py-28 bg-[#0a1f17]/50" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
         class="transition-all duration-1000 ease-out opacity-0 translate-y-8">
        <div class="text-center mb-12 lg:mb-16">
            <p class="text-forest-emerald text-sm font-semibold uppercase tracking-widest mb-3">FAQ</p>
            <h2 class="landing-section-title font-bold">Pertanyaan Umum</h2>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            @foreach([
                ['Apakah daftar SiSampah gratis?', 'Ya, pendaftaran untuk nasabah sepenuhnya gratis tanpa dipungut biaya apapun.'],
                ['Bagaimana cara kerja penjemputan sampah?', 'Anda cukup masuk ke aplikasi, pilih jadwal penjemputan, dan petugas kami akan datang ke lokasi Anda sesuai koordinat GPS yang dikirimkan.'],
                ['Kapan saya bisa menarik saldo?', 'Saldo dapat ditarik kapan saja (tunai atau transfer bank) selama mencapai batas minimum penarikan yang ditetapkan oleh Admin.'],
                ['Apa saja jenis sampah yang diterima?', 'Kami menerima sampah Plastik, Kertas, Kardus, Logam, Kaca, Organik, E-Waste (Elektronik), dan Minyak Jelantah.'],
            ] as $index => [$question, $answer])
                <div class="landing-card !p-0 overflow-hidden">
                    <button @click="active = active === {{ $index }} ? null : {{ $index }}" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                        <span class="font-bold text-lg">{{ $question }}</span>
                        <svg class="w-5 h-5 text-forest-emerald transition-transform" :class="active === {{ $index }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="active === {{ $index }}" x-collapse class="px-6 pb-6 text-white/60">
                        {{ $answer }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════ CTA ═══════════════ --}}
<section class="py-16 sm:py-20 lg:py-28" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
         class="transition-all duration-1000 ease-out opacity-0 translate-y-8">
        <div class="relative overflow-hidden rounded-3xl lg:rounded-[2rem]">
            <div class="absolute inset-0 bg-gradient-to-br from-primary via-[#0d4a35] to-[#051410]"></div>
            <div class="absolute inset-0 opacity-20" style="background-image: url('/images/auth-bg-pattern.svg'); background-size: cover;"></div>
            <div class="relative z-10 px-6 py-12 sm:px-12 sm:py-16 lg:px-20 lg:py-20 text-center">
                <h2 class="landing-section-title font-bold mb-4 max-w-2xl mx-auto">
                    Siap Mengubah Sampah Menjadi Berkah?
                </h2>
                <p class="text-white/60 text-base sm:text-lg max-w-xl mx-auto mb-8 lg:mb-10">
                    Bergabung dengan {{ $stats['nasabah'] }}+ nasabah yang sudah merasakan manfaatnya. Gratis, mudah, dan ramah untuk semua perangkat.
                </p>
                @guest
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-[#051410] font-bold rounded-2xl hover:bg-white/90 transition-all min-h-[52px]">
                            Daftar Sebagai Nasabah
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 border border-white/30 text-white font-semibold rounded-2xl hover:bg-white/10 transition-all min-h-[52px]">
                            Sudah Punya Akun
                        </a>
                    </div>
                @else
                    <a href="{{ route($dash) }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-[#051410] font-bold rounded-2xl hover:bg-white/90 transition-all min-h-[52px]">
                        Ke Dashboard Saya
                    </a>
                @endguest
            </div>
        </div>
    </div>
</section>

@endsection
