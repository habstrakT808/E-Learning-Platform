<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionOption;
use Illuminate\Support\Str;

class CreateQuiz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:quiz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a quiz for Laravel course';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Course ID (Complete Laravel Development Course)
        $courseId = 1;

        // Create Quiz
        $this->info('Creating quiz...');
        try {
            $quiz = new Quiz();
            $quiz->course_id = $courseId;
            $quiz->title = 'Laravel Fundamentals Quiz';
            $quiz->description = 'Test your knowledge of Laravel core concepts including routing, controllers, models, and Eloquent ORM.';
            $quiz->slug = Str::slug('Laravel Fundamentals Quiz-' . uniqid());
            $quiz->time_limit = 30;
            $quiz->pass_percentage = 70;
            $quiz->max_attempts = 2;
            $quiz->is_published = true;
            $quiz->randomize_questions = false;
            $quiz->show_correct_answers = true;
            $quiz->created_at = now();
            $quiz->save();
            
            $this->info("Quiz created with ID: " . $quiz->id);
            
            // Add question 1
            $question1 = new QuizQuestion();
            $question1->quiz_id = $quiz->id;
            $question1->question = 'Which artisan command is used to create a new controller?';
            $question1->type = 'multiple_choice';
            $question1->explanation = 'The make:controller command is used to generate a new controller class.';
            $question1->points = 10;
            $question1->order = 1;
            $question1->save();
            
            // Add options for question 1
            $options1 = [
                ['php artisan make:controller', true],
                ['php artisan create:controller', false],
                ['php artisan controller:make', false],
                ['php artisan new:controller', false],
            ];
            
            foreach ($options1 as $index => $optionData) {
                $option = new QuizQuestionOption();
                $option->quiz_question_id = $question1->id;
                $option->option_text = $optionData[0];
                $option->is_correct = $optionData[1];
                $option->order = $index + 1;
                $option->save();
            }
            
            // Add question 2
            $question2 = new QuizQuestion();
            $question2->quiz_id = $quiz->id;
            $question2->question = 'Laravel follows which architectural pattern?';
            $question2->type = 'multiple_choice';
            $question2->explanation = 'Laravel follows the Model-View-Controller (MVC) architectural pattern.';
            $question2->points = 10;
            $question2->order = 2;
            $question2->save();
            
            // Add options for question 2
            $options2 = [
                ['MVP (Model-View-Presenter)', false],
                ['MVC (Model-View-Controller)', true],
                ['MVVM (Model-View-ViewModel)', false],
                ['SOA (Service-Oriented Architecture)', false],
            ];
            
            foreach ($options2 as $index => $optionData) {
                $option = new QuizQuestionOption();
                $option->quiz_question_id = $question2->id;
                $option->option_text = $optionData[0];
                $option->is_correct = $optionData[1];
                $option->order = $index + 1;
                $option->save();
            }
            
            // Add question 3
            $question3 = new QuizQuestion();
            $question3->quiz_id = $quiz->id;
            $question3->question = 'What is the command to create a new Laravel migration?';
            $question3->type = 'multiple_choice';
            $question3->explanation = 'The make:migration command is used to create a new database migration.';
            $question3->points = 10;
            $question3->order = 3;
            $question3->save();
            
            // Add options for question 3
            $options3 = [
                ['php artisan make:migration', true],
                ['php artisan create:migration', false],
                ['php artisan migration:new', false],
                ['php artisan db:migration', false],
            ];
            
            foreach ($options3 as $index => $optionData) {
                $option = new QuizQuestionOption();
                $option->quiz_question_id = $question3->id;
                $option->option_text = $optionData[0];
                $option->is_correct = $optionData[1];
                $option->order = $index + 1;
                $option->save();
            }
            
            $this->info("Quiz questions and options created successfully.");
        } catch (\Exception $e) {
            $this->error("Error creating quiz: " . $e->getMessage());
        }

        $this->info('Done!');
    }
} 