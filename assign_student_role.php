<?php
// This script assigns the 'student' role to a specific user

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Get the user and assign the role
use App\Models\User;
use Spatie\Permission\Models\Role;

$userId = 3; // ID of the user who needs the student role
$user = User::find($userId);

if (!$user) {
    echo "User with ID {$userId} not found.\n";
    exit;
}

if ($user->hasRole('student')) {
    echo "User '{$user->name}' already has the student role.\n";
} else {
    $studentRole = Role::where('name', 'student')->first();
    
    if (!$studentRole) {
        echo "Student role not found in the database. Creating it...\n";
        $studentRole = Role::create(['name' => 'student']);
    }
    
    $user->assignRole($studentRole);
    echo "Student role successfully assigned to '{$user->name}'.\n";
}

// Check if user now has the student role
if ($user->hasRole('student')) {
    echo "Verified: User now has the student role.\n";
} else {
    echo "Warning: User still doesn't have the student role after assignment.\n";
} 