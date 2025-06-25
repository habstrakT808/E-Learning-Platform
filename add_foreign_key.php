<?php
// Script untuk menambahkan foreign key
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Menambahkan foreign key untuk discussion_category_id...\n";

// Periksa apakah tabel discussion_categories ada
if (!Schema::hasTable('discussion_categories')) {
    echo "Error: Tabel discussion_categories tidak ditemukan.\n";
    exit(1);
}

// Periksa apakah foreign key sudah ada
$hasFK = false;
$constraints = DB::select("
    SELECT CONSTRAINT_NAME
    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
    WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = 'discussions'
        AND COLUMN_NAME = 'discussion_category_id'
        AND REFERENCED_TABLE_NAME IS NOT NULL
");

if (!empty($constraints)) {
    echo "Foreign key untuk discussion_category_id sudah ada.\n";
    exit(0);
}

// Tambahkan foreign key
try {
    DB::statement('ALTER TABLE discussions ADD CONSTRAINT fk_discussions_category FOREIGN KEY (discussion_category_id) REFERENCES discussion_categories(id) ON DELETE SET NULL');
    echo "Foreign key berhasil ditambahkan.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "Selesai!\n"; 