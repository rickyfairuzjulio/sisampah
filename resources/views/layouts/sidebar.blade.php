<aside class="w-[250px] flex-shrink-0 bg-slate-900 border-r border-slate-800 flex flex-col h-full z-20 transition-all duration-200">
    <div class="h-16 flex items-center justify-between px-5 border-b border-slate-800">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-7 h-7">
            <span class="text-lg font-bold text-white tracking-tight">SiSampah</span>
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1">
            <i class="bi bi-x-lg text-lg"></i>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto custom-scrollbar py-5 px-3 space-y-1">
        <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Menu Utama</p>
        
        @php
            $user = Auth::user();
            $role = $user?->getRoleNames()?->first() ?? '';
            $isSuperAdmin = $role === 'super_admin' || empty($user->bank_sampah_id);
            $links = [];
            
            if ($role === 'super_admin' || ($role === 'admin' && empty($user->bank_sampah_id))) {
                $links = [
                    ['route' => 'admin.dashboard', 'label' => 'Dashboard Platform', 'icon' => 'bi-grid-1x2-fill', 'pattern' => 'admin.dashboard'],
                    ['route' => 'admin.verifikasi_bank_sampah.index', 'label' => 'Verifikasi Bank Sampah', 'icon' => 'bi-shield-check', 'pattern' => 'admin.verifikasi_bank_sampah.*'],
                    ['route' => 'admin.master_bank_sampah.index', 'label' => 'Master Bank Sampah', 'icon' => 'bi-buildings-fill', 'pattern' => 'admin.master_bank_sampah.*'],
                    ['route' => 'admin.users.index', 'label' => 'Data Manager & User', 'icon' => 'bi-people-fill', 'pattern' => 'admin.users.*'],
                    ['route' => 'admin.articles.index', 'label' => 'Artikel Edukasi', 'icon' => 'bi-journal-text', 'pattern' => 'admin.articles.*'],
                    ['route' => 'admin.trash_price.index', 'label' => 'Harga Sampah Acuan', 'icon' => 'bi-tags-fill', 'pattern' => 'admin.trash_price.*'],
                    ['route' => 'admin.pelanggaran.index', 'label' => 'Catatan Pelanggaran', 'icon' => 'bi-exclamation-triangle-fill', 'pattern' => 'admin.pelanggaran.*'],
                    ['route' => 'admin.region.configure', 'label' => 'Konfigurasi Sistem', 'icon' => 'bi-gear-fill', 'pattern' => 'admin.region.*'],
                ];
            } elseif ($role === 'admin') {
                $links = [
                    ['route' => 'admin.dashboard', 'label' => 'Dashboard Unit', 'icon' => 'bi-grid-1x2-fill', 'pattern' => 'admin.dashboard'],
                    ['route' => 'admin.users.index', 'label' => 'Petugas & Nasabah Unit', 'icon' => 'bi-people-fill', 'pattern' => 'admin.users.*'],
                    ['route' => 'admin.trash_price.index', 'label' => 'Harga Sampah Unit', 'icon' => 'bi-tags-fill', 'pattern' => 'admin.trash_price.*'],
                    ['route' => 'admin.finance.validate', 'label' => 'Keuangan Unit (Payout)', 'icon' => 'bi-wallet2', 'pattern' => 'admin.finance.*'],
                    ['route' => 'admin.pelanggaran.index', 'label' => 'Pelanggaran & Log Unit', 'icon' => 'bi-exclamation-triangle-fill', 'pattern' => 'admin.pelanggaran.*'],
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
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors duration-150 relative text-xs font-semibold
                      {{ $isActive ? 'bg-emerald-500/10 text-emerald-400 font-bold' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                
                @if($isActive)
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-emerald-400 rounded-r"></div>
                @endif
                
                <i class="bi {{ $link['icon'] }} text-sm {{ $isActive ? 'text-emerald-400' : 'text-slate-400' }}"></i>
                <span>{{ $link['label'] }}</span>
            </a>
        @endforeach
    </div>

    <div class="p-3 border-t border-slate-800">
        <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 w-full py-2 px-3 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white rounded-lg font-medium text-xs transition-colors border border-slate-700/60">
            <i class="bi bi-house-door"></i>
            Kembali ke Beranda
        </a>
    </div>
</aside>
