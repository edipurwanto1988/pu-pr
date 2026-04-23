@extends('layouts.admin')

@section('content')
<div class="">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('admin.galleries.index') }}" class="text-gray-600 hover:text-gray-900"><i class="ri-arrow-left-line"></i></a>
        <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-add-circle-line mr-2"></i>Tambah Galeri</h1>
    </div>

    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-text mr-1"></i>Judul</label>
            <input type="text" name="title" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-file-text-line mr-1"></i>Deskripsi</label>
            <textarea name="description" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-sort-number-asc mr-1"></i>Urutan</label>
            <input type="number" name="order" value="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-image-line mr-1"></i>Gambar <span class="text-gray-400 text-xs">(bisa pilih beberapa file)</span></label>
            <input type="file" name="images[]" accept="image/*" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700" required>
            <div id="preview-container" class="grid grid-cols-4 gap-2 mt-3"></div>
        </div>
        <div class="flex gap-3 pt-2">
            <a href="{{ route('admin.galleries.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"><i class="ri-close-line mr-1"></i>Batal</a>
            <button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]"><i class="ri-save-line mr-1"></i>Simpan</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.querySelector('input[name="images[]"]').addEventListener('change', function(e) {
    const container = document.getElementById('preview-container');
    container.innerHTML = '';
    Array.from(e.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(ev) {
            const img = document.createElement('img');
            img.src = ev.target.result;
            img.className = 'h-20 w-full object-cover rounded';
            container.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endsection