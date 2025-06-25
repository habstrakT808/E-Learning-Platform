<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DiscussionCategory;
use App\Models\Course;

class DiscussionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kategori umum (tidak khusus untuk course tertentu)
        $generalCategories = [
            [
                'name' => 'General Discussion',
                'slug' => 'general-discussion',
                'description' => 'General discussion about anything related to learning',
                'color' => '#3498db',
                'icon' => 'far fa-comments',
                'is_course_specific' => false,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Introductions',
                'slug' => 'introductions',
                'description' => 'Introduce yourself to the community',
                'color' => '#2ecc71',
                'icon' => 'far fa-user-circle',
                'is_course_specific' => false,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Technical Help',
                'slug' => 'technical-help',
                'description' => 'Get help with technical issues and problems',
                'color' => '#e74c3c',
                'icon' => 'fas fa-wrench',
                'is_course_specific' => false,
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Career Advice',
                'slug' => 'career-advice',
                'description' => 'Discuss career paths, job opportunities, and professional growth',
                'color' => '#9b59b6',
                'icon' => 'fas fa-briefcase',
                'is_course_specific' => false,
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($generalCategories as $category) {
            DiscussionCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        // Tambahkan kategori untuk course dengan ID 1 (Web Development with Laravel)
        $course = Course::find(1);
        
        if ($course) {
            $courseCategories = [
                [
                    'name' => 'Laravel Basics',
                    'slug' => 'laravel-basics-' . $course->id,
                    'description' => 'Discussions about Laravel fundamentals',
                    'color' => '#f1c40f',
                    'icon' => 'fab fa-laravel',
                    'is_course_specific' => true,
                    'course_id' => $course->id,
                    'order' => 1,
                    'is_active' => true,
                ],
                [
                    'name' => 'Advanced Laravel',
                    'slug' => 'advanced-laravel-' . $course->id,
                    'description' => 'Discussions about advanced Laravel topics',
                    'color' => '#e67e22',
                    'icon' => 'fas fa-code',
                    'is_course_specific' => true,
                    'course_id' => $course->id,
                    'order' => 2,
                    'is_active' => true,
                ],
                [
                    'name' => 'Course Assignments',
                    'slug' => 'course-assignments-' . $course->id,
                    'description' => 'Discuss course assignments and projects',
                    'color' => '#1abc9c',
                    'icon' => 'fas fa-tasks',
                    'is_course_specific' => true,
                    'course_id' => $course->id,
                    'order' => 3,
                    'is_active' => true,
                ],
            ];

            foreach ($courseCategories as $category) {
                DiscussionCategory::firstOrCreate(
                    ['slug' => $category['slug']],
                    $category
                );
            }

            $this->command->info('Added categories for course: ' . $course->title);
        } else {
            $this->command->warn('Course with ID 1 not found. Skipping course-specific categories.');
        }
    }
}
