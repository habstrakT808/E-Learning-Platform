<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Get the first course
    $course = \DB::table('courses')->first();
    
    if (!$course) {
        echo "No courses found in the database.\n";
        exit;
    }
    
    echo "Working with course: " . $course->title . " (ID: {$course->id})\n\n";
    
    // 1. Add assignments if needed
    echo "STEP 1: Adding assignments\n";
    $assignmentCount = \DB::table('assignments')->where('course_id', $course->id)->count();
    
    if ($assignmentCount == 0) {
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
        }
        echo "Added 2 assignments\n";
    } else {
        echo "Found {$assignmentCount} existing assignments\n";
    }
    
    // 2. Add quizzes if needed
    echo "\nSTEP 2: Adding quizzes\n";
    $quizCount = \DB::table('quizzes')->where('course_id', $course->id)->count();
    
    if ($quizCount == 0) {
        // Get the first section of the course, if any
        $section = \DB::table('course_sections')->where('course_id', $course->id)->first();
        $sectionId = $section ? $section->id : null;
        
        // Add two sample quizzes
        $quizData = [
            [
                'course_id' => $course->id,
                'section_id' => $sectionId,
                'title' => 'Module 1 Quiz',
                'description' => 'Test your knowledge of the fundamental concepts.',
                'time_limit' => 30,
                'passing_score' => 70,
                'pass_percentage' => 70,
                'max_attempts' => 3,
                'show_correct_answers' => 1,
                'randomize_questions' => 0,
                'is_published' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'course_id' => $course->id,
                'section_id' => $sectionId,
                'title' => 'Final Assessment',
                'description' => 'Comprehensive quiz covering all course material.',
                'time_limit' => 60,
                'passing_score' => 80,
                'pass_percentage' => 80,
                'max_attempts' => 2,
                'show_correct_answers' => 1,
                'randomize_questions' => 1,
                'is_published' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        
        foreach ($quizData as $quiz) {
            $quizId = \DB::table('quizzes')->insertGetId($quiz);
            echo "Created quiz: {$quiz['title']}\n";
            
            // Check if quiz_questions table exists
            $questionsTableExists = \DB::select("SHOW TABLES LIKE 'quiz_questions'");
            
            if (!empty($questionsTableExists)) {
                // Add sample questions for this quiz
                $questionData = [
                    [
                        'quiz_id' => $quizId,
                        'question' => 'What is the primary purpose of this course?',
                        'question_type' => 'multiple_choice',
                        'options' => json_encode(['Learning basics', 'Advanced techniques', 'Both A and B', 'Neither']),
                        'correct_answer' => 'Both A and B',
                        'points' => 5,
                        'order' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    [
                        'quiz_id' => $quizId,
                        'question' => 'Which of the following is a best practice?',
                        'question_type' => 'multiple_choice',
                        'options' => json_encode(['Option 1', 'Option 2', 'Option 3', 'All of the above']),
                        'correct_answer' => 'All of the above',
                        'points' => 5,
                        'order' => 2,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                ];
                
                foreach ($questionData as $question) {
                    \DB::table('quiz_questions')->insert($question);
                }
                
                echo "Added sample questions to quiz {$quiz['title']}\n";
            } else {
                echo "Quiz questions table doesn't exist. Skipping adding questions.\n";
            }
        }
        
        echo "Added 2 quizzes\n";
    } else {
        echo "Found {$quizCount} existing quizzes\n";
    }
    
    // 3. Check resources table and add resources if needed
    echo "\nSTEP 3: Adding resources\n";
    
    // Check if resources table exists
    $resourcesTableExists = \DB::select("SHOW TABLES LIKE 'resources'");
    
    if (empty($resourcesTableExists)) {
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
        echo "Created resources table\n";
    }
    
    // Add resources
    $resourceCount = \DB::table('resources')->where('course_id', $course->id)->count();
    
    if ($resourceCount == 0) {
        // Add sample resources
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
        }
        echo "Added 3 resources\n";
    } else {
        echo "Found {$resourceCount} existing resources\n";
    }
    
    // 4. Make sure course_sections and lessons exist
    echo "\nSTEP 4: Checking course sections and lessons\n";
    $sectionCount = \DB::table('course_sections')->where('course_id', $course->id)->count();
    
    if ($sectionCount == 0) {
        // Add sample sections
        $sectionIds = [];
        $sectionData = [
            [
                'course_id' => $course->id,
                'title' => 'Introduction',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'course_id' => $course->id,
                'title' => 'Core Concepts',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'course_id' => $course->id,
                'title' => 'Advanced Topics',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        
        foreach ($sectionData as $section) {
            $sectionId = \DB::table('course_sections')->insertGetId($section);
            $sectionIds[] = $sectionId;
        }
        
        echo "Added 3 course sections\n";
        
        // Add lessons to each section
        $lessonsTableExists = \DB::select("SHOW TABLES LIKE 'lessons'");
        
        if (!empty($lessonsTableExists)) {
            foreach ($sectionIds as $index => $sectionId) {
                // Add 2-3 lessons per section
                for ($i = 1; $i <= rand(2, 3); $i++) {
                    $sectionTitle = $sectionData[$index]['title'];
                    $lessonTitle = "Lesson {$i}: {$sectionTitle} " . ($i == 1 ? "Basics" : "Advanced");
                    
                    \DB::table('lessons')->insert([
                        'course_id' => $course->id,
                        'section_id' => $sectionId,
                        'title' => $lessonTitle,
                        'content' => '<p>This is the content for ' . $lessonTitle . '. Replace this with actual lesson content.</p>',
                        'duration' => rand(15, 45), // 15-45 minutes
                        'order' => $i,
                        'is_published' => 1,
                        'is_free' => ($i == 1), // First lesson is free
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
            
            echo "Added lessons to each section\n";
        } else {
            echo "Lessons table doesn't exist. Skipping adding lessons.\n";
        }
    } else {
        echo "Found {$sectionCount} existing course sections\n";
    }
    
    // Summary
    echo "\nSUMMARY:\n";
    echo "Assignments: " . \DB::table('assignments')->where('course_id', $course->id)->count() . "\n";
    echo "Quizzes: " . \DB::table('quizzes')->where('course_id', $course->id)->count() . "\n";
    echo "Resources: " . \DB::table('resources')->where('course_id', $course->id)->count() . "\n";
    echo "Course Sections: " . \DB::table('course_sections')->where('course_id', $course->id)->count() . "\n";
    
    echo "\nCourse content setup complete. You should now see assignments, quizzes, and resources in the course!\n";
    echo "Please refresh your browser to see the updated course content.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 