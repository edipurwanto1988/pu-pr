@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-gray-800"><i class="ri-slideshow-line mr-2"></i>Slider</h1>
    <a href="{{ route('admin.sliders.create') }}" class="px-4 py-2 bg-[#ca4e33] text-white rounded-lg hover:bg-[#b8432b]">
        <i class="ri-add-line mr-1"></i> Tambah Slider
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($sliders as $slider)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="font-semibold text-gray-800">{{ $slider->title }}</h3>
                <p class="text-sm text-gray-500">{{ $slider->subtitle }}</p>
                <div class="mt-3 flex items-center justify-between">
                    <span class="px-2 py-1 text-xs rounded-full {{ $slider->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $slider->status }}
                    </span>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.sliders.edit', $slider) }}" class="text-blue-600 hover:text-blue-900"><i class="ri-edit-line"></i></a>
                        <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin hapus?')">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-8 text-gray-500">Belum ada slider</div>
    @endforelse
</div>
@endsection