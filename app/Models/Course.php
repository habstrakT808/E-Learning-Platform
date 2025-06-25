<?php
// app/Models/Course.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Facades\Storage;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property array<array-key, mixed>|null $requirements
 * @property array<array-key, mixed>|null $objectives
 * @property string|null $thumbnail
 * @property numeric $price
 * @property string $level
 * @property string $status
 * @property int $duration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Enrollment> $enrollments
 * @property-read int|null $enrollments_count
 * @property-read mixed $average_rating
 * @property-read mixed $duration_in_hours
 * @property-read mixed $enrolled_students_count
 * @property-read mixed $formatted_price
 * @property-read mixed $is_free
 * @property-read mixed $thumbnail_url
 * @property-read mixed $total_lessons
 * @property-read mixed $total_reviews
 * @property-read mixed $user_progress
 * @property-read \App\Models\User $instructor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Lesson> $lessons
 * @property-read int|null $lessons_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Section> $sections
 * @property-read int|null $sections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $students
 * @property-read int|null $students_count
 * @method static Builder<static>|Course byCategory($categoryId)
 * @method static Builder<static>|Course byLevel($level)
 * @method static Builder<static>|Course draft()
 * @method static Builder<static>|Course free()
 * @method static Builder<static>|Course newModelQuery()
 * @method static Builder<static>|Course newQuery()
 * @method static Builder<static>|Course paid()
 * @method static Builder<static>|Course published()
 * @method static Builder<static>|Course query()
 * @method static Builder<static>|Course whereCreatedAt($value)
 * @method static Builder<static>|Course whereDescription($value)
 * @method static Builder<static>|Course whereDuration($value)
 * @method static Builder<static>|Course whereId($value)
 * @method static Builder<static>|Course whereLevel($value)
 * @method static Builder<static>|Course whereObjectives($value)
 * @method static Builder<static>|Course wherePrice($value)
 * @method static Builder<static>|Course whereRequirements($value)
 * @method static Builder<static>|Course whereSlug($value)
 * @method static Builder<static>|Course whereStatus($value)
 * @method static Builder<static>|Course whereThumbnail($value)
 * @method static Builder<static>|Course whereTitle($value)
 * @method static Builder<static>|Course whereUpdatedAt($value)
 * @method static Builder<static>|Course whereUserId($value)
 * @mixin \Eloquent
 */
class Course extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'requirements',
        'objectives',
        'thumbnail',
        'price',
        'level',
        'status',
        'duration'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'requirements' => 'array',
        'objectives' => 'array',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    // Relationships
    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('order');
    }

    public function lessons()
    {
        return $this->hasManyThrough(
            Lesson::class, 
            Section::class,
            'course_id', // Foreign key pada tabel sections yang merujuk ke courses
            'section_id', // Foreign key pada tabel lessons yang merujuk ke sections
            'id', // Local key pada tabel courses
            'id'  // Local key pada tabel sections
        )->select('lessons.*'); // Gunakan select untuk memperjelas kolom mana yang ingin diambil
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments')
                    ->withPivot('progress', 'enrolled_at', 'completed_at')
                    ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'course_categories');
    }

    // Relationships dengan resources
    public function resources()
    {
        return $this->hasMany(CourseResource::class);
    }

    // Relationships dengan discussions
    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    // Relationships dengan quizzes
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get all assignments for this course
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    // Scopes
    public function scopePublished(Builder $query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft(Builder $query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeByLevel(Builder $query, $level)
    {
        return $query->where('level', $level);
    }

    public function scopeByCategory(Builder $query, $categoryId)
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        });
    }

    public function scopeFree(Builder $query)
    {
        return $query->where('price', 0);
    }

    public function scopePaid(Builder $query)
    {
        return $query->where('price', '>', 0);
    }

    // Accessors & Mutators
    public function getThumbnailUrlAttribute()
    {
        // Jika ada thumbnail yang di-upload, gunakan itu
        if ($this->thumbnail && Storage::exists('public/' . $this->thumbnail)) {
            return asset('storage/' . $this->thumbnail);
        }
        
        // Jika tidak ada, gunakan gambar berdasarkan kategori
        $primaryCategory = $this->categories->first();
        
        if ($primaryCategory) {
            $categorySlug = strtolower(str_replace(' ', '-', $primaryCategory->name));
            $categoryImage = "images/courses/{$categorySlug}.jpg";
            
            if (file_exists(public_path($categoryImage))) {
                return asset($categoryImage);
            }
        }
        
        // Fallback ke beberapa gambar default berdasarkan level course
        $levelImages = [
            'beginner' => 'images/courses/web-development.jpg',
            'intermediate' => 'images/courses/programming.jpg',
            'advanced' => 'images/courses/data-science.jpg',
        ];
        
        if (array_key_exists($this->level, $levelImages)) {
            return asset($levelImages[$this->level]);
        }
        
        // Default fallback
        return asset('images/courses/web-development.jpg');
    }

    public function getFormattedPriceAttribute()
    {
        return $this->price == 0 ? 'Free' : 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getIsFreeAttribute()
    {
        return $this->price == 0;
    }

    public function getDurationInHoursAttribute()
    {
        return round($this->duration / 60, 1);
    }

    // Helper methods
    public function getTotalLessonsAttribute()
    {
        return $this->lessons()->count();
    }

    public function getEnrolledStudentsCountAttribute()
    {
        return $this->enrollments()->count();
    }

    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * Check if a user is enrolled in this course
     */
    public function isEnrolledByUser($userId)
    {
        return $this->enrollments()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->exists();
    }

    /**
     * Get user's enrollment for this course
     */
    public function getEnrollmentByUser($userId)
    {
        return $this->enrollments()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->first();
    }

    /**
     * Get user's progress in this course
     */
    public function getUserProgressAttribute()
    {
        if (!\Illuminate\Support\Facades\Auth::check()) return 0;
        
        $enrollment = $this->getEnrollmentByUser(\Illuminate\Support\Facades\Auth::id());
        return $enrollment ? $enrollment->progress : 0;
    }

    /**
     * Check if course can be enrolled
     */
    public function canBeEnrolled()
    {
        return $this->status === 'published';
    }

    // Calculate total duration from lessons
    public function calculateTotalDuration()
    {
        return $this->lessons()->sum('duration');
    }

    // Update course duration based on lessons
    public function updateDuration()
    {
        $this->update(['duration' => $this->calculateTotalDuration()]);
    }

    /**
     * Check if this course has any preview lessons
     */
    public function hasPreviewLessons()
    {
        return $this->lessons()->where('is_preview', true)->exists();
    }
}