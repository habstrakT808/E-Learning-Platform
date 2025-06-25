<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscussionReply extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'discussion_id',
        'user_id',
        'parent_id',
        'content',
        'is_best_answer',
        'votes_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_best_answer' => 'boolean',
    ];

    // Relationships
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(DiscussionReply::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(DiscussionReply::class, 'parent_id');
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    // Scopes
    public function scopeParentReplies($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeBestAnswers($query)
    {
        return $query->where('is_best_answer', true);
    }

    // Methods
    public function markAsBestAnswer()
    {
        // First unmark any existing best answer in this discussion
        self::where('discussion_id', $this->discussion_id)
            ->where('is_best_answer', true)
            ->update(['is_best_answer' => false]);
        
        // Mark this reply as the best answer
        $this->update(['is_best_answer' => true]);
        
        // Mark the discussion as answered
        $this->discussion->update(['is_answered' => true]);
        
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

    // Helpers for mentions
    public function getMentionedUsers()
    {
        preg_match_all('/@([a-zA-Z0-9_]+)/', $this->content, $matches);
        
        if (!empty($matches[1])) {
            return User::whereIn('username', $matches[1])->get();
        }
        
        return collect();
    }
} 