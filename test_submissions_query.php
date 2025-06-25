<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Testing submission queries with soft delete...\n";
    
    // Get the first assignment
    $assignment = \App\Models\Assignment::first();
    
    if (!$assignment) {
        echo "No assignments found in database. Cannot test.\n";
        exit(1);
    }
    
    $assignmentId = $assignment->id;
    echo "Using assignment ID: {$assignmentId}\n";
    
    // Get a user
    $user = \App\Models\User::first();
    
    if (!$user) {
        echo "No users found in database. Cannot test.\n";
        exit(1);
    }
    
    $userId = $user->id;
    echo "Using user ID: {$userId}\n\n";
    
    // Run the query that was previously failing
    echo "Testing query with soft delete...\n";
    
    $result = \DB::table('submissions')
        ->where('submissions.assignment_id', $assignmentId)
        ->where('submissions.assignment_id', '!=', null)
        ->where('user_id', $userId)
        ->whereNull('submissions.deleted_at')
        ->orderBy('created_at', 'desc')
        ->limit(1)
        ->get();
    
    echo "Query executed successfully!\n";
    echo "Found " . $result->count() . " results.\n";
    
    // Test a submission model query with soft deletes
    echo "\nTesting Eloquent model with soft deletes...\n";
    
    $submissions = \App\Models\Submission::where('assignment_id', $assignmentId)
        ->where('user_id', $userId)
        ->latest()
        ->get();
    
    echo "Eloquent query executed successfully!\n";
    echo "Found " . $submissions->count() . " submissions.\n";
    
    echo "\nAll tests passed! The issue with the deleted_at column has been fixed.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
} 