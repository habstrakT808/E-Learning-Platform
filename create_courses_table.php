<?php
// Script untuk membuat tabel courses
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Memeriksa dan membuat tabel courses jika belum ada...\n";

if (!Schema::hasTable('courses')) {
    echo "Tabel courses tidak ditemukan. Membuat tabel...\n";
    
    try {
        DB::statement('
            CREATE TABLE courses (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT UNSIGNED NOT NULL,
                title VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL,
                description TEXT NULL,
                requirements JSON NULL,
                objectives JSON NULL,
                thumbnail VARCHAR(255) NULL,
                price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
                level VARCHAR(20) NOT NULL DEFAULT "beginner",
                status VARCHAR(20) NOT NULL DEFAULT "draft",
                duration INT NOT NULL DEFAULT 0,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL,
                UNIQUE KEY courses_slug_unique (slug),
                CONSTRAINT fk_courses_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        ');
        
        echo "Tabel courses berhasil dibuat.\n";
        
        // Buat tabel course_categories juga jika belum ada
        if (!Schema::hasTable('course_categories')) {
            DB::statement('
                CREATE TABLE course_categories (
                    course_id BIGINT UNSIGNED NOT NULL,
                    category_id BIGINT UNSIGNED NOT NULL,
                    created_at TIMESTAMP NULL,
                    updated_at TIMESTAMP NULL,
                    PRIMARY KEY (course_id, category_id),
                    CONSTRAINT fk_course_categories_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
                    CONSTRAINT fk_course_categories_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
            ');
            
            echo "Tabel course_categories berhasil dibuat.\n";
        }
        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        exit(1);
    }
} else {
    echo "Tabel courses sudah ada.\n";
}

// Cek apakah kolom status sudah ada di tabel courses
if (Schema::hasTable('courses') && !Schema::hasColumn('courses', 'status')) {
    echo "Menambahkan kolom status ke tabel courses...\n";
    
    try {
        DB::statement('ALTER TABLE courses ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT "draft" AFTER level');
        echo "Kolom status berhasil ditambahkan.\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

echo "\nSelesai!\n"; 