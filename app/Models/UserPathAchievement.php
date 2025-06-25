<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPathAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'path_achievement_id',
        'earned_at',
        'metadata',
    ];

    protected $casts = [
        'earned_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the user that owns the achievement.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the achievement.
     */
    public function achievement()
    {
        return $this->belongsTo(PathAchievement::class, 'path_achievement_id');
    }
}
