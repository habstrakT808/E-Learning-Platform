<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('quiz_answers', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_answers', 'attempt_id')) {
                $table->unsignedBigInteger('attempt_id')->nullable()->after('quiz_attempt_id');
                
                // Tambahkan foreign key ke quiz_attempts
                $table->foreign('attempt_id')
                      ->references('id')
                      ->on('quiz_attempts')
                      ->nullOnDelete();
            }
        });
        
        // Salin nilai dari quiz_attempt_id ke attempt_id
        DB::statement('UPDATE quiz_answers SET attempt_id = quiz_attempt_id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_answers', function (Blueprint $table) {
            if (Schema::hasColumn('quiz_answers', 'attempt_id')) {
                $table->dropForeign(['attempt_id']);
                $table->dropColumn('attempt_id');
            }
        });
    }
};
