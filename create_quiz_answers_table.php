<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Checking if quiz_answers table exists...\n";
    
    $tableExists = DB::select("SHOW TABLES LIKE 'quiz_answers'");
    
    if (empty($tableExists)) {
        echo "Creating quiz_answers table...\n";
        
        DB::statement("
            CREATE TABLE `quiz_answers` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                `attempt_id` BIGINT UNSIGNED NOT NULL,
                `question_id` BIGINT UNSIGNED NOT NULL,
                `selected_option_id` BIGINT UNSIGNED NULL,
                `answer_text` TEXT NULL,
                `is_correct` BOOLEAN NULL,
                `points_earned` INT NULL,
                `feedback` TEXT NULL,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL,
                `deleted_at` TIMESTAMP NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`attempt_id`) REFERENCES `quiz_attempts` (`id`) ON DELETE CASCADE,
                FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE,
                FOREIGN KEY (`selected_option_id`) REFERENCES `quiz_question_options` (`id`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
        
        echo "quiz_answers table created successfully.\n";
        
        // Create migration file
        echo "\nCreating migration file...\n";
        
        $timestamp = date('Y_m_d_His');
        $migrationPath = database_path("migrations/{$timestamp}_create_quiz_answers_table.php");
        
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
        if (!Schema::hasTable('quiz_answers')) {
            Schema::create('quiz_answers', function (Blueprint \$table) {
                \$table->id();
                \$table->foreignId('attempt_id')->constrained('quiz_attempts')->onDelete('cascade');
                \$table->foreignId('question_id')->constrained('quiz_questions')->onDelete('cascade');
                \$table->foreignId('selected_option_id')->nullable()->constrained('quiz_question_options')->onDelete('set null');
                \$table->text('answer_text')->nullable();
                \$table->boolean('is_correct')->nullable();
                \$table->integer('points_earned')->nullable();
                \$table->text('feedback')->nullable();
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
        Schema::dropIfExists('quiz_answers');
    }
};
EOT;

        file_put_contents($migrationPath, $migrationContent);
        
        echo "Created migration file at: {$migrationPath}\n";
    } else {
        echo "quiz_answers table already exists.\n";
        
        // Check for missing columns
        $columns = DB::select("SHOW COLUMNS FROM quiz_answers");
        $columnNames = array_map(function($col) { return $col->Field; }, $columns);
        
        echo "\nCurrent columns in quiz_answers table:\n";
        foreach ($columnNames as $column) {
            echo "- {$column}\n";
        }
        
        // Check if deleted_at column exists for soft deletes
        if (!in_array('deleted_at', $columnNames)) {
            echo "\nAdding deleted_at column for soft deletes...\n";
            
            DB::statement("
                ALTER TABLE `quiz_answers`
                ADD COLUMN `deleted_at` TIMESTAMP NULL
            ");
            
            echo "Added deleted_at column successfully.\n";
        }
    }
    
    echo "\nQuiz answers table setup is complete.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} 