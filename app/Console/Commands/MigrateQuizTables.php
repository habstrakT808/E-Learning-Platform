<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateQuizTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:quiz-tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations for quiz tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running quiz table migrations...');

        // Paths to quiz migration files
        $migrationFiles = [
            'database/migrations/2025_06_03_000000_create_quizzes_table.php',
            'database/migrations/2025_06_03_000001_create_quiz_questions_table.php',
            'database/migrations/2025_06_03_000002_create_quiz_options_table.php',
            'database/migrations/2025_06_03_000003_create_quiz_attempts_table.php',
            'database/migrations/2025_06_03_000004_create_quiz_answers_table.php'
        ];

        foreach ($migrationFiles as $file) {
            $this->info('Migrating: ' . basename($file));
            
            try {
                $exitCode = Artisan::call('migrate', [
                    '--path' => $file
                ]);
                
                if ($exitCode === 0) {
                    $this->info('Migration successful!');
                } else {
                    $this->error('Migration failed with exit code: ' . $exitCode);
                }
            } catch (\Exception $e) {
                $this->error('Error running migration: ' . $e->getMessage());
            }
        }

        $this->info('All quiz migrations completed!');
    }
} 