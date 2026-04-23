@extends('layouts.admin')
@section('content')
<div class="max-w-xl">
    <h1 class="text-2xl font-semibold mb-6">Tambah Partner</h1>
    <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf
        <div><label class="block text-sm font-medium mb-1">Nama</label><input type="text" name="name" class="w-full border rounded p-2" required></div>
        <div><label class="block text-sm font-medium mb-1">Logo</label><input type="file" name="logo" accept="image/*" class="block w-full" required></div>
        <div><label class="block text-sm font-medium mb-1">URL</label><input type="text" name="url" class="w-full border rounded p-2"></div>
        <div><label class="block text-sm font-medium mb-1">Urutan</label><input type="number" name="order" value="0" class="w-full border rounded p-2"></div>
        <div><label class="block text-sm font-medium mb-1">Status</label><select name="status" class="w-full border rounded p-2"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
        <div class="flex gap-3"><a href="{{ route('admin.partners.index') }}" class="px-4 py-2 border rounded">Batal</a><button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded">Simpan</button></div>
    </form>
</div>
@endsection