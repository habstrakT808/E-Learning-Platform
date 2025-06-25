<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Section;
use App\Models\Lesson;

class SectionsAndLessonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua course
        $courses = Course::all();
        $sectionsCreated = 0;
        $lessonsCreated = 0;
        
        $this->command->info('Menambahkan sections dan lessons untuk ' . $courses->count() . ' course...');
        
        foreach ($courses as $course) {
            $sectionCount = rand(2, 4); // 2-4 sections per course
            
            for ($i = 1; $i <= $sectionCount; $i++) {
                $sectionTitle = "Section {$i}: " . $this->getSectionTitle();
                
                $section = Section::create([
                    'course_id' => $course->id,
                    'title' => $sectionTitle,
                    'order' => $i,
                ]);
                
                $sectionsCreated++;
                
                // Tambahkan 3-6 lessons per section
                $lessonCount = rand(3, 6);
                
                for ($j = 1; $j <= $lessonCount; $j++) {
                    $isPreview = ($i == 1 && $j <= 2) ? 1 : 0; // Preview untuk 2 lesson pertama pada section pertama
                    
                    Lesson::create([
                        'section_id' => $section->id,
                        'title' => "Lesson {$j}: " . $this->getLessonTitle(),
                        'content' => "This is the content for lesson {$j} of {$sectionTitle}. You'll learn valuable skills related to {$course->title}.",
                        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                        'duration' => rand(10, 40),
                        'order' => $j,
                        'is_preview' => $isPreview,
                    ]);
                    
                    $lessonsCreated++;
                }
            }
            
            $this->command->info("- {$course->title}: {$sectionCount} sections dengan " . ($sectionCount * rand(3, 6)) . " lessons ditambahkan");
        }
        
        $this->command->info("Berhasil menambahkan {$sectionsCreated} sections dan {$lessonsCreated} lessons!");
    }
    
    private function getSectionTitle()
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
    
    private function getLessonTitle()
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
