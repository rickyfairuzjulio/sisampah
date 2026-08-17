@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Modern Header with Gradient -->
    <div class="mb-8 animate-fade-in">
        <div class="bg-gradient-to-r from-primary to-forest-emerald rounded-2xl p-8 shadow-lg text-white">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 text-center sm:text-left">
                <div class="relative group shrink-0">
                    <div class="w-24 h-24 sm:w-20 sm:h-20 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm border-2 border-white/40 overflow-hidden shadow-inner">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=025e36&color=fff&size=128&bold=true" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute inset-0 bg-black/40 rounded-full opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer backdrop-blur-[2px]">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold mb-2 sm:mb-1 shadow-sm">{{ $user->name }}</h1>
                    <div class="flex items-center gap-2 text-white/90 text-sm font-medium">
                        <span class="px-2 py-0.5 bg-white/20 rounded-md backdrop-blur-sm border border-white/20 capitalize">{{ $user->getRoleNames()->first() ?? 'User' }}</span>
                        <span>·</span>
                        <p>{{ $user->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Settings Sections -->
    <div class="grid grid-cols-1 gap-6 animate-slide-in">
        <!-- Profile Information Section -->
        <section>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-on-surface">Informasi Profil</h2>
                    <p class="text-sm text-on-surface-variant">Update data pribadi Anda</p>
                </div>
            </div>
            <x-card class="border border-outline-variant">
                @include('profile.partials.update-profile-information-form')
            </x-card>
        </section>

        <!-- Password Security Section -->
        <section>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-forest-emerald/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-forest-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-on-surface">Keamanan Password</h2>
                    <p class="text-sm text-on-surface-variant">Ubah password akun Anda</p>
                </div>
            </div>
            <x-card class="border border-outline-variant mt-3">
                @include('profile.partials.update-password-form')
            </x-card>
        </section>

        <!-- Danger Zone -->
        <section>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2m0-14H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-6z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-red-600">Zona Berbahaya</h2>
                    <p class="text-sm text-on-surface-variant">Tindakan yang tidak dapat dibatalkan</p>
                </div>
            </div>
            <x-card class="border-2 border-red-200 bg-red-50/50 mt-3">
                @include('profile.partials.delete-user-form')
            </x-card>
        </section>
    </div>

    <!-- Back Button -->
    <div class="mt-8 flex justify-between items-center">
        <a href="{{ route('dashboard') }}" class="text-primary hover:text-primary-container flex items-center gap-2 font-semibold transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Dashboard
        </a>
        <p class="text-xs text-on-surface-variant">
            Perubahan disimpan secara otomatis
        </p>
    </div>
</div>
@endsection
