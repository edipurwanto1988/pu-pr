@extends('layouts.admin')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-settings-3-line mr-2"></i>Pengaturan</h1>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <div class="border-b border-gray-200">
            <nav data-tabs-nav class="-mb-px flex space-x-8 px-6 overflow-x-auto">
                <a href="#umum" id="tab-link-umum" class="border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors" onclick="showTab('umum'); return false;">
                    <i class="ri-settings-3-line mr-1"></i> Umum
                </a>
                <a href="#seo" id="tab-link-seo" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors" onclick="showTab('seo'); return false;">
                    <i class="ri-seo-line mr-1"></i> SEO
                </a>
                <a href="#sosialmedia" id="tab-link-sosial_media" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors" onclick="showTab('sosial_media'); return false;">
                    <i class="ri-share-line mr-1"></i> Sosial Media
                </a>
                <a href="#googledrive" id="tab-link-google_drive" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors" onclick="showTab('google_drive'); return false;">
                    <i class="ri-drive-line mr-1"></i> Google Drive
                </a>
            </nav>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="active_tab" id="active_tab" value="umum">

            <div class="p-6 space-y-6">
                @foreach($tabs as $tab)
                <div id="tab-pane-{{ $tab }}" class="tab-pane {{ $loop->first ? '' : 'hidden' }}">
                    @if($tab === 'google_drive')
                        <div class="mb-5 p-3.5 bg-amber-50 border border-amber-200 text-amber-800 rounded-lg text-sm flex items-center gap-2">
                            <i class="ri-lock-line text-lg text-amber-600 shrink-0"></i>
                            <span>Pengaturan Google Drive saat ini <strong>dinonaktifkan sementara</strong> (tombol Sambungkan dan Simpan di-disable).</span>
                        </div>
                    @endif
                    @if($grouped->has($tab))
                        @foreach($grouped[$tab] as $setting)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    @if($setting->name === 'site_title')<i class="ri-text mr-1"></i> Judul Website
                                    @elseif($setting->name === 'site_description')<i class="ri-file-text-line mr-1"></i> Deskripsi Website
                                    @elseif($setting->name === 'favicon')<i class="ri-window-line mr-1"></i> Favicon
                                    @elseif($setting->name === 'logo_header')<i class="ri-layout-top-line mr-1"></i> Logo Header
                                    @elseif($setting->name === 'logo_footer')<i class="ri-layout-bottom-line mr-1"></i> Logo Footer
                                    @elseif($setting->name === 'google_login_enabled')<i class="ri-google-line mr-1"></i> Aktifkan Login Google
                                    @elseif($setting->name === 'google_search_console_key')<i class="ri-search-eye-line mr-1"></i> Google Search Console Key
                                    @elseif($setting->name === 'google_analytics_id')<i class="ri-bar-chart-line mr-1"></i> Google Analytics ID
                                    @elseif($setting->name === 'meta_keywords_default')<i class="ri-price-tag-3-line mr-1"></i> Meta Keywords Default
                                    @elseif($setting->name === 'facebook_url')<i class="ri-facebook-line mr-1"></i> Facebook URL
                                    @elseif($setting->name === 'youtube_url')<i class="ri-youtube-line mr-1"></i> YouTube URL
                                    @elseif($setting->name === 'instagram_url')<i class="ri-instagram-line mr-1"></i> Instagram URL
                                    @elseif($setting->name === 'tiktok_url')<i class="ri-tiktok-line mr-1"></i> TikTok URL
                                    @elseif($setting->name === 'twitter_url')<i class="ri-twitter-line mr-1"></i> Twitter/X URL
                                    @elseif($setting->name === 'whatsapp_number')<i class="ri-whatsapp-line mr-1"></i> Nomor WhatsApp
                                    @elseif($setting->name === 'whatsapp_message')<i class="ri-chat-3-line mr-1"></i> Pesan WhatsApp
                                    @elseif($setting->name === 'google_drive_client_id')<i class="ri-key-line mr-1"></i> Client ID
                                    @elseif($setting->name === 'google_drive_client_secret')<i class="ri-lock-password-line mr-1"></i> Client Secret
                                    @elseif($setting->name === 'google_drive_refresh_token')
                                        <i class="ri-refresh-line mr-1"></i> Refresh Token
                                    @elseif($setting->name === 'google_drive_folder_id')<i class="ri-folder-line mr-1"></i> Folder ID
                                    @else{{ $setting->name }}
                                    @endif
                                </label>

                                @if($setting->type === 'boolean')
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="bool_{{ $setting->name }}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ $setting->value === 'true' ? 'checked' : '' }} onchange="document.getElementById('hidden_{{ $setting->name }}').value = this.checked ? 'true' : 'false'">
                                        <span class="ml-2 text-sm text-gray-600">Aktif</span>
                                    </label>
                                    <input type="hidden" id="hidden_{{ $setting->name }}" name="settings[{{ $loop->index }}][value]" value="{{ $setting->value }}">
                                    <input type="hidden" name="settings[{{ $loop->index }}][name]" value="{{ $setting->name }}">
                                @elseif($setting->type === 'image')
                                    <div class="flex items-center gap-4">
                                        @if($setting->value)
                                            <img src="{{ asset($setting->value) }}" alt="{{ $setting->name }}" class="h-16 w-16 object-contain border rounded">
                                        @endif
                                        <input type="file" name="settings_image_{{ $setting->name }}" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        <input type="hidden" name="settings[{{ $loop->index }}][name]" value="{{ $setting->name }}">
                                        <input type="hidden" name="settings[{{ $loop->index }}][value]" value="{{ $setting->value }}">
                                    </div>
                                @else
                                    @if($setting->name === 'whatsapp_message')
                                        <textarea name="settings[{{ $loop->index }}][value]" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ $setting->value }}</textarea>
                                    @else
                                        @if($setting->name === 'google_drive_refresh_token')
                                            <div class="flex gap-2">
                                                <input type="text" name="settings[{{ $loop->index }}][value]" value="{{ $setting->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-gray-50" readonly placeholder="Tombol Sambungkan dinonaktifkan sementara">
                                                <button type="button" disabled class="mt-1 inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest cursor-not-allowed opacity-60 whitespace-nowrap" title="Tombol Sambungkan dinonaktifkan sementara">
                                                    <i class="ri-google-fill mr-2"></i> Sambungkan
                                                </button>
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">Tombol Sambungkan Google Drive saat ini dinonaktifkan sementara.</p>
                                        @else
                                            <input type="text" name="settings[{{ $loop->index }}][value]" value="{{ $setting->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm {{ str_starts_with($setting->name, 'google_drive') ? 'bg-gray-50' : '' }}" {{ str_starts_with($setting->name, 'google_drive') ? 'readonly' : '' }}>
                                        @endif
                                    @endif
                                    <input type="hidden" name="settings[{{ $loop->index }}][name]" value="{{ $setting->name }}">
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
                @endforeach
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                <button type="submit" id="btn-save-settings" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b] font-medium transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    @if(isset($grouped['google_drive']))
        @php
            $hasToken = $grouped['google_drive']->firstWhere('name', 'google_drive_refresh_token')->value;
        @endphp
        @if($hasToken)
        <div id="test-upload-section" class="mt-6 bg-white rounded-lg shadow p-6 hidden">
            <h2 class="text-lg font-medium text-gray-800 mb-4"><i class="ri-upload-cloud-2-line mr-2"></i>Test Upload ke Google Drive</h2>
            <p class="text-sm text-gray-600 mb-4">Karena Anda sudah terhubung ke Google Drive, Anda bisa mencoba fitur upload untuk memastikan konfigurasi berjalan dengan baik.</p>
            <form action="{{ route('admin.settings.google-drive.test-upload') }}" method="POST" enctype="multipart/form-data" class="flex gap-4 items-end">
                @csrf
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih File (Gambar/Dokumen, Maks. 5MB)</label>
                    <input type="file" name="test_file" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border rounded-md">
                </div>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium whitespace-nowrap h-[42px]">
                    <i class="ri-upload-cloud-line mr-1"></i> Upload Test
                </button>
            </form>
        </div>
        @endif
    @endif
