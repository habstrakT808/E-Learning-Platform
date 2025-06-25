<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Checking lesson_progress table structure...\n";
    
    // Check if the table exists
    $tableExists = \DB::select("SHOW TABLES LIKE 'lesson_progress'");
    
    if (empty($tableExists)) {
        echo "The lesson_progress table doesn't exist. Please check your database setup.\n";
        exit;
    }
    
    // Check if watch_time column exists
    $columns = \DB::select("SHOW COLUMNS FROM lesson_progress");
    $hasWatchTime = false;
    
    foreach ($columns as $column) {
        echo "- {$column->Field}\n";
        if ($column->Field === 'watch_time') {
            $hasWatchTime = true;
        }
    }
    
    if (!$hasWatchTime) {
        echo "\nAdding watch_time column to lesson_progress table...\n";
        \DB::statement('ALTER TABLE `lesson_progress` ADD COLUMN `watch_time` INT NOT NULL DEFAULT 0 COMMENT "Time watched in seconds"');
        echo "Added watch_time column successfully.\n";
    } else {
        echo "\nwatch_time column already exists in the lesson_progress table.\n";
    }
    
    echo "\nLesson progress table structure has been updated.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 