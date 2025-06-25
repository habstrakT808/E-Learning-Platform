<?php
// Script untuk memperbaiki masalah login dengan membuat ulang user
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;

echo "Reset users dan roles...\n";

// Disable foreign key checks sementara
Schema::disableForeignKeyConstraints();

try {
    // 1. Hapus semua user kecuali ID 1 (jika ada)
    DB::table('users')->where('id', '>', 1)->delete();
    echo "- Users lama dibersihkan\n";

    // 2. Hapus semua role assignments
    DB::table('model_has_roles')->delete();
    echo "- Model has roles dibersihkan\n";

    // 3. Hapus semua roles yang ada
    DB::table('roles')->delete();
    echo "- Roles dibersihkan\n";

    // Pastikan tabel permission juga bersih
    DB::table('permissions')->delete();
    DB::table('model_has_permissions')->delete();
    DB::table('role_has_permissions')->delete();
    echo "- Permissions dibersihkan\n";

    // 4. Buat role baru
    $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $instructorRole = Role::create(['name' => 'instructor', 'guard_name' => 'web']);
    $studentRole = Role::create(['name' => 'student', 'guard_name' => 'web']);
    echo "- Role admin, instructor, dan student dibuat\n";

    // 5. Buat user admin dan assign role
    $admin = DB::table('users')->where('id', 1)->first();
    if (!$admin) {
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Admin User',
            'email' => 'admin@elearning.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "- User admin@elearning.com dibuat\n";
    } else {
        $adminId = $admin->id;
        // Update password admin
        DB::table('users')->where('id', $adminId)->update([
            'password' => Hash::make('password')
        ]);
        echo "- Password user admin@elearning.com di-reset\n";
    }

    // Assign role admin
    DB::table('model_has_roles')->insert([
        'role_id' => $adminRole->id,
        'model_type' => 'App\\Models\\User',
        'model_id' => $adminId
    ]);
    echo "- Role admin berhasil ditambahkan untuk admin@elearning.com\n";

    // 6. Buat user instructor dan assign role
    $instructorId = DB::table('users')->insertGetId([
        'name' => 'John Instructor',
        'email' => 'instructor@elearning.com',
        'password' => Hash::make('password'),
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Assign role instructor
    DB::table('model_has_roles')->insert([
        'role_id' => $instructorRole->id,
        'model_type' => 'App\\Models\\User',
        'model_id' => $instructorId
    ]);
    echo "- User instructor@elearning.com dibuat dan role instructor ditambahkan\n";

    // 7. Buat user student dan assign role
    $studentId = DB::table('users')->insertGetId([
        'name' => 'Jane Student',
        'email' => 'student@elearning.com',
        'password' => Hash::make('password'),
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Assign role student
    DB::table('model_has_roles')->insert([
        'role_id' => $studentRole->id,
        'model_type' => 'App\\Models\\User',
        'model_id' => $studentId
    ]);
    echo "- User student@elearning.com dibuat dan role student ditambahkan\n";

    // 8. Buat beberapa student tambahan
    for ($i = 1; $i <= 3; $i++) {
        $extraStudentId = DB::table('users')->insertGetId([
            'name' => "Student $i",
            'email' => "student$i@elearning.com",
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign role student
        DB::table('model_has_roles')->insert([
            'role_id' => $studentRole->id,
            'model_type' => 'App\\Models\\User',
            'model_id' => $extraStudentId
        ]);
        echo "- User student{$i}@elearning.com dibuat dan role student ditambahkan\n";
    }
} finally {
    // Aktifkan kembali foreign key checks
    Schema::enableForeignKeyConstraints();
}

echo "\nSelesai! Reset user dan role sudah selesai.\n";
echo "==============================================\n";
echo "LOGIN CREDENTIALS:\n";
echo "Admin: admin@elearning.com / password\n";
echo "Instructor: instructor@elearning.com / password\n";
echo "Student: student@elearning.com / password\n";
echo "Student 1: student1@elearning.com / password\n";
echo "Student 2: student2@elearning.com / password\n";
echo "Student 3: student3@elearning.com / password\n";
echo "==============================================\n";
echo "Silakan coba login kembali.\n"; 