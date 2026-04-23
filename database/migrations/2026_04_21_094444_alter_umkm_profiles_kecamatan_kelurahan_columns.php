<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->dropColumn(['kecamatan', 'kelurahan']);
        });

        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->foreignId('kecamatan_id')->nullable()->after('address')->constrained()->onDelete('set null');
            $table->foreignId('kelurahan_id')->nullable()->after('kecamatan_id')->constrained()->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->dropForeign(['kecamatan_id']);
            $table->dropForeign(['kelurahan_id']);
            $table->dropColumn(['kecamatan_id', 'kelurahan_id']);
        });

        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->string('kecamatan')->nullable()->after('address');
            $table->string('kelurahan')->nullable()->after('kecamatan');
        });
    }
};