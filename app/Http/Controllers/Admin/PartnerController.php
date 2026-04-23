<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('order')->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'logo' => 'required|image|max:5120']);
        $data = $request->except('logo');
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }
        Partner::create($data);
        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dibuat');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $data = $request->except('logo');
        if ($request->hasFile('logo')) {
            if ($partner->logo) Storage::disk('public')->delete($partner->logo);
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }
        $partner->update($data);
        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil diperbarui');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo) Storage::disk('public')->delete($partner->logo);
        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus');
    }
}