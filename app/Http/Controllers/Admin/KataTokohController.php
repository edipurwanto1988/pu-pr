<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KataTokoh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KataTokohController extends Controller
{
    public function index()
    {
        $tokohs = KataTokoh::orderBy('order')->get();
        return view('admin.kata-tokoh.index', compact('tokohs'));
    }

    public function create()
    {
        return view('admin.kata-tokoh.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'required|image|mimes:webp|max:5120',
        ]);

        $file = $request->file('foto');
        $imageSize = getimagesize($file->getRealPath());
        if ($imageSize[0] !== 100 || $imageSize[1] !== 100) {
            return back()->withErrors(['foto' => 'Ukuran foto harus tepat 100x100 piksel. Ukuran yang diupload: ' . $imageSize[0] . 'x' . $imageSize[1]])->withInput();
        }

        $data = $request->except('foto');
        $data['foto'] = $file->store('kata-tokoh', 'public');

        KataTokoh::create($data);
        return redirect()->route('admin.kata-tokoh.index')->with('success', 'Kata Tokoh berhasil ditambahkan');
    }

    public function edit(KataTokoh $kataTokoh)
    {
        return view('admin.kata-tokoh.edit', compact('kataTokoh'));
    }

    public function update(Request $request, KataTokoh $kataTokoh)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ];

        if ($request->hasFile('foto')) {
            $rules['foto'] = 'image|mimes:webp|max:5120';
        }

        $request->validate($rules);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $imageSize = getimagesize($file->getRealPath());
            if ($imageSize[0] !== 100 || $imageSize[1] !== 100) {
                return back()->withErrors(['foto' => 'Ukuran foto harus tepat 100x100 piksel. Ukuran yang diupload: ' . $imageSize[0] . 'x' . $imageSize[1]])->withInput();
            }
            if ($kataTokoh->foto) {
                Storage::disk('public')->delete($kataTokoh->foto);
            }
            $data['foto'] = $file->store('kata-tokoh', 'public');
        }

        $kataTokoh->update($data);
        return redirect()->route('admin.kata-tokoh.index')->with('success', 'Kata Tokoh berhasil diperbarui');
    }

    public function destroy(KataTokoh $kataTokoh)
    {
        if ($kataTokoh->foto) {
            Storage::disk('public')->delete($kataTokoh->foto);
        }
        $kataTokoh->delete();
        return redirect()->route('admin.kata-tokoh.index')->with('success', 'Kata Tokoh berhasil dihapus');
    }

    public function toggle(KataTokoh $kataTokoh)
    {
        $kataTokoh->update(['status' => $kataTokoh->status === 'active' ? 'inactive' : 'active']);
        return redirect()->route('admin.kata-tokoh.index')->with('success', 'Status Kata Tokoh diperbarui');
    }
}