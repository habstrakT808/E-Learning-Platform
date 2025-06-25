<?php
// Script untuk menambahkan kolom is_preview ke tabel lessons
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Memeriksa tabel lessons...\n";

if (Schema::hasTable('lessons')) {
    echo "Tabel lessons ditemukan.\n";
    
    // Menampilkan struktur tabel sebelum perubahan
    echo "\nStruktur tabel lessons sebelum perubahan:\n";
    $columns = DB::select('SHOW COLUMNS FROM lessons');
    foreach ($columns as $column) {
        echo "- {$column->Field} ({$column->Type})" . ($column->Key ? " [KEY: {$column->Key}]" : "") . "\n";
    }
    
    // Periksa kolom is_preview
    if (!Schema::hasColumn('lessons', 'is_preview')) {
        echo "\nKolom is_preview tidak ditemukan. Menambahkan kolom...\n";
        
        try {
            // Cek apakah kolom is_free ada, karena mungkin kolom ini sudah ada dengan nama yang berbeda
            if (Schema::hasColumn('lessons', 'is_free')) {
                echo "Kolom is_free ditemukan. Mengganti nama menjadi is_preview...\n";
                DB::statement('ALTER TABLE lessons CHANGE COLUMN is_free is_preview TINYINT(1) NOT NULL DEFAULT 0');
                echo "Kolom is_free berhasil diubah menjadi is_preview.\n";
            } else {
                // Tambahkan kolom baru jika tidak ada kolom is_free
                DB::statement('ALTER TABLE lessons ADD COLUMN is_preview TINYINT(1) NOT NULL DEFAULT 0 AFTER duration');
                echo "Kolom is_preview berhasil ditambahkan.\n";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
            exit(1);
        }
    } else {
        echo "\nKolom is_preview sudah ada.\n";
    }
    
    // Menampilkan struktur tabel setelah perubahan
    echo "\nStruktur tabel lessons setelah perubahan:\n";
    $columns = DB::select('SHOW COLUMNS FROM lessons');
    foreach ($columns as $column) {
        echo "- {$column->Field} ({$column->Type})" . ($column->Key ? " [KEY: {$column->Key}]" : "") . "\n";
    }
    
    // Update data yang ada untuk menandai beberapa pelajaran sebagai preview
    echo "\nMengupdate beberapa lesson untuk dijadikan preview...\n";
    
    try {
        // Ambil semua course
        $courses = DB::table('courses')->get();
        $updatedCount = 0;
        
        foreach ($courses as $course) {
            // Untuk setiap course, ambil 1-2 lesson dari section pertama untuk dijadikan preview
            $firstSection = DB::table('sections')
                ->where('course_id', $course->id)
                ->orderBy('order')
                ->first();
                
            if ($firstSection) {
                // Update 1-2 lesson pertama sebagai preview
                $previewCount = rand(1, 2);
                $updatedLessons = DB::table('lessons')
                    ->where('section_id', $firstSection->id)
                    ->orderBy('order')
                    ->limit($previewCount)
                    ->update(['is_preview' => 1]);
                    
                $updatedCount += $updatedLessons;
                
                echo "- Course '{$course->title}': {$updatedLessons} lesson telah ditandai sebagai preview.\n";
            }
        }
        
        echo "\nTotal {$updatedCount} lesson telah ditandai sebagai preview.\n";
    } catch (Exception $e) {
        echo "Error saat mengupdate data: " . $e->getMessage() . "\n";
    }
} else {
    echo "Tabel lessons tidak ditemukan.\n";
}

echo "\nSelesai!\n"; 