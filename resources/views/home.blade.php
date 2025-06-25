{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', ' - Transform Your Future with Expert-Led Courses')
@section('meta_description', 'Join thousands of learners worldwide. Access premium courses, earn certificates, and advance your career with our expert instructors.')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-primary-50 via-white to-blue-50">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <!-- Animated Background Shapes -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary-200/30 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-purple-200/30 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-200/30 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
        
        <!-- Floating Icons -->
        <div class="absolute top-1/4 left-1/4 animate-float">
            <div class="w-16 h-16 bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl flex items-center justify-center">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>
        
        <div class="absolute top-1/3 right-1/4 animate-float animation-delay-1000">
            <div class="w-12 h-12 bg-white/80 backdrop-blur-sm rounded-xl shadow-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            </div>
        </div>
        
        <div class="absolute bottom-1/3 left-1/3 animate-float animation-delay-2000">
            <div class="w-14 h-14 bg-white/80 backdrop-blur-sm rounded-xl shadow-lg flex items-center justify-center">
                <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="text-center lg:text-left" data-aos="fade-right">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 bg-primary-100 text-primary-800 rounded-full text-sm font-medium mb-6">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    #1 Online Learning Platform
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                    Transform Your
                    <span class="relative">
                        <span class="bg-gradient-to-r from-primary-600 to-purple-600 bg-clip-text text-transparent">Future</span>
                        <svg class="absolute -bottom-2 left-0 w-full h-3 text-primary-200" fill="currentColor" viewBox="0 0 100 10">
                            <path d="M0 8c30-6 70-6 100 0v2H0z"/>
                        </svg>
                    </span>
                    <br>with Expert-Led Courses
                </h1>

                <!-- Subtitle -->
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    Join <span class="font-semibold text-primary-600">{{ number_format($stats['total_students']) }}+</span> learners worldwide. 
                    Access premium courses, earn certificates, and advance your career with industry experts.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 mb-8">
                    <a href="{{ route('courses.index') }}" 
                       class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-2xl shadow-xl hover:shadow-2xl hover:shadow-primary-500/25 transform hover:-translate-y-1 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Start Learning Now
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    
                    <a href="#featured-courses" 
                       class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-2xl shadow-lg hover:shadow-xl border border-gray-200 hover:border-primary-300 transform hover:-translate-y-1 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-9-4V8a3 3 0 116 0v2M7 16a3 3 0 106 0v-2"/>
                        </svg>
                        Explore Courses
                    </a>
                </div>

                <!-- Trust Indicators -->
                <div class="flex flex-wrap items-center gap-6 text-sm text-gray-500">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        No Credit Card Required
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Certified Courses
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-purple-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        30-Day Guarantee
                    </div>
                </div>
            </div>

            <!-- Right Content - Hero Image/Video -->
            <div class="relative" data-aos="fade-left" data-aos-delay="200">
                <div class="relative">
                    <!-- Main Hero Image -->
                    <div class="relative bg-gradient-to-br from-primary-100 to-purple-100 rounded-3xl p-8 shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                             alt="Students Learning" 
                             class="w-full h-80 object-cover rounded-2xl shadow-lg">
                        
                        <!-- Play Button Overlay -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <button class="group w-20 h-20 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-all duration-300"
                                    onclick="document.getElementById('video-modal').classList.remove('hidden')">
                                <svg class="w-8 h-8 text-primary-600 ml-1 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Floating Cards -->
                    <div class="absolute -top-6 -left-6 bg-white rounded-2xl shadow-xl p-4 animate-float">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ number_format($stats['total_courses']) }}+</div>
                                <div class="text-xs text-gray-500">Courses Available</div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-xl p-4 animate-float animation-delay-1000">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ number_format($stats['total_instructors']) }}+</div>
                                <div class="text-xs text-gray-500">Expert Instructors</div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute top-1/2 -left-8 bg-white rounded-2xl shadow-xl p-3 animate-float animation-delay-2000">
                        <div class="flex items-center space-x-2">
                            <div class="flex -space-x-2">
                                <img class="w-8 h-8 rounded-full border-2 border-white" src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=100&h=100&fit=crop&crop=face" alt="">
                                <img class="w-8 h-8 rounded-full border-2 border-white" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face" alt="">
                                <img class="w-8 h-8 rounded-full border-2 border-white" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face" alt="">
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-gray-900">2K+ Reviews</div>
                                <div class="flex items-center">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <a href="#stats" class="flex flex-col items-center text-gray-400 hover:text-primary-600 transition-colors duration-300">
            <span class="text-sm font-medium mb-2">Scroll to explore</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </a>
    </div>
