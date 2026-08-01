<aside class="w-[260px] flex-shrink-0 bg-[#041A12] border-r border-white/5 flex flex-col h-full z-20 transition-all duration-300">
    <div class="h-16 flex items-center justify-between px-6 border-b border-white/5">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8">
            <span class="text-xl font-bold text-white tracking-tight">SiSampah</span>
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden text-[#8BA39A] hover:text-white p-1">
            <i class="bi bi-x-lg text-lg"></i>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto custom-scrollbar py-6 px-4 space-y-1">
        <p class="px-4 text-[10px] font-bold uppercase tracking-widest text-[#6D8A7F] mb-3">Menu Utama</p>
        
        @php
            $role = Auth::user()->roles->first()->name ?? '';
            $links = [];
            
            if ($role === 'admin') {
                $links = [
                    ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'bi-grid-1x2-fill', 'pattern' => 'admin.dashboard'],
                    ['route' => 'admin.master_bank_sampah.index', 'label' => 'Bank Sampah', 'icon' => 'bi-buildings-fill', 'pattern' => 'admin.master_bank_sampah.*'],
                    ['route' => 'admin.users.index', 'label' => 'Pengguna', 'icon' => 'bi-people-fill', 'pattern' => 'admin.users.*'],
                    ['route' => 'admin.trash_price.index', 'label' => 'Harga Sampah', 'icon' => 'bi-tags-fill', 'pattern' => 'admin.trash_price.*'],
                    ['route' => 'admin.finance.validate', 'label' => 'Keuangan', 'icon' => 'bi-shield-check', 'pattern' => 'admin.finance.*'],
                    ['route' => 'admin.peta_sebaran', 'label' => 'Peta Sebaran', 'icon' => 'bi-geo-alt-fill', 'pattern' => 'admin.peta_sebaran'],
                    ['route' => 'admin.reports', 'label' => 'Laporan', 'icon' => 'bi-bar-chart-fill', 'pattern' => 'admin.reports'],
                    ['route' => 'admin.articles.index', 'label' => 'Artikel Edukasi', 'icon' => 'bi-journal-text', 'pattern' => 'admin.articles.*'],
                ];
            } elseif ($role === 'petugas') {
                $links = [
                    ['route' => 'petugas.dashboard', 'label' => 'Manifes Jemput', 'icon' => 'bi-clipboard-check-fill', 'pattern' => 'petugas.dashboard'],
                    ['route' => 'petugas.self_deposit.form', 'label' => 'Setor Mandiri', 'icon' => 'bi-box-arrow-in-down', 'pattern' => 'petugas.self_deposit.*'],
                ];
            } elseif ($role === 'nasabah') {
                $links = [
                    ['route' => 'nasabah.dashboard', 'label' => 'Dashboard', 'icon' => 'bi-grid-1x2-fill', 'pattern' => 'nasabah.dashboard'],
                    ['route' => 'nasabah.prices.index', 'label' => 'Katalog Harga', 'icon' => 'bi-tags-fill', 'pattern' => 'nasabah.prices.*'],
                    ['route' => 'nasabah.pickup.form', 'label' => 'Jemput Sampah', 'icon' => 'bi-truck-front-fill', 'pattern' => 'nasabah.pickup.*'],
                    ['route' => 'nasabah.wallet', 'label' => 'Dompet Digital', 'icon' => 'bi-wallet-fill', 'pattern' => 'nasabah.wallet'],
                    ['route' => 'nasabah.certificate', 'label' => 'Sertifikat', 'icon' => 'bi-award-fill', 'pattern' => 'nasabah.certificate'],
                    ['route' => 'nasabah.edukasi', 'label' => 'Edukasi', 'icon' => 'bi-book-fill', 'pattern' => 'nasabah.edukasi'],
                ];
            }
        @endphp

        @foreach($links as $link)
            @php $isActive = request()->routeIs($link['pattern']); @endphp
            <a href="{{ route($link['route']) }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-[14px] transition-all duration-200 group relative
                      {{ $isActive ? 'bg-primary/10 text-white' : 'text-[#8BA39A] hover:bg-[#113325] hover:text-white' }}">
                
                <!-- Left Border indicator for active state -->
                @if($isActive)
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-primary rounded-r-md shadow-[0_0_10px_rgba(34,197,94,0.6)]"></div>
                @endif
                
                <i class="bi {{ $link['icon'] }} text-lg {{ $isActive ? 'text-primary' : 'text-[#6D8A7F] group-hover:text-primary' }} transition-colors"></i>
                <span class="font-bold text-sm">{{ $link['label'] }}</span>
            </a>
        @endforeach
    </div>

    <div class="p-4 border-t border-white/5">
        <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 w-full py-3 bg-[#113325] hover:bg-primary/20 text-[#B7C7C1] hover:text-white rounded-[14px] font-bold text-sm transition-colors border border-white/5">
            <i class="bi bi-house-door"></i>
            Kembali ke Beranda
        </a>
    </div>
</aside>
