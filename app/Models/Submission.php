<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Submission extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'assignment_id',
        'user_id',
        'notes',
        'file_path',
        'original_filename',
        'file_size',
        'mime_type',
        'status',
        'feedback',
        'score',
        'is_late',
        'attempt_number',
        'reviewed_at',
        'reviewed_by',
    ];
    
    protected $casts = [
        'is_late' => 'boolean',
        'score' => 'integer',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Status constants
     */
    const STATUS_DRAFT = 'draft';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_REVIEWED = 'reviewed';
    const STATUS_NEED_REVISION = 'need_revision';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    
    /**
     * Get all submission statuses
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_SUBMITTED => 'Submitted',
            self::STATUS_REVIEWED => 'Reviewed',
            self::STATUS_NEED_REVISION => 'Needs Revision',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
        ];
    }
    
    /**
     * Get the assignment that owns the submission
     */
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }
    
    /**
     * Get the student who submitted the submission
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Get the instructor who reviewed the submission
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
    
    /**
     * Get the file URL
     */
    public function getFileUrlAttribute(): ?string
    {
        if (!$this->file_path) {
            return null;
        }
        
        return Storage::url($this->file_path);
    }
    
    /**
     * Format the file size for human reading
     */
    public function getFormattedFileSizeAttribute(): string
    {
        if (!$this->file_size) {
            return '0 KB';
        }
        
        $size = (int) $this->file_size;
        
        if ($size < 1024) {
            return $size . ' KB';
        } elseif ($size < 1024 * 1024) {
            return round($size / 1024, 1) . ' MB';
        }
        
        return round($size / (1024 * 1024), 2) . ' GB';
    }
    
    /**
     * Get the status class for UI display
     */
    public function getStatusClassAttribute(): string
    {
        switch ($this->status) {
            case self::STATUS_DRAFT:
                return 'bg-gray-200 text-gray-800';
            case self::STATUS_SUBMITTED:
                return 'bg-blue-100 text-blue-800';
            case self::STATUS_REVIEWED:
                return 'bg-purple-100 text-purple-800';
            case self::STATUS_NEED_REVISION:
                return 'bg-amber-100 text-amber-800';
            case self::STATUS_APPROVED:
                return 'bg-green-100 text-green-800';
            case self::STATUS_REJECTED:
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }
    
    /**
     * Get formatted status text
     */
    public function getFormattedStatusAttribute(): string
    {
        return self::getStatuses()[$this->status] ?? ucfirst($this->status);
    }
}
