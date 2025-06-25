<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Current columns in enrollments table:\n";
    $columns = \DB::select('SHOW COLUMNS FROM enrollments');
    foreach ($columns as $column) {
        echo "- {$column->Field}\n";
    }
    
    // Using separate ALTER TABLE statements for each column
    \DB::statement('ALTER TABLE `enrollments` ADD COLUMN `enrolled_at` TIMESTAMP NULL AFTER `course_id`');
    echo "Added enrolled_at column\n";
    
    \DB::statement('ALTER TABLE `enrollments` ADD COLUMN `amount_paid` DECIMAL(10,2) NULL DEFAULT 0.00 AFTER `enrolled_at`');
    echo "Added amount_paid column\n";
    
    \DB::statement('ALTER TABLE `enrollments` ADD COLUMN `payment_method` VARCHAR(50) NULL AFTER `amount_paid`');
    echo "Added payment_method column\n";
    
    // Additional columns that might be useful
    \DB::statement('ALTER TABLE `enrollments` ADD COLUMN `payment_id` VARCHAR(100) NULL AFTER `payment_method`');
    \DB::statement('ALTER TABLE `enrollments` ADD COLUMN `transaction_id` VARCHAR(100) NULL AFTER `payment_id`');
    
    echo "\nUpdated columns in enrollments table:\n";
    $columns = \DB::select('SHOW COLUMNS FROM enrollments');
    foreach ($columns as $column) {
        echo "- {$column->Field}\n";
    }
    
    // Set enrolled_at for existing enrollments if any
    $updated = \DB::table('enrollments')
        ->whereNull('enrolled_at')
        ->update(['enrolled_at' => \DB::raw('created_at')]);
    
    echo "\nUpdated {$updated} existing enrollments with enrolled_at date.\n";
    echo "\nEnrollment table structure fixed. You should now be able to enroll in courses.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 