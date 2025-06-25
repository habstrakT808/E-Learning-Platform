<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Creating quiz tables if they don't exist...\n";
    
    // Create quiz_questions table
    if (empty(DB::select("SHOW TABLES LIKE 'quiz_questions'"))) {
        echo "Creating quiz_questions table...\n";
        
        DB::statement("
            CREATE TABLE `quiz_questions` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                `quiz_id` BIGINT UNSIGNED NOT NULL,
                `question` TEXT NOT NULL,
                `question_type` ENUM('multiple_choice', 'true_false', 'short_answer') NOT NULL DEFAULT 'multiple_choice',
                `points` INT NOT NULL DEFAULT 1,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL,
                `deleted_at` TIMESTAMP NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
        
        echo "quiz_questions table created successfully.\n";
    } else {
        echo "quiz_questions table already exists.\n";
    }
    
    // Create quiz_question_options table
    if (empty(DB::select("SHOW TABLES LIKE 'quiz_question_options'"))) {
        echo "Creating quiz_question_options table...\n";
        
        DB::statement("
            CREATE TABLE `quiz_question_options` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                `question_id` BIGINT UNSIGNED NOT NULL,
                `option_text` TEXT NOT NULL,
                `is_correct` BOOLEAN NOT NULL DEFAULT FALSE,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL,
                `deleted_at` TIMESTAMP NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
        
        echo "quiz_question_options table created successfully.\n";
    } else {
        echo "quiz_question_options table already exists.\n";
    }
    
    // Create migration files
    echo "\nCreating migration files to track these changes...\n";
    
    // Migration for quiz_questions
    $questionsTimestamp = date('Y_m_d_His');
    $questionsMigrationPath = database_path("migrations/{$questionsTimestamp}_create_quiz_questions_table.php");
    
    $questionsMigrationContent = <<<EOT
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('quiz_questions')) {
            Schema::create('quiz_questions', function (Blueprint \$table) {
                \$table->id();
                \$table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
                \$table->text('question');
                \$table->enum('question_type', ['multiple_choice', 'true_false', 'short_answer'])->default('multiple_choice');
                \$table->integer('points')->default(1);
                \$table->timestamps();
                \$table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_questions');
    }
};
EOT;

    file_put_contents($questionsMigrationPath, $questionsMigrationContent);
    
    // Migration for quiz_question_options
    $optionsTimestamp = date('Y_m_d_His', time() + 1);
    $optionsMigrationPath = database_path("migrations/{$optionsTimestamp}_create_quiz_question_options_table.php");
    
    $optionsMigrationContent = <<<EOT
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('quiz_question_options')) {
            Schema::create('quiz_question_options', function (Blueprint \$table) {
                \$table->id();
                \$table->foreignId('question_id')->constrained('quiz_questions')->onDelete('cascade');
                \$table->text('option_text');
                \$table->boolean('is_correct')->default(false);
                \$table->timestamps();
                \$table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_question_options');
    }
};
EOT;

    file_put_contents($optionsMigrationPath, $optionsMigrationContent);
    
    echo "Created migration files:\n";
    echo "- {$questionsMigrationPath}\n";
    echo "- {$optionsMigrationPath}\n";
    
    // Create model files if they don't exist
    echo "\nCreating model files if they don't exist...\n";
    
    // QuizQuestion model
    $questionModelPath = app_path('Models/QuizQuestion.php');
    if (!file_exists($questionModelPath)) {
        echo "Creating QuizQuestion model...\n";
        
        $questionModelContent = <<<EOT
<?php

namespace App\\Models;

use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;
use Illuminate\\Database\\Eloquent\\Model;
use Illuminate\\Database\\Eloquent\\SoftDeletes;

class QuizQuestion extends Model
{
    use HasFactory, SoftDeletes;
    
    protected \$fillable = [
        'quiz_id',
        'question',
        'question_type',
        'points'
    ];
    
    public function quiz()
    {
        return \$this->belongsTo(Quiz::class);
    }
    
    public function options()
    {
        return \$this->hasMany(QuizQuestionOption::class, 'question_id');
    }
    
    public function correctOptions()
    {
        return \$this->hasMany(QuizQuestionOption::class, 'question_id')->where('is_correct', true);
    }
}
EOT;

        file_put_contents($questionModelPath, $questionModelContent);
        echo "QuizQuestion model created successfully.\n";
    } else {
        echo "QuizQuestion model already exists.\n";
    }
    
    // QuizQuestionOption model
    $optionModelPath = app_path('Models/QuizQuestionOption.php');
    if (!file_exists($optionModelPath)) {
        echo "Creating QuizQuestionOption model...\n";
        
        $optionModelContent = <<<EOT
<?php

namespace App\\Models;

use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;
use Illuminate\\Database\\Eloquent\\Model;
use Illuminate\\Database\\Eloquent\\SoftDeletes;

class QuizQuestionOption extends Model
{
    use HasFactory, SoftDeletes;
    
    protected \$fillable = [
        'question_id',
        'option_text',
        'is_correct'
    ];
    
    protected \$casts = [
        'is_correct' => 'boolean',
    ];
    
    public function question()
    {
        return \$this->belongsTo(QuizQuestion::class, 'question_id');
    }
}
EOT;

        file_put_contents($optionModelPath, $optionModelContent);
        echo "QuizQuestionOption model created successfully.\n";
    } else {
        echo "QuizQuestionOption model already exists.\n";
    }
    
    // Update Quiz model to add relationships
    $quizModelPath = app_path('Models/Quiz.php');
    if (file_exists($quizModelPath)) {
        echo "\nUpdating Quiz model to add relationships...\n";
        
        $quizModelContent = file_get_contents($quizModelPath);
        
        // Check if questions relationship exists
        if (strpos($quizModelContent, 'public function questions()') === false) {
            // Find the closing brace of the class
            $lastBracePos = strrpos($quizModelContent, '}');
            
            // Add relationships before the closing brace
            $relationshipsCode = <<<EOT

    /**
     * Get the questions for the quiz.
     */
    public function questions()
    {
        return \$this->hasMany(QuizQuestion::class);
    }
}
EOT;
            
            $quizModelContent = substr_replace($quizModelContent, $relationshipsCode, $lastBracePos, 1);
            file_put_contents($quizModelPath, $quizModelContent);
            echo "Updated Quiz model with questions relationship.\n";
        } else {
            echo "Quiz model already has questions relationship.\n";
        }
    }
    
    echo "\nQuiz tables and models have been set up successfully.\n";
    echo "Now you can run the add_sample_quiz_questions.php script to add questions.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} 