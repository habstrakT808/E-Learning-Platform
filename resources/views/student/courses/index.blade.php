{{-- resources/views/student/courses/index.blade.php --}}
@extends('layouts.app')

@section('title', ' - My Courses')
@section('meta_description', 'Manage your enrolled courses, track progress, and continue your learning journey.')

@section('content')
<!-- Course Management Header -->
<section class="relative py-16 bg-gradient-to-br from-primary-600 via-purple-600 to-blue-600 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="courses-pattern" width="20" height="20" patternUnits="userSpaceOnUse">
                    <circle cx="10" cy="10" r="1" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#courses-pattern)"/>
        </svg>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
    <div class="absolute bottom-10 right-20 w-16 h-16 bg-yellow-400/20 rounded-full animate-float animation-delay-1000"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-white mb-8" data-aos="fade-up">
            <!-- Page Title -->
            <h1 class="text-4xl lg:text-5xl font-bold mb-4">
                My 
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">Learning</span>
                Journey
            </h1>
            <p class="text-xl text-white/90 mb-8">Track your progress and continue learning</p>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto">
                <form action="{{ route('student.courses.index') }}" method="GET" class="relative">
                    <input type="hidden" name="status" value="{{ request('status') }}">
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
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center" data-aos="zoom-in" data-aos-delay="100">
                <div class="text-3xl font-bold mb-2">{{ $stats['total'] }}</div>
                <div class="text-sm text-white/80">Total Courses</div>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center" data-aos="zoom-in" data-aos-delay="200">
                <div class="text-3xl font-bold mb-2">{{ $stats['completed'] }}</div>
                <div class="text-sm text-white/80">Completed</div>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center" data-aos="zoom-in" data-aos-delay="300">
                <div class="text-3xl font-bold mb-2">{{ $stats['in_progress'] }}</div>
                <div class="text-sm text-white/80">In Progress</div>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center" data-aos="zoom-in" data-aos-delay="400">
                <div class="text-3xl font-bold mb-2">{{ $stats['not_started'] }}</div>
                <div class="text-sm text-white/80">Not Started</div>
            </div>
        </div>
    </div>
</section>

