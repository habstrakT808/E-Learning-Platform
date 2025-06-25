<?php
// Script untuk membuat contoh quiz
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

echo "Membuat contoh quiz...\n";

// Data contoh untuk quiz
$quizData = [
    [
        'title' => 'Dasar-dasar HTML dan CSS',
        'description' => 'Quiz untuk menguji pemahaman Anda tentang dasar-dasar HTML dan CSS.',
        'course_id' => 1, // Web Development Fundamentals
        'time_limit' => 20,
        'pass_percentage' => 70,
        'max_attempts' => 3,
        'is_published' => true,
        'randomize_questions' => false,
        'show_correct_answers' => true,
        'questions' => [
            [
                'question' => 'Apa kepanjangan dari HTML?',
                'type' => 'multiple_choice',
                'points' => 10,
                'order' => 1,
                'options' => [
                    ['option_text' => 'Hyper Text Markup Language', 'is_correct' => true],
                    ['option_text' => 'Hyper Transfer Markup Language', 'is_correct' => false],
                    ['option_text' => 'High Text Machine Language', 'is_correct' => false],
                    ['option_text' => 'Hyper Transfer Machine Language', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Tag HTML mana yang digunakan untuk membuat paragraf?',
                'type' => 'multiple_choice',
                'points' => 10,
                'order' => 2,
                'options' => [
                    ['option_text' => '<p>', 'is_correct' => true],
                    ['option_text' => '<paragraph>', 'is_correct' => false],
                    ['option_text' => '<para>', 'is_correct' => false],
                    ['option_text' => '<pg>', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Properti CSS mana yang digunakan untuk mengubah warna teks?',
                'type' => 'multiple_choice',
                'points' => 10,
                'order' => 3,
                'options' => [
                    ['option_text' => 'color', 'is_correct' => true],
                    ['option_text' => 'text-color', 'is_correct' => false],
                    ['option_text' => 'font-color', 'is_correct' => false],
                    ['option_text' => 'text-style', 'is_correct' => false],
                ],
            ],
        ],
    ],
    [
        'title' => 'Dasar JavaScript',
        'description' => 'Quiz untuk menguji pemahaman Anda tentang dasar-dasar JavaScript.',
        'course_id' => 2, // JavaScript Fundamentals
        'time_limit' => 25,
        'pass_percentage' => 75,
        'max_attempts' => 2,
        'is_published' => true,
        'randomize_questions' => true,
        'show_correct_answers' => true,
        'questions' => [
            [
                'question' => 'Bagaimana cara mendefinisikan variabel dalam JavaScript?',
                'type' => 'multiple_choice',
                'points' => 10,
                'order' => 1,
                'options' => [
                    ['option_text' => 'var x = 5;', 'is_correct' => true],
                    ['option_text' => 'variable x = 5;', 'is_correct' => false],
                    ['option_text' => 'v x = 5;', 'is_correct' => false],
                    ['option_text' => 'x := 5;', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Fungsi alert() dalam JavaScript digunakan untuk:',
                'type' => 'multiple_choice',
                'points' => 10,
                'order' => 2,
                'options' => [
                    ['option_text' => 'Menampilkan dialog pesan kepada pengguna', 'is_correct' => true],
                    ['option_text' => 'Mencetak pesan ke konsol', 'is_correct' => false],
                    ['option_text' => 'Menulis ke dokumen HTML', 'is_correct' => false],
                    ['option_text' => 'Mengalihkan ke halaman lain', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Operator "===" dalam JavaScript adalah:',
                'type' => 'multiple_choice',
                'points' => 10,
                'order' => 3,
                'options' => [
                    ['option_text' => 'Operator perbandingan ketat (strict equality)', 'is_correct' => true],
                    ['option_text' => 'Operator penugasan (assignment)', 'is_correct' => false],
                    ['option_text' => 'Operator aritmatika', 'is_correct' => false],
                    ['option_text' => 'Operator logika', 'is_correct' => false],
                ],
            ],
        ],
    ],
    [
        'title' => 'Dasar-dasar UI/UX Design',
        'description' => 'Quiz untuk menguji pemahaman Anda tentang dasar-dasar UI/UX Design.',
        'course_id' => 16, // UI/UX Design Principles
        'time_limit' => 15,
        'pass_percentage' => 70,
        'max_attempts' => 3,
        'is_published' => true,
        'randomize_questions' => false,
        'show_correct_answers' => true,
        'questions' => [
            [
                'question' => 'Apa yang dimaksud dengan UX Design?',
                'type' => 'multiple_choice',
                'points' => 10,
                'order' => 1,
                'options' => [
                    ['option_text' => 'User Experience Design', 'is_correct' => true],
                    ['option_text' => 'User Interface Design', 'is_correct' => false],
                    ['option_text' => 'User External Design', 'is_correct' => false],
                    ['option_text' => 'Unified Experience Design', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Apa tujuan utama dari wireframing?',
                'type' => 'multiple_choice',
                'points' => 10,
                'order' => 2,
                'options' => [
                    ['option_text' => 'Membuat kerangka dasar layout tanpa detail visual', 'is_correct' => true],
                    ['option_text' => 'Membuat desain final dengan detail warna', 'is_correct' => false],
                    ['option_text' => 'Menambahkan efek animasi ke desain', 'is_correct' => false],
                    ['option_text' => 'Menguji interaksi pengguna', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Apa prinsip desain yang mengacu pada penggunaan elemen visual yang serupa?',
                'type' => 'multiple_choice',
                'points' => 10,
                'order' => 3,
                'options' => [
                    ['option_text' => 'Konsistensi', 'is_correct' => true],
                    ['option_text' => 'Kontras', 'is_correct' => false],
                    ['option_text' => 'Hierarki', 'is_correct' => false],
                    ['option_text' => 'Keseimbangan', 'is_correct' => false],
                ],
            ],
        ],
    ],
    [
        'title' => 'Digital Marketing Dasar',
        'description' => 'Quiz untuk menguji pemahaman Anda tentang dasar-dasar Digital Marketing.',
        'course_id' => 15, // Social Media Marketing
        'time_limit' => 20,
        'pass_percentage' => 70,
        'max_attempts' => 3,
        'is_published' => true,
        'randomize_questions' => false,
        'show_correct_answers' => true,
        'questions' => [
            [
                'question' => 'Apa yang dimaksud dengan SEO?',
                'type' => 'multiple_choice',
                'points' => 10,
                'order' => 1,
                'options' => [
                    ['option_text' => 'Search Engine Optimization', 'is_correct' => true],
                    ['option_text' => 'Social Engagement Opportunity', 'is_correct' => false],
                    ['option_text' => 'Social Engine Optimization', 'is_correct' => false],
                    ['option_text' => 'Search Engagement Opportunity', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Platform media sosial mana yang paling cocok untuk pemasaran B2B?',
                'type' => 'multiple_choice',
                'points' => 10,
                'order' => 2,
                'options' => [
                    ['option_text' => 'LinkedIn', 'is_correct' => true],
                    ['option_text' => 'Instagram', 'is_correct' => false],
                    ['option_text' => 'TikTok', 'is_correct' => false],
                    ['option_text' => 'Snapchat', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Apa yang dimaksud dengan CTR dalam digital marketing?',
                'type' => 'multiple_choice',
                'points' => 10,
                'order' => 3,
                'options' => [
                    ['option_text' => 'Click-Through Rate', 'is_correct' => true],
                    ['option_text' => 'Content Transfer Rate', 'is_correct' => false],
                    ['option_text' => 'Customer Targeting Response', 'is_correct' => false],
                    ['option_text' => 'Customer Traffic Rate', 'is_correct' => false],
                ],
            ],
        ],
    ],
];

// Buat quiz dan pertanyaan
foreach ($quizData as $quiz) {
    echo "Membuat quiz: {$quiz['title']} untuk course ID {$quiz['course_id']}...\n";
    
    try {
        // Cek apakah quiz sudah ada
        $existingQuiz = DB::table('quizzes')
            ->where('title', $quiz['title'])
            ->where('course_id', $quiz['course_id'])
            ->first();
        
        if ($existingQuiz) {
            echo "Quiz '{$quiz['title']}' sudah ada. Melewati...\n";
            continue;
        }
        
        // Buat quiz
        $quizId = DB::table('quizzes')->insertGetId([
            'course_id' => $quiz['course_id'],
            'title' => $quiz['title'],
            'description' => $quiz['description'],
            'slug' => Str::slug($quiz['title']),
            'time_limit' => $quiz['time_limit'],
            'pass_percentage' => $quiz['pass_percentage'],
            'max_attempts' => $quiz['max_attempts'],
            'is_published' => $quiz['is_published'],
            'randomize_questions' => $quiz['randomize_questions'],
            'show_correct_answers' => $quiz['show_correct_answers'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        echo "Quiz berhasil dibuat dengan ID: {$quizId}\n";
        
        // Buat pertanyaan dan opsi
        foreach ($quiz['questions'] as $question) {
            $questionId = DB::table('quiz_questions')->insertGetId([
                'quiz_id' => $quizId,
                'question' => $question['question'],
                'type' => $question['type'],
                'points' => $question['points'],
                'order' => $question['order'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            echo "Pertanyaan '{$question['question']}' berhasil dibuat.\n";
            
            // Buat opsi jawaban
            foreach ($question['options'] as $option) {
                DB::table('quiz_question_options')->insert([
                    'quiz_question_id' => $questionId,
                    'option_text' => $option['option_text'],
                    'is_correct' => $option['is_correct'],
                    'order' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            echo "Opsi jawaban untuk pertanyaan '{$question['question']}' berhasil dibuat.\n";
        }
    } catch (Exception $e) {
        echo "Error saat membuat quiz '{$quiz['title']}': " . $e->getMessage() . "\n";
    }
}

echo "\nSelesai!\n"; 