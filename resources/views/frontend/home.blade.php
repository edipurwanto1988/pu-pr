@extends('layouts.frontend')

@section('title', config('app.name', 'PUPR') . ' — Promosi UMKM/IKM Pekanbaru')

@section('og_title', config('app.name', 'PUPR') . ' — Promosi UMKM/IKM Pekanbaru')
@section('og_description', 'Platform Promosi UMKM/IKM Kota Pekanbaru — Temukan produk dan jasa terbaik dari pelaku usaha Pekanbaru.')
@section('og_image', asset('logo_pupr.webp'))
@section('og_url', route('home'))

@section('json_ld')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Organization",
  "name": "PUPR",
  "alternateName": "Pelaku Usaha Pekanbaru Riau",
  "url": "{{ route('home') }}",
  "logo": "{{ asset('logo_pupr.webp') }}",
  "description": "Platform Promosi UMKM/IKM Kota Pekanbaru",
  "address": { "@@type": "PostalAddress", "addressLocality": "Pekanbaru", "addressRegion": "Riau", "addressCountry": "ID" },
  "contactPoint": { "@@type": "ContactPoint", "telephone": "+62-813-6569-5586", "contactType": "customer service" }
}
</script>
@endsection

@section('content')

{{-- Hero / Slider Section --}}
@if($sliders->count() > 0)
<section class="relative h-[250px] sm:h-[300px] md:h-[400px] lg:h-[500px] overflow-hidden">
    <div id="hero-slider" class="relative w-full h-full">
        @foreach($sliders as $index => $slider)
        <div class="slider-slide absolute inset-0 transition-opacity duration-700 {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}">
            <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900/70 via-gray-900/40 to-transparent md:from-gray-900/80 md:via-gray-900/60"></div>
            <div class="absolute inset-0 flex items-center">
                <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 w-full">
                    <div class="max-w-xs sm:max-w-md md:max-w-xl lg:max-w-2xl">
                        <h1 class="text-lg sm:text-xl md:text-2xl lg:text-4xl font-bold text-white leading-tight mb-2 md:mb-3">{{ $slider->title }}</h1>
                        @if($slider->subtitle)
                            <p class="text-xs sm:text-sm md:text-base text-gray-200 mb-3 md:mb-4 leading-relaxed line-clamp-2 md:line-clamp-none">{{ $slider->subtitle }}</p>
                        @endif
                        @if($slider->button_text && $slider->link)
                            <a href="{{ $slider->link }}" class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 md:px-6 py-1.5 sm:py-2 md:py-3 text-xs sm:text-sm md:text-base bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                {{ $slider->button_text }} <i class="ri-arrow-right-line"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Slider Controls --}}
    @if($sliders->count() > 1)
    <div class="absolute bottom-3 sm:bottom-6 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1.5 sm:gap-2">
        @foreach($sliders as $index => $slider)
        <button onclick="goToSlide({{ $index }})" class="slider-dot w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-white w-6 sm:w-8' : 'bg-white/50' }}" data-index="{{ $index }}"></button>
        @endforeach
    </div>
    <button onclick="prevSlide()" class="absolute left-2 sm:left-3 md:left-4 top-1/2 -translate-y-1/2 z-20 w-8 h-8 sm:w-10 md:w-10 flex items-center justify-center bg-white/20 backdrop-blur-sm rounded-full text-white hover:bg-white/40 transition-colors">
        <i class="ri-arrow-left-s-line text-lg sm:text-xl"></i>
    </button>
    <button onclick="nextSlide()" class="absolute right-2 sm:right-3 md:right-4 top-1/2 -translate-y-1/2 z-20 w-8 h-8 sm:w-10 md:w-10 flex items-center justify-center bg-white/20 backdrop-blur-sm rounded-full text-white hover:bg-white/40 transition-colors">
        <i class="ri-arrow-right-s-line text-lg sm:text-xl"></i>
    </button>
    @endif
