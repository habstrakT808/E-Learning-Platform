<?php
// Script untuk membuat tabel quizzes dan tabel terkait
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Membuat tabel quizzes dan tabel terkait...\n";

// Cek apakah tabel quizzes sudah ada
if (!Schema::hasTable('quizzes')) {
    echo "Tabel quizzes tidak ditemukan. Membuat tabel...\n";
    
    try {
        // Create quizzes table
        DB::statement('
            CREATE TABLE `quizzes` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `course_id` BIGINT UNSIGNED NOT NULL,
                `title` VARCHAR(255) NOT NULL,
                `description` TEXT NULL,
                `slug` VARCHAR(255) NOT NULL,
                `time_limit` INT NOT NULL DEFAULT 30,
                `pass_percentage` INT NOT NULL DEFAULT 70,
                `max_attempts` INT NOT NULL DEFAULT 3,
                `is_published` TINYINT(1) NOT NULL DEFAULT 0,
                `randomize_questions` TINYINT(1) NOT NULL DEFAULT 0,
                `show_correct_answers` TINYINT(1) NOT NULL DEFAULT 1,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL,
                UNIQUE KEY `quizzes_slug_unique` (`slug`),
                CONSTRAINT `quizzes_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        ');
        echo "Tabel quizzes berhasil dibuat.\n";
    } catch (Exception $e) {
        echo "Error saat membuat tabel quizzes: " . $e->getMessage() . "\n";
    }
} else {
    echo "Tabel quizzes sudah ada.\n";
}

// Cek apakah tabel quiz_questions sudah ada
if (!Schema::hasTable('quiz_questions')) {
    echo "Tabel quiz_questions tidak ditemukan. Membuat tabel...\n";
    
    try {
        // Create quiz_questions table
        DB::statement('
            CREATE TABLE `quiz_questions` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `quiz_id` BIGINT UNSIGNED NOT NULL,
                `question` TEXT NOT NULL,
                `type` VARCHAR(255) NOT NULL DEFAULT "multiple_choice",
                `points` INT NOT NULL DEFAULT 10,
                `order` INT NOT NULL DEFAULT 0,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL,
                CONSTRAINT `quiz_questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        ');
        echo "Tabel quiz_questions berhasil dibuat.\n";
    } catch (Exception $e) {
        echo "Error saat membuat tabel quiz_questions: " . $e->getMessage() . "\n";
    }
} else {
    echo "Tabel quiz_questions sudah ada.\n";
}

// Cek apakah tabel quiz_question_options sudah ada
if (!Schema::hasTable('quiz_question_options')) {
    echo "Tabel quiz_question_options tidak ditemukan. Membuat tabel...\n";
    
    try {
        // Create quiz_question_options table
        DB::statement('
            CREATE TABLE `quiz_question_options` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `quiz_question_id` BIGINT UNSIGNED NOT NULL,
                `option_text` TEXT NOT NULL,
                `is_correct` TINYINT(1) NOT NULL DEFAULT 0,
                `order` INT NOT NULL DEFAULT 0,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL,
                CONSTRAINT `quiz_question_options_quiz_question_id_foreign` FOREIGN KEY (`quiz_question_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        ');
        echo "Tabel quiz_question_options berhasil dibuat.\n";
    } catch (Exception $e) {
        echo "Error saat membuat tabel quiz_question_options: " . $e->getMessage() . "\n";
    }
} else {
    echo "Tabel quiz_question_options sudah ada.\n";
}

// Cek apakah tabel quiz_attempts sudah ada
if (!Schema::hasTable('quiz_attempts')) {
    echo "Tabel quiz_attempts tidak ditemukan. Membuat tabel...\n";
    
    try {
        // Create quiz_attempts table
        DB::statement('
            CREATE TABLE `quiz_attempts` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `user_id` BIGINT UNSIGNED NOT NULL,
                `quiz_id` BIGINT UNSIGNED NOT NULL,
                `attempt_number` INT NOT NULL,
                `started_at` TIMESTAMP NULL,
                `submitted_at` TIMESTAMP NULL,
                `graded_at` TIMESTAMP NULL,
                `time_spent` INT NULL,
                `score` DECIMAL(5, 2) NULL,
                `is_passed` TINYINT(1) NOT NULL DEFAULT 0,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL,
                UNIQUE KEY `quiz_attempts_user_id_quiz_id_attempt_number_unique` (`user_id`, `quiz_id`, `attempt_number`),
                CONSTRAINT `quiz_attempts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
                CONSTRAINT `quiz_attempts_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        ');
        echo "Tabel quiz_attempts berhasil dibuat.\n";
    } catch (Exception $e) {
        echo "Error saat membuat tabel quiz_attempts: " . $e->getMessage() . "\n";
    }
} else {
    echo "Tabel quiz_attempts sudah ada.\n";
}

// Cek apakah tabel quiz_answers sudah ada
if (!Schema::hasTable('quiz_answers')) {
    echo "Tabel quiz_answers tidak ditemukan. Membuat tabel...\n";
    
    try {
        // Create quiz_answers table
        DB::statement('
            CREATE TABLE `quiz_answers` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `quiz_attempt_id` BIGINT UNSIGNED NOT NULL,
                `quiz_question_id` BIGINT UNSIGNED NOT NULL,
                `quiz_question_option_id` BIGINT UNSIGNED NULL,
                `answer_text` TEXT NULL,
                `is_correct` TINYINT(1) NOT NULL DEFAULT 0,
                `points_earned` DECIMAL(5, 2) NOT NULL DEFAULT 0,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL,
                UNIQUE KEY `quiz_answers_quiz_attempt_id_quiz_question_id_unique` (`quiz_attempt_id`, `quiz_question_id`),
                CONSTRAINT `quiz_answers_quiz_attempt_id_foreign` FOREIGN KEY (`quiz_attempt_id`) REFERENCES `quiz_attempts` (`id`) ON DELETE CASCADE,
                CONSTRAINT `quiz_answers_quiz_question_id_foreign` FOREIGN KEY (`quiz_question_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE,
                CONSTRAINT `quiz_answers_quiz_question_option_id_foreign` FOREIGN KEY (`quiz_question_option_id`) REFERENCES `quiz_question_options` (`id`) ON DELETE SET NULL
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        ');
        echo "Tabel quiz_answers berhasil dibuat.\n";
    } catch (Exception $e) {
        echo "Error saat membuat tabel quiz_answers: " . $e->getMessage() . "\n";
    }
} else {
    echo "Tabel quiz_answers sudah ada.\n";
}

echo "\nSelesai!\n"; 