<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Bookmark extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'bookmarkable_type',
        'bookmarkable_id',
        'bookmark_category_id',
        'notes',
        'title',
        'type',
        'metadata',
        'is_favorite',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'metadata' => 'array',
        'is_favorite' => 'boolean',
    ];

    /**
     * Get the user who created the bookmark.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bookmarked item.
     */
    public function bookmarkable()
    {
        return $this->morphTo();
    }

    /**
     * Get the category of the bookmark.
     */
    public function category()
    {
        return $this->belongsTo(BookmarkCategory::class, 'bookmark_category_id');
    }

    /**
     * Scope bookmarks to current authenticated user.
     */
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', Auth::id());
    }

    /**
     * Scope bookmarks to a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope bookmarks to favorites.
     */
    public function scopeFavorites($query)
    {
        return $query->where('is_favorite', true);
    }

    /**
     * Scope bookmarks to a specific category.
     */
    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('bookmark_category_id', $categoryId);
    }

    /**
     * Search bookmarks by title or notes.
     */
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', "%{$searchTerm}%")
              ->orWhere('notes', 'like', "%{$searchTerm}%");
        });
    }

    /**
     * Get icon for bookmarked content type.
     */
    public function getIconAttribute()
    {
        switch ($this->type) {
            case 'lesson':
                return 'book-open';
            case 'resource':
                return 'document';
            case 'discussion':
                return 'chat';
            case 'quiz':
                return 'pencil-alt';
            case 'assignment':
                return 'clipboard-check';
            default:
                return 'bookmark';
        }
    }

    /**
     * Get color for bookmarked content type.
     */
    public function getColorAttribute()
    {
        switch ($this->type) {
            case 'lesson':
                return '#3B82F6'; // blue
            case 'resource':
                return '#10B981'; // green
            case 'discussion':
                return '#8B5CF6'; // purple
            case 'quiz':
                return '#F59E0B'; // amber
            case 'assignment':
                return '#EF4444'; // red
            default:
                return '#6B7280'; // gray
        }
    }

    /**
     * Get bookmark URL.
     */
    public function getUrlAttribute()
    {
        // Return URL based on bookmarkable type
        if ($this->bookmarkable) {
            switch ($this->type) {
                case 'lesson':
                    return route('lessons.show', [$this->bookmarkable->section->course, $this->bookmarkable]);
                case 'resource':
                    return route('courses.resources.show', [$this->bookmarkable->course, $this->bookmarkable]);
                case 'discussion':
                    return route('discussions.show', $this->bookmarkable);
                // Add more cases as needed
            }
        }

        return '#';
    }
}
