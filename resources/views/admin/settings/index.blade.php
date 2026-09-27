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
            <nav class="-mb-px flex space-x-8 px-6">
                <a href="#umum" class="border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" onclick="showTab('umum')">
                    <i class="ri-settings-3-line mr-1"></i> Umum
                </a>
                <a href="#seo" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" onclick="showTab('seo')">
                    <i class="ri-seo-line mr-1"></i> SEO
                </a>
                <a href="#sosial_media" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" onclick="showTab('sosial_media')">
                    <i class="ri-share-line mr-1"></i> Sosial Media
                </a>
                <a href="#google_drive" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" onclick="showTab('google_drive')">
                    <i class="ri-drive-line mr-1"></i> Google Drive
                </a>
            </nav>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="p-6 space-y-6">
                @foreach($tabs as $tab)
                <div id="tab-{{ $tab }}" class="{{ $loop->first ? '' : 'hidden' }}">
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
                                                <input type="text" name="settings[{{ $loop->index }}][value]" value="{{ $setting->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-gray-50" readonly placeholder="Klik tombol Sambungkan untuk mengisi token ini secara otomatis">
                                                <a href="{{ route('admin.settings.google-drive.connect') }}" class="mt-1 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
                                                    <i class="ri-google-fill mr-2"></i> Sambungkan
                                                </a>
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">Pastikan Anda telah mengisi dan <b>menyimpan</b> Client ID dan Client Secret terlebih dahulu sebelum menyambungkan.</p>
                                        @else
                                            <input type="text" name="settings[{{ $loop->index }}][value]" value="{{ $setting->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
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
                <button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b] font-medium">
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
function showTab(tab) {
    event.preventDefault();
    document.querySelectorAll('[id^="tab-"]').forEach(el => el.classList.add('hidden'));
    document.getElementById('tab-' + tab).classList.remove('hidden');
    
    document.querySelectorAll('nav a').forEach(el => {
        el.classList.remove('border-blue-500', 'text-blue-600');
        el.classList.add('border-transparent', 'text-gray-500');
    });
    event.target.classList.remove('border-transparent', 'text-gray-500');
    event.target.classList.add('border-blue-500', 'text-blue-600');

    // Tampilkan fitur Test Upload jika tab google_drive aktif
    const testSection = document.getElementById('test-upload-section');
    if (testSection) {
        if (tab === 'google_drive') {
            testSection.classList.remove('hidden');
        } else {
            testSection.classList.add('hidden');
        }
    }
}
</script>
@endsection