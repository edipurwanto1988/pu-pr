@extends('layouts.frontend')

@section('title', 'Berita & Informasi — PUPR')

@section('og_title', 'Berita & Informasi — PUPR')
@section('og_description', 'Berita terkini seputar UMKM/IKM Kota Pekanbaru.')
@section('og_image', asset('logo_pupr.webp'))
@section('og_url', route('berita'))

@section('content')
<div class="bg-gray-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
            <i class="ri-arrow-right-s-line text-gray-300"></i>
            <span class="text-gray-700 font-medium">Berita</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Berita</h1>

    <form method="GET" action="{{ route('berita') }}" class="mb-6 flex gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..." class="flex-1 min-w-[200px] px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 text-white rounded-lg transition-colors font-medium" style="background-color: #ca4e33;" onmouseover="this.style.backgroundColor='#b8432b'" onmouseout="this.style.backgroundColor='#ca4e33'"><i class="ri-search-line"></i> Cari</button>
    </form>

    @if($news->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($news as $item)
                <a href="{{ route('berita.detail', $item->slug) }}" class="group bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <div class="aspect-video bg-gray-100 overflow-hidden">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300"><i class="ri-article-line text-4xl"></i></div>
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-gray-400 mb-1">{{ $item->published_at ? $item->published_at->format('d F Y') : $item->created_at->format('d F Y') }}</p>
                        <h3 class="font-medium text-gray-800 group-hover:text-blue-600 transition-colors line-clamp-2">{{ $item->title }}</h3>
                        <p class="text-sm text-gray-500 mt-2 line-clamp-3">{{ $item->excerpt }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $news->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-12 text-gray-500">
            <i class="ri-inbox-line text-4xl mb-2"></i>
            <p>Belum ada berita</p>
        </div>
    @endif
</div>
@endsection