<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Adding resources to courses...\n\n";
    
    // Check if resources table exists
    $resourcesTableExists = \DB::select("SHOW TABLES LIKE 'resources'");
    
    if (empty($resourcesTableExists)) {
        echo "Creating resources table...\n";
        
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
        echo "Created resources table successfully!\n\n";
    } else {
        echo "Resources table already exists.\n\n";
    }
    
    // Get all courses
    $courses = \DB::table('courses')->get();
    
    foreach ($courses as $course) {
        echo "Processing course: {$course->title} (ID: {$course->id})\n";
        
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
                echo "- Added resource: {$resource['title']}\n";
            }
        } else {
            echo "Course already has {$resourceCount} resources. Skipping.\n";
        }
    }
    
    echo "\nResource setup complete. You should now see resources for your courses!\n";
    echo "Please refresh your browser to see the updated course content.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 