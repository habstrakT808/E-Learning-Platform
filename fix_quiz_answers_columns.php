<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Checking quiz_answers table columns...\n";
    
    // Get current columns
    $columns = DB::select("SHOW COLUMNS FROM quiz_answers");
    $columnNames = array_map(function($col) { return $col->Field; }, $columns);
    
    echo "Current columns in quiz_answers table:\n";
    foreach ($columnNames as $column) {
        echo "- {$column}\n";
    }
    
    // Check if option_id column needs to be renamed to selected_option_id
    if (in_array('option_id', $columnNames) && !in_array('selected_option_id', $columnNames)) {
        echo "\nRenaming option_id to selected_option_id...\n";
        
        DB::statement("
            ALTER TABLE `quiz_answers`
            CHANGE COLUMN `option_id` `selected_option_id` BIGINT UNSIGNED NULL
        ");
        
        echo "Renamed option_id to selected_option_id successfully.\n";
    }
    
    // Check if text_answer column needs to be renamed to answer_text
    if (in_array('text_answer', $columnNames) && !in_array('answer_text', $columnNames)) {
        echo "\nRenaming text_answer to answer_text...\n";
        
        DB::statement("
            ALTER TABLE `quiz_answers`
            CHANGE COLUMN `text_answer` `answer_text` TEXT NULL
        ");
        
        echo "Renamed text_answer to answer_text successfully.\n";
    }
    
    // Check if feedback column exists
    if (!in_array('feedback', $columnNames)) {
        echo "\nAdding feedback column...\n";
        
        DB::statement("
            ALTER TABLE `quiz_answers`
            ADD COLUMN `feedback` TEXT NULL
        ");
        
        echo "Added feedback column successfully.\n";
    }
    
    // Check if updated_at column exists
    if (!in_array('updated_at', $columnNames)) {
        echo "\nAdding updated_at column...\n";
        
        DB::statement("
            ALTER TABLE `quiz_answers`
            ADD COLUMN `updated_at` TIMESTAMP NULL
        ");
        
        echo "Added updated_at column successfully.\n";
    }
    
    // Check if deleted_at column exists
    if (!in_array('deleted_at', $columnNames)) {
        echo "\nAdding deleted_at column...\n";
        
        DB::statement("
            ALTER TABLE `quiz_answers`
            ADD COLUMN `deleted_at` TIMESTAMP NULL
        ");
        
        echo "Added deleted_at column successfully.\n";
    }
    
    // Create migration file to track these changes
    echo "\nCreating migration file...\n";
    
    $timestamp = date('Y_m_d_His');
    $migrationPath = database_path("migrations/{$timestamp}_fix_quiz_answers_columns.php");
    
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
        Schema::table('quiz_answers', function (Blueprint \$table) {
            if (Schema::hasColumn('quiz_answers', 'option_id') && !Schema::hasColumn('quiz_answers', 'selected_option_id')) {
                \$table->renameColumn('option_id', 'selected_option_id');
            }
            
            if (Schema::hasColumn('quiz_answers', 'text_answer') && !Schema::hasColumn('quiz_answers', 'answer_text')) {
                \$table->renameColumn('text_answer', 'answer_text');
            }
            
            if (!Schema::hasColumn('quiz_answers', 'feedback')) {
                \$table->text('feedback')->nullable();
            }
            
            if (!Schema::hasColumn('quiz_answers', 'updated_at')) {
                \$table->timestamp('updated_at')->nullable();
            }
            
            if (!Schema::hasColumn('quiz_answers', 'deleted_at')) {
                \$table->softDeletes();
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
        Schema::table('quiz_answers', function (Blueprint \$table) {
            if (Schema::hasColumn('quiz_answers', 'selected_option_id') && !Schema::hasColumn('quiz_answers', 'option_id')) {
                \$table->renameColumn('selected_option_id', 'option_id');
            }
            
            if (Schema::hasColumn('quiz_answers', 'answer_text') && !Schema::hasColumn('quiz_answers', 'text_answer')) {
                \$table->renameColumn('answer_text', 'text_answer');
            }
            
            if (Schema::hasColumn('quiz_answers', 'feedback')) {
                \$table->dropColumn('feedback');
            }
            
            if (Schema::hasColumn('quiz_answers', 'deleted_at')) {
                \$table->dropSoftDeletes();
            }
        });
    }
};
EOT;

    file_put_contents($migrationPath, $migrationContent);
    
    echo "Created migration file at: {$migrationPath}\n";
    
    echo "\nQuiz answers table columns have been fixed.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} 