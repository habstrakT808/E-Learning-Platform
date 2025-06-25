<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddCompletedAtToLessonProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:completed-at-to-lesson-progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add completed_at column to lesson_progress table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Adding completed_at column to lesson_progress table...');

        try {
            // Add completed_at column
            DB::statement("ALTER TABLE `lesson_progress` 
                ADD COLUMN `completed_at` TIMESTAMP NULL AFTER `is_completed`");
            
            $this->info('Successfully added completed_at column to lesson_progress table.');
            
            // Update existing records to set completed_at for already completed lessons
            $this->info('Updating existing completed lessons...');
            
            DB::statement("
                UPDATE lesson_progress 
                SET completed_at = updated_at 
                WHERE is_completed = 1 AND completed_at IS NULL
            ");
            
            $this->info('Successfully updated existing lesson_progress records.');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Error updating lesson_progress table: ' . $e->getMessage());
            return 1;
        }
    }
} 