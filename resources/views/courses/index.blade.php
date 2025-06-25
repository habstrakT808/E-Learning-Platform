{{-- resources/views/courses/index.blade.php --}}
@extends('layouts.app')

@section('title', ' - Explore All Courses')
@section('meta_description', 'Browse our comprehensive collection of online courses. Filter by category, level, and price to find the perfect course for your learning journey.')

@section('content')
<!-- Hero Section with Enhanced Design -->
<div class="relative overflow-hidden bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-yellow-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative pt-20 pb-24 lg:pt-28 lg:pb-32">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto text-center">
                <div class="mb-12 mt-8" data-aos="fade-up">
                    <span class="inline-flex items-center px-6 py-3 rounded-full text-sm font-bold bg-purple-100 border border-purple-200 shadow-xl">
                        <svg class="w-4 h-4 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                        <span class="text-purple-800 font-bold">Trusted by 50,000+ Students</span>
                    </span>
            </div>

                <h1 class="text-5xl md:text-7xl font-black mb-8 leading-tight drop-shadow-2xl" data-aos="fade-up" data-aos-delay="100">
                    <span class="text-purple-600">Learn</span> 
                    <span class="text-purple-600">Without</span> 
                    <span class="text-purple-600">Limits</span>
            </h1>

                <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto leading-relaxed font-semibold text-purple-200 drop-shadow-xl" data-aos="fade-up" data-aos-delay="200">
                    Master new skills with our world-class courses. From beginner to expert, we have something for everyone.
                </p>
                
                <!-- Enhanced Search Bar -->
                <div class="max-w-2xl mx-auto mb-12" data-aos="fade-up" data-aos-delay="300">
                <form action="{{ route('courses.index') }}" method="GET" class="relative">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="What do you want to learn today?"
                                   class="w-full px-6 py-4 pr-32 text-gray-900 bg-white/95 backdrop-blur-sm rounded-2xl border-0 shadow-2xl focus:ring-4 focus:ring-purple-300/50 focus:outline-none text-lg placeholder-gray-500 font-medium text-center">
                            <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 px-6 py-2 bg-orange-500 text-white rounded-xl hover:bg-orange-600 transition-all duration-200 font-semibold shadow-lg">
                            Search
                            </button>
                        </div>
                </form>
                </div>
                
                <div class="flex flex-wrap justify-center gap-4 mb-16" data-aos="fade-up" data-aos-delay="400">
                    <a href="#all-courses" class="group relative px-8 py-4 bg-purple-100 text-purple-800 rounded-xl font-semibold transition-all duration-300 hover:transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <span class="relative z-10">Explore Courses</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                    @if(Auth::check())
                        <a href="{{ route('student.dashboard') }}" class="px-8 py-4 bg-purple-200/30 backdrop-blur-sm border-2 border-purple-300/50 text-purple-100 rounded-xl font-semibold transition-all duration-300 hover:bg-purple-200/40 hover:transform hover:scale-105 shadow-lg">
                            My Learning
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-purple-200/30 backdrop-blur-sm border-2 border-purple-300/50 text-purple-100 rounded-xl font-semibold transition-all duration-300 hover:bg-purple-200/40 hover:transform hover:scale-105 shadow-lg">
                            Join Free
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-white py-16 border-b">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center" data-aos="fade-up">
                <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">1,000+</div>
                <div class="text-gray-600">Courses</div>
            </div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">50,000+</div>
                <div class="text-gray-600">Students</div>
            </div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">100+</div>
                <div class="text-gray-600">Instructors</div>
            </div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">4.8★</div>
                <div class="text-gray-600">Average Rating</div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Category Badges -->
