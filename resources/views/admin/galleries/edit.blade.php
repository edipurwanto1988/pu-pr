@extends('layouts.admin')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('admin.galleries.index') }}" class="text-gray-600 hover:text-gray-900"><i class="ri-arrow-left-line"></i></a>
        <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-edit-line mr-2"></i>Edit Galeri</h1>
    </div>

    <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-text mr-1"></i>Judul</label>
            <input type="text" name="title" value="{{ $gallery->title }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-file-text-line mr-1"></i>Deskripsi</label>
            <textarea name="description" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $gallery->description }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-sort-number-asc mr-1"></i>Urutan</label>
            <input type="number" name="order" value="{{ $gallery->order }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2"><i class="ri-image-line mr-1"></i>Gambar Saat Ini ({{ $gallery->images->count() }})</label>
            @if($gallery->images->count() > 0)
                <div id="existing-images" class="grid grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach($gallery->images as $img)
                        <div class="relative group" id="image-{{ $img->id }}">
                            <img src="{{ asset('storage/' . $img->image) }}" alt="" class="h-40 w-full object-cover rounded border">
                            <button type="button" onclick="deleteImage({{ $gallery->id }}, {{ $img->id }})" class="absolute top-1 right-1 flex items-center justify-center w-6 h-6 bg-red-600 hover:bg-red-700 text-white rounded-full shadow-lg" title="Hapus gambar">
                                <i class="ri-close-line text-base font-bold"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-sm">Belum ada gambar</p>
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-upload-line mr-1"></i>Tambah Gambar</label>
            <input type="file" name="new_images[]" accept="image/*" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700">
            <div id="preview-container" class="grid grid-cols-3 md:grid-cols-4 gap-2 mt-3"></div>
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
function deleteImage(galleryId, imageId) {
    if (!confirm('Yakin hapus gambar ini?')) return;
    fetch('{{ url("/admin/galleries") }}/' + galleryId + '/images/' + imageId, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('image-' + imageId).remove();
            if (document.querySelectorAll('#existing-images > div').length === 0) {
                document.getElementById('existing-images').outerHTML = '<p class="text-gray-400 text-sm">Belum ada gambar</p>';
            }
        }
    });
}

document.querySelector('input[name="new_images[]"]').addEventListener('change', function(e) {
    const container = document.getElementById('preview-container');
    container.innerHTML = '';
    Array.from(e.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(ev) {
            const img = document.createElement('img');
            img.src = ev.target.result;
            img.className = 'h-28 w-full object-cover rounded';
            container.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endsection