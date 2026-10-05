@extends('layouts.admin')

@section('title', 'Edit Anggota Dewan Pengurus')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h3 class="text-gray-700 text-3xl font-medium">Edit Anggota Dewan Pengurus</h3>
        <a href="{{ route('admin.board-members.index') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <form action="{{ route('admin.board-members.update', $boardMember) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ old('name', $boardMember->name) }}" required>
            </div>

            <div class="mb-4">
                <label for="position" class="block text-gray-700 font-semibold mb-2">Jabatan <span class="text-red-500">*</span></label>
                <input type="text" name="position" id="position" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ old('position', $boardMember->position) }}" required>
            </div>

            <div class="mb-6">
                <label for="photo" class="block text-gray-700 font-semibold mb-2">Foto Profile</label>
                @if($boardMember->photo_id)
                    <div class="mb-4">
                        <img src="{{ \App\Services\GoogleDriveService::getUrl($boardMember->photo_id) }}" alt="{{ $boardMember->name }}" class="w-32 h-32 object-cover rounded shadow-md border border-gray-200">
                    </div>
                @endif
                <input type="file" name="photo" id="photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-sm text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto.</p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300">
                    Perbarui Pengurus
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
