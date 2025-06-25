<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:instructor']);
    }
    
    /**
     * Display a listing of the sections for a course.
     */
    public function index(Course $course)
    {
        // Ensure instructor owns this course
        $this->authorize('update', $course);
        
        $sections = $course->sections()->orderBy('order')->with('lessons')->get();
        
        return response()->json([
            'success' => true,
            'sections' => $sections,
        ]);
    }

    /**
     * Store a newly created section in storage.
     */
    public function store(Request $request, Course $course)
    {
        // Ensure instructor owns this course
        $this->authorize('update', $course);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        
        // Get max order for the course sections
        $maxOrder = $course->sections()->max('order') ?? 0;
        
        // Create section
        $section = $course->sections()->create([
            'title' => $validated['title'],
            'order' => $maxOrder + 1,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Section created successfully!',
            'section' => $section,
        ]);
    }

    /**
     * Update the specified section in storage.
     */
    public function update(Request $request, Course $course, Section $section)
    {
        // Ensure instructor owns this course
        $this->authorize('update', $course);
        
        // Ensure section belongs to this course
        if ($section->course_id !== $course->id) {
            return response()->json([
                'success' => false,
                'message' => 'Section does not belong to this course.',
            ], 403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        
        // Update section
        $section->update([
            'title' => $validated['title'],
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Section updated successfully!',
            'section' => $section,
        ]);
    }

    /**
     * Remove the specified section from storage.
     */
    public function destroy(Course $course, Section $section)
    {
        // Ensure instructor owns this course
        $this->authorize('update', $course);
        
        // Ensure section belongs to this course
        if ($section->course_id !== $course->id) {
            return response()->json([
                'success' => false,
                'message' => 'Section does not belong to this course.',
            ], 403);
        }
        
        // Delete section (lessons will be cascaded due to foreign key constraints)
        $section->delete();
        
        // Reorder remaining sections
        $remainingSections = $course->sections()->orderBy('order')->get();
        foreach ($remainingSections as $index => $remainingSection) {
            $remainingSection->update(['order' => $index + 1]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Section deleted successfully!',
        ]);
    }
} 