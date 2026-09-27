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

    public function testUploadGoogleDrive(Request $request)
    {
        $request->validate([
            'test_file' => 'required|file|max:5120', // Max 5MB
        ]);

        $clientId = Setting::where('name', 'google_drive_client_id')->value('value');
        $clientSecret = Setting::where('name', 'google_drive_client_secret')->value('value');
        $refreshToken = Setting::where('name', 'google_drive_refresh_token')->value('value');
        $folderId = Setting::where('name', 'google_drive_folder_id')->value('value');

        if (empty($clientId) || empty($clientSecret) || empty($refreshToken) || empty($folderId)) {
            return redirect()->route('admin.settings.index')->with('error', 'Konfigurasi Google Drive belum lengkap (Pastikan Folder ID juga sudah diisi).');
        }

        // Dapatkan Access Token baru menggunakan Refresh Token
        $tokenResponse = \Illuminate\Support\Facades\Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token',
        ]);

        if (!$tokenResponse->successful()) {
            return redirect()->route('admin.settings.index')->with('error', 'Gagal mendapatkan Access Token: ' . $tokenResponse->body());
        }

        $accessToken = $tokenResponse->json('access_token');
        $file = $request->file('test_file');

        // Upload ke Google Drive via Multipart
        $metadata = json_encode([
            'name' => 'TEST_' . $file->getClientOriginalName(),
            'parents' => [$folderId]
        ]);

        $uploadResponse = \Illuminate\Support\Facades\Http::withToken($accessToken)
            ->attach('metadata', $metadata, 'metadata.json', ['Content-Type' => 'application/json'])
            ->attach('file', file_get_contents($file->path()), $file->getClientOriginalName(), ['Content-Type' => $file->getMimeType()])
            ->post('https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart');

        if ($uploadResponse->successful()) {
            $fileId = $uploadResponse->json('id');
            
            // Set permission to public
            \Illuminate\Support\Facades\Http::withToken($accessToken)
                ->post("https://www.googleapis.com/drive/v3/files/{$fileId}/permissions", [
                    'type' => 'anyone',
                    'role' => 'reader',
                ]);

            return redirect()->route('admin.settings.index')->with('success', 'File berhasil diupload ke Google Drive! ID File: ' . $fileId);
        }

        return redirect()->route('admin.settings.index')->with('error', 'Gagal mengupload file: ' . $uploadResponse->body());
    }
}