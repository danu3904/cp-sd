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
        // Cek apakah tabel sudah ada sebelum mencoba membuatnya
        if (!Schema::hasTable('principal_message_images')) {
            Schema::create('principal_message_images', function (Blueprint $table) {
                $table->id();
                $table->string('image_path'); // Path ke file gambar
                $table->string('alt_text')->nullable(); // Teks alternatif untuk gambar
                $table->boolean('is_active')->default(false); // Hanya satu yang boleh aktif pada satu waktu
                $table->timestamps();
            });
        } else {
            // Jika tabel sudah ada, mungkin kita ingin menambahkan kolom jika belum ada (untuk migrasi yang dimodifikasi)
            Schema::table('principal_message_images', function (Blueprint $table) {
                if (!Schema::hasColumn('principal_message_images', 'alt_text')) {
                    $table->string('alt_text')->nullable()->after('image_path');
                }
                if (!Schema::hasColumn('principal_message_images', 'is_active')) {
                    $table->boolean('is_active')->default(false)->after('alt_text');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('principal_message_images');
    }
};
