<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Columns in enrollments table:\n";
    $columns = \DB::select('SHOW COLUMNS FROM enrollments');
    foreach ($columns as $column) {
        echo "- {$column->Field}\n";
    }
    
    // Check if the specific columns exist
    $hasEnrolledAt = false;
    $hasAmountPaid = false;
    $hasPaymentMethod = false;
    
    foreach ($columns as $column) {
        if ($column->Field === 'enrolled_at') {
            $hasEnrolledAt = true;
        }
        if ($column->Field === 'amount_paid') {
            $hasAmountPaid = true;
        }
        if ($column->Field === 'payment_method') {
            $hasPaymentMethod = true;
        }
    }
    
    echo "\nRequired columns check:\n";
    echo "- enrolled_at: " . ($hasEnrolledAt ? "Exists" : "Missing") . "\n";
    echo "- amount_paid: " . ($hasAmountPaid ? "Exists" : "Missing") . "\n";
    echo "- payment_method: " . ($hasPaymentMethod ? "Exists" : "Missing") . "\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 