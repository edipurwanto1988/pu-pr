<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmUserProfile;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmUserProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = UmkmUserProfile::firstOrNew(['user_id' => $user->id]);
        $kecamatans = Kecamatan::orderBy('name')->get();
        $kelurahans = $profile->kecamatan_id ? Kelurahan::where('kecamatan_id', $profile->kecamatan_id)->get() : [];

        return view('admin.profile.index', compact('profile', 'kecamatans', 'kelurahans'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $profile = UmkmUserProfile::firstOrNew(['user_id' => $user->id]);

        $request->validate([
            'kta_number' => 'nullable|string|max:255',
            'business_actor_name' => 'nullable|string|max:255',
            'nib' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'business_place_type' => 'nullable|string|max:255',
            'business_category' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'kecamatan_id' => 'nullable|exists:kecamatans,id',
            'kelurahan_id' => 'nullable|exists:kelurahans,id',
            'whatsapp' => 'nullable|string|max:255',
            'business_products' => 'nullable|string',
            'monthly_turnover' => 'nullable|string|max:255',
            'ktp_photo' => 'nullable|image|max:2048',
            'face_photo' => 'nullable|image|max:2048',
            'payment_proof' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['ktp_photo', 'face_photo', 'payment_proof', '_token']);

        if ($request->hasFile('ktp_photo')) {
            $data['ktp_photo'] = $request->file('ktp_photo')->store('profiles/ktp', 'public');
        }
        if ($request->hasFile('face_photo')) {
            $data['face_photo'] = $request->file('face_photo')->store('profiles/face', 'public');
        }
        if ($request->hasFile('payment_proof')) {
            $data['payment_proof'] = $request->file('payment_proof')->store('profiles/payment', 'public');
        }

        $profile->fill($data);
        $profile->save();

        return redirect()->route('admin.profile.index')->with('success', 'Profil berhasil disimpan.');
    }
}
