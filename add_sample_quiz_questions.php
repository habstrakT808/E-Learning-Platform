<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Check if the quiz exists
    $quiz = DB::table('quizzes')->where('id', 1)->first();
    
    if (!$quiz) {
        echo "Quiz with ID 1 not found. Please check your database.\n";
        exit;
    }
    
    echo "Adding sample questions to quiz: {$quiz->title}\n";
    
    // Sample multiple-choice questions
    $questions = [
        [
            'quiz_id' => 1,
            'question' => 'What does Laravel use for template rendering?',
            'type' => 'multiple_choice',
            'points' => 5,
            'options' => [
                ['text' => 'Blade', 'is_correct' => true],
                ['text' => 'Twig', 'is_correct' => false],
                ['text' => 'Smarty', 'is_correct' => false],
                ['text' => 'Mustache', 'is_correct' => false],
            ]
        ],
        [
            'quiz_id' => 1,
            'question' => 'Which command creates a new Laravel controller?',
            'type' => 'multiple_choice',
            'points' => 5,
            'options' => [
                ['text' => 'php artisan make:controller', 'is_correct' => true],
                ['text' => 'php artisan new:controller', 'is_correct' => false],
                ['text' => 'php artisan create:controller', 'is_correct' => false],
                ['text' => 'php artisan generate:controller', 'is_correct' => false],
            ]
        ],
        [
            'quiz_id' => 1,
            'question' => 'Which Laravel feature is used for database migrations?',
            'type' => 'multiple_choice',
            'points' => 5,
            'options' => [
                ['text' => 'Schema Builder', 'is_correct' => true],
                ['text' => 'Database Manager', 'is_correct' => false],
                ['text' => 'SQL Generator', 'is_correct' => false],
                ['text' => 'Table Constructor', 'is_correct' => false],
            ]
        ],
        [
            'quiz_id' => 1,
            'question' => 'Which of the following is a Laravel ORM?',
            'type' => 'multiple_choice',
            'points' => 5,
            'options' => [
                ['text' => 'Eloquent', 'is_correct' => true],
                ['text' => 'Doctrine', 'is_correct' => false],
                ['text' => 'Hibernate', 'is_correct' => false],
                ['text' => 'Entity Framework', 'is_correct' => false],
            ]
        ],
        [
            'quiz_id' => 1,
            'question' => 'Which directive is used to include a sub-view in Blade?',
            'type' => 'multiple_choice',
            'points' => 5,
            'options' => [
                ['text' => '@include', 'is_correct' => true],
                ['text' => '@section', 'is_correct' => false],
                ['text' => '@yield', 'is_correct' => false],
                ['text' => '@extends', 'is_correct' => false],
            ]
        ],
    ];
    
    // Check if questions table exists
    $questionsTableExists = DB::select("SHOW TABLES LIKE 'quiz_questions'");
    
    if (empty($questionsTableExists)) {
        echo "Error: quiz_questions table does not exist.\n";
        exit;
    }
    
    // Check if options table exists
    $optionsTableExists = DB::select("SHOW TABLES LIKE 'quiz_question_options'");
    
    if (empty($optionsTableExists)) {
        echo "Error: quiz_question_options table does not exist.\n";
        exit;
    }
    
    // Clear existing questions for this quiz to avoid duplicates
    $existingQuestions = DB::table('quiz_questions')->where('quiz_id', 1)->get();
    
    if (count($existingQuestions) > 0) {
        echo "Removing existing questions for this quiz...\n";
        
        foreach ($existingQuestions as $question) {
            // Delete associated options
            DB::table('quiz_question_options')->where('question_id', $question->id)->delete();
        }
        
        // Delete questions
        DB::table('quiz_questions')->where('quiz_id', 1)->delete();
        
        echo "Existing questions removed.\n";
    }
    
    // Add new questions and options
    foreach ($questions as $questionData) {
        // Insert question
        $questionId = DB::table('quiz_questions')->insertGetId([
            'quiz_id' => $questionData['quiz_id'],
            'question' => $questionData['question'],
            'type' => $questionData['type'],
            'points' => $questionData['points'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        echo "Added question: {$questionData['question']}\n";
        
        // Insert options
        foreach ($questionData['options'] as $option) {
            DB::table('quiz_question_options')->insert([
                'question_id' => $questionId,
                'option_text' => $option['text'],
                'is_correct' => $option['is_correct'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            echo "  - Option: {$option['text']} (" . ($option['is_correct'] ? "Correct" : "Incorrect") . ")\n";
        }
    }
    
    echo "\nSample questions added successfully!\n";
    echo "You can now take the quiz at: http://127.0.0.1:8000/courses/web-development-with-laravel/quizzes/1\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} 