<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PUPR') }} - Admin</title>
    @php $favicon = \App\Models\Setting::where('name', 'favicon')->value('value'); @endphp
    <link rel="icon" href="{{ $favicon ? asset($favicon) : asset('logo_pupr.webp') }}" type="image/webp">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Responsive Sidebar & Main Wrapper */
        @media (max-width: 767px) {
            #admin-sidebar {
                transform: translateX(-100%) !important;
                -webkit-transform: translateX(-100%) !important;
                transition: transform 0.3s ease-in-out !important;
                position: fixed !important;
                top: 0 !important;
                bottom: 0 !important;
                left: 0 !important;
                width: 16rem !important;
                z-index: 50 !important;
                display: block !important;
            }
            #admin-sidebar.sidebar-open {
                transform: translateX(0) !important;
                -webkit-transform: translateX(0) !important;
            }
            .admin-main-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
        }
        @media (min-width: 768px) {
            #admin-sidebar {
                transform: translateX(0) !important;
                -webkit-transform: translateX(0) !important;
                position: fixed !important;
                top: 0 !important;
                bottom: 0 !important;
                left: 0 !important;
                width: 16rem !important;
            }
            .admin-main-wrapper {
                margin-left: 16rem !important;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <!-- Backdrop for mobile sidebar -->
    <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity"></div>

    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar -->
        <aside id="admin-sidebar" class="w-64 bg-white border-r border-gray-200 fixed inset-y-0 left-0 z-50 h-full overflow-y-auto">
            <div class="p-4 sm:p-6 border-b border-gray-200 flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                    <img src="{{ asset('logo_pupr.webp') }}" alt="Logo" class="h-8 w-8 object-contain">Admin
                </h1>
                <button type="button" onclick="toggleSidebar()" class="md:hidden p-1.5 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none" title="Tutup Menu">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>
            <nav class="p-4 space-y-1">
                @if(auth()->user()->hasRole('umkm-ikm'))
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100' : '' }}">
                    <i class="ri-dashboard-line mr-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.profile.index') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.profile.*') ? 'bg-gray-100' : '' }}">
                    <i class="ri-user-settings-line mr-2"></i> Profil
                </a>
                <a href="{{ route('admin.umkm.index') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.umkm.*') ? 'bg-gray-100' : '' }}">
                    <i class="ri-store-line mr-2"></i> UMKM/IKM
                </a>
                <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.products.*') ? 'bg-gray-100' : '' }}">
                    <i class="ri-product-hunt-line mr-2"></i> Produk & Jasa
                </a>
                @else
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100' : '' }}">
                    <i class="ri-dashboard-line mr-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.umkm.index') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.umkm.*') ? 'bg-gray-100' : '' }}">
                    <i class="ri-store-line mr-2"></i> UMKM/IKM
                </a>
                <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.products.*') ? 'bg-gray-100' : '' }}">
                    <i class="ri-product-hunt-line mr-2"></i> Produk & Jasa
                </a>
                <a href="{{ route('admin.news.index') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.news.*') ? 'bg-gray-100' : '' }}">
                    <i class="ri-news-line mr-2"></i> Berita
                </a>
                <a href="{{ route('admin.pages.index') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.pages.*') ? 'bg-gray-100' : '' }}">
                    <i class="ri-file-text-line mr-2"></i> Halaman
                </a>
                <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-100' : '' }}">
                    <i class="ri-settings-3-line mr-2"></i> Pengaturan
                </a>

                @php $masterRoutes = ['admin.categories.*', 'admin.menus.*', 'admin.sliders.*', 'admin.galleries.*', 'admin.partners.*', 'admin.sponsors.*', 'admin.users.*', 'admin.kecamatans.*', 'admin.kelurahans.*', 'admin.kata-tokoh.*']; @endphp
                @php $isMasterActive = collect($masterRoutes)->contains(fn($r) => request()->routeIs($r)); @endphp
                <div>
                    <button type="button" onclick="toggleMaster()" class="w-full flex items-center justify-between px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ $isMasterActive ? 'bg-gray-100' : '' }}">
                        <span><i class="ri-database-2-line mr-2"></i> Master</span>
                        <i id="master-arrow" class="ri-arrow-down-s-line transition-transform {{ $isMasterActive ? 'rotate-180' : 'rotate-0' }}"></i>
                    </button>
                    <div id="master-submenu" class="{{ $isMasterActive ? '' : 'hidden' }} ml-4 mt-1 space-y-1">
                        <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 text-sm {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <i class="ri-user-line mr-2"></i> User
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 text-sm {{ request()->routeIs('admin.categories.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <i class="ri-bookmark-line mr-2"></i> Kategori
                        </a>
                        <a href="{{ route('admin.menus.index') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 text-sm {{ request()->routeIs('admin.menus.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <i class="ri-menu-line mr-2"></i> Menu
                        </a>
                        <a href="{{ route('admin.sliders.index') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 text-sm {{ request()->routeIs('admin.sliders.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <i class="ri-slideshow-line mr-2"></i> Slider
                        </a>
                        <a href="{{ route('admin.galleries.index') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 text-sm {{ request()->routeIs('admin.galleries.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <i class="ri-gallery-line mr-2"></i> Galeri
                        </a>
                        <a href="{{ route('admin.partners.index') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 text-sm {{ request()->routeIs('admin.partners.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <i class="ri-links-line mr-2"></i> Partner & Sponsor
                        </a>
                        <a href="{{ route('admin.kecamatans.index') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 text-sm {{ request()->routeIs('admin.kecamatans.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <i class="ri-map-pin-line mr-2"></i> Kecamatan
                        </a>
                        <a href="{{ route('admin.kelurahans.index') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 text-sm {{ request()->routeIs('admin.kelurahans.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <i class="ri-home-line mr-2"></i> Kelurahan
                        </a>
                        <a href="{{ route('admin.kata-tokoh.index') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 text-sm {{ request()->routeIs('admin.kata-tokoh.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <i class="ri-double-quotes-l mr-2"></i> Kata Tokoh
                        </a>
                    </div>
                </div>
                @endif
            </nav>
        </aside>

        <!-- Main Wrapper -->
        <div class="admin-main-wrapper flex-1 md:ml-64 flex flex-col min-w-0 min-h-screen">
            <header class="bg-white border-b border-gray-200 px-4 py-3 sm:px-6 sm:py-4 sticky top-0 z-30 shadow-sm">
                <div class="flex justify-between items-center gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <button type="button" onclick="toggleSidebar()" class="md:hidden p-2 -ml-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none" title="Buka Menu">
                            <i class="ri-menu-line text-2xl"></i>
                        </button>
                        <h2 class="text-base sm:text-lg font-semibold text-gray-800 truncate">@yield('title', 'Dashboard')</h2>
                    </div>
                    <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                        <span class="text-xs sm:text-sm text-gray-600 truncate max-w-[120px] sm:max-w-none">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs sm:text-sm text-gray-600 hover:text-gray-800 flex items-center gap-1 px-2 py-1 rounded hover:bg-gray-100">
                                <i class="ri-logout-box-r-line"></i> <span class="hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="p-4 sm:p-6 lg:p-8 flex-1 min-w-0">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('admin-sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        if (!sidebar) return;
        sidebar.classList.toggle('sidebar-open');
        if (sidebar.classList.contains('sidebar-open')) {
            backdrop.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        } else {
            backdrop.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    function toggleMaster() {
        const submenu = document.getElementById('master-submenu');
        const arrow = document.getElementById('master-arrow');
        submenu.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }
    </script>
    @yield('scripts')
</body>
</html>