<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Checking quiz_questions table structure...\n";
    
    // Check if the table exists
    $tableExists = DB::select("SHOW TABLES LIKE 'quiz_questions'");
    
    if (empty($tableExists)) {
        echo "The quiz_questions table doesn't exist. Please run create_quiz_tables.php first.\n";
        exit;
    }
    
    // Get current columns
    $columns = DB::select("SHOW COLUMNS FROM quiz_questions");
    $columnNames = array_map(function($col) { return $col->Field; }, $columns);
    
    echo "Current columns in quiz_questions table:\n";
    foreach ($columnNames as $column) {
        echo "- {$column}\n";
    }
    
    // Check if question_type column exists
    if (!in_array('question_type', $columnNames)) {
        echo "\nAdding question_type column to quiz_questions table...\n";
        
        DB::statement("
            ALTER TABLE `quiz_questions`
            ADD COLUMN `question_type` ENUM('multiple_choice', 'true_false', 'short_answer') NOT NULL DEFAULT 'multiple_choice'
        ");
        
        echo "Added question_type column successfully.\n";
    } else {
        echo "\nquestion_type column already exists.\n";
    }
    
    // Let's also check if points column exists
    if (!in_array('points', $columnNames)) {
        echo "\nAdding points column to quiz_questions table...\n";
        
        DB::statement("
            ALTER TABLE `quiz_questions`
            ADD COLUMN `points` INT NOT NULL DEFAULT 1
        ");
        
        echo "Added points column successfully.\n";
    } else {
        echo "\npoints column already exists.\n";
    }
    
    // Let's also check if deleted_at column exists for soft deletes
    if (!in_array('deleted_at', $columnNames)) {
        echo "\nAdding deleted_at column for soft deletes...\n";
        
        DB::statement("
            ALTER TABLE `quiz_questions`
            ADD COLUMN `deleted_at` TIMESTAMP NULL
        ");
        
        echo "Added deleted_at column successfully.\n";
    } else {
        echo "\ndeleted_at column already exists.\n";
    }
    
    // Check quiz_question_options table
    echo "\nChecking quiz_question_options table structure...\n";
    
    $optionsTableExists = DB::select("SHOW TABLES LIKE 'quiz_question_options'");
    
    if (empty($optionsTableExists)) {
        echo "The quiz_question_options table doesn't exist. Please run create_quiz_tables.php first.\n";
        exit;
    }
    
    // Get current columns
    $optionColumns = DB::select("SHOW COLUMNS FROM quiz_question_options");
    $optionColumnNames = array_map(function($col) { return $col->Field; }, $optionColumns);
    
    echo "Current columns in quiz_question_options table:\n";
    foreach ($optionColumnNames as $column) {
        echo "- {$column}\n";
    }
    
    // Check if deleted_at column exists for soft deletes
    if (!in_array('deleted_at', $optionColumnNames)) {
        echo "\nAdding deleted_at column for soft deletes to quiz_question_options table...\n";
        
        DB::statement("
            ALTER TABLE `quiz_question_options`
            ADD COLUMN `deleted_at` TIMESTAMP NULL
        ");
        
        echo "Added deleted_at column successfully.\n";
    } else {
        echo "\ndeleted_at column already exists in quiz_question_options table.\n";
    }
    
    echo "\nTables are now ready for adding quiz questions.\n";
    echo "Run add_sample_quiz_questions.php to add the sample questions.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} 