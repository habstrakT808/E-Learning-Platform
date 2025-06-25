<?php
// app/Http/Controllers/Instructor/CourseController.php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Category;
use App\Models\Section;
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:instructor']);
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'all');
        $sort = $request->get('sort', 'latest');

        $courses = Auth::user()->courses()
            ->with(['categories', 'sections.lessons'])
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            });

        // Sorting
        switch ($sort) {
            case 'popular':
                $courses->orderBy('enrollments_count', 'desc');
                break;
            case 'rating':
                $courses->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'revenue':
                $courses->select('courses.*')
                    ->selectRaw('(SELECT SUM(amount_paid) FROM enrollments WHERE enrollments.course_id = courses.id) as total_revenue')
                    ->orderBy('total_revenue', 'desc');
                break;
            default:
                $courses->latest();
        }

        $courses = $courses->paginate(12);

        // Calculate additional stats for each course
        foreach ($courses as $course) {
            $course->total_revenue = DB::table('enrollments')
                ->where('course_id', $course->id)
                ->sum('amount_paid');
            
            $course->completion_rate = $this->calculateCourseCompletionRate($course->id);
            $course->total_lessons = $course->sections->sum(function ($section) {
                return $section->lessons->count();
            });
        }

        // Overall stats
        $stats = [
            'total_courses' => Auth::user()->courses()->count(),
            'published_courses' => Auth::user()->courses()->published()->count(),
            'draft_courses' => Auth::user()->courses()->draft()->count(),
            'total_students' => DB::table('enrollments')
                ->whereIn('course_id', Auth::user()->courses->pluck('id'))
                ->distinct('user_id')
                ->count('user_id'),
        ];

        return view('instructor.courses.index', compact('courses', 'search', 'status', 'sort', 'stats'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $levels = ['beginner', 'intermediate', 'advanced'];
        return view('instructor.courses.create', compact('categories', 'levels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
            'thumbnail' => 'nullable|image|max:2048',
            'categories' => 'sometimes|array',
            'categories.*' => 'exists:categories,id',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string',
            'objectives' => 'nullable|array',
            'objectives.*' => 'nullable|string',
        ]);

        // Handle requirements and objectives 
        $requirements = $request->input('requirements', []);
        $objectives = $request->input('objectives', []);
        
            // Handle thumbnail upload
        $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            }

            // Create course
            $course = Auth::user()->courses()->create([
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']),
                'description' => $validated['description'],
            'price' => $validated['price'],
                'level' => $validated['level'],
            'thumbnail' => $thumbnailPath,
            'requirements' => $requirements,
            'objectives' => $objectives,
                'status' => 'draft',
            'duration' => 0,
            ]);

        // Attach categories if any
        if ($request->has('categories') && is_array($request->categories)) {
            $course->categories()->attach($request->categories);
        }

            // Create default section
            Section::create([
                'course_id' => $course->id,
                'title' => 'Introduction',
                'order' => 1,
            ]);

        return redirect()->route('instructor.courses.show', $course)
                        ->with('success', 'Course created successfully! Now you can add sections and lessons.');
    }

    public function show(Course $course)
    {
        // Ensure instructor owns this course
        if ($course->user_id !== Auth::id()) {
            abort(403);
        }

        $course->load([
            'sections.lessons',
            'categories',
            'enrollments.user',
            'reviews.user'
        ]);

        // Course statistics
        $stats = [
            'total_students' => $course->enrollments->count(),
            'total_revenue' => $course->enrollments->sum('amount_paid'),
            'average_rating' => $course->reviews->avg('rating') ?? 0,
            'total_reviews' => $course->reviews->count(),
            'completion_rate' => $this->calculateCourseCompletionRate($course->id),
            'total_lessons' => $course->lessons->count(),
        ];

        // Recent enrollments
        $recentEnrollments = $course->enrollments()
            ->with('user')
            ->latest('enrolled_at')
            ->take(5)
            ->get();

        // Student progress
        $studentProgress = DB::table('enrollments')
            ->join('users', 'enrollments.user_id', '=', 'users.id')
            ->where('enrollments.course_id', $course->id)
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.avatar',
                'enrollments.progress',
                'enrollments.enrolled_at',
                'enrollments.completed_at'
            )
            ->orderBy('enrollments.progress', 'desc')
            ->get();

        return view('instructor.courses.show', compact('course', 'stats', 'recentEnrollments', 'studentProgress'));
    }

    public function edit(Course $course)
    {
        // Ensure instructor owns this course
        if ($course->user_id !== Auth::id()) {
            abort(403);
        }

        $course->load(['sections.lessons', 'categories']);
        $categories = Category::orderBy('name')->get();
        $levels = ['beginner', 'intermediate', 'advanced'];

        return view('instructor.courses.edit', compact('course', 'categories', 'levels'));
    }

    public function update(Request $request, Course $course)
    {
        // Ensure instructor owns this course
        if ($course->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
            'thumbnail' => 'nullable|image|max:2048',
            'categories' => 'sometimes|array',
            'categories.*' => 'exists:categories,id',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string',
            'objectives' => 'nullable|array',
            'objectives.*' => 'nullable|string',
        ]);

        // Handle requirements and objectives
        $requirements = $request->input('requirements', []);
        $objectives = $request->input('objectives', []);
        
            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $course->thumbnail = $thumbnailPath;
            }

            // Update course
            $course->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
            'price' => $validated['price'],
                'level' => $validated['level'],
            'requirements' => $requirements,
            'objectives' => $objectives,
            ]);

        // Sync categories if any
        if ($request->has('categories') && is_array($request->categories)) {
            $course->categories()->sync($request->categories);
        } else {
            $course->categories()->detach();
        }

            // Update course duration
            $course->updateDuration();

            return redirect()->route('instructor.courses.show', $course)
                ->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course)
    {
        // Ensure instructor owns this course
        if ($course->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if course has enrollments
        if ($course->enrollments()->exists()) {
            return back()->with('error', 'Cannot delete course with enrolled students.');
        }

        // Delete thumbnail
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();

        return redirect()->route('instructor.courses.index')
            ->with('success', 'Course deleted successfully!');
    }

    public function publish(Course $course)
    {
        // Ensure instructor owns this course
        if ($course->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if course has at least one lesson
        if ($course->lessons->count() === 0) {
            return back()->with('error', 'Course must have at least one lesson before publishing.');
        }

        $course->update(['status' => 'published']);

        return back()->with('success', 'Course published successfully!');
    }

    public function unpublish(Course $course)
    {
        // Ensure instructor owns this course
        if ($course->user_id !== Auth::id()) {
            abort(403);
        }

        $course->update(['status' => 'draft']);

        return back()->with('success', 'Course unpublished successfully!');
    }

    private function calculateCourseCompletionRate($courseId)
    {
        $totalEnrollments = DB::table('enrollments')->where('course_id', $courseId)->count();
        
        if ($totalEnrollments === 0) {
            return 0;
        }

        $completedEnrollments = DB::table('enrollments')
            ->where('course_id', $courseId)
            ->whereNotNull('completed_at')
            ->count();

        return round(($completedEnrollments / $totalEnrollments) * 100, 1);
    }
}