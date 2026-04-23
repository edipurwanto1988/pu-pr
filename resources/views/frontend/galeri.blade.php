@extends('layouts.frontend')

@section('title', 'Galeri — PUPR')

@section('og_title', 'Galeri — PUPR')
@section('og_description', 'Galeri foto kegiatan dan dokumentasi UMKM/IKM Kota Pekanbaru.')
@section('og_image', asset('logo_pupr.webp'))
@section('og_url', route('galeri'))

@section('content')
<div class="bg-gray-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
            <i class="ri-arrow-right-s-line text-gray-300"></i>
            <span class="text-gray-700 font-medium">Galeri</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="text-center mb-10">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Galeri</h1>
        <p class="text-gray-500">Dokumentasi kegiatan dan dokumentasi UMKM/IKM Kota Pekanbaru</p>
    </div>

    @if($galleries->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($galleries as $gallery)
                @if($gallery->images->count() > 0)
                    @php $firstImage = $gallery->images->first(); @endphp
                    <div class="group relative rounded-xl overflow-hidden bg-white border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300">
                        <div class="aspect-square overflow-hidden">
                            <img src="{{ asset('storage/' . $firstImage->image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                            <h3 class="text-white font-semibold text-sm">{{ $gallery->title }}</h3>
                            <p class="text-white/70 text-xs mt-0.5">{{ $gallery->images->count() }} gambar</p>
                        </div>
                        @if($gallery->title)
                            <div class="p-3 group-hover:hidden">
                                <h3 class="font-medium text-sm text-gray-800 truncate">{{ $gallery->title }}</h3>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $gallery->images->count() }} gambar</p>
                            </div>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="text-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-full bg-gray-100 text-gray-400">
                <i class="ri-image-line text-3xl"></i>
            </div>
            <p class="text-gray-500 font-medium mb-1">Belum ada galeri</p>
            <p class="text-sm text-gray-400">Dokumentasi akan tampil di sini</p>
        </div>
    @endif
</div>
@endsection