</section>
@else
{{-- Default Hero when no sliders --}}
<section class="relative overflow-hidden" style="background: linear-gradient(to bottom right, #ca4e33, #b8432b, #a03a24);">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-white rounded-full translate-y-1/3 -translate-x-1/4"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 relative">
        <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 rounded-full text-sm text-white mb-6">
                <i class="ri-store-2-line"></i> Platform UMKM/IKM Kota Pekanbaru
            </div>
            <h1 class="text-3xl md:text-5xl font-bold text-white leading-tight mb-4">
                Selamat Datang di<br>Promosi UMKM/IKM
            </h1>
            <p class="text-lg text-white/80 mb-8 leading-relaxed">
                Temukan produk dan jasa terbaik dari pelaku UMKM/IKM Kota Pekanbaru. Bergabunglah dan kembangkan bisnis Anda bersama kami.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('produk') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white font-semibold rounded-lg hover:bg-orange-50 transition-colors" style="color: #ca4e33;">
                    <i class="ri-shopping-bag-line"></i> Lihat Produk
                </a>
                <a href="{{ route('jasa') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 text-white font-medium rounded-lg hover:bg-white/30 border border-white/20 transition-colors">
                    <i class="ri-service-line"></i> Lihat Jasa
                </a>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Quick Stats --}}
<section class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-gray-100">
            <div class="py-8 text-center">
                <div class="w-12 h-12 mx-auto mb-3 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="ri-store-2-line text-2xl"></i>
                </div>
                <p class="text-2xl font-bold text-gray-800">UMKM</p>
                <p class="text-sm text-gray-500 mt-0.5">Terdaftar</p>
            </div>
            <div class="py-8 text-center">
                <div class="w-12 h-12 mx-auto mb-3 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i class="ri-shopping-bag-line text-2xl"></i>
                </div>
                <p class="text-2xl font-bold text-gray-800">Produk</p>
                <p class="text-sm text-gray-500 mt-0.5">Tersedia</p>
            </div>
            <div class="py-8 text-center">
                <div class="w-12 h-12 mx-auto mb-3 flex items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <i class="ri-service-line text-2xl"></i>
                </div>
                <p class="text-2xl font-bold text-gray-800">Jasa</p>
                <p class="text-sm text-gray-500 mt-0.5">Tersedia</p>
            </div>
            <div class="py-8 text-center">
                <div class="w-12 h-12 mx-auto mb-3 flex items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                    <i class="ri-map-pin-line text-2xl"></i>
                </div>
                <p class="text-2xl font-bold text-gray-800">Kecamatan</p>
                <p class="text-sm text-gray-500 mt-0.5">Terjangkau</p>
            </div>
        </div>
    </div>
</section>

