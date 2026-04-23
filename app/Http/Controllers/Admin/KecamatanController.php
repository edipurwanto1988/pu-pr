<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kecamatan::withCount('kelurahans');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $kecamatans = $query->orderBy('name')->paginate(15);

        return view('admin.kecamatans.index', compact('kecamatans'));
    }

    public function create()
    {
        return view('admin.kecamatans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:kecamatans,name',
        ]);

        Kecamatan::create(['name' => $request->name]);

        return redirect()->route('admin.kecamatans.index')->with('success', 'Kecamatan berhasil ditambahkan');
    }

    public function edit(Kecamatan $kecamatan)
    {
        return view('admin.kecamatans.edit', compact('kecamatan'));
    }

    public function update(Request $request, Kecamatan $kecamatan)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:kecamatans,name,' . $kecamatan->id,
        ]);

        $kecamatan->update(['name' => $request->name]);

        return redirect()->route('admin.kecamatans.index')->with('success', 'Kecamatan berhasil diperbarui');
    }

    public function destroy(Kecamatan $kecamatan)
    {
        if ($kecamatan->kelurahans()->exists()) {
            return redirect()->route('admin.kecamatans.index')->with('error', 'Kecamatan tidak dapat dihapus karena masih memiliki kelurahan.');
        }

        $kecamatan->delete();

        return redirect()->route('admin.kecamatans.index')->with('success', 'Kecamatan berhasil dihapus');
    }

    public function kelurahans(Kecamatan $kecamatan)
    {
        $kelurahans = $kecamatan->kelurahans()->orderBy('name')->get();
        return response()->json($kelurahans);
    }
}