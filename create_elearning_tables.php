<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Collection of SQL statements to create missing tables
$sql = "
-- Create sections table
CREATE TABLE IF NOT EXISTS `sections` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `course_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `order` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `sections_course_id_foreign` (`course_id`),
    CONSTRAINT `sections_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
);

-- Create lessons table
CREATE TABLE IF NOT EXISTS `lessons` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `section_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `video_url` VARCHAR(255) NULL,
    `duration` INT NULL DEFAULT 0,
    `order` INT NOT NULL DEFAULT 0,
    `is_preview` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `lessons_section_id_foreign` (`section_id`),
    CONSTRAINT `lessons_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE
);

-- Create lesson_progress table
CREATE TABLE IF NOT EXISTS `lesson_progress` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `lesson_id` BIGINT UNSIGNED NOT NULL,
    `enrollment_id` BIGINT UNSIGNED NULL,
    `watch_time` INT NOT NULL DEFAULT 0,
    `is_completed` TINYINT(1) NOT NULL DEFAULT 0,
    `completed_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `lesson_progress_user_lesson_unique` (`user_id`, `lesson_id`),
    KEY `lesson_progress_user_id_foreign` (`user_id`),
    KEY `lesson_progress_lesson_id_foreign` (`lesson_id`),
    CONSTRAINT `lesson_progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `lesson_progress_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE
);

-- Create enrollments table
CREATE TABLE IF NOT EXISTS `enrollments` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `course_id` BIGINT UNSIGNED NOT NULL,
    `status` VARCHAR(20) NOT NULL DEFAULT 'active',
    `progress` INT NOT NULL DEFAULT 0,
    `completed_at` TIMESTAMP NULL,
    `expires_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `enrollments_user_course_unique` (`user_id`, `course_id`),
    KEY `enrollments_user_id_foreign` (`user_id`),
    KEY `enrollments_course_id_foreign` (`course_id`),
    CONSTRAINT `enrollments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
);

-- Create discussions table
CREATE TABLE IF NOT EXISTS `discussions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `course_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NULL UNIQUE,
    `content` TEXT NOT NULL,
    `status` VARCHAR(20) NOT NULL DEFAULT 'published',
    `is_pinned` TINYINT(1) NOT NULL DEFAULT 0,
    `is_answered` TINYINT(1) NOT NULL DEFAULT 0,
    `views_count` INT NOT NULL DEFAULT 0,
    `replies_count` INT NOT NULL DEFAULT 0,
    `votes_count` INT NOT NULL DEFAULT 0,
    `last_reply_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `discussions_user_id_foreign` (`user_id`),
    KEY `discussions_course_id_foreign` (`course_id`),
    CONSTRAINT `discussions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `discussions_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
);

-- Create assignments table
CREATE TABLE IF NOT EXISTS `assignments` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `course_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `deadline` TIMESTAMP NULL,
    `max_score` INT NULL DEFAULT 100,
    `max_attempts` INT NULL DEFAULT 1,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `allow_late_submission` TINYINT(1) NOT NULL DEFAULT 0,
    `allowed_file_types` JSON NULL,
    `max_file_size` INT NULL DEFAULT 5,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `assignments_course_id_foreign` (`course_id`),
    CONSTRAINT `assignments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
);

-- Create submissions table
CREATE TABLE IF NOT EXISTS `submissions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `assignment_id` BIGINT UNSIGNED NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `content` TEXT NULL,
    `file_path` VARCHAR(255) NULL,
    `score` INT NULL,
    `feedback` TEXT NULL,
    `status` VARCHAR(20) NOT NULL DEFAULT 'submitted',
    `submitted_at` TIMESTAMP NULL,
    `graded_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `submissions_assignment_id_foreign` (`assignment_id`),
    KEY `submissions_user_id_foreign` (`user_id`),
    CONSTRAINT `submissions_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
    CONSTRAINT `submissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

-- Create quizzes table
CREATE TABLE IF NOT EXISTS `quizzes` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `course_id` BIGINT UNSIGNED NOT NULL,
    `section_id` BIGINT UNSIGNED NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `time_limit` INT NULL,
    `passing_score` INT NULL DEFAULT 70,
    `max_attempts` INT NULL DEFAULT 1,
    `show_correct_answers` TINYINT(1) NOT NULL DEFAULT 0,
    `randomize_questions` TINYINT(1) NOT NULL DEFAULT 0,
    `is_published` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `quizzes_course_id_foreign` (`course_id`),
    KEY `quizzes_section_id_foreign` (`section_id`),
    CONSTRAINT `quizzes_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
    CONSTRAINT `quizzes_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE SET NULL
);

-- Create quiz_questions table
CREATE TABLE IF NOT EXISTS `quiz_questions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `quiz_id` BIGINT UNSIGNED NOT NULL,
    `question` TEXT NOT NULL,
    `type` VARCHAR(20) NOT NULL DEFAULT 'multiple_choice',
    `points` INT NOT NULL DEFAULT 1,
    `order` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `quiz_questions_quiz_id_foreign` (`quiz_id`),
    CONSTRAINT `quiz_questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE
);

