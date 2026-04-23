<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::whereNull('parent_id')->with('children')->orderBy('order')->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $parentMenus = Menu::whereNull('parent_id')->orderBy('order')->get();
        $pages = \App\Models\Page::orderBy('title')->get();
        return view('admin.menus.create', compact('parentMenus', 'pages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
        ]);

        $data = $request->only(['title', 'url', 'icon', 'target', 'order', 'status']);
        $data['parent_id'] = $request->parent_id ?? null;

        Menu::create($data);

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil dibuat');
    }

    public function edit(Menu $menu)
    {
        $parentMenus = Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->orderBy('order')->get();
        $pages = \App\Models\Page::orderBy('title')->get();
        return view('admin.menus.edit', compact('menu', 'parentMenus', 'pages'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
        ]);

        $data = $request->only(['title', 'url', 'icon', 'target', 'order', 'status']);
        $data['parent_id'] = $request->parent_id ?? null;

        $menu->update($data);

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy(Menu $menu)
    {
        $menu->children()->delete();
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil dihapus');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            Menu::where('id', $id['id'])->update(['order' => $index]);
        }
        return response()->json(['success' => true]);
    }
}