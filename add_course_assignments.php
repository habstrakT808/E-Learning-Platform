<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Adding assignments to courses...\n\n";
    
    // Check assignments table structure
    $columns = \DB::select("SHOW COLUMNS FROM assignments");
    echo "Assignments table structure:\n";
    foreach ($columns as $column) {
        echo "- {$column->Field}\n";
    }
    echo "\n";
    
    // Get all courses
    $courses = \DB::table('courses')->get();
    
    foreach ($courses as $course) {
        echo "Processing course: {$course->title} (ID: {$course->id})\n";
        
        // Check if course already has assignments
        $assignmentCount = \DB::table('assignments')->where('course_id', $course->id)->count();
        
        if ($assignmentCount == 0) {
            // Create assignments for this course
            $assignmentData = [
                [
                    'course_id' => $course->id,
                    'title' => 'Midterm Project',
                    'description' => 'Create a comprehensive analysis based on the first half of the course material.',
                    'deadline' => date('Y-m-d H:i:s', strtotime('+2 weeks')),
                    'max_score' => 100,
                    'max_attempts' => 3,
                    'is_active' => 1,
                    'allow_late_submission' => 1,
                    'allowed_file_types' => json_encode(['pdf', 'doc', 'docx']),
                    'max_file_size' => 5, // 5MB
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'course_id' => $course->id,
                    'title' => 'Final Project',
                    'description' => 'Apply everything you\'ve learned to solve a real-world problem.',
                    'deadline' => date('Y-m-d H:i:s', strtotime('+4 weeks')),
                    'max_score' => 100,
                    'max_attempts' => 2,
                    'is_active' => 1,
                    'allow_late_submission' => 0,
                    'allowed_file_types' => json_encode(['pdf', 'doc', 'docx', 'zip']),
                    'max_file_size' => 10, // 10MB
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ];
            
            foreach ($assignmentData as $assignment) {
                \DB::table('assignments')->insert($assignment);
                echo "- Added assignment: {$assignment['title']}\n";
            }
        } else {
            echo "Course already has {$assignmentCount} assignments. Skipping.\n";
        }
        
        echo "\n";
    }
    
    echo "Assignment setup complete. You should now see assignments in your courses!\n";
    echo "Please refresh your browser to see the updated course content.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 