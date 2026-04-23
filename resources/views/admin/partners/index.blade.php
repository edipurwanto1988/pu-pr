@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-links-line mr-2"></i>Partner</h1>
    <a href="{{ route('admin.partners.create') }}" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">Tambah</a>
</div>
@if(session('success'))<div class="mb-4 p-4 bg-green-100 rounded-lg">{{ session('success') }}</div>@endif
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @forelse($partners as $partner)
        <div class="bg-white rounded-lg shadow p-4">
            <img src="{{ asset('storage/' . $partner->logo) }}" class="h-16 w-full object-contain mb-2">
            <div class="flex justify-between">
                <a href="{{ route('admin.partners.edit', $partner) }}" class="text-blue-600">Edit</a>
                <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST">@csrf @method('DELETE')<button type="submit" class="text-red-600" onclick="return confirm('Yakin?')">Hapus</button></form>
            </div>
        </div>
    @empty<div class="col-span-full text-center py-8 text-gray-500">Belum ada partner</div>
    @endforelse
</div>
@endsection