@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-user-settings-line mr-2"></i>Profil UMKM/IKM</h1>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg"><i class="ri-check-line mr-1"></i>{{ session('success') }}</div>
@endif

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.profile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. KTA</label>
                    <input type="text" name="kta_number" value="{{ old('kta_number', $profile->kta_number) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan No. KTA">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NO NIK KTP</label>
                    <input type="text" name="nik_number" value="{{ old('nik_number', $profile->nik_number) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan NO NIK KTP">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NAMA PELAKU USAHA</label>
                <input type="text" name="business_actor_name" value="{{ old('business_actor_name', $profile->business_actor_name) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIB (BAGI YANG ADA)</label>
                <input type="text" name="nib" value="{{ old('nib', $profile->nib) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">JENIS USAHA</label>
                <select name="business_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Pilih Jenis Usaha --</option>
                    @foreach(['Usaha kuliner', 'Usaha fashion', 'Usaha agribisnis', 'Usaha elektronik', 'Usaha furniture', 'Usaha bidang jasa', 'UMKM berbasis digital', 'UMKM produk kecantikan'] as $type)
                        <option value="{{ $type }}" {{ old('business_type', $profile->business_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">JENIS TEMPAT USAHA</label>
                <select name="business_place_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Pilih Jenis Tempat Usaha --</option>
                    <option value="BERGERAK" {{ old('business_place_type', $profile->business_place_type) == 'BERGERAK' ? 'selected' : '' }}>BERGERAK</option>
                    <option value="TIDAK BERGERAK" {{ old('business_place_type', $profile->business_place_type) == 'TIDAK BERGERAK' ? 'selected' : '' }}>TIDAK BERGERAK</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">KATEGORI USAHA</label>
                <select name="business_category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="UMKM" {{ old('business_category', $profile->business_category) == 'UMKM' ? 'selected' : '' }}>UMKM</option>
                    <option value="IKM" {{ old('business_category', $profile->business_category) == 'IKM' ? 'selected' : '' }}>IKM</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ALAMAT (Jalan)</label>
                <textarea name="address" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('address', $profile->address) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                    <select name="kecamatan_id" id="kecamatan_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" onchange="loadKelurahans()">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($kecamatans as $kec)
                            <option value="{{ $kec->id }}" {{ old('kecamatan_id', $profile->kecamatan_id) == $kec->id ? 'selected' : '' }}>{{ $kec->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                    <select name="kelurahan_id" id="kelurahan_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Pilih Kelurahan --</option>
                        @foreach($kelurahans as $kel)
                            <option value="{{ $kel->id }}" {{ old('kelurahan_id', $profile->kelurahan_id) == $kel->id ? 'selected' : '' }}>{{ $kel->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NO WA</label>
                <input type="text" name="whatsapp" value="{{ old('whatsapp', $profile->whatsapp) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">PRODUK USAHA</label>
                <input type="text" name="business_products" value="{{ old('business_products', $profile->business_products) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Omset perbulan</label>
                <input type="text" name="monthly_turnover" value="{{ old('monthly_turnover', $profile->monthly_turnover) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t pt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">KIRIM FOTO KTP</label>
                    @if($profile->ktp_photo) <img src="{{ asset('storage/' . $profile->ktp_photo) }}" class="h-20 mb-2"> @endif
                    <input type="file" name="ktp_photo" accept="image/*" class="w-full text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">KIRIM FOTO WAJAH</label>
                    @if($profile->face_photo) <img src="{{ asset('storage/' . $profile->face_photo) }}" class="h-20 mb-2"> @endif
                    <input type="file" name="face_photo" accept="image/*" class="w-full text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">KIRIM BUKTI PEMBAYARAN</label>
                    @if($profile->payment_proof) <img src="{{ asset('storage/' . $profile->payment_proof) }}" class="h-20 mb-2"> @endif
                    <input type="file" name="payment_proof" accept="image/*" class="w-full text-sm">
                </div>
            </div>

            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg text-blue-900">
                <p class="font-semibold mb-1"><i class="ri-bank-card-line mr-1"></i> Transfer biaya kartu anggota ke :</p>
                <p class="text-sm font-medium">Rek Bank Syariah Mandiri (BSI) : <span class="font-bold text-blue-700">7273362918</span></p>
                <p class="text-sm font-medium">An. <span class="font-bold">Suci Damaiyanti</span></p>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end">
            <button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">Simpan Profil</button>
        </div>
    </form>
</div>

<script>
async function loadKelurahans() {
    const kecId = document.getElementById('kecamatan_id').value;
    const kelSelect = document.getElementById('kelurahan_id');
    kelSelect.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';

    if (!kecId) return;

    const res = await fetch(`/admin/umkm/kecamatan/${kecId}/kelurahans`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
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
@endsection
