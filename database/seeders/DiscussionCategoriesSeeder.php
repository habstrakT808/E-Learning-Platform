<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DiscussionCategory;
use Illuminate\Support\Str;

class DiscussionCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'General Discussions',
                'description' => 'General discussions about anything related to learning',
                'color' => '#3498db', // Blue
                'icon' => 'fa-comments',
                'is_course_specific' => false,
                'order' => 1,
            ],
            [
                'name' => 'Questions & Answers',
                'description' => 'Ask questions and get answers from the community',
                'color' => '#2ecc71', // Green
                'icon' => 'fa-question-circle',
                'is_course_specific' => false,
                'order' => 2,
            ],
            [
                'name' => 'Troubleshooting',
                'description' => 'Get help with technical issues',
                'color' => '#e74c3c', // Red
                'icon' => 'fa-wrench',
                'is_course_specific' => false,
                'order' => 3,
            ],
            [
                'name' => 'Ideas & Suggestions',
                'description' => 'Share your ideas and suggestions',
                'color' => '#f39c12', // Orange
                'icon' => 'fa-lightbulb',
                'is_course_specific' => false,
                'order' => 4,
            ],
            [
                'name' => 'Course Materials',
                'description' => 'Discuss course materials and resources',
                'color' => '#9b59b6', // Purple
                'icon' => 'fa-book',
                'is_course_specific' => false,
                'order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            DiscussionCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'color' => $category['color'],
                'icon' => $category['icon'],
                'is_course_specific' => $category['is_course_specific'],
                'order' => $category['order'],
                'is_active' => true,
            ]);
        }
    }
}
