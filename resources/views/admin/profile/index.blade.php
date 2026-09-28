@extends('layouts.admin')

@section('content')
<div class="mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 flex items-center">
        <i class="ri-user-settings-line mr-2 text-[#ca4e33]"></i>Profil UMKM/IKM
    </h1>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-300 text-green-800 rounded-lg text-sm flex items-center gap-2">
        <i class="ri-check-line text-lg text-green-600 shrink-0"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 lg:p-8">
    <form action="{{ route('admin.profile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="space-y-4 sm:space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">No. KTA</label>
                    <input type="text" name="kta_number" value="{{ old('kta_number', $profile->kta_number) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#ca4e33] focus:ring-[#ca4e33] text-sm" placeholder="Masukkan No. KTA">
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">NO NIK KTP</label>
                    <input type="text" name="nik_number" value="{{ old('nik_number', $profile->nik_number) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#ca4e33] focus:ring-[#ca4e33] text-sm" placeholder="Masukkan NO NIK KTP">
                </div>
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">NAMA PELAKU USAHA</label>
                <input type="text" name="business_actor_name" value="{{ old('business_actor_name', $profile->business_actor_name) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#ca4e33] focus:ring-[#ca4e33] text-sm" placeholder="Nama Pelaku Usaha">
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">NIB (BAGI YANG ADA)</label>
                <input type="text" name="nib" value="{{ old('nib', $profile->nib) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#ca4e33] focus:ring-[#ca4e33] text-sm" placeholder="Nomor Induk Berusaha (opsional)">
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">JENIS USAHA</label>
                <select name="business_type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#ca4e33] focus:ring-[#ca4e33] text-sm">
                    <option value="">-- Pilih Jenis Usaha --</option>
                    @foreach(['Usaha kuliner', 'Usaha fashion', 'Usaha agribisnis', 'Usaha elektronik', 'Usaha furniture', 'Usaha bidang jasa', 'UMKM berbasis digital', 'UMKM produk kecantikan'] as $type)
                        <option value="{{ $type }}" {{ old('business_type', $profile->business_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">JENIS TEMPAT USAHA</label>
                    <select name="business_place_type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#ca4e33] focus:ring-[#ca4e33] text-sm">
                        <option value="">-- Pilih Jenis Tempat Usaha --</option>
                        <option value="BERGERAK" {{ old('business_place_type', $profile->business_place_type) == 'BERGERAK' ? 'selected' : '' }}>BERGERAK</option>
                        <option value="TIDAK BERGERAK" {{ old('business_place_type', $profile->business_place_type) == 'TIDAK BERGERAK' ? 'selected' : '' }}>TIDAK BERGERAK</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">KATEGORI USAHA</label>
                    <select name="business_category" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#ca4e33] focus:ring-[#ca4e33] text-sm">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="UMKM" {{ old('business_category', $profile->business_category) == 'UMKM' ? 'selected' : '' }}>UMKM</option>
                        <option value="IKM" {{ old('business_category', $profile->business_category) == 'IKM' ? 'selected' : '' }}>IKM</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">ALAMAT (Jalan)</label>
                <textarea name="address" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#ca4e33] focus:ring-[#ca4e33] text-sm" placeholder="Nama Jalan, RT/RW, No. Rumah">{{ old('address', $profile->address) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Kecamatan</label>
                    <select name="kecamatan_id" id="kecamatan_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#ca4e33] focus:ring-[#ca4e33] text-sm" onchange="loadKelurahans()">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($kecamatans as $kec)
                            <option value="{{ $kec->id }}" {{ old('kecamatan_id', $profile->kecamatan_id) == $kec->id ? 'selected' : '' }}>{{ $kec->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Kelurahan</label>
                    <select name="kelurahan_id" id="kelurahan_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#ca4e33] focus:ring-[#ca4e33] text-sm">
                        <option value="">-- Pilih Kelurahan --</option>
                        @foreach($kelurahans as $kel)
                            <option value="{{ $kel->id }}" {{ old('kelurahan_id', $profile->kelurahan_id) == $kel->id ? 'selected' : '' }}>{{ $kel->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">NO WA</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $profile->whatsapp) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#ca4e33] focus:ring-[#ca4e33] text-sm" placeholder="Contoh: 08123456789">
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Omset perbulan</label>
                    <input type="text" name="monthly_turnover" value="{{ old('monthly_turnover', $profile->monthly_turnover) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#ca4e33] focus:ring-[#ca4e33] text-sm" placeholder="Contoh: Rp 10.000.000">
                </div>
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">PRODUK USAHA</label>
                <input type="text" name="business_products" value="{{ old('business_products', $profile->business_products) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#ca4e33] focus:ring-[#ca4e33] text-sm" placeholder="Produk atau layanan yang dijual">
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-sm sm:text-base font-semibold text-gray-800 mb-3"><i class="ri-attachment-line mr-1 text-[#ca4e33]"></i> Dokumen & Bukti Transfer</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 flex flex-col justify-between">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">KIRIM FOTO KTP</label>
                            @if($profile->ktp_photo)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $profile->ktp_photo) }}" class="h-24 w-full object-cover rounded-lg border border-gray-200">
                                </div>
                            @endif
                        </div>
                        <input type="file" name="ktp_photo" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-white file:text-gray-700 file:border-gray-200 hover:file:bg-gray-100 cursor-pointer">
                    </div>

                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 flex flex-col justify-between">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">KIRIM FOTO WAJAH</label>
                            @if($profile->face_photo)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $profile->face_photo) }}" class="h-24 w-full object-cover rounded-lg border border-gray-200">
                                </div>
                            @endif
                        </div>
                        <input type="file" name="face_photo" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-white file:text-gray-700 file:border-gray-200 hover:file:bg-gray-100 cursor-pointer">
                    </div>

                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 flex flex-col justify-between sm:col-span-2 lg:col-span-1">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">KIRIM BUKTI PEMBAYARAN</label>
                            @if($profile->payment_proof)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $profile->payment_proof) }}" class="h-24 w-full object-cover rounded-lg border border-gray-200">
                                </div>
                            @endif
                        </div>
                        <input type="file" name="payment_proof" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-white file:text-gray-700 file:border-gray-200 hover:file:bg-gray-100 cursor-pointer">
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-5 bg-blue-50/80 border border-blue-200 rounded-xl text-blue-900">
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg shrink-0">
                        <i class="ri-bank-card-line text-xl"></i>
                    </div>
                    <div class="space-y-1 min-w-0">
                        <p class="font-semibold text-sm sm:text-base text-blue-950">Transfer biaya kartu anggota ke :</p>
                        <p class="text-xs sm:text-sm text-blue-900">Rek Bank Syariah Mandiri (BSI) : <span class="font-bold text-blue-700 text-sm sm:text-base tracking-wide select-all">7273362918</span></p>
                        <p class="text-xs sm:text-sm text-blue-900">An. <span class="font-bold text-blue-950">Suci Damaiyanti</span></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6 sm:mt-8 flex justify-end">
            <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-[#ca4e33] hover:bg-[#b8432b] text-white rounded-lg font-medium shadow-sm transition-all duration-200 flex items-center justify-center gap-2">
                <i class="ri-save-line text-lg"></i> Simpan Profil
            </button>
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