</section>

<!-- Video Modal -->
<div id="video-modal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="relative bg-white rounded-2xl p-2 max-w-4xl w-full">
        <button onclick="document.getElementById('video-modal').classList.add('hidden')" 
                class="absolute -top-4 -right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 transition-colors duration-200">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <div class="aspect-video bg-gray-900 rounded-xl overflow-hidden">
            <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
                    class="w-full h-full" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
            </iframe>
        </div>
    </div>
</div>

<!-- Stats Section -->
<section id="stats" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="relative">
                    <div class="w-20 h-20 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2" data-counter="{{ $stats['total_students'] }}">0</div>
                <div class="text-gray-600 font-medium">Happy Students</div>
            </div>

            <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="relative">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2" data-counter="{{ $stats['total_courses'] }}">0</div>
                <div class="text-gray-600 font-medium">Quality Courses</div>
            </div>

            <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                <div class="relative">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2" data-counter="{{ $stats['total_instructors'] }}">0</div>
                <div class="text-gray-600 font-medium">Expert Instructors</div>
            </div>

            <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                <div class="relative">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2" data-counter="{{ $stats['total_enrollments'] }}">0</div>
                <div class="text-gray-600 font-medium">Course Enrollments</div>
            </div>
        </div>
    </div>
</section>

{{-- Lanjutan dari home.blade.php --}}

