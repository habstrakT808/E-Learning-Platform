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
        Schema::table('lesson_progress', function (Blueprint $table) {
            // Tambahkan kolom enrollment_id jika belum ada
            if (!Schema::hasColumn('lesson_progress', 'enrollment_id')) {
                $table->foreignId('enrollment_id')->nullable()->after('user_id')->constrained()->onDelete('cascade');
            }
        });
        
        // Update nilai enrollment_id berdasarkan user_id dan lesson_id
        $this->updateEnrollmentIds();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lesson_progress', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu
            $table->dropForeign(['enrollment_id']);
            $table->dropColumn('enrollment_id');
        });
    }
    
    /**
     * Update enrollment_id values for existing records
     */
    private function updateEnrollmentIds(): void
    {
        // Ambil semua lesson progress
        $progresses = DB::table('lesson_progress')->whereNull('enrollment_id')->get();
        
        foreach ($progresses as $progress) {
            // Cari lesson untuk mendapatkan section_id
            $lesson = DB::table('lessons')->where('id', $progress->lesson_id)->first();
            
            if ($lesson) {
                // Cari section untuk mendapatkan course_id
                $section = DB::table('sections')->where('id', $lesson->section_id)->first();
                
                if ($section) {
                    // Cari enrollment berdasarkan user_id dan course_id
                    $enrollment = DB::table('enrollments')
                        ->where('user_id', $progress->user_id)
                        ->where('course_id', $section->course_id)
                        ->first();
                    
                    if ($enrollment) {
                        // Update progress dengan enrollment_id
                        DB::table('lesson_progress')
                            ->where('id', $progress->id)
                            ->update(['enrollment_id' => $enrollment->id]);
                    }
                }
            }
        }
    }
};
