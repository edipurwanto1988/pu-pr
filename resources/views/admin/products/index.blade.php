@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-product-hunt-line mr-2"></i>Produk & Jasa</h1>
    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">
        <i class="ri-add-line mr-1"></i> Tambah
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg"><i class="ri-check-line mr-1"></i>{{ session('success') }}</div>
@endif

<form method="GET" action="{{ route('admin.products.index') }}" class="mb-4 bg-white rounded-lg shadow p-4">
    <div class="flex flex-wrap gap-2 items-end">
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk, UMKM..." class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-9 w-56 text-sm">
        </div>
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">Jenis</label>
            <select name="type" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-9 text-sm">
                <option value="">Semua</option>
                <option value="produk" {{ request('type') === 'produk' ? 'selected' : '' }}>Produk</option>
                <option value="jasa" {{ request('type') === 'jasa' ? 'selected' : '' }}>Jasa</option>
            </select>
        </div>
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">Kategori</label>
            <select name="category_id" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-9 text-sm">
                <option value="">Semua</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-9 text-sm">
                <option value="">Semua</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">&nbsp;</label>
            <div class="flex gap-2">
                <button type="submit" class="px-3 bg-[#ca4e33] text-white rounded-md hover:bg-[#b8432b] h-9 text-sm"><i class="ri-search-line mr-1"></i>Filter</button>
                <a href="{{ route('admin.products.index') }}" class="px-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 h-9 text-sm inline-flex items-center"><i class="ri-refresh-line mr-1"></i>Reset</a>
            </div>
        </div>
    </div>
</form>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">UMKM</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Featured</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $product->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $product->umkmProfile?->business_name }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->type === 'produk' ? 'bg-blue-50 text-blue-700' : 'bg-green-50 text-green-700' }}">
                            <i class="{{ $product->type === 'produk' ? 'ri-shopping-bag-line' : 'ri-service-line' }} mr-1"></i>{{ $product->type }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($product->status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700"><i class="ri-time-line mr-1"></i>Pending</span>
                        @elseif($product->status === 'approved')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700"><i class="ri-check-line mr-1"></i>Approved</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700"><i class="ri-close-line mr-1"></i>Rejected</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.products.featured', $product) }}" method="POST">
                            @csrf
                            <input type="checkbox" name="is_featured" {{ $product->is_featured ? 'checked' : '' }} onchange="this.form.submit()" class="rounded text-yellow-500">
                        </form>
                    </td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 hover:text-blue-900 mr-2" title="Lihat"><i class="ri-eye-line"></i></a>
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-yellow-600 hover:text-yellow-900 mr-2" title="Edit"><i class="ri-edit-line"></i></a>
                        @if($product->status === 'pending')
                            <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-emerald-600 hover:text-emerald-900 mr-2" title="Setujui"><i class="ri-check-double-line"></i></button>
                            </form>
                            <button type="button" onclick="document.getElementById('reject-{{ $product->id }}').classList.toggle('hidden')" class="text-red-600 hover:text-red-900" title="Tolak"><i class="ri-close-circle-line"></i></button>
                            <div id="reject-{{ $product->id }}" class="hidden absolute bg-white border shadow-lg rounded-lg p-4 mt-2 right-20 z-10 w-64">
                                <form action="{{ route('admin.products.reject', $product) }}" method="POST">
                                    @csrf
                                    <textarea name="rejection_reason" placeholder="Alasan penolakan" class="w-full border rounded p-2 text-sm mb-2" required></textarea>
                                    <button type="submit" class="w-full bg-red-600 text-white py-1 rounded text-sm"><i class="ri-close-circle-line mr-1"></i>Tolak</button>
                                </form>
                            </div>
                        @endif
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 ml-2" title="Hapus"><i class="ri-delete-bin-line"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500"><i class="ri-inbox-line text-3xl block mb-2"></i>Belum ada produk/jasa</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $products->withQueryString()->links() }}
</div>
@endsection