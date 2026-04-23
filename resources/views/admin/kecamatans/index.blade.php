@extends('layouts.admin')

@section('title', 'Kecamatan')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-map-pin-line mr-2"></i>Kecamatan</h1>
    <a href="{{ route('admin.kecamatans.create') }}" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">
        <i class="ri-add-line mr-1"></i> Tambah Kecamatan
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg"><i class="ri-check-line mr-1"></i>{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg"><i class="ri-error-warning-line mr-1"></i>{{ session('error') }}</div>
@endif

<form method="GET" action="{{ route('admin.kecamatans.index') }}" class="mb-4 bg-white rounded-lg shadow p-4">
    <div class="flex flex-wrap gap-2 items-end">
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama kecamatan..." class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-9 w-56 text-sm">
        </div>
        <div class="flex flex-col">
            <label class="block text-xs font-medium text-gray-500 mb-1">&nbsp;</label>
            <div class="flex gap-2">
                <button type="submit" class="px-3 bg-[#ca4e33] text-white rounded-md hover:bg-[#b8432b] h-9 text-sm"><i class="ri-search-line mr-1"></i>Filter</button>
                <a href="{{ route('admin.kecamatans.index') }}" class="px-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 h-9 text-sm inline-flex items-center"><i class="ri-refresh-line mr-1"></i>Reset</a>
            </div>
        </div>
    </div>
</form>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kecamatan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Kelurahan</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($kecamatans as $index => $kecamatan)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-500">{{ $kecamatans->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <button onclick="showKelurahans({{ $kecamatan->id }}, '{{ addslashes($kecamatan->name) }}')" class="font-medium text-blue-600 hover:text-blue-800 hover:underline cursor-pointer">
                            {{ $kecamatan->name }}
                        </button>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $kecamatan->kelurahans_count }}</td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <a href="{{ route('admin.kecamatans.edit', $kecamatan) }}" class="text-yellow-600 hover:text-yellow-900 mr-3" title="Edit"><i class="ri-edit-line"></i></a>
                        <form action="{{ route('admin.kecamatans.destroy', $kecamatan) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kecamatan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus"><i class="ri-delete-bin-line"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500"><i class="ri-inbox-line text-3xl block mb-2"></i>Belum ada kecamatan</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $kecamatans->withQueryString()->links() }}
</div>

<div id="kelurahan-modal-overlay" class="fixed inset-0 bg-black/50 z-50 hidden" onclick="closeKelurahanModal()"></div>
<div id="kelurahan-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800"><i class="ri-home-line mr-2"></i>Kelurahan di Kecamatan <span id="kecamatan-name-modal"></span></h3>
            <button type="button" onclick="closeKelurahanModal()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-500 hover:text-gray-700">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>

        <div class="px-4 pt-3">
            <div class="flex gap-2">
                <input type="text" id="new-kelurahan-name" placeholder="Nama kelurahan baru..." class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-9 text-sm" onkeydown="if(event.key==='Enter'){event.preventDefault();addKelurahan();}">
                <button onclick="addKelurahan()" class="px-4 py-1.5 bg-[#ca4e33] text-white rounded-md hover:bg-[#b8432b] text-sm whitespace-nowrap"><i class="ri-add-line mr-1"></i>Tambah</button>
            </div>
            <div id="add-error" class="hidden text-sm text-red-600 bg-red-50 rounded-md p-2 mt-2"></div>
        </div>

        <div class="p-4 overflow-y-auto flex-1">
            <div id="kelurahan-list" class="space-y-1">
                <p class="text-gray-400 text-center py-4">Memuat data...</p>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="current-kecamatan-id">
@endsection

@section('scripts')
<script>
let currentKecamatanId = null;

async function showKelurahans(kecamatanId, kecamatanName) {
    currentKecamatanId = kecamatanId;
    document.getElementById('current-kecamatan-id').value = kecamatanId;
    document.getElementById('kecamatan-name-modal').textContent = kecamatanName;
    document.getElementById('kelurahan-modal-overlay').classList.remove('hidden');
    document.getElementById('kelurahan-modal').classList.remove('hidden');
    document.getElementById('new-kelurahan-name').value = '';
    document.getElementById('add-error').classList.add('hidden');
    await loadKelurahans(kecamatanId);
}

