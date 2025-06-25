<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Assignment;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionOption;
use Illuminate\Support\Str;

class CreateDummyContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:dummy-content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create dummy assignment and quiz for Laravel course';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Course ID (Complete Laravel Development Course)
        $courseId = 1;
        $sectionId = 2; // Section 2: Core Principles

        // Create Assignment
        $this->info('Creating assignment...');
        try {
            $assignment = new Assignment();
            $assignment->course_id = $courseId;
            $assignment->title = 'Build a RESTful API with Laravel';
            $assignment->description = 'Create a simple RESTful API for a blog with posts and comments. Your API should support CRUD operations for both resources and implement proper validation and authentication.';
            $assignment->slug = 'build-a-restful-api-with-laravel';
            $assignment->deadline = date('Y-m-d H:i:s', strtotime('+7 days'));
            $assignment->max_score = 100;
            $assignment->max_attempts = 3;
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
            $quiz->title = 'Laravel Fundamentals Quiz';
            $quiz->description = 'Test your knowledge of Laravel core concepts including routing, controllers, models, and Eloquent ORM.';
            $quiz->time_limit = 30; // 30 minutes
            $quiz->passing_score = 70;
            $quiz->max_attempts = 2;
            $quiz->show_correct_answers = true;
            $quiz->randomize_questions = false;
            $quiz->is_published = true;
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
            $option1 = new QuizQuestionOption();
            $option1->quiz_question_id = $question1->id;
            $option1->option_text = 'php artisan make:controller';
            $option1->is_correct = true;
            $option1->order = 1;
            $option1->save();
            
            $option2 = new QuizQuestionOption();
            $option2->quiz_question_id = $question1->id;
            $option2->option_text = 'php artisan create:controller';
            $option2->is_correct = false;
            $option2->order = 2;
            $option2->save();
            
            $option3 = new QuizQuestionOption();
            $option3->quiz_question_id = $question1->id;
            $option3->option_text = 'php artisan controller:make';
            $option3->is_correct = false;
            $option3->order = 3;
            $option3->save();
            
            $option4 = new QuizQuestionOption();
            $option4->quiz_question_id = $question1->id;
            $option4->option_text = 'php artisan new:controller';
            $option4->is_correct = false;
            $option4->order = 4;
            $option4->save();
            
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
            $option1 = new QuizQuestionOption();
            $option1->quiz_question_id = $question2->id;
            $option1->option_text = 'MVP (Model-View-Presenter)';
            $option1->is_correct = false;
            $option1->order = 1;
            $option1->save();
            
            $option2 = new QuizQuestionOption();
            $option2->quiz_question_id = $question2->id;
            $option2->option_text = 'MVC (Model-View-Controller)';
            $option2->is_correct = true;
            $option2->order = 2;
            $option2->save();
            
            $option3 = new QuizQuestionOption();
            $option3->quiz_question_id = $question2->id;
            $option3->option_text = 'MVVM (Model-View-ViewModel)';
            $option3->is_correct = false;
            $option3->order = 3;
            $option3->save();
            
            $option4 = new QuizQuestionOption();
            $option4->quiz_question_id = $question2->id;
            $option4->option_text = 'SOA (Service-Oriented Architecture)';
            $option4->is_correct = false;
            $option4->order = 4;
            $option4->save();
            
            $this->info("Quiz questions and options created successfully.");
        } catch (\Exception $e) {
            $this->error("Error creating quiz: " . $e->getMessage());
        }

        $this->info('Done!');
    }
} 