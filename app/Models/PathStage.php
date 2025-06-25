<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'learning_path_id',
        'title',
        'description',
        'order',
        'icon',
        'badge_image',
    ];

    /**
     * Get the learning path that owns the stage.
     */
    public function learningPath()
    {
        return $this->belongsTo(LearningPath::class, 'learning_path_id');
    }

    /**
     * Get the stage courses.
     */
    public function stageCourses()
    {
        return $this->hasMany(PathStageCourse::class)->orderBy('order');
    }

    /**
     * Get the courses in this stage.
     */
    public function courses()
    {
        return $this->hasManyThrough(
            Course::class,
            PathStageCourse::class,
            'path_stage_id',  // Foreign key on PathStageCourse table
            'id',             // Foreign key on Course table
            'id',             // Local key on PathStage table
            'course_id'       // Local key on PathStageCourse table
        );
    }

    /**
     * Get the badge image URL attribute.
     */
    public function getBadgeImageUrlAttribute()
    {
        return $this->badge_image 
            ? asset('storage/' . $this->badge_image) 
            : null;
    }

    /**
     * Get the progress for a specific user.
     */
    public function getProgressForUser($userId = null)
    {
        $userId = $userId ?: auth()->id();
        
        // Get all courses in this stage
        $stageCourses = $this->stageCourses()->with('course')->get();
        
        if ($stageCourses->isEmpty()) {
            return 0;
        }
        
        // Get the user's enrollments for these courses
        $courseIds = $stageCourses->pluck('course_id')->toArray();
        $enrollments = Enrollment::where('user_id', $userId)
            ->whereIn('course_id', $courseIds)
            ->get()
            ->keyBy('course_id');
            
        // Calculate the progress based on course enrollments
        $totalProgress = 0;
        $courseCount = $stageCourses->count();
        
        foreach ($stageCourses as $stageCourse) {
            $courseId = $stageCourse->course_id;
            if (isset($enrollments[$courseId])) {
                $totalProgress += $enrollments[$courseId]->progress;
            }
        }
        
        return $courseCount > 0 ? round($totalProgress / $courseCount) : 0;
    }
}
