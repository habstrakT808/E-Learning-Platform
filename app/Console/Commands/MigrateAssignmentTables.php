<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateAssignmentTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:assignment-tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations for assignment and submission tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running assignment table migrations...');

        // Paths to assignment migration files
        $migrationFiles = [
            'database/migrations/2025_06_01_025846_create_assignments_table.php',
            'database/migrations/2025_06_01_025857_create_submissions_table.php'
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

        $this->info('All assignment migrations completed!');
    }
} 