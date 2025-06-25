<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionOption;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
use App\Models\Course;
use Carbon\Carbon;

class QuizController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a quiz.
     */
    public function show(Request $request, Course $course, Quiz $quiz)
    {
        // Check if quiz belongs to the course
        if ($quiz->course_id !== $course->id) {
            abort(404);
        }

        // Check if user is enrolled
        if (!$course->isEnrolledByUser(Auth::id())) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You need to enroll in this course to access this quiz.');
        }
        
        // Get previous attempts
        $previousAttempts = $quiz->attempts()
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();
            
        $latestAttempt = $previousAttempts->first();
        
        // Check if there's an ongoing attempt
        $ongoingAttempt = $latestAttempt && $latestAttempt->isInProgress() ? $latestAttempt : null;
        
        // Check if user can take this quiz
        $canAttempt = $quiz->canBeAttemptedByUser(Auth::id());

        return view('quizzes.show', [
            'course' => $course,
            'quiz' => $quiz,
            'previousAttempts' => $previousAttempts,
            'ongoingAttempt' => $ongoingAttempt,
            'canAttempt' => $canAttempt,
            'attemptsExhausted' => $quiz->max_attempts > 0 && $previousAttempts->count() >= $quiz->max_attempts,
        ]);
    }

    /**
     * Start a new quiz attempt.
     */
    public function start(Request $request, Course $course, Quiz $quiz)
    {
        // Check if quiz belongs to the course
        if ($quiz->course_id !== $course->id) {
            abort(404);
        }

        // Check if user can take this quiz
        if (!$quiz->canBeAttemptedByUser(Auth::id())) {
            return redirect()->route('quizzes.show', [$course, $quiz])
                ->with('error', 'You cannot attempt this quiz.');
        }

        // Check for existing attempts
        $attemptsCount = $quiz->attempts()->where('user_id', Auth::id())->count();
        
        // Create a new attempt
        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'started_at' => now(),
            'attempt_number' => $attemptsCount + 1,
        ]);

        return redirect()->route('quizzes.take', [$course, $quiz, $attempt]);
    }

    /**
     * Take a quiz (answer questions).
     */
    public function take(Request $request, Course $course, Quiz $quiz, QuizAttempt $attempt)
    {
        // Check if quiz belongs to the course
        if ($quiz->course_id !== $course->id || $attempt->quiz_id !== $quiz->id) {
            abort(404);
        }

        // Check if attempt belongs to the authenticated user
        if ($attempt->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if attempt is already submitted
        if ($attempt->submitted_at) {
            return redirect()->route('quizzes.review', [$course, $quiz, $attempt])
                ->with('info', 'This attempt has already been submitted.');
        }

        // Get questions (randomized if required)
        $questions = $quiz->questions();
        if ($quiz->randomize_questions) {
            $questions = $questions->inRandomOrder();
        } else {
            $questions = $questions->orderBy('order');
        }
        $questions = $questions->with('options')->get();

        // Get existing answers for this attempt
        $answers = $attempt->answers()->get()->keyBy('question_id');

        // Check time limit
        $timeExpired = false;
        $remainingTime = null;
        
        if ($quiz->time_limit) {
            $remainingTime = $attempt->remaining_time;
            $timeExpired = $remainingTime <= 0;
            
            if ($timeExpired && !$attempt->submitted_at) {
                // Auto-submit if time expired
                return $this->processSubmit($request, $course, $quiz, $attempt, true);
            }
        }

        return view('quizzes.take', [
            'course' => $course,
            'quiz' => $quiz,
            'attempt' => $attempt,
            'questions' => $questions,
            'answers' => $answers,
            'remainingTime' => $remainingTime,
            'currentPage' => $request->page ?? 1,
        ]);
    }

    /**
     * Save an answer during a quiz attempt.
     */
    public function saveAnswer(Request $request, Course $course, Quiz $quiz, QuizAttempt $attempt, QuizQuestion $question)
    {
        // Log semua request yang masuk
        $logFile = storage_path('logs/quiz_debug.log');
        file_put_contents($logFile, "=== QUIZ ANSWER REQUEST RECEIVED ===\n", FILE_APPEND);
        file_put_contents($logFile, "Method: " . $request->method() . "\n", FILE_APPEND);
        file_put_contents($logFile, "Content-Type: " . $request->header('Content-Type') . "\n", FILE_APPEND);
        file_put_contents($logFile, "Raw content: " . $request->getContent() . "\n", FILE_APPEND);
        file_put_contents($logFile, "Parameters: " . json_encode($request->all()) . "\n", FILE_APPEND);
        file_put_contents($logFile, "Question ID: " . $question->id . "\n", FILE_APPEND);
        file_put_contents($logFile, "Attempt ID: " . $attempt->id . "\n", FILE_APPEND);
        
        \Log::info("=== QUIZ ANSWER REQUEST RECEIVED ===");
        \Log::info("Method: " . $request->method());
        \Log::info("Content-Type: " . $request->header('Content-Type'));
        \Log::info("Raw content: " . $request->getContent());
        \Log::info("Parameters: " . json_encode($request->all()));
        \Log::info("Question ID: " . $question->id);
        \Log::info("Attempt ID: " . $attempt->id);
        
        // Check if quiz and question are related and attempt is valid
        if ($quiz->course_id !== $course->id || $question->quiz_id !== $quiz->id || 
            $attempt->quiz_id !== $quiz->id || $attempt->user_id !== Auth::id()) {
            \Log::error("Invalid operation. Auth ID: " . Auth::id() . ", Attempt user ID: " . $attempt->user_id);
            return response()->json(['error' => 'Invalid operation'], 403);
        }
        
        // Check if attempt is already submitted
        if ($attempt->submitted_at) {
            \Log::error("Attempt already submitted at: " . $attempt->submitted_at);
            return response()->json(['error' => 'This attempt has already been submitted'], 403);
        }

        $answer = null;
        $questionType = $question->type;

        try {
            \DB::beginTransaction();
            
            // Log informasi untuk debugging
            \Log::info("Saving answer for question ID: {$question->id}, attempt ID: {$attempt->id}, attempt user: {$attempt->user_id}");
            
            switch ($questionType) {
                case 'multiple_choice':
                case 'true_false':
                    $validatedData = $request->validate([
                        'selected_option_id' => 'required|integer|exists:quiz_question_options,id'
                    ]);
                    
                    $optionId = $validatedData['selected_option_id'];
                    \Log::info("Validating option ID: {$optionId}");
                    file_put_contents(storage_path('logs/quiz_debug.log'), "Validating option ID: {$optionId}\n", FILE_APPEND);
                    
                    // Make sure the option belongs to the question
                    $option = QuizQuestionOption::where('id', $optionId)
                                               ->where('quiz_question_id', $question->id)
                                               ->first();
                                               
                    if (!$option) {
                        \DB::rollBack();
                        file_put_contents(storage_path('logs/quiz_debug.log'), "Invalid option selected: Option {$optionId} does not belong to question {$question->id}\n", FILE_APPEND);
                        \Log::error("Invalid option selected: Option {$optionId} does not belong to question {$question->id}");
                        return response()->json(['error' => 'Invalid option selected'], 400);
                    }
                    
                    // Debug: Tampilkan info opsi yang dipilih
                    file_put_contents(storage_path('logs/quiz_debug.log'), "Selected option: {$option->id}, option text: {$option->option_text}\n", FILE_APPEND);
                    \Log::debug("Selected option: {$option->id}, option text: {$option->option_text}");
                    
                    // Hapus jawaban lama untuk menghindari duplikasi
                    $deleted = QuizAnswer::where(function($query) use ($attempt, $question) {
                        $query->where('attempt_id', $attempt->id)
                              ->orWhere('quiz_attempt_id', $attempt->id);
                    })
                    ->where('quiz_question_id', $question->id)
                    ->delete();
                    \Log::info("Deleted {$deleted} old answers");
                        
                    // Buat jawaban baru
                    $answer = new QuizAnswer();
                    $answer->quiz_attempt_id = $attempt->id;
                    $answer->attempt_id = $attempt->id;
                    $answer->question_id = $question->id;
                    $answer->quiz_question_id = $question->id;
                    $answer->selected_option_id = $option->id;
                    $answer->quiz_question_option_id = $option->id;
                    $answer->answer_text = null;
                    $answer->save();
                    
                    \Log::info("Answer saved with ID: {$answer->id}");
                    break;
                    
                case 'short_answer':
                case 'essay':
                    $validatedData = $request->validate([
                        'answer_text' => 'required|string'
                    ]);
                    
                    $answerText = $validatedData['answer_text'];
                    \Log::debug("Saving text answer: {$answerText}");
                    
                    // Hapus jawaban lama untuk menghindari duplikasi
                    $deleted = QuizAnswer::where(function($query) use ($attempt, $question) {
                        $query->where('attempt_id', $attempt->id)
                              ->orWhere('quiz_attempt_id', $attempt->id);
                    })
                    ->where('quiz_question_id', $question->id)
                    ->delete();
                    \Log::info("Deleted {$deleted} old text answers");
                        
                    // Buat jawaban baru
                    $answer = new QuizAnswer();
                    $answer->quiz_attempt_id = $attempt->id;
                    $answer->attempt_id = $attempt->id;
                    $answer->question_id = $question->id;
                    $answer->quiz_question_id = $question->id;
                    $answer->selected_option_id = null;
                    $answer->quiz_question_option_id = null;
                    $answer->answer_text = $answerText;
                    $answer->save();
                    
                    \Log::info("Text answer saved with ID: {$answer->id}");
                    break;
            }
            
            \DB::commit();
            
            // Verifikasi jawaban tersimpan
            $verifyAnswer = QuizAnswer::where(function($query) use ($attempt, $question) {
                $query->where('attempt_id', $attempt->id)
                      ->orWhere('quiz_attempt_id', $attempt->id);
            })
            ->where('quiz_question_id', $question->id)
            ->first();
                
            if (!$verifyAnswer) {
                \Log::error("Failed to save quiz answer: attempt_id={$attempt->id}, question_id={$question->id}");
                return response()->json([
                    'success' => false,
                    'error' => 'Answer could not be saved'
                ], 500);
            }
            
            \Log::info("Answer verified with ID: {$verifyAnswer->id}");
            
            // Memeriksa total jawaban yang tersimpan
            $totalAnswers = QuizAnswer::where(function($query) use ($attempt) {
                $query->where('attempt_id', $attempt->id)
                      ->orWhere('quiz_attempt_id', $attempt->id);
            })->count();
            \Log::info("Total answers for attempt {$attempt->id}: {$totalAnswers}");
            
            return response()->json([
                'success' => true,
                'answer' => $verifyAnswer,
                'message' => 'Answer saved successfully'
            ]);
            
        } catch (\Exception $e) {
            \DB::rollBack();
            file_put_contents(storage_path('logs/quiz_debug.log'), "ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
            file_put_contents(storage_path('logs/quiz_debug.log'), "TRACE: " . $e->getTraceAsString() . "\n", FILE_APPEND);
            \Log::error("Error saving quiz answer: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while saving your answer: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Review answers before submitting.
     */
    public function review(Request $request, Course $course, Quiz $quiz, QuizAttempt $attempt)
    {
        // Check if quiz and attempt are related
        if ($quiz->course_id !== $course->id || $attempt->quiz_id !== $quiz->id) {
            abort(404);
        }

        // Check if attempt belongs to the authenticated user
        if ($attempt->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Get questions
        $questions = $quiz->questions()->with('options')->orderBy('order')->get();
        
        // Get user answers with eager loading untuk memastikan data lengkap dan preload relasi
        $answers = $attempt->answers()
            ->with(['question', 'selectedOption'])
            ->get();
            
        // Debug: Pastikan data jawaban diambil dengan benar
        \Log::debug('Quiz Review - Answers count: ' . $answers->count());
        foreach ($answers as $answer) {
            \Log::debug("Answer for question {$answer->question_id}: " . 
                      ($answer->selected_option_id ? "Option: {$answer->selected_option_id}" : "") .
                      ($answer->answer_text ? "Text: {$answer->answer_text}" : ""));
        }
            
        // Konversi ke array dengan key question_id
        $answers = $answers->keyBy('question_id');
        
        // Memastikan info jawaban yang benar dihitung
        $answeredCount = 0;
        foreach ($questions as $question) {
            if (isset($answers[$question->id])) {
                $answer = $answers[$question->id];
                if (
                    (($question->type === 'multiple_choice' || $question->type === 'true_false') && $answer->selected_option_id) ||
                    (($question->type === 'short_answer' || $question->type === 'essay') && !empty($answer->answer_text))
                ) {
                    $answeredCount++;
                    \Log::debug("Question {$question->id} is answered");
                } else {
                    \Log::debug("Question {$question->id} has answer record but is considered unanswered");
                }
            } else {
                \Log::debug("Question {$question->id} has no answer record");
            }
        }
        
        $totalQuestions = $questions->count();
        
        // Debug: Tampilkan jumlah pertanyaan yang dijawab
        \Log::debug("Total questions: {$totalQuestions}, Answered: {$answeredCount}");
        
        // Check if all questions have been answered
        $allAnswered = $answeredCount === $totalQuestions;

        return view('quizzes.review', [
            'course' => $course,
            'quiz' => $quiz,
            'attempt' => $attempt,
            'questions' => $questions,
            'answers' => $answers,
            'answeredCount' => $answeredCount,
            'totalQuestions' => $totalQuestions,
            'allAnswered' => $allAnswered,
            'isSubmitted' => $attempt->submitted_at !== null,
        ]);
    }

    /**
     * Submit the quiz attempt.
     */
    public function submit(Request $request, Course $course, Quiz $quiz, QuizAttempt $attempt)
    {
        return $this->processSubmit($request, $course, $quiz, $attempt);
    }

    /**
     * Process quiz submission (internal method).
     */
    private function processSubmit($request, $course, $quiz, $attempt, $isAutoSubmit = false)
    {
        // Check if quiz and attempt are related
        if ($quiz->course_id !== $course->id || $attempt->quiz_id !== $quiz->id) {
            abort(404);
        }

        // Check if attempt belongs to the authenticated user
        if ($attempt->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if it's already submitted
        if ($attempt->submitted_at) {
            return redirect()->route('quizzes.result', [$course, $quiz, $attempt]);
        }

        // Calculate time spent
        $timeSpent = $attempt->started_at->diffInSeconds(now());
        
        \Log::debug("Quiz submission - Time spent: {$timeSpent} seconds");
        
        // Update attempt as submitted
        $attempt->update([
            'submitted_at' => now(),
            'time_spent' => $timeSpent,
        ]);

        // Grade objective questions automatically
        $this->gradeObjectiveQuestions($attempt);
        
        // Debug: Log jawaban setelah penilaian
        $answers = $attempt->answers()->with(['question', 'selectedOption'])->get();
        foreach ($answers as $answer) {
            $isCorrect = $answer->is_correct ? 'Benar' : 'Salah';
            $points = $answer->points_earned;
            $questionText = substr($answer->question->question, 0, 30) . '...';
            \Log::debug("Jawaban untuk pertanyaan '{$questionText}': {$isCorrect}, Poin: {$points}");
        }
        
        // Calculate the score
        $score = $attempt->calculateScore();
        
        \Log::debug("Quiz submitted - Final score: {$score}, Passed: " . ($attempt->is_passed ? 'Yes' : 'No'));
        
        // If auto submit, redirect with message
        if ($isAutoSubmit) {
            return redirect()->route('quizzes.result', [$course, $quiz, $attempt])
                ->with('info', 'Time is up! Your quiz has been automatically submitted.');
        }

        return redirect()->route('quizzes.result', [$course, $quiz, $attempt]);
    }

    /**
     * Show quiz result.
     */
    public function result(Request $request, Course $course, Quiz $quiz, QuizAttempt $attempt)
    {
        // Check if quiz and attempt are related
        if ($quiz->course_id !== $course->id || $attempt->quiz_id !== $quiz->id) {
            abort(404);
        }

        // Check if attempt belongs to the authenticated user
        if ($attempt->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if it's submitted
        if (!$attempt->submitted_at) {
            return redirect()->route('quizzes.take', [$course, $quiz, $attempt]);
        }

        // Get questions with options
        $questions = $quiz->questions()->with('options')->orderBy('order')->get();
        
        // Get answers with options
        $answers = $attempt->answers()->with('selectedOption')->get()->keyBy('question_id');
        
        // Calculate stats
        $totalQuestions = $questions->count();
        $answeredQuestions = $answers->count();
        $correctAnswers = $answers->where('is_correct', true)->count();
        $incorrectAnswers = $answers->where('is_correct', false)->count();
        $unansweredQuestions = $totalQuestions - $answeredQuestions;

        return view('quizzes.result', [
            'course' => $course,
            'quiz' => $quiz,
            'attempt' => $attempt,
            'questions' => $questions,
            'answers' => $answers,
            'totalQuestions' => $totalQuestions,
            'answeredQuestions' => $answeredQuestions,
            'correctAnswers' => $correctAnswers,
            'incorrectAnswers' => $incorrectAnswers,
            'unansweredQuestions' => $unansweredQuestions,
            'showCorrectAnswers' => $quiz->show_correct_answers,
        ]);
    }

    /**
     * Grade objective questions (multiple choice, true/false, short answer).
     */
    private function gradeObjectiveQuestions($attempt)
    {
        $answers = $attempt->answers()->with('question', 'selectedOption')->get();
        
        $totalQuestions = $attempt->quiz->questions()->count();
        $answeredQuestions = $answers->count();
        
        \Log::info("Grading quiz attempt {$attempt->id} - Total questions: {$totalQuestions}, Answered: {$answeredQuestions}");
        
        // Reset semua poin yang diperoleh untuk menghitung ulang
        foreach ($answers as $answer) {
            $question = $answer->question;
            
            if (!$question) {
                \Log::error("Missing question for answer ID {$answer->id}");
                continue;
            }
            
            \Log::debug("Grading answer for question {$question->id}, type: {$question->type}");
            
            switch ($question->type) {
                case 'multiple_choice':
                case 'true_false':
                    if (!$answer->selected_option_id) {
                        $answer->update([
                            'is_correct' => false,
                            'points_earned' => 0
                        ]);
                        \Log::debug("Answer has no selected option, marked as incorrect");
                        break;
                    }
                    
                    $selectedOption = $answer->selectedOption;
                    if (!$selectedOption) {
                        \Log::error("Missing selected option for answer ID {$answer->id}");
                        $answer->update([
                            'is_correct' => false,
                            'points_earned' => 0
                        ]);
                        break;
                    }
                    
                    $isCorrect = $selectedOption->is_correct;
                    $pointsEarned = $isCorrect ? $question->points : 0;
                    
                    \Log::debug("Answer marked as " . ($isCorrect ? "correct" : "incorrect") . 
                             ", points: {$pointsEarned}/{$question->points}");
                    
                    $answer->update([
                        'is_correct' => $isCorrect,
                        'points_earned' => $pointsEarned
                    ]);
                    break;
                    
                case 'short_answer':
                    $answer->gradeShortAnswer();
                    break;
                    
                case 'essay':
                    // Essays need manual grading
                    $answer->update([
                        'is_correct' => null,
                        'points_earned' => 0
                    ]);
                    break;
            }
        }
        
        // Log hasil penilaian
        $correctCount = $answers->where('is_correct', true)->count();
        $incorrectCount = $answers->where('is_correct', false)->count();
        $pendingCount = $answers->whereNull('is_correct')->count();
        
        \Log::info("Grading complete - Correct: {$correctCount}, Incorrect: {$incorrectCount}, Pending: {$pendingCount}");
    }

    /**
     * Update time spent and keep track of progress.
     */
    public function updateTime(Request $request, Course $course, Quiz $quiz, QuizAttempt $attempt)
    {
        // Check if quiz and attempt are related
        if ($quiz->course_id !== $course->id || $attempt->quiz_id !== $quiz->id) {
            return response()->json(['error' => 'Invalid operation'], 403);
        }

        // Check if attempt belongs to the authenticated user
        if ($attempt->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized action'], 403);
        }

        // Check if it's already submitted
        if ($attempt->submitted_at) {
            return response()->json(['error' => 'This attempt has already been submitted'], 403);
        }

        // Get remaining time
        $remainingTime = $attempt->remaining_time;
        
        // If time's up, auto submit
        if ($quiz->time_limit && $remainingTime <= 0) {
            // Update as submitted
            $attempt->update([
                'submitted_at' => now(),
                'time_spent' => $quiz->time_limit * 60, // Total time spent is the time limit
            ]);
            
            return response()->json([
                'time_expired' => true,
                'redirect_url' => route('quizzes.result', [$course, $quiz, $attempt])
            ]);
        }

        return response()->json([
            'remaining_time' => $remainingTime,
            'time_expired' => false
        ]);
    }

    /**
     * Reset the quiz attempt so user can retry the quiz.
     */
    public function resetQuiz(Request $request, Course $course, Quiz $quiz)
    {
        // Check if quiz belongs to the course
        if ($quiz->course_id !== $course->id) {
            abort(404);
        }

        // Check if user is enrolled
        if (!$course->isEnrolledByUser(Auth::id())) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You need to enroll in this course to access this quiz.');
        }
        
        // Check if user can attempt this quiz
        $canAttempt = $quiz->canBeAttemptedByUser(Auth::id());
        
        if (!$canAttempt) {
            return redirect()->route('quizzes.show', [$course, $quiz])
                ->with('error', 'You have reached the maximum number of attempts for this quiz.');
        }
        
        // Create a new attempt
        $attemptsCount = $quiz->attempts()->where('user_id', Auth::id())->count();
        
        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'started_at' => now(),
            'attempt_number' => $attemptsCount + 1,
        ]);
        
        \Log::info("Created new quiz attempt ID: {$attempt->id} for user ID: " . Auth::id());
        
        return redirect()->route('quizzes.take', [$course, $quiz, $attempt])
            ->with('success', 'You can now retake the quiz. Good luck!');
    }
} 