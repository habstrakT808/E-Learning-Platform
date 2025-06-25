<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Checking if course_sections table exists...\n";
    $sectionTableExists = \DB::select("SHOW TABLES LIKE 'course_sections'");
    
    if (empty($sectionTableExists)) {
        echo "Creating course_sections table...\n";
        
        // Create the course_sections table
        $sql = "
        CREATE TABLE `course_sections` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `course_id` BIGINT UNSIGNED NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT NULL,
            `order` INT NOT NULL DEFAULT 0,
            `created_at` TIMESTAMP NULL,
            `updated_at` TIMESTAMP NULL,
            PRIMARY KEY (`id`),
            KEY `course_sections_course_id_foreign` (`course_id`),
            CONSTRAINT `course_sections_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
        )";
        
        \DB::unprepared($sql);
        echo "Created course_sections table successfully.\n";
        
        // Check if lessons table exists
        $lessonsTableExists = \DB::select("SHOW TABLES LIKE 'lessons'");
        
        if (empty($lessonsTableExists)) {
            echo "\nCreating lessons table...\n";
            
            // Create the lessons table
            $sql = "
            CREATE TABLE `lessons` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                `course_id` BIGINT UNSIGNED NOT NULL,
                `section_id` BIGINT UNSIGNED NOT NULL,
                `title` VARCHAR(255) NOT NULL,
                `content` LONGTEXT NULL,
                `video_url` VARCHAR(255) NULL,
                `video_duration` INT NULL COMMENT 'Duration in seconds',
                `duration` INT NULL COMMENT 'Duration in minutes',
                `order` INT NOT NULL DEFAULT 0,
                `is_published` TINYINT(1) NOT NULL DEFAULT 0,
                `is_free` TINYINT(1) NOT NULL DEFAULT 0,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL,
                `deleted_at` TIMESTAMP NULL,
                PRIMARY KEY (`id`),
                KEY `lessons_course_id_foreign` (`course_id`),
                KEY `lessons_section_id_foreign` (`section_id`),
                CONSTRAINT `lessons_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
                CONSTRAINT `lessons_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `course_sections` (`id`) ON DELETE CASCADE
            )";
            
            \DB::unprepared($sql);
            echo "Created lessons table successfully.\n";
        } else {
            echo "\nLessons table already exists.\n";
        }
        
        // Add sample sections for the first course
        $course = \DB::table('courses')->first();
        
        if ($course) {
            echo "\nAdding sample sections to course: {$course->title}...\n";
            
            $sections = [
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
            
            foreach ($sections as $section) {
                $sectionId = \DB::table('course_sections')->insertGetId($section);
                echo "Added section: {$section['title']}\n";
                
                // Add sample lessons for this section
                for ($i = 1; $i <= 2; $i++) {
                    $lessonTitle = "Lesson {$i}: {$section['title']} " . ($i == 1 ? 'Basics' : 'Advanced');
                    
                    \DB::table('lessons')->insert([
                        'course_id' => $course->id,
                        'section_id' => $sectionId,
                        'title' => $lessonTitle,
                        'content' => '<p>This is sample content for ' . $lessonTitle . '. Replace this with actual lesson content.</p>',
                        'duration' => rand(15, 45), // 15-45 minutes
                        'order' => $i,
                        'is_published' => 1,
                        'is_free' => ($i == 1 && $section['order'] == 1), // First lesson in first section is free
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    
                    echo "  - Added lesson: {$lessonTitle}\n";
                }
            }
        }
        
    } else {
        echo "Course sections table already exists.\n";
        
        // Check if there are sections in the table
        $sectionCount = \DB::table('course_sections')->count();
        echo "Found {$sectionCount} course sections in the database.\n";
    }
    
    echo "\nCourse sections setup complete!\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 