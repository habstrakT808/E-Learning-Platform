<?php
// Script untuk menambahkan gambar sampul untuk course dan membersihkan enrollment
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Memperbarui gambar sampul course dan enrollment...\n";

// Hapus enrollment yang ada untuk user student@elearning.com
try {
    $student = DB::table('users')->where('email', 'student@elearning.com')->first();
    
    if ($student) {
        $count = DB::table('enrollments')->where('user_id', $student->id)->count();
        DB::table('enrollments')->where('user_id', $student->id)->delete();
        echo "Berhasil menghapus {$count} enrollment untuk user student@elearning.com.\n";
    } else {
        echo "User student@elearning.com tidak ditemukan.\n";
    }
} catch (Exception $e) {
    echo "Error saat menghapus enrollment: " . $e->getMessage() . "\n";
}

// Cek kolom yang ada di tabel enrollments
echo "Memeriksa struktur tabel enrollments...\n";
$enrollmentColumns = Schema::getColumnListing('enrollments');
echo "Kolom yang tersedia di tabel enrollments: " . implode(', ', $enrollmentColumns) . "\n";

// Cek dan buat direktori untuk gambar sampul jika belum ada
$imagesPath = public_path('images/courses');
if (!file_exists($imagesPath)) {
    mkdir($imagesPath, 0755, true);
    echo "Direktori untuk gambar sampul berhasil dibuat.\n";
}

// Daftar gambar sampul yang akan digunakan
$courseImages = [
    'web-development.jpg' => 'https://images.unsplash.com/photo-1547658719-da2b51169166?q=80&w=800&auto=format&fit=crop',
    'mobile-development.jpg' => 'https://images.unsplash.com/photo-1526925539332-aa3b66e35444?q=80&w=800&auto=format&fit=crop',
    'programming.jpg' => 'https://images.unsplash.com/photo-1516116216624-53e697fedbea?q=80&w=800&auto=format&fit=crop',
    'data-science.jpg' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop',
    'ai-ml.jpg' => 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?q=80&w=800&auto=format&fit=crop',
    'digital-marketing.jpg' => 'https://images.unsplash.com/photo-1533750349088-cd871a92f312?q=80&w=800&auto=format&fit=crop',
    'graphic-design.jpg' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=800&auto=format&fit=crop',
    'ui-ux-design.jpg' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?q=80&w=800&auto=format&fit=crop',
    'business.jpg' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=800&auto=format&fit=crop',
    'finance.jpg' => 'https://images.unsplash.com/photo-1638913662180-afc4334cf422?q=80&w=800&auto=format&fit=crop',
];

// Download gambar sampul
foreach ($courseImages as $filename => $url) {
    $fullPath = $imagesPath . '/' . $filename;
    if (!file_exists($fullPath)) {
        try {
            $imageContent = file_get_contents($url);
            if ($imageContent !== false) {
                file_put_contents($fullPath, $imageContent);
                echo "Berhasil mendownload gambar {$filename}.\n";
            } else {
                echo "Gagal mendownload gambar {$filename}.\n";
            }
        } catch (Exception $e) {
            echo "Error saat mendownload gambar {$filename}: " . $e->getMessage() . "\n";
        }
    } else {
        echo "Gambar {$filename} sudah ada.\n";
    }
}

// Periksa kolom image di tabel courses
if (!Schema::hasColumn('courses', 'image')) {
    echo "Menambahkan kolom image ke tabel courses...\n";
    try {
        Schema::table('courses', function ($table) {
            $table->string('image')->nullable();
        });
        echo "Kolom image berhasil ditambahkan ke tabel courses.\n";
    } catch (Exception $e) {
        echo "Error saat menambahkan kolom image: " . $e->getMessage() . "\n";
    }
}

// Update gambar sampul untuk semua course
try {
    $courses = DB::table('courses')->get();
    $updated = 0;
    
    foreach ($courses as $course) {
        // Gunakan gambar default secara bergilir berdasarkan ID course
        $imageName = array_keys($courseImages)[($course->id - 1) % count($courseImages)];
        
        // Update course image
        DB::table('courses')
            ->where('id', $course->id)
            ->update(['image' => 'images/courses/' . $imageName]);
        $updated++;
    }
    
    echo "Berhasil memperbarui gambar sampul untuk {$updated} course.\n";
} catch (Exception $e) {
    echo "Error saat memperbarui gambar sampul course: " . $e->getMessage() . "\n";
}

// Enroll user student@elearning.com ke semua course
try {
    $student = DB::table('users')->where('email', 'student@elearning.com')->first();
    $courses = DB::table('courses')->get();
    $enrolled = 0;
    
    if ($student) {
        foreach ($courses as $course) {
            // Buat array data berdasarkan kolom yang tersedia
            $data = [
                'user_id' => $student->id,
                'course_id' => $course->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Tambahkan kolom status dan progress jika tersedia
            if (in_array('status', $enrollmentColumns)) {
                $data['status'] = 'active';
            }
            
            if (in_array('progress', $enrollmentColumns)) {
                $data['progress'] = 0;
            }
            
            // Tambahkan enrollment baru
            DB::table('enrollments')->insert($data);
            $enrolled++;
        }
        
        echo "Berhasil mengenroll user student@elearning.com ke {$enrolled} course.\n";
    } else {
        echo "User student@elearning.com tidak ditemukan.\n";
    }
} catch (Exception $e) {
    echo "Error saat mengenroll user: " . $e->getMessage() . "\n";
}

echo "\nSelesai!\n"; 