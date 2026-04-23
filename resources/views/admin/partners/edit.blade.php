@extends('layouts.admin')
@section('content')
<div class="max-w-xl">
    <h1 class="text-2xl font-semibold mb-6">Edit Partner</h1>
    <form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf @method('PUT')
        <div><label class="block text-sm font-medium mb-1">Nama</label><input type="text" name="name" value="{{ $partner->name }}" class="w-full border rounded p-2" required></div>
        <div>@if($partner->logo)<img src="{{ asset('storage/' . $partner->logo) }}" class="h-16 mb-2">@endif<label class="block text-sm font-medium mb-1">Logo</label><input type="file" name="logo" accept="image/*" class="block w-full"></div>
        <div><label class="block text-sm font-medium mb-1">URL</label><input type="text" name="url" value="{{ $partner->url }}" class="w-full border rounded p-2"></div>
        <div><label class="block text-sm font-medium mb-1">Urutan</label><input type="number" name="order" value="{{ $partner->order }}" class="w-full border rounded p-2"></div>
        <div><label class="block text-sm font-medium mb-1">Status</label><select name="status" class="w-full border rounded p-2"><option value="active" {{ $partner->status === 'active' ? 'selected' : '' }}>Active</option><option value="inactive" {{ $partner->status === 'inactive' ? 'selected' : '' }}>Inactive</option></select></div>
        <div class="flex gap-3"><a href="{{ route('admin.partners.index') }}" class="px-4 py-2 border rounded">Batal</a><button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded">Simpan</button></div>
    </form>
</div>
@endsection