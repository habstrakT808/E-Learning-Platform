{{-- resources/views/student/courses/show.blade.php --}}
@extends('layouts.app')

@section('title', " - {$course->title}")
@section('meta_description', "Continue learning {$course->title}. Track your progress and access all course materials.")

@section('content')
<!-- Course Header -->
<section class="relative py-12 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="course-detail-pattern" width="20" height="20" patternUnits="userSpaceOnUse">
                    <path d="M 10,0 L 10,20 M 0,10 L 20,10" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#course-detail-pattern)"/>
        </svg>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-primary-500/20 rounded-full animate-float"></div>
    <div class="absolute bottom-10 right-20 w-16 h-16 bg-yellow-400/20 rounded-full animate-float animation-delay-1000"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-8 items-start">
            <!-- Course Info -->
            <div class="lg:col-span-2" data-aos="fade-right">
                <!-- Breadcrumb -->
                <nav class="flex items-center space-x-2 text-sm text-gray-300 mb-6">
                    <a href="{{ route('student.dashboard') }}" class="hover:text-white transition-colors duration-200">Dashboard</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <a href="{{ route('student.courses.index') }}" class="hover:text-white transition-colors duration-200">My Courses</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-primary-400">{{ $course->title }}</span>
                </nav>

                <!-- Course Title & Status -->
                <div class="flex items-start justify-between mb-6">
                    <div class="flex-1">
                        <h1 class="text-4xl lg:text-5xl font-bold mb-4 leading-tight">{{ $course->title }}</h1>
                        <p class="text-xl text-gray-300 mb-4">{{ $course->description }}</p>
                        
                        <!-- Instructor Info -->
                        <div class="flex items-center">
                            <img src="{{ $course->instructor->avatar_url }}" 
                                 alt="{{ $course->instructor->name }}" 
                                 class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <div class="font-semibold">{{ $course->instructor->name }}</div>
                                <div class="text-gray-400 text-sm">Course Instructor</div>
                            </div>
                        </div>
                    </div>

                    <!-- Enrollment Status Badge -->
                    @if($enrollment->completed_at)
                        <div class="bg-green-500/20 border border-green-500/30 rounded-2xl p-4 text-center backdrop-blur-sm">
                            <svg class="w-8 h-8 text-green-400 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-green-400 font-bold">Completed!</div>
                            <div class="text-green-300 text-sm">{{ $enrollment->completed_at->format('M d, Y') }}</div>
                        </div>
                    @else
                        <div class="bg-blue-500/20 border border-blue-500/30 rounded-2xl p-4 text-center backdrop-blur-sm">
                            <svg class="w-8 h-8 text-blue-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-blue-400 font-bold">{{ $enrollment->progress }}%</div>
                            <div class="text-blue-300 text-sm">In Progress</div>
                        </div>
                    @endif
                </div>

                <!-- Progress Overview -->
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Your Progress</h3>
                    
                    <!-- Main Progress Bar -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-300">Overall Completion</span>
                            <span class="text-sm font-bold">{{ $completionPercentage }}%</span>
                        </div>
                        <div class="bg-gray-700 rounded-full h-4">
                            <div class="bg-gradient-to-r from-primary-500 to-primary-600 h-4 rounded-full transition-all duration-500 relative overflow-hidden" 
                                 style="width: {{ $completionPercentage }}%">
                                <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-primary-400">{{ $completedLessons }}</div>
                            <div class="text-xs text-gray-400">Lessons Completed</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-400">{{ $totalLessons - $completedLessons }}</div>
                            <div class="text-xs text-gray-400">Lessons Remaining</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-400">{{ $enrollment->formatted_learning_time ?? '0h' }}</div>
                            <div class="text-xs text-gray-400">Time Spent</div>
                        </div>
                    </div>
                </div>

                <!-- Achievements -->
                @if(count($achievements) > 0)
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Achievements Unlocked
                        </h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($achievements as $achievement)
                                <div class="bg-{{ $achievement['color'] }}-500/20 border border-{{ $achievement['color'] }}-500/30 rounded-xl p-3 flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-{{ $achievement['color'] }}-500/30 rounded-full flex items-center justify-center">
                                        <i class="fas {{ $achievement['icon'] }} text-{{ $achievement['color'] }}-400"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-{{ $achievement['color'] }}-300">{{ $achievement['title'] }}</div>
                                        <div class="text-xs text-{{ $achievement['color'] }}-400">{{ $achievement['description'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Quick Actions Sidebar -->
            <div class="lg:col-span-1" data-aos="fade-left">
                <div class="sticky top-8 space-y-6">
                    
                    <!-- Continue Learning Card -->
                    @if($nextLesson)
                        <div class="bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl p-6 text-white shadow-2xl">
                            <h3 class="text-lg font-bold mb-4">Continue Learning</h3>
                            <div class="mb-4">
                                <div class="text-sm opacity-90 mb-1">Next Lesson:</div>
                                <div class="font-semibold">{{ $nextLesson->title }}</div>
                                <div class="text-xs opacity-75 mt-1">{{ $nextLesson->section->title }}</div>
                            </div>
                            <a href="{{ route('lessons.show', [$course, $nextLesson]) }}" 
                               class="block w-full bg-white text-primary-600 text-center py-3 px-4 rounded-xl font-bold hover:bg-gray-100 transition-colors duration-200">
                                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                </svg>
                                Continue Learning
                            </a>
                        </div>
                    @elseif($enrollment->completed_at)
                        <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-2xl p-6 text-white shadow-2xl">
                            <h3 class="text-lg font-bold mb-4">Congratulations!</h3>
                            <p class="mb-4">You've completed this course. Download your certificate now!</p>
                            <button class="block w-full bg-white text-green-600 text-center py-3 px-4 rounded-xl font-bold hover:bg-gray-100 transition-colors duration-200">
                                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Download Certificate
                            </button>
                        </div>
                    @else
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                            <h3 class="text-lg font-bold mb-4">Ready to Start?</h3>
                            <p class="text-gray-300 mb-4">Begin your learning journey with the first lesson.</p>
                            @if($course->sections->count() > 0 && $course->sections->first()->lessons->count() > 0)
                                <a href="{{ route('lessons.show', [$course, $course->sections->first()->lessons->first()]) }}" 
                                   class="block w-full bg-primary-600 text-white text-center py-3 px-4 rounded-xl font-bold hover:bg-primary-700 transition-colors duration-200">
                                    <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                    </svg>
                                    Start Learning
                                </a>
                            @else
                                <div class="block w-full bg-gray-600 text-white text-center py-3 px-4 rounded-xl font-bold cursor-not-allowed">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    No Lessons Available
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Quick Stats -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                        <h3 class="text-lg font-bold mb-4">Course Stats</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300">Total Sections</span>
                                <span class="font-semibold">{{ $course->sections->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300">Total Lessons</span>
                                <span class="font-semibold">{{ $totalLessons }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300">Course Duration</span>
                                <span class="font-semibold">{{ $course->duration_in_hours }}h</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300">Enrolled</span>
                                <span class="font-semibold">{{ $enrollment->enrolled_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    @if($recentActivity->count() > 0)
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                            <h3 class="text-lg font-bold mb-4">Recent Activity</h3>
                            <div class="space-y-3">
                                @foreach($recentActivity->take(3) as $activity)
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-primary-500/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                            @if($activity->is_completed)
                                                <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-white truncate">{{ $activity->lesson->title }}</p>
                                            <p class="text-xs text-gray-400">{{ $activity->updated_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Course Curriculum -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Course Content</h2>
            <p class="text-lg text-gray-600 mb-8">{{ $course->sections->count() }} sections • {{ $totalLessons }} lessons • {{ $course->duration_in_hours }}h total</p>
            
            <!-- View All Lessons Button -->
            <a href="{{ route('lessons.index', $course) }}" class="inline-flex items-center mb-6 bg-primary-100 hover:bg-primary-200 text-primary-800 font-medium px-6 py-3 rounded-xl transition-colors shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                View All Lessons
            </a>
            
            <!-- Alpine.js Tab System Initialization -->
            <div x-data="{ tab: 'curriculum' }" class="relative z-10">
                <!-- Tab Navigation -->
                <div class="flex justify-center mb-10">
                    <div class="inline-flex bg-gray-100 rounded-lg p-1.5">
                        <button @click="tab = 'curriculum'" 
                                :class="tab === 'curriculum' ? 'bg-white shadow text-primary-600' : 'text-gray-600 hover:text-gray-900'"
                                class="px-6 py-3 rounded-lg font-medium transition-all duration-200">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Curriculum
                        </button>
                        <button @click="tab = 'assignments'" 
                                :class="tab === 'assignments' ? 'bg-white shadow text-primary-600' : 'text-gray-600 hover:text-gray-900'"
                                class="px-6 py-3 rounded-lg font-medium transition-all duration-200">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Assignments
                        </button>
                        <button @click="tab = 'quizzes'" 
                                :class="tab === 'quizzes' ? 'bg-white shadow text-primary-600' : 'text-gray-600 hover:text-gray-900'"
                                class="px-6 py-3 rounded-lg font-medium transition-all duration-200">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Quizzes
                        </button>
                        <button @click="tab = 'resources'" 
                                :class="tab === 'resources' ? 'bg-white shadow text-primary-600' : 'text-gray-600 hover:text-gray-900'"
                                class="px-6 py-3 rounded-lg font-medium transition-all duration-200">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                            </svg>
                            Resources
                        </button>
                        <button @click="tab = 'discussions'" 
                                :class="tab === 'discussions' ? 'bg-white shadow text-primary-600' : 'text-gray-600 hover:text-gray-900'"
                                class="px-6 py-3 rounded-lg font-medium transition-all duration-200">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Discussions
                        </button>
                    </div>
                </div>

                <!-- Curriculum Tab Content -->
                <div x-show="tab === 'curriculum'" x-cloak class="max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    @foreach($course->sections as $sectionIndex => $section)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 mb-16" 
                             x-data="{ expanded: {{ $sectionIndex === 0 ? 'true' : 'false' }} }">
                            
                            <!-- Section Header -->
                            <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100">
                                <button @click="expanded = !expanded" 
                                        class="w-full flex items-center justify-between text-left group">
                                    <div class="flex items-center flex-1">
                                        <!-- Section Number -->
                                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center mr-4 text-white font-bold shadow-lg group-hover:scale-105 transition-transform duration-200">
                                            {{ $sectionIndex + 1 }}
                                        </div>
                                        
                                        <!-- Section Info -->
                                        <div class="flex-1">
                                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-primary-600 transition-colors duration-200">
                                                {{ $section->title }}
                                            </h3>
                                            <div class="flex items-center space-x-4 text-sm text-gray-600 mt-1">
                                                <span>{{ $section->lessons->count() }} lessons</span>
                                                <span>{{ $section->duration_in_hours }}h</span>
                                                <span class="flex items-center">
                                                    <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                        <div class="bg-primary-500 h-2 rounded-full transition-all duration-300" 
                                                             style="width: {{ $sectionProgress[$section->id] ?? 0 }}%"></div>
                                                    </div>
                                                    {{ $sectionProgress[$section->id] ?? 0 }}%
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Expand Icon -->
                                    <div class="flex items-center space-x-3">
                                        @if(isset($sectionProgress[$section->id]) && $sectionProgress[$section->id] == 100)
                                            <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Completed
                                            </div>
                                        @endif
                                        
                                        <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200 group-hover:text-primary-600" 
                                             :class="{ 'rotate-180': expanded }" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </button>
                            </div>

                            <!-- Section Lessons -->
                            <div x-show="expanded" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="divide-y divide-gray-100">
                                @foreach($section->lessons as $lessonIndex => $lesson)
                                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-200 group">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1">
                                                <!-- Lesson Status -->
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                                    @if(isset($lessonProgress[$lesson->id]) && $lessonProgress[$lesson->id])
                                                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                            </svg>
                                                        </div>
                                                    @else
                                                        <div class="w-8 h-8 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-sm font-medium group-hover:bg-primary-100 group-hover:text-primary-600 transition-colors duration-200">
                                                            {{ $lessonIndex + 1 }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Lesson Info -->
                                                <div class="flex-1">
                                                    <div class="flex items-center">
                                                        <h4 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors duration-200 mr-3">
                                                            {{ $lesson->title }}
                                                        </h4>
                                                        
                                                        @if($lesson->is_preview)
                                                            <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                </svg>
                                                                Preview
                                                            </span>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="flex items-center mt-1 text-sm text-gray-500">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        {{ $lesson->formatted_duration }}
                                                        
                                                        @if($lesson->video_url)
                                                            <span class="mx-2">•</span>
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                                            </svg>
                                                            Video
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Lesson Action -->
                                            <div class="flex items-center space-x-3">
                                                @if(isset($lessonProgress[$lesson->id]) && $lessonProgress[$lesson->id])
                                                    <span class="text-green-600 text-sm font-medium">Completed</span>
                                                @endif
                                                
                                                <a href="{{ route('lessons.show', [$course, $lesson]) }}" 
                                                   class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200 text-sm font-medium opacity-0 group-hover:opacity-100 transform translate-x-4 group-hover:translate-x-0 transition-all duration-200">
                                                    @if(isset($lessonProgress[$lesson->id]) && $lessonProgress[$lesson->id])
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                        </svg>
                                                        Review
                                                    @else
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                                        </svg>
                                                        Watch
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Assignments Tab Content -->
                <div x-show="tab === 'assignments'" x-cloak class="max-w-4xl mx-auto space-y-10" data-aos="fade-up" data-aos-delay="200">
                    @if($course->assignments->count() > 0)
                        <div class="space-y-8">
                            @foreach($course->assignments as $assignment)
                                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:border-primary-200 transition-all duration-300">
                                    <div class="px-6 py-5">
                                        <div class="sm:flex sm:items-center sm:justify-between">
                                            <div class="sm:flex-1">
                                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $assignment->title }}</h3>
                                                <div class="text-sm text-gray-500 mb-4">{{ Str::limit($assignment->description, 120) }}</div>
                                                
                                                <div class="flex flex-wrap gap-4 text-sm">
                                                    <div class="flex items-center">
                                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span>Deadline: {{ $assignment->formatted_deadline }}</span>
                                                    </div>
                                                    
                                                    <div class="flex items-center">
                                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span>Max Score: {{ $assignment->max_score }}</span>
                                                    </div>
                                                    
                                                    <div class="flex items-center">
                                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span>Max Attempts: {{ $assignment->max_attempts }}</span>
                                                    </div>
                                                    
                                                    @php
                                                        $latestSubmission = $assignment->submissions()
                                                                            ->where('user_id', auth()->id())
                                                                            ->latest()
                                                                            ->first();
                                                    @endphp
                                                    
                                                    @if($latestSubmission)
                                                        <div class="flex items-center">
                                                            @if($latestSubmission->status === 'approved')
                                                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                                <span class="text-green-700">Approved ({{ $latestSubmission->score }}/{{ $assignment->max_score }})</span>
                                                            @elseif($latestSubmission->status === 'need_revision')
                                                                <svg class="w-5 h-5 text-amber-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                                </svg>
                                                                <span class="text-amber-700">Needs Revision</span>
                                                            @elseif($latestSubmission->status === 'rejected')
                                                                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                                </svg>
                                                                <span class="text-red-700">Rejected</span>
                                                            @else
                                                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                                </svg>
                                                                <span class="text-blue-700">Submitted</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="mt-4 sm:mt-0 sm:flex-shrink-0">
                                                <a href="{{ route('student.courses.assignments.show', [$course, $assignment]) }}" 
                                                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                     @if($latestSubmission && $latestSubmission->status === 'approved')
                                                         View Submission
                                                     @elseif($latestSubmission)
                                                         View Details
                                                     @else
                                                         Submit Assignment
                                                     @endif
                                                 </a>
                                             </div>
                                         </div>
                                     </div>
                                     
                                     @if($latestSubmission)
                                         <div class="bg-gray-50 px-6 py-3">
                                             <div class="flex flex-col-reverse sm:flex-row sm:justify-between sm:items-center">
                                                 <span class="text-sm text-gray-500 mt-2 sm:mt-0">
                                                     Submission Date: {{ $latestSubmission->created_at->format('M d, Y - H:i') }}
                                                     @if($latestSubmission->is_late)
                                                         <span class="text-red-500 ml-1">(Late)</span>
                                                     @endif
                                                 </span>
                                                 
                                                 <a href="{{ route('student.courses.assignments.show', [$course, $assignment]) }}" class="text-primary-600 text-sm font-medium hover:text-primary-700">
                                                     View submission details
                                                     <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                     </svg>
                                                 </a>
                                             </div>
                                         </div>
                                     @endif
                                 </div>
                             @endforeach
                         </div>
                         
                         <!-- View All Assignments Button -->
                         <div class="flex justify-center mt-8">
                             <a href="{{ route('student.courses.assignments.index', $course) }}" class="text-primary-600 bg-white border border-primary-300 rounded-lg px-6 py-3 font-medium hover:bg-primary-50 transition-colors duration-200">
                                 View All Assignments
                             </a>
                         </div>
                     @else
                         <!-- Empty State for Assignments -->
                         <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
                             <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                 <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                 </svg>
                             </div>
                             <h3 class="text-lg font-bold text-gray-900 mb-2">No Assignments Available</h3>
                             <p class="text-gray-600">This course doesn't have any assignments yet.</p>
                         </div>
                     @endif
                 </div>
                
                <!-- Quizzes Tab Content -->
                <div x-show="tab === 'quizzes'" x-cloak class="max-w-4xl mx-auto space-y-10" data-aos="fade-up" data-aos-delay="200">
                    {{ $course->quizzes->isEmpty() ? 'Tidak ada quiz' : 'Ada ' . $course->quizzes->count() . ' quiz: ' . $course->quizzes->pluck('title')->join(', ') }}
                    @if($course->quizzes->count() > 0)
                        <div class="space-y-8">
                            @foreach($course->quizzes as $quiz)
                                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:border-primary-200 transition-all duration-300">
                                    <div class="px-6 py-5">
                                        <div class="sm:flex sm:items-center sm:justify-between">
                                            <div class="sm:flex-1">
                                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $quiz->title }}</h3>
                                                <div class="text-sm text-gray-500 mb-4">{{ Str::limit($quiz->description, 120) }}</div>
                                                
                                                <div class="flex flex-wrap gap-4 text-sm">
                                                    <div class="flex items-center">
                                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span>{{ $quiz->questions()->count() }} Questions</span>
                                                    </div>
                                                    
                                                    <div class="flex items-center">
                                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span>{{ $quiz->formatted_time_limit }}</span>
                                                    </div>
                                                    
                                                    <div class="flex items-center">
                                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span>Passing: {{ $quiz->passing_score }}%</span>
                                                    </div>
                                                    
                                                    @php
                                                        $bestAttempt = $quiz->getBestAttemptForUser(Auth::id());
                                                    @endphp
                                                    
                                                    @if($bestAttempt)
                                                        <div class="flex items-center">
                                                            @if($bestAttempt->is_passed)
                                                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                                <span class="text-green-700">Passed ({{ $bestAttempt->score }}%)</span>
                                                            @else
                                                                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                                </svg>
                                                                <span class="text-red-700">Failed ({{ $bestAttempt->score }}%)</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="mt-4 sm:mt-0 sm:flex-shrink-0">
                                                <a href="{{ route('quizzes.show', [$course, $quiz]) }}" 
                                                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                    @if($bestAttempt && $bestAttempt->is_passed)
                                                        Review Quiz
                                                    @elseif($bestAttempt)
                                                        Try Again
                                                    @else
                                                        Start Quiz
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($quiz->attempts()->where('user_id', Auth::id())->count() > 0)
                                        <div class="bg-gray-50 px-6 py-3">
                                            <div class="flex flex-col-reverse sm:flex-row sm:justify-between sm:items-center">
                                                <span class="text-sm text-gray-500 mt-2 sm:mt-0">
                                                    {{ $quiz->attempts()->where('user_id', Auth::id())->count() }} attempt(s)
                                                    @if($quiz->max_attempts > 0)
                                                         of {{ $quiz->max_attempts }}
                                                    @endif
                                                </span>
                                                
                                                <a href="{{ route('quizzes.show', [$course, $quiz]) }}" class="text-primary-600 text-sm font-medium hover:text-primary-700">
                                                    View all attempts
                                                    <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State for Quizzes -->
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">No Quizzes Available</h3>
                            <p class="text-gray-600">This course doesn't have any quizzes yet.</p>
                        </div>
                    @endif
                </div>
                
                <!-- Resources Tab Content -->
                <div x-show="tab === 'resources'" x-cloak class="max-w-4xl mx-auto space-y-10" data-aos="fade-up" data-aos-delay="200">
                    @if($groupedResources->count() > 0)
                        <div class="space-y-8">
                            @foreach($groupedResources as $type => $resources)
                                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                                    <!-- Resource Type Header -->
                                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center">
                                        <div class="bg-{{ $type === 'book' ? 'blue' : ($type === 'document' ? 'purple' : ($type === 'video' ? 'red' : 'green')) }}-100 p-2.5 rounded-lg mr-4">
                                            @if($type === 'book')
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                            @elseif($type === 'document')
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            @elseif($type === 'video')
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                            @else
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                            @endif
                                        </div>
                                        <h3 class="text-xl font-bold capitalize">{{ $type }}s</h3>
                                    </div>
                                    
                                    <!-- Resource List -->
                                    <div class="divide-y divide-gray-100">
                                        @foreach($resources as $resource)
                                            <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-200 flex items-center">
                                                <!-- Resource Type Icon -->
                                                <div class="w-12 h-12 bg-{{ $type === 'book' ? 'blue' : ($type === 'document' ? 'purple' : ($type === 'video' ? 'red' : 'green')) }}-50 rounded-lg flex items-center justify-center mr-4">
                                                    @if($type === 'book')
                                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                    @elseif($type === 'document')
                                                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    </svg>
                                                    @elseif($type === 'video')
                                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                    @else
                                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                    </svg>
                                                    @endif
                                                </div>
                                                
                                                <!-- Resource Info -->
                                                <div class="flex-1">
                                                    <h4 class="font-semibold text-gray-900 mb-1">{{ $resource->title }}</h4>
                                                    @if($resource->description)
                                                        <p class="text-sm text-gray-600">{{ $resource->description }}</p>
                                                    @endif
                                                    <div class="flex items-center mt-2 text-xs text-gray-500">
                                                        @if($resource->file_size)
                                                        <span class="flex items-center mr-4">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                            </svg>
                                                            {{ $resource->formatted_file_size }}
                                                        </span>
                                                        @endif
                                                        @if($resource->file_type)
                                                        <span class="uppercase bg-gray-100 px-2 py-1 rounded text-gray-600">
                                                            {{ $resource->file_type }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <!-- Download/View Button -->
                                                <a href="{{ $resource->is_external ? $resource->url : asset('storage/'.$resource->file_path) }}" 
                                                   target="_blank" 
                                                   class="bg-{{ $type === 'book' ? 'blue' : ($type === 'document' ? 'purple' : ($type === 'video' ? 'red' : 'green')) }}-100 text-{{ $type === 'book' ? 'blue' : ($type === 'document' ? 'purple' : ($type === 'video' ? 'red' : 'green')) }}-700 px-4 py-2 rounded-lg font-medium hover:bg-{{ $type === 'book' ? 'blue' : ($type === 'document' ? 'purple' : ($type === 'video' ? 'red' : 'green')) }}-200 transition-colors duration-200 whitespace-nowrap flex items-center">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    {{ $resource->is_external ? 'Open Link' : 'Download' }}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State for Resources -->
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">No Resources Available</h3>
                            <p class="text-gray-600">This course doesn't have any additional resources yet.</p>
                        </div>
                    @endif
                </div>
                
                <!-- Discussions Tab Content -->
                <div x-show="tab === 'discussions'" x-cloak class="max-w-4xl mx-auto space-y-10" data-aos="fade-up" data-aos-delay="200">
                    <!-- New Discussion Button -->
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Course Discussions</h2>
                        <div class="flex justify-end">
                            <a href="{{ route('discussions.create', ['course_id' => $course->id]) }}" class="flex items-center bg-primary-600 text-white px-4 py-3 rounded-lg font-medium hover:bg-primary-700 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Start New Discussion
                            </a>
                        </div>
                    </div>
                    
                    @if($course->discussions->count() > 0)
                        <!-- Discussions List -->
                        <div class="space-y-8">
                            @foreach($course->discussions as $discussion)
                                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 hover:border-primary-200 transition-all duration-300 overflow-hidden">
                                    <div class="px-6 py-6">
                                        <!-- Discussion Header -->
                                        <div class="flex items-start">
                                            <!-- User Avatar -->
                                            <div class="flex-shrink-0 mr-4">
                                                <img src="{{ $discussion->user->avatar_url }}" alt="{{ $discussion->user->name }}" class="w-10 h-10 rounded-full">
                                            </div>
                                            
                                            <!-- Discussion Content -->
                                            <div class="flex-1 min-w-0">
                                                <a href="{{ $discussion->slug ? route('discussions.show', $discussion->slug) : '#' }}" class="block group">
                                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-primary-600 transition-colors duration-200 mb-1">
                                                        @if($discussion->is_pinned)
                                                            <svg class="inline w-4 h-4 text-amber-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.616a1 1 0 01.894-1.79l1.599.8L9 4.323V3a1 1 0 011-1z" />
                                                            </svg>
                                                        @endif
                                                        {{ $discussion->title }}
                                                    </h3>
                                                    <div class="flex items-center text-sm text-gray-500">
                                                        <span class="mr-3">{{ $discussion->user->name }}</span>
                                                        <span class="mr-3">{{ $discussion->created_at ? $discussion->created_at->diffForHumans() : 'Recently' }}</span>
                                                        <span class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                            </svg>
                                                            {{ $discussion->replies_count }} replies
                                                        </span>
                                                    </div>
                                                </a>
                                                
                                                <!-- Preview Content -->
                                                <div class="mt-3">
                                                    <p class="text-gray-600 line-clamp-2">{{ \Illuminate\Support\Str::limit($discussion->content, 150) }}</p>
                                                </div>
                                                
                                                <!-- Recent Replies Preview - Optional -->
                                                @if($discussion->replies->count() > 0)
                                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                                        <div class="flex items-center text-xs text-gray-500 mb-2">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                                            </svg>
                                                            Latest reply:
                                                        </div>
                                                        <div class="flex items-start">
                                                            <div class="flex-shrink-0 mr-3">
                                                                <img src="{{ $discussion->replies->first()->user->avatar_url }}" alt="{{ $discussion->replies->first()->user->name }}" class="w-6 h-6 rounded-full">
                                                            </div>
                                                            <div>
                                                                <div class="text-xs font-medium text-gray-900">{{ $discussion->replies->first()->user->name }}</div>
                                                                <div class="text-xs text-gray-600 line-clamp-1 mt-0.5">{{ \Illuminate\Support\Str::limit($discussion->replies->first()->content, 80) }}</div>
                                                                <div class="text-xs text-gray-400 mt-0.5">{{ $discussion->replies->first()->created_at ? $discussion->replies->first()->created_at->diffForHumans() : 'Recently' }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Discussion Footer -->
                                    <div class="bg-gray-50 px-6 py-3 flex items-center justify-between">
                                        <div class="text-xs text-gray-500">
                                            <span>{{ $discussion->views_count }} views</span>
                                            @if($discussion->last_reply_at)
                                                <span class="mx-2">•</span>
                                                <span>Last reply {{ $discussion->last_reply_at ? $discussion->last_reply_at->diffForHumans() : 'Recently' }}</span>
                                            @endif
                                        </div>
                                        
                                        <!-- View Full Discussion Button -->
                                        <a href="{{ $discussion->slug ? route('discussions.show', $discussion->slug) : '#' }}" target="_self" class="text-primary-600 text-sm font-medium hover:text-primary-700 transition-colors duration-200 flex items-center">
                                            View Discussion
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Load More Button -->
                        @if($course->discussions->count() >= 10)
                            <div class="flex justify-center mt-8">
                                <a href="{{ route('discussions.course', $course) }}" class="text-primary-600 bg-white border border-primary-300 rounded-lg px-6 py-3 font-medium hover:bg-primary-50 transition-colors duration-200">
                                    Load More Discussions
                                </a>
                            </div>
                        @endif
                    @else
                        <!-- Empty State for Discussions -->
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">No Discussions Yet</h3>
                            <p class="text-gray-600 mb-6">Be the first to start a discussion in this course!</p>
                            <a href="{{ route('discussions.create', ['course_id' => $course->id]) }}" class="inline-flex items-center bg-primary-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-700 transition-colors duration-200 shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Start New Discussion
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('head')
<style>
    /* Add x-cloak directive to hide elements with x-cloak during Alpine.js initialization */
    [x-cloak] { 
        display: none !important; 
    }
    
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
</style>
@endpush

@push('scripts')
<script>
    // Auto-expand current section
    document.addEventListener('DOMContentLoaded', function() {
        // Add any JavaScript functionality here
        console.log('Student course detail page loaded');
    });
</script>
@endpush