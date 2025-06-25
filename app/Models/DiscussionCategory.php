<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DiscussionCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'is_course_specific',
        'course_id',
        'order',
        'is_active',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
                
                // Ensure slug is unique
                $count = 1;
                $originalSlug = $category->slug;
                
                while (static::where('slug', $category->slug)->exists()) {
                    $category->slug = $originalSlug . '-' . $count++;
                }
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the course that owns the category (if category is course-specific)
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the discussions in this category
     */
    public function discussions()
    {
        return $this->hasMany(Discussion::class, 'discussion_category_id');
    }

    /**
     * Get general categories that are not course-specific
     */
    public function scopeGeneral($query)
    {
        return $query->where('is_course_specific', false);
    }

    /**
     * Get categories specific to a course
     */
    public function scopeForCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }

    /**
     * Get active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get ordered categories
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