</div>

<script>
const tabAliases = {
    'googledrive': 'google_drive',
    'google_drive': 'google_drive',
    'google-drive': 'google_drive',
    'sosialmedia': 'sosial_media',
    'sosial_media': 'sosial_media',
    'sosial-media': 'sosial_media',
    'seo': 'seo',
    'umum': 'umum'
};

const canonicalHashes = {
    'google_drive': 'googledrive',
    'sosial_media': 'sosialmedia',
    'seo': 'seo',
    'umum': 'umum'
};

function showTab(tabName, updateHash = true) {
    const actualTab = tabAliases[tabName] || tabName;
    const targetContent = document.getElementById('tab-pane-' + actualTab);
    if (!targetContent) return;

    // Sembunyikan hanya konten tab (tab-pane), JANGAN sembunyikan tombol navigasi tab
    document.querySelectorAll('.tab-pane').forEach(el => el.classList.add('hidden'));
    targetContent.classList.remove('hidden');
    
    // Reset styling semua tab link
    document.querySelectorAll('nav[data-tabs-nav] a').forEach(el => {
        el.classList.remove('border-blue-500', 'text-blue-600');
        el.classList.add('border-transparent', 'text-gray-500');
    });

    // Aktifkan tab link yang sesuai
    const activeLink = document.getElementById('tab-link-' + actualTab);
    if (activeLink) {
        activeLink.classList.remove('border-transparent', 'text-gray-500');
        activeLink.classList.add('border-blue-500', 'text-blue-600');
    }

    // Tampilkan fitur Test Upload jika tab google_drive aktif
    const testSection = document.getElementById('test-upload-section');
    if (testSection) {
        if (actualTab === 'google_drive') {
            testSection.classList.remove('hidden');
        } else {
            testSection.classList.add('hidden');
        }
    }

    // Atur tombol Simpan saat berada di tab Google Drive
    const saveBtn = document.getElementById('btn-save-settings');
    if (saveBtn) {
        if (actualTab === 'google_drive') {
            saveBtn.disabled = true;
            saveBtn.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
            saveBtn.classList.remove('bg-[#ca4e33]', 'hover:bg-[#b8432b]');
            saveBtn.title = 'Tombol Simpan untuk Google Drive dinonaktifkan sementara';
        } else {
            saveBtn.disabled = false;
            saveBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
            saveBtn.classList.add('bg-[#ca4e33]', 'hover:bg-[#b8432b]');
            saveBtn.title = '';
        }
    }

    const hash = canonicalHashes[actualTab] || actualTab;
    const activeTabInput = document.getElementById('active_tab');
    if (activeTabInput) {
        activeTabInput.value = hash;
    }

    // Ubah URL hash di browser
    if (updateHash) {
        if (window.location.hash !== '#' + hash) {
            history.pushState(null, '', '#' + hash);
        }
    }
}

function handleHashChange() {
    const rawHash = (window.location.hash || '').replace('#', '').toLowerCase();
    if (rawHash && tabAliases[rawHash]) {
        showTab(tabAliases[rawHash], false);
    }
}

window.addEventListener('hashchange', handleHashChange);

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', handleHashChange);
} else {
    handleHashChange();
}
</script>
@endsection