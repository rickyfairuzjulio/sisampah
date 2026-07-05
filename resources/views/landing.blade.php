<!-- Landing Page / Home -->
<x-guest-layout>
    <div class="min-h-screen flex flex-col">
        <!-- Hero Section -->
        <section class="flex-1 bg-gradient-to-br from-primary via-forest-emerald to-primary text-white px-4 py-20">
            <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight">
                        Kelola Sampah, <br>Raih Penghasilan
                    </h1>
                    <p class="text-xl text-white/90 leading-relaxed">
                        SiSampah memberdayakan masyarakat untuk mengelola sampah dengan cerdas dan mendapatkan nilai ekonomis dari setiap sampah yang didaur ulang.
                    </p>
                    <div class="flex gap-4 pt-4">
                        <x-button variant="primary" size="lg">
                            Daftar Sekarang
                        </x-button>
                        <x-button variant="ghost" size="lg">
                            Pelajari Lebih Lanjut →
                        </x-button>
                    </div>
                    <div class="flex gap-8 text-white/80 text-sm pt-4">
                        <div><strong>127+</strong> Nasabah Aktif</div>
                        <div><strong>45 Ton</strong> Sampah Terkelola</div>
                        <div><strong>18</strong> RT Terlibat</div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white/10 backdrop-blur rounded-2xl p-8 border border-white/20 space-y-4">
                        <div class="bg-white/20 rounded-lg p-4 flex items-center justify-between">
                            <div>
                                <p class="text-white/80 text-sm">Saldo Anda</p>
                                <p class="text-3xl font-bold">Rp 2.5M</p>
                            </div>
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.16 2.75a.75.75 0 00-.75.75v2.5H4.5a2.75 2.75 0 000 5.5h2.91v2.5a.75.75 0 001.5 0v-2.5h2.91a2.75 2.75 0 000-5.5H11v-2.5a.75.75 0 00-.75-.75H8.16z" />
                            </svg>
                        </div>
                        <div class="bg-white/20 rounded-lg p-4">
                            <p class="text-white/80 text-sm mb-2">Sampah Bulan Ini</p>
                            <x-progress :value="65" :show-label="true" />
                        </div>
                        <div class="bg-white/20 rounded-lg p-4">
                            <p class="text-white/80 text-sm mb-2">Peringkat Komunitas</p>
                            <p class="text-2xl font-bold">🏅 #5 dari 18 RT</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="bg-white py-20 px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-on-surface mb-4">Fitur Unggulan</h2>
                    <p class="text-xl text-on-surface-variant max-w-2xl mx-auto">
                        Teknologi terdepan untuk mengelola Bank Sampah dengan mudah dan efisien
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    @php
                        $features = [
                            [
                                'icon' => '📅',
                                'title' => 'Penjadwalan Cerdas',
                                'desc' => 'Atur jadwal penjemputan sampah dengan GPS tracking real-time'
                            ],
                            [
                                'icon' => '💰',
                                'title' => 'Pembayaran Instan',
                                'desc' => 'Dapatkan pembayaran langsung berdasarkan berat dan jenis sampah'
                            ],
                            [
                                'icon' => '🎮',
                                'title' => 'Gamifikasi',
                                'desc' => 'Kumpulkan poin dan naik peringkat di papan komunitas'
                            ],
                            [
                                'icon' => '📊',
                                'title' => 'Analytics Mendalam',
                                'desc' => 'Lacak progress sampah dan penghasilan Anda secara detail'
                            ],
                            [
                                'icon' => '🎓',
                                'title' => 'Pusat Edukasi',
                                'desc' => 'Pelajari cara daur ulang dan dampak lingkungan'
                            ],
                            [
                                'icon' => '🤝',
                                'title' => 'Komunitas Kuat',
                                'desc' => 'Bergabung dengan ribuan nasabah di seluruh Indonesia'
                            ],
                        ]
                    @endphp

                    @foreach($features as $feature)
                        <x-card hover class="text-center">
                            <div class="text-5xl mb-4">{{ $feature['icon'] }}</div>
                            <h3 class="text-lg font-bold text-on-surface mb-2">{{ $feature['title'] }}</h3>
                            <p class="text-on-surface-variant">{{ $feature['desc'] }}</p>
                        </x-card>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section class="bg-soft-mint py-20 px-4">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-4xl font-bold text-on-surface text-center mb-16">Cara Kerja</h2>
                <div class="grid md:grid-cols-4 gap-6">
                    @php
                        $steps = [
                            ['num' => '1', 'title' => 'Daftar', 'desc' => 'Buat akun dan verifikasi identitas Anda'],
                            ['num' => '2', 'title' => 'Kumpulkan', 'desc' => 'Pisahkan dan kumpulkan sampah Anda'],
                            ['num' => '3', 'title' => 'Jemput', 'desc' => 'Pesan penjemputan kapan saja'],
                            ['num' => '4', 'title' => 'Dapatkan Uang', 'desc' => 'Terima pembayaran langsung ke rekening'],
                        ]
                    @endphp
                    @foreach($steps as $step)
                        <div class="text-center">
                            <div class="w-16 h-16 rounded-full bg-primary text-white flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                                {{ $step['num'] }}
                            </div>
                            <h3 class="text-lg font-bold text-on-surface mb-2">{{ $step['title'] }}</h3>
                            <p class="text-on-surface-variant">{{ $step['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-gradient-to-r from-primary to-forest-emerald text-white py-20 px-4">
            <div class="max-w-4xl mx-auto text-center space-y-6">
                <h2 class="text-4xl font-bold">Siap Mulai?</h2>
                <p class="text-xl text-white/90">
                    Bergabunglah dengan komunitas SiSampah dan mulai hasilkan penghasilan dari sampah Anda hari ini juga!
                </p>
                <div class="flex gap-4 justify-center pt-4">
                    <x-button variant="primary" size="lg">
                        Daftar Gratis
                    </x-button>
                    <x-button variant="ghost" size="lg">
                        Hubungi Kami
                    </x-button>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-on-background text-white py-12 px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <h4 class="font-bold mb-4">SiSampah</h4>
                        <p class="text-white/70 text-sm">Mengubah sampah menjadi berkah bagi semua orang</p>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">Produk</h4>
                        <ul class="space-y-2 text-sm text-white/70">
                            <li><a href="#" class="hover:text-white">Untuk Nasabah</a></li>
                            <li><a href="#" class="hover:text-white">Untuk Petugas</a></li>
                            <li><a href="#" class="hover:text-white">Untuk Admin</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">Perusahaan</h4>
                        <ul class="space-y-2 text-sm text-white/70">
                            <li><a href="#" class="hover:text-white">Tentang</a></li>
                            <li><a href="#" class="hover:text-white">Blog</a></li>
                            <li><a href="#" class="hover:text-white">Karir</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">Kontak</h4>
                        <ul class="space-y-2 text-sm text-white/70">
                            <li>📧 hello@sisampah.id</li>
                            <li>📞 +62 822 1234 5678</li>
                            <li>📍 Jakarta, Indonesia</li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-white/20 pt-8 text-center text-white/70 text-sm">
                    <p>&copy; 2024 SiSampah. Semua hak cipta dilindungi.</p>
                </div>
            </div>
        </footer>
    </div>
</x-guest-layout>
