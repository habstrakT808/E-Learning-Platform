<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'section_id',
        'title',
        'description',
        'time_limit',
        'passing_score',
        'max_attempts',
        'show_correct_answers',
        'randomize_questions',
        'is_published',
    ];

    protected $casts = [
        'time_limit' => 'integer',
        'passing_score' => 'integer',
        'max_attempts' => 'integer',
        'show_correct_answers' => 'boolean',
        'randomize_questions' => 'boolean',
        'is_published' => 'boolean',
    ];

    /**
     * Get the course that owns the quiz.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the section that owns the quiz.
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the questions for the quiz.
     */
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    /**
     * Get the attempts for the quiz.
     */
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Get total points possible for this quiz.
     */
    public function getTotalPointsAttribute()
    {
        return $this->questions->sum('points');
    }

    /**
     * Get the formatted time limit.
     */
    public function getFormattedTimeLimitAttribute()
    {
        if (!$this->time_limit) {
            return '00:00:00';
        }
        
        $hours = floor($this->time_limit / 60);
        $minutes = $this->time_limit % 60;
        $seconds = 0;
        
        // Format waktu dalam format HH:MM:SS
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    /**
     * Get passing_score alias untuk pass_percentage.
     */
    public function getPassingScoreAttribute()
    {
        return $this->pass_percentage;
    }

    /**
     * Check if a user can attempt this quiz.
     */
    public function canBeAttemptedByUser($userId)
    {
        if (!$this->is_published) {
            return false;
        }

        // Check if user is enrolled in the course
        if (!$this->course->isEnrolledByUser($userId)) {
            return false;
        }

        // Check max attempts
        if ($this->max_attempts > 0) {
            $attemptsCount = $this->attempts()->where('user_id', $userId)->count();
            if ($attemptsCount >= $this->max_attempts) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the latest attempt for a user.
     */
    public function getLatestAttemptForUser($userId)
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->latest()
            ->first();
    }

    /**
     * Get the best attempt for a user.
     */
    public function getBestAttemptForUser($userId)
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->whereNotNull('score')
            ->orderBy('score', 'desc')
            ->first();
    }
} 