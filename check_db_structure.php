<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// List of essential tables for an e-learning platform
$essentialTables = [
    'users',
    'sessions',
    'cache',
    'cache_locks',
    'roles',
    'permissions',
    'model_has_roles',
    'model_has_permissions',
    'role_has_permissions',
    'courses',
    'sections',
    'lessons',
    'lesson_progress',
    'enrollments',
    'discussions',
    'discussion_replies',
    'assignments',
    'submissions',
    'quizzes',
    'quiz_questions',
    'quiz_options',
    'quiz_attempts',
    'quiz_answers',
    'certificates',
    'course_resources',
    'settings',
    'notifications',
    'password_resets',
    'personal_access_tokens',
    'failed_jobs',
    'jobs'
];

echo "Checking database structure...\n\n";
echo "Database: " . config('database.connections.mysql.database') . "\n\n";

$missingTables = [];
$existingTables = [];

foreach ($essentialTables as $table) {
    if (\Schema::hasTable($table)) {
        $existingTables[] = $table;
        echo "✓ {$table} (exists)\n";
    } else {
        $missingTables[] = $table;
        echo "✗ {$table} (missing)\n";
    }
}

echo "\nSummary:\n";
echo "- " . count($existingTables) . " tables exist\n";
echo "- " . count($missingTables) . " tables are missing\n";

if (count($missingTables) > 0) {
    echo "\nMissing tables: " . implode(", ", $missingTables) . "\n";
    echo "\nRECOMMENDATION: Run 'php artisan migrate:fresh' to create all tables from scratch. Note this will erase existing data.\n";
} 