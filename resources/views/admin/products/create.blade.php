@extends('layouts.admin')

@section('content')
<div class="">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-900"><i class="ri-arrow-left-line"></i></a>
        <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-add-circle-line mr-2"></i>Tambah Produk/Jasa</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-text mr-1"></i>Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-store-line mr-1"></i>UMKM/IKM</label>
                    @if($umkm->isEmpty())
                        <p class="text-red-500 text-sm mt-1">Belum ada data UMKM/IKM yang disetujui. <a href="{{ route('admin.umkm.create') }}" class="text-blue-600 underline">Buat UMKM/IKM terlebih dahulu</a>.</p>
                        <select name="umkm_profile_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-100" disabled>
                            <option value="">Tidak ada data UMKM/IKM</option>
                        </select>
                        <input type="hidden" name="umkm_profile_id" value="">
                    @else
                        <select name="umkm_profile_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Pilih UMKM/IKM</option>
                            @foreach($umkm as $u)
                                <option value="{{ $u->id }}" {{ old('umkm_profile_id') == $u->id ? 'selected' : '' }}>{{ $u->business_name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-bookmark-line mr-1"></i>Kategori</label>
                    <div class="flex items-center gap-2">
                        <select name="category_id" id="category_id" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih Kategori</option>
                            @foreach(\App\Models\Category::all() as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" onclick="openCategoryModal()" class="px-3 py-2 border border-gray-300 rounded-md hover:bg-blue-50 text-blue-600 hover:text-blue-700 transition" title="Tambah Kategori">
                            <i class="ri-add-line text-lg"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-money-dollar-circle-line mr-1"></i>Harga</label>
                    <input type="number" name="price" value="{{ old('price') }}" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-file-text-line mr-1"></i>Deskripsi</label>
                    <textarea name="description" id="description" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-image-line mr-1"></i>Gambar</label>
                    <div id="image-preview-container" class="flex flex-wrap gap-3 mb-2"></div>
                    <input type="file" name="images[]" id="image-input" accept="image/*" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-400 mt-1">Pilih satu atau beberapa gambar. Gambar pertama akan menjadi gambar utama.</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"><i class="ri-close-line mr-1"></i>Batal</a>
                <button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]"><i class="ri-save-line mr-1"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="category-modal-overlay" class="fixed inset-0 bg-black/50 z-50 hidden" onclick="closeCategoryModal()"></div>
<div id="category-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl w-96">
        <div class="flex items-center justify-between p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Tambah Kategori</h3>
            <button type="button" onclick="closeCategoryModal()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-500 hover:text-gray-700">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>
        <form id="category-quick-form" class="p-4 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="cat-name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe <span class="text-red-500">*</span></label>
                <select name="type" id="cat-type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    <option value="produk">Produk</option>
                    <option value="jasa">Jasa</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" id="cat-description" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            </div>
            <div id="category-modal-error" class="hidden text-sm text-red-600 bg-red-50 rounded-md p-2"></div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeCategoryModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openCategoryModal() {
    document.getElementById('category-modal-overlay').classList.remove('hidden');
    document.getElementById('category-modal').classList.remove('hidden');
    document.getElementById('cat-name').value = '';
    document.getElementById('cat-type').value = 'produk';
    document.getElementById('cat-description').value = '';
    document.getElementById('category-modal-error').classList.add('hidden');
    document.getElementById('cat-name').focus();
}

function closeCategoryModal() {
    document.getElementById('category-modal-overlay').classList.add('hidden');
    document.getElementById('category-modal').classList.add('hidden');
}

document.getElementById('category-quick-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const errorEl = document.getElementById('category-modal-error');
    errorEl.classList.add('hidden');

    const formData = new FormData(this);
    const response = await fetch('{{ route("admin.categories.quick-store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    });

    if (response.ok) {
        const category = await response.json();
        const select = document.getElementById('category_id');
        const option = document.createElement('option');
        option.value = category.id;
        option.textContent = category.name;
        option.selected = true;
        select.appendChild(option);
        select.value = category.id;
        closeCategoryModal();
    } else {
        const data = await response.json();
        errorEl.textContent = Object.values(data.errors || {}).flat().join(', ') || 'Gagal menyimpan kategori';
        errorEl.classList.remove('hidden');
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeCategoryModal();
});
</script>

<script>
document.getElementById('image-input').addEventListener('change', function(e) {
    const container = document.getElementById('image-preview-container');
    container.innerHTML = '';
    const files = Array.from(e.target.files);
    files.forEach(function(file, index) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            const wrapper = document.createElement('div');
            wrapper.className = 'relative group';
            wrapper.innerHTML = '<img src="' + ev.target.result + '" class="w-24 h-24 object-cover rounded-lg border"><button type="button" onclick="removeImage(this, ' + index + ')" class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white rounded-full text-xs flex items-center justify-center hover:bg-red-600 opacity-0 group-hover:opacity-100 transition"><i class="ri-close-line text-xs"></i></button>' + (index === 0 ? '<span class="absolute bottom-1 left-1 bg-[#ca4e33] text-white text-[10px] px-1.5 py-0.5 rounded">Utama</span>' : '');
            container.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
    window._productImages = files;
});

function removeImage(btn, index) {
    const dt = new DataTransfer();
    const input = document.getElementById('image-input');
    const files = Array.from(input.files);
    files.splice(index, 1);
    files.forEach(f => dt.items.add(f));
    input.files = dt.files;
    btn.closest('.relative').remove();
    input.dispatchEvent(new Event('change'));
}
</script>

<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<script>
tinymce.init({
    selector: '#description',
    license_key: 'gpl',
    plugins: 'lists link image preview align formatpainter code',
    menubar: 'edit insert view format',
    toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | link image | code | removeformat',
    height: 300,
    branding: false,
    promotion: false,
});
</script>
@endsection