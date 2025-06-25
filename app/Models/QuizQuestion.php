<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question',
        'type',
        'explanation',
        'points',
        'order',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'points' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the quiz that owns the question.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get all options for this question.
     */
    public function options()
    {
        return $this->hasMany(QuizQuestionOption::class, 'quiz_question_id')->orderBy('order');
    }

    /**
     * Get the correct options for the question.
     */
    public function correctOptions()
    {
        return $this->options()->where('is_correct', true);
    }

    /**
     * Get the user answers for this question.
     */
    public function answers()
    {
        return $this->hasMany(QuizAnswer::class, 'quiz_question_id');
    }

    /**
     * Check if the question is a multiple-choice question.
     */
    public function isMultipleChoice()
    {
        return $this->type === 'multiple_choice';
    }

    /**
     * Check if the question is a true/false question.
     */
    public function isTrueFalse()
    {
        return $this->type === 'true_false';
    }

    /**
     * Check if the question is a short answer question.
     */
    public function isShortAnswer()
    {
        return $this->type === 'short_answer';
    }

    /**
     * Check if the question is an essay question.
     */
    public function isEssay()
    {
        return $this->type === 'essay';
    }

    /**
     * Check if the question needs manual grading.
     */
    public function needsManualGrading()
    {
        return $this->isEssay() || $this->isShortAnswer();
    }
} 