<?php
// Script untuk membuat contoh data quiz
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

echo "Membuat contoh data quiz...\n";

// Dapatkan course ids
$courses = DB::table('courses')->limit(3)->get();

if ($courses->isEmpty()) {
    echo "Error: Tidak ada courses yang ditemukan.\n";
    exit(1);
}

echo "Ditemukan " . $courses->count() . " courses.\n";

// Cek struktur tabel quiz_question_options
$questionOptionsColumns = DB::getSchemaBuilder()->getColumnListing('quiz_question_options');
echo "Kolom pada tabel quiz_question_options: " . implode(', ', $questionOptionsColumns) . "\n";

// Jika kolom question_id tidak ada dalam tabel
if (!in_array('question_id', $questionOptionsColumns)) {
    echo "Error: Kolom question_id tidak ditemukan di tabel quiz_question_options.\n";
    echo "Mencoba menambahkan kolom question_id...\n";
    
    try {
        DB::statement('ALTER TABLE quiz_question_options ADD COLUMN question_id BIGINT UNSIGNED AFTER id');
        echo "Kolom question_id berhasil ditambahkan.\n";
    } catch (Exception $e) {
        echo "Error saat menambahkan kolom: " . $e->getMessage() . "\n";
    }
}

// Hapus data yang ada di tabel-tabel quiz untuk menghindari duplikasi
try {
    // Hapus dari tabel child terlebih dahulu, kemudian ke parent
    echo "Menghapus data lama dari tabel quiz_answers...\n";
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('quiz_answers')->delete();
    
    echo "Menghapus data lama dari tabel quiz_attempts...\n";
    DB::table('quiz_attempts')->delete();
    
    echo "Menghapus data lama dari tabel quiz_question_options...\n";
    DB::table('quiz_question_options')->delete();
    
    echo "Menghapus data lama dari tabel quiz_questions...\n";
    DB::table('quiz_questions')->delete();
    
    echo "Menghapus data lama dari tabel quizzes...\n";
    DB::table('quizzes')->delete();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
    
    echo "Semua data lama berhasil dihapus.\n";
} catch (Exception $e) {
    echo "Error saat menghapus data: " . $e->getMessage() . "\n";
    // Lanjutkan proses meskipun ada error
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
}

// Data contoh untuk quiz
foreach ($courses as $index => $course) {
    // Buat quiz baru
    $quizId = DB::table('quizzes')->insertGetId([
        'course_id' => $course->id,
        'title' => 'Quiz ' . ($index + 1) . ': ' . $course->title,
        'description' => 'Tes pemahaman Anda tentang materi di ' . $course->title,
        'slug' => 'quiz-' . ($index + 1) . '-' . Str::slug($course->title),
        'time_limit' => 30, // 30 menit
        'pass_percentage' => 70,
        'max_attempts' => 3,
        'is_published' => true,
        'randomize_questions' => false,
        'show_correct_answers' => true,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);
    
    echo "Berhasil membuat quiz untuk course: " . $course->title . "\n";
    
    // Buat pertanyaan untuk quiz
    $questions = [
        [
            'question' => 'Apa yang dimaksud dengan ' . $course->title . '?',
            'type' => 'multiple_choice',
            'points' => 10,
            'explanation' => 'Penjelasan tentang definisi ' . $course->title,
            'options' => [
                ['text' => 'Jawaban benar tentang ' . $course->title, 'is_correct' => true],
                ['text' => 'Jawaban salah 1', 'is_correct' => false],
                ['text' => 'Jawaban salah 2', 'is_correct' => false],
                ['text' => 'Jawaban salah 3', 'is_correct' => false],
            ]
        ],
        [
            'question' => 'Manfaat utama dari ' . $course->title . ' adalah:',
            'type' => 'multiple_choice',
            'points' => 10,
            'explanation' => 'Penjelasan tentang manfaat ' . $course->title,
            'options' => [
                ['text' => 'Manfaat utama yang benar', 'is_correct' => true],
                ['text' => 'Manfaat yang kurang tepat', 'is_correct' => false],
                ['text' => 'Bukan manfaat dari ' . $course->title, 'is_correct' => false],
                ['text' => 'Pernyataan yang salah tentang manfaat', 'is_correct' => false],
            ]
        ],
        [
            'question' => 'Apakah ' . $course->title . ' penting untuk dipelajari?',
            'type' => 'true_false',
            'points' => 5,
            'explanation' => 'Penjelasan tentang pentingnya ' . $course->title,
            'options' => [
                ['text' => 'Benar', 'is_correct' => true],
                ['text' => 'Salah', 'is_correct' => false],
            ]
        ]
    ];
    
    foreach ($questions as $order => $questionData) {
        // Buat pertanyaan
        $questionId = DB::table('quiz_questions')->insertGetId([
            'quiz_id' => $quizId,
            'question' => $questionData['question'],
            'type' => $questionData['type'],
            'points' => $questionData['points'],
            'explanation' => $questionData['explanation'],
            'order' => $order,
            'is_required' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        echo "  - Berhasil menambahkan pertanyaan: " . $questionData['question'] . "\n";
        
        // Tambahkan opsi jawaban
        foreach ($questionData['options'] as $optionOrder => $option) {
            DB::table('quiz_question_options')->insert([
                'question_id' => $questionId,
                'quiz_question_id' => $questionId,
                'option_text' => $option['text'],
                'is_correct' => $option['is_correct'],
                'order' => $optionOrder,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        
        echo "    Berhasil menambahkan " . count($questionData['options']) . " opsi jawaban\n";
    }
}

echo "\nProses pembuatan data contoh quiz selesai!\n"; 