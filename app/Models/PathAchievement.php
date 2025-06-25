<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'learning_path_id',
        'title',
        'description',
        'badge_image',
        'requirement_type',
        'requirement_value',
    ];

    /**
     * Get the learning path that owns the achievement.
     */
    public function learningPath()
    {
        return $this->belongsTo(LearningPath::class, 'learning_path_id');
    }

    /**
     * Get the users who earned this achievement.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_path_achievements')
            ->withPivot('earned_at', 'metadata')
            ->withTimestamps();
    }

    /**
     * Get the badge image URL attribute.
     */
    public function getBadgeImageUrlAttribute()
    {
        return $this->badge_image 
            ? asset('storage/' . $this->badge_image) 
            : asset('images/default-badge.png');
    }

    /**
     * Check if a user has earned this achievement.
     */
    public function isEarnedByUser($userId = null)
    {
        $userId = $userId ?: auth()->id();
        
        return $this->users()->where('user_id', $userId)->exists();
    }

    /**
     * Check if a user is eligible for this achievement.
     */
    public function checkEligibility($userId = null)
    {
        $userId = $userId ?: auth()->id();
        
        // If already earned, return false
        if ($this->isEarnedByUser($userId)) {
            return false;
        }
        
        $path = $this->learningPath;
        $enrollment = $path->getEnrollmentForUser($userId);
        
        if (!$enrollment) {
            return false;
        }
        
        switch ($this->requirement_type) {
            case 'path_completion':
                return $enrollment->isCompleted();
                
            case 'stage_completion':
                $stageId = $this->requirement_value;
                $stage = PathStage::find($stageId);
                
                if (!$stage || $stage->learning_path_id !== $path->id) {
                    return false;
                }
                
                $progress = $stage->getProgressForUser($userId);
                return $progress >= 100;
                
            case 'course_completion':
                $courseId = $this->requirement_value;
                $enrollment = Enrollment::where('user_id', $userId)
                    ->where('course_id', $courseId)
                    ->first();
                    
                return $enrollment && ($enrollment->completed_at || $enrollment->progress >= 100);
                
            case 'progress_milestone':
                $requiredProgress = $this->requirement_value;
                return $enrollment->progress >= $requiredProgress;
                
            default:
                return false;
        }
    }

    /**
     * Award this achievement to a user if eligible.
     */
    public function awardIfEligible($userId = null)
    {
        $userId = $userId ?: auth()->id();
        
        if ($this->checkEligibility($userId)) {
            UserPathAchievement::create([
                'user_id' => $userId,
                'path_achievement_id' => $this->id,
                'earned_at' => now(),
            ]);
            
            return true;
        }
        
        return false;
    }
}
