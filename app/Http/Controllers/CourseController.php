<?php
// app/Http/Controllers/CourseController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CourseController extends Controller
{
    /**
     * Display a listing of all published courses
     */
    public function index(Request $request)
    {
        $query = Course::with(['instructor', 'categories'])
            ->where('status', 'published')
            ->when($request->category, function($q) use ($request) {
                return $q->whereHas('categories', function($query) use ($request) {
                    $query->where('categories.id', $request->category);
                });
            })
            ->when($request->level, function($q) use ($request) {
                return $q->where('level', $request->level);
            })
            ->when($request->price, function($q) use ($request) {
                if ($request->price === 'free') {
                    return $q->where('price', 0);
                } elseif ($request->price === 'paid') {
                    return $q->where('price', '>', 0);
                }
            })
            ->when($request->search, function($q) use ($request) {
                return $q->where(function($query) use ($request) {
                    $query->where('title', 'like', "%{$request->search}%")
                        ->orWhere('description', 'like', "%{$request->search}%");
                  });
            });

        // Sort courses
        switch ($request->sort) {
            case 'newest':
                $query->latest();
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'popular':
                $query->withCount('enrollments')->orderBy('enrollments_count', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
        }

        $courses = $query->paginate(12);
        $categories = Category::all();
        $levels = ['beginner', 'intermediate', 'advanced'];
        $prices = ['free', 'paid'];
        $sorts = [
            'newest' => 'Newest',
            'rating' => 'Highest Rated',
            'popular' => 'Most Popular',
            'price_low' => 'Price: Low to High',
            'price_high' => 'Price: High to Low'
        ];

        // Get recommended courses based on user's interests
        $recommendedCourses = null;
        if (Auth::check()) {
            $userInterests = Auth::user()->interests ?? [];
            if (!empty($userInterests)) {
                $recommendedCourses = Course::with(['instructor', 'categories'])
                    ->where('status', 'published')
                    ->whereHas('categories', function($query) use ($userInterests) {
                        $query->whereIn('categories.id', $userInterests);
                    })
                    ->whereNotIn('id', $courses->pluck('id'))
                    ->take(4)
                    ->get();
            }
        }

        return view('courses.index', compact(
            'courses',
            'categories',
            'levels',
            'prices',
            'sorts',
            'recommendedCourses'
        ));
    }

    /**
     * Display the specified course
     */
    public function show(Course $course)
    {
        // Check if course is published or user is the instructor
        if ($course->status !== 'published' && 
            (!Auth::check() || Auth::id() !== $course->user_id)) {
            abort(404);
        }

        $course->load([
            'instructor',
            'categories',
            'sections.lessons' => function ($query) {
                $query->orderBy('order');
            },
            'reviews.user'
        ]);

        // Get course statistics
        $course->loadCount(['enrollments', 'reviews']);
        $course->loadAvg('reviews', 'rating');

        // Check if user is enrolled
        $isEnrolled = Auth::check() ? $course->isEnrolledByUser(Auth::id()) : false;
        $enrollment = $isEnrolled ? $course->getEnrollmentByUser(Auth::id()) : null;

        // Get preview lessons
        $previewLessons = $course->lessons()->where('is_preview', true)->get();

        // Get related courses
        $relatedCourses = Course::published()
            ->where('id', '!=', $course->id)
            ->whereHas('categories', function ($query) use ($course) {
                $query->whereIn('categories.id', $course->categories->pluck('id'));
            })
            ->withCount('enrollments')
            ->withAvg('reviews', 'rating')
            ->take(4)
            ->get();

        // Get reviews with pagination
        $reviews = $course->reviews()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('courses.show', compact(
            'course',
            'isEnrolled',
            'enrollment',
            'previewLessons',
            'relatedCourses',
            'reviews'
        ));
    }

    /**
     * Display courses by category
     */
    public function category(Category $category)
    {
        $courses = Course::published()
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category->id);
            })
            ->with(['instructor', 'categories'])
            ->withCount('enrollments')
            ->withAvg('reviews', 'rating')
            ->latest()
            ->paginate(12);

        return view('courses.category', compact('category', 'courses'));
    }

    /**
     * Display courses by instructor
     */
    public function instructor($id)
    {
        $instructor = \App\Models\User::findOrFail($id);
        
        $courses = Course::published()
            ->where('user_id', $instructor->id)
            ->with(['instructor', 'categories'])
            ->withCount('enrollments')
            ->withAvg('reviews', 'rating')
            ->latest()
            ->paginate(12);

        return view('courses.instructor', compact('instructor', 'courses'));
    }
}