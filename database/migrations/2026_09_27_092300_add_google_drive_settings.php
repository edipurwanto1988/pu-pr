<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $settings = [
            ['name' => 'google_drive_client_id', 'value' => '', 'tab' => 'google_drive', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'google_drive_client_secret', 'value' => '', 'tab' => 'google_drive', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'google_drive_refresh_token', 'value' => '', 'tab' => 'google_drive', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'google_drive_folder_id', 'value' => '', 'tab' => 'google_drive', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('settings')->insert($settings);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->where('tab', 'google_drive')->delete();
    }
};
