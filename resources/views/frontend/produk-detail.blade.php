@extends('layouts.frontend')

@section('title', $product->name . ' — PUPR')

@section('og_title', $product->name . ' — ' . ($product->umkmProfile?->business_name ?? 'PUPR'))
@section('og_description', \Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 160))
@section('og_image', $product->images->count() > 0 ? asset('storage/' . $product->images->first()->image_path) : asset('logo_pupr.webp'))
@section('og_url', route('produk.detail', $product->slug))

@section('json_ld')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Product",
  "name": {{ json_encode($product->name) }},
  "description": {{ json_encode(\Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 300)) }},
  "image": {{ json_encode($product->images->count() > 0 ? asset('storage/' . $product->images->first()->image_path) : asset('logo_pupr.webp')) }},
  @if($product->price)"offers": { "@@type": "Offer", "price": "{{ $product->price }}", "priceCurrency": "IDR", "availability": "https://schema.org/InStock" },@endif
  "brand": { "@@type": "Organization", "name": {{ json_encode($product->umkmProfile?->business_name ?? 'PUPR') }} }
}
</script>
@endsection

@section('content')
<div class="bg-white">
    {{-- Breadcrumbs --}}
    <div class="border-b border-gray-100 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex items-center gap-2 text-xs md:text-sm text-gray-500 overflow-x-auto whitespace-nowrap pb-1 md:pb-0">
                <a href="{{ route('home') }}" class="hover:text-[#ca4e33] transition-colors flex items-center gap-1">
                    <i class="ri-home-4-line"></i> Beranda
                </a>
                <i class="ri-arrow-right-s-line text-gray-300"></i>
                <a href="{{ route('produk') }}" class="hover:text-[#ca4e33] transition-colors">Produk</a>
                <i class="ri-arrow-right-s-line text-gray-300"></i>
                <span class="text-gray-900 font-medium truncate">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    {{-- Product Main Section --}}
    <section class="py-2 md:py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-8 lg:gap-16">
                
                {{-- Left Column: Gallery --}}
                <div class="lg:col-span-7">
                    <div class="sticky top-24">
                        <div class="relative group">
                            <div class="aspect-square md:aspect-[4/3] bg-gray-100 rounded-2xl overflow-hidden shadow-sm border border-gray-100" id="mainImageWrap">
                                @if($product->images->count() > 0)
                                    <img id="mainImage" src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 bg-gray-50">
                                        <i class="ri-image-2-line text-7xl mb-2"></i>
                                        <p class="text-sm">Tidak ada foto produk</p>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Image Zoom Toggle (Hidden on mobile) --}}
                            @if($product->images->count() > 0)
                                <div class="absolute bottom-4 right-4 hidden md:block">
                                    <button class="bg-white/90 backdrop-blur p-2 rounded-full shadow-lg text-gray-700 hover:text-[#ca4e33] transition-all" title="Zoom">
                                        <i class="ri-zoom-in-line text-xl"></i>
                                    </button>
                                </div>
                            @endif
                        </div>

                        {{-- Thumbnails --}}
                        @if($product->images->count() > 1)
                            <div class="mt-4 flex gap-3 overflow-x-auto pb-2 scrollbar-hide" id="thumbnailRow">
                                @foreach($product->images as $i => $img)
                                    <button onclick="switchImage('{{ asset('storage/' . $img->image_path) }}', this)" 
                                        class="shrink-0 w-20 h-20 md:w-24 md:h-24 rounded-xl overflow-hidden border-2 transition-all duration-300 relative @if($i === 0) border-[#ca4e33] ring-2 ring-[#ca4e33]/20 @else border-gray-100 hover:border-gray-300 @endif">
                                        <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-full object-cover">
                                        @if($i === 0)
                                            <div class="absolute inset-0 bg-[#ca4e33]/5"></div>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Right Column: Info --}}
                <div class="lg:col-span-5 flex flex-col">
                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-4">
                            @if($product->category)
                                <a href="{{ route('produk', ['category' => $product->category->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#ca4e33]/10 text-[#ca4e33] text-xs font-bold uppercase tracking-wider rounded-full hover:bg-[#ca4e33]/20 transition-colors">
                                    <i class="ri-price-tag-3-line"></i> {{ $product->category->name }}
                                </a>
                            @endif
                            <span class="text-xs text-gray-400 bg-gray-100 px-2.5 py-1 rounded-full flex items-center gap-1">
                                <i class="ri-eye-line"></i> Dilihat banyak orang
                            </span>
                        </div>

                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mb-4">{{ $product->name }}</h1>
                        
                        @if($product->price)
                            <div class="flex items-baseline gap-2 mb-6">
                                <span class="text-3xl md:text-4xl font-black text-[#ca4e33]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="text-gray-400 text-sm font-medium">/ Unit</span>
                            </div>
                        @else
                            <div class="mb-6">
                                <span class="text-lg font-bold text-gray-500 italic">Harga Hubungi Penjual</span>
                            </div>
                        @endif

                        
                    </div>

                    

                    
                </div>
            </div>
        </div>
    </section>

    {{-- Content + Sidebar Section --}}
    <section class="py-12 bg-gray-50/50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12">
                
                {{-- Main Info --}}
                <div class="lg:col-span-6 space-y-12">
                    {{-- Full Description --}}
                    <div id="deskripsi" class="bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-2 h-8 bg-[#ca4e33] rounded-full"></div>
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Deskripsi Produk</h2>
                        </div>
                        <div class="prose prose-lg prose-slate max-w-none text-gray-600 leading-relaxed">
                            {!! $product->description !!}
                        </div>
                    </div>

                    {{-- Additional Info if needed --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="ri-information-line text-[#ca4e33]"></i> Detail Lainnya
                        </h3>
                        <ul class="space-y-3 text-sm">
                            <li class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Kategori</span>
                                <span class="font-medium text-gray-900">{{ $product->category?->name ?? '-' }}</span>
                            </li>
                            <li class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Jenis Usaha</span>
                                <span class="font-medium text-gray-900">{{ $product->umkmProfile?->type === 'umkm' ? 'UMKM' : 'IKM' }}</span>
                            </li>
                            <li class="flex justify-between py-2">
                                <span class="text-gray-500">Update Terakhir</span>
                                <span class="font-medium text-gray-900">{{ $product->updated_at->format('d M Y') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Sidebar: Seller Info --}}
                <div class="lg:col-span-6">
                    <div class="sticky top-24 space-y-6">
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                            {{-- Header Profile --}}
                            <div class="p-6 border-b border-gray-50 bg-gray-50/30">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Penjual</h3>
                                @if($product->umkmProfile)
                                    <div class="flex items-center gap-4">
                                        @if($product->umkmProfile->logo)
                                            <img src="{{ asset('storage/' . $product->umkmProfile->logo) }}" alt="{{ $product->umkmProfile->business_name }}" class="w-16 h-16 rounded-xl object-cover border-2 border-white shadow-sm">
                                        @else
                                            <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center text-[#ca4e33] border-2 border-gray-100 shadow-sm">
                                                <i class="ri-store-2-line text-2xl"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="font-bold text-gray-900 leading-tight">
                                                <a href="{{ route('umkm.detail', $product->umkmProfile->slug) }}" class="hover:text-[#ca4e33] transition-colors">{{ $product->umkmProfile->business_name }}</a>
                                            </h4>
                                            <span class="text-[10px] font-bold bg-[#ca4e33]/10 text-[#ca4e33] px-2 py-0.5 rounded uppercase mt-1 inline-block">{{ $product->umkmProfile->type }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="p-6 space-y-6">
                                @if($product->umkmProfile)
                                    <div class="space-y-4">
                                        {{-- Contact List ala Bazaar Jakarta --}}
                                        @if($product->umkmProfile->phone)
                                            <div class="flex items-start gap-3">
                                                <div class="w-10 h-10 shrink-0 bg-orange-50 rounded-full flex items-center justify-center text-[#ca4e33]">
                                                    <i class="ri-phone-line text-lg"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-0.5">Telepon</p>
                                                    <p class="text-sm font-semibold text-gray-900">{{ $product->umkmProfile->phone }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        @if($product->umkmProfile->whatsapp)
                                            <div class="flex items-start gap-3">
                                                <div class="w-10 h-10 shrink-0 bg-green-50 rounded-full flex items-center justify-center text-green-600">
                                                    <i class="ri-whatsapp-line text-lg"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-0.5">WhatsApp</p>
                                                    <p class="text-sm font-semibold text-gray-900">{{ $product->umkmProfile->whatsapp }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        @if($product->umkmProfile->address)
                                            <div class="flex items-start gap-3">
                                                <div class="w-10 h-10 shrink-0 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                                                    <i class="ri-map-pin-line text-lg"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-0.5">Alamat</p>
                                                    <p class="text-sm font-semibold text-gray-900 leading-relaxed">{{ $product->umkmProfile->address }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="pt-6 border-t border-gray-50 flex flex-col gap-2">
                                        <a href="{{ route('umkm.detail', $product->umkmProfile->slug) }}" class="flex items-center justify-center gap-2 w-full py-3 bg-gray-900 hover:bg-black text-white rounded-xl font-bold transition-all text-sm">
                                            Kunjungi Toko
                                        </a>
                                        @if($product->umkmProfile->whatsapp)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->umkmProfile->whatsapp) }}" class="flex items-center justify-center gap-2 w-full py-2.5 text-gray-600 hover:text-[#ca4e33] text-sm font-semibold transition-colors">
                                                <i class="ri-chat-1-line"></i> Tanya via Chat
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="ri-error-warning-line text-3xl text-gray-200 mb-2 block"></i>
                                        <p class="text-xs text-gray-400">Profil tidak tersedia</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Quality Badge --}}
                        <div class="bg-[#ca4e33]/5 border border-[#ca4e33]/10 p-6 rounded-3xl flex items-start gap-4">
                            <div class="w-12 h-12 shrink-0 bg-[#ca4e33] rounded-2xl flex items-center justify-center text-white shadow-lg shadow-[#ca4e33]/20">
                                <i class="ri-heart-pulse-line text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Cintai Produk Lokal</h4>
                                <p class="text-xs text-gray-500 leading-relaxed">Dengan membeli produk ini, Anda turut serta membangun ekonomi kreatif di Pekanbaru.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Related Products --}}
    @if($relatedProducts->count() > 0)
    <section class="py-16 md:py-24 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 mb-2">Produk Terkait</h2>
                    <p class="text-gray-500">Mungkin Anda juga menyukai produk-produk berikut dari kategori yang sama.</p>
                </div>
                <a href="{{ route('produk') }}" class="text-[#ca4e33] font-bold flex items-center gap-1 hover:gap-2 transition-all">
                    Lihat Semua Produk <i class="ri-arrow-right-line"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                @foreach($relatedProducts as $item)
                    <div class="group bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-2">
                        <a href="{{ route('produk.detail', $item->slug) }}" class="block">
                            <div class="aspect-square bg-gray-50 overflow-hidden relative">
                                @if($item->images->first())
                                    <img src="{{ asset('storage/' . $item->images->first()->image_path) }}" alt="{{ $item->name }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-200">
                                        <i class="ri-image-line text-5xl"></i>
                                    </div>
                                @endif
                                
                                {{-- Quick Info Badge --}}
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white/90 backdrop-blur px-2.5 py-1 rounded-full text-[10px] font-bold text-gray-700 shadow-sm uppercase tracking-wider">
                                        {{ $item->category?->name ?? 'Produk' }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <p class="text-[10px] font-bold text-[#ca4e33] uppercase tracking-widest mb-1">{{ $item->umkmProfile?->business_name }}</p>
                                <h3 class="font-bold text-gray-900 group-hover:text-[#ca4e33] transition-colors mb-3 truncate">{{ $item->name }}</h3>
                                <div class="flex items-center justify-between">
                                    @if($item->price)
                                        <p class="font-black text-[#ca4e33]">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    @else
                                        <p class="text-xs font-bold text-gray-400 uppercase italic">Hubungi Penjual</p>
                                    @endif
                                    <div class="w-8 h-8 rounded-full bg-gray-50 group-hover:bg-[#ca4e33] group-hover:text-white flex items-center justify-center text-gray-400 transition-all">
                                        <i class="ri-arrow-right-line"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
</style>

<script>
function switchImage(src, btn) {
    const mainImage = document.getElementById('mainImage');
    
    // Fade out
    mainImage.style.opacity = '0';
    
    setTimeout(() => {
        mainImage.src = src;
        mainImage.style.opacity = '1';
        
        // Update thumbnails
        document.querySelectorAll('#thumbnailRow button').forEach(b => {
            b.classList.remove('border-[#ca4e33]', 'ring-2', 'ring-[#ca4e33]/20');
            b.classList.add('border-gray-100');
            const overlay = b.querySelector('.absolute');
            if (overlay) overlay.remove();
        });
        
        btn.classList.remove('border-gray-100');
        btn.classList.add('border-[#ca4e33]', 'ring-2', 'ring-[#ca4e33]/20');
        
        const newOverlay = document.createElement('div');
        newOverlay.className = 'absolute inset-0 bg-[#ca4e33]/5';
        btn.appendChild(newOverlay);
    }, 200);
}

function shareProduct() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $product->name }}',
            text: 'Lihat produk {{ $product->name }} dari {{ $product->umkmProfile?->business_name }} di PUPR Pekanbaru',
            url: window.location.href,
        }).catch(console.error);
    } else {
        // Fallback
        const tempInput = document.createElement('input');
        tempInput.value = window.location.href;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        alert('Link produk berhasil disalin!');
    }
}
</script>
@endsection