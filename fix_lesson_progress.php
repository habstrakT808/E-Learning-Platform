<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Fixing lesson_progress table...\n\n";
    
    // Check if the table exists
    $tableExists = \DB::select("SHOW TABLES LIKE 'lesson_progress'");
    
    if (empty($tableExists)) {
        echo "The lesson_progress table doesn't exist. Creating it...\n";
        
        $sql = "
        CREATE TABLE `lesson_progress` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `user_id` BIGINT UNSIGNED NOT NULL,
            `lesson_id` BIGINT UNSIGNED NOT NULL,
            `enrollment_id` BIGINT UNSIGNED NULL,
            `completed` TINYINT(1) NOT NULL DEFAULT 0,
            `watch_time` INT NOT NULL DEFAULT 0 COMMENT 'Time watched in seconds',
            `last_watched_at` TIMESTAMP NULL,
            `completed_at` TIMESTAMP NULL,
            `created_at` TIMESTAMP NULL,
            `updated_at` TIMESTAMP NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `lesson_progress_user_lesson_unique` (`user_id`, `lesson_id`),
            KEY `lesson_progress_lesson_id_foreign` (`lesson_id`),
            KEY `lesson_progress_enrollment_id_foreign` (`enrollment_id`),
            CONSTRAINT `lesson_progress_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
            CONSTRAINT `lesson_progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
            CONSTRAINT `lesson_progress_enrollment_id_foreign` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`id`) ON DELETE CASCADE
        )";
        
        \DB::unprepared($sql);
        echo "Created lesson_progress table with all required columns.\n";
    } else {
        echo "Lesson progress table exists. Checking structure...\n";
        
        // Check for required columns
        $columns = \DB::select("SHOW COLUMNS FROM lesson_progress");
        $columnNames = array_map(function($column) {
            return $column->Field;
        }, $columns);
        
        echo "\nCurrent columns in lesson_progress table:\n";
        foreach ($columnNames as $column) {
            echo "- {$column}\n";
        }
        
        // Check for watch_time column
        if (!in_array('watch_time', $columnNames)) {
            echo "\nAdding watch_time column...\n";
            \DB::statement('ALTER TABLE `lesson_progress` ADD COLUMN `watch_time` INT NOT NULL DEFAULT 0 COMMENT "Time watched in seconds"');
            echo "Added watch_time column successfully.\n";
        } else {
            echo "\nwatch_time column already exists.\n";
        }
        
        // Check for enrollment_id column
        if (!in_array('enrollment_id', $columnNames)) {
            echo "\nAdding enrollment_id column...\n";
            \DB::statement('ALTER TABLE `lesson_progress` ADD COLUMN `enrollment_id` BIGINT UNSIGNED NULL');
            
            // Add foreign key if possible
            try {
                \DB::statement('ALTER TABLE `lesson_progress` ADD CONSTRAINT `lesson_progress_enrollment_id_foreign` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`id`) ON DELETE CASCADE');
                echo "Added enrollment_id column with foreign key constraint.\n";
            } catch (\Exception $e) {
                echo "Added enrollment_id column but couldn't add foreign key constraint: " . $e->getMessage() . "\n";
            }
        } else {
            echo "\nenrollment_id column already exists.\n";
        }
        
        // Check if we need to rename 'completed' to 'is_completed'
        if (in_array('completed', $columnNames) && !in_array('is_completed', $columnNames)) {
            echo "\nRenaming 'completed' column to 'is_completed'...\n";
            // Rename the column
            try {
                \DB::statement('ALTER TABLE `lesson_progress` CHANGE `completed` `is_completed` TINYINT(1) NOT NULL DEFAULT 0');
                echo "Renamed column successfully.\n";
            } catch (\Exception $e) {
                echo "Couldn't rename column: " . $e->getMessage() . "\n";
            }
        } elseif (in_array('is_completed', $columnNames)) {
            echo "\nis_completed column already exists.\n";
        }
    }
    
    echo "\nLesson progress table has been fixed with all required columns.\n";
    echo "You can now continue using the application.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 