<?php
// Script untuk memeriksa dan memperbaiki tabel discussions
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Memeriksa dan memperbaiki tabel discussions...\n";

// Menampilkan struktur tabel discussions
echo "Struktur tabel discussions:\n";
$columns = DB::select('SHOW COLUMNS FROM discussions');
foreach ($columns as $column) {
    echo "- {$column->Field} ({$column->Type})" . ($column->Key ? " [KEY: {$column->Key}]" : "") . "\n";
}

// Cek apakah kolom discussion_category_id sudah ada
if (!Schema::hasColumn('discussions', 'discussion_category_id')) {
    echo "Kolom discussion_category_id tidak ditemukan. Menambahkan kolom...\n";
    
    try {
        DB::statement('ALTER TABLE discussions ADD COLUMN discussion_category_id BIGINT UNSIGNED NULL AFTER user_id');
        echo "Kolom discussion_category_id berhasil ditambahkan.\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "Kolom discussion_category_id sudah ada di tabel discussions.\n";
}

// Periksa relasi antar tabel
echo "\nMemeriksa relasi foreign key...\n";
$foreignKeys = DB::select("
    SELECT 
        TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
    FROM
        INFORMATION_SCHEMA.KEY_COLUMN_USAGE
    WHERE
        REFERENCED_TABLE_NAME IS NOT NULL
        AND TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = 'discussions'
");

foreach ($foreignKeys as $key) {
    echo "- {$key->TABLE_NAME}.{$key->COLUMN_NAME} -> {$key->REFERENCED_TABLE_NAME}.{$key->REFERENCED_COLUMN_NAME} [{$key->CONSTRAINT_NAME}]\n";
}

// Periksa apakah ada foreign key untuk discussion_category_id
$hasForeignKey = false;
foreach ($foreignKeys as $key) {
    if ($key->COLUMN_NAME === 'discussion_category_id') {
        $hasForeignKey = true;
        break;
    }
}

if (!$hasForeignKey && Schema::hasColumn('discussions', 'discussion_category_id')) {
    echo "Foreign key untuk discussion_category_id tidak ditemukan. Menambahkan foreign key...\n";
    
    try {
        // Periksa apakah tabel discussion_categories ada
        if (Schema::hasTable('discussion_categories')) {
            DB::statement('ALTER TABLE discussions ADD CONSTRAINT fk_discussions_category FOREIGN KEY (discussion_category_id) REFERENCES discussion_categories(id) ON DELETE SET NULL');
            echo "Foreign key untuk discussion_category_id berhasil ditambahkan.\n";
        } else {
            echo "Tabel discussion_categories tidak ditemukan. Foreign key tidak dapat ditambahkan.\n";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

echo "\nSelesai!\n"; 