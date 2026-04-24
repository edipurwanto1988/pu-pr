<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PUPR') }} — Masuk</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-600">

    {{-- Top Bar --}}
    <div class="bg-[#ca4e33] text-white/80 text-xs py-1.5 hidden md:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1"><i class="ri-phone-line"></i> 0813-6569-5586</span>
                <span class="flex items-center gap-1"><i class="ri-mail-line"></i> info@pu-pr.com</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="#" class="hover:text-white transition-colors"><i class="ri-facebook-line text-sm"></i></a>
                <a href="#" class="hover:text-white transition-colors"><i class="ri-instagram-line text-sm"></i></a>
                <a href="#" class="hover:text-white transition-colors"><i class="ri-youtube-line text-sm"></i></a>
            </div>
        </div>
    </div>

    {{-- Header --}}
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('logo_pupr.webp') }}" alt="{{ config('app.name') }}" class="h-9 w-9 object-contain">
                    <div class="hidden sm:block">
                        <span class="text-lg font-bold text-gray-800 leading-tight block">PUPR</span>
                        <span class="text-[10px] text-gray-400 leading-tight block -mt-0.5">Pekanbaru</span>
                    </div>
                </a>
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">Beranda</a>
                    <a href="{{ route('produk') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">Produk</a>
                    <a href="{{ route('jasa') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">Jasa</a>
                    <a href="{{ route('berita') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">Berita</a>
                    <a href="{{ route('galeri') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">Galeri</a>
                </nav>
                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors">
                        <i class="ri-arrow-left-line"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="min-h-[60vh] flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block">
                    <img src="{{ asset('logo_pupr.webp') }}" alt="{{ config('app.name') }}" class="h-14 w-14 object-contain mx-auto mb-3">
                </a>
                <h2 class="text-xl font-bold text-gray-800">{{ config('app.name') }}</h2>
                <p class="text-sm text-gray-400 mt-1">Platform Promosi UMKM/IKM Pekanbaru</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                {{ $slot }}
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white">
        <div class="border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-center gap-2">
                <p class="text-xs text-gray-500">&copy; {{ date('Y') }} Pelaku Usaha Pekanbaru Riau (PUPR). All rights reserved.</p>
                <p class="text-xs text-gray-500">Develop By <a href="https://jasawebpekanbaru.com" class="text-gray-400 hover:text-white transition-colors" target="_blank" rel="noopener noreferrer">Jasa Website Pekanbaru</a></p>
            </div>
        </div>
    </footer>

</body>
</html>
