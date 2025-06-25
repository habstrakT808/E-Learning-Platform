<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\QuizAttempt;
use App\Models\Quiz;
use Illuminate\Support\Facades\Log;

class UpdateQuizAttemptsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Updating existing quiz attempts...');
        
        $attempts = QuizAttempt::all();
        $count = 0;
        
        foreach ($attempts as $attempt) {
            try {
                $quiz = Quiz::find($attempt->quiz_id);
                
                if ($quiz) {
                    $isPassed = $attempt->score >= $quiz->passing_score;
                    
                    $attempt->update([
                        'is_passed' => $isPassed
                    ]);
                    
                    $count++;
                } else {
                    Log::warning("Quiz not found for attempt ID {$attempt->id}");
                }
            } catch (\Exception $e) {
                Log::error("Error updating attempt ID {$attempt->id}: {$e->getMessage()}");
            }
        }
        
        $this->command->info("Updated {$count} quiz attempts successfully.");
    }
} 