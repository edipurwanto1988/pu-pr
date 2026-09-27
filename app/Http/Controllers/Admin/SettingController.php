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
        $tabs = ['umum', 'seo', 'sosial_media', 'google_drive'];
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

    public function connectGoogleDrive()
    {
        $clientId = Setting::where('name', 'google_drive_client_id')->value('value');
        
        if (empty($clientId)) {
            return redirect()->route('admin.settings.index')->with('error', 'Silakan isi dan simpan Client ID terlebih dahulu.');
        }

        $redirectUri = route('admin.settings.google-drive.callback');
        $scope = 'https://www.googleapis.com/auth/drive';
        $authUrl = "https://accounts.google.com/o/oauth2/v2/auth?client_id={$clientId}&redirect_uri={$redirectUri}&response_type=code&scope={$scope}&access_type=offline&prompt=consent";

        return redirect($authUrl);
    }

    public function googleDriveCallback(Request $request)
    {
        if ($request->has('error')) {
            return redirect()->route('admin.settings.index')->with('error', 'Otorisasi Google Drive dibatalkan.');
        }

        $code = $request->get('code');
        $clientId = Setting::where('name', 'google_drive_client_id')->value('value');
        $clientSecret = Setting::where('name', 'google_drive_client_secret')->value('value');
        $redirectUri = route('admin.settings.google-drive.callback');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->route('admin.settings.index')->with('error', 'Client ID atau Client Secret tidak ditemukan.');
        }

        $response = \Illuminate\Support\Facades\Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'code' => $code,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            
            if (isset($data['refresh_token'])) {
                Setting::where('name', 'google_drive_refresh_token')->update(['value' => $data['refresh_token']]);
                return redirect()->route('admin.settings.index')->with('success', 'Google Drive berhasil disambungkan! Refresh Token telah disimpan.');
            } else {
                return redirect()->route('admin.settings.index')->with('error', 'Gagal mendapatkan Refresh Token. Pastikan Anda mengklik "Sambungkan" ulang dan mengizinkan akses.');
            }
        }

        return redirect()->route('admin.settings.index')->with('error', 'Gagal terhubung ke Google Drive API: ' . $response->body());
    }
}