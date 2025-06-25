<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Checking quiz_attempts table structure...\n";
    
    // Check if the table exists
    $tableExists = \DB::select("SHOW TABLES LIKE 'quiz_attempts'");
    
    if (empty($tableExists)) {
        echo "The quiz_attempts table doesn't exist. Please check your database setup.\n";
        exit;
    }
    
    // Check if attempt_number column exists
    $columns = \DB::select("SHOW COLUMNS FROM quiz_attempts");
    $hasAttemptNumber = false;
    
    echo "Current columns in quiz_attempts table:\n";
    foreach ($columns as $column) {
        echo "- {$column->Field}\n";
        if ($column->Field === 'attempt_number') {
            $hasAttemptNumber = true;
        }
    }
    
    if (!$hasAttemptNumber) {
        echo "\nAdding attempt_number column to quiz_attempts table...\n";
        \DB::statement('ALTER TABLE `quiz_attempts` ADD COLUMN `attempt_number` INT NOT NULL DEFAULT 1');
        echo "Added attempt_number column successfully.\n";
        
        // Populate attempt numbers for existing records
        echo "\nPopulating attempt numbers for existing records...\n";
        
        // Get distinct user and quiz combinations
        $attempts = \DB::select("
            SELECT user_id, quiz_id
            FROM quiz_attempts
            GROUP BY user_id, quiz_id
        ");
        
        $updatedCount = 0;
        
        foreach ($attempts as $attempt) {
            // For each user and quiz, get attempts ordered by created_at
            $userAttempts = \DB::select("
                SELECT id, created_at
                FROM quiz_attempts
                WHERE user_id = ? AND quiz_id = ?
                ORDER BY created_at ASC
            ", [$attempt->user_id, $attempt->quiz_id]);
            
            // Update attempt_number for each attempt
            foreach ($userAttempts as $index => $userAttempt) {
                $attemptNumber = $index + 1;
                \DB::update("
                    UPDATE quiz_attempts
                    SET attempt_number = ?
                    WHERE id = ?
                ", [$attemptNumber, $userAttempt->id]);
                $updatedCount++;
            }
        }
        
        echo "Updated attempt numbers for {$updatedCount} attempt records.\n";
    } else {
        echo "\nattempt_number column already exists in the quiz_attempts table.\n";
    }
    
    // Create migration file to track this change
    echo "\nCreating migration file...\n";
    
    $migrationName = 'add_attempt_number_to_quiz_attempts_table';
    $timestamp = date('Y_m_d_His');
    
    $migrationPath = database_path("migrations/{$timestamp}_{$migrationName}.php");
    
    $migrationContent = <<<EOT
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
        Schema::table('quiz_attempts', function (Blueprint \$table) {
            if (!Schema::hasColumn('quiz_attempts', 'attempt_number')) {
                \$table->integer('attempt_number')->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_attempts', function (Blueprint \$table) {
            if (Schema::hasColumn('quiz_attempts', 'attempt_number')) {
                \$table->dropColumn('attempt_number');
            }
        });
    }
};
EOT;

    file_put_contents($migrationPath, $migrationContent);
    
    echo "Migration file created at: {$migrationPath}\n";
    
    // Check QuizAttempt model
    $modelPath = app_path('Models/QuizAttempt.php');
    
    if (file_exists($modelPath)) {
        $modelContents = file_get_contents($modelPath);
        
        // Make sure attempt_number is in $fillable array
        if (strpos($modelContents, "'attempt_number'") === false) {
            echo "\nUpdating QuizAttempt model to include attempt_number in fillable array...\n";
            
            // Add attempt_number to fillable array
            $modelContents = preg_replace(
                "/(protected \\\$fillable = \[.*?)(])/s",
                "$1, 'attempt_number'$2",
                $modelContents
            );
            
            file_put_contents($modelPath, $modelContents);
            echo "Updated QuizAttempt model.\n";
        }
    }
    
    echo "\nQuiz attempts table structure has been updated.\n";
    echo "You can now start quizzes without errors.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 