<!-- Featured Courses Section -->
<section id="featured-courses" class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-flex items-center px-4 py-2 bg-primary-100 text-primary-800 rounded-full text-sm font-medium mb-4">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Featured Courses
            </div>
            <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                Most Popular 
                <span class="bg-gradient-to-r from-primary-600 to-purple-600 bg-clip-text text-transparent">Courses</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Discover our top-rated courses loved by thousands of students worldwide. 
                Start your learning journey with industry-leading content.
            </p>
        </div>

        <!-- Courses Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($featuredCourses as $index => $course)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-primary-200 transform hover:-translate-y-2" 
                     data-aos="fade-up" 
                     data-aos-delay="{{ ($index + 1) * 100 }}">
                    
                    <!-- Course Image -->
                    <div class="relative overflow-hidden">
                        <img src="{{ $course->thumbnail_url }}" 
                             alt="{{ $course->title }}" 
                             class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Course Level Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ 
                                $course->level === 'beginner' ? 'bg-green-100 text-green-800' : 
                                ($course->level === 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') 
                            }}">
                                {{ ucfirst($course->level) }}
                            </span>
                        </div>
                        
                        <!-- Price Badge -->
                        <div class="absolute top-4 right-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ 
                                $course->is_free ? 'bg-green-500 text-white' : 'bg-primary-500 text-white' 
                            }}">
                                {{ $course->formatted_price }}
                            </span>
                        </div>
                        
                        <!-- Quick View Button -->
                        <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="{{ route('courses.show', $course) }}" 
                               class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-colors duration-200">
                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Course Content -->
                    <div class="p-6">
                        <!-- Instructor -->
                        <div class="flex items-center mb-3">
                            <img src="{{ $course->instructor->avatar_url }}" 
                                 alt="{{ $course->instructor->name }}" 
                                 class="w-8 h-8 rounded-full mr-3">
                            <span class="text-sm text-gray-600">{{ $course->instructor->name }}</span>
                        </div>

                        <!-- Course Title -->
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors duration-200 line-clamp-2">
                            <a href="{{ route('courses.show', $course) }}">{{ $course->title }}</a>
                        </h3>

                        <!-- Course Description -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $course->description }}</p>

                        <!-- Course Stats -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $course->enrolled_students_count }} students
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $course->duration_in_hours }}h
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                {{ number_format($course->average_rating, 1) }}
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($course->categories->take(2) as $category)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('courses.show', $course) }}" 
                           class="block w-full text-center bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                            {{ $course->is_free ? 'Start Learning Free' : 'View Course' }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- View All Button -->
        <div class="text-center" data-aos="fade-up">
            <a href="{{ route('courses.index') }}" 
               class="inline-flex items-center px-8 py-4 bg-white text-primary-600 font-semibold rounded-2xl shadow-lg hover:shadow-xl border-2 border-primary-600 hover:bg-primary-600 hover:text-white transition-all duration-300 transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Explore All {{ number_format($stats['total_courses']) }}+ Courses
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-medium mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Browse Categories
            </div>
            <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                Explore by 
                <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Category</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Find the perfect course for your interests and career goals. 
                Our diverse categories cover everything from technology to creative arts.
            </p>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($categories as $index => $category)
                <div class="group" data-aos="zoom-in" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <a href="{{ route('courses.category', $category) }}" 
                       class="block bg-gradient-to-br from-white to-gray-50 rounded-2xl p-6 shadow-lg hover:shadow-2xl border border-gray-100 hover:border-primary-200 transition-all duration-300 transform hover:-translate-y-3 hover:scale-105">
                        
                        <!-- Icon Container -->
                        <div class="relative mb-4">
                            <div class="w-16 h-16 bg-gradient-to-br {{ 
                                $index % 6 == 0 ? 'from-blue-400 to-blue-600' : 
                                ($index % 6 == 1 ? 'from-green-400 to-green-600' : 
                                ($index % 6 == 2 ? 'from-purple-400 to-purple-600' : 
                                ($index % 6 == 3 ? 'from-pink-400 to-pink-600' : 
                                ($index % 6 == 4 ? 'from-yellow-400 to-yellow-600' : 'from-indigo-400 to-indigo-600'))))
                            }} rounded-xl flex items-center justify-center mx-auto group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <i class="fas {{ $category->icon ?? 'fa-folder' }} text-white text-2xl"></i>
                            </div>
                            
                            <!-- Floating Badge -->
                            <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary-500 text-white rounded-full flex items-center justify-center text-xs font-bold shadow-lg group-hover:scale-110 transition-transform duration-300">
                                {{ $category->courses_count }}
                            </div>
                        </div>

                        <!-- Category Info -->
                        <div class="text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors duration-200">
                                {{ $category->name }}
                            </h3>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $category->description }}</p>
                            <div class="text-xs text-gray-500">
                                {{ $category->courses_count }} {{ Str::plural('course', $category->courses_count) }}
                            </div>
                        </div>

                        <!-- Hover Effect -->
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/5 to-purple-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-20 bg-gradient-to-br from-primary-50 via-white to-purple-50 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="hero-pattern" width="20" height="20" patternUnits="userSpaceOnUse">
                    <circle cx="10" cy="10" r="1" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#hero-pattern)"/>
        </svg>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium mb-4">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Why Choose LearnHub
            </div>
            <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                Learn with 
                <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">Confidence</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Join millions of learners who trust LearnHub for their educational journey. 
                Experience the difference with our innovative learning platform.
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <!-- Feature 1 -->
            <div class="group" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-primary-200 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Interactive Learning</h3>
                    <p class="text-gray-600 mb-4">Engage with hands-on projects, quizzes, and real-world assignments that make learning stick.</p>
                    <div class="flex items-center text-primary-600 font-medium">
                        <span class="mr-2">Learn more</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="group" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-green-200 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Certified Courses</h3>
                    <p class="text-gray-600 mb-4">Earn industry-recognized certificates that boost your career and validate your skills.</p>
                    <div class="flex items-center text-green-600 font-medium">
                        <span class="mr-2">View certificates</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="group" data-aos="fade-up" data-aos-delay="300">
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-purple-200 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Expert Instructors</h3>
                    <p class="text-gray-600 mb-4">Learn from industry professionals with years of real-world experience and proven expertise.</p>
                    <div class="flex items-center text-purple-600 font-medium">
                        <span class="mr-2">Meet instructors</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Feature 4 -->
            <div class="group" data-aos="fade-up" data-aos-delay="400">
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-yellow-200 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Flexible Schedule</h3>
                    <p class="text-gray-600 mb-4">Learn at your own pace with lifetime access to course materials and mobile learning support.</p>
                    <div class="flex items-center text-yellow-600 font-medium">
                        <span class="mr-2">Learn more</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Feature 5 -->
            <div class="group" data-aos="fade-up" data-aos-delay="500">
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-red-200 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Community Support</h3>
                    <p class="text-gray-600 mb-4">Join a vibrant community of learners, get help from peers, and network with professionals.</p>
                    <div class="flex items-center text-red-600 font-medium">
                        <span class="mr-2">Join community</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Feature 6 -->
            <div class="group" data-aos="fade-up" data-aos-delay="600">
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-indigo-200 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Progress Tracking</h3>
                    <p class="text-gray-600 mb-4">Monitor your learning journey with detailed analytics and achievement milestones.</p>
                    <div class="flex items-center text-indigo-600 font-medium">
                        <span class="mr-2">Track progress</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center" data-aos="fade-up">
            <div class="bg-gradient-to-r from-primary-600 to-purple-600 rounded-3xl p-8 md:p-12 shadow-2xl">
                <h3 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Ready to Start Your Journey?
                </h3>
                <p class="text-xl text-primary-100 mb-8 max-w-2xl mx-auto">
                    Join thousands of successful learners who have transformed their careers with LearnHub.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center px-8 py-4 bg-white text-primary-600 font-semibold rounded-2xl hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Get Started Free
                    </a>
                    <a href="{{ route('courses.index') }}" 
                       class="inline-flex items-center px-8 py-4 bg-transparent text-white font-semibold rounded-2xl border-2 border-white hover:bg-white hover:text-primary-600 transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Browse Courses
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Lanjutan dari home.blade.php --}}

