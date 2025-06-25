<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'is_passed',
        'started_at',
        'submitted_at',
        'graded_at',
        'attempt_number',
        'time_spent',
    ];

    protected $casts = [
        'is_passed' => 'boolean',
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
        'attempt_number' => 'integer',
        'time_spent' => 'integer',
    ];

    /**
     * Get the user that owns the attempt.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the quiz that owns the attempt.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the answers for the attempt.
     */
    public function answers()
    {
        return $this->hasMany(QuizAnswer::class, 'quiz_attempt_id');
    }

    /**
     * Get the formatted time spent.
     */
    public function getFormattedTimeSpentAttribute()
    {
        if (!$this->time_spent) {
            return '00:00:00';
        }

        $hours = floor($this->time_spent / 3600);
        $minutes = floor(($this->time_spent % 3600) / 60);
        $seconds = $this->time_spent % 60;

        // Format waktu sebagai HH:MM:SS
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    /**
     * Get the remaining time for this attempt in seconds.
     */
    public function getRemainingTimeAttribute()
    {
        if (!$this->quiz->time_limit || !$this->started_at) {
            return null;
        }

        $timeLimitSeconds = $this->quiz->time_limit * 60;
        $timeElapsed = now()->diffInSeconds($this->started_at);
        $remainingTime = $timeLimitSeconds - $timeElapsed;

        return (int)max(0, $remainingTime);
    }

    /**
     * Check if the attempt is in progress.
     */
    public function isInProgress()
    {
        return $this->started_at && !$this->submitted_at;
    }

    /**
     * Check if the attempt is completed (submitted).
     */
    public function isCompleted()
    {
        return $this->submitted_at !== null;
    }

    /**
     * Check if the attempt is graded.
     */
    public function isGraded()
    {
        return $this->graded_at !== null;
    }

    /**
     * Calculate the score for this attempt.
     */
    public function calculateScore()
    {
        // Pastikan kita mendapatkan total poin dengan benar
        $quiz = $this->quiz()->with('questions')->first();
        $totalPoints = $quiz->questions->sum('points');
        
        if ($totalPoints === 0) {
            // Default ke 0 jika tidak ada total poin yang valid
            $this->update([
                'score' => 0,
                'is_passed' => false,
                'graded_at' => now(),
            ]);
            return 0;
        }

        // Hitung poin yang diperoleh dari jawaban
        $earnedPoints = $this->answers->sum('points_earned') ?: 0;
        $score = round(($earnedPoints / $totalPoints) * 100);

        \Log::debug("Calculating score - Earned: {$earnedPoints}, Total: {$totalPoints}, Score: {$score}%");
        
        // Pastikan skor sama dengan 0 jika tidak ada jawaban yang benar
        if ($earnedPoints <= 0) {
            $score = 0;
        }
        
        // Passing score dari kuis
        $passingScore = $quiz->passing_score;
        \Log::debug("Quiz passing score: {$passingScore}%, User score: {$score}%");
        
        // Update attempt dengan hasil yang benar
        $isPassed = $score >= $passingScore;
        
        $this->update([
            'score' => $score,
            'is_passed' => $isPassed,
            'graded_at' => now(),
        ]);
        
        \Log::info("Quiz attempt {$this->id} graded - Score: {$score}%, Passed: " . ($isPassed ? 'Yes' : 'No'));

        return $score;
    }
} 