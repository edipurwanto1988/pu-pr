<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('umkm_user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('kta_number')->nullable(); // No. KTA
            $table->string('nik_number')->nullable(); // NO NIK KTP
            $table->string('business_actor_name')->nullable(); // NAMA PELAKU USAHA
            $table->string('nib')->nullable(); // NIB : BAGI YANG ADA
            $table->string('business_type')->nullable(); // JENIS USAHA
            $table->string('business_place_type')->nullable(); // JENIS TEMPAT USAHA : BERGERAK / TIDAK BERGERAK
            $table->string('business_category')->nullable(); // KATEGORI USAHA : UMKM/IKM
            $table->text('address')->nullable(); // ALAMAT : Jalan
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->nullOnDelete();
            $table->foreignId('kelurahan_id')->nullable()->constrained('kelurahans')->nullOnDelete();
            $table->string('whatsapp')->nullable(); // NO WA
            $table->text('business_products')->nullable(); // PRODUK USAHA
            $table->string('monthly_turnover')->nullable(); // Omset perbulan
            $table->string('ktp_photo')->nullable(); // KIRIM FOTO KTP
            $table->string('face_photo')->nullable(); // KIRIM FOTO WAJAH
            $table->string('payment_proof')->nullable(); // KIRIM BUKTI PEMBAYARAN
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_user_profiles');
    }
};
