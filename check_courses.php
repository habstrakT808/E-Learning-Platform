<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check courses
$courses = \DB::table('courses')->get();
echo "Courses in database: " . $courses->count() . "\n";

foreach ($courses as $course) {
    echo "- {$course->title} (ID: {$course->id})\n";
    
    // Get categories for this course
    $categories = \DB::table('categories')
        ->join('course_categories', 'categories.id', '=', 'course_categories.category_id')
        ->where('course_categories.course_id', $course->id)
        ->select('categories.name')
        ->get();
        
    if ($categories->count() > 0) {
        echo "  Categories: ";
        $categoryNames = [];
        foreach ($categories as $category) {
            $categoryNames[] = $category->name;
        }
        echo implode(", ", $categoryNames) . "\n";
    } else {
        echo "  No categories assigned\n";
    }
} 