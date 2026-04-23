@extends('layouts.admin')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">{{ $umkm->business_name }}</h1>
        <a href="{{ route('admin.umkm.index') }}" class="text-blue-600 hover:text-blue-900">Kembali</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Informasi Usaha</h2>
            <div class="space-y-3">
                <div><span class="text-gray-500">Tipe:</span> {{ strtoupper($umkm->type) }}</div>
                <div><span class="text-gray-500">Jenis:</span> {{ $umkm->business_type }}</div>
                <div><span class="text-gray-500">Alamat:</span> {{ $umkm->address }}</div>
                <div><span class="text-gray-500">Kecamatan:</span> {{ $umkm->kecamatan?->name ?? '-' }}</div>
                <div><span class="text-gray-500">Kelurahan:</span> {{ $umkm->kelurahan?->name ?? '-' }}</div>
                <div><span class="text-gray-500">Kode Pos:</span> {{ $umkm->postal_code }}</div>
                <div><span class="text-gray-500">Telepon:</span> {{ $umkm->phone }}</div>
                <div><span class="text-gray-500">WhatsApp:</span> {{ $umkm->whatsapp }}</div>
            </div>
            @if($umkm->description)
                <div class="mt-4 pt-4 border-t">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Deskripsi</h3>
                    <div class="prose max-w-none text-gray-600">{!! $umkm->description !!}</div>
                </div>
            @endif
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Status</h2>
            <div class="space-y-3">
                <div><span class="text-gray-500">Status:</span> {{ $umkm->status }}</div>
                <div><span class="text-gray-500">Dibuat:</span> {{ $umkm->created_at }}</div>
                @if($umkm->validated_at)
                    <div><span class="text-gray-500">Validasi:</span> {{ $umkm->validated_at }}</div>
                @endif
                @if($umkm->rejection_reason)
                    <div class="mt-4 p-3 bg-red-50 rounded"><span class="text-red-600">Alasan Penolakan: {{ $umkm->rejection_reason }}</span></div>
                @endif
            </div>
            @if($umkm->status === 'pending')
            <div class="mt-6 flex gap-3">
                <form action="{{ route('admin.umkm.approve', $umkm) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Setuju</button>
                </form>
                <button onclick="document.getElementById('reject-form').classList.toggle('hidden')" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Tolak</button>
            </div>
            <div id="reject-form" class="hidden mt-4">
                <form action="{{ route('admin.umkm.reject', $umkm) }}" method="POST">
                    @csrf
                    <textarea name="rejection_reason" placeholder="Alasan penolakan" class="w-full border rounded p-2 mb-2" required></textarea>
                    <button type="submit" class="w-full bg-red-600 text-white py-2 rounded">Tolak</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection