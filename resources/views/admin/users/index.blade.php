@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-user-line mr-2"></i>Manajemen User</h1>
    <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">
        <i class="ri-add-line mr-1"></i> Tambah User
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg"><i class="ri-check-line mr-1"></i>{{ session('success') }}</div>
@endif

<form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 bg-white rounded-lg shadow p-4">
    <div class="flex flex-wrap gap-2 items-end">
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, email, telepon..." class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-9 w-56 text-sm">
        </div>
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">Role</label>
            <select name="role_id" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-9 text-sm">
                <option value="">Semua Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-9 text-sm">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">&nbsp;</label>
            <div class="flex gap-2">
                <button type="submit" class="px-3 bg-[#ca4e33] text-white rounded-md hover:bg-[#b8432b] h-9 text-sm"><i class="ri-search-line mr-1"></i>Filter</button>
                <a href="{{ route('admin.users.index') }}" class="px-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 h-9 text-sm inline-flex items-center"><i class="ri-refresh-line mr-1"></i>Reset</a>
            </div>
        </div>
    </div>
</form>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">UMKM/IKM</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terdaftar</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-9 h-9 rounded-full object-cover">
                            @else
                                <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold text-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="font-medium text-gray-800">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            {{ $user->role?->name ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        @if($user->umkmProfile)
                            <span class="text-blue-600">{{ $user->umkmProfile->business_name }}</span>
                            <span class="text-gray-400 ml-1">({{ $user->umkmProfile->type }})</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $user->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-900 mr-3" title="Edit"><i class="ri-edit-line"></i></a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus user ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus"><i class="ri-delete-bin-line"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500"><i class="ri-inbox-line text-3xl block mb-2"></i>Tidak ada user ditemukan</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $users->withQueryString()->links() }}
</div>
@endsection