<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('umkm_profiles', 'qris_image')) {
                $table->string('qris_image')->nullable()->after('banner');
            }
        });
    }

    public function down(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('umkm_profiles', 'qris_image')) {
                $table->dropColumn('qris_image');
            }
        });
    }
};
