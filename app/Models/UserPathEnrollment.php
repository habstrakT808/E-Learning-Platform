<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPathEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'learning_path_id',
        'progress',
        'started_at',
        'completed_at',
        'last_activity_at',
    ];

    protected $casts = [
        'progress' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    /**
     * Get the user that owns the enrollment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the learning path that owns the enrollment.
     */
    public function learningPath()
    {
        return $this->belongsTo(LearningPath::class, 'learning_path_id');
    }

    /**
     * Check if the path is completed.
     */
    public function isCompleted()
    {
        return $this->completed_at !== null || $this->progress >= 100;
    }

    /**
     * Check if the path is in progress.
     */
    public function isInProgress()
    {
        return $this->started_at !== null && !$this->isCompleted();
    }

    /**
     * Calculate the expected completion date based on current progress.
     */
    public function getExpectedCompletionDateAttribute()
    {
        if ($this->isCompleted() || !$this->started_at || $this->progress <= 0) {
            return null;
        }
        
        $daysElapsed = $this->started_at->diffInDays(now());
        $progressPerDay = $daysElapsed > 0 ? $this->progress / $daysElapsed : 0;
        
        if ($progressPerDay <= 0) {
            return null;
        }
        
        $remainingProgress = 100 - $this->progress;
        $daysRemaining = $progressPerDay > 0 ? ceil($remainingProgress / $progressPerDay) : 0;
        
        return now()->addDays($daysRemaining);
    }

    /**
     * Update user progress based on course completions.
     */
    public function updateProgress()
    {
        $path = $this->learningPath;
        
        // Get all required courses in this path
        $stagesWithCourses = $path->stages()->with([
            'stageCourses' => function($query) {
                $query->where('is_required', true);
            }
        ])->get();
        
        // Get course IDs that are required
        $requiredCourseIds = [];
        foreach ($stagesWithCourses as $stage) {
            foreach ($stage->stageCourses as $stageCourse) {
                $requiredCourseIds[] = $stageCourse->course_id;
            }
        }
        
        // Count total required courses
        $totalRequiredCourses = count($requiredCourseIds);
        
        if ($totalRequiredCourses === 0) {
            return;
        }
        
        // Get user's enrollments for these courses
        $userEnrollments = Enrollment::where('user_id', $this->user_id)
            ->whereIn('course_id', $requiredCourseIds)
            ->get();
            
        // Count completed courses
        $completedCourses = $userEnrollments->filter(function($enrollment) {
            return $enrollment->completed_at !== null || $enrollment->progress >= 100;
        })->count();
        
        // Calculate progress percentage
        $progressPercentage = $totalRequiredCourses > 0
            ? min(100, round(($completedCourses / $totalRequiredCourses) * 100))
            : 0;
        
        // Update progress
        $this->progress = $progressPercentage;
        $this->last_activity_at = now();
        
        // Mark as completed if 100%
        if ($progressPercentage >= 100 && !$this->completed_at) {
            $this->completed_at = now();
        }
        
        $this->save();
        
        return $progressPercentage;
    }
}
