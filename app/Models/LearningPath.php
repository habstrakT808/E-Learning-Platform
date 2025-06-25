<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class LearningPath extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'thumbnail',
        'banner_image',
        'estimated_hours',
        'difficulty_level',
        'prerequisites',
        'outcomes',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from title
        static::creating(function ($path) {
            if (!$path->slug) {
                $path->slug = Str::slug($path->title);
            }
        });
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the stages for the learning path.
     */
    public function stages()
    {
        return $this->hasMany(PathStage::class, 'learning_path_id')->orderBy('order');
    }

    /**
     * Get the courses in this learning path through stages.
     */
    public function courses()
    {
        return $this->hasManyThrough(
            PathStageCourse::class,
            PathStage::class,
            'learning_path_id', // Foreign key on PathStage table
            'path_stage_id',    // Foreign key on PathStageCourse table
            'id',               // Local key on LearningPath table
            'id'                // Local key on PathStage table
        );
    }

    /**
     * Get unique courses in this learning path.
     */
    public function uniqueCourses()
    {
        $stageCoursesIds = $this->stages()
            ->with('courses')
            ->get()
            ->pluck('courses')
            ->flatten()
            ->pluck('course_id')
            ->unique();
            
        return Course::whereIn('id', $stageCoursesIds)->get();
    }

    /**
     * Get the users enrolled in this learning path.
     */
    public function enrolledUsers()
    {
        return $this->belongsToMany(User::class, 'path_enrollments')
            ->withPivot(['status', 'progress', 'completed_at'])
            ->withTimestamps();
    }

    /**
     * Get the enrollments for this learning path.
     */
    public function enrollments()
    {
        return $this->hasMany(UserPathEnrollment::class, 'learning_path_id');
    }

    /**
     * Get the achievements for this learning path.
     */
    public function achievements()
    {
        return $this->hasMany(PathAchievement::class, 'learning_path_id');
    }

    /**
     * Get the thumbnail URL attribute.
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail 
            ? asset('storage/' . $this->thumbnail) 
            : asset('images/default-path.jpg');
    }

    /**
     * Get the banner image URL attribute.
     */
    public function getBannerImageUrlAttribute()
    {
        return $this->banner_image 
            ? asset('storage/' . $this->banner_image) 
            : asset('images/default-path-banner.jpg');
    }

    /**
     * Get the total courses count.
     */
    public function getTotalCoursesAttribute()
    {
        return $this->stages()
            ->withCount('courses')
            ->get()
            ->sum('courses_count');
    }

    /**
     * Get the unique courses count.
     */
    public function getUniqueCoursesCountAttribute()
    {
        return $this->stages()
            ->with('courses')
            ->get()
            ->pluck('courses')
            ->flatten()
            ->pluck('course_id')
            ->unique()
            ->count();
    }

    /**
     * Check if a user is enrolled in this learning path.
     */
    public function isEnrolledByUser($userId = null)
    {
        $userId = $userId ?: auth()->id();
        
        return $this->enrolledUsers()->where('user_id', $userId)->exists();
    }

    /**
     * Get the enrollment for a user.
     */
    public function getEnrollmentForUser($userId = null)
    {
        $userId = $userId ?: auth()->id();
        
        return $this->enrolledUsers()
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * Scope published paths.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope paths by difficulty level.
     */
    public function scopeByDifficulty($query, $level)
    {
        if ($level === 'all-levels') {
            return $query;
        }
        
        return $query->where('difficulty_level', $level);
    }

    /**
     * Get the route key name.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