<div class="bg-gradient-to-r from-gray-50 to-gray-100 py-8 sticky top-0 z-40 backdrop-blur-lg border-b">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Browse by Category</h3>
            <button id="toggleFilters" class="lg:hidden flex items-center px-4 py-2 bg-white rounded-lg shadow-sm border">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                </svg>
                Filters
            </button>
        </div>
        
        <div class="flex flex-wrap gap-3 overflow-x-auto pb-2">
            <a href="{{ route('courses.index') }}" 
               class="flex-shrink-0 px-6 py-3 rounded-full text-sm font-medium transition-all duration-200 {{ !request('category') ? 'bg-gradient-to-r from-purple-600 to-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-50 border shadow-sm' }}">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    All Categories
                </span>
            </a>
            @foreach($categories as $category)
                <a href="{{ route('courses.index', ['category' => $category->id]) }}" 
                   class="flex-shrink-0 px-6 py-3 rounded-full text-sm font-medium transition-all duration-200 {{ request('category') == $category->id ? 'bg-gradient-to-r from-purple-600 to-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-50 border shadow-sm' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <!-- Enhanced Filters Panel -->
    <div id="filtersPanel" class="bg-white rounded-2xl shadow-xl mb-12 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Advanced Filters</h2>
                        <p class="text-gray-600 text-sm">Refine your search to find the perfect course</p>
                    </div>
                </div>
                <button class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="p-8">
            <form action="{{ route('courses.index') }}" method="GET" class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Category Filter -->
                    <div class="space-y-2">
                        <label for="category" class="block text-sm font-semibold text-gray-700">Category</label>
                        <div class="relative">
                            <select name="category" id="category" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 appearance-none">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                </div>

                <!-- Level Filter -->
                    <div class="space-y-2">
                        <label for="level" class="block text-sm font-semibold text-gray-700">Difficulty Level</label>
                        <div class="relative">
                            <select name="level" id="level" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 appearance-none">
                        <option value="">All Levels</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                                        {{ ucfirst($level) }}
                                    </option>
                                @endforeach
                    </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                </div>

                <!-- Price Filter -->
                    <div class="space-y-2">
                        <label for="price" class="block text-sm font-semibold text-gray-700">Price Range</label>
                        <div class="relative">
                            <select name="price" id="price" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 appearance-none">
                        <option value="">All Prices</option>
                                @foreach($prices as $price)
                                    <option value="{{ $price }}" {{ request('price') == $price ? 'selected' : '' }}>
                                        {{ ucfirst($price) }}
                                    </option>
                                @endforeach
                    </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                </div>

                    <!-- Sort -->
                    <div class="space-y-2">
                        <label for="sort" class="block text-sm font-semibold text-gray-700">Sort By</label>
                        <div class="relative">
                            <select name="sort" id="sort" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 appearance-none">
                                @foreach($sorts as $value => $label)
                                    <option value="{{ $value }}" {{ request('sort') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                    </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
                    <button type="submit" class="flex-1 sm:flex-none px-8 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-xl font-semibold hover:from-purple-700 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                        Apply Filters
                    </button>
                    <a href="{{ route('courses.index') }}" class="flex-1 sm:flex-none px-8 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-200 text-center">
                        Clear All
                    </a>
                </div>
            </form>
        </div>
        </div>

    <!-- Recommended Courses -->
    @if($recommendedCourses && $recommendedCourses->isNotEmpty())
    <div class="mb-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Recommended For You</h2>
                <p class="text-gray-600">Handpicked courses based on your interests and learning goals</p>
            </div>
            <div class="hidden md:flex items-center space-x-2">
                <button class="p-2 rounded-full bg-white shadow-md hover:shadow-lg transition-shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button class="p-2 rounded-full bg-white shadow-md hover:shadow-lg transition-shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                </button>
                </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($recommendedCourses as $course)
            <div class="group bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="relative overflow-hidden">
                    <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <!-- Level Badge -->
                    <div class="absolute top-4 right-4">
                        @if($course->level === 'beginner')
                            <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">Beginner</span>
                        @elseif($course->level === 'intermediate')
                            <span class="px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-full">Intermediate</span>
                        @else
                            <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full">Advanced</span>
                        @endif
                    </div>
                    
                    <!-- Wishlist Button -->
                    <button class="absolute top-4 left-4 p-2 bg-white/90 backdrop-blur-sm rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-white">
                        <svg class="w-4 h-4 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    
                    <!-- Quick View Button -->
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <a href="{{ route('courses.show', $course) }}" class="px-6 py-2 bg-white text-gray-900 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                            View Course
                        </a>
                    </div>
                </div>
                
                <div class="p-6">
                    <!-- Category & Rating -->
                    <div class="flex items-center justify-between mb-3">
                        @if($course->categories->isNotEmpty())
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-full">
                                {{ $course->categories->first()->name }}
                                </span>
                        @endif
                        <div class="flex items-center text-yellow-500">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-700">{{ number_format($course->average_rating, 1) }}</span>
                        </div>
                            </div>
                            
                    <!-- Title -->
                    <h3 class="font-bold text-lg mb-2 text-gray-900 line-clamp-2 group-hover:text-purple-600 transition-colors">
                        <a href="{{ route('courses.show', $course) }}">{{ $course->title }}</a>
                    </h3>
                    
                    <!-- Description -->
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        {{ \Illuminate\Support\Str::limit($course->description, 100) }}
                    </p>
                    
                    <!-- Course Info -->
                    <div class="flex items-center text-sm text-gray-500 mb-4 space-x-4">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $course->duration_in_hours }}h
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            {{ $course->enrollments_count ?? '0' }}
                                </span>
                            </div>
                            
                    <!-- Footer -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($course->instructor->name) }}&background=random" 
                                 alt="{{ $course->instructor->name }}" 
                                 class="w-8 h-8 rounded-full mr-2">
                            <span class="text-sm text-gray-700 font-medium">{{ $course->instructor->name }}</span>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-gray-900">{{ $course->formatted_price }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- All Courses Section -->
    <div id="all-courses">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">All Courses</h2>
                <p class="text-gray-600">{{ $courses->total() }} courses available</p>
            </div>
            
            <!-- View Toggle -->
            <div class="flex items-center space-x-2 mt-4 md:mt-0">
                <span class="text-sm text-gray-600">View:</span>
                <button id="gridView" class="p-2 rounded-lg bg-purple-100 text-purple-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </button>
                <button id="listView" class="p-2 rounded-lg bg-gray-100 text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                    </svg>
                </button>
            </div>
        </div>
        
        <div id="coursesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-12">
            @foreach($courses as $course)
            <div class="group bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                <div class="relative overflow-hidden">
                    <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                    
                    @if($course->price == 0)
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">FREE</span>
                        </div>
                    @endif
                    
                    <div class="absolute top-4 right-4">
                        @if($course->level === 'beginner')
                            <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">Beginner</span>
                        @elseif($course->level === 'intermediate')
                            <span class="px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-full">Intermediate</span>
                        @else
                            <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full">Advanced</span>
                        @endif
                    </div>
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <button class="absolute top-4 left-4 p-2 bg-white/90 backdrop-blur-sm rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-white" onclick="addToWishlist({{ $course->id }})">
                        <svg class="w-4 h-4 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                        </button>
                    
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <a href="{{ route('courses.show', $course) }}" class="px-6 py-2 bg-white text-gray-900 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                            View Course
                        </a>
                            </div>
                        </div>

                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        @if($course->categories->isNotEmpty())
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-full">
                                {{ $course->categories->first()->name }}
                            </span>
                        @endif
                        <div class="flex items-center text-yellow-500">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-700">{{ number_format($course->average_rating, 1) }}</span>
                                </div>
                            </div>

                    <h3 class="font-bold text-lg mb-2 text-gray-900 line-clamp-2 group-hover:text-purple-600 transition-colors">
                                <a href="{{ route('courses.show', $course) }}">{{ $course->title }}</a>
                            </h3>

                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        {{ \Illuminate\Support\Str::limit($course->description, 100) }}
                    </p>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-4 space-x-4">
                        <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $course->duration_in_hours }}h
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                            {{ $course->enrolled_students_count ?? '0' }}
                        </span>
                            </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($course->instructor->name) }}&background=random" 
                                 alt="{{ $course->instructor->name }}" 
                                 class="w-8 h-8 rounded-full mr-2">
                            <span class="text-sm text-gray-700 font-medium">{{ $course->instructor->name }}</span>
                            </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-gray-900">{{ $course->formatted_price }}</div>
                        </div>
                    </div>
                        </div>
                    </div>
                @endforeach
        </div>

        <!-- Enhanced Pagination -->
        <div class="mt-16">
            {{ $courses->links() }}
        </div>
    </div>
