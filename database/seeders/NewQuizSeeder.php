<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionOption;

class NewQuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tambahkan quiz baru ke course "Web Development with Laravel" (ID: 1)
        $quiz = Quiz::create([
            'course_id' => 1, // ID course Web Development with Laravel
            'section_id' => 1, // Sesuaikan dengan section yang sesuai
            'title' => 'Advanced Laravel Quiz',
            'description' => 'Tes pengetahuan lanjutan tentang Laravel untuk memastikan Anda telah memahami konsep-konsep penting',
            'time_limit' => 30, // 30 menit
            'passing_score' => 70,
            'max_attempts' => 3,
            'show_correct_answers' => true,
            'randomize_questions' => false,
            'is_published' => true,
        ]);
        
        // Pertanyaan 1
        $question1 = QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question' => 'Apa yang dimaksud dengan Eloquent ORM dalam Laravel?',
            'type' => 'multiple_choice',
            'points' => 20,
            'order' => 1,
        ]);

        // Opsi untuk Pertanyaan 1
        QuizQuestionOption::create([
            'question_id' => $question1->id,
            'option_text' => 'Bahasa pemrograman yang digunakan Laravel',
            'is_correct' => false,
            'order' => 1,
        ]);
        
        QuizQuestionOption::create([
            'question_id' => $question1->id,
            'option_text' => 'Object Relational Mapping untuk berinteraksi dengan database',
            'is_correct' => true,
            'order' => 2,
        ]);
        
        QuizQuestionOption::create([
            'question_id' => $question1->id,
            'option_text' => 'Sistem manajemen file Laravel',
            'is_correct' => false,
            'order' => 3,
        ]);
        
        QuizQuestionOption::create([
            'question_id' => $question1->id,
            'option_text' => 'Komponen keamanan Laravel',
            'is_correct' => false,
            'order' => 4,
        ]);
        
        // Pertanyaan 2
        $question2 = QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question' => 'Apa peran middleware dalam aplikasi Laravel?',
            'type' => 'multiple_choice',
            'points' => 20,
            'order' => 2,
        ]);
        
        // Opsi untuk Pertanyaan 2
        QuizQuestionOption::create([
            'question_id' => $question2->id,
            'option_text' => 'Menangani database migration',
            'is_correct' => false,
            'order' => 1,
        ]);
        
        QuizQuestionOption::create([
            'question_id' => $question2->id,
            'option_text' => 'Memfilter HTTP requests sebelum mencapai controller',
            'is_correct' => true,
            'order' => 2,
        ]);
        
        QuizQuestionOption::create([
            'question_id' => $question2->id,
            'option_text' => 'Merender tampilan frontend',
            'is_correct' => false,
            'order' => 3,
        ]);
        
        QuizQuestionOption::create([
            'question_id' => $question2->id,
            'option_text' => 'Mengoptimalkan query database',
            'is_correct' => false,
            'order' => 4,
        ]);
        
        // Pertanyaan 3
        $question3 = QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question' => 'Apa fungsi dari Laravel Artisan?',
            'type' => 'multiple_choice',
            'points' => 20,
            'order' => 3,
        ]);
        
        // Opsi untuk Pertanyaan 3
        QuizQuestionOption::create([
            'question_id' => $question3->id,
            'option_text' => 'Command-line interface untuk otomatisasi tugas',
            'is_correct' => true,
            'order' => 1,
        ]);
        
        QuizQuestionOption::create([
            'question_id' => $question3->id,
            'option_text' => 'Library untuk membuat animasi UI',
            'is_correct' => false,
            'order' => 2,
        ]);
        
        QuizQuestionOption::create([
            'question_id' => $question3->id,
            'option_text' => 'Framework CSS untuk Laravel',
            'is_correct' => false,
            'order' => 3,
        ]);
        
        QuizQuestionOption::create([
            'question_id' => $question3->id,
            'option_text' => 'Sistem manajemen konten',
            'is_correct' => false,
            'order' => 4,
        ]);
        
        // Pertanyaan 4
        $question4 = QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question' => 'Apa itu Laravel Blade?',
            'type' => 'multiple_choice',
            'points' => 20,
            'order' => 4,
        ]);
        
        // Opsi untuk Pertanyaan 4
        QuizQuestionOption::create([
            'question_id' => $question4->id,
            'option_text' => 'Sistem basis data Laravel',
            'is_correct' => false,
            'order' => 1,
        ]);
        
        QuizQuestionOption::create([
            'question_id' => $question4->id,
            'option_text' => 'Template engine untuk membuat view',
            'is_correct' => true,
            'order' => 2,
        ]);
        
        QuizQuestionOption::create([
            'question_id' => $question4->id,
            'option_text' => 'Caching sistem Laravel',
            'is_correct' => false,
            'order' => 3,
        ]);
        
        QuizQuestionOption::create([
            'question_id' => $question4->id,
            'option_text' => 'Komponen autentikasi',
            'is_correct' => false,
            'order' => 4,
        ]);
        
        // Pertanyaan 5
        $question5 = QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question' => 'Perintah Laravel untuk membuat migration adalah:',
            'type' => 'multiple_choice',
            'points' => 20,
            'order' => 5,
        ]);
        
        // Opsi untuk Pertanyaan 5
        QuizQuestionOption::create([
            'question_id' => $question5->id,
            'option_text' => 'php artisan migration:make',
            'is_correct' => false,
            'order' => 1,
        ]);
        
        QuizQuestionOption::create([
            'question_id' => $question5->id,
            'option_text' => 'php artisan make:migration',
            'is_correct' => true,
            'order' => 2,
        ]);
        
        QuizQuestionOption::create([
            'question_id' => $question5->id,
            'option_text' => 'php artisan create:migration',
            'is_correct' => false,
            'order' => 3,
        ]);
        
        QuizQuestionOption::create([
            'question_id' => $question5->id,
            'option_text' => 'php artisan db:migration',
            'is_correct' => false,
            'order' => 4,
        ]);
        
        $this->command->info('Quiz baru berhasil ditambahkan ke course Web Development with Laravel!');
    }
} 