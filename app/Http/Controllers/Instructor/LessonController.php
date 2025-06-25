<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Section;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:instructor']);
    }
    
    /**
     * Display a listing of the lessons for a course.
     */
    public function index(Course $course)
    {
        // Ensure instructor owns this course
        $this->authorize('update', $course);
        
        $lessons = $course->lessons()->with('section')->get();
        
        return response()->json([
            'success' => true,
            'lessons' => $lessons,
        ]);
    }

    /**
     * Show the form for editing the specified lesson.
     */
    public function edit(Course $course, Lesson $lesson)
    {
        // Ensure instructor owns this course
        $this->authorize('update', $course);
        
        // Ensure lesson belongs to a section of this course
        if ($lesson->section->course_id !== $course->id) {
            return response()->json([
                'success' => false,
                'message' => 'Lesson does not belong to this course.',
            ], 403);
        }
        
        return response()->json([
            'success' => true,
            'lesson' => $lesson,
        ]);
    }

    /**
     * Store a newly created lesson in storage.
     */
    public function store(Request $request, Course $course)
    {
        // Ensure instructor owns this course
        $this->authorize('update', $course);
        
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'is_preview' => 'sometimes|boolean',
        ]);
        
        // Ensure section belongs to this course
        $section = Section::findOrFail($validated['section_id']);
        if ($section->course_id !== $course->id) {
            return response()->json([
                'success' => false,
                'message' => 'Section does not belong to this course.',
            ], 403);
        }
        
        // Get max order for the section lessons
        $maxOrder = $section->lessons()->max('order') ?? 0;
        
        // Create lesson
        $lesson = $section->lessons()->create([
            'title' => $validated['title'],
            'duration' => $validated['duration'],
            'is_preview' => $request->has('is_preview'),
            'order' => $maxOrder + 1,
            'content' => '',
            'video_platform' => 'none',
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Lesson created successfully!',
            'lesson' => $lesson,
        ]);
    }

    /**
     * Update the specified lesson in storage.
     */
    public function update(Request $request, Course $course, Lesson $lesson)
    {
        // Ensure instructor owns this course
        $this->authorize('update', $course);
        
        // Ensure lesson belongs to a section of this course
        if ($lesson->section->course_id !== $course->id) {
            return response()->json([
                'success' => false,
                'message' => 'Lesson does not belong to this course.',
            ], 403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'is_preview' => 'sometimes|boolean',
        ]);
        
        // Update lesson
        $lesson->update([
            'title' => $validated['title'],
            'duration' => $validated['duration'],
            'is_preview' => $request->has('is_preview'),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Lesson updated successfully!',
            'lesson' => $lesson,
        ]);
    }

    /**
     * Remove the specified lesson from storage.
     */
    public function destroy(Course $course, Lesson $lesson)
    {
        // Ensure instructor owns this course
        $this->authorize('update', $course);
        
        // Ensure lesson belongs to a section of this course
        if ($lesson->section->course_id !== $course->id) {
            return response()->json([
                'success' => false,
                'message' => 'Lesson does not belong to this course.',
            ], 403);
        }
        
        $sectionId = $lesson->section_id;
        
        // Delete lesson
        $lesson->delete();
        
        // Reorder remaining lessons in section
        $remainingLessons = Lesson::where('section_id', $sectionId)->orderBy('order')->get();
        foreach ($remainingLessons as $index => $remainingLesson) {
            $remainingLesson->update(['order' => $index + 1]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Lesson deleted successfully!',
        ]);
    }
}
