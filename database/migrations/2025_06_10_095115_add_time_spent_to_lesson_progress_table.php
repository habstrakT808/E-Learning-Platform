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
        // Use raw SQL queries to avoid exceptions with Schema::hasColumn
        
        // First check if we have a lesson_progress table
        $tableExists = DB::select("SHOW TABLES LIKE 'lesson_progress'");
        if (!empty($tableExists)) {
            // Check if time_spent column exists
            $timeSpentExists = DB::select("SHOW COLUMNS FROM `lesson_progress` LIKE 'time_spent'");
            if (empty($timeSpentExists)) {
        Schema::table('lesson_progress', function (Blueprint $table) {
                    $table->integer('time_spent')->default(0)
                        ->comment('Time in seconds that the user has spent on this lesson');
                });
            }
            
            // Check if watch_time column exists
            $watchTimeExists = DB::select("SHOW COLUMNS FROM `lesson_progress` LIKE 'watch_time'");
            if (empty($watchTimeExists)) {
                Schema::table('lesson_progress', function (Blueprint $table) {
                    $table->integer('watch_time')->default(0)
                        ->comment('Time in seconds that the user has spent watching the video');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop these columns as they might be used elsewhere
    }
};
