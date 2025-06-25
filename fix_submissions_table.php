<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Checking submissions table structure...\n";
    
    // Check if the table exists
    $tableExists = \DB::select("SHOW TABLES LIKE 'submissions'");
    
    if (empty($tableExists)) {
        echo "The submissions table doesn't exist. Creating it...\n";
        
        $sql = "
        CREATE TABLE `submissions` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `assignment_id` BIGINT UNSIGNED NOT NULL,
            `user_id` BIGINT UNSIGNED NOT NULL,
            `content` TEXT NULL,
            `file_path` VARCHAR(255) NULL,
            `original_filename` VARCHAR(255) NULL,
            `score` INT NULL,
            `feedback` TEXT NULL,
            `status` VARCHAR(20) DEFAULT 'pending' NOT NULL,
            `submitted_at` TIMESTAMP NULL,
            `graded_at` TIMESTAMP NULL,
            `created_at` TIMESTAMP NULL,
            `updated_at` TIMESTAMP NULL,
            `deleted_at` TIMESTAMP NULL,
            PRIMARY KEY (`id`),
            KEY `submissions_assignment_id_foreign` (`assignment_id`),
            KEY `submissions_user_id_foreign` (`user_id`),
            CONSTRAINT `submissions_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
            CONSTRAINT `submissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
        )";
        
        \DB::unprepared($sql);
        echo "Created submissions table with all required columns.\n";
    } else {
        echo "Submissions table exists. Checking structure...\n";
        
        // Check if deleted_at column exists
        $columns = \DB::select("SHOW COLUMNS FROM submissions");
        $columnNames = array_map(function($column) {
            return $column->Field;
        }, $columns);
        
        echo "\nCurrent columns in submissions table:\n";
        foreach ($columnNames as $column) {
            echo "- {$column}\n";
        }
        
        if (!in_array('deleted_at', $columnNames)) {
            echo "\nAdding deleted_at column to submissions table...\n";
            \DB::statement('ALTER TABLE `submissions` ADD COLUMN `deleted_at` TIMESTAMP NULL');
            echo "Added deleted_at column successfully.\n";
        } else {
            echo "\ndeleted_at column already exists.\n";
        }
    }
    
    // Check if the Submission model uses SoftDeletes
    $modelPath = app_path('Models/Submission.php');
    
    if (file_exists($modelPath)) {
        echo "\nChecking Submission model...\n";
        
        $modelContents = file_get_contents($modelPath);
        
        if (strpos($modelContents, 'use SoftDeletes') === false || strpos($modelContents, 'use Illuminate\Database\Eloquent\SoftDeletes') === false) {
            echo "NOTE: The Submission model doesn't appear to use SoftDeletes trait.\n";
            echo "You may need to add the following to your model:\n\n";
            echo "use Illuminate\Database\Eloquent\SoftDeletes;\n";
            echo "...\n";
            echo "class Submission extends Model\n";
            echo "{\n";
            echo "    use HasFactory, SoftDeletes;\n";
            echo "    ...\n";
        } else {
            echo "Submission model correctly uses SoftDeletes trait.\n";
        }
    } else {
        echo "\nSubmission model not found at {$modelPath}. You may need to create it.\n";
    }
    
    echo "\nSubmissions table has been fixed with the required deleted_at column.\n";
    echo "You can now continue using the application.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 