<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        \Log::debug('DashboardController constructor called');
        
        // Save this for error debugging
        $this->middleware(function ($request, $next) {
            \Log::debug('User auth check: ' . (Auth::check() ? 'true' : 'false'));
            
            if (Auth::check()) {
                $user = Auth::user();
                \Log::debug('User: ' . $user->name);
                \Log::debug('User roles: ' . $user->roles->pluck('name')->implode(', '));
            }
            
            return $next($request);
        });
        
        $this->middleware(['auth', 'role:instructor']);
    }

    public function index()
    {
        $instructor = auth()->user();

        // Get total statistics
        $totalStudents = Enrollment::whereHas('course', function($query) use ($instructor) {
            $query->where('user_id', $instructor->id);
        })->distinct('user_id')->count();

        $totalCourses = Course::where('user_id', $instructor->id)->count();

        // Get total revenue from enrollments table instead
        $totalRevenue = Enrollment::whereHas('course', function($query) use ($instructor) {
            $query->where('user_id', $instructor->id);
        })->sum('amount_paid');

        // Get monthly revenue data for the last 6 months from enrollments
        $monthlyRevenue = Enrollment::whereHas('course', function($query) use ($instructor) {
            $query->where('user_id', $instructor->id);
        })
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(amount_paid) as total')
        )
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

        // Get monthly student growth data for the last 6 months
        $monthlyStudents = Enrollment::whereHas('course', function($query) use ($instructor) {
            $query->where('user_id', $instructor->id);
        })
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(DISTINCT user_id) as total')
        )
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

        // Get latest courses
        $latestCourses = Course::where('user_id', $instructor->id)
            ->with(['categories', 'enrollments'])
            ->latest()
            ->take(5)
            ->get();

        // Get recent activities
        $recentActivities = $this->getRecentActivities($instructor);

        // Get top performing courses
        $topCourses = Course::where('user_id', $instructor->id)
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('enrollments_count')
            ->take(5)
            ->get();

        return view('instructor.dashboard.index', compact(
            'totalStudents',
            'totalCourses',
            'totalRevenue',
            'monthlyRevenue',
            'monthlyStudents',
            'latestCourses',
            'recentActivities',
            'topCourses'
        ));
    }

    private function getRecentActivities($instructor)
    {
        $activities = collect();

        // Get recent enrollments
        $recentEnrollments = Enrollment::whereHas('course', function($query) use ($instructor) {
            $query->where('user_id', $instructor->id);
        })
        ->with(['user', 'course'])
        ->latest()
        ->take(5)
        ->get()
        ->map(function($enrollment) {
            return [
                'type' => 'enrollment',
                'message' => "{$enrollment->user->name} enrolled in {$enrollment->course->title}",
                'time' => $enrollment->created_at,
                'icon' => 'user-plus',
                'color' => 'blue'
            ];
        });

        // Get recent reviews
        $recentReviews = DB::table('reviews')
            ->join('courses', 'reviews.course_id', '=', 'courses.id')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->where('courses.user_id', $instructor->id)
            ->select('reviews.*', 'courses.title as course_title', 'users.name as user_name')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($review) {
                return [
                    'type' => 'review',
                    'message' => "{$review->user_name} reviewed {$review->course_title}",
                    'time' => $review->created_at,
                    'icon' => 'star',
                    'color' => 'yellow'
                ];
            });

        // Get recent payments (directly from enrollments)
        $recentPayments = Enrollment::whereHas('course', function($query) use ($instructor) {
            $query->where('user_id', $instructor->id);
        })
        ->where('amount_paid', '>', 0)
        ->with(['user', 'course'])
        ->latest()
        ->take(5)
        ->get()
        ->map(function($enrollment) {
            return [
                'type' => 'payment',
                'message' => "Received payment of $" . number_format($enrollment->amount_paid, 2) . " for {$enrollment->course->title}",
                'time' => $enrollment->created_at,
                'icon' => 'credit-card',
                'color' => 'green'
            ];
        });

        // Combine and sort all activities
        return $activities->concat($recentEnrollments)
            ->concat($recentReviews)
            ->concat($recentPayments)
            ->sortByDesc('time')
            ->take(10);
    }
}