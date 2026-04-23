<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['name' => 'site_title', 'value' => 'PUPR - Website UMKM/IKM', 'tab' => 'umum', 'type' => 'text'],
            ['name' => 'site_description', 'value' => 'Website resmi pemberdayaan UMKM/IKM', 'tab' => 'umum', 'type' => 'text'],
            ['name' => 'favicon', 'value' => '', 'tab' => 'umum', 'type' => 'image'],
            ['name' => 'logo_header', 'value' => '', 'tab' => 'umum', 'type' => 'image'],
            ['name' => 'logo_footer', 'value' => '', 'tab' => 'umum', 'type' => 'image'],
            ['name' => 'google_login_enabled', 'value' => 'false', 'tab' => 'umum', 'type' => 'boolean'],
            ['name' => 'google_search_console_key', 'value' => '', 'tab' => 'seo', 'type' => 'text'],
            ['name' => 'google_analytics_id', 'value' => '', 'tab' => 'seo', 'type' => 'text'],
            ['name' => 'meta_keywords_default', 'value' => 'umkm,ikm,bisnis,produk lokal,jasa', 'tab' => 'seo', 'type' => 'text'],
            ['name' => 'facebook_url', 'value' => '', 'tab' => 'sosial_media', 'type' => 'text'],
            ['name' => 'youtube_url', 'value' => '', 'tab' => 'sosial_media', 'type' => 'text'],
            ['name' => 'instagram_url', 'value' => '', 'tab' => 'sosial_media', 'type' => 'text'],
            ['name' => 'tiktok_url', 'value' => '', 'tab' => 'sosial_media', 'type' => 'text'],
            ['name' => 'twitter_url', 'value' => '', 'tab' => 'sosial_media', 'type' => 'text'],
            ['name' => 'whatsapp_number', 'value' => '081372801534', 'tab' => 'sosial_media', 'type' => 'text'],
            ['name' => 'whatsapp_message', 'value' => 'Halo, saya ingin bertanya tentang produk/jasa di PUPR', 'tab' => 'sosial_media', 'type' => 'text'],
        ];

        DB::table('settings')->insert($settings);
    }
}