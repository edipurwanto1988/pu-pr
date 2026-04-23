@extends('layouts.admin')

@section('content')
<div class="">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900"><i class="ri-arrow-left-line"></i></a>
        <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-edit-line mr-2"></i>Edit User</h1>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf @method('PUT')
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
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-mail-line mr-1"></i>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-lock-line mr-1"></i>Password</label>
            <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-phone-line mr-1"></i>Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-shield-check-line mr-1"></i>Role</label>
            <select name="role_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                <option value="">Pilih Role</option>
                @foreach($roles as $role)
                    @if(in_array($role->slug, ['super-admin', 'umkm-ikm']))
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-toggle-line mr-1"></i>Status</label>
            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-image-line mr-1"></i>Avatar</label>
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="h-16 w-16 rounded-full object-cover mb-2">
            @endif
            <input type="file" name="avatar" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700">
        </div>

        @if($user->umkmProfile)
        <div class="border-t pt-4 mt-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-3"><i class="ri-store-line mr-1"></i>Profil UMKM/IKM</h3>
            <div class="bg-gray-50 rounded-lg p-4 space-y-2 text-sm">
                <div><span class="text-gray-500">Nama Usaha:</span> <span class="font-medium">{{ $user->umkmProfile->business_name }}</span></div>
                <div><span class="text-gray-500">Jenis:</span> <span class="font-medium">{{ $user->umkmProfile->type === 'umkm' ? 'UMKM' : 'IKM' }}</span></div>
                <div><span class="text-gray-500">Tipe:</span> <span class="font-medium">{{ $user->umkmProfile->business_type === 'produk' ? 'Produk' : 'Jasa' }}</span></div>
                <div><span class="text-gray-500">Status:</span> <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $user->umkmProfile->status === 'approved' ? 'bg-emerald-50 text-emerald-700' : ($user->umkmProfile->status === 'pending' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700') }}">{{ $user->umkmProfile->status }}</span></div>
                @if($user->umkmProfile->phone)<div><span class="text-gray-500">Telepon:</span> {{ $user->umkmProfile->phone }}</div>@endif
                @if($user->umkmProfile->whatsapp)<div><span class="text-gray-500">WhatsApp:</span> {{ $user->umkmProfile->whatsapp }}</div>@endif
            </div>
        </div>
        @endif

        <div class="flex gap-3 pt-2">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"><i class="ri-close-line mr-1"></i>Batal</a>
            <button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]"><i class="ri-save-line mr-1"></i>Simpan</button>
        </div>
    </form>
</div>
@endsection