<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddEnrollmentIdToLessonProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:enrollment-id-to-lesson-progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add enrollment_id column to lesson_progress table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Adding enrollment_id column to lesson_progress table...');

        try {
            // Add enrollment_id column
            DB::statement("ALTER TABLE `lesson_progress` 
                ADD COLUMN `enrollment_id` BIGINT UNSIGNED NULL AFTER `lesson_id`");
            
            // Add foreign key constraint
            DB::statement("ALTER TABLE `lesson_progress` 
                ADD CONSTRAINT `lesson_progress_enrollment_id_foreign` 
                FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`id`) 
                ON DELETE CASCADE");
            
            $this->info('Successfully added enrollment_id column to lesson_progress table.');
            
            // Update existing records to set enrollment_id based on user_id and lesson courses
            $this->info('Updating existing records with enrollment data...');
            
            DB::statement("
                UPDATE lesson_progress lp
                JOIN lessons l ON lp.lesson_id = l.id
                JOIN sections s ON l.section_id = s.id
                JOIN enrollments e ON lp.user_id = e.user_id AND s.course_id = e.course_id
                SET lp.enrollment_id = e.id
                WHERE lp.enrollment_id IS NULL
            ");
            
            $this->info('Successfully updated existing lesson_progress records with enrollment IDs.');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Error updating lesson_progress table: ' . $e->getMessage());
            return 1;
        }
    }
} 