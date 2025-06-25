<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Traits\Bookmarkable;

class Discussion extends Model
{
    use HasFactory, Bookmarkable;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
        'discussion_category_id',
        'course_id',
        'status',
        'is_pinned',
        'is_answered',
        'views_count',
        'replies_count',
        'votes_count',
        'last_reply_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_pinned' => 'boolean',
        'is_answered' => 'boolean',
        'last_reply_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($discussion) {
            // Set default status jika tidak ada
            if (empty($discussion->status)) {
                $discussion->status = 'published';
            }
            
            if (empty($discussion->slug)) {
                $discussion->slug = Str::slug($discussion->title);
                
                // Ensure slug is unique
                $count = 1;
                $originalSlug = $discussion->slug;
                
                while (static::where('slug', $discussion->slug)->exists()) {
                    $discussion->slug = $originalSlug . '-' . $count++;
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

    // Relationships
    public function category()
    {
        return $this->belongsTo(DiscussionCategory::class, 'discussion_category_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(DiscussionReply::class)->whereNull('parent_id');
    }

    public function allReplies()
    {
        return $this->hasMany(DiscussionReply::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeAnswered($query)
    {
        return $query->where('is_answered', true);
    }

    public function scopeUnanswered($query)
    {
        return $query->where('is_answered', false);
    }

    public function scopeForCategory($query, $categoryId)
    {
        return $query->where('discussion_category_id', $categoryId);
    }

    public function scopeForCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }

    // Methods
    public function incrementViewCount()
    {
        $this->increment('views_count');
        return $this;
    }

    public function markAsAnswered()
    {
        $this->update(['is_answered' => true]);
        return $this;
    }

    public function updateRepliesCount()
    {
        $this->replies_count = $this->allReplies()->count();
        $this->save();
        return $this;
    }

    public function updateVotesCount()
    {
        $this->votes_count = $this->votes()->sum('value');
        $this->save();
        return $this;
    }

    public function hasUserVoted($userId)
    {
        return $this->votes()->where('user_id', $userId)->exists();
    }

    public function getUserVote($userId)
    {
        $vote = $this->votes()->where('user_id', $userId)->first();
        return $vote ? $vote->value : null;
    }

    /**
     * Ensure a slug is always available
     */
    public function getSlugAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }
        
        // Generate a slug from the title if none exists
        $slug = Str::slug($this->title);
        
        if (empty($slug)) {
            return 'discussion-' . $this->id;
        }
        
        return $slug;
    }
} 