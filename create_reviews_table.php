<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// SQL to create reviews table
$sql = "
CREATE TABLE IF NOT EXISTS `reviews` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `course_id` BIGINT UNSIGNED NOT NULL,
    `rating` TINYINT UNSIGNED NOT NULL,
    `comment` TEXT NULL,
    `is_approved` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `reviews_user_id_foreign` (`user_id`),
    KEY `reviews_course_id_foreign` (`course_id`),
    CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `reviews_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
);";

// Execute the SQL
try {
    \DB::unprepared($sql);
    echo "Reviews table created successfully!\n";
    
    // Get student users to add reviews
    $students = \DB::table('users')
        ->where('role', 'student')
        ->orWhereIn('email', ['student@example.com'])
        ->get();
    
    // Get courses
    $courses = \DB::table('courses')->get();
    
    // Add sample reviews if students and courses exist
    if ($students->count() > 0 && $courses->count() > 0) {
        $student = $students->first();
        
        // Add reviews for each course
        foreach ($courses as $course) {
            // Check if review already exists
            if (\DB::table('reviews')->where(['user_id' => $student->id, 'course_id' => $course->id])->exists()) {
                continue;
            }
            
            // Add random rating and comment
            $rating = rand(3, 5); // Random rating between 3-5 stars (mostly positive)
            $comments = [
                "Great course! I learned a lot.",
                "Very informative and well-structured.",
                "The instructor explains topics clearly.",
                "Good content, but could use more practical examples.",
                "Excellent course with valuable insights."
            ];
            
            \DB::table('reviews')->insert([
                'user_id' => $student->id,
                'course_id' => $course->id,
                'rating' => $rating,
                'comment' => $comments[rand(0, count($comments) - 1)],
                'is_approved' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            echo "Added review for course: {$course->title}\n";
        }
        
        echo "Sample reviews added to courses!\n";
    } else {
        echo "No students or courses found to add sample reviews.\n";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 