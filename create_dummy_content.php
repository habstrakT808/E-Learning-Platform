<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Assignment;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionOption;
use Illuminate\Support\Str;

// Course ID (Complete Laravel Development Course)
$courseId = 1;
$sectionId = 2; // Section 2: Core Principles

// Create Assignment
echo "Creating assignment...\n";
$assignment = Assignment::create([
    'course_id' => $courseId,
    'title' => 'Build a RESTful API with Laravel',
    'description' => 'Create a simple RESTful API for a blog with posts and comments. Your API should support CRUD operations for both resources and implement proper validation, authentication and error handling. Include documentation using Postman or Swagger.',
    'slug' => Str::slug('Build a RESTful API with Laravel'),
    'deadline' => now()->addDays(7),
    'max_score' => 100,
    'max_attempts' => 3,
    'is_active' => true,
    'allow_late_submission' => true,
    'allowed_file_types' => ['zip', 'rar', 'pdf', 'doc', 'docx'],
    'max_file_size' => 10,
]);

echo "Assignment created with ID: " . $assignment->id . "\n";

// Create Quiz
echo "Creating quiz...\n";
$quiz = Quiz::create([
    'course_id' => $courseId,
    'section_id' => $sectionId,
    'title' => 'Laravel Fundamentals Quiz',
    'description' => 'Test your knowledge of Laravel core concepts including routing, controllers, models, migrations, and Eloquent ORM.',
    'time_limit' => 30, // 30 minutes
    'passing_score' => 70,
    'max_attempts' => 2,
    'show_correct_answers' => true,
    'randomize_questions' => false,
    'is_published' => true,
]);

echo "Quiz created with ID: " . $quiz->id . "\n";

// Add Questions to Quiz
echo "Adding questions to quiz...\n";

// Question 1
$question1 = QuizQuestion::create([
    'quiz_id' => $quiz->id,
    'question' => 'Which artisan command is used to create a new controller?',
    'type' => 'multiple_choice',
    'explanation' => 'The make:controller command is used to generate a new controller class in the app/Http/Controllers directory.',
    'points' => 10,
    'order' => 1,
]);

// Add options for Question 1
QuizQuestionOption::create([
    'quiz_question_id' => $question1->id,
    'option_text' => 'php artisan make:controller',
    'is_correct' => true,
    'order' => 1,
]);

QuizQuestionOption::create([
    'quiz_question_id' => $question1->id,
    'option_text' => 'php artisan create:controller',
    'is_correct' => false,
    'order' => 2,
]);

QuizQuestionOption::create([
    'quiz_question_id' => $question1->id,
    'option_text' => 'php artisan controller:make',
    'is_correct' => false,
    'order' => 3,
]);

QuizQuestionOption::create([
    'quiz_question_id' => $question1->id,
    'option_text' => 'php artisan new:controller',
    'is_correct' => false,
    'order' => 4,
]);

// Question 2
$question2 = QuizQuestion::create([
    'quiz_id' => $quiz->id,
    'question' => 'Which of the following is NOT a valid relationship method in Eloquent?',
    'type' => 'multiple_choice',
    'explanation' => 'Eloquent provides hasOne, hasMany, belongsTo, belongsToMany, hasManyThrough, and morphTo relationship methods, but not "connectsTo".',
    'points' => 10,
    'order' => 2,
]);

// Add options for Question 2
QuizQuestionOption::create([
    'quiz_question_id' => $question2->id,
    'option_text' => 'hasMany',
    'is_correct' => false,
    'order' => 1,
]);

QuizQuestionOption::create([
    'quiz_question_id' => $question2->id,
    'option_text' => 'belongsTo',
    'is_correct' => false,
    'order' => 2,
]);

QuizQuestionOption::create([
    'quiz_question_id' => $question2->id,
    'option_text' => 'connectsTo',
    'is_correct' => true,
    'order' => 3,
]);

QuizQuestionOption::create([
    'quiz_question_id' => $question2->id,
    'option_text' => 'morphTo',
    'is_correct' => false,
    'order' => 4,
]);

// Question 3
$question3 = QuizQuestion::create([
    'quiz_id' => $quiz->id,
    'question' => 'In Laravel, which middleware group is applied to web routes by default?',
    'type' => 'multiple_choice',
    'explanation' => 'Routes defined in the routes/web.php file automatically have the "web" middleware group applied.',
    'points' => 10,
    'order' => 3,
]);

// Add options for Question 3
QuizQuestionOption::create([
    'quiz_question_id' => $question3->id,
    'option_text' => 'api',
    'is_correct' => false,
    'order' => 1,
]);

QuizQuestionOption::create([
    'quiz_question_id' => $question3->id,
    'option_text' => 'web',
    'is_correct' => true,
    'order' => 2,
]);

QuizQuestionOption::create([
    'quiz_question_id' => $question3->id,
    'option_text' => 'auth',
    'is_correct' => false,
    'order' => 3,
]);

QuizQuestionOption::create([
    'quiz_question_id' => $question3->id,
    'option_text' => 'default',
    'is_correct' => false,
    'order' => 4,
]);

// Question 4
$question4 = QuizQuestion::create([
    'quiz_id' => $quiz->id,
    'question' => 'What is the purpose of Laravel\'s "tinker" command?',
    'type' => 'multiple_choice',
    'explanation' => 'Tinker is a REPL (Read-Eval-Print Loop) that allows you to interact with your Laravel application from the command line.',
    'points' => 10,
    'order' => 4,
]);

// Add options for Question 4
QuizQuestionOption::create([
    'quiz_question_id' => $question4->id,
    'option_text' => 'To test email sending',
    'is_correct' => false,
    'order' => 1,
]);

QuizQuestionOption::create([
    'quiz_question_id' => $question4->id,
    'option_text' => 'To optimize application performance',
    'is_correct' => false,
    'order' => 2,
]);

QuizQuestionOption::create([
    'quiz_question_id' => $question4->id,
    'option_text' => 'To interact with your application in a REPL environment',
    'is_correct' => true,
    'order' => 3,
]);

QuizQuestionOption::create([
    'quiz_question_id' => $question4->id,
    'option_text' => 'To fix code formatting issues',
    'is_correct' => false,
    'order' => 4,
]);

// Question 5
$question5 = QuizQuestion::create([
    'quiz_id' => $quiz->id,
    'question' => 'Laravel follows which architectural pattern?',
    'type' => 'multiple_choice',
    'explanation' => 'Laravel follows the Model-View-Controller (MVC) architectural pattern, which separates application logic, UI, and data management.',
    'points' => 10,
    'order' => 5,
]);

// Add options for Question 5
QuizQuestionOption::create([
    'quiz_question_id' => $question5->id,
    'option_text' => 'MVP (Model-View-Presenter)',
    'is_correct' => false,
    'order' => 1,
]);

QuizQuestionOption::create([
    'quiz_question_id' => $question5->id,
    'option_text' => 'MVC (Model-View-Controller)',
    'is_correct' => true,
    'order' => 2,
]);

QuizQuestionOption::create([
    'quiz_question_id' => $question5->id,
    'option_text' => 'MVVM (Model-View-ViewModel)',
    'is_correct' => false,
    'order' => 3,
]);

QuizQuestionOption::create([
    'quiz_question_id' => $question5->id,
    'option_text' => 'SOA (Service-Oriented Architecture)',
    'is_correct' => false,
    'order' => 4,
]);

echo "Quiz questions and options created successfully.\n";
echo "Done!\n"; 