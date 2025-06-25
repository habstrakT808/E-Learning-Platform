<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Fixing course content...\n\n";
    
    // Get all courses
    $courses = \DB::table('courses')->get();
    
    foreach ($courses as $course) {
        echo "Processing course: {$course->title} (ID: {$course->id})\n";
        
        // 1. Make sure there are sections for the course
        $sections = \DB::table('course_sections')->where('course_id', $course->id)->get();
        
        if ($sections->isEmpty()) {
            echo "  Adding sections for this course...\n";
            
            // Create sample sections
            $sectionIds = [];
            $sectionData = [
                [
                    'course_id' => $course->id,
                    'title' => 'Introduction',
                    'description' => 'Get started with the course fundamentals.',
                    'order' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'course_id' => $course->id,
                    'title' => 'Core Concepts',
                    'description' => 'Learn the essential concepts of the course.',
                    'order' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'course_id' => $course->id,
                    'title' => 'Advanced Topics',
                    'description' => 'Dive deeper into advanced course material.',
                    'order' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ];
            
            foreach ($sectionData as $section) {
                $sectionId = \DB::table('course_sections')->insertGetId($section);
                $sectionIds[] = $sectionId;
                echo "    - Added section: {$section['title']}\n";
                
                // Add lessons for this section
                for ($i = 1; $i <= 2; $i++) {
                    $lessonTitle = "Lesson {$i}: {$section['title']} " . ($i === 1 ? 'Basics' : 'Advanced');
                    
                    \DB::table('lessons')->insert([
                        'section_id' => $sectionId,
                        'title' => $lessonTitle,
                        'description' => "This is a sample description for {$lessonTitle}.",
                        'order' => $i,
                        'is_preview' => ($section['order'] === 1 && $i === 1), // First lesson of first section is a preview
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    
                    echo "      - Added lesson: {$lessonTitle}\n";
                }
            }
            
            // Update sections for quizzes
            $sections = \DB::table('course_sections')->where('course_id', $course->id)->get();
        } else {
            echo "  Course already has " . $sections->count() . " sections\n";
        }
        
        // 2. Add quizzes if needed
        $quizCount = \DB::table('quizzes')->where('course_id', $course->id)->count();
        
        if ($quizCount === 0) {
            echo "  Adding quizzes for this course...\n";
            
            // Get the last two sections for quizzes
            $quizSections = $sections->slice(-2);
            
            foreach ($quizSections as $index => $section) {
                $quizTitle = $index === 0 ? "Mid-term Assessment" : "Final Assessment";
                
                $quizId = \DB::table('quizzes')->insertGetId([
                    'course_id' => $course->id,
                    'section_id' => $section->id,
                    'title' => $quizTitle,
                    'description' => "This is a {$quizTitle} to test your knowledge.",
                    'time_limit' => $index === 0 ? 30 : 60,
                    'passing_score' => $index === 0 ? 70 : 80,
                    'max_attempts' => $index === 0 ? 3 : 2,
                    'show_correct_answers' => 1,
                    'randomize_questions' => $index === 1, // Randomize only for final
                    'is_published' => 1,
                    'is_active' => 1,
                    'pass_percentage' => $index === 0 ? 70 : 80,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                echo "    - Added quiz: {$quizTitle} to section {$section->title}\n";
                
                // Create quiz_questions table if it doesn't exist
                $questionsTableExists = \DB::select("SHOW TABLES LIKE 'quiz_questions'");
                
                if (empty($questionsTableExists)) {
                    $sql = "
                    CREATE TABLE `quiz_questions` (
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
                    echo "    - Created quiz_questions table\n";
                }
                
                // Add sample questions
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
                
                echo "    - Added sample questions to {$quizTitle}\n";
            }
        } else {
            echo "  Course already has {$quizCount} quizzes\n";
        }
        
        // 3. Add resources if they don't exist
        $resourcesTableExists = \DB::select("SHOW TABLES LIKE 'resources'");
        
        if (empty($resourcesTableExists)) {
            echo "  Creating resources table...\n";
            
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
            echo "  Created resources table\n";
            
            // Add sample resources for all courses
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
            
            echo "  Added 3 resources to the course\n";
        } else {
            $resourceCount = \DB::table('resources')->where('course_id', $course->id)->count();
            
            if ($resourceCount === 0) {
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
                
                echo "  Added 3 resources to the course\n";
            } else {
                echo "  Course already has {$resourceCount} resources\n";
            }
        }
        
        echo "Completed processing course: {$course->title}\n\n";
    }
    
    echo "All courses have been processed. Course content is now set up.\n";
    echo "Please refresh your browser to see the updated course content including assignments, quizzes, and resources.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 