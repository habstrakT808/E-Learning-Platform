<?php
// Script untuk mengubah nama kolom completed menjadi is_completed
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
    
    if (Schema::hasColumn('lesson_progress', 'completed') && !Schema::hasColumn('lesson_progress', 'is_completed')) {
        echo "Kolom completed ditemukan, tetapi kolom is_completed tidak ada. Mengganti nama kolom...\n";
        
        try {
            DB::statement('ALTER TABLE lesson_progress CHANGE COLUMN completed is_completed TINYINT(1) NOT NULL DEFAULT 0');
            echo "Kolom completed berhasil diubah menjadi is_completed.\n";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
            exit(1);
        }
    } else if (Schema::hasColumn('lesson_progress', 'is_completed')) {
        echo "Kolom is_completed sudah ada.\n";
    } else {
        echo "Kolom completed tidak ditemukan. Menambahkan kolom is_completed...\n";
        
        try {
            DB::statement('ALTER TABLE lesson_progress ADD COLUMN is_completed TINYINT(1) NOT NULL DEFAULT 0 AFTER lesson_id');
            echo "Kolom is_completed berhasil ditambahkan.\n";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
            exit(1);
        }
    }
    
    // Periksa apakah kolom completed_at ada
    if (!Schema::hasColumn('lesson_progress', 'completed_at')) {
        echo "Kolom completed_at tidak ditemukan. Menambahkan kolom...\n";
        
        try {
            DB::statement('ALTER TABLE lesson_progress ADD COLUMN completed_at TIMESTAMP NULL AFTER watch_time');
            echo "Kolom completed_at berhasil ditambahkan.\n";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
            exit(1);
        }
    } else {
        echo "Kolom completed_at sudah ada.\n";
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