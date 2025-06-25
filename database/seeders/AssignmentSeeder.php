<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get course IDs
        $courseIds = DB::table('courses')->pluck('id')->toArray();
        
        if (empty($courseIds)) {
            // If no courses exist, we can't create assignments
            $this->command->info('No courses found. Skipping assignment seeding.');
            return;
        }

        // Sample assignment titles
        $assignmentTitles = [
            'Introduction Assignment',
            'Mid-term Project',
            'Final Project',
            'Research Paper',
            'Practical Exercise'
        ];

        // Add a sample assignment for each course
        foreach ($courseIds as $courseId) {
            // Create 2-3 assignments per course
            $numAssignments = rand(2, 3);
            
            for ($i = 0; $i < $numAssignments; $i++) {
                $title = $assignmentTitles[array_rand($assignmentTitles)] . ' ' . ($i + 1);
                $slug = Str::slug($title . '-course-' . $courseId);
                
                DB::table('assignments')->insert([
                    'course_id' => $courseId,
                    'title' => $title,
                    'description' => 'This assignment helps you practice the concepts learned in this course.',
                    'slug' => $slug,
                    'deadline' => now()->addDays(14),
                    'max_score' => 100,
                    'max_attempts' => 2,
                    'instructions' => 'Complete all the tasks described in the assignment description. Upload your solution as a single ZIP file.',
                    'submission_requirements' => 'Submit your code and a brief explanation document.',
                    'is_active' => true,
                    'allow_late_submissions' => true,
                    'late_submission_penalty' => 10,
                    'is_group_assignment' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
} 