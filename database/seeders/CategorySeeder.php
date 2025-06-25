<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'icon' => 'fa-code',
                'description' => 'Learn web development from basics to advanced including HTML, CSS, JavaScript, PHP, and frameworks.'
            ],
            [
                'name' => 'Mobile Development',
                'icon' => 'fa-mobile-alt',
                'description' => 'Build mobile applications for iOS and Android using various technologies and frameworks.'
            ],
            [
                'name' => 'Data Science',
                'icon' => 'fa-chart-bar',
                'description' => 'Analyze data and build machine learning models using Python, R, and various data tools.'
            ],
            [
                'name' => 'UI/UX Design',
                'icon' => 'fa-paint-brush',
                'description' => 'Learn user interface and user experience design principles and tools.'
            ],
            [
                'name' => 'Digital Marketing',
                'icon' => 'fa-bullhorn',
                'description' => 'Master digital marketing strategies, SEO, social media, and online advertising.'
            ],
            [
                'name' => 'Programming',
                'icon' => 'fa-laptop-code',
                'description' => 'Learn programming languages and computer science fundamentals.'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        echo "Created " . count($categories) . " categories\n";
    }
}