<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_attempt_id',
        'attempt_id',
        'quiz_question_id',
        'question_id',
        'quiz_question_option_id',
        'selected_option_id',
        'answer_text',
        'is_correct',
        'points_earned',
        'feedback',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'points_earned' => 'integer',
    ];

    /**
     * Get the attempt that owns the answer.
     */
    public function attempt()
    {
        return $this->belongsTo(QuizAttempt::class, 'attempt_id');
    }

    /**
     * Get the quiz attempt that owns the answer.
     */
    public function quizAttempt()
    {
        return $this->belongsTo(QuizAttempt::class, 'quiz_attempt_id');
    }

    /**
     * Get the question that owns the answer.
     */
    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_question_id');
    }

    /**
     * Get the selected option associated with the answer.
     */
    public function selectedOption()
    {
        return $this->belongsTo(QuizQuestionOption::class, 'quiz_question_option_id');
    }

    /**
     * Get the question that owns the answer using question_id.
     */
    public function questionByQuestionId()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }

    /**
     * Check if this answer has been graded.
     */
    public function isGraded()
    {
        return $this->is_correct !== null || $this->points_earned !== null;
    }

    /**
     * Grade a multiple choice or true/false answer.
     */
    public function gradeObjectiveAnswer()
    {
        $questionType = $this->question->type;
        
        if ($questionType === 'multiple_choice' || $questionType === 'true_false') {
            if (!$this->quiz_question_option_id) {
                $this->update([
                    'is_correct' => false,
                    'points_earned' => 0
                ]);
                \Log::debug("Answer ID {$this->id} has no selected option, marked as incorrect");
                return;
            }

            try {
                // Memastikan selected option terisi dengan benar
                $selectedOption = $this->selectedOption;
                
                if (!$selectedOption) {
                    \Log::error("Missing selectedOption relation for answer ID {$this->id} with quiz_question_option_id {$this->quiz_question_option_id}");
                    $this->update([
                        'is_correct' => false,
                        'points_earned' => 0
                    ]);
                    return;
                }
                
                $isCorrect = $selectedOption->is_correct;
                $pointsEarned = $isCorrect ? $this->question->points : 0;
                
                \Log::debug("Answer ID {$this->id} - Option {$this->quiz_question_option_id} is " . 
                          ($isCorrect ? "correct" : "incorrect") . " - Awarded {$pointsEarned} points");
                
                $this->update([
                    'is_correct' => $isCorrect,
                    'points_earned' => $pointsEarned
                ]);
            } catch (\Exception $e) {
                \Log::error("Error grading answer ID {$this->id}: " . $e->getMessage());
                $this->update([
                    'is_correct' => false,
                    'points_earned' => 0
                ]);
            }
        }
    }

    /**
     * Grade a short answer automatically by exact match.
     */
    public function gradeShortAnswer()
    {
        if ($this->question->type !== 'short_answer' || !$this->answer_text) {
            return;
        }

        // Get correct answers from the options
        $correctAnswers = $this->question->correctOptions()->pluck('option_text')->toArray();
        
        // Convert all to lowercase for case-insensitive comparison
        $userAnswer = strtolower(trim($this->answer_text));
        $correctAnswers = array_map(function ($answer) {
            return strtolower(trim($answer));
        }, $correctAnswers);
        
        $isCorrect = in_array($userAnswer, $correctAnswers);
        $pointsEarned = $isCorrect ? $this->question->points : 0;
        
        $this->update([
            'is_correct' => $isCorrect,
            'points_earned' => $pointsEarned
        ]);
    }

    /**
     * Grade an essay answer manually.
     */
    public function gradeEssayAnswer($isCorrect, $pointsEarned, $feedback = null)
    {
        if ($this->question->type !== 'essay') {
            return false;
        }
        
        $this->update([
            'is_correct' => $isCorrect,
            'points_earned' => $pointsEarned,
            'feedback' => $feedback
        ]);
        
        return true;
    }
} 