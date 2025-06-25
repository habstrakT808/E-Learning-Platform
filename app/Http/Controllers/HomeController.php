<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        // Featured courses (published courses with high ratings)
        $featuredCourses = Course::published()
            ->withCount('enrollments')
            ->withAvg('reviews', 'rating')
            ->orderBy('enrollments_count', 'desc')
            ->take(6)
            ->get();

        // Latest courses
        $latestCourses = Course::published()
            ->latest()
            ->take(4)
            ->get();

        // Free courses
        $freeCourses = Course::published()
            ->free()
            ->take(4)
            ->get();

        // Categories with course count
        $categories = Category::withCount(['courses' => function ($query) {
            $query->where('status', 'published');
        }])
        ->orderBy('courses_count', 'desc')
        ->take(6)
        ->get();

        // Statistics
        $stats = [
            'total_students' => User::role('student')->count(),
            'total_courses' => Course::published()->count(),
            'total_instructors' => User::role('instructor')->count(),
            'total_enrollments' => \App\Models\Enrollment::count(),
        ];

        // Latest reviews
        $latestReviews = Review::with(['user', 'course'])
            ->whereHas('course', function ($query) {
                $query->where('status', 'published');
            })
            ->latest()
            ->take(3)
            ->get();

        return view('home', compact(
            'featuredCourses',
            'latestCourses', 
            'freeCourses',
            'categories',
            'stats',
            'latestReviews'
        ));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $category = $request->get('category');
        $level = $request->get('level');
        $price = $request->get('price');
        $sort = $request->get('sort', 'latest');

        $courses = Course::published()
            ->with(['instructor', 'categories'])
            ->withCount('enrollments')
            ->withAvg('reviews', 'rating');

        // Search by title or description
        if ($query) {
            $courses->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        }

        // Filter by category
        if ($category) {
            $courses->whereHas('categories', function ($q) use ($category) {
                $q->where('categories.id', $category);
            });
        }

        // Filter by level
        if ($level) {
            $courses->where('level', $level);
        }

        // Filter by price
        switch ($price) {
            case 'free':
                $courses->where('price', 0);
                break;
            case 'paid':
                $courses->where('price', '>', 0);
                break;
            case 'under_100k':
                $courses->where('price', '>', 0)->where('price', '<', 100000);
                break;
            case 'under_500k':
                $courses->where('price', '>', 0)->where('price', '<', 500000);
                break;
        }

        // Sorting
        switch ($sort) {
            case 'popular':
                $courses->orderBy('enrollments_count', 'desc');
                break;
            case 'rating':
                $courses->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'price_low':
                $courses->orderBy('price', 'asc');
                break;
            case 'price_high':
                $courses->orderBy('price', 'desc');
                break;
            default:
                $courses->latest();
        }

        $courses = $courses->paginate(12)->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('courses.search', compact('courses', 'categories', 'query'));
    }
}