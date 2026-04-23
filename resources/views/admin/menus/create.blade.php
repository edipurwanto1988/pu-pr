@extends('layouts.admin')

@section('content')
<div class="">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Tambah Menu</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.menus.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                    <div class="flex gap-2">
                        <input type="text" name="url" id="url-input" value="{{ old('url') }}" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required placeholder="/url-atau-https://...">
                        <select id="page-select" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-auto text-sm" onchange="if(this.value){document.getElementById('url-input').value=this.value;}">
                            <option value="">-- Pilih Halaman --</option>
                            @foreach($pages as $page)
                                <option value="/page/{{ $page->slug }}">{{ $page->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
                    <div class="flex items-center gap-2">
                        <div class="flex-1 relative">
                            <input type="text" name="icon" id="icon-input" value="{{ old('icon') }}" placeholder="ri-home-line" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pr-10">
                            @if(old('icon'))
                                <span class="absolute right-3 top-1/2 -translate-y-1/2"><i class="{{ old('icon') }} text-lg text-gray-600"></i></span>
                            @endif
                        </div>
                        <button type="button" onclick="openIconPicker()" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 text-sm font-medium text-gray-700 flex items-center gap-2 transition">
                            <i class="ri-apps-line"></i> Pilih Icon
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Parent Menu</label>
                    <select name="parent_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Tidak ada</option>
                        @foreach($parentMenus as $pm)
                            <option value="{{ $pm->id }}">{{ $pm->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                    <select name="target" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="_self">Same Tab (_self)</option>
                        <option value="_blank">New Tab (_blank)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.menus.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">Simpan</button>
            </div>
        </form>
    </div>
</div>

@include('components.icon-picker')
@endsection