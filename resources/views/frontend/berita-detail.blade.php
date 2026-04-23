@extends('layouts.frontend')

@section('title', $news->title)

@section('og_title', $news->title)
@section('og_description', \Illuminate\Support\Str::limit(strip_tags($news->excerpt ?? $news->content ?? ''), 160))
@section('og_image', $news->image ? asset('storage/' . $news->image) : asset('logo_pupr.webp'))
@section('og_url', route('berita.detail', $news->slug))

@section('json_ld')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "NewsArticle",
  "headline": {{ json_encode($news->title) }},
  "description": {{ json_encode(\Illuminate\Support\Str::limit(strip_tags($news->excerpt ?? ''), 160)) }},
  "image": {{ json_encode($news->image ? asset('storage/' . $news->image) : asset('logo_pupr.webp')) }},
  "datePublished": "{{ $news->published_at ? $news->published_at->toIso8601String() : $news->created_at->toIso8601String() }}",
  "dateModified": "{{ $news->updated_at->toIso8601String() }}",
  "author": { "@@type": "Organization", "name": "PUPR" },
  "publisher": { "@@type": "Organization", "name": "PUPR", "logo": { "@@type": "ImageObject", "url": "{{ asset('logo_pupr.webp') }}" } },
  "mainEntityOfPage": "{{ route('berita.detail', $news->slug) }}"
}
</script>
@endsection

@section('content')
<div class="bg-gray-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
            <i class="ri-arrow-right-s-line text-gray-300"></i>
            <a href="{{ route('berita') }}" class="hover:text-blue-600 transition-colors">Berita</a>
            <i class="ri-arrow-right-s-line text-gray-300"></i>
            <span class="text-gray-700 font-medium truncate max-w-xs">{{ $news->title }}</span>
        </nav>
    </div>
</div>

<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    {{-- Header --}}
    <header class="mb-8">
        <h1 class="text-2xl md:text-4xl font-bold text-gray-900 leading-tight mb-4">{{ $news->title }}</h1>
        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
            <span class="inline-flex items-center gap-1.5">
                <i class="ri-calendar-line"></i>
                {{ $news->published_at ? $news->published_at->format('d F Y') : $news->created_at->format('d F Y') }}
            </span>
            <span class="inline-flex items-center gap-1.5">
                <i class="ri-user-line"></i>
                {{ $news->creator?->name ?? 'Admin' }}
            </span>
        </div>
    </header>

    {{-- Featured Image --}}
    @if($news->image)
        <div class="mb-8 rounded-xl overflow-hidden">
            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full max-h-[480px] object-cover" loading="lazy">
        </div>
    @endif

    {{-- Excerpt --}}
    @if($news->excerpt)
        <div class="text-lg text-gray-600 leading-relaxed mb-8 font-medium border-l-4 pl-4" style="border-color: #ca4e33;">
            {{ $news->excerpt }}
        </div>
    @endif

    {{-- Content --}}
    <div class="prose prose-lg max-none prose-headings:text-gray-900 prose-p:text-gray-600 prose-a:text-blue-600 prose-img:rounded-lg">
        {!! preg_replace('/<iframe([^>]*?)\s+sandbox=""\s*/i', '<iframe$1 ', $news->content) !!}
    </div>

    {{-- Share & Back --}}
    <div class="mt-10 pt-6 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
        <a href="{{ route('berita') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition-colors">
            <i class="ri-arrow-left-line"></i> Kembali ke Berita
        </a>
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-400">Bagikan:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ request()->fullUrl() }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-blue-100 hover:text-blue-600 transition-colors">
                <i class="ri-facebook-line"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ request()->fullUrl() }}&text={{ $news->title }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-blue-100 hover:text-blue-400 transition-colors">
                <i class="ri-twitter-x-line"></i>
            </a>
            <a href="https://wa.me/?text={{ $news->title }}%20{{ request()->fullUrl() }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-green-100 hover:text-green-600 transition-colors">
                <i class="ri-whatsapp-line"></i>
            </a>
        </div>
    </div>
</article>
@endsection
