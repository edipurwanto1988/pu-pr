@extends('layouts.admin')

@section('content')
<div class="">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900"><i class="ri-arrow-left-line"></i></a>
        <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-add-circle-line mr-2"></i>Tambah User</h1>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf
        @if($errors->any())
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-user-line mr-1"></i>Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-mail-line mr-1"></i>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-lock-line mr-1"></i>Password</label>
            <input type="password" name="password" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-phone-line mr-1"></i>Telepon</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-shield-check-line mr-1"></i>Role</label>
            <select name="role_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                <option value="">Pilih Role</option>
                @foreach($roles as $role)
                    @if(in_array($role->slug, ['super-admin', 'umkm-ikm']))
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-toggle-line mr-1"></i>Status</label>
            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-image-line mr-1"></i>Avatar</label>
            <input type="file" name="avatar" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700">
        </div>
        <div class="flex gap-3 pt-2">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"><i class="ri-close-line mr-1"></i>Batal</a>
            <button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]"><i class="ri-save-line mr-1"></i>Simpan</button>
        </div>
    </form>
</div>
@endsection