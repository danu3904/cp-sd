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
        if (!Schema::hasTable('principal_welcomes')) {
            Schema::create('principal_welcomes', function (Blueprint $table) {
                $table->id();
                $table->string('title')->default('Kata Sambutan Kepala Sekolah'); // Judul default
                $table->string('headmaster_name')->nullable(); // Nama Kepala Sekolah, bisa diisi dari admin
                $table->text('content'); // Isi teks kata sambutan
                $table->boolean('is_active')->default(false); // Hanya satu yang boleh aktif
                $table->timestamps();
            });
        } else {
            // Jika tabel sudah ada, tambahkan kolom yang mungkin belum ada
            Schema::table('principal_welcomes', function (Blueprint $table) {
                if (!Schema::hasColumn('principal_welcomes', 'title')) {
                    $table->string('title')->default('Kata Sambutan Kepala Sekolah')->after('id');
                }
                if (!Schema::hasColumn('principal_welcomes', 'headmaster_name')) {
                    $table->string('headmaster_name')->nullable()->after('title');
                }
                if (!Schema::hasColumn('principal_welcomes', 'is_active')) {
                    $table->boolean('is_active')->default(false)->after('content');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('principal_welcomes');
    }
};
