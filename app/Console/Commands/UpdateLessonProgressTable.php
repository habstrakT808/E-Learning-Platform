<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UpdateLessonProgressTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:lesson-progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rename completed column to is_completed in lesson_progress table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating lesson_progress table...');

        try {
            // SQL to rename the column
            DB::statement("ALTER TABLE `lesson_progress` CHANGE COLUMN `completed` `is_completed` TINYINT(1) NOT NULL DEFAULT '0';");
            
            $this->info('Successfully renamed column completed to is_completed in lesson_progress table.');
            return 0;
        } catch (\Exception $e) {
            $this->error('Error updating lesson_progress table: ' . $e->getMessage());
            return 1;
        }
    }
} 