<!-- Testimonials Section -->
<section class="py-20 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-blue-500/5 rounded-full blur-3xl animate-pulse delay-2000"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm text-white rounded-full text-sm font-medium mb-4 border border-white/20">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Student Success Stories
            </div>
            <h2 class="text-4xl lg:text-5xl font-bold mb-6">
                What Our 
                <span class="bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">Students Say</span>
            </h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Real stories from real students who transformed their careers and achieved their goals with LearnHub.
            </p>
        </div>

        <!-- Testimonials Slider -->
        <div class="swiper testimonials-swiper mb-12" data-aos="fade-up" data-aos-delay="200">
            <div class="swiper-wrapper">
                @php
                    $testimonials = [
                        [
                            'name' => 'Sarah Johnson',
                            'role' => 'Full Stack Developer',
                            'company' => 'Google',
                            'image' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face',
                            'rating' => 5,
                            'text' => 'LearnHub completely transformed my career! The Laravel course was so comprehensive and practical. Within 6 months, I landed my dream job at Google. The instructors are amazing and the community support is incredible.',
                            'course' => 'Complete Laravel Development'
                        ],
                        [
                            'name' => 'Michael Chen',
                            'role' => 'UI/UX Designer',
                            'company' => 'Apple',
                            'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face',
                            'rating' => 5,
                            'text' => 'The design courses here are top-notch! I went from a complete beginner to designing apps for Apple. The hands-on projects and feedback from instructors made all the difference in my learning journey.',
                            'course' => 'UI/UX Design Masterclass'
                        ],
                        [
                            'name' => 'Emily Rodriguez',
                            'role' => 'Data Scientist',
                            'company' => 'Microsoft',
                            'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face',
                            'rating' => 5,
                            'text' => 'The data science track exceeded my expectations. Real-world projects, industry-standard tools, and amazing mentorship. I\'m now leading AI projects at Microsoft thanks to the solid foundation I got here.',
                            'course' => 'Data Science & Machine Learning'
                        ],
                        [
                            'name' => 'David Kim',
                            'role' => 'DevOps Engineer',
                            'company' => 'Amazon',
                            'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face',
                            'rating' => 5,
                            'text' => 'The practical approach to learning DevOps was exactly what I needed. From Docker to Kubernetes, everything was explained clearly with real-world examples. Now I\'m managing cloud infrastructure at Amazon!',
                            'course' => 'DevOps & Cloud Computing'
                        ],
                        [
                            'name' => 'Lisa Thompson',
                            'role' => 'Product Manager',
                            'company' => 'Meta',
                            'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&h=150&fit=crop&crop=face',
                            'rating' => 5,
                            'text' => 'Transitioning from marketing to product management seemed impossible until I found LearnHub. The courses are structured perfectly and the career guidance helped me land a PM role at Meta within 8 months.',
                            'course' => 'Product Management Essentials'
                        ]
                    ];
                @endphp

                @foreach($testimonials as $testimonial)
                    <div class="swiper-slide">
                        <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 border border-white/20 hover:bg-white/15 transition-all duration-300 h-full">
                            <!-- Quote Icon -->
                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center mb-6">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>

                            <!-- Rating -->
                            <div class="flex items-center mb-4">
                                @for($i = 0; $i < $testimonial['rating']; $i++)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>

                            <!-- Testimonial Text -->
                            <blockquote class="text-lg text-gray-200 mb-6 leading-relaxed">
                                "{{ $testimonial['text'] }}"
                            </blockquote>

                            <!-- Course Badge -->
                            <div class="inline-flex items-center px-3 py-1 bg-primary-500/20 text-primary-300 rounded-full text-sm font-medium mb-6 border border-primary-500/30">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                {{ $testimonial['course'] }}
                            </div>

                            <!-- User Info -->
                            <div class="flex items-center">
                                <img src="{{ $testimonial['image'] }}" 
                                     alt="{{ $testimonial['name'] }}" 
                                     class="w-14 h-14 rounded-full object-cover mr-4 ring-4 ring-white/20">
                                <div>
                                    <h4 class="text-lg font-bold text-white">{{ $testimonial['name'] }}</h4>
                                    <p class="text-gray-300">{{ $testimonial['role'] }}</p>
                                    <div class="flex items-center mt-1">
                                        <span class="text-sm text-gray-400">at</span>
                                        <span class="text-sm font-semibold text-primary-400 ml-1">{{ $testimonial['company'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="swiper-pagination !bottom-0"></div>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8" data-aos="fade-up" data-aos-delay="400">
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">4.9/5</div>
                <div class="text-gray-400">Average Rating</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">95%</div>
                <div class="text-gray-400">Completion Rate</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">2,500+</div>
                <div class="text-gray-400">Success Stories</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">89%</div>
                <div class="text-gray-400">Career Advancement</div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Courses Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-12" data-aos="fade-up">
            <div class="mb-6 lg:mb-0">
                <div class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Fresh Content
                </div>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Latest 
                    <span class="bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Courses</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl">
                    Stay ahead with our newest courses featuring cutting-edge technologies and industry trends.
                </p>
            </div>
            
            <div class="flex-shrink-0">
                <a href="{{ route('courses.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-cyan-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    View All Courses
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Latest Courses Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($latestCourses as $index => $course)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-blue-200 transform hover:-translate-y-3" 
                     data-aos="fade-up" 
                     data-aos-delay="{{ ($index + 1) * 150 }}">
                    
                    <!-- Course Image -->
                    <div class="relative overflow-hidden">
                        <img src="{{ $course->thumbnail_url }}" 
                             alt="{{ $course->title }}" 
                             class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-500">
                        
                        <!-- New Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center px-2 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold rounded-full shadow-lg animate-pulse">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                NEW
                            </span>
                        </div>
                        
                        <!-- Price -->
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-900 text-sm font-bold rounded-full shadow-lg">
                                {{ $course->formatted_price }}
                            </span>
                        </div>

                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>

                    <!-- Course Content -->
                    <div class="p-5">
                        <!-- Instructor -->
                        <div class="flex items-center mb-3">
                            <img src="{{ $course->instructor->avatar_url }}" 
                                 alt="{{ $course->instructor->name }}" 
                                 class="w-6 h-6 rounded-full mr-2">
                            <span class="text-xs text-gray-600">{{ $course->instructor->name }}</span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                            <a href="{{ route('courses.show', $course) }}">{{ $course->title }}</a>
                        </h3>

                        <!-- Stats -->
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $course->duration_in_hours }}h
                            </div>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $course->enrolled_students_count }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                {{ number_format($course->average_rating, 1) }}
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <a href="{{ route('courses.show', $course) }}" 
                           class="block w-full text-center bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300 transform group-hover:scale-105 text-sm">
                            {{ $course->is_free ? 'Start Free' : 'Learn More' }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Free Courses Section -->
<section class="py-20 bg-gradient-to-br from-green-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium mb-4">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                </svg>
                100% Free
            </div>
            <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                Start Learning 
                <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">For Free</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Get started with our completely free courses. No credit card required, 
                no hidden fees, just high-quality education at your fingertips.
            </p>
        </div>

        <!-- Free Courses Carousel -->
        <div class="swiper free-courses-swiper" data-aos="fade-up" data-aos-delay="200">
            <div class="swiper-wrapper">
                @foreach($freeCourses as $course)
                    <div class="swiper-slide">
                        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-green-200 transform hover:-translate-y-2 h-full">
                            
                            <!-- Course Image -->
                            <div class="relative overflow-hidden">
                                <img src="{{ $course->thumbnail_url }}" 
                                     alt="{{ $course->title }}" 
                                     class="w-full h-48 object-cover hover:scale-110 transition-transform duration-500">
                                
                                <!-- Free Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white text-sm font-bold rounded-full shadow-lg">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                        </svg>
                                        FREE
                                    </span>
                                </div>

                                <!-- Level Badge -->
                                <div class="absolute top-4 right-4">
                                    <span class="inline-flex items-center px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-700 text-sm font-medium rounded-full">
                                        {{ ucfirst($course->level) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Course Content -->
                            <div class="p-6">
                                <!-- Instructor -->
                                <div class="flex items-center mb-4">
                                    <img src="{{ $course->instructor->avatar_url }}" 
                                         alt="{{ $course->instructor->name }}" 
                                         class="w-8 h-8 rounded-full mr-3">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $course->instructor->name }}</div>
                                        <div class="text-xs text-gray-500">Expert Instructor</div>
                                    </div>
                                </div>

                                <!-- Title -->
                                <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                                    <a href="{{ route('courses.show', $course) }}" class="hover:text-green-600 transition-colors duration-200">
                                        {{ $course->title }}
                                    </a>
                                </h3>

                                <!-- Description -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $course->description }}</p>

                                <!-- Course Stats -->
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-6">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        {{ $course->enrolled_students_count }} students
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $course->duration_in_hours }}h
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        {{ number_format($course->average_rating, 1) }}
                                    </div>
                                </div>

                                <!-- What You'll Learn -->
                                @if($course->objectives)
                                    <div class="mb-6">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-2">What you'll learn:</h4>
                                        <ul class="space-y-1">
                                            @foreach(array_slice(is_array($course->objectives) ? $course->objectives : json_decode($course->objectives), 0, 2) as $objective)
                                                <li class="flex items-start text-sm text-gray-600">
                                                    <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ $objective }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- CTA Button -->
                                <a href="{{ route('courses.show', $course) }}" 
                                   class="block w-full text-center bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Start Learning Free
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation -->
            <div class="swiper-button-next !text-green-600"></div>
            <div class="swiper-button-prev !text-green-600"></div>
            <div class="swiper-pagination !bottom-0"></div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-20 bg-gradient-to-br from-primary-600 via-purple-600 to-blue-600 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="newsletter-pattern" width="20" height="20" patternUnits="userSpaceOnUse">
                    <path d="M 10,0 L 10,20 M 0,10 L 20,10" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#newsletter-pattern)"/>
        </svg>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
    <div class="absolute top-20 right-20 w-16 h-16 bg-yellow-400/20 rounded-full animate-float animation-delay-1000"></div>
    <div class="absolute bottom-20 left-1/4 w-24 h-24 bg-pink-400/20 rounded-full animate-float animation-delay-2000"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Newsletter Content -->
        <div data-aos="fade-up">
            <!-- Icon -->
            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-8">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>

            <!-- Heading -->
            <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">
                Stay Updated with 
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">Latest Courses</span>
            </h2>

            <!-- Description -->
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto leading-relaxed">
                Join over 50,000+ learners and get notified about new courses, exclusive discounts, 
                and learning tips delivered straight to your inbox.
            </p>

            <!-- Newsletter Form -->
            <div class="max-w-md mx-auto" 
                 x-data="{ 
                    email: '', 
                    loading: false, 
                    subscribed: false,
                    subscribe() {
                        if (!this.email) return;
                        this.loading = true;
                        setTimeout(() => {
                            this.loading = false;
                            this.subscribed = true;
                            showToast('Successfully subscribed to newsletter!', 'success');
                            this.email = '';
                            setTimeout(() => this.subscribed = false, 3000);
                        }, 1500);
                    }
                 }">
                
                <form @submit.prevent="subscribe()" class="space-y-4">
                    <div class="relative">
                        <input type="email" 
                               x-model="email"
                               placeholder="Enter your email address" 
                               required
                               class="w-full px-6 py-4 bg-white/20 backdrop-blur-sm border border-white/30 rounded-2xl text-white placeholder-white/70 focus:outline-none focus:ring-4 focus:ring-white/30 focus:border-white/50 transition-all duration-300">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-6">
                            <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                    </div>
                    
                    <button type="submit" 
                            :disabled="loading || !email"
                            :class="{ 'opacity-50 cursor-not-allowed': loading || !email }"
                            class="w-full bg-white text-primary-600 font-bold py-4 px-8 rounded-2xl hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl disabled:transform-none disabled:hover:bg-white">
                        
                        <span x-show="!loading && !subscribed" class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Subscribe Now
                        </span>
                        
                        <span x-show="loading" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Subscribing...
                        </span>
                        
                        <span x-show="subscribed" class="flex items-center justify-center text-green-600">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Subscribed!
                        </span>
                    </button>
                </form>
            </div>

            <!-- Trust Indicators -->
            <div class="mt-8 flex flex-wrap items-center justify-center gap-8 text-white/80">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm">No Spam, Ever</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm">Secure & Private</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-sm">Premium Content</span>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Di bagian akhir file home.blade.php, sebelum @endsection --}}

