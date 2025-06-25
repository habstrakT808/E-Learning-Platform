<?php
// app/Http/Controllers/Student/CourseController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:student']);
    }

    /**
     * Display a listing of student's enrolled courses
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $search = $request->get('search');
        
        $enrollments = Auth::user()->enrollments()
            ->with(['course.instructor', 'course.categories', 'course.sections.lessons'])
            ->when($search, function ($query, $search) {
                $query->whereHas('course', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            });

        switch ($status) {
            case 'completed':
                $enrollments->whereNotNull('completed_at');
                break;
            case 'in_progress':
                $enrollments->whereNull('completed_at')->where('progress', '>', 0);
                break;
            case 'not_started':
                $enrollments->where('progress', 0);
                break;
        }

        $enrollments = $enrollments->latest()->paginate(12);

        // Stats for the page
        $stats = [
            'total' => Auth::user()->enrollments()->count(),
            'completed' => Auth::user()->enrollments()->whereNotNull('completed_at')->count(),
            'in_progress' => Auth::user()->enrollments()->whereNull('completed_at')->where('progress', '>', 0)->count(),
            'not_started' => Auth::user()->enrollments()->where('progress', 0)->count(),
        ];

        return view('student.courses.index', compact('enrollments', 'status', 'search', 'stats'));
    }

    /**
     * Display the specified course for student
     */
    public function show(Course $course)
    {
        $enrollment = $course->getEnrollmentByUser(Auth::id());
        
        if (!$enrollment) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You are not enrolled in this course.');
        }

        $course->load([
            'sections.lessons' => function ($query) {
                $query->orderBy('order');
            },
            'instructor',
            'categories',
            'resources',
            'discussions' => function($query) {
                $query->latest()->limit(10);
            },
            'discussions.user',
            'discussions.replies' => function($query) {
                $query->latest()->limit(3);
            },
            'discussions.replies.user',
            'quizzes' => function($query) {
                $query->where('is_published', true);
            },
            'assignments' => function($query) {
                $query->where('is_active', true)->latest();
            }
        ]);

        // Get lesson progress
        $lessonProgress = Auth::user()->lessonProgress()
            ->whereHas('lesson.section', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->pluck('is_completed', 'lesson_id');

        // Get next lesson to continue
        $nextLesson = $enrollment->getNextLessonToWatch();
        
        // Get last accessed lesson
        $lastLesson = $enrollment->getLastAccessedLesson();

        // Calculate section progress
        $sectionProgress = [];
        foreach ($course->sections as $section) {
            $totalLessons = $section->lessons->count();
            $completedLessons = $section->lessons->filter(function ($lesson) use ($lessonProgress) {
                return isset($lessonProgress[$lesson->id]) && $lessonProgress[$lesson->id];
            })->count();
            
            $sectionProgress[$section->id] = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
        }

        // Get recent activity
        $recentActivity = Auth::user()->lessonProgress()
            ->whereHas('lesson.section', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->with(['lesson.section'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        // Calculate completion stats
        $totalLessons = $course->lessons->count();
        $completedLessons = collect($lessonProgress)->filter()->count();
        $completionPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

        // Get course achievements/milestones
        $achievements = [];
        if ($completionPercentage >= 25) {
            $achievements[] = [
                'title' => 'Getting Started',
                'description' => 'Completed 25% of the course',
                'icon' => 'fa-play',
                'color' => 'blue'
            ];
        }
        if ($completionPercentage >= 50) {
            $achievements[] = [
                'title' => 'Halfway There',
                'description' => 'Completed 50% of the course',
                'icon' => 'fa-star',
                'color' => 'yellow'
            ];
        }
        if ($completionPercentage >= 75) {
            $achievements[] = [
                'title' => 'Almost Done',
                'description' => 'Completed 75% of the course',
                'icon' => 'fa-trophy',
                'color' => 'orange'
            ];
        }
        if ($completionPercentage >= 100) {
            $achievements[] = [
                'title' => 'Course Master',
                'description' => 'Completed the entire course',
                'icon' => 'fa-crown',
                'color' => 'green'
            ];
        }
        
        // Group resources by type
        $groupedResources = $course->resources ? $course->resources->groupBy('type') : collect();

        return view('student.courses.show', compact(
            'course',
            'enrollment',
            'lessonProgress',
            'nextLesson',
            'lastLesson',
            'sectionProgress',
            'recentActivity',
            'totalLessons',
            'completedLessons',
            'completionPercentage',
            'achievements',
            'groupedResources'
        ));
    }
}