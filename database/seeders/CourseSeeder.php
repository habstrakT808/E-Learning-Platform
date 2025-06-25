<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Section;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $instructor = User::role('instructor')->first();
        
        if (!$instructor) {
            echo "No instructor found. Please run UserSeeder first.\n";
            return;
        }

        // Create categories if they don't exist
        $categories = [
            'Web Development',
            'Programming',
            'Mobile Development',
            'Data Science',
            'Design',
            'Business',
            'Marketing'
        ];
        
        $categoryIds = [];
        foreach ($categories as $categoryName) {
            $category = Category::firstOrCreate([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName)
            ]);
            $categoryIds[] = $category->id;
        }

        $courseTitles = [
            'Complete Laravel Development Course',
            'HTML & CSS Fundamentals',
            'Advanced JavaScript Concepts',
            'React.js for Beginners',
            'Vue.js Masterclass',
            'Mobile App Development with Flutter',
            'iOS Development with Swift',
            'Android Development with Kotlin',
            'Python for Data Science',
            'Machine Learning Fundamentals',
            'UI/UX Design Principles',
            'Graphic Design Masterclass',
            'Digital Marketing Strategies',
            'SEO Optimization Techniques',
            'Content Marketing Mastery',
            'Social Media Marketing',
            'Database Design and Management',
            'Cloud Computing with AWS',
            'DevOps Engineering',
            'Blockchain Development'
        ];

        $levels = ['beginner', 'intermediate', 'advanced'];

        echo "Creating 20 courses...\n";
        
        for ($i = 0; $i < 20; $i++) {
            $title = $courseTitles[$i];
            $slug = Str::slug($title);
            $price = $i % 4 == 0 ? 0 : rand(99000, 599000); // Every 4th course is free
            $level = $levels[rand(0, 2)];
            $status = rand(0, 9) < 8 ? 'published' : 'draft'; // 80% are published

            $course = Course::create([
                'user_id' => $instructor->id,
                'title' => $title,
                'slug' => $slug,
                'description' => 'Learn ' . $title . ' from basics to advanced concepts. This comprehensive course covers everything you need to know.',
                'requirements' => json_encode(['Basic knowledge in related field', 'Computer with internet connection', 'Willingness to learn']),
                'objectives' => json_encode(['Master core concepts', 'Build practical projects', 'Apply knowledge in real-world scenarios', 'Gain confidence in the subject']),
                'price' => $price,
                'level' => $level,
                'status' => $status,
            ]);

            // Attach 1-3 random categories
            $randCategoryCount = rand(1, 3);
            $randCategories = array_rand(array_flip($categoryIds), $randCategoryCount);
            if (!is_array($randCategories)) {
                $randCategories = [$randCategories];
            }
            $course->categories()->attach($randCategories);

            // Create 2-4 sections per course
            $sectionCount = rand(2, 4);
            for ($s = 1; $s <= $sectionCount; $s++) {
                $section = Section::create([
                    'course_id' => $course->id,
                    'title' => "Section $s: " . $this->getSectionTitle($s),
                    'order' => $s
                ]);

                // Create 3-6 lessons per section
                $lessonCount = rand(3, 6);
                for ($l = 1; $l <= $lessonCount; $l++) {
                    $isFree = ($s == 1 && $l <= 2); // First two lessons of first section are free
                    $duration = rand(10, 40);
                    
                    Lesson::create([
                        'section_id' => $section->id,
                        'title' => "Lesson $l: " . $this->getLessonTitle($l),
                        'content' => "This lesson covers important concepts related to " . $title . ". You'll learn practical skills that you can apply immediately.",
                        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                        'duration' => $duration,
                        'order' => $l,
                        'is_free' => $isFree
                    ]);
                }
            }

            // Update course duration
            $course->updateDuration();
            
            echo ($i + 1) . ". Created: $title ($status, " . ($price == 0 ? 'Free' : 'Paid') . ")\n";
        }

        echo "Successfully created 20 courses!\n";
    }

    private function getSectionTitle($number)
    {
        $titles = [
            'Getting Started',
            'Basic Concepts',
            'Core Principles',
            'Advanced Techniques',
            'Practical Applications',
            'Real-world Projects',
            'Mastering the Fundamentals',
            'Professional Tips'
        ];
        
        return $titles[array_rand($titles)];
    }
    
    private function getLessonTitle($number)
    {
        $titles = [
            'Introduction to the Topic',
            'Understanding the Basics',
            'Key Concepts Explained',
            'Practical Implementation',
            'Step-by-step Tutorial',
            'Common Mistakes to Avoid',
            'Best Practices',
            'Advanced Techniques',
            'Case Study',
            'Practical Exercise'
        ];
        
        return $titles[array_rand($titles)];
    }
}