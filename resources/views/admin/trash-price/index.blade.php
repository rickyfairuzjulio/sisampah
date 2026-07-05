@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Flash Messages --}}
    @if(session('success'))
        <x-alert type="success" class="mb-6 animate-slide-in">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        </x-alert>
    @endif

    {{-- Header Section --}}
    <div class="mb-8 animate-fade-in">
        <div class="bg-gradient-to-r from-primary to-forest-emerald rounded-2xl p-8 shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Manajemen Harga Sampah</h1>
                    <p class="text-white/90">Atur harga sampah per kategori</p>
                </div>
                <a href="{{ route('admin.trash-price.create') }}" class="flex items-center gap-2 px-6 py-3 bg-white text-primary font-bold rounded-xl hover:shadow-lg hover:scale-105 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Harga
                </a>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="mb-8 animate-slide-in">
        <x-card class="border border-outline-variant">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-input-field
                    label="Cari Kategori"
                    name="search"
                    type="text"
                    placeholder="Ketik nama kategori..."
                />
                <x-select-field
                    label="Urutkan"
                    name="sort"
                    :options="[
                        'nama' => 'Nama (A-Z)',
                        'harga_asc' => 'Harga (Terendah)',
                        'harga_desc' => 'Harga (Tertinggi)',
                        'terbaru' => 'Paling Baru'
                    ]"
                />
                <div class="flex items-end">
                    <button class="w-full py-2.5 px-6 bg-primary hover:bg-primary-container text-white font-bold rounded-lg transition-colors">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Filter
                        </span>
                    </button>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Price Table --}}
    <x-card class="border border-outline-variant overflow-hidden animate-slide-in">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-surface-container border-b border-outline-variant">
                    <tr>
                        <th class="text-left py-4 px-6 font-bold text-on-surface">Kategori Sampah</th>
                        <th class="text-center py-4 px-6 font-bold text-on-surface">Satuan</th>
                        <th class="text-right py-4 px-6 font-bold text-on-surface">Harga / Unit</th>
                        <th class="text-center py-4 px-6 font-bold text-on-surface">Status</th>
                        <th class="text-center py-4 px-6 font-bold text-on-surface">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="py-4 px-6">
                            <div>
                                <p class="font-semibold text-on-surface">Plastik</p>
                                <p class="text-xs text-on-surface-variant">Kode: PLS-001</p>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-center text-on-surface">Kg</td>
                        <td class="py-4 px-6 text-right">
                            <p class="font-bold text-lg text-primary">Rp 3.500</p>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <x-badge status="active" label="Aktif" />
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <a href="#" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="py-4 px-6">
                            <div>
                                <p class="font-semibold text-on-surface">Kertas</p>
                                <p class="text-xs text-on-surface-variant">Kode: KRT-001</p>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-center text-on-surface">Kg</td>
                        <td class="py-4 px-6 text-right">
                            <p class="font-bold text-lg text-primary">Rp 2.000</p>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <x-badge status="active" label="Aktif" />
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <a href="#" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="py-4 px-6">
                            <div>
                                <p class="font-semibold text-on-surface">Logam</p>
                                <p class="text-xs text-on-surface-variant">Kode: LGM-001</p>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-center text-on-surface">Kg</td>
                        <td class="py-4 px-6 text-right">
                            <p class="font-bold text-lg text-primary">Rp 5.500</p>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <x-badge status="active" label="Aktif" />
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <a href="#" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="py-4 px-6">
                            <div>
                                <p class="font-semibold text-on-surface">Kaca</p>
                                <p class="text-xs text-on-surface-variant">Kode: KCC-001</p>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-center text-on-surface">Kg</td>
                        <td class="py-4 px-6 text-right">
                            <p class="font-bold text-lg text-primary">Rp 1.500</p>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <x-badge status="active" label="Aktif" />
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <a href="#" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="py-4 px-6">
                            <div>
                                <p class="font-semibold text-on-surface">Organik</p>
                                <p class="text-xs text-on-surface-variant">Kode: ORG-001</p>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-center text-on-surface">Kg</td>
                        <td class="py-4 px-6 text-right">
                            <p class="font-bold text-lg text-primary">Rp 800</p>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <x-badge status="active" label="Aktif" />
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <a href="#" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Summary --}}
        <div class="bg-surface-container-lowest p-6 border-t border-outline-variant">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-on-surface-variant mb-1">Total Kategori</p>
                    <p class="text-2xl font-bold text-on-surface">5</p>
                </div>
                <div>
                    <p class="text-sm text-on-surface-variant mb-1">Kategori Aktif</p>
                    <p class="text-2xl font-bold text-primary">5</p>
                </div>
                <div>
                    <p class="text-sm text-on-surface-variant mb-1">Terakhir Diperbarui</p>
                    <p class="text-lg font-semibold text-on-surface">{{ now()->translatedFormat('d M Y') }}</p>
                </div>
            </div>
        </div>
    </x-card>
</div>

@endsection
