<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Adding sample lesson progress data...\n\n";
    
    // Get first user and first course
    $user = \App\Models\User::first();
    
    if (!$user) {
        echo "No users found in the database.\n";
        exit(1);
    }
    
    echo "Working with user: {$user->name} (ID: {$user->id})\n";
    
    // Get first course or a specific course
    $course = \App\Models\Course::first();
    
    if (!$course) {
        echo "No courses found in the database.\n";
        exit(1);
    }
    
    echo "Working with course: {$course->title} (ID: {$course->id})\n";
    
    // Find or create enrollment
    $enrollment = \App\Models\Enrollment::firstOrCreate(
        [
            'user_id' => $user->id,
            'course_id' => $course->id,
        ],
        [
            'status' => 'active',
            'progress' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]
    );
    
    echo "Using enrollment ID: {$enrollment->id}\n\n";
    
    // Get all lessons for the course
    $lessons = \App\Models\Lesson::whereHas('section', function($query) use ($course) {
        $query->where('course_id', $course->id);
    })->get();
    
    if ($lessons->isEmpty()) {
        echo "No lessons found for this course. Please add some lessons first.\n";
        exit(1);
    }
    
    echo "Found {$lessons->count()} lessons. Adding progress data...\n";
    
    $totalAdded = 0;
    $totalUpdated = 0;
    
    foreach ($lessons as $index => $lesson) {
        // Create random progress based on lesson position
        // Earlier lessons have more progress than later ones
        $progressPercentage = max(0, min(100, 100 - ($index * (100 / $lessons->count()))));
        $isCompleted = $progressPercentage >= 90;
        $watchTime = 0;
        
        if ($lesson->duration) {
            $watchTime = ($lesson->duration * 60) * ($progressPercentage / 100);
        } else {
            // If no duration set, use some random value between 5-30 minutes
            $randomDuration = rand(300, 1800);
            $watchTime = $randomDuration * ($progressPercentage / 100);
        }
        
        // Round to nearest second
        $watchTime = round($watchTime);
        
        // Create or update progress record
        $progress = \App\Models\LessonProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
            ],
            [
                'enrollment_id' => $enrollment->id,
                'is_completed' => $isCompleted,
                'completed_at' => $isCompleted ? now()->subDays(rand(0, 7)) : null,
                'watch_time' => $watchTime,
                'updated_at' => now()->subDays(rand(0, 14))
            ]
        );
        
        if ($progress->wasRecentlyCreated) {
            $totalAdded++;
            echo "+ Added progress for lesson '{$lesson->title}': {$watchTime}s watched, " . 
                 ($isCompleted ? 'completed' : 'in progress') . "\n";
        } else {
            $totalUpdated++;
            echo "~ Updated progress for lesson '{$lesson->title}': {$watchTime}s watched, " . 
                 ($isCompleted ? 'completed' : 'in progress') . "\n";
        }
    }
    
    // Update enrollment progress
    $enrollment->calculateProgress();
    $enrollment->refresh();
    
    echo "\nFinished processing {$lessons->count()} lessons.\n";
    echo "Added: {$totalAdded}, Updated: {$totalUpdated}\n";
    echo "Updated enrollment progress to {$enrollment->progress}%\n";
    
    echo "\nSample progress data has been added successfully!\n";
    echo "You should now see progress in the course dashboard.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
} 