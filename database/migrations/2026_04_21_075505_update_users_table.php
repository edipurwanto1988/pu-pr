<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('google_id')->nullable()->after('phone');
            $table->string('avatar')->nullable()->after('google_id');
            $table->foreignId('role_id')->nullable()->constrained()->onDelete('set null')->after('avatar');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('role_id');
            $table->string('password')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['phone', 'google_id', 'avatar', 'role_id', 'status']);
            $table->string('password')->nullable(false)->change();
        });
    }
};