{{-- Produk Unggulan --}}
<section class="py-14 md:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-10 md:mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm font-medium mb-3">
                <i class="ri-star-line"></i> Pilihan Terbaik
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Produk Unggulan</h2>
            <p class="text-gray-500 max-w-lg mx-auto">Temukan produk berkualitas dari pelaku UMKM/IKM Kota Pekanbaru</p>
        </div>

        @if($produkUnggulan->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($produkUnggulan as $produk)
                    <a href="{{ route('produk.detail', $produk->slug) }}" class="group block bg-white rounded-xl overflow-hidden border border-gray-100 hover:border-blue-200 hover:shadow-lg transition-all duration-300">
                        <div class="aspect-square bg-gray-50 overflow-hidden relative">
                            @if($produk->images->first())
                                <img src="{{ asset('storage/' . $produk->images->first()->image_path) }}" alt="{{ $produk->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                                    <i class="ri-image-line text-4xl"></i>
                                </div>
                            @endif
                            @if($produk->is_featured)
                                <span class="absolute top-2 left-2 px-2 py-0.5 bg-amber-500 text-white text-[10px] font-semibold rounded-md uppercase tracking-wide">Unggulan</span>
                            @endif
                        </div>
                        <div class="p-3 md:p-4">
                            <h3 class="font-semibold text-sm md:text-base text-gray-800 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug mb-1">{{ $produk->name }}</h3>
                            <p class="text-xs md:text-sm text-gray-400 truncate mb-2">
                                @if($produk->umkmProfile?->business_name)
                                    <i class="ri-store-2-line"></i> {{ $produk->umkmProfile->business_name }}
                                @endif
                            </p>
                            @if($produk->price)
                                <p class="text-sm md:text-base font-bold text-blue-600">Rp {{ number_format($produk->price, 0, ',', '.') }}</p>
                            @else
                                <p class="text-sm text-gray-400 italic">Hubungi penjual</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="text-center mt-10">
                <a href="{{ route('produk') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-colors">
                    Lihat Semua Produk <i class="ri-arrow-right-line"></i>
                </a>
            </div>
        @else
            <div class="text-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-full bg-gray-100 text-gray-400">
                    <i class="ri-inbox-line text-3xl"></i>
                </div>
                <p class="text-gray-500 font-medium mb-1">Belum ada produk unggulan</p>
                <p class="text-sm text-gray-400 mb-4">Produk dari UMKM/IKM akan tampil di sini</p>
                <a href="{{ route('produk') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm">
                    Lihat semua produk <i class="ri-arrow-right-line"></i>
                </a>
            </div>
        @endif
    </div>
</section>

{{-- Kata Tokoh --}}
@if($kataTokoh->count() > 0)
<section class="relative overflow-hidden py-14 md:py-20" style="background: linear-gradient(to bottom right, #ca4e33, #b8432b, #a03a24);">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-20 -right-20 w-80 h-80 bg-white/20 rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-white/20 rounded-full"></div>
        <div class="absolute top-10 left-10 w-40 h-40 bg-white/10 rounded-full"></div>
        <div class="absolute bottom-1/3 right-20 w-24 h-24 bg-white/10 rounded-full"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-10 md:mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 text-white rounded-full text-sm font-medium mb-3">
                <i class="ri-double-quotes-l"></i> Kata Tokoh
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">Apa Kata Mereka?</h2>
            <p class="text-white/80 max-w-lg mx-auto">Testimoni dan dukungan dari para pemangku kepentingan</p>
        </div>

        <div id="kata-tokoh-carousel" class="relative">
            <div class="absolute inset-0 pointer-events-none overflow-hidden rounded-2xl">
                <div class="absolute -top-8 -right-8 w-24 h-24 bg-white/10 rounded-full"></div>
                <div class="absolute -bottom-8 -left-8 w-16 h-16 bg-white/10 rounded-full"></div>
                <div class="absolute top-1/2 right-4 w-12 h-12 bg-white/5 rounded-full"></div>
            </div>
            <div class="overflow-hidden">
                <div class="flex transition-transform duration-500 ease-in-out" id="kata-tokoh-track">
                    @foreach($kataTokoh as $index => $tokoh)
                    <div class="flex-shrink-0 w-full px-4">
                        <div class="bg-gray-900/80 backdrop-blur rounded-2xl shadow-lg border border-white/20 p-8 md:p-10 text-center max-w-2xl mx-auto">
                            <img src="{{ asset('storage/' . $tokoh->foto) }}" alt="{{ $tokoh->nama }}" class="w-24 h-24 rounded-full object-cover mx-auto mb-4 border-4 border-white/30">
                            <p class="text-white text-lg leading-relaxed mb-4">{{ $tokoh->deskripsi }}</p>
                            <p class="font-bold text-white text-lg">{{ $tokoh->nama }}</p>
                            <p class="text-white/80 font-medium">{{ $tokoh->jabatan }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            @if($kataTokoh->count() > 1)
            <button onclick="prevTokoh()" class="absolute left-0 top-1/2 -translate-y-1/2 -ml-4 w-12 h-12 bg-white/90 backdrop-blur rounded-full shadow-lg flex items-center justify-center text-[#ca4e33] hover:bg-white hover:shadow-xl transition-all z-10">
                <i class="ri-arrow-left-s-line text-2xl"></i>
            </button>
            <button onclick="nextTokoh()" class="absolute right-0 top-1/2 -translate-y-1/2 -mr-4 w-12 h-12 bg-white/90 backdrop-blur rounded-full shadow-lg flex items-center justify-center text-[#ca4e33] hover:bg-white hover:shadow-xl transition-all z-10">
                <i class="ri-arrow-right-s-line text-2xl"></i>
            </button>
            <div class="flex justify-center gap-2 mt-6" id="kata-tokoh-dots">
                @foreach($kataTokoh as $index => $tokoh)
                <button onclick="goToTokoh({{ $index }})" class="kata-tokoh-dot w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-white w-8' : 'bg-white/50' }}" data-index="{{ $index }}"></button>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- Berita Terbaru --}}
