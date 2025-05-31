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
        Schema::table('news', function (Blueprint $table) {
            // Cek dulu apakah kolomnya belum ada, untuk menghindari error jika migrasi dijalankan ulang
            if (!Schema::hasColumn('news', 'description')) {
                // Tambahkan kolom description setelah title, atau sesuaikan posisinya jika perlu
                $table->text('description')->nullable()->after('title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            if (Schema::hasColumn('news', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};