@extends('layouts.admin')

@section('content')
<div class="max-w-xl">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('admin.sponsors.index') }}" class="text-gray-600 hover:text-gray-900"><i class="ri-arrow-left-line"></i></a>
        <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-edit-line mr-2"></i>Edit Sponsor</h1>
    </div>

    <form action="{{ route('admin.sponsors.update', $sponsor) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf @method('PUT')
        <div><label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-text mr-1"></i>Nama</label><input type="text" name="name" value="{{ $sponsor->name }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-image-line mr-1"></i>Logo</label>@if($sponsor->logo)<img src="{{ asset('storage/' . $sponsor->logo) }}" class="h-16 mb-2 object-contain">
            @endif<input type="file" name="logo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-link mr-1"></i>URL</label><input type="text" name="url" value="{{ $sponsor->url }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-sort-number-asc mr-1"></i>Urutan</label><input type="number" name="order" value="{{ $sponsor->order }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-toggle-line mr-1"></i>Status</label><select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"><option value="active" {{ $sponsor->status === 'active' ? 'selected' : '' }}>Active</option><option value="inactive" {{ $sponsor->status === 'inactive' ? 'selected' : '' }}>Inactive</option></select></div>
        <div class="flex gap-3 pt-2"><a href="{{ route('admin.sponsors.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"><i class="ri-close-line mr-1"></i>Batal</a><button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]"><i class="ri-save-line mr-1"></i>Simpan</button></div>
    </form>
</div>
@endsection