{{-- resources/views/instructor/courses/index.blade.php --}}
@extends('layouts.app')

@section('title', ' - My Courses')
@section('meta_description', 'Manage your courses, track performance, and create new content.')

@section('content')
<!-- Course Management Header -->
<section class="relative py-16 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="course-management-pattern" width="20" height="20" patternUnits="userSpaceOnUse">
                    <circle cx="10" cy="10" r="1" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#course-management-pattern)"/>
        </svg>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
    <div class="absolute bottom-10 right-20 w-16 h-16 bg-yellow-400/20 rounded-full animate-float animation-delay-1000"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-white mb-8" data-aos="fade-up">
            <!-- Page Title -->
            <h1 class="text-4xl lg:text-5xl font-bold mb-4">
                Course 
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">Management</span>
            </h1>
            <p class="text-xl text-white/90 mb-8">Create, manage, and track your courses</p>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto">
                <form action="{{ route('instructor.courses.index') }}" method="GET" class="relative">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search your courses..." 
                           class="w-full pl-12 pr-20 py-4 bg-white/20 backdrop-blur-sm border border-white/30 rounded-2xl text-white placeholder-white/70 focus:outline-none focus:ring-4 focus:ring-white/30 focus:border-white/50 transition-all duration-300">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-6 w-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <div class="bg-white text-primary-600 px-6 py-2 rounded-xl hover:bg-gray-100 transition-colors duration-200 font-semibold">
                            Search
                        </div>
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="100">
                <div class="text-3xl font-bold mb-2">{{ $stats['total_courses'] }}</div>
                <div class="text-sm text-white/80">Total Courses</div>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="200">
                <div class="text-3xl font-bold mb-2">{{ $stats['published_courses'] }}</div>
                <div class="text-sm text-white/80">Published</div>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="300">
                <div class="text-3xl font-bold mb-2">{{ $stats['draft_courses'] }}</div>
                <div class="text-sm text-white/80">Drafts</div>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="400">
                <div class="text-3xl font-bold mb-2">{{ number_format($stats['total_students']) }}</div>
                <div class="text-sm text-white/80">Total Students</div>
            </div>
        </div>
    </div>
</section>

<!-- Course Management Content -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Filters and Actions -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8" data-aos="fade-up">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <!-- Filter Tabs -->
                <div class="flex flex-wrap gap-2 mb-4 lg:mb-0">
                    <a href="{{ route('instructor.courses.index', ['status' => 'all', 'search' => request('search'), 'sort' => request('sort')]) }}" 
                       class="px-6 py-3 rounded-xl font-medium transition-all duration-300 {{ request('status', 'all') === 'all' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        All Courses
                    </a>
                    
                    <a href="{{ route('instructor.courses.index', ['status' => 'published', 'search' => request('search'), 'sort' => request('sort')]) }}" 
                       class="px-6 py-3 rounded-xl font-medium transition-all duration-300 {{ request('status') === 'published' ? 'bg-green-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Published
                    </a>
                    
                    <a href="{{ route('instructor.courses.index', ['status' => 'draft', 'search' => request('search'), 'sort' => request('sort')]) }}" 
                       class="px-6 py-3 rounded-xl font-medium transition-all duration-300 {{ request('status') === 'draft' ? 'bg-yellow-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Drafts
                    </a>
                </div>

                <!-- Sort & Create Button -->
                <div class="flex items-center space-x-4">
                    <!-- Sort Dropdown -->
                    <select onchange="window.location.href='{{ route('instructor.courses.index') }}?status={{ request('status') }}&search={{ request('search') }}&sort=' + this.value"
                            class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Highest Rated</option>
                        <option value="revenue" {{ request('sort') === 'revenue' ? 'selected' : '' }}>Highest Revenue</option>
                    </select>

                    <!-- Create Course Button -->
                    <a href="{{ route('instructor.courses.create') }}" 
                       class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create New Course
                    </a>
                </div>
            </div>
        </div>

        <!-- Courses Grid -->
        @if($courses->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($courses as $index => $course)
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-indigo-200 transform hover:-translate-y-2" 
                         data-aos="fade-up" 
                         data-aos-delay="{{ ($index % 6 + 1) * 100 }}">
                        
                        <!-- Course Image -->
                        <div class="relative overflow-hidden">
                            <img src="{{ $course->thumbnail_url }}" 
                                 alt="{{ $course->title }}" 
                                 class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                            
                            <!-- Status Badge -->
                            <div class="absolute top-4 left-4">
                                @if($course->status === 'published')
                                    <span class="inline-flex items-center px-3 py-1 bg-green-500 text-white text-sm font-bold rounded-full shadow-lg">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white text-sm font-bold rounded-full shadow-lg">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Draft
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Quick Stats Overlay -->
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="flex items-center justify-between text-white text-sm">
                                    <span>{{ $course->enrollments_count }} students</span>
                                    <span>{{ number_format($course->reviews_avg_rating ?? 0, 1) }} ⭐</span>
                                    <span>Rp {{ number_format($course->total_revenue, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Course Content -->
                        <div class="p-6">
                            <!-- Course Title -->
                            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors duration-200 line-clamp-2">
                                {{ $course->title }}
                            </h3>

                            <!-- Course Stats -->
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <div class="text-xl font-bold text-gray-900">{{ $course->enrollments_count }}</div>
                                    <div class="text-xs text-gray-600">Students</div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <div class="text-xl font-bold text-green-600">Rp {{ number_format($course->total_revenue / 1000, 0) }}k</div>
                                    <div class="text-xs text-gray-600">Revenue</div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between text-sm mb-1">
                                    <span class="text-gray-600">Completion Rate</span>
                                    <span class="font-semibold text-gray-900">{{ $course->completion_rate }}%</span>
                                </div>
                                <div class="bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2 rounded-full transition-all duration-300" 
                                         style="width: {{ $course->completion_rate }}%"></div>
                                </div>
                            </div>

                            <!-- Course Info -->
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span>{{ $course->total_lessons }} lessons</span>
                                <span>{{ $course->duration_in_hours }}h</span>
                                <span class="capitalize">{{ $course->level }}</span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('instructor.courses.show', $course) }}" 
                                   class="flex-1 text-center bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition-colors duration-200 font-medium">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </a>
                                
                                <a href="{{ route('instructor.courses.edit', $course) }}" 
                                   class="flex-1 text-center bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 transition-colors duration-200 font-medium">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                
                                <!-- Status Toggle -->
                                @if($course->status === 'published')
                                    <form action="{{ route('instructor.courses.unpublish', $course) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="p-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors duration-200"
                                                onclick="return confirm('Are you sure you want to unpublish this course?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('instructor.courses.publish', $course) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="p-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center" data-aos="fade-up">
                {{ $courses->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        @else
            <!-- No Courses State -->
            <div class="text-center py-16" data-aos="fade-up">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    @if(request('search'))
                        No courses found for "{{ request('search') }}"
                    @else
                        No courses yet
                    @endif
                </h3>
                <p class="text-gray-600 mb-8">
                    @if(request('search'))
                        Try adjusting your search terms.
                    @else
                        Start creating your first course and share your knowledge with the world!
                    @endif
                </p>
                <a href="{{ route('instructor.courses.create') }}" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-2xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Create Your First Course
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@push('head')
<style>
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    .animation-delay-1000 {
        animation-delay: 1s;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush