<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::orderBy('order')->get();
        return view('admin.sponsors.index', compact('sponsors'));
    }

    public function create()
    {
        return view('admin.sponsors.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'logo' => 'required|image|max:5120']);
        $data = $request->except('logo');
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('sponsors', 'public');
        }
        Sponsor::create($data);
        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor berhasil dibuat');
    }

    public function edit(Sponsor $sponsor)
    {
        return view('admin.sponsors.edit', compact('sponsor'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $data = $request->except('logo');
        if ($request->hasFile('logo')) {
            if ($sponsor->logo) Storage::disk('public')->delete($sponsor->logo);
            $data['logo'] = $request->file('logo')->store('sponsors', 'public');
        }
        $sponsor->update($data);
        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor berhasil diperbarui');
    }

    public function destroy(Sponsor $sponsor)
    {
        if ($sponsor->logo) Storage::disk('public')->delete($sponsor->logo);
        $sponsor->delete();
        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor berhasil dihapus');
    }
}