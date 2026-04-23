@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-menu-line mr-2"></i>Menu</h1>
    <a href="{{ route('admin.menus.create') }}" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">
        <i class="ri-add-line mr-1"></i> Tambah Menu
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg"><i class="ri-check-line mr-1"></i>{{ session('success') }}</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-3 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
        <span class="text-sm text-gray-500"><i class="ri-drag-move-line mr-1"></i>Drag & drop untuk menyusun urutan</span>
        <span id="save-indicator" class="text-sm text-green-600 hidden"><i class="ri-check-line mr-1"></i>Urutan tersimpan</span>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-8"></th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">URL</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Parent</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200" id="menu-list">
            @forelse($menus as $menu)
                <tr data-id="{{ $menu->id }}" class="menu-row hover:bg-gray-50">
                    <td class="px-4 py-4"><i class="ri-drag-move-line text-gray-400 cursor-move"></i></td>
                    <td class="px-6 py-4 font-medium">{{ $menu->title }}</td>
                    <td class="px-6 py-4 text-gray-500 text-sm">{{ $menu->url }}</td>
                    <td class="px-6 py-4 text-gray-500">-</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $menu->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $menu->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        @if($menu->icon)<i class="{{ $menu->icon }} mr-2 text-gray-400"></i>@endif
                        <a href="{{ route('admin.menus.edit', $menu) }}" class="text-yellow-600 hover:text-yellow-900 mr-3"><i class="ri-edit-line"></i></a>
                        <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin hapus?')"><i class="ri-delete-bin-line"></i></button>
                        </form>
                    </td>
                </tr>
                @foreach($menu->children as $child)
                <tr data-id="{{ $child->id }}" data-parent="{{ $menu->id }}" class="menu-child-row hover:bg-gray-50">
                    <td class="px-4 py-4 pl-8"><i class="ri-drag-move-line text-gray-300 cursor-move"></i></td>
                    <td class="px-6 py-4">↳ {{ $child->title }}</td>
                    <td class="px-6 py-4 text-gray-500 text-sm">{{ $child->url }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $menu->title }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $child->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $child->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        @if($child->icon)<i class="{{ $child->icon }} mr-2 text-gray-400"></i>@endif
                        <a href="{{ route('admin.menus.edit', $child) }}" class="text-yellow-600 hover:text-yellow-900 mr-3"><i class="ri-edit-line"></i></a>
                        <form action="{{ route('admin.menus.destroy', $child) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin hapus?')"><i class="ri-delete-bin-line"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500"><i class="ri-inbox-line text-3xl block mb-2"></i>Belum ada menu</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
<script>
new Sortable(document.getElementById('menu-list'), {
    handle: '.cursor-move',
    animation: 150,
    onEnd: function() {
        const rows = document.querySelectorAll('#menu-list tr[data-id]');
        const order = [];
        rows.forEach((row, index) => {
            order.push({ id: row.dataset.id });
        });
        fetch('{{ route("admin.menus.reorder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ order })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const ind = document.getElementById('save-indicator');
                ind.classList.remove('hidden');
                setTimeout(() => ind.classList.add('hidden'), 2000);
            }
        });
    }
});
</script>
@endsection