<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Log;

class UpdateQuizAttemptsGradedAtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Updating graded_at for existing quiz attempts...');
        
        $attempts = QuizAttempt::whereNotNull('score')
                               ->whereNull('graded_at')
                               ->get();
        
        $count = 0;
        
        foreach ($attempts as $attempt) {
            try {
                // Set graded_at sama dengan submitted_at atau waktu saat ini jika submitted_at null
                $gradedAt = $attempt->submitted_at ?? now();
                
                $attempt->update([
                    'graded_at' => $gradedAt
                ]);
                
                $count++;
            } catch (\Exception $e) {
                Log::error("Error updating graded_at for attempt ID {$attempt->id}: {$e->getMessage()}");
            }
        }
        
        $this->command->info("Updated {$count} quiz attempts with graded_at timestamp.");
    }
}
