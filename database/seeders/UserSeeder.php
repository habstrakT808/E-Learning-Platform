<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $adminEmail = 'admin@elearning.com';
        if (!User::where('email', $adminEmail)->exists()) {
        $admin = User::create([
            'name' => 'Admin User',
                'email' => $adminEmail,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'bio' => 'System Administrator'
        ]);
        $admin->assignRole('admin');
            echo "Created admin: $adminEmail / password\n";
        }

        // Create Instructor
        $instructorEmail = 'instructor@elearning.com';
        if (!User::where('email', $instructorEmail)->exists()) {
        $instructor = User::create([
            'name' => 'John Instructor',
                'email' => $instructorEmail,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'bio' => 'Experienced web developer with 5+ years teaching experience.',
            'phone' => '+62812345678'
        ]);
        $instructor->assignRole('instructor');
            echo "Created instructor: $instructorEmail / password\n";
        }

        // Create Student
        $studentEmail = 'student@elearning.com';
        if (!User::where('email', $studentEmail)->exists()) {
        $student = User::create([
            'name' => 'Jane Student',
                'email' => $studentEmail,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'bio' => 'Passionate learner interested in web development.',
            'phone' => '+62812345679'
        ]);
        $student->assignRole('student');
            echo "Created student: $studentEmail / password\n";
        }

        // Create more students
        for ($i = 1; $i <= 5; $i++) {
            $email = "student$i@elearning.com";
            if (!User::where('email', $email)->exists()) {
            $user = User::create([
                'name' => "Student $i",
                    'email' => $email,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'bio' => "Student number $i learning various courses."
            ]);
            $user->assignRole('student');
                echo "Created student: $email / password\n";
            }
        }
    }
}