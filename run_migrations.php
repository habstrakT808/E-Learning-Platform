<?php
// This script runs the quiz migrations

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Run the quiz migrations
$migrator = $app->make('migrator');

echo "Running quiz migrations...\n";

// Paths to quiz migration files
$migrationFiles = [
    'database/migrations/2025_06_03_000000_create_quizzes_table.php',
    'database/migrations/2025_06_03_000001_create_quiz_questions_table.php',
    'database/migrations/2025_06_03_000002_create_quiz_options_table.php',
    'database/migrations/2025_06_03_000003_create_quiz_attempts_table.php',
    'database/migrations/2025_06_03_000004_create_quiz_answers_table.php'
];

// Run the migrations
foreach ($migrationFiles as $file) {
    echo "Migrating: " . basename($file) . "\n";
    
    try {
        // Run the migration
        $migrator->run([$file]);
        echo "Migration successful!\n";
    } catch (Exception $e) {
        echo "Error running migration: " . $e->getMessage() . "\n";
    }
} 