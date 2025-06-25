<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;

// Find users by email
$admin = User::where('email', 'admin@elearning.com')->first();
$instructor = User::where('email', 'instructor@elearning.com')->first();
$student = User::where('email', 'student@elearning.com')->first();

// Find roles
$adminRole = Role::where('name', 'admin')->first();
$instructorRole = Role::where('name', 'instructor')->first();
$studentRole = Role::where('name', 'student')->first();

// Assign roles
if ($admin && $adminRole) {
    $admin->assignRole($adminRole);
    echo "Admin role assigned to admin@elearning.com\n";
} else {
    echo "Could not assign admin role\n";
}

if ($instructor && $instructorRole) {
    $instructor->assignRole($instructorRole);
    echo "Instructor role assigned to instructor@elearning.com\n";
} else {
    echo "Could not assign instructor role\n";
}

if ($student && $studentRole) {
    $student->assignRole($studentRole);
    echo "Student role assigned to student@elearning.com\n";
} else {
    echo "Could not assign student role\n";
}

// Also assign student role to the additional students
for ($i = 1; $i <= 5; $i++) {
    $additionalStudent = User::where('email', "student$i@elearning.com")->first();
    if ($additionalStudent && $studentRole) {
        $additionalStudent->assignRole($studentRole);
        echo "Student role assigned to student$i@elearning.com\n";
    }
}

echo "Roles assignment completed!\n"; 