<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Checking quizzes table structure...\n";
    
    // Get columns from quizzes table
    $columns = \DB::select('SHOW COLUMNS FROM quizzes');
    
    echo "Current quizzes table columns:\n";
    $hasPassPercentage = false;
    
    foreach ($columns as $column) {
        echo "- {$column->Field}\n";
        if ($column->Field === 'pass_percentage') {
            $hasPassPercentage = true;
        }
    }
    
    // Add missing columns if needed
    if (!$hasPassPercentage) {
        echo "\nAdding pass_percentage column to quizzes table...\n";
        \DB::statement('ALTER TABLE `quizzes` ADD COLUMN `pass_percentage` INT NOT NULL DEFAULT 60');
        echo "Added pass_percentage column\n";
    } else {
        echo "\nThe pass_percentage column already exists\n";
    }
    
    // Check other necessary columns for quizzes table
    $columns = \DB::select('SHOW COLUMNS FROM quizzes');
    $requiredColumns = ['time_limit', 'is_active', 'deleted_at'];
    
    foreach ($requiredColumns as $column) {
        $exists = false;
        foreach ($columns as $tableColumn) {
            if ($tableColumn->Field === $column) {
                $exists = true;
                break;
            }
        }
        
        if (!$exists) {
            echo "Adding {$column} column to quizzes table...\n";
            
            switch ($column) {
                case 'time_limit':
                    \DB::statement('ALTER TABLE `quizzes` ADD COLUMN `time_limit` INT NULL COMMENT "Time limit in minutes"');
                    break;
                case 'is_active':
                    \DB::statement('ALTER TABLE `quizzes` ADD COLUMN `is_active` TINYINT(1) NOT NULL DEFAULT 1');
                    break;
                case 'deleted_at':
                    \DB::statement('ALTER TABLE `quizzes` ADD COLUMN `deleted_at` TIMESTAMP NULL');
                    break;
            }
            
            echo "Added {$column} column\n";
        }
    }
    
    echo "\nQuizzes table structure updated. Now continuing with adding sample quizzes and resources...\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 