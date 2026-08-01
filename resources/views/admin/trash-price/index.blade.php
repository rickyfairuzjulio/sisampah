@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="priceManagement()">

    {{-- Flash Messages & Toasts --}}
    @if(session('success'))
        <x-alert type="success" class="mb-6 animate-slide-in" dismissible>{{ session('success') }}</x-alert>
    @endif
    @if(session('error'))
        <x-alert type="error" class="mb-6 animate-slide-in" dismissible>{{ session('error') }}</x-alert>
    @endif
    @if($errors->any())
        <div class="mb-6 animate-slide-in">
            <x-alert type="error" dismissible>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        </div>
    @endif



    {{-- Dashboard Stats --}}
    <div class="mb-8 animate-fade-in">
        <div class="bg-gradient-to-r from-primary to-forest-emerald rounded-2xl p-6 shadow-lg text-white">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold mb-1">Manajemen Harga Sampah</h1>
                    <p class="text-white/80 text-sm">Kelola seluruh data harga, pantau tren, dan atur katalog sampah.</p>
                </div>
                <div class="flex gap-2">
                    <button @click="$dispatch('open-modal', 'import-modal')" class="px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-md text-white font-semibold rounded-xl transition-colors flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Import
                    </button>
                    <button @click="$dispatch('open-modal', 'create-modal')" class="px-4 py-2 bg-white text-primary hover:bg-gray-100 font-bold rounded-xl transition-all shadow-sm flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/20">
                    <p class="text-white/70 text-xs font-semibold mb-1 uppercase tracking-wider">Total Kategori</p>
                    <p class="text-2xl font-bold">{{ $statistics['total_jenis'] }}</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/20">
                    <p class="text-white/70 text-xs font-semibold mb-1 uppercase tracking-wider">Harga Tertinggi</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($statistics['harga_tertinggi'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/20">
                    <p class="text-white/70 text-xs font-semibold mb-1 uppercase tracking-wider">Harga Naik</p>
                    <p class="text-2xl font-bold text-green-300 flex items-center gap-1">
                        {{ $statistics['harga_naik'] }} <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    </p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/20">
                    <p class="text-white/70 text-xs font-semibold mb-1 uppercase tracking-wider">Update Hari Ini</p>
                    <p class="text-2xl font-bold">{{ $statistics['update_hari_ini'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Section --}}
    <x-card class="mb-6 !p-4 border border-outline-variant animate-slide-in">
        <form action="{{ route('admin.trash_price.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, kode, jenis..." class="w-full pl-10 pr-4 py-2 border border-outline-variant rounded-xl focus:ring-primary focus:border-primary">
            </div>
            
            <div class="w-full md:w-48">
                <select name="kategori" class="w-full border border-outline-variant rounded-xl py-2 px-3 focus:ring-primary focus:border-primary text-sm">
                    <option value="">Semua Kategori</option>
                    <option value="organik" {{ request('kategori') == 'organik' ? 'selected' : '' }}>Organik</option>
                    <option value="anorganik" {{ request('kategori') == 'anorganik' ? 'selected' : '' }}>Anorganik</option>
                    <option value="b3" {{ request('kategori') == 'b3' ? 'selected' : '' }}>B3</option>
                </select>
            </div>

            <div class="w-full md:w-48">
                <select name="status_harga" class="w-full border border-outline-variant rounded-xl py-2 px-3 focus:ring-primary focus:border-primary text-sm">
                    <option value="">Semua Tren Harga</option>
                    <option value="naik" {{ request('status_harga') == 'naik' ? 'selected' : '' }}>Harga Naik</option>
                    <option value="turun" {{ request('status_harga') == 'turun' ? 'selected' : '' }}>Harga Turun</option>
                    <option value="stabil" {{ request('status_harga') == 'stabil' ? 'selected' : '' }}>Harga Stabil</option>
                </select>
            </div>
            
            <div class="flex items-center gap-2">
                <label class="flex items-center gap-2 text-sm text-on-surface-variant cursor-pointer">
                    <input type="checkbox" name="is_archived" value="true" {{ request('is_archived') == 'true' ? 'checked' : '' }} class="rounded border-gray-300 text-primary focus:ring-primary">
                    Tampilkan Arsip
                </label>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-primary text-white font-semibold rounded-xl hover:bg-primary-container transition-colors text-sm">
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'kategori', 'status_harga', 'is_archived']))
                    <a href="{{ route('admin.trash_price.index') }}" class="px-4 py-2 bg-surface-container-high text-on-surface font-semibold rounded-xl hover:bg-surface-container-highest transition-colors text-sm">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </x-card>

    {{-- Main Table --}}
    <x-card class="overflow-hidden border border-outline-variant shadow-sm !p-0 animate-slide-in">
        
        {{-- Toolbar --}}
        <div class="p-4 border-b border-outline-variant bg-surface-container-low flex items-center justify-between">
            <div class="flex items-center gap-2">
                <h3 class="font-bold text-on-surface">Katalog Harga</h3>
                <span class="px-2 py-1 text-xs font-semibold bg-primary/10 text-primary rounded-md">{{ $prices->total() }} Data</span>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.trash_price.history') }}" class="px-3 py-1.5 text-xs font-semibold border border-outline-variant rounded-lg hover:bg-surface-container transition-colors flex items-center gap-1 text-on-surface-variant">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Riwayat Global
                </a>
            </div>
        </div>

        <div class="overflow-x-auto hidden md:block">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-on-surface-variant uppercase bg-surface-container-low font-bold border-b border-outline-variant tracking-wider">
                    <tr>
                        <th class="px-5 py-4 w-10"><input type="checkbox" @click="toggleAll" x-ref="selectAll" class="rounded border-gray-300 text-primary focus:ring-primary"></th>
                        <th class="px-5 py-4">Sampah</th>
                        <th class="px-5 py-4 text-right">Harga (Kg)</th>
                        <th class="px-5 py-4 text-center">Tren</th>
                        <th class="px-5 py-4 text-center">Stok</th>
                        <th class="px-5 py-4 text-center">Kualitas</th>
                        <th class="px-5 py-4">Update Terakhir</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($prices as $price)
                        <tr class="hover:bg-surface-container-lowest/80 transition-colors group {{ $price->is_archived ? 'opacity-60 bg-gray-50' : '' }}">
                            <td class="px-5 py-4"><input type="checkbox" value="{{ $price->id }}" x-model="selectedItems" class="rounded border-gray-300 text-primary focus:ring-primary"></td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-lg bg-surface-container border border-outline-variant flex-shrink-0 overflow-hidden flex items-center justify-center">
                                        @if($price->image_url)
                                            <img src="{{ $price->image_url }}" alt="{{ $price->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-6 h-6 text-outline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-on-surface">
                                            <a href="{{ route('admin.trash_price.show', $price->id) }}" class="hover:text-primary transition-colors">
                                                {{ $price->nama }}
                                            </a>
                                            @if($price->is_archived)
                                                <span class="ml-1 text-[10px] px-1.5 py-0.5 bg-gray-200 text-gray-700 rounded-sm">Arsip</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-on-surface-variant flex items-center gap-1 mt-0.5">
                                            <span class="font-mono text-[10px] bg-surface-container-high px-1 rounded">{{ $price->kode }}</span>
                                            · {{ $price->kategori_label }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <p class="font-extrabold text-base text-primary">Rp {{ number_format($price->harga_per_kg, 0, ',', '.') }}</p>
                                <p class="text-[10px] text-on-surface-variant font-medium mt-0.5">Rp {{ number_format($price->harga_per_gram, 2, ',', '.') }} / gram</p>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold {{ $price->price_status_bg }}">
                                    <span>{{ $price->price_status_icon }}</span>
                                    <span>{{ abs($price->perubahan_persen) }}%</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="text-xs font-bold text-on-surface bg-surface-container-low px-3 py-1 rounded-full border border-outline-variant">{{ number_format($price->stok_dibutuhkan, 0) }} Kg</span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @php
                                    $qualColors = [
                                        'premium' => 'bg-purple-100 text-purple-800',
                                        'standar' => 'bg-blue-100 text-blue-800',
                                        'rendah' => 'bg-gray-100 text-gray-800'
                                    ];
                                    $qColor = $qualColors[$price->kualitas] ?? $qualColors['standar'];
                                @endphp
                                <span class="px-2.5 py-1.5 text-[10px] uppercase tracking-wide font-extrabold rounded-md border border-black/5 shadow-sm {{ $qColor }}">
                                    {{ $price->kualitas }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-xs font-bold text-on-surface">{{ $price->updated_at->translatedFormat('d M Y') }}</p>
                                <p class="text-[10px] font-medium text-on-surface-variant mt-0.5">{{ $price->updated_at->translatedFormat('H:i') }} WIB</p>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.trash_price.show', $price->id) }}" title="Detail" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    
                                    @if(!$price->is_archived)
                                        <button @click="openEditModal({{ $price->toJson() }})" title="Edit" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                    @else
                                        <form action="{{ route('admin.trash_price.restore', $price->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" title="Restore" class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <button @click="openDeleteModal({{ $price->id }}, '{{ addslashes($price->nama) }}')" title="Hapus" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-surface-container rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-outline-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    </div>
                                    <p class="text-on-surface font-semibold text-lg">Tidak ada data harga sampah</p>
                                    <p class="text-on-surface-variant text-sm mt-1 mb-4">Belum ada kategori yang ditambahkan atau tidak sesuai filter.</p>
                                    <button @click="$dispatch('open-modal', 'create-modal')" class="px-4 py-2 bg-primary text-white font-semibold rounded-xl text-sm hover:bg-primary-container transition-colors">
                                        Tambah Data Pertama
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card View --}}
        <div class="block md:hidden divide-y divide-outline-variant">
            @forelse($prices as $price)
                <div class="p-4 bg-surface-container-lowest {{ $price->is_archived ? 'opacity-60 bg-gray-50' : '' }}">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" value="{{ $price->id }}" x-model="selectedItems" class="rounded border-gray-300 text-primary focus:ring-primary mt-1">
                            <div class="w-12 h-12 rounded-lg bg-surface-container border border-outline-variant flex-shrink-0 overflow-hidden flex items-center justify-center">
                                @if($price->image_url)
                                    <img src="{{ $price->image_url }}" alt="{{ $price->nama }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-6 h-6 text-outline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-bold text-on-surface flex items-center gap-2">
                                    {{ $price->nama }}
                                    @if($price->is_archived)
                                        <span class="text-[10px] px-1.5 py-0.5 bg-gray-200 text-gray-700 rounded-sm">Arsip</span>
                                    @endif
                                </p>
                                <p class="text-xs text-on-surface-variant flex items-center gap-1 mt-0.5">
                                    <span class="font-mono text-[10px] bg-surface-container-high px-1 rounded">{{ $price->kode }}</span>
                                    · {{ $price->kategori_label }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-extrabold text-primary">Rp {{ number_format($price->harga_per_kg, 0, ',', '.') }}</p>
                            <p class="text-[10px] text-on-surface-variant">/ kg</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-2 mb-3 bg-surface-container-low p-2.5 rounded-xl border border-outline-variant">
                        <div>
                            <p class="text-[10px] text-on-surface-variant uppercase font-semibold">Tren Harga</p>
                            <div class="inline-flex items-center gap-1 px-2 py-0.5 mt-0.5 rounded-full text-[10px] font-bold {{ $price->price_status_bg }}">
                                <span>{{ $price->price_status_icon }}</span>
                                <span>{{ abs($price->perubahan_persen) }}%</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] text-on-surface-variant uppercase font-semibold">Stok & Kualitas</p>
                            <div class="flex items-center gap-1 mt-0.5">
                                <span class="text-[10px] font-bold text-on-surface bg-surface-container-high px-2 py-0.5 rounded-full border border-outline-variant">{{ number_format($price->stok_dibutuhkan, 0) }} Kg</span>
                                @php
                                    $qualColors = [
                                        'premium' => 'bg-purple-100 text-purple-800',
                                        'standar' => 'bg-blue-100 text-blue-800',
                                        'rendah' => 'bg-gray-100 text-gray-800'
                                    ];
                                    $qColor = $qualColors[$price->kualitas] ?? $qualColors['standar'];
                                @endphp
                                <span class="px-1.5 py-0.5 text-[9px] uppercase font-extrabold rounded border border-black/5 {{ $qColor }}">{{ substr($price->kualitas, 0, 3) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-xs text-on-surface-variant">
                            Diperbarui: {{ $price->updated_at->translatedFormat('d M Y') }}
                        </div>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.trash_price.show', $price->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></a>
                            @if(!$price->is_archived)
                                <button @click="openEditModal({{ $price->toJson() }})" class="p-2 bg-amber-50 text-amber-600 rounded-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                            @else
                                <form action="{{ route('admin.trash_price.restore', $price->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 bg-green-50 text-green-600 rounded-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg></button>
                                </form>
                            @endif
                            <button @click="openDeleteModal({{ $price->id }}, '{{ addslashes($price->nama) }}')" class="p-2 bg-red-50 text-red-600 rounded-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-12 text-center bg-surface-container-lowest">
                    <p class="text-on-surface-variant font-medium">Tidak ada data harga sampah</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($prices->hasPages())
            <div class="p-4 border-t border-outline-variant bg-surface-container-lowest">
                {{ $prices->withQueryString()->links() }}
            </div>
        @endif
    </x-card>

    {{-- Include Modals --}}
    @include('admin.trash-price.partials.create-modal')
    @include('admin.trash-price.partials.edit-modal')
    @include('admin.trash-price.partials.delete-modal')
    @include('admin.trash-price.partials.import-modal')

</div>

@push('scripts')
<script>
    function priceManagement() {
        return {
            selectedItems: [],
            editData: {},
            deleteId: null,
            deleteName: '',
            
            toggleAll(e) {
                if (e.target.checked) {
                    const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
                    this.selectedItems = Array.from(checkboxes).map(cb => cb.value);
                } else {
                    this.selectedItems = [];
                }
            },
            
            openEditModal(data) {
                this.editData = data;
                this.$dispatch('open-modal', 'edit-modal');
                // Form action URL will be updated via x-bind in the modal
            },
            
            openDeleteModal(id, name) {
                this.deleteId = id;
                this.deleteName = name;
                this.$dispatch('open-modal', 'delete-modal');
            }
        }
    }
</script>
@endpush
@endsection
