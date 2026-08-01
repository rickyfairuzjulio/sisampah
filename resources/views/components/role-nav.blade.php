@props(['role'])

@php
$links = match($role) {
    'nasabah' => [
        ['route' => 'nasabah.dashboard', 'label' => 'Dashboard', 'bi' => 'bi-speedometer2', 'pattern' => 'nasabah.dashboard'],
        ['route' => 'nasabah.prices.index', 'label' => 'Harga Sampah', 'bi' => 'bi-tags-fill', 'pattern' => 'nasabah.prices.*'],
        ['route' => 'nasabah.pickup.form', 'label' => 'Jemput Sampah', 'bi' => 'bi-truck-front-fill', 'pattern' => 'nasabah.pickup.*'],
        ['route' => 'nasabah.wallet', 'label' => 'Dompet & Penarikan', 'bi' => 'bi-wallet2', 'pattern' => 'nasabah.wallet'],
        ['route' => 'nasabah.edukasi', 'label' => 'Edukasi', 'bi' => 'bi-book-fill', 'pattern' => 'nasabah.edukasi'],
    ],
    'petugas' => [
        ['route' => 'petugas.dashboard', 'label' => 'Manifes Jemput', 'bi' => 'bi-clipboard-check-fill', 'pattern' => 'petugas.dashboard'],
        ['route' => 'petugas.self_deposit.form', 'label' => 'Setor Mandiri', 'bi' => 'bi-box-arrow-in-down', 'pattern' => 'petugas.self_deposit.*'],
    ],
    'admin' => [
        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'bi' => 'bi-speedometer2', 'pattern' => 'admin.dashboard'],
        ['route' => 'admin.master_bank_sampah.index', 'label' => 'Master Bank Sampah', 'bi' => 'bi-buildings-fill', 'pattern' => 'admin.master_bank_sampah.*'],
        ['route' => 'admin.peta_sebaran', 'label' => 'Peta Sebaran (GIS)', 'bi' => 'bi-geo-alt-fill', 'pattern' => 'admin.peta_sebaran'],
        ['route' => 'admin.users.index', 'label' => 'Pengguna', 'bi' => 'bi-people-fill', 'pattern' => 'admin.users.*'],
        ['route' => 'admin.trash_price.index', 'label' => 'Harga Sampah', 'bi' => 'bi-tags-fill', 'pattern' => 'admin.trash_price.*'],
        ['route' => 'admin.finance.validate', 'label' => 'Validasi Keuangan', 'bi' => 'bi-shield-check', 'pattern' => 'admin.finance.*'],
        ['route' => 'admin.reports', 'label' => 'Laporan', 'bi' => 'bi-bar-chart-line-fill', 'pattern' => 'admin.reports*'],
        ['route' => 'admin.articles.index', 'label' => 'Artikel Edukasi', 'bi' => 'bi-journal-text', 'pattern' => 'admin.articles.*'],
    ],
    default => [],
};
@endphp

<nav class="mb-6 overflow-x-auto no-scrollbar">
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <div class="flex gap-2.5 min-w-max pb-1">
        @foreach($links as $link)
            <a href="{{ route($link['route']) }}"
               class="inline-flex items-center gap-2 px-4.5 py-2.5 rounded-[14px] text-xs font-extrabold transition-all duration-200 shadow-xs
                      {{ request()->routeIs($link['pattern']) 
                         ? 'bg-gradient-to-r from-[#22C55E] to-[#14B8A6] text-white shadow-[0_4px_20px_rgba(34,197,94,0.35)]' 
                         : 'bg-white dark:bg-[#0F172A] text-[#64748B] dark:text-[#CBD5E1] hover:bg-slate-50 dark:hover:bg-[#1E293B] hover:text-[#0F172A] border border-[#E2E8F0] dark:border-[#334155]' }}">
                @if(!empty($link['bi']))
                    <i class="bi {{ $link['bi'] }} text-sm"></i>
                @elseif(!empty($link['icon']))
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"/>
                    </svg>
                @endif
                {{ $link['label'] }}
            </a>
        @endforeach
    </div>
</nav>
