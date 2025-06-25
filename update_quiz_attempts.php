<?php
// Script untuk memperbarui quiz_attempts dengan nilai is_passed yang benar
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Memperbarui quiz_attempts...\n";

// Ambil semua quiz
$quizzes = DB::table('quizzes')->get();

// Buat mapping quiz_id => passing_score
$passingScores = [];
foreach ($quizzes as $quiz) {
    $passingScores[$quiz->id] = $quiz->passing_score;
}

// Ambil semua attempts
$attempts = DB::table('quiz_attempts')->get();
$count = 0;

foreach ($attempts as $attempt) {
    if (isset($passingScores[$attempt->quiz_id])) {
        $isPassed = $attempt->score >= $passingScores[$attempt->quiz_id];
        
        try {
            DB::table('quiz_attempts')
                ->where('id', $attempt->id)
                ->update(['is_passed' => $isPassed ? 1 : 0]);
            $count++;
        } catch (Exception $e) {
            echo "Error updating attempt ID {$attempt->id}: {$e->getMessage()}\n";
        }
    } else {
        echo "Warning: Quiz not found for attempt ID {$attempt->id}\n";
    }
}

echo "Berhasil memperbarui $count quiz attempts.\n";
echo "Selesai!\n"; 