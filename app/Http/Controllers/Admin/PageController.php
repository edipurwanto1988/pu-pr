<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::with('creator');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pages = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.pages.index', compact('pages'));
    }
    public function create() { return view('admin.pages.create'); }
    public function store(Request $request) {
        $request->validate(['title' => 'required']);
        $data = $request->all(); $data['slug'] = \Str::slug($request->title); $data['created_by'] = auth()->id();
        Page::create($data);
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dibuat');
    }
    public function show(Page $page) { return view('admin.pages.show', compact('page')); }
    public function edit(Page $page) { return view('admin.pages.edit', compact('page')); }
    public function update(Request $request, Page $page) { $page->update($request->all()); return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diperbarui'); }
    public function destroy(Page $page) { $page->delete(); return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dihapus'); }
}