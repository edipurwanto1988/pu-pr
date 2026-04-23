@extends('layouts.admin')

@section('content')
<div class="">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('admin.pages.index') }}" class="text-gray-600 hover:text-gray-900"><i class="ri-arrow-left-line"></i></a>
        <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-edit-line mr-2"></i>Edit Halaman</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.pages.update', $page) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-text mr-1"></i>Judul</label>
                    <input type="text" name="title" value="{{ $page->title }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-article-line mr-1"></i>Konten</label>
                    <textarea name="content" id="content" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{!! $page->content !!}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-toggle-line mr-1"></i>Status</label>
                    <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="draft" {{ $page->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ $page->status === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-seo-line mr-1"></i>Meta Title</label>
                    <input type="text" name="meta_title" value="{{ $page->meta_title }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><i class="ri-seo-line mr-1"></i>Meta Description</label>
                    <textarea name="meta_description" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $page->meta_description }}</textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"><i class="ri-close-line mr-1"></i>Batal</a>
                <button type="submit" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]"><i class="ri-save-line mr-1"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<script>
tinymce.init({
    selector: '#content',
    license_key: 'gpl',
    plugins: 'lists link image preview align formatpainter code',
    menubar: 'edit insert view format',
    toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | link image | code | removeformat',
    height: 400,
    branding: false,
    promotion: false,
});
</script>
@endsection