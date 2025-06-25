<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Assignment;
use Illuminate\Support\Str;

// Course ID (Complete Laravel Development Course)
$courseId = 1;

// Create Assignment
echo "Creating assignment...\n";
try {
    $assignment = Assignment::create([
        'course_id' => $courseId,
        'title' => 'Build a RESTful API with Laravel',
        'description' => 'Create a simple RESTful API for a blog with posts and comments. Your API should support CRUD operations for both resources and implement proper validation, authentication and error handling.',
        'slug' => Str::slug('Build a RESTful API with Laravel'),
        'deadline' => now()->addDays(7),
        'max_score' => 100,
        'max_attempts' => 3,
        'is_active' => true,
    ]);

    echo "Assignment created with ID: " . $assignment->id . "\n";
} catch (Exception $e) {
    echo "Error creating assignment: " . $e->getMessage() . "\n";
}

echo "Done!\n"; 