@if($beritaTerbaru->count() > 0)
<section class="py-14 md:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-10 md:mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm font-medium mb-3">
                <i class="ri-newspaper-line"></i> Terbaru
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Berita & Informasi</h2>
            <p class="text-gray-500 max-w-lg mx-auto">Ikuti berita terkini seputar UMKM/IKM Kota Pekanbaru</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($beritaTerbaru as $berita)
                <a href="{{ route('berita.detail', $berita->slug) }}" class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100">
                    <div class="aspect-video bg-gray-100 overflow-hidden relative">
                        @if($berita->image)
                            <img src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                                <i class="ri-article-line text-4xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 md:p-5">
                        <div class="flex items-center gap-2 text-xs text-gray-400 mb-2">
                            <i class="ri-calendar-line"></i>
                            <span>{{ $berita->published_at ? $berita->published_at->format('d F Y') : $berita->created_at->format('d F Y') }}</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug mb-2">{{ $berita->title }}</h3>
                        @if($berita->excerpt)
                            <p class="text-sm text-gray-500 line-clamp-2">{{ $berita->excerpt }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('berita') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-white hover:shadow-sm transition-all">
                Lihat Semua Berita <i class="ri-arrow-right-line"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- CTA Section --}}
<section class="relative overflow-hidden" style="background: linear-gradient(to bottom right, #ca4e33, #b8432b, #a03a24);">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-20 -right-20 w-80 h-80 bg-white rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-white rounded-full"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative text-center">
        <div class="max-w-2xl mx-auto">
            <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center rounded-2xl bg-white/20 text-white">
                <i class="ri-rocket-line text-3xl"></i>
            </div>
            <h2 class="text-2xl md:text-4xl font-bold text-white mb-4">Daftarkan UMKM/IKM Anda Sekarang</h2>
            <p class="text-white/80 text-lg mb-8 leading-relaxed">Tingkatkan visibility bisnis Anda dengan menampilkan produk dan jasa di platform resmi Pelaku Usaha Pekanbaru Riau (PUPR).</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white font-semibold rounded-lg hover:bg-orange-50 transition-colors shadow-lg" style="color: #ca4e33;">
                    <i class="ri-user-add-line"></i> Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white/20 text-white font-medium rounded-lg hover:bg-white/30 border border-white/20 transition-colors">
                    <i class="ri-login-box-line"></i> Sudah Punya Akun
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Partner --}}
@if($partners->count() > 0)
<section class="py-14 md:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-2">Mitra & Partner</h2>
            <p class="text-gray-500 text-sm">Bekerja sama untuk kemajuan UMKM/IKM Kota Pekanbaru</p>
        </div>
        <div class="grid grid-cols-3 md:grid-cols-6 gap-6 md:gap-8 items-center">
            @foreach($partners as $partner)
                @if($partner->url && $partner->logo)
                    <a href="{{ $partner->url }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center p-4 rounded-xl hover:bg-gray-50 transition-colors group">
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="h-10 md:h-12 object-contain opacity-50 group-hover:opacity-100 transition-opacity" loading="lazy">
                    </a>
                @elseif($partner->logo)
                    <div class="flex items-center justify-center p-4">
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="h-10 md:h-12 object-contain opacity-50" loading="lazy">
                    </div>
                @else
                    <div class="flex items-center justify-center p-4">
                        <span class="text-sm text-gray-400 font-medium">{{ $partner->name }}</span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Kata Tokoh Carousel Script --}}
