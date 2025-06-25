<?php
// Script untuk menambahkan kolom watch_time ke tabel lesson_progress
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
    
    if (!Schema::hasColumn('lesson_progress', 'watch_time')) {
        echo "Kolom watch_time tidak ditemukan. Menambahkan kolom...\n";
        
        try {
            // Cek apakah kolom is_completed ada
            $hasIsCompleted = Schema::hasColumn('lesson_progress', 'is_completed');
            
            if ($hasIsCompleted) {
                DB::statement('ALTER TABLE lesson_progress ADD COLUMN watch_time INT NULL DEFAULT 0 AFTER is_completed');
            } else {
                // Cek apakah kolom completed ada (nama lama)
                $hasCompleted = Schema::hasColumn('lesson_progress', 'completed');
                
                if ($hasCompleted) {
                    DB::statement('ALTER TABLE lesson_progress ADD COLUMN watch_time INT NULL DEFAULT 0 AFTER completed');
                } else {
                    DB::statement('ALTER TABLE lesson_progress ADD COLUMN watch_time INT NULL DEFAULT 0');
                }
            }
            
            echo "Kolom watch_time berhasil ditambahkan.\n";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
            exit(1);
        }
    } else {
        echo "Kolom watch_time sudah ada.\n";
    }
    
    // Menampilkan struktur tabel
    echo "\nStruktur tabel lesson_progress sekarang:\n";
    $columns = DB::select('SHOW COLUMNS FROM lesson_progress');
    foreach ($columns as $column) {
        echo "- {$column->Field} ({$column->Type})" . ($column->Key ? " [KEY: {$column->Key}]" : "") . "\n";
    }
} else {
    echo "Tabel lesson_progress tidak ditemukan.\n";
}

echo "\nSelesai!\n"; 