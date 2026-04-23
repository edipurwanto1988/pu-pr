@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-double-quotes-l mr-2"></i>Kata Tokoh</h1>
    <a href="{{ route('admin.kata-tokoh.create') }}" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">
        <i class="ri-add-line mr-1"></i> Tambah Kata Tokoh
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg"><i class="ri-check-line mr-1"></i>{{ session('success') }}</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urutan</th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($tokohs as $tokoh)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    @if($tokoh->foto)
                        <img src="{{ asset('storage/' . $tokoh->foto) }}" alt="{{ $tokoh->nama }}" class="w-12 h-12 rounded-full object-cover">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center"><i class="ri-user-line text-gray-400"></i></div>
                    @endif
                </td>
                <td class="px-4 py-3 font-medium text-gray-900">{{ $tokoh->nama }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $tokoh->jabatan }}</td>
                <td class="px-4 py-3 text-gray-600 text-sm truncate max-w-xs">{{ Str::limit($tokoh->deskripsi, 80) }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $tokoh->order }}</td>
                <td class="px-4 py-3 text-center">
                    <form action="{{ route('admin.kata-tokoh.toggle', $tokoh) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-3 py-1 rounded-full text-xs font-semibold {{ $tokoh->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $tokoh->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                        </button>
                    </form>
                </td>
                <td class="px-4 py-3 text-center whitespace-nowrap">
                    <a href="{{ route('admin.kata-tokoh.edit', $tokoh) }}" class="text-yellow-600 hover:text-yellow-900 mr-3" title="Edit"><i class="ri-edit-line"></i></a>
                    <form action="{{ route('admin.kata-tokoh.destroy', $tokoh) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus"><i class="ri-delete-bin-line"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                    <i class="ri-inbox-line text-3xl block mb-2"></i>Belum ada Kata Tokoh
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection