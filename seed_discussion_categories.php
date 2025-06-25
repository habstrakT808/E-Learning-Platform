<?php
// Script untuk menambahkan kategori diskusi awal
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

echo "Menambahkan kategori diskusi awal...\n";

// Kategori umum
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
        'created_at' => now(),
        'updated_at' => now(),
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
        'created_at' => now(),
        'updated_at' => now(),
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
        'created_at' => now(),
        'updated_at' => now(),
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
        'created_at' => now(),
        'updated_at' => now(),
    ],
];

$count = 0;
foreach ($generalCategories as $category) {
    try {
        // Cek apakah kategori sudah ada
        $exists = DB::table('discussion_categories')
                    ->where('slug', $category['slug'])
                    ->exists();
        
        if (!$exists) {
            DB::table('discussion_categories')->insert($category);
            echo "Kategori '{$category['name']}' berhasil ditambahkan.\n";
            $count++;
        } else {
            echo "Kategori '{$category['name']}' sudah ada.\n";
        }
    } catch (Exception $e) {
        echo "Error saat menambahkan kategori '{$category['name']}': " . $e->getMessage() . "\n";
    }
}

// Tambahkan kategori untuk course dengan ID 1 jika ada
$courseId = 1;
$courseExists = DB::table('courses')->where('id', $courseId)->exists();

if ($courseExists) {
    $courseCategories = [
        [
            'name' => 'Laravel Basics',
            'slug' => 'laravel-basics-' . $courseId,
            'description' => 'Discussions about Laravel fundamentals',
            'color' => '#f1c40f',
            'icon' => 'fab fa-laravel',
            'is_course_specific' => true,
            'course_id' => $courseId,
            'order' => 1,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Advanced Laravel',
            'slug' => 'advanced-laravel-' . $courseId,
            'description' => 'Discussions about advanced Laravel topics',
            'color' => '#e67e22',
            'icon' => 'fas fa-code',
            'is_course_specific' => true,
            'course_id' => $courseId,
            'order' => 2,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Course Assignments',
            'slug' => 'course-assignments-' . $courseId,
            'description' => 'Discuss course assignments and projects',
            'color' => '#1abc9c',
            'icon' => 'fas fa-tasks',
            'is_course_specific' => true,
            'course_id' => $courseId,
            'order' => 3,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    foreach ($courseCategories as $category) {
        try {
            // Cek apakah kategori sudah ada
            $exists = DB::table('discussion_categories')
                        ->where('slug', $category['slug'])
                        ->exists();
            
            if (!$exists) {
                DB::table('discussion_categories')->insert($category);
                echo "Kategori '{$category['name']}' untuk course ID {$courseId} berhasil ditambahkan.\n";
                $count++;
            } else {
                echo "Kategori '{$category['name']}' untuk course ID {$courseId} sudah ada.\n";
            }
        } catch (Exception $e) {
            echo "Error saat menambahkan kategori '{$category['name']}': " . $e->getMessage() . "\n";
        }
    }
    
    echo "Kategori untuk course ID {$courseId} berhasil ditambahkan.\n";
} else {
    echo "Course dengan ID {$courseId} tidak ditemukan. Melewati penambahan kategori khusus course.\n";
}

echo "\nTotal {$count} kategori baru ditambahkan.\n";
echo "Selesai!\n"; 