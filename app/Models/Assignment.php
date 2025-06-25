<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'deadline',
        'max_score',
        'max_attempts',
        'is_active',
        'allow_late_submission',
        'allowed_file_types',
        'max_file_size',
    ];
    
    protected $casts = [
        'deadline' => 'datetime',
        'is_active' => 'boolean',
        'allow_late_submission' => 'boolean',
        'allowed_file_types' => 'array',
    ];

    /**
     * Get the course that owns the assignment
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    
    /**
     * Get submissions for this assignment
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
    
    /**
     * Check if assignment is past deadline
     */
    public function isPastDeadline(): bool
    {
        if (!$this->deadline) {
            return false;
        }
        
        return Carbon::now()->greaterThan($this->deadline);
    }
    
    /**
     * Get time remaining until deadline in human readable format
     */
    public function getTimeRemainingAttribute(): string
    {
        if (!$this->deadline) {
            return 'No deadline';
        }
        
        if ($this->isPastDeadline()) {
            return 'Deadline passed';
        }
        
        return Carbon::now()->diffForHumans($this->deadline, true) . ' remaining';
    }
    
    /**
     * Get deadline in a formatted string
     */
    public function getFormattedDeadlineAttribute(): string
    {
        if (!$this->deadline) {
            return 'No deadline';
        }
        
        return $this->deadline->format('M d, Y - H:i');
    }
    
    /**
     * Get submission status for a specific user
     */
    public function getSubmissionStatusForUser($userId): string
    {
        $submission = $this->submissions()->where('user_id', $userId)->latest()->first();
        
        if (!$submission) {
            return 'Not submitted';
        }
        
        return ucfirst(str_replace('_', ' ', $submission->status));
    }
    
    /**
     * Get the latest submission for a specific user
     */
    public function getLatestSubmissionForUser($userId): ?Submission
    {
        return $this->submissions()->where('user_id', $userId)->latest()->first();
    }
}
