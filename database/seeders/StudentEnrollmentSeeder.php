<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use Carbon\Carbon;

class StudentEnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get student user
        $student = User::role('student')->first();
        
        if (!$student) {
            $this->command->error('No student found. Please run UserSeeder first.');
            return;
        }
        
        // Get 3 best courses (published, with highest number of sections/lessons)
        $courses = Course::where('status', 'published')
            ->withCount(['sections', 'lessons'])
            ->orderBy('lessons_count', 'desc')
            ->take(3)
            ->get();
        
        if ($courses->count() === 0) {
            $this->command->error('No published courses found. Please run CourseSeeder first.');
            return;
        }
        
        $this->command->info('Enrolling student to ' . $courses->count() . ' courses...');
        
        foreach ($courses as $index => $course) {
            // Create enrollment
            $enrollment = Enrollment::firstOrCreate(
                [
                    'user_id' => $student->id,
                    'course_id' => $course->id,
                ],
                [
                    'enrolled_at' => Carbon::now()->subDays(rand(1, 30)),
                    'progress' => 0,
                    'last_activity_at' => Carbon::now()->subDays(rand(0, 7)),
                ]
            );
            
            if ($enrollment->wasRecentlyCreated) {
                $this->command->info("Enrolled in: {$course->title}");
            } else {
                $this->command->info("Already enrolled in: {$course->title}");
            }
            
            // Create lesson progress for each lesson
            $lessons = $course->lessons;
            $lessonCount = $lessons->count();
            
            // Calculate how many lessons should be completed (based on index)
            // First course: 30-50% complete, Second: 10-30%, Third: 0-10%
            $percentComplete = [
                0 => rand(30, 50),
                1 => rand(10, 30),
                2 => rand(0, 10),
            ][$index];
            
            $lessonsToComplete = ceil($lessonCount * ($percentComplete / 100));
            
            $this->command->info("  - Creating progress for {$lessonsToComplete} of {$lessonCount} lessons ({$percentComplete}%)");
            
            foreach ($lessons as $i => $lesson) {
                $isCompleted = $i < $lessonsToComplete;
                $watchTimePercent = $isCompleted ? rand(90, 100) : rand(0, 90);
                $watchTime = $lesson->duration ? round(($lesson->duration * 60) * ($watchTimePercent / 100)) : rand(30, 300);
                
                $progress = LessonProgress::updateOrCreate(
                    [
                        'user_id' => $student->id,
                        'lesson_id' => $lesson->id,
                    ],
                    [
                        'enrollment_id' => $enrollment->id,
                        'is_completed' => $isCompleted,
                        'completed_at' => $isCompleted ? Carbon::now()->subDays(rand(0, 14)) : null,
                        'watch_time' => $watchTime,
                    ]
                );
            }
            
            // Update enrollment progress
            $enrollment->calculateProgress();
            $this->command->info("  - Progress updated: {$enrollment->progress}%");
        }
        
        $this->command->info('Student enrolled successfully!');
    }
}
