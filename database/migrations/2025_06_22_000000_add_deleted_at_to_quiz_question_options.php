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
        // Only add the column if it doesn't exist
        if (Schema::hasTable('quiz_question_options') && !Schema::hasColumn('quiz_question_options', 'deleted_at')) {
            Schema::table('quiz_question_options', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't actually drop the column in the down method
        // as this is just a recovery migration
    }
}; 