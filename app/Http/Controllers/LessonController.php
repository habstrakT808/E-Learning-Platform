<?php
// app/Http/Controllers/LessonController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\LessonProgress;
use App\Models\Enrollment;
use App\Models\Review;
use App\Models\LessonNote;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of lessons for a course.
     */
    public function index(Course $course)
    {
        // Check if user is enrolled
        if (!$course->isEnrolledByUser(Auth::id()) && !$course->hasPreviewLessons()) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You need to enroll in this course to access the lessons.');
        }

        $enrollment = $course->getEnrollmentByUser(Auth::id());
        
        // Get all course lessons organized by section
        $courseLessons = $course->lessons()
            ->with(['section', 'userProgress'])
            ->orderBy('sections.order')
            ->orderBy('lessons.order')
            ->get()
            ->groupBy('section.title');

        // Get last watched lesson and next recommended lesson
        $lastWatchedLesson = null;
        $nextLesson = null;
        
        if ($enrollment) {
            // Find the last watched lesson
            $lastProgress = LessonProgress::where('enrollment_id', $enrollment->id)
                ->orderBy('updated_at', 'desc')
                ->first();
                
            if ($lastProgress) {
                $lastWatchedLesson = $lastProgress->lesson;
                
                // Find next lesson if last watched is completed
                if ($lastProgress->is_completed) {
                    $nextLesson = $lastWatchedLesson->getNextLesson();
                } else {
                    $nextLesson = $lastWatchedLesson;
                }
            }
            
            // If no last watched lesson, get the first lesson of the course
            if (!$lastWatchedLesson && $course->sections->isNotEmpty()) {
                $firstSection = $course->sections->sortBy('order')->first();
                if ($firstSection && $firstSection->lessons->isNotEmpty()) {
                    $nextLesson = $firstSection->lessons->sortBy('order')->first();
                }
            }
        }

        // Calculate completion statistics
        $totalLessons = $course->lessons()->count();
        $completedLessons = 0;
        $totalWatchTime = 0;
        
        if ($enrollment) {
            $lessonProgress = LessonProgress::where('enrollment_id', $enrollment->id)->get();
            $completedLessons = $lessonProgress->where('is_completed', true)->count();
            $totalWatchTime = $lessonProgress->sum('watch_time');
        }

        // Get related resources
        $quizzes = $course->quizzes()->where('is_published', true)->get();
        $assignments = $course->assignments()->where('is_active', true)->get();
        $discussions = $course->discussions()->count() > 0;

        return view('lessons.index', compact(
            'course',
            'courseLessons',
            'lastWatchedLesson',
            'nextLesson',
            'totalLessons',
            'completedLessons',
            'totalWatchTime',
            'quizzes',
            'assignments',
            'discussions'
        ));
    }

    public function show(Course $course, Lesson $lesson)
    {
        // Check if lesson belongs to the course
        if ($lesson->section->course_id !== $course->id) {
            abort(404);
        }

        // Check if user can access this lesson
        if (!$lesson->canBeWatched(Auth::id())) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You need to enroll in this course to access this lesson.');
        }

        $enrollment = $course->getEnrollmentByUser(Auth::id());
        
        // Load lesson with related data
        $lesson->load(['section']);
        
        // Get all course lessons for navigation
        $courseLessons = $course->lessons()
            ->with('section')
            ->orderBy('sections.order')
            ->orderBy('lessons.order')
            ->get()
            ->groupBy('section.title');

        // Get next and previous lessons
        $nextLesson = $lesson->getNextLesson();
        $previousLesson = $lesson->getPreviousLesson();

        // Get or create lesson progress
        $progress = LessonProgress::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'lesson_id' => $lesson->id
            ],
            [
                'enrollment_id' => $enrollment->id,
                'is_completed' => false,
                'watch_time' => 0
            ]
        );

        // Get user progress for all lessons
        $userCompletedLessonIds = LessonProgress::where('user_id', Auth::id())
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();
            
        // Get notes for this lesson
        $notes = $lesson->userNote;
        
        // Progress statistics
        $totalLessons = $course->lessons()->count();
        $completedLessons = LessonProgress::where('user_id', Auth::id())
            ->whereIn('lesson_id', $course->lessons()->select('lessons.id')->pluck('lessons.id'))
            ->where('is_completed', true)
            ->count();
            
        // Time statistics
        $totalDuration = $course->total_duration > 0 ? $course->total_duration * 60 : 0; // in minutes
        $completedDuration = $course->lessons()
            ->whereIn('lessons.id', $userCompletedLessonIds)
            ->sum('lessons.duration') * 60; // in minutes
            
        $remainingDuration = max(0, $totalDuration - $completedDuration);
        $remainingHours = floor($remainingDuration / 60);
        $remainingMinutes = $remainingDuration % 60;
        
        $elapsedDuration = $completedDuration;
        $elapsedHours = floor($elapsedDuration / 60);
        $elapsedMinutes = $elapsedDuration % 60;

        return view('lessons.show', compact(
            'course',
            'lesson',
            'courseLessons',
            'nextLesson',
            'previousLesson',
            'progress',
            'userCompletedLessonIds',
            'notes',
            'totalLessons',
            'completedLessons',
            'remainingHours',
            'remainingMinutes',
            'elapsedHours',
            'elapsedMinutes'
        ));
    }

    public function complete(Request $request, Course $course, Lesson $lesson)
    {
        $enrollment = $course->getEnrollmentByUser(Auth::id());
        
        if (!$enrollment) {
            return response()->json(['error' => 'Not enrolled'], 403);
        }

        // Mark lesson as completed
        $progress = LessonProgress::where('user_id', Auth::id())
            ->where('lesson_id', $lesson->id)
            ->first();

        if ($progress) {
            $progress->update([
                'is_completed' => true,
                'completed_at' => now()
            ]);
        }

        // Update enrollment progress
        $enrollment->calculateProgress();

        // Check if this completes the course
        $allCompleted = !$course->lessons()
            ->whereNotIn('lessons.id', function ($query) use ($enrollment) {
                $query->select('lesson_id')
                    ->from('lesson_progress')
                    ->where('enrollment_id', $enrollment->id)
                    ->where('is_completed', true);
            })
            ->exists();

        return response()->json([
            'success' => true,
            'message' => 'Lesson marked as completed',
            'course_progress' => $enrollment->fresh()->progress,
            'course_completed' => $allCompleted
        ]);
    }

    public function updateWatchTime(Request $request, Course $course, Lesson $lesson)
    {
        $request->validate([
            'watch_time' => 'required|integer|min:0'
        ]);

        $enrollment = $course->getEnrollmentByUser(Auth::id());
        
        if (!$enrollment) {
            return response()->json(['error' => 'Not enrolled'], 403);
        }

        $progress = LessonProgress::where('user_id', Auth::id())
            ->where('lesson_id', $lesson->id)
            ->first();

        if ($progress) {
            $progress->update(['watch_time' => $request->watch_time]);

            // Auto-complete if watched 90% of the lesson
            if (!$progress->is_completed && $request->watch_time >= ($lesson->duration * 60 * 0.9)) {
                $progress->update([
                    'is_completed' => true,
                    'completed_at' => now()
                ]);
                $enrollment->calculateProgress();
            }
        }

        return response()->json([
            'success' => true,
            'watch_time' => $progress->watch_time,
            'is_completed' => $progress->is_completed
        ]);
    }

    /**
     * Toggle lesson completion status
     */
    public function toggleComplete(Request $request, Course $course, Lesson $lesson)
    {
        // Check if lesson belongs to the course
        if ($lesson->section->course_id !== $course->id) {
            abort(404);
        }

        // Check if user can access this lesson
        if (!$lesson->canBeWatched(Auth::id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $enrollment = $course->getEnrollmentByUser(Auth::id());

        // Get progress record
        $progress = LessonProgress::where('user_id', Auth::id())
            ->where('lesson_id', $lesson->id)
            ->first();

        if (!$progress) {
            $progress = LessonProgress::create([
                'user_id' => Auth::id(),
                'lesson_id' => $lesson->id,
                'enrollment_id' => $enrollment->id,
                'is_completed' => true,
                'watch_time' => 0,
            ]);
        } else {
            // If the request specifies a completion state, use that
            // Otherwise toggle the current state
            $completionState = $request->has('complete') 
                ? (bool)$request->complete 
                : !$progress->is_completed;
            
            $progress->update(['is_completed' => $completionState]);
        }

        // Update course progress in enrollment
        $totalLessons = $course->lessons()->count();
        $completedLessons = LessonProgress::where('user_id', Auth::id())
            ->whereIn('lesson_id', $course->lessons()->select('lessons.id')->pluck('lessons.id'))
            ->where('is_completed', true)
            ->count();
        
        $progressPercent = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;
        
        $enrollment->update([
            'progress' => $progressPercent,
            'last_completed_at' => now(),
        ]);

        // Check if course is now completed
        if ($completedLessons == $totalLessons) {
            // Mark course as completed if all lessons are completed
            $enrollment->update([
                'completed_at' => now(),
                'status' => 'completed'
            ]);
        }

        return response()->json([
            'success' => true,
            'is_completed' => $progress->is_completed,
            'progress_percent' => $progressPercent
        ]);
    }

    /**
     * Save lesson notes
     */
    public function saveNotes(Request $request, Course $course, Lesson $lesson)
    {
        // Validate request
        $request->validate([
            'content' => 'required|string'
        ]);
        
        // Check if user can access this lesson
        if (!$lesson->canBeWatched(Auth::id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Store or update the note
        $note = LessonNote::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'lesson_id' => $lesson->id
            ],
            [
                'content' => $request->content
            ]
        );
        
        return response()->json([
            'success' => true,
            'note' => $note
        ]);
    }

    /**
     * Download lesson attachment
     */
    public function download(Course $course, Lesson $lesson, $filename)
    {
        // Check if user can access this lesson
        if (!$lesson->canBeWatched(Auth::id())) {
            abort(403);
        }
        
        // Check if the file exists in lesson attachments
        $attachments = $lesson->attachments ?? [];
        
        $fileExists = false;
        foreach ($attachments as $attachment) {
            if (isset($attachment['filename']) && $attachment['filename'] === $filename) {
                $fileExists = true;
                break;
            }
        }
        
        if (!$fileExists) {
            abort(404);
        }
        
        $path = "courses/{$course->id}/lessons/{$lesson->id}/attachments/{$filename}";
        
        if (!Storage::exists($path)) {
            abort(404);
        }
        
        return Storage::download($path, $filename);
    }
}