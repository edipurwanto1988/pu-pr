@extends('layouts.frontend')

@section('title', 'Produk — PUPR')

@section('og_title', 'Produk UMKM/IKM — PUPR')
@section('og_description', 'Temukan produk berkualitas dari pelaku UMKM/IKM Kota Pekanbaru.')
@section('og_image', asset('logo_pupr.webp'))
@section('og_url', route('produk'))

@section('content')
<div class="bg-gray-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
            <i class="ri-arrow-right-s-line text-gray-300"></i>
            <span class="text-gray-700 font-medium">Produk</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Produk</h1>

    <form method="GET" action="{{ route('produk') }}" class="mb-6 flex flex-wrap gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="flex-1 min-w-[200px] px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <select name="category" class="min-w-[220px] pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%236b7280%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.23%207.21a.75.75%200%20011.06.02L10%2011.168l3.71-3.938a.75.75%200%20111.08%201.04l-4.25%204.5a.75.75%200%2001-1.08%200l-4.25-4.5a.75.75%200%2001.02-1.06z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-[length:20px] bg-[right_8px_center] bg-no-repeat">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 text-white rounded-lg transition-colors font-medium" style="background-color: #ca4e33;" onmouseover="this.style.backgroundColor='#b8432b'" onmouseout="this.style.backgroundColor='#ca4e33'"><i class="ri-search-line"></i> Cari</button>
    </form>

    @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($products as $item)
                <a href="{{ route('produk.detail', $item->slug) }}" class="group bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <div class="aspect-square bg-gray-100 overflow-hidden">
                        @if($item->images->first())
                            <img src="{{ asset('storage/' . $item->images->first()->image_path) }}" alt="{{ $item->name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300"><i class="ri-image-line text-4xl"></i></div>
                        @endif
                    </div>
                    <div class="p-3">
                        <h3 class="font-medium text-gray-800 group-hover:text-blue-600 transition-colors truncate">{{ $item->name }}</h3>
                        <p class="text-sm text-gray-500 truncate">{{ $item->umkmProfile?->business_name }}</p>
                        @if($item->price)
                            <p class="text-sm font-medium text-gray-800 mt-1">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $products->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-12 text-gray-500">
            <i class="ri-inbox-line text-4xl mb-2"></i>
            <p>Belum ada produk</p>
        </div>
    @endif
</div>
@endsection