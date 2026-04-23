@extends('layouts.admin')

@section('title', 'Edit Kelurahan')

@section('content')
<div class="max-w-lg">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('admin.kelurahans.index') }}" class="text-gray-600 hover:text-gray-900"><i class="ri-arrow-left-line"></i></a>
        <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-edit-line mr-2"></i>Edit Kelurahan</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.kelurahans.update', $kelurahan) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                    <select name="kecamatan_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $kelurahan->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->name }}</option>
                        @endforeach
                    </select>
                    @error('kecamatan_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelurahan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $kelurahan->name) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.kelurahans.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"><i class="ri-close-line mr-1"></i>Batal</a>
                <button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]"><i class="ri-save-line mr-1"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection