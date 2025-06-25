<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Checking important tables structure...\n\n";
    
    // Tables to check
    $tables = [
        'lessons',
        'quizzes', 
        'assignments',
        'resources',
        'course_sections'
    ];
    
    foreach ($tables as $table) {
        echo "TABLE: {$table}\n";
        echo "-------------------\n";
        
        $tableExists = \DB::select("SHOW TABLES LIKE '{$table}'");
        
        if (!empty($tableExists)) {
            // Get columns
            $columns = \DB::select("SHOW COLUMNS FROM {$table}");
            
            foreach ($columns as $column) {
                echo "{$column->Field} - {$column->Type}";
                if ($column->Key) echo " [{$column->Key}]";
                echo "\n";
            }
            
            // Get count
            $count = \DB::table($table)->count();
            echo "\nTotal records: {$count}\n\n";
        } else {
            echo "Table doesn't exist in the database.\n\n";
        }
    }
    
    // Check course data
    echo "COURSE DATA:\n";
    echo "--------------\n";
    $courses = \DB::table('courses')->get(['id', 'title', 'status']);
    
    foreach ($courses as $course) {
        echo "Course #{$course->id}: {$course->title} (Status: {$course->status})\n";
    }
    
    echo "\nDatabase structure check complete.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 