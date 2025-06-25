<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Submission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $this->authorize('update', $course);
        
        $assignments = $course->assignments()->latest()->paginate(10);
        
        return view('instructor.assignments.index', compact('course', 'assignments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        $this->authorize('update', $course);
        
        return view('instructor.assignments.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        $this->authorize('update', $course);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'nullable|date',
            'max_score' => 'required|integer|min:0|max:100',
            'max_attempts' => 'required|integer|min:1',
            'is_active' => 'sometimes|boolean',
            'allow_late_submission' => 'sometimes|boolean',
            'allowed_file_types' => 'required|array',
            'allowed_file_types.*' => 'required|string|in:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar,jpg,jpeg,png,gif',
            'max_file_size' => 'required|integer|min:1|max:50',
        ]);
        
        // Format allowed file types as array
        $allowedTypes = $validated['allowed_file_types'];
        
        // Convert deadline to Carbon instance if provided
        if (isset($validated['deadline'])) {
            $validated['deadline'] = Carbon::parse($validated['deadline']);
        }
        
        // Create the assignment
        $assignment = $course->assignments()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'deadline' => $validated['deadline'] ?? null,
            'max_score' => $validated['max_score'],
            'max_attempts' => $validated['max_attempts'],
            'is_active' => $request->has('is_active'),
            'allow_late_submission' => $request->has('allow_late_submission'),
            'allowed_file_types' => $allowedTypes,
            'max_file_size' => $validated['max_file_size'],
        ]);
        
        return redirect()->route('instructor.courses.assignments.index', $course)
            ->with('success', 'Assignment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Assignment $assignment)
    {
        $this->authorize('update', $course);
        
        // Get submissions for this assignment
        $submissions = $assignment->submissions()
            ->with(['student'])
            ->latest()
            ->paginate(15);
        
        // Get submission statistics
        $totalSubmissions = $assignment->submissions()->count();
        $submittedCount = $assignment->submissions()->where('status', '!=', 'draft')->count();
        $reviewedCount = $assignment->submissions()->whereIn('status', ['reviewed', 'approved', 'rejected'])->count();
        $needRevisionCount = $assignment->submissions()->where('status', 'need_revision')->count();
        
        return view('instructor.assignments.show', compact(
            'course', 
            'assignment', 
            'submissions', 
            'totalSubmissions', 
            'submittedCount', 
            'reviewedCount', 
            'needRevisionCount'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Assignment $assignment)
    {
        $this->authorize('update', $course);
        
        return view('instructor.assignments.edit', compact('course', 'assignment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Assignment $assignment)
    {
        $this->authorize('update', $course);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'nullable|date',
            'max_score' => 'required|integer|min:0|max:100',
            'max_attempts' => 'required|integer|min:1',
            'is_active' => 'sometimes|boolean',
            'allow_late_submission' => 'sometimes|boolean',
            'allowed_file_types' => 'required|array',
            'allowed_file_types.*' => 'required|string|in:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar,jpg,jpeg,png,gif',
            'max_file_size' => 'required|integer|min:1|max:50',
        ]);
        
        // Format allowed file types as array
        $allowedTypes = $validated['allowed_file_types'];
        
        // Convert deadline to Carbon instance if provided
        if (isset($validated['deadline'])) {
            $validated['deadline'] = Carbon::parse($validated['deadline']);
        }
        
        // Update the assignment
        $assignment->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'deadline' => $validated['deadline'] ?? null,
            'max_score' => $validated['max_score'],
            'max_attempts' => $validated['max_attempts'],
            'is_active' => $request->has('is_active'),
            'allow_late_submission' => $request->has('allow_late_submission'),
            'allowed_file_types' => $allowedTypes,
            'max_file_size' => $validated['max_file_size'],
        ]);
        
        return redirect()->route('instructor.courses.assignments.show', [$course, $assignment])
            ->with('success', 'Assignment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Assignment $assignment)
    {
        $this->authorize('update', $course);
        
        // Check if there are any submissions for this assignment
        $hasSubmissions = $assignment->submissions()->count() > 0;
        
        if ($hasSubmissions) {
            return back()->with('error', 'Cannot delete assignment with submissions.');
        }
        
        $assignment->delete();
        
        return redirect()->route('instructor.courses.assignments.index', $course)
            ->with('success', 'Assignment deleted successfully.');
    }
    
    /**
     * View submission details
     */
    public function viewSubmission(Course $course, Assignment $assignment, Submission $submission)
    {
        $this->authorize('update', $course);
        
        return view('instructor.assignments.submission', compact('course', 'assignment', 'submission'));
    }
    
    /**
     * Grade a submission
     */
    public function gradeSubmission(Request $request, Course $course, Assignment $assignment, Submission $submission)
    {
        $this->authorize('update', $course);
        
        $validated = $request->validate([
            'score' => 'required|integer|min:0|max:' . $assignment->max_score,
            'feedback' => 'required|string',
            'status' => 'required|in:reviewed,need_revision,approved,rejected',
        ]);
        
        $submission->update([
            'score' => $validated['score'],
            'feedback' => $validated['feedback'],
            'status' => $validated['status'],
            'reviewed_at' => now(),
            'reviewed_by' => request()->user()->id,
        ]);
        
        return redirect()->route('instructor.courses.assignments.show', [$course, $assignment])
            ->with('success', 'Submission graded successfully.');
    }
}
