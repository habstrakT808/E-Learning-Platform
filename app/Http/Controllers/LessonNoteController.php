<?php
// app/Http/Controllers/LessonNoteController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonNote;

class LessonNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Store or update a lesson note
     */
    public function store(Request $request, Course $course, Lesson $lesson)
    {
        try {
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save note: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get user's note for a lesson
     */
    public function show(Course $course, Lesson $lesson)
    {
        try {
            // Check if user can access this lesson
            if (!$lesson->canBeWatched(Auth::id())) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            
            $note = LessonNote::where('user_id', Auth::id())
                ->where('lesson_id', $lesson->id)
                ->first();
                
            return response()->json([
                'success' => true,
                'note' => $note
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load note: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Delete a lesson note
     */
    public function destroy(Course $course, Lesson $lesson)
    {
        try {
            // Check if user can access this lesson
            if (!$lesson->canBeWatched(Auth::id())) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            
            LessonNote::where('user_id', Auth::id())
                ->where('lesson_id', $lesson->id)
                ->delete();
                
            return response()->json([
                'success' => true,
                'message' => 'Note deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete note: ' . $e->getMessage()
            ], 500);
        }
    }
} 