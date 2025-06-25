<?php
// app/Models/Lesson.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Bookmarkable;

/**
 * 
 *
 * @property int $id
 * @property int $section_id
 * @property string $title
 * @property string|null $content
 * @property string|null $video_url
 * @property string $video_platform
 * @property int $duration
 * @property int $order
 * @property bool $is_preview
 * @property array<array-key, mixed>|null $attachments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Course|null $course
 * @property-read mixed $duration_in_minutes
 * @property-read mixed $formatted_duration
 * @property-read mixed $video_embed_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LessonProgress> $progress
 * @property-read int|null $progress_count
 * @property-read \App\Models\Section $section
 * @property-read \App\Models\LessonProgress|null $userProgress
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lesson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lesson query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lesson whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lesson whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lesson whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lesson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lesson whereIsPreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lesson whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lesson whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lesson whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lesson whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lesson whereVideoPlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lesson whereVideoUrl($value)
 * @mixin \Eloquent
 */
class Lesson extends Model
{
    use HasFactory, Bookmarkable;

    protected $fillable = [
        'section_id',
        'title',
        'content',
        'video_url',
        'video_platform',
        'duration',
        'order',
        'is_preview',
        'attachments'
    ];

    protected $casts = [
        'is_preview' => 'boolean',
        'attachments' => 'array',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    // Relationships
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function course()
    {
        return $this->hasOneThrough(Course::class, Section::class, 'id', 'id', 'section_id', 'course_id');
    }

    public function progress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function userProgress()
    {
        return $this->hasOne(LessonProgress::class)->where('user_id', \Illuminate\Support\Facades\Auth::id());
    }
    
    public function notes()
    {
        return $this->hasMany(LessonNote::class);
    }
    
    public function userNote()
    {
        return $this->hasOne(LessonNote::class)->where('user_id', \Illuminate\Support\Facades\Auth::id());
    }

    // Accessors
    public function getDurationInMinutesAttribute()
    {
        return $this->duration;
    }

    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        
        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        
        return $minutes . 'm';
    }

    public function getVideoEmbedUrlAttribute()
    {
        if (!$this->video_url) return null;

        switch ($this->video_platform) {
            case 'youtube':
                // Convert YouTube URL to embed URL
                preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $this->video_url, $matches);
                return isset($matches[1]) ? "https://www.youtube.com/embed/{$matches[1]}" : null;
                
            case 'vimeo':
                // Convert Vimeo URL to embed URL
                preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $matches);
                return isset($matches[1]) ? "https://player.vimeo.com/video/{$matches[1]}" : null;
                
            case 'upload':
                return asset('storage/' . $this->video_url);
                
            default:
                return $this->video_url;
        }
    }

    // Helper methods
    public function isCompletedByUser($userId)
    {
        return $this->progress()->where('user_id', $userId)->where('is_completed', true)->exists();
    }

    public function getUserProgress($userId)
    {
        return $this->progress()->where('user_id', $userId)->first();
    }

    public function markAsCompleted($userId, $enrollmentId)
    {
        return $this->progress()->updateOrCreate(
            ['user_id' => $userId, 'lesson_id' => $this->id],
            [
                'enrollment_id' => $enrollmentId,
                'is_completed' => true,
                'completed_at' => now()
            ]
        );
    }

    // Get next lesson
    public function getNextLesson()
    {
        // Try to get next lesson in same section
        $nextInSection = $this->section->lessons()
                              ->where('order', '>', $this->order)
                              ->orderBy('order')
                              ->first();
        
        if ($nextInSection) {
            return $nextInSection;
        }

        // Get first lesson from next section
        $nextSection = $this->section->getNextSection();
        if ($nextSection) {
            return $nextSection->lessons()->orderBy('order')->first();
        }

        return null;
    }

    // Get previous lesson
    public function getPreviousLesson()
    {
        // Try to get previous lesson in same section
        $prevInSection = $this->section->lessons()
                              ->where('order', '<', $this->order)
                              ->orderBy('order', 'desc')
                              ->first();
        
        if ($prevInSection) {
            return $prevInSection;
        }

        // Get last lesson from previous section
        $prevSection = $this->section->getPreviousSection();
        if ($prevSection) {
            return $prevSection->lessons()->orderBy('order', 'desc')->first();
        }

        return null;
    }

    /**
     * Check if a user can watch this lesson
     */
    public function canBeWatched($userId)
    {
        // If lesson is preview, anyone can watch
        if ($this->is_preview) {
            return true;
        }

        // Check if user is enrolled in the course
        $course = $this->course;
        if (!$course) {
            return false;
        }

        return $course->isEnrolledByUser($userId);
    }
}