@extends('layouts.frontend')

@section('title', $umkm->business_name . ' — PUPR')

@section('og_title', $umkm->business_name . ' — PUPR')
@section('og_description', \Illuminate\Support\Str::limit(strip_tags($umkm->description ?? ''), 160))
@section('og_image', $umkm->logo ? asset('storage/' . $umkm->logo) : asset('logo_pupr.webp'))
@section('og_url', route('umkm.detail', $umkm->slug))

@section('content')
<div class="bg-gray-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
            <i class="ri-arrow-right-s-line text-gray-300"></i>
            <span class="text-gray-700 font-medium truncate max-w-xs">{{ $umkm->business_name }}</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            @if($umkm->logo)
                <img src="{{ asset('storage/' . $umkm->logo) }}" alt="{{ $umkm->business_name }}" class="w-full h-48 object-cover rounded-lg mb-4">
            @endif
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">{{ $umkm->business_name }}</h1>
            <p class="text-sm text-gray-500 mb-4">{{ $umkm->type === 'umkm' ? 'UMKM' : 'IKM' }} - {{ $umkm->business_type === 'produk' ? 'Produk' : 'Jasa' }}</p>
            <div class="prose max-w-none mb-6">
                {!! $umkm->description !!}
            </div>

            @if($umkm->products->count() > 0)
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Produk/Jasa</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($umkm->products->where('status', 'approved') as $product)
                        <a href="{{ route($product->type === 'produk' ? 'produk.detail' : 'jasa.detail', $product->slug) }}" class="group bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                            <div class="aspect-square bg-gray-100 overflow-hidden">
                                @if($product->images->first())
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300"><i class="ri-image-line text-3xl"></i></div>
                                @endif
                            </div>
                            <div class="p-2">
                                <h3 class="font-medium text-gray-800 text-sm truncate">{{ $product->name }}</h3>
                                @if($product->price)
                                    <p class="text-sm font-medium text-gray-800">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="bg-gray-50 rounded-lg p-6 h-fit">
            @if($umkm->logo)
                <img src="{{ asset('storage/' . $umkm->logo) }}" alt="{{ $umkm->business_name }}" loading="lazy" class="w-24 h-24 rounded-lg object-cover mb-4">
            @else
                <div class="w-24 h-24 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mb-4"><i class="ri-store-line text-4xl"></i></div>
            @endif

            <div class="space-y-2 text-sm">
                @if($umkm->address)
                    <p class="text-gray-600"><i class="ri-map-pin-line mr-2"></i>{{ $umkm->address }}</p>
                @endif
                @if($umkm->kecamatan || $umkm->kelurahan)
                    <p class="text-gray-600">{{ $umkm->kecamatan?->name }}{{ $umkm->kecamatan && $umkm->kelurahan ? ', ' : '' }}{{ $umkm->kelurahan?->name }}</p>
                @endif
                @if($umkm->phone)
                    <p class="text-gray-600"><i class="ri-phone-line mr-2"></i>{{ $umkm->phone }}</p>
                @endif
            </div>

            @if($umkm->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->whatsapp) }}" target="_blank" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors mt-4">
                    <i class="ri-whatsapp-line text-xl"></i> Hubungi via WhatsApp
                </a>
            @endif
        </div>
    </div>
</div>
@endsection