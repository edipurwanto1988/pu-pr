<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Setting;

class GoogleDriveService
{
    public static function upload($file, $prefix = '')
    {
        $clientId = Setting::where('name', 'google_drive_client_id')->value('value');
        $clientSecret = Setting::where('name', 'google_drive_client_secret')->value('value');
        $refreshToken = Setting::where('name', 'google_drive_refresh_token')->value('value');
        $folderId = Setting::where('name', 'google_drive_folder_id')->value('value');

        if (empty($clientId) || empty($clientSecret) || empty($refreshToken) || empty($folderId)) {
            return false;
        }

        $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token',
        ]);

        if (!$tokenResponse->successful()) {
            return false;
        }

        $accessToken = $tokenResponse->json('access_token');
        
        $metadata = json_encode([
            'name' => $prefix . time() . '_' . $file->getClientOriginalName(),
            'parents' => [$folderId]
        ]);

        $uploadResponse = Http::withToken($accessToken)
            ->attach('metadata', $metadata, 'metadata.json', ['Content-Type' => 'application/json'])
            ->attach('file', file_get_contents($file->path()), $file->getClientOriginalName(), ['Content-Type' => $file->getMimeType()])
            ->post('https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart');

        if ($uploadResponse->successful()) {
            $fileId = $uploadResponse->json('id');
            
            // Set permission to public
            Http::withToken($accessToken)
                ->post("https://www.googleapis.com/drive/v3/files/{$fileId}/permissions", [
                    'type' => 'anyone',
                    'role' => 'reader',
                ]);

            return $fileId;
        }

        return false;
    }

    public static function getUrl($path)
    {
        if (empty($path)) return null;

        if (\Str::startsWith($path, 'gdrive:')) {
            $driveId = str_replace('gdrive:', '', $path);
            return "https://drive.google.com/thumbnail?id={$driveId}&sz=w1000";
        }
        
        return asset('storage/' . $path);
    }
}
