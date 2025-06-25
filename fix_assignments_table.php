<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Current columns in assignments table:\n";
    $columns = \DB::select('SHOW COLUMNS FROM assignments');
    
    // Check if assignments table exists
    if (!$columns) {
        echo "The assignments table doesn't exist yet. Creating it...\n";
        
        // Create the assignments table with all necessary columns
        $sql = "
        CREATE TABLE `assignments` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `course_id` BIGINT UNSIGNED NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT NULL,
            `attachment` VARCHAR(255) NULL,
            `deadline` TIMESTAMP NULL,
            `total_marks` INT NOT NULL DEFAULT 100,
            `pass_marks` INT NOT NULL DEFAULT 50,
            `is_active` TINYINT(1) NOT NULL DEFAULT 1,
            `created_at` TIMESTAMP NULL,
            `updated_at` TIMESTAMP NULL,
            `deleted_at` TIMESTAMP NULL,
            PRIMARY KEY (`id`),
            KEY `assignments_course_id_foreign` (`course_id`),
            CONSTRAINT `assignments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
        )";
        
        \DB::unprepared($sql);
        echo "Created assignments table with all required columns including deleted_at.\n";
    } else {
        // Display current columns
        foreach ($columns as $column) {
            echo "- {$column->Field}\n";
        }
        
        // Check if deleted_at column exists
        $hasDeletedAt = false;
        foreach ($columns as $column) {
            if ($column->Field === 'deleted_at') {
                $hasDeletedAt = true;
                break;
            }
        }
        
        if (!$hasDeletedAt) {
            // Add the deleted_at column
            \DB::statement('ALTER TABLE `assignments` ADD COLUMN `deleted_at` TIMESTAMP NULL');
            echo "\nAdded deleted_at column to assignments table.\n";
        } else {
            echo "\nThe deleted_at column already exists in the assignments table.\n";
        }
    }
    
    echo "\nAssignments table is now ready for soft deletes.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 