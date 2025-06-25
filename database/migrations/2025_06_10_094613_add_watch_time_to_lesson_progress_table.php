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
        // Check if column exists first using raw SQL to avoid exception
        $columnExists = DB::select("SHOW COLUMNS FROM `lesson_progress` LIKE 'watch_time'");
        
        if (empty($columnExists)) {
        Schema::table('lesson_progress', function (Blueprint $table) {
                $table->integer('watch_time')->default(0)->comment('Time in seconds that the user has spent watching the lesson video');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if column exists first using raw SQL to avoid exception
        $columnExists = DB::select("SHOW COLUMNS FROM `lesson_progress` LIKE 'watch_time'");
        
        if (!empty($columnExists)) {
        Schema::table('lesson_progress', function (Blueprint $table) {
                $table->dropColumn('watch_time');
        });
        }
    }
};
