<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathStageCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'path_stage_id',
        'course_id',
        'order',
        'is_required',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    /**
     * Get the stage that owns the course.
     */
    public function stage()
    {
        return $this->belongsTo(PathStage::class, 'path_stage_id');
    }

    /**
     * Get the course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
