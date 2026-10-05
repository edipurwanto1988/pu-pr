@extends('layouts.admin')

@section('title', 'Kelola Dewan Pengurus')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-gray-700 text-3xl font-medium">Dewan Pengurus</h3>
        <a href="{{ route('admin.board-members.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
            <i class="ri-add-line mr-1"></i> Tambah Pengurus
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <p class="p-4 bg-gray-50 text-sm text-gray-600 border-b"><i class="ri-information-line text-blue-500 mr-1"></i> Anda dapat mengubah urutan tampilan dengan men-drag and drop (geser) baris di bawah ini.</p>
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            #
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Foto
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Nama Lengkap
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Jabatan
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody id="sortable-board-members">
                    @foreach($members as $member)
                        <tr data-id="{{ $member->id }}" class="hover:bg-gray-50 bg-white">
                            <td class="px-5 py-4 border-b border-gray-200 text-sm cursor-move drag-handle text-gray-400 hover:text-gray-600">
                                <i class="ri-drag-move-2-fill text-xl"></i>
                            </td>
                            <td class="px-5 py-4 border-b border-gray-200 text-sm">
                                @if($member->photo_id)
                                    <img src="{{ \App\Services\GoogleDriveService::getUrl($member->photo_id) }}" alt="{{ $member->name }}" class="w-12 h-12 rounded-full object-cover shadow-sm border border-gray-200">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 shadow-sm border border-gray-200">
                                        <i class="ri-user-fill text-xl"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-4 border-b border-gray-200 text-sm">
                                <p class="text-gray-900 font-semibold whitespace-no-wrap">{{ $member->name }}</p>
                            </td>
                            <td class="px-5 py-4 border-b border-gray-200 text-sm">
                                <p class="text-gray-600 whitespace-no-wrap">{{ $member->position }}</p>
                            </td>
                            <td class="px-5 py-4 border-b border-gray-200 text-sm text-right">
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('admin.board-members.edit', $member) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors" title="Edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <form action="{{ route('admin.board-members.destroy', $member) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Hapus">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if($members->isEmpty())
                        <tr>
                            <td colspan="5" class="px-5 py-8 border-b border-gray-200 text-sm text-center text-gray-500">
                                Belum ada data anggota dewan pengurus.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var el = document.getElementById('sortable-board-members');
        if (el && el.children.length > 0) {
            var sortable = Sortable.create(el, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'bg-blue-50',
                onEnd: function (evt) {
                    var order = [];
                    var rows = el.querySelectorAll('tr');
                    rows.forEach(function (row) {
                        if(row.dataset.id) {
                            order.push(row.dataset.id);
                        }
                    });

                    fetch('{{ route('admin.board-members.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ order: order })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            // Optional: Show a subtle toast or notification
                        } else {
                            alert('Terjadi kesalahan saat menyimpan urutan.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });
        }
    });
</script>
@endpush
@endsection
