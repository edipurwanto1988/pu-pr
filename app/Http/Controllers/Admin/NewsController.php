<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('creator');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $news = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
        ]);

        $data = $request->except('image');
        $data['slug'] = \Str::slug($request->title);
        $data['created_by'] = auth()->id();
        
        if ($request->hasFile('image')) {
            $driveId = \App\Services\GoogleDriveService::upload($request->file('image'), 'Berita_');
            if ($driveId) {
                $data['image'] = 'gdrive:' . $driveId;
            } else {
                $data['image'] = $request->file('image')->store('news', 'public');
            }
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dibuat');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($news->image && !\Str::startsWith($news->image, 'gdrive:')) {
                Storage::disk('public')->delete($news->image);
            }
            
            $driveId = \App\Services\GoogleDriveService::upload($request->file('image'), 'Berita_');
            if ($driveId) {
                $data['image'] = 'gdrive:' . $driveId;
            } else {
                $data['image'] = $request->file('image')->store('news', 'public');
            }
        }

        if ($request->filled('published_at')) {
            $data['published_at'] = \Carbon\Carbon::parse($request->published_at);
        } else {
            $data['published_at'] = null;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy(News $news)
    {
        if ($news->image) Storage::disk('public')->delete($news->image);
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus');
    }

    public function publish(Request $request, News $news)
    {
        $news->update(['status' => 'published', 'published_at' => now()]);
        return redirect()->route('admin.news.index')->with('success', 'Berita dipublish');
    }
}