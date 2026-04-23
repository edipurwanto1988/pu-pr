@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-blue-100 rounded-lg">
                <i class="ri-store-line text-2xl text-blue-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total UMKM/IKM</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $stats['total_umkm'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-green-100 rounded-lg">
                <i class="ri-product-hunt-line text-2xl text-green-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Produk</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $stats['total_products'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-yellow-100 rounded-lg">
                <i class="ri-service-line text-2xl text-yellow-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Jasa</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $stats['total_jasa'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-red-100 rounded-lg">
                <i class="ri-time-line text-2xl text-red-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Menunggu Validasi</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $stats['pending'] }}</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4"><i class="ri-store-line mr-1"></i>UMKM/IKM Terbaru</h3>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @forelse($latestUmkm as $item)
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 last:border-b-0 hover:bg-gray-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#ca4e33]/10 rounded-lg flex items-center justify-center">
                    <i class="ri-store-line text-[#ca4e33]"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $item->business_name }}</p>
                    <p class="text-xs text-gray-500">{{ $item->user?->name ?? '-' }} &middot; {{ $item->kecamatan?->name ?? '-' }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->type === 'umkm' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                    {{ strtoupper($item->type) }}
                </span>
                @if($item->status === 'pending')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Pending</span>
                @elseif($item->status === 'approved')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Approved</span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Rejected</span>
                @endif
                <span class="text-xs text-gray-400">{{ $item->created_at->diffForHumans() }}</span>
            </div>
        </div>
        @empty
        <div class="p-6 text-center text-gray-500"><i class="ri-inbox-line text-3xl block mb-2"></i>Belum ada UMKM/IKM</div>
        @endforelse
    </div>
</div>
@endsection