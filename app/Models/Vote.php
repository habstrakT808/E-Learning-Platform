<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'votable_id',
        'votable_type',
        'value',
    ];

    /**
     * Get the user who cast the vote.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent votable model (discussion or reply).
     */
    public function votable()
    {
        return $this->morphTo();
    }

    /**
     * Scope for upvotes.
     */
    public function scopeUpvotes($query)
    {
        return $query->where('value', 1);
    }

    /**
     * Scope for downvotes.
     */
    public function scopeDownvotes($query)
    {
        return $query->where('value', -1);
    }

    /**
     * Create or update a vote.
     */
    public static function vote($userId, $votableType, $votableId, $value)
    {
        $vote = self::where('user_id', $userId)
            ->where('votable_type', $votableType)
            ->where('votable_id', $votableId)
            ->first();

        if ($vote) {
            // If vote exists and value is the same, remove the vote (toggle)
            if ($vote->value == $value) {
                $vote->delete();
                return null;
            } else {
                // Change vote direction
                $vote->value = $value;
                $vote->save();
                return $vote;
            }
        } else {
            // Create new vote
            return self::create([
                'user_id' => $userId,
                'votable_type' => $votableType,
                'votable_id' => $votableId,
                'value' => $value,
            ]);
        }
    }
}
