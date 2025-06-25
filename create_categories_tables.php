<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// SQL to create categories and course_categories tables
$sql = "
-- Create categories table
CREATE TABLE IF NOT EXISTS `categories` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `description` TEXT NULL,
    `parent_id` BIGINT UNSIGNED NULL,
    `order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `categories_parent_id_foreign` (`parent_id`),
    CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
);

-- Create course_categories pivot table
CREATE TABLE IF NOT EXISTS `course_categories` (
    `course_id` BIGINT UNSIGNED NOT NULL,
    `category_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`course_id`, `category_id`),
    KEY `course_categories_category_id_foreign` (`category_id`),
    CONSTRAINT `course_categories_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
    CONSTRAINT `course_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
);
";

// Execute the SQL
try {
    \DB::unprepared($sql);
    echo "Categories and course_categories tables created successfully!\n";
    
    // Create sample categories
    $categories = [
        ['name' => 'Web Development', 'slug' => 'web-development', 'description' => 'Courses related to web development'],
        ['name' => 'Programming', 'slug' => 'programming', 'description' => 'Programming language courses'],
        ['name' => 'Database', 'slug' => 'database', 'description' => 'Database management courses'],
        ['name' => 'Design', 'slug' => 'design', 'description' => 'Design courses'],
        ['name' => 'Business', 'slug' => 'business', 'description' => 'Business and entrepreneurship courses']
    ];
    
    foreach ($categories as $category) {
        if (!\DB::table('categories')->where('slug', $category['slug'])->exists()) {
            $category['created_at'] = now();
            $category['updated_at'] = now();
            \DB::table('categories')->insert($category);
        }
    }
    echo "Sample categories created!\n";
    
    // Associate courses with categories
    $courses = \DB::table('courses')->get();
    
    if ($courses->count() > 0) {
        $webDevCategoryId = \DB::table('categories')->where('slug', 'web-development')->first()->id;
        $programmingCategoryId = \DB::table('categories')->where('slug', 'programming')->first()->id;
        $databaseCategoryId = \DB::table('categories')->where('slug', 'database')->first()->id;
        
        foreach ($courses as $course) {
            // Skip if already categorized
            if (\DB::table('course_categories')->where('course_id', $course->id)->exists()) {
                continue;
            }
            
            // Assign categories based on course title/slug
            $categoryId = null;
            
            if (stripos($course->title, 'Laravel') !== false || stripos($course->title, 'Web') !== false) {
                $categoryId = $webDevCategoryId;
            } elseif (stripos($course->title, 'JavaScript') !== false || stripos($course->title, 'Programming') !== false) {
                $categoryId = $programmingCategoryId;
            } elseif (stripos($course->title, 'Database') !== false || stripos($course->title, 'SQL') !== false) {
                $categoryId = $databaseCategoryId;
            } else {
                // Default to programming if no match
                $categoryId = $programmingCategoryId;
            }
            
            // Insert into pivot table
            \DB::table('course_categories')->insert([
                'course_id' => $course->id,
                'category_id' => $categoryId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            echo "Course '{$course->title}' categorized successfully!\n";
        }
    }
    
    echo "\nYour courses are still intact and now have categories assigned to them.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 