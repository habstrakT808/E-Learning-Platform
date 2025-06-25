<?php
// Script untuk memeriksa struktur tabel courses
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Memeriksa tabel courses...\n";

if (Schema::hasTable('courses')) {
    echo "Tabel courses sudah ada.\n";
    
    // Menampilkan struktur tabel
    echo "\nStruktur tabel courses:\n";
    $columns = DB::select('SHOW COLUMNS FROM courses');
    foreach ($columns as $column) {
        echo "- {$column->Field} ({$column->Type})" . ($column->Key ? " [KEY: {$column->Key}]" : "") . "\n";
    }

    // Periksa kolom yang diperlukan
    $requiredColumns = [
        'title', 'slug', 'description', 'requirements', 'objectives',
        'price', 'level', 'status', 'user_id'
    ];
    
    $missingColumns = [];
    foreach ($requiredColumns as $column) {
        if (!Schema::hasColumn('courses', $column)) {
            $missingColumns[] = $column;
        }
    }
    
    if (count($missingColumns) > 0) {
        echo "\nKolom yang belum ada: " . implode(', ', $missingColumns) . "\n";
    } else {
        echo "\nSemua kolom yang diperlukan sudah ada.\n";
    }

    // Periksa data
    $courseCount = DB::table('courses')->count();
    echo "\nJumlah data di tabel courses: {$courseCount}\n";
    
    if ($courseCount > 0) {
        echo "\nContoh data courses:\n";
        $courses = DB::table('courses')->limit(3)->get();
        foreach ($courses as $course) {
            echo "- ID: {$course->id}, Title: {$course->title}, Status: {$course->status}\n";
        }
    }
} else {
    echo "Tabel courses belum ada.\n";
}

echo "\nSelesai!\n"; 