<?php
// Script untuk membuat tabel discussion_categories
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Memeriksa dan membuat tabel discussion_categories jika belum ada...\n";

if (!Schema::hasTable('discussion_categories')) {
    echo "Tabel discussion_categories tidak ditemukan. Membuat tabel...\n";
    
    try {
        DB::statement('
            CREATE TABLE discussion_categories (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL,
                description TEXT NULL,
                color VARCHAR(255) NOT NULL DEFAULT "#3498db",
                icon VARCHAR(255) NULL,
                is_course_specific TINYINT(1) NOT NULL DEFAULT 0,
                course_id BIGINT UNSIGNED NULL,
                `order` INT NOT NULL DEFAULT 0,
                is_active TINYINT(1) NOT NULL DEFAULT 1,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL,
                UNIQUE KEY discussion_categories_slug_unique (slug)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        ');
        
        // Tambahkan foreign key course_id jika tabel courses ada
        if (Schema::hasTable('courses')) {
            DB::statement('
                ALTER TABLE discussion_categories 
                ADD CONSTRAINT fk_discussion_categories_course 
                FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL;
            ');
        }
        
        echo "Tabel discussion_categories berhasil dibuat.\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        exit(1);
    }
} else {
    echo "Tabel discussion_categories sudah ada.\n";
}

// Coba menambahkan foreign key di discussions
echo "\nMenambahkan foreign key untuk discussion_category_id di tabel discussions...\n";

// Periksa apakah foreign key sudah ada
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
} else {
    try {
        DB::statement('ALTER TABLE discussions ADD CONSTRAINT fk_discussions_category FOREIGN KEY (discussion_category_id) REFERENCES discussion_categories(id) ON DELETE SET NULL');
        echo "Foreign key berhasil ditambahkan.\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

echo "\nSelesai!\n"; 