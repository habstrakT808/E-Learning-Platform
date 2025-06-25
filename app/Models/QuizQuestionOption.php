<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizQuestionOption extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quiz_question_options';
    
    protected $fillable = [
        'quiz_question_id',
        'option_text',
        'is_correct',
        'order'
    ];
    
    protected $casts = [
        'is_correct' => 'boolean',
    ];
    
    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_question_id');
    }
}