<?php
// Script untuk memperbaiki hubungan user dan role
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

echo "Memperbaiki user roles...\n";

// Hapus semua role assignment yang ada
DB::table('model_has_roles')->truncate();
echo "- Model_has_roles dibersihkan\n";

// Tambahkan role ke user yang sudah ada
$admin = User::where('email', 'admin@elearning.com')->first();
if ($admin) {
    $admin->assignRole('admin');
    echo "- Admin role berhasil ditambahkan untuk {$admin->email}\n";
}

$instructor = User::where('email', 'instructor@elearning.com')->first();
if ($instructor) {
    $instructor->assignRole('instructor');
    echo "- Instructor role berhasil ditambahkan untuk {$instructor->email}\n";
}

$student = User::where('email', 'student@elearning.com')->first();
if ($student) {
    $student->assignRole('student');
    echo "- Student role berhasil ditambahkan untuk {$student->email}\n";
}

// Tambahkan role ke semua student lain
$otherStudents = User::where('email', 'like', 'student%@elearning.com')
                    ->where('email', '!=', 'student@elearning.com')
                    ->get();

foreach ($otherStudents as $student) {
    $student->assignRole('student');
    echo "- Student role berhasil ditambahkan untuk {$student->email}\n";
}

echo "Selesai! Role sudah diperbaiki.\n";
echo "Silahkan coba login kembali.\n"; 