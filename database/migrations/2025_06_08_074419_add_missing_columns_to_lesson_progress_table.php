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
        Schema::table('lesson_progress', function (Blueprint $table) {
            if (!Schema::hasColumn('lesson_progress', 'enrollment_id')) {
                $table->foreignId('enrollment_id')->nullable()->after('lesson_id')
                    ->constrained('enrollments')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('lesson_progress', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('is_completed');
            }
            
            if (!Schema::hasColumn('lesson_progress', 'watch_time')) {
                $table->integer('watch_time')->default(0)->after('completed_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lesson_progress', function (Blueprint $table) {
            if (Schema::hasColumn('lesson_progress', 'enrollment_id')) {
                $table->dropForeign(['enrollment_id']);
                $table->dropColumn('enrollment_id');
            }
            
            if (Schema::hasColumn('lesson_progress', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
            
            if (Schema::hasColumn('lesson_progress', 'watch_time')) {
                $table->dropColumn('watch_time');
            }
        });
    }
};
