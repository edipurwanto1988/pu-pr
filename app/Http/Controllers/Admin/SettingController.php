<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $tabs = ['umum', 'seo', 'sosial_media'];
        $settings = Setting::whereIn('tab', $tabs)->get();
        
        $grouped = $settings->groupBy('tab');
        
        return view('admin.settings.index', compact('grouped', 'tabs'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings.*.name' => 'required|string',
            'settings.*.value' => 'nullable|string',
        ]);

        foreach ($request->settings as $settingData) {
            $setting = Setting::where('name', $settingData['name'])->first();
            
            if ($setting) {
                if ($setting->type === 'image' && $request->hasFile('settings_image_' . $setting->name)) {
                    if ($setting->value) {
                        $oldPath = str_replace('storage/', '', $setting->value);
                        Storage::disk('public')->delete($oldPath);
                    }
                    $file = $request->file('settings_image_' . $setting->name);
                    $filename = $setting->name . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('settings', $filename, 'public');
                    $setting->value = 'storage/' . $path;
                } elseif ($setting->type !== 'image') {
                    $setting->value = $settingData['value'] ?? '';
                }
                $setting->save();
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil disimpan');
    }
}