<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update enrollments with deadlines
        $enrollments = Enrollment::all();

        foreach ($enrollments as $enrollment) {
            // Skip completed courses
            if ($enrollment->completed_at) {
                continue;
            }
            
            // Tambahkan deadline untuk beberapa kursus
            if ($enrollment->id % 4 === 0) {
                // Deadline yang sudah lewat
                $enrollment->deadline = now()->subDays(5);
                $enrollment->save();
            } elseif ($enrollment->id % 3 === 0) {
                // Deadline dalam waktu dekat
                $enrollment->deadline = now()->addDays(rand(2, 7));
                $enrollment->save();
            } elseif ($enrollment->id % 2 === 0) {
                // Deadline jauh ke depan
                $enrollment->deadline = now()->addDays(rand(14, 30));
                $enrollment->save();
            }
        }
    }
} 