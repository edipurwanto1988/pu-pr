<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:produk,jasa',
        ]);

        $data = $request->only(['name', 'type', 'description', 'icon', 'order', 'status']);
        $data['slug'] = \Str::slug($request->name);

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dibuat');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:produk,jasa',
        ]);

        $data = $request->only(['name', 'type', 'description', 'icon', 'order', 'status']);
        $data['slug'] = \Str::slug($request->name);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus');
    }

    public function quickStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:produk,jasa',
        ]);

        $data = $request->only(['name', 'type', 'description', 'icon', 'order', 'status']);
        $data['slug'] = \Str::slug($request->name);
        $data['status'] = $data['status'] ?? 'active';

        $category = Category::create($data);

        return response()->json($category);
    }
}