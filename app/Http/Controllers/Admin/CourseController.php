<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Course::with(['instructor', 'categories'])
            ->withCount('enrollments')
            ->withCount('reviews')
            ->withAvg('reviews as average_rating', 'rating');
        
        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by category
        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }
        
        // Filter by instructor
        if ($request->has('instructor') && $request->instructor != 'all') {
            $query->where('user_id', $request->instructor);
        }
        
        // Filter by level
        if ($request->has('level') && $request->level != 'all') {
            $query->where('level', $request->level);
        }
        
        // Filter by price type (free/paid)
        if ($request->has('price_type')) {
            if ($request->price_type === 'free') {
                $query->where('price', 0);
            } elseif ($request->price_type === 'paid') {
                $query->where('price', '>', 0);
            }
        }
        
        // Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Sorting
        $sortField = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        
        if ($sortField === 'rating') {
            $query->orderBy('average_rating', $sortOrder);
        } elseif ($sortField === 'popularity') {
            $query->orderBy('enrollments_count', $sortOrder);
        } elseif ($sortField === 'revenue') {
            $query->orderByRaw('(SELECT COALESCE(SUM(amount_paid), 0) FROM enrollments WHERE course_id = courses.id) ' . $sortOrder);
        } else {
            $query->orderBy($sortField, $sortOrder);
        }
        
        $courses = $query->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $instructors = User::role('instructor')->orderBy('name')->get();
        
        $stats = [
            'total_courses' => Course::count(),
            'published_courses' => Course::where('status', 'published')->count(),
            'draft_courses' => Course::where('status', 'draft')->count(),
            'total_enrollments' => Enrollment::count(),
            'total_revenue' => Enrollment::sum('amount_paid'),
            'total_instructors' => User::role('instructor')->count(),
        ];
        
        return view('admin.courses.index', [
            'courses' => $courses,
            'categories' => $categories,
            'instructors' => $instructors,
            'stats' => $stats,
            'filters' => $request->only(['status', 'category', 'instructor', 'level', 'price_type', 'search', 'sort_by', 'sort_order'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::with([
            'instructor', 
            'categories', 
            'sections.lessons',
            'enrollments.user',
            'reviews.user'
        ])->findOrFail($id);
        
        // Course statistics
        $stats = [
            'total_students' => $course->enrollments->count(),
            'total_revenue' => $course->enrollments->sum('amount_paid'),
            'average_rating' => $course->reviews->avg('rating') ?? 0,
            'total_reviews' => $course->reviews->count(),
            'completion_rate' => $this->calculateCourseCompletionRate($course->id),
            'total_lessons' => $course->lessons->count(),
            'total_duration' => $course->lessons->sum('duration')
        ];
        
        // Recent enrollments
        $recentEnrollments = $course->enrollments()
            ->with('user')
            ->latest('enrolled_at')
            ->take(10)
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
            ->paginate(15);
        
        // Review statistics by rating
        $reviewStats = [
            5 => $course->reviews->where('rating', 5)->count(),
            4 => $course->reviews->where('rating', 4)->count(),
            3 => $course->reviews->where('rating', 3)->count(),
            2 => $course->reviews->where('rating', 2)->count(),
            1 => $course->reviews->where('rating', 1)->count(),
        ];
        
        return view('admin.courses.show', compact('course', 'stats', 'recentEnrollments', 'studentProgress', 'reviewStats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Update course status (approve/reject)
     */
    public function updateStatus(Request $request, string $id)
    {
        $course = Course::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:draft,published,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string',
        ]);
        
        $course->status = $validated['status'];
        if ($validated['status'] === 'rejected' && isset($validated['rejection_reason'])) {
            $course->rejection_reason = $validated['rejection_reason'];
        } else {
            $course->rejection_reason = null;
        }
        
        $course->reviewed_at = now();
        $course->reviewed_by = Auth::id();
        $course->save();
        
        return redirect()->route('admin.courses.show', $course->id)
            ->with('success', 'Course status updated successfully');
    }
    
    /**
     * Show platform-wide course analytics
     */
    public function analytics()
    {
        // General statistics
        $stats = [
            'total_courses' => Course::count(),
            'published_courses' => Course::where('status', 'published')->count(),
            'draft_courses' => Course::where('status', 'draft')->count(),
            'total_enrollments' => Enrollment::count(),
            'total_revenue' => Enrollment::sum('amount_paid'),
            'avg_course_rating' => round(Review::avg('rating') ?? 0, 1),
            'avg_course_price' => round(Course::where('price', '>', 0)->avg('price') ?? 0, 2),
            'free_courses' => Course::where('price', 0)->count(),
            'paid_courses' => Course::where('price', '>', 0)->count(),
        ];
        
        // Courses by level
        $coursesByLevel = DB::table('courses')
            ->select('level', DB::raw('count(*) as count'))
            ->groupBy('level')
            ->get();
        
        // Courses by category
        $coursesByCategory = DB::table('course_categories')
            ->join('categories', 'course_categories.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('count(*) as count'))
            ->groupBy('categories.name')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
        
        // Monthly enrollments data for chart (last 12 months)
        $enrollmentData = $this->getMonthlyEnrollmentData();
        
        // Monthly revenue data for chart (last 12 months)
        $revenueData = $this->getMonthlyRevenueData();
        
        // Top 10 most popular courses
        $popularCourses = Course::withCount('enrollments')
            ->with('instructor')
            ->orderBy('enrollments_count', 'desc')
            ->take(10)
            ->get();
        
        // Top 10 instructors by course count/revenue/students
        $topInstructors = User::role('instructor')
            ->withCount('courses')
            ->withCount(['courses as published_courses_count' => function($query) {
                $query->where('status', 'published');
            }])
            ->withCount(['courses as students_count' => function($query) {
                $query->join('enrollments', 'courses.id', '=', 'enrollments.course_id')
                    ->selectRaw('count(distinct enrollments.user_id)');
            }])
            ->withSum(['courses as total_revenue' => function($query) {
                $query->join('enrollments', 'courses.id', '=', 'enrollments.course_id')
                    ->select(DB::raw('sum(enrollments.amount_paid)'));
            }], 'amount_paid')
            ->orderBy('total_revenue', 'desc')
            ->take(10)
            ->get();
        
        return view('admin.courses.analytics', compact(
            'stats',
            'coursesByLevel', 
            'coursesByCategory', 
            'enrollmentData', 
            'revenueData', 
            'popularCourses', 
            'topInstructors'
        ));
    }
    
    /**
     * Calculate the course completion rate
     */
    private function calculateCourseCompletionRate($courseId)
    {
        $enrollments = Enrollment::where('course_id', $courseId)->get();
        
        if ($enrollments->isEmpty()) {
            return 0;
        }
        
        $completedCount = $enrollments->whereNotNull('completed_at')->count();
        return round(($completedCount / $enrollments->count()) * 100);
    }
    
    /**
     * Get monthly enrollment data for charts
     */
    private function getMonthlyEnrollmentData()
    {
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        $enrollments = Enrollment::select(
                DB::raw('YEAR(enrolled_at) as year'),
                DB::raw('MONTH(enrolled_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('enrolled_at', '>=', $startDate)
            ->where('enrolled_at', '<=', $endDate)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        
        $months = [];
        $values = [];
        
        // Initialize all months with zero values
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            $monthKey = $currentDate->format('Y-m');
            $months[$monthKey] = $currentDate->format('M Y');
            $values[$monthKey] = 0;
            $currentDate->addMonth();
        }
        
        // Fill in actual values
        foreach ($enrollments as $enrollment) {
            $monthKey = sprintf('%d-%02d', $enrollment->year, $enrollment->month);
            $values[$monthKey] = $enrollment->count;
        }
        
        return [
            'labels' => array_values($months),
            'values' => array_values($values)
        ];
    }
    
    /**
     * Get monthly revenue data for charts
     */
    private function getMonthlyRevenueData()
    {
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        $revenue = Enrollment::select(
                DB::raw('YEAR(enrolled_at) as year'),
                DB::raw('MONTH(enrolled_at) as month'),
                DB::raw('SUM(amount_paid) as total')
            )
            ->where('enrolled_at', '>=', $startDate)
            ->where('enrolled_at', '<=', $endDate)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        
        $months = [];
        $values = [];
        
        // Initialize all months with zero values
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            $monthKey = $currentDate->format('Y-m');
            $months[$monthKey] = $currentDate->format('M Y');
            $values[$monthKey] = 0;
            $currentDate->addMonth();
        }
        
        // Fill in actual values
        foreach ($revenue as $entry) {
            $monthKey = sprintf('%d-%02d', $entry->year, $entry->month);
            $values[$monthKey] = (float) $entry->total;
        }
        
        return [
            'labels' => array_values($months),
            'values' => array_values($values)
        ];
    }
}
