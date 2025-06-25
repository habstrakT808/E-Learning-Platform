<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\LearningPath;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user student@elearning.com
        $student = User::where('email', 'student@elearning.com')->first();
        if (!$student) {
            $this->command->info('User student@elearning.com tidak ditemukan.');
            return;
        }

        // Ambil semua course dan path yang published
        $courses = Course::where('status', 'published')->get();
        $paths = LearningPath::where('status', 'published')->get();

        if ($courses->isEmpty() && $paths->isEmpty()) {
            $this->command->info('Tidak ada course atau learning path yang published.');
            return;
        }

        $totalCreated = 0;
        // Buat sertifikat untuk semua course published
        foreach ($courses as $course) {
            Certificate::create([
                'user_id' => $student->id,
                'course_id' => $course->id,
                'certificate_number' => Certificate::generateCertificateNumber(),
                'title' => "Course Completion: {$course->title}",
                'description' => "This is to certify that {$student->name} has successfully completed the course {$course->title}.",
                'template' => 'course',
                'issued_at' => now()->subDays(rand(1, 60)),
            ]);
            $totalCreated++;
        }
        // Buat sertifikat untuk semua path published
        foreach ($paths as $path) {
            Certificate::create([
                'user_id' => $student->id,
                'learning_path_id' => $path->id,
                'certificate_number' => Certificate::generateCertificateNumber(),
                'title' => "Path Completion: {$path->title}",
                'description' => "This is to certify that {$student->name} has successfully completed the learning path {$path->title}.",
                'template' => 'path',
                'issued_at' => now()->subDays(rand(1, 60)),
            ]);
            $totalCreated++;
        }

        $this->command->info("Berhasil membuat {$totalCreated} sertifikat untuk student@elearning.com!");
    }
} 