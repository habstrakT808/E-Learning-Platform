<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;
use App\Models\Review;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data reviews lama
        DB::table('reviews')->truncate();
        
        // Ambil semua course
        $courses = Course::all();
        $students = User::role('student')->get();
        
        if ($students->count() == 0) {
            $this->command->error('No students found. Please run UserSeeder first.');
            return;
        }
        
        $this->command->info('Adding reviews for courses...');
        $reviewsCreated = 0;
        
        // Buat array untuk melacak kombinasi user_id dan course_id yang sudah digunakan
        $usedCombinations = [];
        
        foreach ($courses as $course) {
            // Tambahkan 3-8 reviews per course
            $reviewCount = min(rand(3, 8), $students->count());
            $reviewsAdded = 0;
            
            // Shuffle students untuk mengambil beberapa secara acak
            $shuffledStudents = $students->shuffle();
            
            foreach ($shuffledStudents as $student) {
                // Cek apakah kombinasi ini sudah digunakan
                $combinationKey = $student->id . '-' . $course->id;
                if (in_array($combinationKey, $usedCombinations)) {
                    continue;
                }
                
                // Cek apakah student sudah terdaftar di course ini
                $enrollment = Enrollment::where('user_id', $student->id)
                    ->where('course_id', $course->id)
                    ->first();
                
                // Jika belum terdaftar, buatkan enrollment baru
                if (!$enrollment) {
                    $enrollment = Enrollment::create([
                        'user_id' => $student->id,
                        'course_id' => $course->id,
                        'progress' => rand(50, 100),
                        'enrolled_at' => now()->subDays(rand(1, 60)),
                    ]);
                }
                
                // Tambahkan review
                $rating = rand(3, 5); // Lebih banyak rating bagus
                $review = Review::create([
                    'user_id' => $student->id,
                    'course_id' => $course->id,
                    'rating' => $rating,
                    'comment' => $this->getReviewComment($rating),
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
                
                // Tambahkan kombinasi ke array yang sudah digunakan
                $usedCombinations[] = $combinationKey;
                
                $reviewsCreated++;
                $reviewsAdded++;
                
                // Hentikan loop jika sudah mencapai jumlah review yang diinginkan
                if ($reviewsAdded >= $reviewCount) {
                    break;
                }
            }
            
            $this->command->info("- {$course->title}: {$reviewsAdded} reviews added");
        }
        
        $this->command->info("Successfully created {$reviewsCreated} reviews!");
    }
    
    private function getReviewComment($rating)
    {
        $excellentComments = [
            "This course is excellent! The instructor explains everything in detail and the examples are very practical.",
            "One of the best courses I've taken. Very comprehensive and well-structured.",
            "Absolutely loved this course. The content is top-notch and the exercises helped reinforce the concepts.",
            "Outstanding course with clear explanations and practical examples. Highly recommended!",
            "The instructor is fantastic and knows how to explain complex topics in an easy-to-understand way.",
        ];
        
        $goodComments = [
            "Good course with solid content. I learned a lot from it.",
            "The material is presented well and the exercises are helpful. Would recommend.",
            "Pretty good course. The instructor knows the subject well and explains it clearly.",
            "I enjoyed this course. The content is valuable and I've learned practical skills.",
            "Solid course with good examples and explanations.",
        ];
        
        $averageComments = [
            "Decent course, but some sections could be more detailed.",
            "The content is good but the pace is a bit slow in some parts.",
            "I learned from this course but expected more practical examples.",
            "It's an okay course. Some sections are better than others.",
            "Good information overall, but could use more exercises.",
        ];
        
        if ($rating == 5) {
            return $excellentComments[array_rand($excellentComments)];
        } elseif ($rating == 4) {
            return $goodComments[array_rand($goodComments)];
        } else {
            return $averageComments[array_rand($averageComments)];
        }
    }
}
