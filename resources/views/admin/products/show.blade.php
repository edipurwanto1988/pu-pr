@extends('layouts.admin')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-900"><i class="ri-arrow-left-line"></i></a>
        <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-product-hunt-line mr-2"></i>{{ $product->name }}</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4"><i class="ri-information-line mr-1"></i>Informasi</h2>
            <div class="space-y-3">
                <div><span class="text-gray-500"><i class="ri-store-line mr-1"></i>UMKM:</span> {{ $product->umkmProfile?->business_name }}</div>
                <div><span class="text-gray-500"><i class="ri-price-tag-3-line mr-1"></i>Tipe:</span> {{ $product->type }}</div>
                <div><span class="text-gray-500"><i class="ri-money-dollar-circle-line mr-1"></i>Harga:</span> {{ $product->price ? 'Rp ' . number_format($product->price) : '-' }}</div>
                <div><span class="text-gray-500"><i class="ri-book-mark-line mr-1"></i>Kategori:</span> {{ $product->category?->name ?? '-' }}</div>
                <div><span class="text-gray-500"><i class="ri-star-line mr-1"></i>Featured:</span> {{ $product->is_featured ? 'Ya' : 'Tidak' }}</div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4"><i class="ri-shield-check-line mr-1"></i>Status</h2>
            <div class="space-y-3">
                <div>
                    @if($product->status === 'pending')
                        <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800"><i class="ri-time-line mr-1"></i>Pending</span>
                    @elseif($product->status === 'approved')
                        <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800"><i class="ri-check-line mr-1"></i>Approved</span>
                    @else
                        <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-800"><i class="ri-close-line mr-1"></i>Rejected</span>
                    @endif
                </div>
                @if($product->validated_at)
                    <div><span class="text-gray-500"><i class="ri-calendar-line mr-1"></i>Validasi:</span> {{ $product->validated_at }}</div>
                @endif
                @if($product->rejection_reason)
                    <div class="p-3 bg-red-50 rounded"><i class="ri-error-warning-line text-red-600 mr-1"></i><span class="text-red-600">{{ $product->rejection_reason }}</span></div>
                @endif
            </div>
            @if($product->status === 'pending')
            <div class="mt-6 flex gap-3">
                <form action="{{ route('admin.products.approve', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"><i class="ri-check-line mr-1"></i>Setuju</button>
                </form>
                <button onclick="document.getElementById('reject-form').classList.toggle('hidden')" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"><i class="ri-close-line mr-1"></i>Tolak</button>
            </div>
            <div id="reject-form" class="hidden mt-4">
                <form action="{{ route('admin.products.reject', $product) }}" method="POST">
                    @csrf
                    <textarea name="rejection_reason" placeholder="Alasan penolakan" class="w-full border rounded p-2 mb-2" required></textarea>
                    <button type="submit" class="w-full bg-red-600 text-white py-2 rounded"><i class="ri-close-circle-line mr-1"></i>Tolak</button>
                </form>
            </div>
            @endif
        </div>
    </div>
    @if($product->description)
    <div class="mt-6 bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4"><i class="ri-file-text-line mr-1"></i>Deskripsi</h2>
        <div class="prose max-w-none">{{ $product->description }}</div>
    </div>
    @endif
</div>
@endsection