<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixQuizTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quiz:fix-tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix quiz tables and relationships';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting quiz tables fix...');

        // 1. Check if tables exist
        $this->info('Checking tables...');
        $hasQuizOptions = Schema::hasTable('quiz_options');
        $hasQuizQuestionOptions = Schema::hasTable('quiz_question_options');
        
        $this->info("quiz_options exists: " . ($hasQuizOptions ? 'Yes' : 'No'));
        $this->info("quiz_question_options exists: " . ($hasQuizQuestionOptions ? 'Yes' : 'No'));

        // 2. Fix table names if needed
        if ($hasQuizOptions && !$hasQuizQuestionOptions) {
            $this->info('Renaming quiz_options to quiz_question_options...');
            Schema::rename('quiz_options', 'quiz_question_options');
            $this->info('Table renamed successfully.');
        } elseif (!$hasQuizOptions && !$hasQuizQuestionOptions) {
            $this->error('Neither quiz_options nor quiz_question_options table exists!');
            return 1;
        }

        // 3. Fix foreign key constraints
        $this->info('Checking foreign key constraints...');
        $foreignKeys = DB::select("
            SELECT 
                TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
            FROM
                INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE
                TABLE_NAME = 'quiz_answers' 
                AND COLUMN_NAME = 'selected_option_id'
                AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if (empty($foreignKeys)) {
            $this->info('No foreign key found for selected_option_id. Creating it...');
            
            // Check if column exists
            if (!Schema::hasColumn('quiz_answers', 'selected_option_id')) {
                $this->info('Column selected_option_id does not exist. Adding it...');
                Schema::table('quiz_answers', function ($table) {
                    $table->unsignedBigInteger('selected_option_id')->nullable()->after('question_id');
                });
            }
            
            // Add foreign key constraint
            Schema::table('quiz_answers', function ($table) {
                $table->foreign('selected_option_id')
                      ->references('id')
                      ->on('quiz_question_options')
                      ->onDelete('set null');
            });
            
            $this->info('Foreign key created successfully.');
        } else {
            $fk = $foreignKeys[0];
            if ($fk->REFERENCED_TABLE_NAME !== 'quiz_question_options') {
                $this->info('Foreign key references wrong table. Fixing it...');
                
                // Drop existing foreign key
                DB::statement("ALTER TABLE quiz_answers DROP FOREIGN KEY {$fk->CONSTRAINT_NAME}");
                
                // Add correct foreign key
                Schema::table('quiz_answers', function ($table) {
                    $table->foreign('selected_option_id')
                          ->references('id')
                          ->on('quiz_question_options')
                          ->onDelete('set null');
                });
                
                $this->info('Foreign key fixed successfully.');
            } else {
                $this->info('Foreign key is already correct.');
            }
        }

        // 4. Check model definition
        $this->info('Checking QuizQuestionOption model...');
        $modelPath = app_path('Models/QuizQuestionOption.php');
        
        if (file_exists($modelPath)) {
            $modelContent = file_get_contents($modelPath);
            
            if (strpos($modelContent, "protected \$table = 'quiz_question_options'") === false) {
                $this->info('Adding table name to model...');
                
                $modelContent = str_replace(
                    "use HasFactory, SoftDeletes;",
                    "use HasFactory, SoftDeletes;\n    \n    /**\n     * The table associated with the model.\n     *\n     * @var string\n     */\n    protected \$table = 'quiz_question_options';",
                    $modelContent
                );
                
                file_put_contents($modelPath, $modelContent);
                $this->info('Model updated successfully.');
            } else {
                $this->info('Model already has correct table name.');
            }
        } else {
            $this->error('QuizQuestionOption model not found!');
        }

        $this->info('Quiz tables fix completed successfully!');
        return 0;
    }
}