<!-- Course Management Content -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Filter Tabs -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8" data-aos="fade-up">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-2 mb-4 lg:mb-0">
                    <a href="{{ route('student.courses.index', ['status' => 'all', 'search' => request('search')]) }}" 
                       class="px-6 py-3 rounded-xl font-medium transition-all duration-300 {{ request('status', 'all') === 'all' ? 'bg-primary-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        All Courses ({{ $stats['total'] }})
                    </a>
                    
                    <a href="{{ route('student.courses.index', ['status' => 'in_progress', 'search' => request('search')]) }}" 
                       class="px-6 py-3 rounded-xl font-medium transition-all duration-300 {{ request('status') === 'in_progress' ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        In Progress ({{ $stats['in_progress'] }})
                    </a>
                    
                    <a href="{{ route('student.courses.index', ['status' => 'completed', 'search' => request('search')]) }}" 
                       class="px-6 py-3 rounded-xl font-medium transition-all duration-300 {{ request('status') === 'completed' ? 'bg-green-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Completed ({{ $stats['completed'] }})
                    </a>
                    
                    <a href="{{ route('student.courses.index', ['status' => 'not_started', 'search' => request('search')]) }}" 
                       class="px-6 py-3 rounded-xl font-medium transition-all duration-300 {{ request('status') === 'not_started' ? 'bg-gray-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Not Started ({{ $stats['not_started'] }})
                    </a>
                </div>

                <!-- View Toggle -->
                <div class="flex items-center space-x-2" x-data="{ view: 'grid' }">
                    <span class="text-sm text-gray-600 mr-3">View:</span>
                    <button @click="view = 'grid'" 
                            :class="view === 'grid' ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-600'"
                            class="p-2 rounded-lg transition-colors duration-200" 
                            onclick="toggleView('grid')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </button>
                    <button @click="view = 'list'" 
                            :class="view === 'list' ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-600'"
                            class="p-2 rounded-lg transition-colors duration-200"
                            onclick="toggleView('list')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Course Grid/List -->
        @if($enrollments->count() > 0)
            <!-- Grid View -->
            <div id="grid-view" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($enrollments as $index => $enrollment)
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-primary-200 transform hover:-translate-y-2 {{ $enrollment->is_overdue ? 'border-red-300' : '' }}" 
                         data-aos="fade-up" 
                         data-aos-delay="{{ ($index % 6 + 1) * 100 }}">
                        
                        <!-- Course Image -->
                        <div class="relative overflow-hidden">
                            <img src="{{ $enrollment->course->thumbnail_url }}" 
                                 alt="{{ $enrollment->course->title }}" 
                                 class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                            
                            <!-- Progress Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <!-- Status Badge -->
                            <div class="absolute top-4 left-4">
                                @if($enrollment->completed_at)
                                    <span class="inline-flex items-center px-3 py-1 bg-green-500 text-white text-sm font-bold rounded-full shadow-lg">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Completed
                                    </span>
                                @elseif($enrollment->progress > 0)
                                    <span class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm font-bold rounded-full shadow-lg">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $enrollment->progress }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 bg-gray-500 text-white text-sm font-bold rounded-full shadow-lg">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Not Started
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Deadline Badge if exists and not completed -->
                            @if($enrollment->deadline && !$enrollment->completed_at)
                                <div class="absolute top-4 right-4">
                                    @if($enrollment->is_overdue)
                                        <span class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm font-bold rounded-full shadow-lg">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                            Overdue
                                        </span>
                                    @elseif($enrollment->days_until_deadline <= 7)
                                        <span class="inline-flex items-center px-3 py-1 bg-amber-500 text-white text-sm font-bold rounded-full shadow-lg">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $enrollment->days_until_deadline }} days left
                                        </span>
                                    @endif
                                </div>
                            @endif
                            
                            <!-- Quick Actions -->
                            <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <a href="{{ route('student.courses.show', $enrollment->course) }}" 
                                   class="w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-colors duration-200 shadow-lg">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-9-4V8a3 3 0 116 0v2M7 16a3 3 0 106 0v-2"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Course Content -->
                        <div class="p-6">
                            <!-- Instructor -->
                            <div class="flex items-center mb-3">
                                <img src="{{ $enrollment->course->instructor->avatar_url }}" 
                                     alt="{{ $enrollment->course->instructor->name }}" 
                                     class="w-8 h-8 rounded-full mr-3">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $enrollment->course->instructor->name }}</div>
                                    <div class="text-xs text-gray-500">Instructor</div>
                                </div>
                            </div>

                            <!-- Course Title -->
                            <h3 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors duration-200 line-clamp-2">
                                <a href="{{ route('student.courses.show', $enrollment->course) }}">
                                    {{ $enrollment->course->title }}
                                </a>
                            </h3>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between text-sm mb-2">
                                    <span class="text-gray-600">Progress</span>
                                    <span class="font-semibold text-gray-900">{{ $enrollment->progress }}%</span>
                                </div>
                                <div class="bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r {{ $enrollment->is_overdue ? 'from-red-500 to-red-600' : 'from-primary-500 to-primary-600' }} h-3 rounded-full transition-all duration-300" 
                                         style="width: {{ $enrollment->progress }}%"></div>
                                </div>
                            </div>

                            <!-- Course Stats -->
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    {{ $enrollment->course->total_lessons }} lessons
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $enrollment->course->duration_in_hours }}h
                                </div>
                                <div class="text-xs text-gray-400">
                                    Enrolled {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->diffForHumans() : 'Recently' }}
                                </div>
                            </div>
                            
                            <!-- Deadline Info (if applicable) -->
                            @if($enrollment->deadline && !$enrollment->completed_at)
                                <div class="mb-4 p-2 rounded-lg {{ $enrollment->is_overdue ? 'bg-red-50 border border-red-200' : ($enrollment->days_until_deadline <= 7 ? 'bg-amber-50 border border-amber-200' : 'bg-blue-50 border border-blue-200') }}">
                                    <div class="flex items-center text-sm">
                                        <svg class="w-4 h-4 mr-1.5 {{ $enrollment->is_overdue ? 'text-red-500' : ($enrollment->days_until_deadline <= 7 ? 'text-amber-500' : 'text-blue-500') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="{{ $enrollment->is_overdue ? 'text-red-600 font-medium' : ($enrollment->days_until_deadline <= 7 ? 'text-amber-600 font-medium' : 'text-blue-600') }}">
                                            @if($enrollment->is_overdue)
                                                Deadline passed: {{ $enrollment->formatted_deadline }}
                                            @elseif($enrollment->days_until_deadline <= 7)
                                                Deadline soon: {{ $enrollment->formatted_deadline }}
                                            @else
                                                Deadline: {{ $enrollment->formatted_deadline }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endif

                            <!-- Action Button -->
                            <a href="{{ route('student.courses.show', $enrollment->course) }}" 
                               class="block w-full text-center bg-gradient-to-r {{ $enrollment->is_overdue ? 'from-red-600 to-red-700 hover:from-red-700 hover:to-red-800' : 'from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800' }} text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 transform group-hover:scale-105 hover:shadow-lg">
                                @if($enrollment->completed_at)
                                    <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    View Certificate
                                @elseif($enrollment->progress > 0)
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-9-4V8a3 3 0 116 0v2M7 16a3 3 0 106 0v-2"/>
                                    </svg>
                                    Continue Learning
                                @else
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-9-4V8a3 3 0 116 0v2M7 16a3 3 0 106 0v-2"/>
                                    </svg>
                                    Start Learning
                                @endif
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- List View (Hidden by default) -->
            <div id="list-view" class="hidden space-y-4 mb-8">
                @foreach($enrollments as $index => $enrollment)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-primary-200 {{ $enrollment->is_overdue ? 'border-red-300' : '' }}" 
                         data-aos="fade-up" 
                         data-aos-delay="{{ ($index % 4 + 1) * 100 }}">
                        <div class="flex items-center p-6">
                            <!-- Course Image -->
                            <div class="flex-shrink-0 mr-6">
                                <div class="relative">
                                    <img src="{{ $enrollment->course->thumbnail_url }}" 
                                         alt="{{ $enrollment->course->title }}" 
                                         class="w-24 h-24 rounded-xl object-cover">
                                     
                                    @if($enrollment->deadline && !$enrollment->completed_at && ($enrollment->is_overdue || $enrollment->days_until_deadline <= 7))
                                        <div class="absolute -top-2 -right-2">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full {{ $enrollment->is_overdue ? 'bg-red-500' : 'bg-amber-500' }} text-white text-xs shadow-lg">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Course Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <!-- Title & Instructor -->
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-primary-600 transition-colors duration-200">
                                            <a href="{{ route('student.courses.show', $enrollment->course) }}">
                                                {{ $enrollment->course->title }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 mb-3">{{ $enrollment->course->instructor->name }}</p>

                                        <!-- Progress Bar -->
                                        <div class="mb-3">
                                            <div class="flex items-center justify-between text-sm mb-1">
                                                <span class="text-gray-600">Progress</span>
                                                <span class="font-semibold text-gray-900">{{ $enrollment->progress }}%</span>
                                            </div>
                                            <div class="bg-gray-200 rounded-full h-2">
                                                <div class="bg-gradient-to-r {{ $enrollment->is_overdue ? 'from-red-500 to-red-600' : 'from-primary-500 to-primary-600' }} h-2 rounded-full transition-all duration-300" 
                                                     style="width: {{ $enrollment->progress }}%"></div>
                                            </div>
                                        </div>

                                        <!-- Stats & Deadline -->
                                        <div class="flex items-center space-x-6 text-sm text-gray-500">
                                            <span>{{ $enrollment->course->total_lessons }} lessons</span>
                                            <span>{{ $enrollment->course->duration_in_hours }}h total</span>
                                            <span>Enrolled {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->diffForHumans() : 'Recently' }}</span>
                                            
                                            @if($enrollment->deadline && !$enrollment->completed_at)
                                                <span class="inline-flex items-center {{ $enrollment->is_overdue ? 'text-red-600' : ($enrollment->days_until_deadline <= 7 ? 'text-amber-600' : 'text-blue-600') }} font-medium">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    @if($enrollment->is_overdue)
                                                        Deadline passed ({{ $enrollment->formatted_deadline }})
                                                    @elseif($enrollment->days_until_deadline <= 7)
                                                        Due soon: {{ $enrollment->formatted_deadline }} ({{ $enrollment->days_until_deadline }} days)
                                                    @else
                                                        Due: {{ $enrollment->formatted_deadline }}
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Status & Action -->
                                    <div class="flex flex-col items-end space-y-3 ml-6">
                                        <!-- Status Badge -->
                                        @if($enrollment->completed_at)
                                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Completed
                                            </span>
                                        @elseif($enrollment->progress > 0)
                                            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                In Progress
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-800 text-sm font-medium rounded-full">
                                                Not Started
                                            </span>
                                        @endif

                                        <!-- Action Button -->
                                        <a href="{{ route('student.courses.show', $enrollment->course) }}" 
                                           class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700 transition-colors duration-200 font-medium {{ $enrollment->is_overdue ? 'bg-red-600 hover:bg-red-700' : '' }}">
                                            @if($enrollment->completed_at)
                                                View Certificate
                                            @elseif($enrollment->progress > 0)
                                                Continue
                                            @else
                                                Start Learning
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center" data-aos="fade-up">
                {{ $enrollments->appends(request()->query())->links('pagination::tailwind') }}
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
                        @switch(request('status', 'all'))
                            @case('completed')
                                No completed courses yet
                                @break
                            @case('in_progress')
                                No courses in progress
                                @break
                            @case('not_started')
                                No courses waiting to be started
                                @break
                            @default
                                No courses enrolled yet
                        @endswitch
                    @endif
                </h3>
                <p class="text-gray-600 mb-8">
                    @if(request('search'))
                        Try adjusting your search terms or browse all courses.
                    @else
                        Start your learning journey by enrolling in courses that interest you.
                    @endif
                </p>
                <a href="{{ route('courses.index') }}" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-bold rounded-2xl hover:from-primary-700 hover:to-primary-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Browse All Courses
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

@push('scripts')
<script>
    // View Toggle Functionality
    function toggleView(viewType) {
        const gridView = document.getElementById('grid-view');
        const listView = document.getElementById('list-view');
        
        if (viewType === 'grid') {
            gridView.classList.remove('hidden');
            listView.classList.add('hidden');
            localStorage.setItem('courseView', 'grid');
        } else {
            gridView.classList.add('hidden');
            listView.classList.remove('hidden');
            localStorage.setItem('courseView', 'list');
        }
    }

    // Load saved view preference
    document.addEventListener('DOMContentLoaded', function() {
        const savedView = localStorage.getItem('courseView') || 'grid';
        if (savedView === 'list') {
            toggleView('list');
        }
    });
</script>
@endpush