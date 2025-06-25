{{-- resources/views/courses/show.blade.php --}}
@extends('layouts.app')

@section('title', " - {$course->title}")
@section('meta_description', $course->description)

@section('content')
<!-- Course Header -->
<section class="relative py-12 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="course-pattern" width="20" height="20" patternUnits="userSpaceOnUse">
                    <path d="M 10,0 L 10,20 M 0,10 L 20,10" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#course-pattern)"/>
        </svg>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-12 items-start">
            <!-- Course Info -->
            <div class="lg:col-span-2" data-aos="fade-right">
                <!-- Breadcrumb -->
                <nav class="flex items-center space-x-2 text-sm text-gray-300 mb-6">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors duration-200">Home</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <a href="{{ route('courses.index') }}" class="hover:text-white transition-colors duration-200">Courses</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-primary-400">{{ $course->title }}</span>
                </nav>

                <!-- Course Categories -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($course->categories as $category)
                        <a href="{{ route('courses.category', $category) }}" 
                           class="inline-flex items-center px-3 py-1 bg-primary-500/20 text-primary-300 rounded-full text-sm font-medium hover:bg-primary-500/30 transition-colors duration-200">
                            <i class="fas {{ $category->icon ?? 'fa-folder' }} mr-2"></i>
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- Course Title -->
                <h1 class="text-4xl lg:text-5xl font-bold mb-4 leading-tight">{{ $course->title }}</h1>

                <!-- Course Description -->
                <p class="text-xl text-gray-300 mb-6 leading-relaxed">{{ $course->description }}</p>

                <!-- Course Stats -->
                <div class="flex flex-wrap items-center gap-6 mb-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-lg font-bold">{{ number_format($course->average_rating, 1) }}</div>
                            <div class="text-sm text-gray-400">Rating</div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-lg font-bold">{{ number_format($course->enrolled_students_count) }}</div>
                            <div class="text-sm text-gray-400">Students</div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-lg font-bold">{{ $course->duration_in_hours }}h</div>
                            <div class="text-sm text-gray-400">Duration</div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-lg font-bold capitalize">{{ $course->level }}</div>
                            <div class="text-sm text-gray-400">Level</div>
                        </div>
                    </div>
                </div>

                <!-- Instructor Info -->
                <div class="flex items-center p-4 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20">
                    <img src="{{ $course->instructor->avatar_url }}" 
                         alt="{{ $course->instructor->name }}" 
                         class="w-16 h-16 rounded-full mr-4">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold">{{ $course->instructor->name }}</h3>
                        <p class="text-gray-300">Course Instructor</p>
                        @if($course->instructor->bio)
                            <p class="text-sm text-gray-400 mt-1">{{ Str::limit($course->instructor->bio, 100) }}</p>
                        @endif
                    </div>
                    <a href="{{ route('courses.instructor', $course->instructor->id) }}" 
                       class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                        View Profile
                    </a>
                </div>
            </div>

            <!-- Course Card -->
            <div class="lg:col-span-1" data-aos="fade-left">
                <div class="sticky top-8">
                    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
                        <!-- Course Image/Video -->
                        <div class="relative">
                            <img src="{{ $course->thumbnail_url }}" 
                                 alt="{{ $course->title }}" 
                                 class="w-full h-48 object-cover">
                            
                            <!-- Play Button -->
                            @if($previewLessons->count() > 0)
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <button onclick="openPreviewModal()" 
                                            class="w-16 h-16 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:scale-110 transition-all duration-300 shadow-2xl group">
                                        <svg class="w-8 h-8 text-primary-600 ml-1 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                        </svg>
                                    </button>
                                </div>
                            @endif

                            <!-- Price Badge -->
                            <div class="absolute top-4 right-4">
                                <span class="inline-flex items-center px-4 py-2 {{ $course->is_free ? 'bg-green-500' : 'bg-primary-600' }} text-white font-bold rounded-full shadow-lg">
                                    {{ $course->formatted_price }}
                                </span>
                            </div>
                        </div>

                        <!-- Course Card Content -->
                        <div class="p-6">
                            <!-- Price -->
                            <div class="text-center mb-6">
                                @if($course->is_free)
                                    <div class="text-3xl font-bold text-green-600 mb-2">Free Course</div>
                                    <p class="text-gray-600">Start learning immediately</p>
                                @else
                                    <div class="text-3xl font-bold text-gray-900 mb-2">{{ $course->formatted_price }}</div>
                                    <p class="text-gray-600">One-time payment • Lifetime access</p>
                                @endif
                            </div>

                            <!-- Enrollment Button -->
                            @auth
                                @if($isEnrolled)
                                    <div class="mb-6">
                                        <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="font-semibold text-green-800">You're enrolled!</span>
                                            </div>
                                            <p class="text-green-700 text-sm mt-1">Progress: {{ $enrollment->progress }}%</p>
                                        </div>
                                        
                                        <a href="{{ route('student.courses.show', $course) }}" 
                                           class="block w-full text-center bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl mb-3">
                                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-9-4V8a3 3 0 116 0v2M7 16a3 3 0 106 0v-2"/>
                                            </svg>
                                            Continue Learning
                                        </a>

                                        <!-- Progress Bar -->
                                        <div class="bg-gray-200 rounded-full h-3 mb-2">
                                            <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full transition-all duration-300" 
                                                 style="width: {{ $enrollment->progress }}%"></div>
                                        </div>
                                        <p class="text-sm text-gray-600 text-center">{{ $enrollment->progress }}% Complete</p>
                                    </div>
                                @else
                                    <form action="{{ route('courses.enroll', $course) }}" method="POST" class="mb-6">
                                        @csrf
                                        <button type="submit" 
                                                class="block w-full text-center bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            {{ $course->is_free ? 'Enroll for Free' : 'Enroll Now' }}
                                        </button>
                                    </form>
                                @endif
                            @else
                                <div class="mb-6">
                                    <a href="{{ route('login') }}" 
                                       class="block w-full text-center bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                        </svg>
                                        Login to Enroll
                                    </a>
                                </div>
                            @endauth

                            <!-- Course Features -->
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $course->total_lessons }} lessons</span>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $course->duration_in_hours }} hours of content</span>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Lifetime access</span>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Certificate of completion</span>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Mobile & desktop access</span>
                                </div>
                            </div>

                            <!-- Share Course -->
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="font-semibold text-gray-900 mb-3">Share this course</h4>
                                <div class="flex space-x-3">
                                    <button onclick="shareOnFacebook()" 
                                            class="flex-1 bg-blue-600 text-white py-2 px-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm font-medium">
                                        Facebook
                                    </button>
                                    <button onclick="shareOnTwitter()" 
                                            class="flex-1 bg-sky-500 text-white py-2 px-3 rounded-lg hover:bg-sky-600 transition-colors duration-200 text-sm font-medium">
                                        Twitter
                                    </button>
                                    <button onclick="copyLink()" 
                                            class="flex-1 bg-gray-600 text-white py-2 px-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 text-sm font-medium">
                                        Copy Link
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Course Content Tabs -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 mb-8" data-aos="fade-up">
            <nav class="-mb-px flex space-x-8" x-data="{ activeTab: 'overview' }">
                <button @click="activeTab = 'overview'" 
                        :class="{ 'border-primary-500 text-primary-600': activeTab === 'overview', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'overview' }"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    Overview
                </button>
                <button @click="activeTab = 'curriculum'" 
                        :class="{ 'border-primary-500 text-primary-600': activeTab === 'curriculum', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'curriculum' }"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    Curriculum
                </button>
                <button @click="activeTab = 'instructor'" 
                        :class="{ 'border-primary-500 text-primary-600': activeTab === 'instructor', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'instructor' }"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    Instructor
                </button>
                <button @click="activeTab = 'reviews'" 
                        :class="{ 'border-primary-500 text-primary-600': activeTab === 'reviews', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'reviews' }"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    Reviews ({{ $course->total_reviews }})
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div x-data="{ activeTab: 'overview' }">
            <!-- Overview Tab -->
            <div x-show="activeTab === 'overview'" x-transition class="grid lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <!-- Course Description -->
                    <div class="prose prose-lg max-w-none mb-8" data-aos="fade-up">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">About This Course</h3>
                        <div class="text-gray-700 leading-relaxed">
                            {{ $course->description }}
                        </div>
                    </div>

                    <!-- What You'll Learn -->
                    @if($course->objectives)
                        <div class="mb-8" data-aos="fade-up" data-aos-delay="100">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">What You'll Learn</h3>

                            <div class="grid md:grid-cols-2 gap-4">
                                @php
                                    $objectivesList = is_string($course->objectives) ? json_decode($course->objectives, true) : $course->objectives;
                                    $objectivesList = is_array($objectivesList) ? $objectivesList : [];
                                @endphp
                                
                                @foreach($objectivesList as $objective)
                                    <div class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-gray-700">{{ $objective }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Requirements -->
                    @if($course->requirements)
                        <div class="mb-8" data-aos="fade-up" data-aos-delay="100">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Requirements</h3>
                            
                            <ul class="list-disc pl-5 space-y-2">
                                @php
                                    $requirementsList = is_string($course->requirements) ? json_decode($course->requirements, true) : $course->requirements;
                                    $requirementsList = is_array($requirementsList) ? $requirementsList : [];
                                @endphp
                                
                                @foreach($requirementsList as $requirement)
                                    <li class="text-gray-700">{{ $requirement }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Course Stats Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-50 rounded-2xl p-6" data-aos="fade-up" data-aos-delay="300">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Course Stats</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Students Enrolled</span>
                                <span class="font-semibold text-gray-900">{{ number_format($course->enrolled_students_count) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Total Lessons</span>
                                <span class="font-semibold text-gray-900">{{ $course->total_lessons }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Course Duration</span>
                                <span class="font-semibold text-gray-900">{{ $course->duration_in_hours }} hours</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Skill Level</span>
                                <span class="font-semibold text-gray-900 capitalize">{{ $course->level }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Language</span>
                                <span class="font-semibold text-gray-900">English</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Last Updated</span>
                                <span class="font-semibold text-gray-900">{{ $course->updated_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lanjutan dari course show.blade.php --}}

            <!-- Curriculum Tab -->
            <div x-show="activeTab === 'curriculum'" x-transition>
                <div class="max-w-4xl">
                    <div class="mb-8" data-aos="fade-up">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Course Curriculum</h3>
                        <p class="text-gray-600">{{ $course->sections->count() }} sections • {{ $course->total_lessons }} lessons • {{ $course->duration_in_hours }}h total length</p>
                    </div>

                    <!-- Course Sections -->
                    <div class="space-y-4" data-aos="fade-up" data-aos-delay="100">
                        @foreach($course->sections as $sectionIndex => $section)
                            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                                <!-- Section Header -->
                                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200" 
                                     x-data="{ expanded: {{ $sectionIndex === 0 ? 'true' : 'false' }} }">
                                    <button @click="expanded = !expanded" 
                                            class="w-full flex items-center justify-between text-left">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-primary-100 text-primary-600 rounded-lg flex items-center justify-center mr-4 font-semibold text-sm">
                                                {{ $sectionIndex + 1 }}
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-900">{{ $section->title }}</h4>
                                                <p class="text-sm text-gray-600">
                                                    {{ $section->lessons->count() }} lessons • {{ $section->duration_in_hours }}h
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200" 
                                                 :class="{ 'rotate-180': expanded }" 
                                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </button>
                                </div>

                                <!-- Section Lessons -->
                                <div x-show="expanded" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 -translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="divide-y divide-gray-100">
                                    @foreach($section->lessons as $lessonIndex => $lesson)
                                        <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-200">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center flex-1">
                                                    <!-- Lesson Number -->
                                                    <div class="w-6 h-6 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center mr-4 text-xs font-medium">
                                                        {{ $lessonIndex + 1 }}
                                                    </div>

                                                    <!-- Lesson Info -->
                                                    <div class="flex-1">
                                                        <div class="flex items-center">
                                                            <h5 class="text-gray-900 font-medium mr-3">{{ $lesson->title }}</h5>
                                                            
                                                            <!-- Preview Badge -->
                                                            @if($lesson->is_preview)
                                                                <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                    </svg>
                                                                    Preview
                                                                </span>
                                                            @endif
                                                        </div>
                                                        
                                                        <!-- Lesson Duration -->
                                                        <div class="flex items-center mt-1 text-sm text-gray-500">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            {{ $lesson->formatted_duration }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Lesson Actions -->
                                                <div class="flex items-center space-x-2">
                                                    @if($lesson->is_preview || ($isEnrolled ?? false))
                                                        <a href="{{ route('lessons.show', [$course, $lesson]) }}" 
                                                           class="inline-flex items-center px-3 py-1 bg-primary-100 text-primary-700 rounded-lg hover:bg-primary-200 transition-colors duration-200 text-sm font-medium">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-9-4V8a3 3 0 116 0v2M7 16a3 3 0 106 0v-2"/>
                                                            </svg>
                                                            {{ $lesson->is_preview ? 'Preview' : 'Watch' }}
                                                        </a>
                                                    @else
                                                        <div class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-500 rounded-lg text-sm">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                            </svg>
                                                            Locked
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Instructor Tab -->
            <div x-show="activeTab === 'instructor'" x-transition>
                <div class="max-w-4xl">
                    <div class="bg-gradient-to-r from-primary-50 to-blue-50 rounded-2xl p-8 mb-8" data-aos="fade-up">
                        <div class="flex flex-col md:flex-row items-start md:items-center space-y-6 md:space-y-0 md:space-x-8">
                            <!-- Instructor Avatar -->
                            <div class="flex-shrink-0">
                                <img src="{{ $course->instructor->avatar_url }}" 
                                     alt="{{ $course->instructor->name }}" 
                                     class="w-32 h-32 rounded-full object-cover ring-4 ring-white shadow-lg">
                            </div>

                            <!-- Instructor Info -->
                            <div class="flex-1">
                                <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $course->instructor->name }}</h3>
                                <p class="text-lg text-primary-600 font-medium mb-4">Course Instructor</p>
                                
                                @if($course->instructor->bio)
                                    <p class="text-gray-700 leading-relaxed mb-6">{{ $course->instructor->bio }}</p>
                                @endif

                                <!-- Instructor Stats -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900">{{ $course->instructor->courses()->published()->count() }}</div>
                                        <div class="text-sm text-gray-600">Courses</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900">{{ number_format($course->instructor->total_students) }}</div>
                                        <div class="text-sm text-gray-600">Students</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900">{{ number_format($course->instructor->average_rating, 1) }}</div>
                                        <div class="text-sm text-gray-600">Rating</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900">{{ $course->instructor->reviews()->count() }}</div>
                                        <div class="text-sm text-gray-600">Reviews</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Other Courses by Instructor -->
                    @php
                        $otherCourses = $course->instructor->courses()
                            ->published()
                            ->where('id', '!=', $course->id)
                            ->withCount('enrollments')
                            ->withAvg('reviews', 'rating')
                            ->take(3)
                            ->get();
                    @endphp

                    @if($otherCourses->count() > 0)
                        <div data-aos="fade-up" data-aos-delay="100">
                            <h4 class="text-2xl font-bold text-gray-900 mb-6">More Courses by {{ $course->instructor->name }}</h4>
                            <div class="grid md:grid-cols-3 gap-6">
                                @foreach($otherCourses as $otherCourse)
                                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                                        <div class="relative">
                                            <img src="{{ $otherCourse->thumbnail_url }}" 
                                                 alt="{{ $otherCourse->title }}" 
                                                 class="w-full h-40 object-cover">
                                            <div class="absolute top-3 right-3">
                                                <span class="inline-flex items-center px-2 py-1 {{ $otherCourse->is_free ? 'bg-green-500' : 'bg-primary-600' }} text-white text-xs font-bold rounded-full">
                                                    {{ $otherCourse->formatted_price }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="p-4">
                                            <h5 class="font-bold text-gray-900 mb-2 line-clamp-2">{{ $otherCourse->title }}</h5>
                                            <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                                <span>{{ $otherCourse->enrollments_count }} students</span>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                    {{ number_format($otherCourse->reviews_avg_rating ?? 0, 1) }}
                                                </div>
                                            </div>
                                            <a href="{{ route('courses.show', $otherCourse) }}" 
                                               class="block w-full text-center bg-primary-600 text-white py-2 px-4 rounded-lg hover:bg-primary-700 transition-colors duration-200 text-sm font-medium">
                                                View Course
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reviews Tab -->
            <div x-show="activeTab === 'reviews'" x-transition>
                <div class="max-w-4xl">
                    <!-- Reviews Summary -->
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl p-8 mb-8" data-aos="fade-up">
                        <div class="grid md:grid-cols-2 gap-8 items-center">
                            <!-- Overall Rating -->
                            <div class="text-center md:text-left">
                                <div class="text-6xl font-bold text-gray-900 mb-2">{{ number_format($course->average_rating, 1) }}</div>
                                <div class="flex items-center justify-center md:justify-start mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-6 h-6 {{ $i <= $course->average_rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-gray-600">Based on {{ $course->total_reviews }} reviews</p>
                            </div>

                            <!-- Rating Breakdown -->
                            <div class="space-y-2">
                                @php
                                    $ratingDistribution = \App\Models\Review::getRatingDistribution($course->id);
                                    $totalReviews = array_sum($ratingDistribution);
                                @endphp
                                
                                @for($i = 5; $i >= 1; $i--)
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-600 w-8">{{ $i }}★</span>
                                        <div class="flex-1 mx-3">
                                            <div class="bg-gray-200 rounded-full h-2">
                                                <div class="bg-yellow-400 h-2 rounded-full" 
                                                     style="width: {{ $totalReviews > 0 ? ($ratingDistribution[$i] / $totalReviews) * 100 : 0 }}%"></div>
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-600 w-8">{{ $ratingDistribution[$i] }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Individual Reviews -->
                    @if($reviews->count() > 0)
                        <div class="space-y-6" data-aos="fade-up" data-aos-delay="100">
                            @foreach($reviews as $review)
                                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                                    <div class="flex items-start space-x-4">
                                        <!-- User Avatar -->
                                        <img src="{{ $review->user->avatar_url }}" 
                                             alt="{{ $review->user->name }}" 
                                             class="w-12 h-12 rounded-full object-cover">
                                        
                                        <!-- Review Content -->
                                        <div class="flex-1">
                                            <!-- User Info & Rating -->
                                            <div class="flex items-center justify-between mb-2">
                                                <div>
                                                    <h5 class="font-semibold text-gray-900">{{ $review->user->name }}</h5>
                                                    <p class="text-sm text-gray-500">{{ $review->formatted_date }}</p>
                                                </div>
                                                <div class="flex items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            
                                            <!-- Review Text -->
                                            @if($review->comment)
                                                <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Reviews Pagination -->
                        <div class="mt-8 flex justify-center">
                            {{ $reviews->links('pagination::tailwind') }}
                        </div>
                    @else
                        <!-- No Reviews -->
                        <div class="text-center py-12" data-aos="fade-up" data-aos-delay="100">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No reviews yet</h3>
                            <p class="text-gray-600">Be the first to review this course!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Courses -->
@if($relatedCourses->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Related Courses</h2>
                <p class="text-lg text-gray-600">You might also be interested in these courses</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedCourses as $index => $relatedCourse)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" 
                         data-aos="fade-up" 
                         data-aos-delay="{{ ($index + 1) * 100 }}">
                        
                        <div class="relative">
                            <img src="{{ $relatedCourse->thumbnail_url }}" 
                                 alt="{{ $relatedCourse->title }}" 
                                 class="w-full h-40 object-cover">
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center px-2 py-1 {{ $relatedCourse->is_free ? 'bg-green-500' : 'bg-primary-600' }} text-white text-xs font-bold rounded-full">
                                    {{ $relatedCourse->formatted_price }}
                                </span>
                            </div>
                        </div>

                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 mb-2 line-clamp-2">{{ $relatedCourse->title }}</h3>
                            <p class="text-sm text-gray-600 mb-3">{{ $relatedCourse->instructor->name }}</p>
                            
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span>{{ $relatedCourse->enrolled_students_count }} students</span>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    {{ number_format($relatedCourse->average_rating, 1) }}
                                </div>
                            </div>

                            <a href="{{ route('courses.show', $relatedCourse) }}" 
                               class="block w-full text-center bg-primary-600 text-white py-2 px-4 rounded-lg hover:bg-primary-700 transition-colors duration-200 text-sm font-medium">
                                View Course
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- Preview Modal -->
@if($previewLessons->count() > 0)
    <div id="preview-modal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl p-2 max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <button onclick="closePreviewModal()" 
                    class="absolute -top-4 -right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 transition-colors duration-200 z-10">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            <div class="bg-gray-900 rounded-xl overflow-hidden">
                <!-- Preview Lessons List -->
                <div class="p-6 border-b border-gray-700">
                    <h3 class="text-xl font-bold text-white mb-4">Preview Lessons</h3>
                    <div class="space-y-2">
                        @foreach($previewLessons as $previewLesson)
                            <button onclick="loadPreviewLesson('{{ $previewLesson->video_embed_url }}', '{{ $previewLesson->title }}')" 
                                    class="w-full text-left p-3 bg-gray-800 hover:bg-gray-700 rounded-lg transition-colors duration-200 preview-lesson-btn">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-primary-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                    </svg>
                                    <div>
                                        <div class="text-white font-medium">{{ $previewLesson->title }}</div>
                                        <div class="text-gray-400 text-sm">{{ $previewLesson->formatted_duration }}</div>
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
                
                <!-- Video Player -->
                <div class="aspect-video bg-black">
                    <iframe id="preview-video" 
                            src="" 
                            class="w-full h-full" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@push('head')
<style>
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
    // Preview Modal Functions
    function openPreviewModal() {
        document.getElementById('preview-modal').classList.remove('hidden');
        // Load first preview lesson by default
        const firstBtn = document.querySelector('.preview-lesson-btn');
        if (firstBtn) {
            firstBtn.click();
        }
    }

    function closePreviewModal() {
        document.getElementById('preview-modal').classList.add('hidden');
        document.getElementById('preview-video').src = '';
    }

    function loadPreviewLesson(videoUrl, title) {
        document.getElementById('preview-video').src = videoUrl;
        
        // Update active state
        document.querySelectorAll('.preview-lesson-btn').forEach(btn => {
            btn.classList.remove('bg-primary-600');
            btn.classList.add('bg-gray-800');
        });
        event.target.closest('.preview-lesson-btn').classList.add('bg-primary-600');
    }

    // Share Functions
    function shareOnFacebook() {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent(document.title);
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
    }

    function shareOnTwitter() {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent(document.title);
        window.open(`https://twitter.com/intent/tweet?url=${url}&text=${title}`, '_blank', 'width=600,height=400');
    }

    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            showToast('Link copied to clipboard!', 'success');
        });
    }

    // Close modal when clicking outside
    document.getElementById('preview-modal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closePreviewModal();
        }
    });
</script>
@endpush