</div>

<!-- Enhanced Features Section -->
<div class="bg-gradient-to-br from-gray-50 via-white to-gray-50 py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Learn With Us?</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Join thousands of students who have transformed their careers through our comprehensive learning platform</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up">
                <div class="relative mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Expert Instructors</h3>
                <p class="text-gray-600 leading-relaxed">Learn from industry veterans with years of real-world experience and proven track records in their fields.</p>
            </div>

            <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                <div class="relative mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Hands-on Projects</h3>
                <p class="text-gray-600 leading-relaxed">Build real-world projects that you can showcase in your portfolio and demonstrate your skills to employers.</p>
            </div>
            
            <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                <div class="relative mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-purple-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Flexible Learning</h3>
                <p class="text-gray-600 leading-relaxed">Study at your own pace with lifetime access to course materials and mobile-friendly content.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('head')
<style>
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
    }
    
    .backdrop-blur-lg {
        backdrop-filter: blur(16px);
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
</style>
@endpush

@push('scripts')
<script>
    // Toggle filters panel
    document.getElementById('toggleFilters').addEventListener('click', function() {
        const panel = document.getElementById('filtersPanel');
        panel.classList.toggle('hidden');
    });
    
    // View toggle functionality
    document.getElementById('gridView').addEventListener('click', function() {
        const grid = document.getElementById('coursesGrid');
        grid.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8';
        this.classList.add('bg-purple-100', 'text-purple-600');
        this.classList.remove('bg-gray-100', 'text-gray-600');
        document.getElementById('listView').classList.add('bg-gray-100', 'text-gray-600');
        document.getElementById('listView').classList.remove('bg-purple-100', 'text-purple-600');
    });
    
    document.getElementById('listView').addEventListener('click', function() {
        const grid = document.getElementById('coursesGrid');
        grid.className = 'space-y-6';
        this.classList.add('bg-purple-100', 'text-purple-600');
        this.classList.remove('bg-gray-100', 'text-gray-600');
        document.getElementById('gridView').classList.add('bg-gray-100', 'text-gray-600');
        document.getElementById('gridView').classList.remove('bg-purple-100', 'text-purple-600');
    });
    
    // Add to wishlist function
    function addToWishlist(courseId) {
        // Add your wishlist functionality here
        showToast('Added to wishlist!', 'success');
    }
    
    // Toast notification function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white font-medium transform transition-all duration-300 translate-x-full ${
            type === 'success' ? 'bg-green-500' : 
            type === 'error' ? 'bg-red-500' : 
            'bg-blue-500'
        }`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
@endpush