@if($kataTokoh->count() > 0)
<script>
    let currentTokoh = 0;
    const totalTokoh = {{ $kataTokoh->count() }};
    let tokohInterval;

    function goToTokoh(index) {
        const track = document.getElementById('kata-tokoh-track');
        const dots = document.querySelectorAll('.kata-tokoh-dot');
        
        track.style.transform = `translateX(-${index * 100}%)`;
        
        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.add('bg-[#ca4e33]', 'w-8');
                dot.classList.remove('bg-gray-300', 'w-2.5');
            } else {
                dot.classList.remove('bg-[#ca4e33]', 'w-8');
                dot.classList.add('bg-gray-300', 'w-2.5');
            }
        });
        
        currentTokoh = index;
    }

    function nextTokoh() {
        goToTokoh((currentTokoh + 1) % totalTokoh);
        resetTokohInterval();
    }

    function prevTokoh() {
        goToTokoh((currentTokoh - 1 + totalTokoh) % totalTokoh);
        resetTokohInterval();
    }

    function resetTokohInterval() {
        clearInterval(tokohInterval);
        tokohInterval = setInterval(nextTokoh, 5000);
    }

    tokohInterval = setInterval(nextTokoh, 5000);
</script>
@endif

{{-- Slider Script --}}
@if($sliders->count() > 1)
<script>
    let currentSlide = 0;
    const totalSlides = {{ $sliders->count() }};
    let sliderInterval;

    function goToSlide(index) {
        const slides = document.querySelectorAll('.slider-slide');
        const dots = document.querySelectorAll('.slider-dot');

        slides.forEach((slide, i) => {
            slide.classList.toggle('opacity-100', i === index);
            slide.classList.toggle('opacity-0', i !== index);
            slide.classList.toggle('z-10', i === index);
            slide.classList.toggle('z-0', i !== index);
        });

        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.add('bg-white', 'w-8');
                dot.classList.remove('bg-white/50', 'w-2.5');
            } else {
                dot.classList.remove('bg-white', 'w-8');
                dot.classList.add('bg-white/50', 'w-2.5');
            }
        });

        currentSlide = index;
    }

    function nextSlide() {
        goToSlide((currentSlide + 1) % totalSlides);
        resetInterval();
    }

    function prevSlide() {
        goToSlide((currentSlide - 1 + totalSlides) % totalSlides);
        resetInterval();
    }

    function resetInterval() {
        clearInterval(sliderInterval);
        sliderInterval = setInterval(nextSlide, 5000);
    }

    // Auto-play
    sliderInterval = setInterval(nextSlide, 5000);
</script>
@endif

@php
    $waNumber = \App\Models\Setting::where('name', 'whatsapp_number')->value('value');
    $waMessage = \App\Models\Setting::where('name', 'whatsapp_message')->value('value');
@endphp

@if($waNumber)
<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $waNumber) }}{{ $waMessage ? '?text=' . urlencode($waMessage) : '' }}" target="_blank" rel="noopener noreferrer" style="position:fixed;bottom:2rem;right:1.5rem;z-index:50;background-color:#22c55e;color:white;width:56px;height:56px;border-radius:50%;box-shadow:0 10px 15px -3px rgba(0,0,0,.1),0 4px 6px -4px rgba(0,0,0,.1);display:flex;align-items:center;justify-content:center;transition:all .3s;" onmouseover="this.style.backgroundColor='#16a34a';this.style.transform='scale(1.1)'" onmouseout="this.style.backgroundColor='#22c55e';this.style.transform='scale(1)'">
    <i class="ri-whatsapp-line" style="font-size:1.75rem;"></i>
</a>
@endif

@endsection
