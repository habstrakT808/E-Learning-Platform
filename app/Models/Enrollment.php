<?php
// app/Models/Enrollment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $course_id
 * @property \Illuminate\Support\Carbon $enrolled_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $deadline
 * @property int $progress
 * @property numeric $amount_paid
 * @property string|null $payment_method
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Course $course
 * @property-read mixed $formatted_amount_paid
 * @property-read mixed $is_completed
 * @property-read mixed $progress_percentage
 * @property-read mixed $days_until_deadline
 * @property-read mixed $is_overdue
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LessonProgress> $lessonProgress
 * @property-read int|null $lesson_progress_count
 * @property-read \App\Models\User $student
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment whereAmountPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment whereEnrolledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment whereUserId($value)
 * @mixin \Eloquent
 */
class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'enrolled_at',
        'completed_at',
        'deadline',
        'progress',
        'amount_paid',
        'payment_method'
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'deadline' => 'date',
        'amount_paid' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lessonProgress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    // Accessors
    public function getIsCompletedAttribute()
    {
        return !is_null($this->completed_at);
    }

    public function getProgressPercentageAttribute()
    {
        return min(100, max(0, $this->progress));
    }

    public function getFormattedAmountPaidAttribute()
    {
        return 'Rp ' . number_format($this->amount_paid, 0, ',', '.');
    }
    
    public function getDaysUntilDeadlineAttribute()
    {
        if (!$this->deadline) {
            return null;
        }
        
        return now()->startOfDay()->diffInDays($this->deadline, false);
    }
    
    public function getIsOverdueAttribute()
    {
        if (!$this->deadline || $this->completed_at) {
            return false;
        }
        
        return now()->startOfDay()->isAfter($this->deadline);
    }
    
    public function getFormattedDeadlineAttribute()
    {
        if (!$this->deadline) {
            return null;
        }
        
        return $this->deadline->format('d M Y');
    }

    // Helper methods
    public function calculateProgress()
    {
        $totalLessons = $this->course->total_lessons;
        
        if ($totalLessons == 0) {
            return 0;
        }

        $completedLessons = $this->lessonProgress()->where('is_completed', true)->count();
        $progress = round(($completedLessons / $totalLessons) * 100);

        // Update progress
        $this->update(['progress' => $progress]);

        // Mark as completed if 100%
        if ($progress >= 100 && !$this->completed_at) {
            $this->update(['completed_at' => now()]);
        }

        return $progress;
    }

    public function getCompletedLessonsCount()
    {
        return $this->lessonProgress()->where('is_completed', true)->count();
    }

    public function getTotalWatchTime()
    {
        return $this->lessonProgress()->sum('watch_time');
    }

    public function getFormattedWatchTime()
    {
        $totalSeconds = $this->getTotalWatchTime();
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        
        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        
        return $minutes . 'm';
    }

    public function getLastAccessedLesson()
    {
        return $this->lessonProgress()
                    ->with('lesson')
                    ->latest('updated_at')
                    ->first()?->lesson;
    }

    public function getNextLessonToWatch()
    {
        // Get first incomplete lesson
        $courseLessons = $this->course->lessons()->orderBy('sections.order')->orderBy('lessons.order');
        
        foreach ($courseLessons->get() as $lesson) {
            if (!$lesson->isCompletedByUser($this->user_id)) {
                return $lesson;
            }
        }

        return null; // All lessons completed
    }
}