@endsection

{{-- CSS Styles --}}
@push('head')
<style>
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    .animation-delay-1000 {
        animation-delay: 1s;
    }
    
    @keyframes blob {
        0% {
            transform: translate(0px, 0px) scale(1);
        }
        33% {
            transform: translate(30px, -50px) scale(1.1);
        }
        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }
        100% {
            transform: translate(0px, 0px) scale(1);
        }
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
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

{{-- JavaScript --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Testimonials Swiper
        new Swiper('.testimonials-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.testimonials-swiper .swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });

        // Free Courses Swiper
        new Swiper('.free-courses-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.free-courses-swiper .swiper-button-next',
                prevEl: '.free-courses-swiper .swiper-button-prev',
            },
            pagination: {
                el: '.free-courses-swiper .swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });

        // Counter Animation
        const counters = document.querySelectorAll('[data-counter]');
        const animateCounter = (counter) => {
            const target = parseInt(counter.getAttribute('data-counter'));
            const increment = target / 100;
            let current = 0;
            
            const updateCounter = () => {
                if (current < target) {
                    current += increment;
                    counter.textContent = Math.floor(current).toLocaleString();
                    setTimeout(updateCounter, 20);
                } else {
                    counter.textContent = target.toLocaleString();
                }
            };
            
            updateCounter();
        };

        // Intersection Observer for counter animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        });

        counters.forEach((counter) => {
            observer.observe(counter);
        });
    });
</script>
@endpush

