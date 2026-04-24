<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'PUPR') . ' — Promosi UMKM/IKM Pekanbaru')</title>
    <link rel="canonical" href="{{ $ogUrl ?? request()->url() }}">
    <meta name="description" content="{{ strip_tags($__env->yieldContent('og_description') ?: 'Platform Promosi UMKM/IKM Kota Pekanbaru') }}">
    <meta name="keywords" content="PUPR, UMKM, IKM, Pekanbaru, Pekanbaru, produk lokal, jasa lokal, promosi usaha, pelaku usaha">
    @php $favicon = \App\Models\Setting::where('name', 'favicon')->value('value'); @endphp
    <link rel="icon" href="{{ $favicon ? asset($favicon) : asset('logo_pupr.webp') }}" type="image/webp">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php
        $ogTitle = $__env->yieldContent('og_title') ?: config('app.name', 'PUPR');
        $ogDescription = $__env->yieldContent('og_description') ?: 'Platform Promosi UMKM/IKM Kota Pekanbaru';
        $ogImage = $__env->yieldContent('og_image') ?: asset('logo_pupr.webp');
        $ogUrl = $__env->yieldContent('og_url') ?: request()->fullUrl();
    @endphp
    <meta property="og:title" content="{{ strip_tags($ogTitle) }}">
    <meta property="og:description" content="{{ strip_tags($ogDescription) }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:url" content="{{ $ogUrl }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name', 'PUPR') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ strip_tags($ogTitle) }}">
    <meta name="twitter:description" content="{{ strip_tags($ogDescription) }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
    @yield('json_ld')
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
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('logo_pupr.webp') }}" alt="{{ config('app.name') }}" class="h-9 w-9 object-contain">
                    <span class="text-lg font-bold text-gray-800 leading-tight block">PUPR</span>
                    <div class="hidden sm:block">
                        <span class="text-[10px] text-gray-400 leading-tight block -mt-0.5">Pekanbaru</span>
                    </div>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center gap-1">
                    @foreach($frontendMenus as $menu)
                        @if($menu->children->count() > 0)
                            <div class="relative group">
                                <a href="{{ $menu->url }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors flex items-center gap-1">
                                    @if($menu->icon)<i class="{{ $menu->icon }}"></i>@endisset {{ $menu->title }} <i class="ri-arrow-down-s-line text-xs"></i>
                                </a>
                                <div class="absolute left-0 top-full mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    @foreach($menu->children as $child)
                                        <a href="{{ $child->url }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">{{ $child->title }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $menu->url }}" {{ $menu->target === '_blank' ? 'target="_blank"' : '' }} class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                @if($menu->icon)<i class="{{ $menu->icon }} mr-1"></i>@endif {{ $menu->title }}
                            </a>
                        @endif
                    @endforeach
                </nav>

                {{-- Right Actions --}}
                <div class="flex items-center gap-2">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="hidden md:inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-medium rounded-lg transition-colors" style="background-color: #ca4e33;" onmouseover="this.style.backgroundColor='#b8432b'" onmouseout="this.style.backgroundColor='#ca4e33'">
                            <i class="ri-dashboard-line"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden md:inline-flex px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="hidden md:inline-flex px-4 py-2 text-white text-sm font-medium rounded-lg transition-colors" style="background-color: #ca4e33;" onmouseover="this.style.backgroundColor='#b8432b'" onmouseout="this.style.backgroundColor='#ca4e33'">Daftar</a>
                    @endauth

                    {{-- Mobile Menu Toggle --}}
                    <button type="button" onclick="toggleMobileMenu()" class="md:hidden p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="ri-menu-3-line text-xl" id="menu-icon"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white">
            <div class="px-4 py-3 space-y-1">
                @foreach($frontendMenus as $menu)
                    @if($menu->children->count() > 0)
                        <div class="space-y-1">
                            <a href="{{ $menu->url }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors">
                                @if($menu->icon)<i class="{{ $menu->icon }} text-lg"></i>@endif {{ $menu->title }}
                            </a>
                            @foreach($menu->children as $child)
                                <a href="{{ $child->url }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-500 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors ml-4">
                                    @if($child->icon)<i class="{{ $child->icon }}"></i>@endif {{ $child->title }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <a href="{{ $menu->url }}" {{ $menu->target === '_blank' ? 'target="_blank"' : '' }} class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors">
                            @if($menu->icon)<i class="{{ $menu->icon }} text-lg"></i>@endif {{ $menu->title }}
                        </a>
                    @endif
                @endforeach
                <div class="border-t border-gray-100 pt-2 mt-2">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg" style="color: #ca4e33; background-color: #fdf0ed;">
                            <i class="ri-dashboard-line text-lg"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="ri-login-box-line text-lg"></i> Masuk
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-white rounded-lg mt-1" style="background-color: #ca4e33;">
                            <i class="ri-user-add-line text-lg"></i> Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white">
        {{-- Main Footer --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                {{-- Brand --}}
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('logo_pupr.webp') }}" alt="{{ config('app.name') }}" class="h-10 w-10 object-contain bg-white rounded-lg p-1">
                        <div>
                            <span class="text-lg font-bold block">PUPR</span>
                            <span class="text-xs text-gray-400">Kota Pekanbaru</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4">Platform Promosi UMKM/IKM Kota Pekanbaru — Mendorong pertumbuhan usaha mikro, kecil, dan menengah melalui digitalisasi.</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-800 text-gray-400 hover:bg-blue-600 hover:text-white transition-colors">
                            <i class="ri-facebook-line"></i>
                        </a>
                        <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-800 text-gray-400 hover:bg-blue-600 hover:text-white transition-colors">
                            <i class="ri-instagram-line"></i>
                        </a>
                        <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-800 text-gray-400 hover:bg-blue-600 hover:text-white transition-colors">
                            <i class="ri-youtube-line"></i>
                        </a>
                        <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-800 text-gray-400 hover:bg-blue-600 hover:text-white transition-colors">
                            <i class="ri-twitter-x-line"></i>
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-gray-300 mb-4">Navigasi</h4>
                    <ul class="space-y-2.5">
                        @foreach($frontendMenus as $menu)
                            <li><a href="{{ $menu->url }}" class="text-sm text-gray-400 hover:text-white transition-colors">{{ $menu->title }}</a></li>
                        @endforeach
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-gray-300 mb-4">Kontak</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2.5 text-sm text-gray-400">
                            <i class="ri-map-pin-line text-base mt-0.5 shrink-0"></i>
                            <span>Jl. Todak No.119A, Tengkerang Bar., Kec. Marpoyan Damai, Kota Pekanbaru, Riau 28124</span>
                        </li>
                        <li class="flex items-center gap-2.5 text-sm text-gray-400">
                            <i class="ri-phone-line text-base shrink-0"></i>
                            <span>0813-6569-5586</span>
                        </li>
                        <li class="flex items-center gap-2.5 text-sm text-gray-400">
                            <i class="ri-mail-line text-base shrink-0"></i>
                            <span>info@pu-pr.com</span>
                        </li>
                    </ul>
                </div>

                {{-- UMKM CTA --}}
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-gray-300 mb-4">UMKM/IKM</h4>
                    <p class="text-sm text-gray-400 mb-4">Punya usaha? Daftarkan UMKM/IKM Anda dan tampilkan produk ke seluruh Indonesia.</p>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-white text-sm font-medium rounded-lg transition-colors" style="background-color: #ca4e33;" onmouseover="this.style.backgroundColor='#b8432b'" onmouseout="this.style.backgroundColor='#ca4e33'">
                        <i class="ri-user-add-line"></i> Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-center gap-2">
                <p class="text-xs text-gray-500">&copy; {{ date('Y') }} Pelaku Usaha Pekanbaru Riau (PUPR). All rights reserved.</p>
                <p class="text-xs text-gray-500">Develop By <a href="https://jasawebpekanbaru.com" class="text-gray-400 hover:text-white transition-colors" target="_blank" rel="noopener noreferrer">Jasa Website Pekanbaru</a></p>
            </div>
        </div>
    </footer>

    <script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('menu-icon');
        menu.classList.toggle('hidden');
        if (menu.classList.contains('hidden')) {
            icon.className = 'ri-menu-3-line text-xl';
        } else {
            icon.className = 'ri-close-line text-xl';
        }
    }

    // Close mobile menu on resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            document.getElementById('mobile-menu').classList.add('hidden');
            document.getElementById('menu-icon').className = 'ri-menu-3-line text-xl';
        }
    });

    // Back to top button visibility
    window.addEventListener('scroll', function() {
        var btn = document.getElementById('backToTop');
        if (window.pageYOffset > 300) {
            btn.classList.remove('opacity-0', 'invisible');
            btn.classList.add('opacity-100', 'visible');
        } else {
            btn.classList.add('opacity-0', 'invisible');
            btn.classList.remove('opacity-100', 'visible');
        }
    });
    </script>

    

    <button id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})" style="position:fixed;bottom:2rem;right:6rem;z-index:50;background-color:#ca4e33;color:white;width:3rem;height:3rem;border-radius:9999px;box-shadow:0 10px 15px -3px rgba(0,0,0,.1);display:flex;align-items:center;justify-content:center;transition:all .3s;opacity:0;visibility:hidden;" onmouseover="this.style.backgroundColor='#b8432b'" onmouseout="this.style.backgroundColor='#ca4e33'">
        <i class="ri-arrow-up-line" style="font-size:1.25rem;"></i>
    </button>
</body>
</html>
