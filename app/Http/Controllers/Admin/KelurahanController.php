<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class KelurahanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelurahan::with('kecamatan');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->kecamatan_id);
        }

        $kelurahans = $query->orderBy('name')->paginate(15);
        $kecamatans = Kecamatan::orderBy('name')->get();

        return view('admin.kelurahans.index', compact('kelurahans', 'kecamatans'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::orderBy('name')->get();
        return view('admin.kelurahans.create', compact('kecamatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'name' => 'required|string|max:255',
        ]);

        Kelurahan::create($request->only('kecamatan_id', 'name'));

        return redirect()->route('admin.kelurahans.index')->with('success', 'Kelurahan berhasil ditambahkan');
    }

    public function edit(Kelurahan $kelurahan)
    {
        $kecamatans = Kecamatan::orderBy('name')->get();
        return view('admin.kelurahans.edit', compact('kelurahan', 'kecamatans'));
    }

    public function update(Request $request, Kelurahan $kelurahan)
    {
        $request->validate([
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'name' => 'required|string|max:255',
        ]);

        $kelurahan->update($request->only('kecamatan_id', 'name'));

        return redirect()->route('admin.kelurahans.index')->with('success', 'Kelurahan berhasil diperbarui');
    }

    public function destroy(Kelurahan $kelurahan)
    {
        $kelurahan->delete();

        return redirect()->route('admin.kelurahans.index')->with('success', 'Kelurahan berhasil dihapus');
    }

    public function ajaxStore(Request $request)
    {
        $request->validate([
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'name' => 'required|string|max:255',
        ]);

        $kelurahan = Kelurahan::create($request->only('kecamatan_id', 'name'));

        return response()->json($kelurahan->load('kecamatan'));
    }

    public function ajaxUpdate(Request $request, Kelurahan $kelurahan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $kelurahan->update(['name' => $request->name]);

        return response()->json($kelurahan->load('kecamatan'));
    }

    public function ajaxDestroy(Kelurahan $kelurahan)
    {
        $kelurahan->delete();

        return response()->json(['success' => true]);
    }
}