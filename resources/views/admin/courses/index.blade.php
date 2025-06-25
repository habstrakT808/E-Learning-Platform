@extends('layouts.app')

@section('title', ' | Course Management')

@section('content')
<div class="py-6 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- All Courses Banner -->
        <div class="mb-8 rounded-xl overflow-hidden shadow-lg">
            <div class="relative bg-blue-600 px-8 py-10">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="h-full w-full" viewBox="0 0 614 614" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none" fill-rule="evenodd">
                            <path d="M104 377l-2-1h-1a3 3 0 00-3 4l26 71 22-12-42-62zm388 238l-2-1h-1a3 3 0 00-3 4l26 71 22-12-42-62zm145-428l-1-2v-1a3 3 0 014-3l72 26-13 22-62-42zm-4 180l-1-2v-1a3 3 0 014-3l72 26-13 22-62-42zM398 73l-2-1h-1a3 3 0 00-3 4l26 71 22-12-42-62zm-108 0l-2-1h-1a3 3 0 00-3 4l26 71 22-12-42-62zm-21 564l32-33-15-15-37 28 20 20zM246 48l32-33-15-15-37 28 20 20zm-81 341l-26-50-21 11 36 53 11-14zm250 9l-25-50-21 11 36 53 10-14zM80 159l-26-50-21 11 36 53 11-14zm354-10l-26-50-21 11 36 53 11-14z" fill="#FFF" fill-opacity=".9"/>
                        </g>
                    </svg>
                </div>
                
                <div class="relative">
                    <!-- Header Text -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">All Courses</h1>
                            <p class="text-blue-100">Manage and monitor all courses across your platform</p>
                        </div>
                        <div class="hidden md:block">
                            <span class="inline-flex items-center px-4 py-2 bg-blue-800 bg-opacity-40 rounded-lg text-white text-xl font-bold backdrop-blur-sm">
                                {{ number_format($stats['total_courses']) }}
                                <span class="ml-2 text-sm font-normal">Total Courses</span>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white bg-opacity-15 backdrop-blur-sm rounded-lg px-4 py-3">
                            <div class="flex items-center">
                                <div class="p-2 rounded-md bg-green-400 bg-opacity-30">
                                    <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-blue-100">Published</p>
                                    <p class="text-xl font-bold text-black">{{ number_format($stats['published_courses']) }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white bg-opacity-15 backdrop-blur-sm rounded-lg px-4 py-3">
                            <div class="flex items-center">
                                <div class="p-2 rounded-md bg-yellow-400 bg-opacity-30">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-blue-100">Pending</p>
                                    <p class="text-xl font-bold text-black">{{ number_format($stats['draft_courses']) }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white bg-opacity-15 backdrop-blur-sm rounded-lg px-4 py-3">
                            <div class="flex items-center">
                                <div class="p-2 rounded-md bg-purple-400 bg-opacity-30">
                                    <svg class="h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-blue-100">Revenue</p>
                                    <p class="text-xl font-bold text-black">{{ number_format($stats['total_revenue']/1000) }}K</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white bg-opacity-15 backdrop-blur-sm rounded-lg px-4 py-3">
                            <div class="flex items-center">
                                <div class="p-2 rounded-md bg-pink-400 bg-opacity-30">
                                    <svg class="h-6 w-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-blue-100">Students</p>
                                    <p class="text-xl font-bold text-black">{{ number_format($stats['total_enrollments']) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions Bar -->
            <div class="bg-white px-8 py-4 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center">
                    <span class="mr-3 text-sm text-gray-500">Quick Actions:</span>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.courses.analytics') }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-md text-sm font-medium hover:bg-indigo-100 transition-colors">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Analytics
                        </a>
                        <button type="button" id="export-courses" class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 rounded-md text-sm font-medium hover:bg-green-100 transition-colors">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Export
                        </button>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">
                        <span class="font-medium">{{ $courses->total() }}</span> courses found
                    </span>
                    
                    <div class="relative">
                        <select id="view-options" class="appearance-none pl-3 pr-8 py-1.5 text-sm bg-gray-100 border border-gray-200 rounded-md text-gray-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="grid">Grid View</option>
                            <option value="list" selected>List View</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Course Management</h1>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.courses.analytics') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 active:bg-indigo-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Course Analytics
                </a>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white shadow-sm rounded-lg p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-50 rounded-md p-3">
                        <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Total Courses</h2>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($stats['total_courses']) }}</p>
                        <p class="text-xs text-gray-500">
                            <span class="text-green-600">{{ number_format($stats['published_courses']) }}</span> Published, 
                            <span class="text-yellow-600">{{ number_format($stats['draft_courses']) }}</span> Draft
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow-sm rounded-lg p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-50 rounded-md p-3">
                        <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Total Enrollments</h2>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($stats['total_enrollments']) }}</p>
                        <p class="text-xs text-gray-500">
                            <span class="text-blue-600">{{ number_format($stats['total_instructors']) }}</span> Instructors
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow-sm rounded-lg p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-amber-50 rounded-md p-3">
                        <svg class="h-6 w-6 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Total Revenue</h2>
                        <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500">
                            <span class="text-green-600">From {{ number_format($stats['total_enrollments']) }} enrollments</span>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow-sm rounded-lg p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-50 rounded-md p-3">
                        <svg class="h-6 w-6 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Avg. Course Price</h2>
                        <p class="text-lg font-semibold text-gray-900">
                            @if(isset($stats['avg_course_price']))
                                Rp {{ number_format($stats['avg_course_price'], 0, ',', '.') }}
                            @else
                                Rp {{ number_format(0, 0, ',', '.') }}
                            @endif
                        </p>
                        <p class="text-xs text-gray-500">
                            <span class="text-purple-600">{{ isset($stats['free_courses']) ? number_format($stats['free_courses']) : 0 }} free courses</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <form action="{{ route('admin.courses.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" id="search" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" 
                            placeholder="Course title or description" value="{{ $filters['search'] ?? '' }}">
                    </div>
                    
                    <!-- Status filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="all" {{ isset($filters['status']) && $filters['status'] == 'all' ? 'selected' : '' }}>All</option>
                            <option value="published" {{ isset($filters['status']) && $filters['status'] == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ isset($filters['status']) && $filters['status'] == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="rejected" {{ isset($filters['status']) && $filters['status'] == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    
                    <!-- Category filter -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category" id="category" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="all" {{ isset($filters['category']) && $filters['category'] == 'all' ? 'selected' : '' }}>All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ isset($filters['category']) && $filters['category'] == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Price filter -->
                    <div>
                        <label for="price_type" class="block text-sm font-medium text-gray-700 mb-1">Price Type</label>
                        <select name="price_type" id="price_type" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="all" {{ isset($filters['price_type']) && $filters['price_type'] == 'all' ? 'selected' : '' }}>All</option>
                            <option value="free" {{ isset($filters['price_type']) && $filters['price_type'] == 'free' ? 'selected' : '' }}>Free</option>
                            <option value="paid" {{ isset($filters['price_type']) && $filters['price_type'] == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Instructor filter -->
                    <div>
                        <label for="instructor" class="block text-sm font-medium text-gray-700 mb-1">Instructor</label>
                        <select name="instructor" id="instructor" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="all" {{ isset($filters['instructor']) && $filters['instructor'] == 'all' ? 'selected' : '' }}>All Instructors</option>
                            @foreach($instructors as $instructor)
                                <option value="{{ $instructor->id }}" {{ isset($filters['instructor']) && $filters['instructor'] == $instructor->id ? 'selected' : '' }}>
                                    {{ $instructor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Level filter -->
                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                        <select name="level" id="level" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="all" {{ isset($filters['level']) && $filters['level'] == 'all' ? 'selected' : '' }}>All Levels</option>
                            <option value="beginner" {{ isset($filters['level']) && $filters['level'] == 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ isset($filters['level']) && $filters['level'] == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ isset($filters['level']) && $filters['level'] == 'advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                    </div>
                    
                    <!-- Sort By -->
                    <div>
                        <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <select name="sort_by" id="sort_by" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="created_at" {{ isset($filters['sort_by']) && $filters['sort_by'] == 'created_at' ? 'selected' : '' }}>Creation Date</option>
                            <option value="title" {{ isset($filters['sort_by']) && $filters['sort_by'] == 'title' ? 'selected' : '' }}>Title</option>
                            <option value="rating" {{ isset($filters['sort_by']) && $filters['sort_by'] == 'rating' ? 'selected' : '' }}>Rating</option>
                            <option value="popularity" {{ isset($filters['sort_by']) && $filters['sort_by'] == 'popularity' ? 'selected' : '' }}>Popularity</option>
                            <option value="revenue" {{ isset($filters['sort_by']) && $filters['sort_by'] == 'revenue' ? 'selected' : '' }}>Revenue</option>
                        </select>
                    </div>
                    
                    <!-- Sort Order -->
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                        <select name="sort_order" id="sort_order" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="desc" {{ isset($filters['sort_order']) && $filters['sort_order'] == 'desc' ? 'selected' : '' }}>Descending</option>
                            <option value="asc" {{ isset($filters['sort_order']) && $filters['sort_order'] == 'asc' ? 'selected' : '' }}>Ascending</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.courses.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Clear Filters
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Filter Results
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Courses Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categories</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stats</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($courses as $course)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded object-cover" src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $course->title }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ ucfirst($course->level) }} | 
                                                {{ $course->formatted_price }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ $course->instructor->avatar_url }}" alt="{{ $course->instructor->name }}">
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm text-gray-900">{{ $course->instructor->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $course->instructor->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($course->categories as $category)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <div class="flex items-center mb-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            {{ $course->enrollments_count }} enrolled
                                        </div>
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            {{ number_format($course->average_rating, 1) }}
                                            <span class="text-xs text-gray-500 ml-1">({{ $course->reviews_count }})</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($course->status === 'published')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Published
                                        </span>
                                    @elseif ($course->status === 'draft')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Draft
                                        </span>
                                    @elseif ($course->status === 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Rejected
                                        </span>
                                    @endif
                                    
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $course->created_at->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.courses.show', $course->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm font-medium text-gray-500">
                                    No courses found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Grid View Template (hidden by default) -->
<div id="grid-view" class="hidden">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
        @forelse ($courses as $course)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-md">
                <div class="relative h-40">
                    <img class="h-full w-full object-cover" src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                    <div class="absolute top-2 right-2">
                        @if ($course->status === 'published')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="-ml-0.5 mr-1 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Published
                            </span>
                        @elseif ($course->status === 'draft')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <svg class="-ml-0.5 mr-1 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Draft
                            </span>
                        @elseif ($course->status === 'rejected')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="-ml-0.5 mr-1 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Rejected
                            </span>
                        @endif
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-sm font-medium text-gray-900 truncate mb-1">{{ $course->title }}</h3>
                    <div class="flex items-center text-xs text-gray-500 mb-3">
                        <span>{{ ucfirst($course->level) }}</span>
                        <span class="mx-1">•</span>
                        <span>{{ $course->formatted_price }}</span>
                    </div>
                    
                    <div class="flex items-center mb-3">
                        <img class="h-6 w-6 rounded-full object-cover mr-2" src="{{ $course->instructor->avatar_url }}" alt="{{ $course->instructor->name }}">
                        <span class="text-xs text-gray-700">{{ $course->instructor->name }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span class="ml-1 text-xs text-gray-500">{{ $course->enrollments_count }}</span>
                        </div>
                        
                        <div class="flex items-center">
                            <svg class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="ml-1 text-xs text-gray-500">{{ number_format($course->average_rating, 1) }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-right">
                        <a href="{{ route('admin.courses.show', $course->id) }}" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">No courses found</h3>
                <p class="text-sm text-gray-500">Try adjusting your search or filter options</p>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
        {{ $courses->links() }}
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewSelector = document.getElementById('view-options');
        const gridView = document.getElementById('grid-view');
        const listView = document.querySelector('.bg-white.shadow.overflow-hidden.sm\\:rounded-lg');
        
        function toggleView() {
            const selectedView = viewSelector.value;
            
            if (selectedView === 'grid') {
                gridView.classList.remove('hidden');
                listView.classList.add('hidden');
            } else {
                gridView.classList.add('hidden');
                listView.classList.remove('hidden');
            }
        }
        
        // Initialize view based on selector
        toggleView();
        
        // Listen for changes
        viewSelector.addEventListener('change', toggleView);
        
        // Export button functionality
        document.getElementById('export-courses').addEventListener('click', function() {
            alert('Export functionality will be implemented soon!');
        });
    });
</script>
@endpush 