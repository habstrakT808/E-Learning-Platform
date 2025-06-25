<?php
// app/Http/Controllers/EnrollmentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use App\Models\Course;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Course $course)
    {
        // Check if course can be enrolled
        if (!$course->canBeEnrolled()) {
            return redirect()->back()->with('error', 'This course is not available for enrollment.');
        }

        // Check if already enrolled
        if ($course->isEnrolledByUser(Auth::id())) {
            return redirect()->route('student.courses.show', $course)->with('info', 'You are already enrolled in this course.');
        }

        // For paid courses, you would integrate payment gateway here
        // For now, we'll just enroll directly
        
        $enrollment = Auth::user()->enrollInCourse(
            $course->id,
            $course->price,
            $course->is_free ? 'free' : 'manual'
        );

        // Remove activity log for now (we'll add it later)
        // activity()
        //     ->performedOn($course)
        //     ->causedBy(Auth::user())
        //     ->log('enrolled in course');

        if ($course->is_free) {
            return redirect()->route('student.courses.show', $course)
                ->with('success', 'Congratulations! You have successfully enrolled in this free course.');
        } else {
            return redirect()->route('student.courses.show', $course)
                ->with('success', 'Congratulations! You have successfully enrolled in this course.');
        }
    }

    public function destroy(Course $course)
    {
        $enrollment = Auth::user()->getEnrollment($course->id);
        
        if (!$enrollment) {
            return redirect()->back()->with('error', 'You are not enrolled in this course.');
        }

        // Delete related lesson progress
        Auth::user()->lessonProgress()
            ->whereHas('lesson.section', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->delete();

        // Delete enrollment
        $enrollment->delete();

        return redirect()->route('courses.show', $course)
            ->with('success', 'You have been unenrolled from this course.');
    }
}