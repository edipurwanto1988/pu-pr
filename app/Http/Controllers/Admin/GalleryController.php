<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('images')->withCount('images')->orderBy('order')->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'order' => 'nullable|integer',
            'images' => 'required|array|min:1',
            'images.*' => 'image|max:5120',
        ]);

        $gallery = Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order ?? 0,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('galleries', 'public');
                $gallery->images()->create([
                    'image' => $path,
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil dibuat');
    }

    public function edit(Gallery $gallery)
    {
        $gallery->load('images');
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'order' => 'nullable|integer',
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|max:5120',
        ]);

        $gallery->update([
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order ?? 0,
        ]);

        if ($request->hasFile('new_images')) {
            $maxOrder = $gallery->images()->max('order') ?? -1;
            foreach ($request->file('new_images') as $index => $file) {
                $path = $file->store('galleries', 'public');
                $gallery->images()->create([
                    'image' => $path,
                    'order' => $maxOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil diperbarui');
    }

    public function destroy(Gallery $gallery)
    {
        foreach ($gallery->images as $img) {
            Storage::disk('public')->delete($img->image);
        }
        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil dihapus');
    }

    public function addImages(Request $request, Gallery $gallery)
    {
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'image|max:5120',
        ]);

        $maxOrder = $gallery->images()->max('order') ?? -1;
        $saved = [];
        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('galleries', 'public');
            $img = $gallery->images()->create([
                'image' => $path,
                'order' => $maxOrder + $index + 1,
            ]);
            $saved[] = ['id' => $img->id, 'url' => asset('storage/' . $path)];
        }

        return response()->json(['success' => true, 'images' => $saved]);
    }

    public function destroyImage(Gallery $gallery, GalleryImage $image)
    {
        if ($image->gallery_id !== $gallery->id) {
            abort(403);
        }

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return response()->json(['success' => true]);
    }
}