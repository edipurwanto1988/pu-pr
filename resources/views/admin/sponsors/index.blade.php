@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-trophy-line mr-2"></i>Sponsor</h1>
    <a href="{{ route('admin.sponsors.create') }}" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">
        <i class="ri-add-line mr-1"></i> Tambah Sponsor
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg"><i class="ri-check-line mr-1"></i>{{ session('success') }}</div>
@endif

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @forelse($sponsors as $sponsor)
        <div class="bg-white rounded-lg shadow p-4">
            <img src="{{ asset($sponsor->logo) }}" class="h-16 w-full object-contain mb-2">
            <div class="flex justify-between">
                <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit"><i class="ri-edit-line mr-1"></i>Edit</a>
                <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST" onsubmit="return confirm('Yakin?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-900" title="Hapus"><i class="ri-delete-bin-line mr-1"></i>Hapus</button></form>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-8 text-gray-500"><i class="ri-inbox-line text-3xl block mb-2"></i>Belum ada sponsor</div>
    @endforelse
</div>
@endsection