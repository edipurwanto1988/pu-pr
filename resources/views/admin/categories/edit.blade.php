@extends('layouts.admin')

@section('content')
<div class="">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Edit Kategori</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" value="{{ $category->name }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                    <select name="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="produk" {{ $category->type === 'produk' ? 'selected' : '' }}>Produk</option>
                        <option value="jasa" {{ $category->type === 'jasa' ? 'selected' : '' }}>Jasa</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $category->description }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
                    <div class="flex items-center gap-2">
                        <div class="flex-1 relative">
                            <input type="text" name="icon" id="icon-input" value="{{ $category->icon }}" placeholder="ri-shopping-bag-line" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pr-10">
                            @if($category->icon)
                                <span class="absolute right-3 top-1/2 -translate-y-1/2"><i class="{{ $category->icon }} text-lg text-gray-600"></i></span>
                            @endif
                        </div>
                        <button type="button" onclick="openIconPicker()" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 text-sm font-medium text-gray-700 flex items-center gap-2 transition">
                            <i class="ri-apps-line"></i> Pilih Icon
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                    <input type="number" name="order" value="{{ $category->order }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="active" {{ $category->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $category->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">Simpan</button>
            </div>
        </form>
    </div>
</div>

@include('components.icon-picker')
@endsection