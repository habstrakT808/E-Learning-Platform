<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get course IDs
        $courseIds = DB::table('courses')->pluck('id')->toArray();
        
        if (empty($courseIds)) {
            // If no courses exist, we can't create quizzes
            $this->command->info('No courses found. Skipping quiz seeding.');
            return;
        }

        // Add a sample quiz for each course
        foreach ($courseIds as $courseId) {
            $quizId = DB::table('quizzes')->insertGetId([
                'course_id' => $courseId,
                'title' => 'Course Quiz ' . $courseId,
                'description' => 'Test your knowledge from this course',
                'slug' => 'course-quiz-' . $courseId,
                'time_limit' => 30,
                'pass_percentage' => 70,
                'max_attempts' => 3,
                'is_published' => true,
                'randomize_questions' => false,
                'show_correct_answers' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Add sample questions
            $questionId1 = DB::table('quiz_questions')->insertGetId([
                'quiz_id' => $quizId,
                'question' => 'What is Laravel?',
                'type' => 'multiple_choice',
                'points' => 10,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Add options for question 1
            DB::table('quiz_question_options')->insert([
                [
                    'quiz_question_id' => $questionId1,
                    'option_text' => 'A PHP Framework',
                    'is_correct' => true,
                    'order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'quiz_question_id' => $questionId1,
                    'option_text' => 'A JavaScript Framework',
                    'is_correct' => false,
                    'order' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'quiz_question_id' => $questionId1,
                    'option_text' => 'A Database System',
                    'is_correct' => false,
                    'order' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            $questionId2 = DB::table('quiz_questions')->insertGetId([
                'quiz_id' => $quizId,
                'question' => 'Which command is used to create a new Laravel project?',
                'type' => 'multiple_choice',
                'points' => 10,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Add options for question 2
            DB::table('quiz_question_options')->insert([
                [
                    'quiz_question_id' => $questionId2,
                    'option_text' => 'composer create-project laravel/laravel',
                    'is_correct' => true,
                    'order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'quiz_question_id' => $questionId2,
                    'option_text' => 'npm install laravel',
                    'is_correct' => false,
                    'order' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'quiz_question_id' => $questionId2,
                    'option_text' => 'php artisan new',
                    'is_correct' => false,
                    'order' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
} 