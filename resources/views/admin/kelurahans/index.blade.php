@extends('layouts.admin')

@section('title', 'Kelurahan')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-home-line mr-2"></i>Kelurahan/Desa</h1>
    <a href="{{ route('admin.kelurahans.create') }}" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">
        <i class="ri-add-line mr-1"></i> Tambah Kelurahan
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg"><i class="ri-check-line mr-1"></i>{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg"><i class="ri-error-warning-line mr-1"></i>{{ session('error') }}</div>
@endif

<form method="GET" action="{{ route('admin.kelurahans.index') }}" class="mb-4 bg-white rounded-lg shadow p-4">
    <div class="flex flex-wrap gap-2 items-end">
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama kelurahan..." class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-9 w-56 text-sm">
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
            <label class="block text-xs font-medium text-gray-500 mb-1">&nbsp;</label>
            <div class="flex gap-2">
                <button type="submit" class="px-3 bg-[#ca4e33] text-white rounded-md hover:bg-[#b8432b] h-9 text-sm"><i class="ri-search-line mr-1"></i>Filter</button>
                <a href="{{ route('admin.kelurahans.index') }}" class="px-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 h-9 text-sm inline-flex items-center"><i class="ri-refresh-line mr-1"></i>Reset</a>
            </div>
        </div>
    </div>
</form>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kelurahan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kecamatan</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($kelurahans as $index => $kelurahan)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-500">{{ $kelurahans->firstItem() + $index }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $kelurahan->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $kelurahan->kecamatan?->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <a href="{{ route('admin.kelurahans.edit', $kelurahan) }}" class="text-yellow-600 hover:text-yellow-900 mr-3" title="Edit"><i class="ri-edit-line"></i></a>
                        <form action="{{ route('admin.kelurahans.destroy', $kelurahan) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kelurahan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus"><i class="ri-delete-bin-line"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500"><i class="ri-inbox-line text-3xl block mb-2"></i>Belum ada kelurahan</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $kelurahans->withQueryString()->links() }}
</div>
@endsection