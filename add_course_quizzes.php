<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Adding quizzes to courses...\n\n";
    
    // Check quizzes table structure
    $columns = \DB::select("SHOW COLUMNS FROM quizzes");
    echo "Quizzes table structure:\n";
    foreach ($columns as $column) {
        echo "- {$column->Field}\n";
    }
    echo "\n";
    
    // Get all courses
    $courses = \DB::table('courses')->get();
    
    foreach ($courses as $course) {
        echo "Processing course: {$course->title} (ID: {$course->id})\n";
        
        // Check if course already has quizzes
        $quizCount = \DB::table('quizzes')->where('course_id', $course->id)->count();
        
        if ($quizCount == 0) {
            // Check if course has sections
            $sections = \DB::table('course_sections')->where('course_id', $course->id)->get();
            
            if ($sections->isEmpty()) {
                echo "Course has no sections. Creating a default section...\n";
                
                $sectionId = \DB::table('course_sections')->insertGetId([
                    'course_id' => $course->id,
                    'title' => 'Course Content',
                    'order' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                echo "Created section: Course Content (ID: {$sectionId})\n";
            } else {
                $sectionId = $sections->first()->id;
                echo "Using existing section: {$sections->first()->title} (ID: {$sectionId})\n";
            }
            
            // Create quizzes for this course
            $quizData = [
                [
                    'course_id' => $course->id,
                    'section_id' => $sectionId,
                    'title' => 'Mid-term Quiz',
                    'description' => 'Test your knowledge of the course fundamentals.',
                    'time_limit' => 30,
                    'passing_score' => 70,
                    'max_attempts' => 3,
                    'show_correct_answers' => 1,
                    'randomize_questions' => 0,
                    'is_published' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'course_id' => $course->id,
                    'section_id' => $sectionId,
                    'title' => 'Final Quiz',
                    'description' => 'Comprehensive assessment of your knowledge.',
                    'time_limit' => 60,
                    'passing_score' => 80,
                    'max_attempts' => 2,
                    'show_correct_answers' => 1,
                    'randomize_questions' => 1,
                    'is_published' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ];
            
            foreach ($quizData as $quiz) {
                $quizId = \DB::table('quizzes')->insertGetId($quiz);
                echo "- Added quiz: {$quiz['title']} (ID: {$quizId})\n";
            }
        } else {
            echo "Course already has {$quizCount} quizzes. Skipping.\n";
        }
        
        echo "\n";
    }
    
    echo "Quiz setup complete. You should now see quizzes in your courses!\n";
    echo "Please refresh your browser to see the updated course content.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 