{{-- resources/views/instructor/courses/show.blade.php --}}
@extends('layouts.app')

@section('title', ' - ' . $course->title)
@section('meta_description', Str::limit($course->description, 160))

@push('styles')
<style>
    .glass-effect {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }
    
    .floating-card {
        transition: all 0.3s ease;
    }
    
    .floating-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .stats-gradient-text {
        background: linear-gradient(135deg, #ffffff 0%, #e2d8fd 50%, #d8b5ff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 800;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.6));
        font-size: 2.5rem;
        letter-spacing: -0.5px;
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    .animate-pulse-slow {
        animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    .shimmer {
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: shimmer 2s infinite;
    }
    
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .card-shadow {
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.1);
    }
    
    .backdrop-blur {
        backdrop-filter: blur(12px);
    }

    .stat-card {
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }
    
    /* Enhanced text styles for better contrast */
    .course-title {
        color: #ffffff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    
    .status-badge {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        font-weight: 600;
    }
    
    .draft-status {
        background: rgba(250, 204, 21, 0.3);
        border: 1px solid rgba(250, 204, 21, 0.5);
    }
    
    .live-status {
        background: rgba(34, 197, 94, 0.3);
        border: 1px solid rgba(34, 197, 94, 0.5);
    }
    
    .meta-item {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.25);
        font-weight: 500;
    }

    /* Button hover styles */
.edit-button:hover, .publish-button:hover {
    background-color: rgba(124, 58, 237, 0.9) !important;
    border-color: rgba(139, 92, 246, 0.5) !important;
    box-shadow: 0 10px 25px -5px rgba(124, 58, 237, 0.4) !important;
}

.edit-button:hover span, .publish-button:hover span {
    color: #a855f7 !important; /* Purple text on hover */
}

.edit-button:hover svg, .publish-button:hover svg {
    color: #a855f7 !important; /* Purple icon on hover */
}
    
    .stat-text {
        color: #000000;
        font-weight: 800;
        font-size: 2.5rem;
        text-shadow: 0 2px 4px rgba(255, 255, 255, 0.2);
        -webkit-text-fill-color: #000000;
    }
    
    .thumbnail-wrapper {
        height: 400px;
        position: relative;
    }
    
    .thumbnail-container {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 0;
        right: 0;
    }
</style>
@endpush

@section('content')
<!-- Course Header -->
<section class="relative bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-0 left-1/2 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float" style="animation-delay: 4s;"></div>
    </div>
    
    <!-- Geometric Patterns -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="pattern" width="20" height="20" patternUnits="userSpaceOnUse">
                    <circle cx="10" cy="10" r="1" fill="currentColor"/>
                    <rect x="8" y="8" width="4" height="4" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#pattern)"/>
        </svg>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-20 pb-16">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <nav class="flex items-center space-x-2 text-white/80">
                <a href="{{ route('instructor.courses.index') }}" class="flex items-center hover:text-white transition-colors duration-200 group">
                    <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="font-medium">My Courses</span>
                </a>
                <svg class="w-4 h-4 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-white font-medium">Course Details</span>
            </nav>
        </div>

        <div class="grid lg:grid-cols-5 gap-12 items-center">
            <!-- Course Info -->
            <div class="lg:col-span-3 space-y-8">
                <!-- Status Badge -->
                <div class="flex items-center mb-6">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm status-badge {{ $course->status === 'published' ? 'live-status' : 'draft-status' }}">
                        <div class="w-2 h-2 rounded-full mr-2 {{ $course->status === 'published' ? 'bg-green-400 animate-pulse' : 'bg-yellow-400 animate-pulse' }}"></div>
                        {{ $course->status === 'published' ? 'Live Course' : 'Draft Mode' }}
                    </span>
                </div>

                <!-- Course Title -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black course-title mb-6 leading-tight">
                    {{ $course->title }}
                </h1>

                <!-- Course Meta -->
                <div class="flex flex-wrap gap-4 mb-8">
                    <div class="meta-item text-sm px-4 py-2 rounded-xl flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        {{ ucfirst($course->level) }} Level
                    </div>
                    <div class="meta-item text-sm px-4 py-2 rounded-xl flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        {{ $stats['total_lessons'] }} Lessons
                    </div>
                    <div class="meta-item text-sm px-4 py-2 rounded-xl flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        {{ $stats['total_students'] }} Students
                    </div>
                    <div class="meta-item text-sm px-4 py-2 rounded-xl flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                        Rp {{ number_format($course->price, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('instructor.courses.edit', $course) }}" class="edit-button group relative inline-flex items-center px-6 py-3 overflow-hidden text-lg font-medium text-indigo-100 bg-indigo-600/80 backdrop-blur-md border border-indigo-500/50 rounded-xl hover:text-white transition-all duration-300 ease-out shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>Edit Course</span>
                    </a>

                    @if($course->status === 'draft')
                        <form action="{{ route('instructor.courses.publish', $course) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="publish-button group inline-flex items-center px-6 py-3 text-lg font-medium text-green-100 bg-green-600/80 backdrop-blur-md border border-green-500/50 rounded-xl hover:text-white transition-all duration-300 ease-out shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Publish Course</span>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('instructor.courses.unpublish', $course) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="publish-button group inline-flex items-center px-6 py-3 text-lg font-medium text-yellow-100 bg-yellow-600/80 backdrop-blur-md border border-yellow-500/50 rounded-xl hover:text-white transition-all duration-300 ease-out shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span>Unpublish</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Course Thumbnail -->
            <div class="lg:col-span-2 thumbnail-wrapper">
                <div class="floating-card overflow-hidden rounded-3xl shadow-2xl thumbnail-container">
                    @if($course->thumbnail)
                        <div class="relative group h-96 w-full">
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="absolute bottom-0 inset-x-0 p-6 text-white opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                                <div class="glass-effect rounded-xl p-4 backdrop-blur-md">
                                    <p class="text-sm font-medium">Course Thumbnail</p>
                                    <p class="text-xs text-white/80 mt-1">Click to view or change the image</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="w-full h-96 bg-gradient-to-br from-indigo-800 to-purple-900 rounded-3xl flex items-center justify-center group hover:from-indigo-700 hover:to-purple-800 transition-all duration-500 p-8 overflow-hidden relative">
                            <div class="absolute inset-0 opacity-10">
                                <svg class="w-full h-full" viewBox="0 0 100 100">
                                    <defs>
                                        <pattern id="small-grid" width="8" height="8" patternUnits="userSpaceOnUse">
                                            <path d="M 8 0 L 0 0 0 8" fill="none" stroke="white" stroke-width="0.5"></path>
                                        </pattern>
                                        <pattern id="grid" width="80" height="80" patternUnits="userSpaceOnUse">
                                            <rect width="80" height="80" fill="url(#small-grid)"></rect>
                                            <path d="M 80 0 L 0 0 0 80" fill="none" stroke="white" stroke-width="1"></path>
                                        </pattern>
                                    </defs>
                                    <rect width="100%" height="100%" fill="url(#grid)" />
                                </svg>
                            </div>
                            <div class="text-center z-10">
                                <svg class="w-20 h-20 text-white/40 mx-auto mb-4 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-white/80 font-medium">Add a thumbnail for this course</p>
                                <p class="text-white/60 text-sm mt-2">Recommended size: 1280×720px</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Overview -->
<section class="py-8 bg-gradient-to-br from-purple-900 via-indigo-800 to-purple-800 relative overflow-hidden border-t border-white/10 border-b border-white/10">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-y-0 right-0 w-1/2 bg-gradient-to-l from-white/5 to-transparent"></div>
        <div class="absolute inset-y-0 left-0 w-1/2 bg-gradient-to-r from-white/5 to-transparent"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Enrolled Students -->
            <div class="stat-card bg-white/90 backdrop-blur p-6 rounded-xl border-2 border-purple-300 text-center shadow-lg">
                <div class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                    {{ $stats['total_students'] }}
                </div>
                <div class="text-sm font-semibold mt-2 bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                    Enrolled Students
                </div>
            </div>
            
            <!-- Total Revenue -->
            <div class="stat-card bg-white/90 backdrop-blur p-6 rounded-xl border-2 border-purple-300 text-center shadow-lg">
                <div class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                    Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}
                </div>
                <div class="text-sm font-semibold mt-2 bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                    Total Revenue
                </div>
            </div>
            
            <!-- Avg. Completion Rate -->
            <div class="stat-card bg-white/90 backdrop-blur p-6 rounded-xl border-2 border-purple-300 text-center shadow-lg">
                <div class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                    {{ number_format($stats['completion_rate'] ?? 0, 1) }}%
                </div>
                <div class="text-sm font-semibold mt-2 bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                    Completion Rate
                </div>
            </div>
            
            <!-- Avg. Rating -->
            <div class="stat-card bg-white/90 backdrop-blur p-6 rounded-xl border-2 border-purple-300 text-center shadow-lg">
                <div class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                    {{ number_format($stats['avg_rating'] ?? 0, 1) }}
                </div>
                <div class="text-sm font-semibold mt-2 bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                    Average Rating
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Course Content -->
<section class="py-20 bg-gradient-to-br from-gray-50 via-white to-gray-50 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-20 right-10 w-32 h-32 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse-slow"></div>
        <div class="absolute bottom-20 left-10 w-32 h-32 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse-slow" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Alerts -->
        @if(session('success'))
            <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-6 mb-8 rounded-2xl shadow-lg" role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-gradient-to-r from-red-400 to-red-600 text-white p-6 mb-8 rounded-2xl shadow-lg" role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Course Analytics Card -->
                <div class="floating-card bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-3xl font-bold gradient-text">Course Analytics</h2>
                        <div class="p-3 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Charts will go here -->
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 h-56 flex items-center justify-center">
                        <a href="{{ route('instructor.courses.analytics', $course) }}" class="text-indigo-600 font-medium hover:text-indigo-800 transition-colors flex items-center">
                            <span>View detailed analytics</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Course Details -->
                <div class="floating-card bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-8 border border-white/20">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-3xl font-bold gradient-text">About This Course</h2>
                        <div class="p-3 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-2xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="prose max-w-none text-gray-700 text-lg leading-relaxed mb-8">
                        {{ $course->description }}
                    </div>

                    <!-- Categories -->
                    @if($course->categories->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Categories
                            </h3>
                            <div class="flex flex-wrap gap-3">
                                @foreach($course->categories as $category)
                                    <span class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-800 text-sm font-medium rounded-xl border border-indigo-200">
                                        <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Requirements -->
                    @if(is_array($course->requirements) && count($course->requirements) > 0)
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                Course Requirements
                            </h3>
                            <ul class="space-y-3">
                                @foreach($course->requirements as $requirement)
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-gray-700">{{ $requirement }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Learning Objectives -->
                    @if(is_array($course->objectives) && count($course->objectives) > 0)
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                What You'll Learn
                            </h3>
                            <ul class="space-y-3">
                                @foreach($course->objectives as $objective)
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-gray-700">{{ $objective }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Course Content Structure -->
                <div class="floating-card bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-8 border border-white/20">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-3xl font-bold gradient-text">Course Content</h2>
                        <a href="{{ route('instructor.courses.edit', $course) }}#content" class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Content
                        </a>
                    </div>

                    @if($course->sections->count() > 0)
                        <div class="space-y-6">
                            @foreach($course->sections->sortBy('order') as $index => $section)
                                <div class="group border border-gray-200 rounded-2xl overflow-hidden hover:border-indigo-300 transition-all duration-300">
                                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-4 flex justify-between items-center group-hover:from-indigo-50 group-hover:to-purple-50 transition-all duration-300">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-sm mr-4">
                                                {{ $index + 1 }}
                                            </div>
                                            <h3 class="font-bold text-gray-800 text-lg">{{ $section->title }}</h3>
                                        </div>
                                        <span class="px-3 py-1 bg-white rounded-lg text-gray-600 text-sm font-medium border border-gray-200">
                                            {{ $section->lessons->count() }} lessons
                                        </span>
                                    </div>
                                    
                                    @if($section->lessons->count() > 0)
                                        <ul class="divide-y divide-gray-100">
                                            @foreach($section->lessons->sortBy('order') as $lesson)
                                                <li class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors duration-200">
                                                    <div class="flex items-center">
                                                        <span class="mr-4 p-2 rounded-lg {{ $lesson->type === 'video' ? 'bg-blue-100 text-blue-600' : ($lesson->type === 'quiz' ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600') }}">
                                                            @if($lesson->type === 'video')
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                            @elseif($lesson->type === 'quiz')
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                </svg>
                                                            @else
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                                </svg>
                                                            @endif
                                                        </span>
                                                        <div>
                                                            <span class="text-gray-800 font-medium">{{ $lesson->title }}</span>
                                                            <p class="text-sm text-gray-500 mt-1">{{ ucfirst($lesson->type) }} Lesson</p>
                                                        </div>
                                                    </div>
                                                    <div class="text-gray-500 text-sm font-medium">
                                                        {{ $lesson->duration ? $lesson->duration . ' min' : 'No duration' }}
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="px-6 py-8 text-center">
                                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                            <p class="text-gray-500 italic">No lessons added to this section yet.</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 text-yellow-800 p-8 rounded-2xl flex items-center">
                            <svg class="w-8 h-8 mr-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <h3 class="font-bold text-lg mb-1">No Content Added Yet</h3>
                                <p>Start building your course by adding sections and lessons. Click "Add Content" to get started.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Recent Enrollments -->
                <div class="floating-card bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-6 border border-white/20">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Recent Students</h3>
                        <div class="p-2 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    @if($recentEnrollments->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentEnrollments as $enrollment)
                                <div class="flex items-center p-3 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                                    <div class="relative">
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-400 to-purple-600 overflow-hidden flex-shrink-0">
                                            @if($enrollment->user->avatar)
                                                <img src="{{ asset('storage/' . $enrollment->user->avatar) }}" alt="{{ $enrollment->user->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-white font-bold">
                                                    {{ substr($enrollment->user->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <p class="text-gray-800 font-medium">{{ $enrollment->user->name }}</p>
                                        <p class="text-gray-500 text-sm">{{ $enrollment->enrolled_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6 text-center">
                            <a href="#" class="inline-flex items-center text-indigo-600 text-sm font-medium hover:text-indigo-800 transition-colors duration-200">
                                View All Students
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <h4 class="font-medium text-gray-800 mb-1">No Students Yet</h4>
                            <p class="text-gray-500 text-sm">
                                @if($course->status === 'published')
                                    Share your course to get students!
                                @else
                                    Publish your course to allow enrollments.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="floating-card bg-gradient-to-br from-indigo-50 to-purple-50 rounded-3xl shadow-xl p-6 border border-indigo-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Quick Actions</h3>
                        <div class="p-2 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <a href="{{ route('instructor.courses.edit', $course) }}" class="group block w-full py-3 px-4 bg-white/80 backdrop-blur-sm text-indigo-600 rounded-xl border border-indigo-200 font-medium hover:bg-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Course Details
                            </div>
                        </a>
                        
                        <a href="{{ route('instructor.courses.edit', ['course' => $course, 'section' => 'content']) }}" class="group block w-full py-3 px-4 bg-white/80 backdrop-blur-sm text-indigo-600 rounded-xl border border-indigo-200 font-medium hover:bg-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                Manage Content
                            </div>
                        </a>
                        
                        <a href="{{ route('instructor.courses.analytics', $course) }}" class="group block w-full py-3 px-4 bg-white/80 backdrop-blur-sm text-indigo-600 rounded-xl border border-indigo-200 font-medium hover:bg-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                View Analytics
                            </div>
                        </a>
                        
                        <a href="#" class="group block w-full py-3 px-4 bg-white/80 backdrop-blur-sm text-indigo-600 rounded-xl border border-indigo-200 font-medium hover:bg-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                                </svg>
                                Manage Q&A
                            </div>
                        </a>
                        
                        <a href="#" class="group block w-full py-3 px-4 bg-white/80 backdrop-blur-sm text-indigo-600 rounded-xl border border-indigo-200 font-medium hover:bg-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Preview Course
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection