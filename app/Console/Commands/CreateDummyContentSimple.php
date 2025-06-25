<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Assignment;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionOption;

class CreateDummyContentSimple extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:dummy-simple';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create simplified dummy assignment and quiz for Laravel course';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Course ID (Complete Laravel Development Course)
        $courseId = 1;

        // Create Assignment
        $this->info('Creating assignment...');
        try {
            $assignment = new Assignment();
            $assignment->course_id = $courseId;
            $assignment->title = 'Create a Laravel Authentication System';
            $assignment->description = 'Build a custom authentication system in Laravel with registration, login, email verification, and password reset functionality.';
            $assignment->slug = 'create-laravel-authentication-system';
            $assignment->deadline = date('Y-m-d H:i:s', strtotime('+10 days'));
            $assignment->max_score = 100;
            $assignment->max_attempts = 2;
            $assignment->is_active = true;
            $assignment->save();
            
            $this->info("Assignment created with ID: " . $assignment->id);
        } catch (\Exception $e) {
            $this->error("Error creating assignment: " . $e->getMessage());
        }

        // Create Quiz
        $this->info('Creating quiz...');
        try {
            $quiz = new Quiz();
            $quiz->course_id = $courseId;
            $quiz->title = 'Laravel Routing and Controllers Quiz';
            $quiz->description = 'Test your knowledge of Laravel routing, controllers, and request handling.';
            $quiz->time_limit = 15; // 15 minutes
            $quiz->max_attempts = 3;
            $quiz->show_correct_answers = true;
            $quiz->is_published = true;
            $quiz->save();
            
            $this->info("Quiz created with ID: " . $quiz->id);
            
            // Add a simple question
            $question = new QuizQuestion();
            $question->quiz_id = $quiz->id;
            $question->question = 'Which method is used to define a GET route in Laravel?';
            $question->type = 'multiple_choice';
            $question->points = 10;
            $question->order = 1;
            $question->save();
            
            // Add options
            $options = [
                ['Route::get()', true],
                ['Route::post()', false],
                ['Route::request()', false],
                ['Route::fetch()', false],
            ];
            
            foreach ($options as $index => $optionData) {
                $option = new QuizQuestionOption();
                $option->quiz_question_id = $question->id;
                $option->option_text = $optionData[0];
                $option->is_correct = $optionData[1];
                $option->order = $index + 1;
                $option->save();
            }
            
            $this->info("Quiz question and options created successfully.");
        } catch (\Exception $e) {
            $this->error("Error creating quiz: " . $e->getMessage());
        }

        $this->info('Done!');
    }
} 