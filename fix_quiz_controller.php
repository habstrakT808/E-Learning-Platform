<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Updating QuizController to use the correct model names...\n";
    
    $controllerPath = app_path('Http/Controllers/QuizController.php');
    
    if (!file_exists($controllerPath)) {
        echo "Error: QuizController.php not found.\n";
        exit;
    }
    
    $content = file_get_contents($controllerPath);
    
    // Replace QuizOption with QuizQuestionOption
    $content = str_replace('use App\Models\QuizOption;', 'use App\Models\QuizQuestionOption;', $content);
    $content = str_replace('QuizOption::', 'QuizQuestionOption::', $content);
    
    // Update model name instances in the code
    $content = str_replace('$option = QuizOption::findOrFail', '$option = QuizQuestionOption::findOrFail', $content);
    
    // Update column references
    $content = str_replace("'option_id'", "'selected_option_id'", $content);
    $content = str_replace("'text_answer'", "'answer_text'", $content);
    
    file_put_contents($controllerPath, $content);
    
    echo "QuizController updated successfully.\n";
    
    // Find any other references in the codebase that might need updating
    echo "\nChecking for other files that may need updating...\n";
    
    // Fix any issues with column references in the take.blade.php file
    $takeBladePath = resource_path('views/quizzes/take.blade.php');
    
    if (file_exists($takeBladePath)) {
        echo "Checking and updating take.blade.php...\n";
        
        $bladeContent = file_get_contents($takeBladePath);
        
        // Make sure the view is using the correct attribute names for the quiz answers
        $bladeContent = str_replace('$answers[$question->id]->option_id', '$answers[$question->id]->selected_option_id', $bladeContent);
        $bladeContent = str_replace('$answers[$question->id]->text_answer', '$answers[$question->id]->answer_text', $bladeContent);
        
        file_put_contents($takeBladePath, $bladeContent);
        
        echo "take.blade.php updated successfully.\n";
    }
    
    // Fix any issues with column references in the review.blade.php file
    $reviewBladePath = resource_path('views/quizzes/review.blade.php');
    
    if (file_exists($reviewBladePath)) {
        echo "Checking and updating review.blade.php...\n";
        
        $bladeContent = file_get_contents($reviewBladePath);
        
        // Make sure the view is using the correct attribute names for the quiz answers
        $bladeContent = str_replace('$answers[$question->id]->option_id', '$answers[$question->id]->selected_option_id', $bladeContent);
        $bladeContent = str_replace('$answers[$question->id]->text_answer', '$answers[$question->id]->answer_text', $bladeContent);
        
        file_put_contents($reviewBladePath, $bladeContent);
        
        echo "review.blade.php updated successfully.\n";
    }
    
    echo "\nAll necessary updates completed.\n";
    echo "The quiz system should now be functioning properly.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} 