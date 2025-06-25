<?php
// Script untuk memeriksa tabel sections
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Memeriksa tabel sections dan lessons...\n";

if (Schema::hasTable('sections')) {
    echo "Tabel sections ditemukan.\n";
    
    // Cek jumlah data sections
    $sectionCount = DB::table('sections')->count();
    echo "Jumlah data di tabel sections: {$sectionCount}\n";
    
    if ($sectionCount > 0) {
        echo "\nContoh data sections:\n";
        $sections = DB::table('sections')->limit(5)->get();
        foreach ($sections as $section) {
            echo "- ID: {$section->id}, Course ID: {$section->course_id}, Title: {$section->title}\n";
        }
    } else {
        echo "Tidak ada data di tabel sections. Menambahkan data sections...\n";
        
        // Tambahkan data sections jika belum ada
        try {
            $courses = DB::table('courses')->get();
            $sectionsCreated = 0;
            
            foreach ($courses as $course) {
                $sectionCount = rand(2, 4); // 2-4 sections per course
                
                for ($i = 1; $i <= $sectionCount; $i++) {
                    $sectionTitle = "Section {$i}: " . getSectionTitle();
                    
                    $sectionId = DB::table('sections')->insertGetId([
                        'course_id' => $course->id,
                        'title' => $sectionTitle,
                        'order' => $i,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    
                    $sectionsCreated++;
                    
                    // Tambahkan 3-6 lessons per section
                    $lessonCount = rand(3, 6);
                    
                    for ($j = 1; $j <= $lessonCount; $j++) {
                        $isPreview = ($i == 1 && $j <= 2) ? 1 : 0; // Preview untuk 2 lesson pertama pada section pertama
                        
                        DB::table('lessons')->insert([
                            'section_id' => $sectionId,
                            'title' => "Lesson {$j}: " . getLessonTitle(),
                            'content' => "This is the content for lesson {$j} of {$sectionTitle}. You'll learn valuable skills related to {$course->title}.",
                            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                            'duration' => rand(10, 40),
                            'order' => $j,
                            'is_preview' => $isPreview,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
            
            echo "Berhasil menambahkan {$sectionsCreated} sections dengan lessons.\n";
        } catch (Exception $e) {
            echo "Error saat menambahkan data: " . $e->getMessage() . "\n";
        }
    }
} else {
    echo "Tabel sections tidak ditemukan. Membuat tabel...\n";
    
    try {
        DB::statement('
            CREATE TABLE sections (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                course_id BIGINT UNSIGNED NOT NULL,
                title VARCHAR(255) NOT NULL,
                description TEXT NULL,
                `order` INT NOT NULL DEFAULT 0,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL,
                CONSTRAINT fk_sections_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        ');
        
        echo "Tabel sections berhasil dibuat.\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

if (Schema::hasTable('lessons')) {
    // Cek jumlah data lessons
    $lessonCount = DB::table('lessons')->count();
    echo "\nJumlah data di tabel lessons: {$lessonCount}\n";
    
    if ($lessonCount > 0) {
        echo "\nContoh data lessons:\n";
        $lessons = DB::table('lessons')->limit(5)->get();
        foreach ($lessons as $lesson) {
            echo "- ID: {$lesson->id}, Section ID: {$lesson->section_id}, Title: {$lesson->title}, Is Preview: {$lesson->is_preview}\n";
        }
        
        // Cek jumlah preview lessons
        $previewCount = DB::table('lessons')->where('is_preview', 1)->count();
        echo "\nJumlah lesson dengan is_preview = 1: {$previewCount}\n";
        
        if ($previewCount == 0) {
            echo "Tidak ada lesson yang ditandai sebagai preview. Menandai beberapa lesson sebagai preview...\n";
            
            try {
                $courses = DB::table('courses')->get();
                $updatedCount = 0;
                
                foreach ($courses as $course) {
                    // Ambil section pertama dari course
                    $firstSection = DB::table('sections')
                        ->where('course_id', $course->id)
                        ->orderBy('order')
                        ->first();
                        
                    if ($firstSection) {
                        // Update 1-2 lesson pertama sebagai preview
                        $previewCount = rand(1, 2);
                        $lessonsToUpdate = DB::table('lessons')
                            ->where('section_id', $firstSection->id)
                            ->orderBy('order')
                            ->limit($previewCount)
                            ->get();
                            
                        foreach ($lessonsToUpdate as $lesson) {
                            DB::table('lessons')
                                ->where('id', $lesson->id)
                                ->update(['is_preview' => 1]);
                                
                            $updatedCount++;
                        }
                        
                        echo "- Course '{$course->title}': " . count($lessonsToUpdate) . " lesson ditandai sebagai preview.\n";
                    }
                }
                
                echo "\nTotal {$updatedCount} lesson telah ditandai sebagai preview.\n";
            } catch (Exception $e) {
                echo "Error saat mengupdate data: " . $e->getMessage() . "\n";
            }
        }
    }
} else {
    echo "\nTabel lessons tidak ditemukan.\n";
}

echo "\nSelesai!\n";

// Helper functions
function getSectionTitle() {
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

function getLessonTitle() {
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