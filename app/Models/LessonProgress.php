<?php
// app/Models/LessonProgress.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $lesson_id
 * @property int $enrollment_id
 * @property bool $is_completed
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property int $watch_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Enrollment $enrollment
 * @property-read mixed $formatted_watch_time
 * @property-read mixed $watch_time_percentage
 * @property-read \App\Models\Lesson $lesson
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonProgress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonProgress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonProgress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonProgress whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonProgress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonProgress whereEnrollmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonProgress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonProgress whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonProgress whereLessonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonProgress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonProgress whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonProgress whereWatchTime($value)
 * @mixin \Eloquent
 */
class LessonProgress extends Model
{
    use HasFactory;

    protected $table = 'lesson_progress';

    protected $fillable = [
        'user_id',
        'lesson_id',
        'enrollment_id',
        'is_completed',
        'completed_at',
        'watch_time'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    // Accessors
    public function getWatchTimePercentageAttribute()
    {
        if ($this->lesson->duration == 0) return 0;
        
        return min(100, ($this->watch_time / ($this->lesson->duration * 60)) * 100);
    }

    public function getFormattedWatchTimeAttribute()
    {
        $hours = floor($this->watch_time / 3600);
        $minutes = floor(($this->watch_time % 3600) / 60);
        $seconds = $this->watch_time % 60;
        
        if ($hours > 0) {
            return sprintf('%dh %dm %ds', $hours, $minutes, $seconds);
        } elseif ($minutes > 0) {
            return sprintf('%dm %ds', $minutes, $seconds);
        } else {
            return sprintf('%ds', $seconds);
        }
    }

    // Helper methods
    public function markAsCompleted()
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now()
        ]);

        // Update enrollment progress
        $this->enrollment->calculateProgress();
    }

    public function updateWatchTime($seconds)
    {
        $this->increment('watch_time', $seconds);
        
        // Auto-complete if watched 90% of the lesson
        if (!$this->is_completed && $this->watch_time_percentage >= 90) {
            $this->markAsCompleted();
        }
    }
}