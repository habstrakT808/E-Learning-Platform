<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Checking quiz_question_options table structure...\n";
    
    // Check if the table exists
    $tableExists = DB::select("SHOW TABLES LIKE 'quiz_question_options'");
    
    if (empty($tableExists)) {
        echo "The quiz_question_options table doesn't exist.\n";
        exit;
    }
    
    // Get current columns
    $columns = DB::select("SHOW COLUMNS FROM quiz_question_options");
    $columnNames = array_map(function($col) { return $col->Field; }, $columns);
    
    echo "Current columns in quiz_question_options table:\n";
    foreach ($columnNames as $column) {
        echo "- {$column}\n";
    }
    
    // Check if order column exists
    if (!in_array('order', $columnNames)) {
        echo "\nAdding order column to quiz_question_options table...\n";
        
        DB::statement("
            ALTER TABLE `quiz_question_options`
            ADD COLUMN `order` INT NOT NULL DEFAULT 0
        ");
        
        echo "Added order column successfully.\n";
        
        // Set default order for existing options (based on id)
        echo "\nUpdating order values for existing options...\n";
        
        $questions = DB::select("SELECT DISTINCT question_id FROM quiz_question_options");
        
        foreach ($questions as $question) {
            $options = DB::select("
                SELECT id FROM quiz_question_options 
                WHERE question_id = ? 
                ORDER BY id
            ", [$question->question_id]);
            
            foreach ($options as $index => $option) {
                DB::update("
                    UPDATE quiz_question_options 
                    SET `order` = ? 
                    WHERE id = ?
                ", [$index + 1, $option->id]);
            }
        }
        
        echo "Updated order values successfully.\n";
    } else {
        echo "\norder column already exists.\n";
    }
    
    // Create migration file
    echo "\nCreating migration file...\n";
    
    $timestamp = date('Y_m_d_His');
    $migrationPath = database_path("migrations/{$timestamp}_add_order_to_quiz_question_options_table.php");
    
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
        Schema::table('quiz_question_options', function (Blueprint \$table) {
            if (!Schema::hasColumn('quiz_question_options', 'order')) {
                \$table->integer('order')->default(0);
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
        Schema::table('quiz_question_options', function (Blueprint \$table) {
            if (Schema::hasColumn('quiz_question_options', 'order')) {
                \$table->dropColumn('order');
            }
        });
    }
};
EOT;

    file_put_contents($migrationPath, $migrationContent);
    
    echo "Created migration file at: {$migrationPath}\n";
    
    // Update QuizQuestionOption model
    $modelPath = app_path('Models/QuizQuestionOption.php');
    
    if (file_exists($modelPath)) {
        echo "\nUpdating QuizQuestionOption model...\n";
        
        $modelContent = file_get_contents($modelPath);
        
        // Check if 'order' is already in fillable
        if (strpos($modelContent, "'order'") === false) {
            // Add 'order' to fillable array
            $modelContent = preg_replace(
                "/(protected \\\$fillable = \[.*?)(])/s", 
                "$1, 'order'$2", 
                $modelContent
            );
            
            file_put_contents($modelPath, $modelContent);
            echo "Updated QuizQuestionOption model with 'order' attribute.\n";
        } else {
            echo "QuizQuestionOption model already has 'order' attribute.\n";
        }
    }
    
    echo "\nThe quiz_question_options table has been updated.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} 