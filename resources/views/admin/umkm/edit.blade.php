@extends('layouts.admin')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Edit UMKM/IKM</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.umkm.update', $umkm) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Usaha <span class="text-red-500">*</span></label>
                    <input type="text" name="business_name" value="{{ old('business_name', $umkm->business_name) }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Usaha <span class="text-red-500">*</span></label>
                        <select name="business_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="produk" {{ $umkm->business_type === 'produk' ? 'selected' : '' }}>Produk</option>
                            <option value="jasa" {{ $umkm->business_type === 'jasa' ? 'selected' : '' }}>Jasa</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe <span class="text-red-500">*</span></label>
                        <select name="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="umkm" {{ $umkm->type === 'umkm' ? 'selected' : '' }}>UMKM</option>
                            <option value="ikm" {{ $umkm->type === 'ikm' ? 'selected' : '' }}>IKM</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" id="description"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $umkm->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="address" rows="2"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('address', $umkm->address) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                        <select name="kecamatan_id" id="kecamatan_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" onchange="loadKelurahans()">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec->id }}" {{ $umkm->kecamatan_id == $kec->id ? 'selected' : '' }}>{{ $kec->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                        <select name="kelurahan_id" id="kelurahan_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Pilih Kelurahan --</option>
                            @foreach($kecamatans->where('id', $umkm->kecamatan_id)->first()?->kelurahans ?? [] as $kel)
                                <option value="{{ $kel->id }}" {{ $umkm->kelurahan_id == $kel->id ? 'selected' : '' }}>{{ $kel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $umkm->postal_code) }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $umkm->phone) }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $umkm->whatsapp) }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.umkm.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
async function loadKelurahans() {
    const kecId = document.getElementById('kecamatan_id').value;
    const kelSelect = document.getElementById('kelurahan_id');
    kelSelect.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';

    if (!kecId) return;

    const res = await fetch(`/admin/umkm/kecamatan/${kecId}/kelurahans`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    });
    const data = await res.json();
    data.forEach(kel => {
        const opt = document.createElement('option');
        opt.value = kel.id;
        opt.textContent = kel.name;
        kelSelect.appendChild(opt);
    });
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