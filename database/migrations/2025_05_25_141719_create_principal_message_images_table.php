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
    Schema::create('principal_message_images', function (Blueprint $table) {
        $table->id();
        $table->string('image_path'); // Path ke file gambar
        $table->string('alt_text')->nullable(); // Teks alternatif untuk gambar
        $table->boolean('is_active')->default(true); // Untuk menandai gambar mana yang aktif
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('principal_message_images');
    }
};