-- Create quiz_options table
CREATE TABLE IF NOT EXISTS `quiz_options` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `question_id` BIGINT UNSIGNED NOT NULL,
    `option_text` TEXT NOT NULL,
    `is_correct` TINYINT(1) NOT NULL DEFAULT 0,
    `order` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `quiz_options_question_id_foreign` (`question_id`),
    CONSTRAINT `quiz_options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE
);

-- Create quiz_attempts table
CREATE TABLE IF NOT EXISTS `quiz_attempts` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `quiz_id` BIGINT UNSIGNED NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `score` INT NULL,
    `passed` TINYINT(1) NULL,
    `started_at` TIMESTAMP NULL,
    `completed_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `quiz_attempts_quiz_id_foreign` (`quiz_id`),
    KEY `quiz_attempts_user_id_foreign` (`user_id`),
    CONSTRAINT `quiz_attempts_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
    CONSTRAINT `quiz_attempts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

-- Create quiz_answers table
CREATE TABLE IF NOT EXISTS `quiz_answers` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `attempt_id` BIGINT UNSIGNED NOT NULL,
    `question_id` BIGINT UNSIGNED NOT NULL,
    `option_id` BIGINT UNSIGNED NULL,
    `text_answer` TEXT NULL,
    `is_correct` TINYINT(1) NULL,
    `points_earned` INT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `quiz_answers_attempt_id_foreign` (`attempt_id`),
    KEY `quiz_answers_question_id_foreign` (`question_id`),
    KEY `quiz_answers_option_id_foreign` (`option_id`),
    CONSTRAINT `quiz_answers_attempt_id_foreign` FOREIGN KEY (`attempt_id`) REFERENCES `quiz_attempts` (`id`) ON DELETE CASCADE,
    CONSTRAINT `quiz_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE,
    CONSTRAINT `quiz_answers_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `quiz_options` (`id`) ON DELETE SET NULL
);

-- Create certificates table
CREATE TABLE IF NOT EXISTS `certificates` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `course_id` BIGINT UNSIGNED NOT NULL,
    `certificate_number` VARCHAR(50) NOT NULL UNIQUE,
    `completion_date` TIMESTAMP NOT NULL,
    `pdf_path` VARCHAR(255) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `certificates_user_id_foreign` (`user_id`),
    KEY `certificates_course_id_foreign` (`course_id`),
    CONSTRAINT `certificates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `certificates_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
);

-- Create course_resources table
CREATE TABLE IF NOT EXISTS `course_resources` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `course_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `type` VARCHAR(50) NOT NULL DEFAULT 'file',
    `url` VARCHAR(255) NULL,
    `file_path` VARCHAR(255) NULL,
    `file_size` INT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `course_resources_course_id_foreign` (`course_id`),
    CONSTRAINT `course_resources_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
);

-- Create settings table
CREATE TABLE IF NOT EXISTS `settings` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `key` VARCHAR(255) NOT NULL UNIQUE,
    `value` TEXT NULL,
    `group` VARCHAR(255) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`)
);

-- Create notifications table
CREATE TABLE IF NOT EXISTS `notifications` (
    `id` CHAR(36) NOT NULL,
    `type` VARCHAR(255) NOT NULL,
    `notifiable_type` VARCHAR(255) NOT NULL,
    `notifiable_id` BIGINT UNSIGNED NOT NULL,
    `data` TEXT NOT NULL,
    `read_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`, `notifiable_id`)
);

-- Create password_resets table
CREATE TABLE IF NOT EXISTS `password_resets` (
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL,
    KEY `password_resets_email_index` (`email`)
);

-- Create personal_access_tokens table
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tokenable_type` VARCHAR(255) NOT NULL,
    `tokenable_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `token` VARCHAR(64) NOT NULL UNIQUE,
    `abilities` TEXT NULL,
    `last_used_at` TIMESTAMP NULL,
    `expires_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`, `tokenable_id`)
);

-- Create failed_jobs table
CREATE TABLE IF NOT EXISTS `failed_jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `uuid` VARCHAR(255) NOT NULL UNIQUE,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

-- Create jobs table
CREATE TABLE IF NOT EXISTS `jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    KEY `jobs_queue_index` (`queue`)
);
";

// Execute the SQL
try {
    \DB::unprepared($sql);
    echo "All e-learning tables created successfully!\n";
    
    // Create sample sections for sample courses
    $courses = \DB::table('courses')->get();
    
    foreach ($courses as $course) {
        // Check if course already has sections
        $sectionsCount = \DB::table('sections')->where('course_id', $course->id)->count();
        
        if ($sectionsCount == 0) {
            echo "Creating sections for course: {$course->title}\n";
            
            // Create two sections per course
            for ($i = 1; $i <= 2; $i++) {
                $sectionId = \DB::table('sections')->insertGetId([
                    'course_id' => $course->id,
                    'title' => $i == 1 ? 'Introduction' : 'Advanced Topics',
                    'description' => $i == 1 ? 'Getting started with the basics' : 'Diving deeper into advanced concepts',
                    'order' => $i,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                // Create 3 lessons per section
                for ($j = 1; $j <= 3; $j++) {
                    \DB::table('lessons')->insert([
                        'section_id' => $sectionId,
                        'title' => "Lesson {$j}: " . ($i == 1 ? 'Basic ' : 'Advanced ') . "Concept " . $j,
                        'description' => "Learn about " . ($i == 1 ? 'basic ' : 'advanced ') . "concept " . $j,
                        'video_url' => 'https://www.youtube.com/watch?v=example',
                        'duration' => rand(5, 30) * 60, // 5-30 minutes in seconds
                        'order' => $j,
                        'is_preview' => $i == 1 && $j == 1 ? 1 : 0, // First lesson is preview
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
    }
    
    echo "\nSample course sections and lessons created successfully!\n";
    echo "\nAll database tables are now ready. Your e-learning platform should work properly.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 