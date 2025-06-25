<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/bootstrap/app.php';

use App\Models\Assignment;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionOption;
use Illuminate\Support\Str;

// Course ID (Complete Laravel Development Course)
$courseId = 1;
$sectionId = 2; // Section 2: Core Principles

// Create Assignment
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
    
    echo "Assignment created with ID: " . $assignment->id . "\n";
} catch (Exception $e) {
    echo "Error creating assignment: " . $e->getMessage() . "\n";
}

// Create Quiz
try {
    $quiz = new Quiz();
    $quiz->course_id = $courseId;
    $quiz->section_id = $sectionId;
    $quiz->title = 'Laravel Fundamentals Quiz';
    $quiz->description = 'Test your knowledge of Laravel core concepts including routing, controllers, models, and Eloquent ORM.';
    $quiz->time_limit = 30; // 30 minutes
    $quiz->passing_score = 70;
    $quiz->max_attempts = 2;
    $quiz->show_correct_answers = true;
    $quiz->randomize_questions = false;
    $quiz->is_published = true;
    $quiz->save();
    
    echo "Quiz created with ID: " . $quiz->id . "\n";
    
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
    
    echo "Quiz questions and options created successfully.\n";
} catch (Exception $e) {
    echo "Error creating quiz: " . $e->getMessage() . "\n";
}

echo "Done!\n"; 