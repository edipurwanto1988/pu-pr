@extends('layouts.admin')

@section('content')
<div class="max-w-xl">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('admin.kata-tokoh.index') }}" class="text-gray-600 hover:text-gray-900"><i class="ri-arrow-left-line"></i></a>
        <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-edit-line mr-2"></i>Edit Kata Tokoh</h1>
    </div>

    <form action="{{ route('admin.kata-tokoh.update', $kataTokoh) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-user-line mr-1"></i>Nama</label>
            <input type="text" name="nama" value="{{ old('nama', $kataTokoh->nama) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-briefcase-line mr-1"></i>Jabatan</label>
            <input type="text" name="jabatan" value="{{ old('jabatan', $kataTokoh->jabatan) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-file-text-line mr-1"></i>Deskripsi</label>
            <textarea name="deskripsi" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('deskripsi', $kataTokoh->deskripsi) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-image-line mr-1"></i>Foto</label>
            <p class="text-xs text-gray-500 mb-1">Wajib format .WebP, ukuran tepat 100x100 piksel</p>
            @if($kataTokoh->foto)
                <img src="{{ asset('storage/' . $kataTokoh->foto) }}" alt="{{ $kataTokoh->nama }}" class="w-16 h-16 rounded-full object-cover mb-2">
            @endif
            <input type="file" name="foto" accept="image/webp" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700">
            @error('foto')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-sort-number-asc mr-1"></i>Urutan</label>
            <input type="number" name="order" value="{{ old('order', $kataTokoh->order) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="flex gap-3 pt-2">
            <a href="{{ route('admin.kata-tokoh.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"><i class="ri-close-line mr-1"></i>Batal</a>
            <button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]"><i class="ri-save-line mr-1"></i>Simpan</button>
        </div>
    </form>
</div>
@endsection