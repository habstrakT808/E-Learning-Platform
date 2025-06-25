<?php

namespace App\Models\Traits;

use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Bookmarkable
{
    /**
     * Get all of the model's bookmarks.
     */
    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    /**
     * Check if the model is bookmarked by a specific user.
     *
     * @param int $userId
     * @return bool
     */
    public function isBookmarkedBy(int $userId): bool
    {
        return $this->bookmarks()
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Bookmark the model for a specific user.
     *
     * @param int $userId
     * @param int|null $categoryId
     * @param string|null $notes
     * @return \App\Models\Bookmark
     */
    public function bookmarkFor(int $userId, ?int $categoryId = null, ?string $notes = null)
    {
        // Get title from the model
        $title = $this->title ?? $this->name ?? 'Untitled';
        
        // Determine the type based on class name
        $className = class_basename($this);
        $type = strtolower($className);
        
        return $this->bookmarks()->create([
            'user_id' => $userId,
            'bookmark_category_id' => $categoryId,
            'notes' => $notes,
            'title' => $title,
            'type' => $type,
            'is_favorite' => false,
        ]);
    }

    /**
     * Remove a bookmark for a specific user.
     *
     * @param int $userId
     * @return bool
     */
    public function unbookmarkFor(int $userId): bool
    {
        return $this->bookmarks()
            ->where('user_id', $userId)
            ->delete() > 0;
    }

    /**
     * Get the bookmark for the current auth user if exists.
     */
    public function getBookmarkFor($userId = null)
    {
        $userId = $userId ?: Auth::id();
        
        if (!$userId) {
            return null;
        }
        
        return $this->bookmarks()->where('user_id', $userId)->first();
    }

    /**
     * Toggle bookmark status for a user.
     */
    public function toggleBookmarkFor($userId = null, $categoryId = null, $notes = null)
    {
        $userId = $userId ?: Auth::id();
        
        if (!$userId) {
            return null;
        }
        
        if ($this->isBookmarkedBy($userId)) {
            $this->unbookmarkFor($userId);
            return null;
        } else {
            return $this->bookmarkFor($userId, $categoryId, $notes);
        }
    }
} 