async function loadKelurahans(kecamatanId) {
    document.getElementById('kelurahan-list').innerHTML = '<p class="text-gray-400 text-center py-4"><i class="ri-loader-4-line ri-spin mr-1"></i>Memuat data...</p>';

    try {
        const res = await fetch(`/admin/kecamatans/${kecamatanId}/kelurahans`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        const kelurahans = await res.json();
        renderKelurahanList(kelurahans);
    } catch (e) {
        document.getElementById('kelurahan-list').innerHTML = '<p class="text-red-500 text-center py-4">Gagal memuat data kelurahan.</p>';
    }
}

function renderKelurahanList(kelurahans) {
    if (kelurahans.length === 0) {
        document.getElementById('kelurahan-list').innerHTML = '<p class="text-gray-400 text-center py-4">Belum ada kelurahan. Tambahkan menggunakan form di atas.</p>';
        return;
    }

    let html = '';
    kelurahans.forEach((kel, i) => {
        html += `<div class="flex items-center gap-2 px-3 py-2 bg-gray-50 rounded-lg group" id="kel-row-${kel.id}">
            <span class="text-gray-400 text-sm w-6">${i + 1}.</span>
            <span id="kel-text-${kel.id}" class="flex-1 text-sm text-gray-700">${kel.name}</span>
            <div id="kel-edit-${kel.id}" class="hidden flex-1 flex gap-2">
                <input type="text" id="kel-input-${kel.id}" value="${kel.name}" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-8 text-sm" onkeydown="if(event.key==='Enter'){event.preventDefault();saveKelurahan(${kel.id});}if(event.key==='Escape'){cancelEdit(${kel.id},'${kel.name.replace(/'/g, "\\'")}');}">
            </div>
            <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity" id="kel-actions-${kel.id}">
                <button onclick="editKelurahan(${kel.id}, '${kel.name.replace(/'/g, "\\'")}')" class="w-7 h-7 flex items-center justify-center rounded hover:bg-yellow-100 text-yellow-600 hover:text-yellow-800" title="Edit"><i class="ri-edit-line text-sm"></i></button>
                <button onclick="deleteKelurahan(${kel.id})" class="w-7 h-7 flex items-center justify-center rounded hover:bg-red-100 text-red-600 hover:text-red-800" title="Hapus"><i class="ri-delete-bin-line text-sm"></i></button>
            </div>
            <div class="flex gap-1 hidden" id="kel-edit-actions-${kel.id}">
                <button onclick="saveKelurahan(${kel.id})" class="w-7 h-7 flex items-center justify-center rounded hover:bg-green-100 text-green-600 hover:text-green-800" title="Simpan"><i class="ri-check-line text-sm"></i></button>
                <button onclick="cancelEdit(${kel.id}, '${kel.name.replace(/'/g, "\\'")}')" class="w-7 h-7 flex items-center justify-center rounded hover:bg-gray-200 text-gray-600 hover:text-gray-800" title="Batal"><i class="ri-close-line text-sm"></i></button>
            </div>
        </div>`;
    });
    document.getElementById('kelurahan-list').innerHTML = html;
}

function editKelurahan(id, name) {
    document.getElementById('kel-text-' + id).classList.add('hidden');
    document.getElementById('kel-edit-' + id).classList.remove('hidden');
    document.getElementById('kel-actions-' + id).classList.add('hidden');
    document.getElementById('kel-edit-actions-' + id).classList.remove('hidden');
    document.getElementById('kel-input-' + id).focus();
    document.getElementById('kel-input-' + id).select();
}

function cancelEdit(id) {
    document.getElementById('kel-text-' + id).classList.remove('hidden');
    document.getElementById('kel-edit-' + id).classList.add('hidden');
    document.getElementById('kel-actions-' + id).classList.remove('hidden');
    document.getElementById('kel-edit-actions-' + id).classList.add('hidden');
}

async function saveKelurahan(id) {
    const name = document.getElementById('kel-input-' + id).value.trim();
    if (!name) return;

    try {
        const res = await fetch(`/admin/kelurahans-ajax/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ name })
        });

        if (res.ok) {
            await loadKelurahans(currentKecamatanId);
            updateCountOnPage();
        }
    } catch (e) {
        console.error('Gagal menyimpan:', e);
    }
}

async function deleteKelurahan(id) {
    if (!confirm('Yakin hapus kelurahan ini?')) return;

    try {
        const res = await fetch(`/admin/kelurahans-ajax/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (res.ok) {
            await loadKelurahans(currentKecamatanId);
            updateCountOnPage();
        }
    } catch (e) {
        console.error('Gagal menghapus:', e);
    }
}

async function addKelurahan() {
    const name = document.getElementById('new-kelurahan-name').value.trim();
    const errorEl = document.getElementById('add-error');
    errorEl.classList.add('hidden');

    if (!name) {
        errorEl.textContent = 'Nama kelurahan wajib diisi.';
        errorEl.classList.remove('hidden');
        return;
    }

    try {
        const res = await fetch('{{ route("admin.kelurahans.ajax-store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                kecamatan_id: currentKecamatanId,
                name: name
            })
        });

        if (res.ok) {
            document.getElementById('new-kelurahan-name').value = '';
            await loadKelurahans(currentKecamatanId);
            updateCountOnPage();
        } else {
            const data = await res.json();
            errorEl.textContent = Object.values(data.errors || {}).flat().join(', ') || 'Gagal menambahkan kelurahan.';
            errorEl.classList.remove('hidden');
        }
    } catch (e) {
        errorEl.textContent = 'Gagal menambahkan kelurahan.';
        errorEl.classList.remove('hidden');
    }
}

function updateCountOnPage() {
    const count = document.getElementById('kelurahan-list').querySelectorAll('[id^="kel-row-"]').length;
}

function closeKelurahanModal() {
    document.getElementById('kelurahan-modal-overlay').classList.add('hidden');
    document.getElementById('kelurahan-modal').classList.add('hidden');
    location.reload();
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeKelurahanModal();
});
</script>
@endsection