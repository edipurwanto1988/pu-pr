@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-gallery-line mr-2"></i>Galeri</h1>
    <a href="{{ route('admin.galleries.create') }}" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">
        <i class="ri-add-line mr-1"></i> Tambah Galeri
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg"><i class="ri-check-line mr-1"></i>{{ session('success') }}</div>
@endif

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @forelse($galleries as $gallery)
        <div class="bg-white rounded-lg shadow overflow-hidden" id="gallery-card-{{ $gallery->id }}">
            @php $firstImage = $gallery->images->first(); @endphp
            @if($firstImage)
                <img src="{{ asset('storage/' . $firstImage->image) }}" alt="{{ $gallery->title }}" class="w-full h-40 object-cover">
            @else
                <div class="w-full h-40 bg-gray-100 flex items-center justify-center">
                    <i class="ri-image-line text-4xl text-gray-300"></i>
                </div>
            @endif
            <div class="p-3">
                <h3 class="font-medium text-sm truncate">{{ $gallery->title }}</h3>
                <p class="text-xs text-gray-400 mt-1" id="gallery-count-{{ $gallery->id }}">{{ $gallery->images_count }} gambar</p>
                <div class="mt-2 flex justify-end gap-2">
                    <button type="button" onclick="openAddImages({{ $gallery->id }})" class="text-green-600 hover:text-green-900" title="Tambah Gambar"><i class="ri-image-add-line"></i></button>
                    <a href="{{ route('admin.galleries.edit', $gallery) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit"><i class="ri-edit-line"></i></a>
                    <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus galeri ini? Semua gambar akan dihapus.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus"><i class="ri-delete-bin-line"></i></button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-8 text-gray-500"><i class="ri-inbox-line text-3xl block mb-2"></i>Belum ada galeri</div>
    @endforelse
</div>

<div id="add-images-modal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
        <h3 class="text-lg font-semibold mb-4"><i class="ri-image-add-line mr-2"></i>Tambah Gambar</h3>
        <form id="add-images-form" enctype="multipart/form-data">
            @csrf
            <div>
                <input type="file" name="images[]" id="add-images-input" accept="image/*" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700">
                <div id="add-images-preview" class="grid grid-cols-4 gap-2 mt-3"></div>
            </div>
            <div class="flex justify-end gap-3 mt-4">
                <button type="button" onclick="closeAddImages()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"><i class="ri-close-line mr-1"></i>Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"><i class="ri-upload-line mr-1"></i>Upload</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentGalleryId = null;

function openAddImages(galleryId) {
    currentGalleryId = galleryId;
    document.getElementById('add-images-input').value = '';
    document.getElementById('add-images-preview').innerHTML = '';
    document.getElementById('add-images-modal').classList.remove('hidden');
}

function closeAddImages() {
    document.getElementById('add-images-modal').classList.add('hidden');
    currentGalleryId = null;
}

document.getElementById('add-images-modal').addEventListener('click', function(e) {
    if (e.target === this) closeAddImages();
});

document.getElementById('add-images-input').addEventListener('change', function(e) {
    const preview = document.getElementById('add-images-preview');
    preview.innerHTML = '';
    Array.from(e.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(ev) {
            const img = document.createElement('img');
            img.src = ev.target.result;
            img.className = 'h-16 w-full object-cover rounded';
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});

document.getElementById('add-images-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="ri-loader-4-line animate-spin mr-1"></i>Uploading...';

    fetch('{{ url("/admin/galleries") }}/' + currentGalleryId + '/add-images', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<i class="ri-upload-line mr-1"></i>Upload';
        if (data.success) {
            closeAddImages();
            location.reload();
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="ri-upload-line mr-1"></i>Upload';
    });
});
</script>
@endsection