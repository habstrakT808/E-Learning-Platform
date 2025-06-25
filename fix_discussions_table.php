<?php
// Script untuk memperbaiki tabel discussions
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Memeriksa struktur tabel discussions...\n";

// Cek apakah kolom discussion_category_id sudah ada
if (!Schema::hasColumn('discussions', 'discussion_category_id')) {
    echo "Kolom discussion_category_id tidak ditemukan. Menambahkan kolom...\n";
    
    try {
        DB::statement('ALTER TABLE discussions ADD COLUMN discussion_category_id BIGINT UNSIGNED NULL AFTER user_id');
        echo "Kolom discussion_category_id berhasil ditambahkan.\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        exit(1);
    }
} else {
    echo "Kolom discussion_category_id sudah ada di tabel discussions.\n";
}

echo "Selesai!\n"; 