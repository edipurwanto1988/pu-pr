@extends('layouts.frontend')

@section('title', $page->title)

@section('og_title', $page->title . ' — PUPR')
@section('og_description', \Illuminate\Support\Str::limit(strip_tags($page->content ?? ''), 160))
@section('og_image', asset('logo_pupr.webp'))
@section('og_url', route('page', $page->slug))

@section('content')
<div class="bg-gray-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
            <i class="ri-arrow-right-s-line text-gray-300"></i>
            <span class="text-gray-700 font-medium truncate max-w-xs">{{ $page->title }}</span>
        </nav>
    </div>
</div>

<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <header class="mb-8">
        <h1 class="text-2xl md:text-4xl font-bold text-gray-900 leading-tight">{{ $page->title }}</h1>
    </header>

    <div class="prose prose-lg max-none prose-headings:text-gray-900 prose-p:text-gray-600 prose-a:text-blue-600 prose-img:rounded-lg">
        {!! preg_replace('/<iframe([^>]*?)\s+sandbox=""\s*/i', '<iframe$1 ', $page->content) !!}
    </div>

    <div class="mt-10 pt-6 border-t border-gray-200">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition-colors">
            <i class="ri-arrow-left-line"></i> Kembali ke Beranda
        </a>
    </div>
</article>
@endsection