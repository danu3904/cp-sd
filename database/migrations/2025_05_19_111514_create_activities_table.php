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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();                          // ID unik
            $table->text('description')->nullable()->after('title');              // Judul kegiatan
            $table->string('icon_class')->nullable()->after('description');
            $table->string('image')->nullable();  // Nama file gambar (opsional)
            $table->timestamps();                 // created_at & updated_at
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
