<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Get available courses
    $courses = \DB::table('courses')->get();
    
    if ($courses->isEmpty()) {
        echo "No courses found in the database.\n";
        exit;
    }
    
    echo "Found " . $courses->count() . " course(s).\n";
    
    // Check for first course
    $course = $courses->first();
    echo "Checking content for course: " . $course->title . " (ID: {$course->id})\n\n";
    
    // 1. Check Assignments
    echo "ASSIGNMENTS:\n";
    $assignments = \DB::table('assignments')->where('course_id', $course->id)->get();
    echo "Found " . $assignments->count() . " assignments for this course.\n";
    
    // If no assignments, create some
    if ($assignments->isEmpty()) {
        echo "Creating sample assignments...\n";
        
        // Create 2 sample assignments
        $assignmentData = [
            [
                'course_id' => $course->id,
                'title' => 'Midterm Project',
                'description' => 'Create a comprehensive analysis based on the course material.',
                'deadline' => date('Y-m-d H:i:s', strtotime('+2 weeks')),
                'max_score' => 100,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'course_id' => $course->id,
                'title' => 'Final Project',
                'description' => 'Apply what you\'ve learned to solve a real-world problem.',
                'deadline' => date('Y-m-d H:i:s', strtotime('+4 weeks')),
                'max_score' => 100,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        
        foreach ($assignmentData as $assignment) {
            \DB::table('assignments')->insert($assignment);
            echo "Created assignment: {$assignment['title']}\n";
        }
    }
    
    // 2. Check Quizzes
    echo "\nQUIZZES:\n";
    
    // Check if quizzes table exists
    $quizzesTableExists = \DB::select("SHOW TABLES LIKE 'quizzes'");
    
    if (empty($quizzesTableExists)) {
        echo "Quizzes table doesn't exist. Creating it...\n";
        
        // Create quizzes table
        $sql = "
        CREATE TABLE `quizzes` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `course_id` BIGINT UNSIGNED NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT NULL,
            `time_limit` INT NULL COMMENT 'Time limit in minutes',
            `pass_percentage` INT NOT NULL DEFAULT 60,
            `is_active` TINYINT(1) NOT NULL DEFAULT 1,
            `created_at` TIMESTAMP NULL,
            `updated_at` TIMESTAMP NULL,
            `deleted_at` TIMESTAMP NULL,
            PRIMARY KEY (`id`),
            KEY `quizzes_course_id_foreign` (`course_id`),
            CONSTRAINT `quizzes_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
        )";
        
        \DB::unprepared($sql);
        
        // Create quiz_questions table if it doesn't exist
        $sql = "
        CREATE TABLE IF NOT EXISTS `quiz_questions` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `quiz_id` BIGINT UNSIGNED NOT NULL,
            `question` TEXT NOT NULL,
            `question_type` VARCHAR(20) NOT NULL DEFAULT 'multiple_choice',
            `options` JSON NULL,
            `correct_answer` TEXT NOT NULL,
            `points` INT NOT NULL DEFAULT 1,
            `order` INT NOT NULL DEFAULT 0,
            `created_at` TIMESTAMP NULL,
            `updated_at` TIMESTAMP NULL,
            PRIMARY KEY (`id`),
            KEY `quiz_questions_quiz_id_foreign` (`quiz_id`),
            CONSTRAINT `quiz_questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE
        )";
        
        \DB::unprepared($sql);
        echo "Created quizzes and quiz_questions tables.\n";
    }
    
    // Check for quizzes in this course
    $quizzes = \DB::table('quizzes')->where('course_id', $course->id)->get();
    echo "Found " . $quizzes->count() . " quizzes for this course.\n";
    
    // If no quizzes, create some
    if ($quizzes->isEmpty()) {
        echo "Creating sample quizzes...\n";
        
        // Create 2 sample quizzes
        $quizData = [
            [
                'course_id' => $course->id,
                'title' => 'Module 1 Quiz',
                'description' => 'Test your knowledge of the fundamental concepts.',
                'time_limit' => 30,
                'pass_percentage' => 70,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'course_id' => $course->id,
                'title' => 'Final Assessment',
                'description' => 'Comprehensive quiz covering all course material.',
                'time_limit' => 60,
                'pass_percentage' => 80,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        
        foreach ($quizData as $quiz) {
            $quizId = \DB::table('quizzes')->insertGetId($quiz);
            echo "Created quiz: {$quiz['title']}\n";
            
            // Add sample questions to this quiz
            $questions = [
                [
                    'quiz_id' => $quizId,
                    'question' => 'What is the primary purpose of this course?',
                    'question_type' => 'multiple_choice',
                    'options' => json_encode(['A) Learning basics', 'B) Advanced techniques', 'C) Both A and B', 'D) Neither']),
                    'correct_answer' => 'C) Both A and B',
                    'points' => 5,
                    'order' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'quiz_id' => $quizId,
                    'question' => 'Which of the following is a best practice?',
                    'question_type' => 'multiple_choice',
                    'options' => json_encode(['A) Option 1', 'B) Option 2', 'C) Option 3', 'D) All of the above']),
                    'correct_answer' => 'D) All of the above',
                    'points' => 5,
                    'order' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ];
            
            foreach ($questions as $question) {
                \DB::table('quiz_questions')->insert($question);
            }
            
            echo "Added " . count($questions) . " questions to quiz: {$quiz['title']}\n";
        }
    }
    
    // 3. Check Resources
    echo "\nRESOURCES:\n";
    
    // Check if resources table exists
    $resourcesTableExists = \DB::select("SHOW TABLES LIKE 'resources'");
    
    if (empty($resourcesTableExists)) {
        echo "Resources table doesn't exist. Creating it...\n";
        
        // Create resources table
        $sql = "
        CREATE TABLE `resources` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `course_id` BIGINT UNSIGNED NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT NULL,
            `type` VARCHAR(50) NOT NULL DEFAULT 'file',
            `file_path` VARCHAR(255) NULL,
            `external_url` VARCHAR(255) NULL,
            `is_active` TINYINT(1) NOT NULL DEFAULT 1,
            `created_at` TIMESTAMP NULL,
            `updated_at` TIMESTAMP NULL,
            `deleted_at` TIMESTAMP NULL,
            PRIMARY KEY (`id`),
            KEY `resources_course_id_foreign` (`course_id`),
            CONSTRAINT `resources_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
        )";
        
        \DB::unprepared($sql);
        echo "Created resources table.\n";
    }
    
    // Check for resources in this course
    $resources = \DB::table('resources')->where('course_id', $course->id)->get();
    echo "Found " . $resources->count() . " resources for this course.\n";
    
    // If no resources, create some
    if ($resources->isEmpty()) {
        echo "Creating sample resources...\n";
        
        // Create sample resources
        $resourceData = [
            [
                'course_id' => $course->id,
                'title' => 'Course Syllabus',
                'description' => 'Complete course outline and learning objectives.',
                'type' => 'file',
                'file_path' => 'resources/course_syllabus.pdf',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'course_id' => $course->id,
                'title' => 'Supplementary Reading',
                'description' => 'Additional materials to enhance your understanding.',
                'type' => 'file',
                'file_path' => 'resources/supplementary_reading.pdf',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'course_id' => $course->id,
                'title' => 'Recommended Tutorials',
                'description' => 'External tutorials that complement the course material.',
                'type' => 'url',
                'external_url' => 'https://www.example.com/tutorials',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        
        foreach ($resourceData as $resource) {
            \DB::table('resources')->insert($resource);
            echo "Created resource: {$resource['title']}\n";
        }
    }
    
    echo "\nSUMMARY:\n";
    echo "Assignments: " . \DB::table('assignments')->where('course_id', $course->id)->count() . "\n";
    echo "Quizzes: " . \DB::table('quizzes')->where('course_id', $course->id)->count() . "\n";
    echo "Resources: " . \DB::table('resources')->where('course_id', $course->id)->count() . "\n";
    echo "\nAll course content has been verified and populated. You should now see assignments, quizzes, and resources in the course content.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 