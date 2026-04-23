@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-store-line mr-2"></i>UMKM/IKM</h1>
    @php $canCreate = true; @endphp
    @if(auth()->user()->hasRole('umkm-ikm'))
        @php $umkmCount = \App\Models\UmkmProfile::where('user_id', auth()->id())->count(); @endphp
        @if($umkmCount >= 3)
            @php $canCreate = false; @endphp
        @endif
    @endif
    @if($canCreate)
    <a href="{{ route('admin.umkm.create') }}" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">
        <i class="ri-add-line mr-1"></i> Tambah UMKM/IKM
    </a>
    @endif
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg"><i class="ri-check-line mr-1"></i>{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg"><i class="ri-error-warning-line mr-1"></i>{{ session('error') }}</div>
@endif

<form method="GET" action="{{ route('admin.umkm.index') }}" class="mb-4 bg-white rounded-lg shadow p-4">
    <div class="flex flex-wrap gap-2 items-end">
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama usaha, pemilik..." class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-9 w-56 text-sm">
        </div>
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">Jenis</label>
            <select name="type" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-9 text-sm">
                <option value="">Semua</option>
                <option value="umkm" {{ request('type') === 'umkm' ? 'selected' : '' }}>UMKM</option>
                <option value="ikm" {{ request('type') === 'ikm' ? 'selected' : '' }}>IKM</option>
            </select>
        </div>
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">Kecamatan</label>
            <select name="kecamatan_id" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-9 text-sm">
                <option value="">Semua</option>
                @foreach($kecamatans as $k)
                    <option value="{{ $k->id }}" {{ request('kecamatan_id') == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-9 text-sm">
                <option value="">Semua</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">&nbsp;</label>
            <div class="flex gap-2">
                <button type="submit" class="px-3 bg-[#ca4e33] text-white rounded-md hover:bg-[#b8432b] h-9 text-sm"><i class="ri-search-line mr-1"></i>Filter</button>
                <a href="{{ route('admin.umkm.index') }}" class="px-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 h-9 text-sm inline-flex items-center"><i class="ri-refresh-line mr-1"></i>Reset</a>
            </div>
        </div>
    </div>
</form>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Usaha</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemilik</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kecamatan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($umkm as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $item->business_name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $item->user?->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $item->kecamatan?->name ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->type === 'umkm' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                            {{ strtoupper($item->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($item->status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Pending</span>
                        @elseif($item->status === 'approved')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Approved</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Rejected</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <a href="{{ route('admin.umkm.show', $item) }}" class="text-blue-600 hover:text-blue-900 mr-3" title="Lihat"><i class="ri-eye-line"></i></a>
                        <a href="{{ route('admin.umkm.edit', $item) }}" class="text-yellow-600 hover:text-yellow-900 mr-3" title="Edit"><i class="ri-edit-line"></i></a>
                        @if($item->status === 'pending')
                            <form action="{{ route('admin.umkm.approve', $item) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-emerald-600 hover:text-emerald-900 mr-2" title="Setujui"><i class="ri-check-line"></i></button>
                            </form>
                            <button type="button" onclick="document.getElementById('reject-{{ $item->id }}').classList.toggle('hidden')" class="text-red-600 hover:text-red-900" title="Tolak"><i class="ri-close-line"></i></button>
                            <div id="reject-{{ $item->id }}" class="hidden absolute bg-white border shadow-lg rounded-lg p-4 mt-2 right-20 z-10 w-64">
                                <form action="{{ route('admin.umkm.reject', $item) }}" method="POST">
                                    @csrf
                                    <textarea name="rejection_reason" placeholder="Alasan penolakan" class="w-full border rounded p-2 text-sm mb-2" required></textarea>
                                    <button type="submit" class="w-full bg-red-600 text-white py-1 rounded text-sm">Tolak</button>
                                </form>
                            </div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500"><i class="ri-inbox-line text-3xl block mb-2"></i>Belum ada UMKM/IKM</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $umkm->withQueryString()->links() }}
</div>

@if(auth()->user()->hasRole('umkm-ikm'))
<div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-lg text-sm text-amber-700">
    <i class="ri-information-line mr-1"></i> Batas maksimal data UMKM/IKM yang dapat Anda buat adalah <strong>3 data</strong>. Saat ini Anda sudah membuat <strong>{{ $umkm->total() }} dari 3</strong> data.
</div>
@endif
@endsection