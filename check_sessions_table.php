<?php
// Script untuk memeriksa apakah tabel sessions sudah ada
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Memeriksa tabel sessions...\n";

if (Schema::hasTable('sessions')) {
    echo "Tabel sessions sudah ada.\n";
    
    // Menampilkan struktur tabel
    echo "\nStruktur tabel sessions:\n";
    $columns = DB::select('SHOW COLUMNS FROM sessions');
    foreach ($columns as $column) {
        echo "- {$column->Field} ({$column->Type})" . ($column->Key ? " [KEY: {$column->Key}]" : "") . "\n";
    }
} else {
    echo "Tabel sessions belum ada.\n";
}

echo "\nSelesai!\n"; 