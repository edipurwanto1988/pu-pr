@extends('layouts.admin')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Tambah UMKM/IKM</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.umkm.store') }}" method="POST">
            @csrf

            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Pemilik Usaha</h2>
                @if(auth()->user()->hasRole('umkm-ikm'))
                    <input type="hidden" name="user_source" value="existing">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg px-4 py-3 text-sm text-blue-700">
                        <i class="ri-user-line mr-1"></i> {{ auth()->user()->name }} ({{ auth()->user()->email }})
                    </div>
                @else
                <div class="space-y-4">
                    <div>
                        <label class="inline-flex items-center mr-6">
                            <input type="radio" name="user_source" value="existing" checked
                                class="mr-2" onchange="toggleUserSource()">
                            Pilih User yang Sudah Ada
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="user_source" value="new"
                                class="mr-2" onchange="toggleUserSource()">
                            Buat User Baru
                        </label>
                    </div>

                    <div id="existing-user-section">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih User</label>
                        <select name="user_id" id="user_id_select" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="new-user-section" class="hidden space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik</label>
                            <input type="text" name="name" id="new_user_name" value="{{ old('name') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="new_user_email" value="{{ old('email') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" id="new_user_password"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="mb-6 border-t pt-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Informasi Usaha</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Usaha <span class="text-red-500">*</span></label>
                        <input type="text" name="business_name" value="{{ old('business_name') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        @error('business_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Usaha <span class="text-red-500">*</span></label>
                            <select name="business_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="produk" {{ old('business_type') === 'produk' ? 'selected' : '' }}>Produk</option>
                                <option value="jasa" {{ old('business_type') === 'jasa' ? 'selected' : '' }}>Jasa</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe <span class="text-red-500">*</span></label>
                            <select name="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="umkm" {{ old('type') === 'umkm' ? 'selected' : '' }}>UMKM</option>
                                <option value="ikm" {{ old('type') === 'ikm' ? 'selected' : '' }}>IKM</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" id="description"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea name="address" rows="2"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('address') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                            <select name="kecamatan_id" id="kecamatan_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" onchange="loadKelurahans()">
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach($kecamatans as $kec)
                                    <option value="{{ $kec->id }}" {{ old('kecamatan_id') == $kec->id ? 'selected' : '' }}>{{ $kec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                            <select name="kelurahan_id" id="kelurahan_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Pilih Kelurahan --</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    @if(!auth()->user()->hasRole('umkm-ikm'))
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="approved" selected>Approved</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    @else
                    <input type="hidden" name="status" value="pending">
                    @endif
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
function toggleUserSource() {
    const existing = document.getElementById('existing-user-section');
    const newUser = document.getElementById('new-user-section');
    const radios = document.querySelectorAll('input[name="user_source"]');
    let value = 'existing';
    radios.forEach(r => { if (r.checked) value = r.value; });

    if (value === 'existing') {
        existing.classList.remove('hidden');
        newUser.classList.add('hidden');
        document.getElementById('user_id_select').required = true;
        document.getElementById('new_user_name').required = false;
        document.getElementById('new_user_email').required = false;
        document.getElementById('new_user_password').required = false;
    } else {
        existing.classList.add('hidden');
        newUser.classList.remove('hidden');
        document.getElementById('user_id_select').required = false;
        document.getElementById('new_user_name').required = true;
        document.getElementById('new_user_email').required = true;
        document.getElementById('new_user_password').required = true;
    }
}

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

document.addEventListener('DOMContentLoaded', function() {
    const kecId = document.getElementById('kecamatan_id').value;
    if (kecId) loadKelurahans();
});
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