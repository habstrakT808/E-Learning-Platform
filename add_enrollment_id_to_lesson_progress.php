<?php
// Script untuk menambahkan kolom enrollment_id ke tabel lesson_progress
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Memeriksa tabel lesson_progress...\n";

if (Schema::hasTable('lesson_progress')) {
    echo "Tabel lesson_progress ditemukan.\n";
    
    // Menampilkan struktur tabel sebelum perubahan
    echo "\nStruktur tabel lesson_progress sebelum perubahan:\n";
    $columns = DB::select('SHOW COLUMNS FROM lesson_progress');
    foreach ($columns as $column) {
        echo "- {$column->Field} ({$column->Type})" . ($column->Key ? " [KEY: {$column->Key}]" : "") . "\n";
    }
    
    // Periksa kolom enrollment_id
    if (!Schema::hasColumn('lesson_progress', 'enrollment_id')) {
        echo "\nKolom enrollment_id tidak ditemukan. Menambahkan kolom...\n";
        
        try {
            DB::statement('ALTER TABLE lesson_progress ADD COLUMN enrollment_id BIGINT UNSIGNED NULL AFTER user_id');
            echo "Kolom enrollment_id berhasil ditambahkan.\n";
            
            // Sekarang kita perlu mengisi nilai enrollment_id berdasarkan user_id dan lesson_id
            echo "\nMengupdate nilai enrollment_id berdasarkan user_id dan lesson_id...\n";
            
            // Ambil semua lesson progress
            $progresses = DB::table('lesson_progress')->get();
            $updatedCount = 0;
            
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
                                
                            $updatedCount++;
                        }
                    }
                }
            }
            
            echo "Berhasil mengupdate {$updatedCount} dari " . count($progresses) . " lesson progress dengan enrollment_id.\n";
            
            // Tambahkan foreign key constraint
            DB::statement('ALTER TABLE lesson_progress ADD CONSTRAINT fk_lesson_progress_enrollment FOREIGN KEY (enrollment_id) REFERENCES enrollments(id) ON DELETE CASCADE');
            echo "Foreign key constraint untuk enrollment_id berhasil ditambahkan.\n";
            
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
            exit(1);
        }
    } else {
        echo "\nKolom enrollment_id sudah ada.\n";
    }
    
    // Menampilkan struktur tabel setelah perubahan
    echo "\nStruktur tabel lesson_progress setelah perubahan:\n";
    $columns = DB::select('SHOW COLUMNS FROM lesson_progress');
    foreach ($columns as $column) {
        echo "- {$column->Field} ({$column->Type})" . ($column->Key ? " [KEY: {$column->Key}]" : "") . "\n";
    }
} else {
    echo "Tabel lesson_progress tidak ditemukan.\n";
}

echo "\nSelesai!\n"; 