<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddWatchTimeToLessonProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:watch-time-to-lesson-progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add watch_time column to lesson_progress table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Adding watch_time column to lesson_progress table...');

        try {
            // Add watch_time column
            DB::statement("ALTER TABLE `lesson_progress` 
                ADD COLUMN `watch_time` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `is_completed`");
            
            $this->info('Successfully added watch_time column to lesson_progress table.');
            return 0;
        } catch (\Exception $e) {
            $this->error('Error updating lesson_progress table: ' . $e->getMessage());
            return 1;
        }
    }
} 