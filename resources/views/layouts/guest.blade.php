<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <!-- Primary Meta Tags -->
    <title>{{ config('app.name', 'SiSampah') }} - Bank Sampah Digital</title>
    <meta name="title" content="{{ config('app.name', 'SiSampah') }} - Bank Sampah Digital">
    <meta name="description" content="Sistem Informasi Manajemen Bank Sampah (SiSampah) untuk mewujudkan lingkungan desa yang bersih, hijau, dan memberikan nilai ekonomis bagi masyarakat.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/app.jsx'])
</head>
<body class="font-sans antialiased bg-[#F8FAFC] text-slate-800 min-h-screen">
    {{ $slot ?? '' }}
    @yield('content')
</body>
</html>
