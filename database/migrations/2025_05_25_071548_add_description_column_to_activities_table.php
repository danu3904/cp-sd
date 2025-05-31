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
            Schema::table('activities', function (Blueprint $table) {
                // Cek dulu apakah kolomnya belum ada, untuk menghindari error jika migrasi dijalankan ulang
                if (!Schema::hasColumn('activities', 'description')) {
                    $table->text('description')->nullable()->after('title'); // Tambahkan kolom description setelah title
                }
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('activities', function (Blueprint $table) {
                if (Schema::hasColumn('activities', 'description')) {
                    $table->dropColumn('description');
                }
            });
        }
    };
    