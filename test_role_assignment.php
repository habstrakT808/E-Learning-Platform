<?php
// This script tests if a user has been assigned the student role correctly

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Get the user and check their roles
use App\Models\User;
use Spatie\Permission\Models\Role;

// Get email from command line argument or use default
$email = $argv[1] ?? 'test@example.com';

$user = User::where('email', $email)->first();

if (!$user) {
    echo "User with email '{$email}' not found.\n";
    exit;
}

echo "User found: {$user->name} (ID: {$user->id})\n";
echo "Roles assigned: ";

if ($user->roles->isEmpty()) {
    echo "None\n";
    
    // Assign student role if the user has no role
    echo "Assigning student role to user...\n";
    $studentRole = Role::where('name', 'student')->first();
    
    if (!$studentRole) {
        echo "Student role not found in the database. Creating it...\n";
        $studentRole = Role::create(['name' => 'student']);
    }
    
    $user->assignRole($studentRole);
    echo "Student role assigned. Refreshing user...\n";
    $user->refresh();
    
    echo "Updated roles assigned: ";
    if ($user->roles->isEmpty()) {
        echo "None (something went wrong)\n";
    } else {
        echo implode(', ', $user->roles->pluck('name')->toArray()) . "\n";
    }
} else {
    echo implode(', ', $user->roles->pluck('name')->toArray()) . "\n";
}

// Check if user can access student routes
echo "\nPermission checks:\n";
echo "- Is student: " . ($user->hasRole('student') ? "Yes" : "No") . "\n";
echo "- Is instructor: " . ($user->hasRole('instructor') ? "Yes" : "No") . "\n";
echo "- Is admin: " . ($user->hasRole('admin') ? "Yes" : "No") . "\n"; 