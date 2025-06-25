<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SubmissionController extends Controller
{
    /**
     * Display assignments for a course
     */
    public function index(Course $course)
    {
        // Check if student is enrolled
        $enrollment = Enrollment::where('user_id', request()->user()->id)
            ->where('course_id', $course->id)
            ->firstOrFail();
        
        // Get active assignments for the course
        $assignments = $course->assignments()
            ->where('is_active', true)
            ->latest()
            ->get();
        
        // Add submission status for each assignment
        $assignments->each(function ($assignment) {
            $assignment->submission_status = $assignment->getSubmissionStatusForUser(request()->user()->id);
        });
        
        return view('student.submissions.index', compact('course', 'assignments'));
    }
    
    /**
     * Display submission form
     */
    public function create(Course $course, Assignment $assignment)
    {
        // Check if student is enrolled
        $enrollment = Enrollment::where('user_id', request()->user()->id)
            ->where('course_id', $course->id)
            ->firstOrFail();
        
        // Check if assignment is active
        if (!$assignment->is_active) {
            return back()->with('error', 'This assignment is not active.');
        }
        
        // Check if deadline has passed and late submissions are not allowed
        if ($assignment->isPastDeadline() && !$assignment->allow_late_submission) {
            return back()->with('error', 'The deadline for this assignment has passed.');
        }
        
        // Get existing submissions for this assignment by the student
        $submissions = $assignment->submissions()
            ->where('user_id', request()->user()->id)
            ->latest()
            ->get();
        
        // Check if max attempts reached
        $attemptCount = $submissions->count();
        if ($attemptCount >= $assignment->max_attempts) {
            return back()->with('error', "You have reached the maximum number of attempts ({$assignment->max_attempts}).");
        }
        
        // Get latest submission if exists
        $latestSubmission = $submissions->first();
        
        return view('student.submissions.create', compact('course', 'assignment', 'latestSubmission', 'attemptCount'));
    }
    
    /**
     * Store a new submission
     */
    public function store(Request $request, Course $course, Assignment $assignment)
    {
        // Check if student is enrolled
        $enrollment = Enrollment::where('user_id', request()->user()->id)
            ->where('course_id', $course->id)
            ->firstOrFail();
        
        // Check if assignment is active
        if (!$assignment->is_active) {
            return back()->with('error', 'This assignment is not active.');
        }
        
        // Check if deadline has passed and late submissions are not allowed
        $isLate = $assignment->isPastDeadline();
        if ($isLate && !$assignment->allow_late_submission) {
            return back()->with('error', 'The deadline for this assignment has passed.');
        }
        
        // Check attempts
        $attemptCount = $assignment->submissions()
            ->where('user_id', request()->user()->id)
            ->count();
        
        if ($attemptCount >= $assignment->max_attempts) {
            return back()->with('error', "You have reached the maximum number of attempts ({$assignment->max_attempts}).");
        }
        
        // Validate request
        $validated = $request->validate([
            'notes' => 'nullable|string',
            'submission_file' => [
                'required',
                'file',
                'max:' . ($assignment->max_file_size * 1024), // Convert to KB
                function ($attribute, $value, $fail) use ($assignment) {
                    $extension = strtolower($value->getClientOriginalExtension());
                    if (!in_array($extension, $assignment->allowed_file_types)) {
                        $fail('The file type is not allowed. Allowed types: ' . implode(', ', $assignment->allowed_file_types));
                    }
                },
            ],
        ]);
        
        // Handle file upload
        $file = $request->file('submission_file');
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;
        $filePath = $file->storeAs('submissions/' . $assignment->id . '/' . request()->user()->id, $fileName);
        
        // Create submission
        $submission = Submission::create([
            'assignment_id' => $assignment->id,
            'user_id' => request()->user()->id,
            'notes' => $validated['notes'] ?? null,
            'file_path' => $filePath,
            'original_filename' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'status' => 'submitted',
            'is_late' => $isLate,
            'attempt_number' => $attemptCount + 1,
        ]);
        
        return redirect()->route('student.courses.assignments.show', [$course, $assignment])
            ->with('success', 'Submission uploaded successfully.');
    }
    
    /**
     * Display submission details
     */
    public function show(Course $course, Assignment $assignment)
    {
        // Check if student is enrolled
        $enrollment = Enrollment::where('user_id', request()->user()->id)
            ->where('course_id', $course->id)
            ->firstOrFail();
        
        // Get all submissions for this assignment by the student
        $submissions = $assignment->submissions()
            ->where('user_id', request()->user()->id)
            ->latest()
            ->get();
        
        // Get the latest submission
        $latestSubmission = $submissions->first();
        
        return view('student.submissions.show', compact('course', 'assignment', 'submissions', 'latestSubmission'));
    }
    
    /**
     * Download submission file
     */
    public function download(Course $course, Assignment $assignment, Submission $submission)
    {
        // Check if student has access to this submission
        if ($submission->user_id !== request()->user()->id && 
            !request()->user()->can('update', $course)) {
            abort(403);
        }
        
        if (!Storage::exists($submission->file_path)) {
            abort(404, 'File not found.');
        }
        
        return Storage::download(
            $submission->file_path, 
            $submission->original_filename
        );
    }
}
