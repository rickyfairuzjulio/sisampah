@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Modern Header with Gradient -->
    <div class="mb-8 animate-fade-in">
        <div class="bg-gradient-to-r from-primary to-forest-emerald rounded-2xl p-8 shadow-lg text-white">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold mb-2">Pengaturan Profil</h1>
                    <p class="text-white/90">Kelola informasi akun, keamanan, dan preferensi Anda</p>
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
            </x-card>
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
            </x-card>
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
