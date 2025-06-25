<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Bookmarkable;

class CourseResource extends Model
{
    use HasFactory, Bookmarkable;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'type',
        'url',
        'file_path',
        'file_size',
        'file_type',
        'sort_order',
        'is_external',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_external' => 'boolean',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Accessors
    public function getFormattedFileSizeAttribute()
    {
        if (!$this->file_size) return '';
        
        $size = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, 2) . ' ' . $units[$i];
    }
    
    public function getIconAttribute()
    {
        switch ($this->type) {
            case 'document':
                return 'file-text';
            case 'video':
                return 'video';
            case 'audio':
                return 'headphones';
            case 'image':
                return 'image';
            case 'link':
                return 'link';
            case 'book':
                return 'book';
            case 'presentation':
                return 'presentation-screen';
            case 'archive':
                return 'archive';
            default:
                return 'document';
        }
    }
} 