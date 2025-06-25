@extends('layouts.app')

@section('title', ' | Course Details')

@section('content')
<div class="py-6 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Actions -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Course Details</h1>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-gray-500 text-sm">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">Dashboard</a>
                        </li>
                        <li>
                            <span class="mx-1">/</span>
                        </li>
                        <li>
                            <a href="{{ route('admin.courses.index') }}" class="hover:text-gray-700">Courses</a>
                        </li>
                        <li>
                            <span class="mx-1">/</span>
                        </li>
                        <li>
                            <span class="text-gray-700">{{ $course->title }}</span>
                        </li>
                    </ol>
                </nav>
            </div>
            
            <div class="flex mt-4 md:mt-0 space-x-3">
                <a href="{{ route('admin.courses.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Courses
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Course Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Course Header -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                    <div class="relative h-48 md:h-64">
                        <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent flex items-end p-6">
                            <div>
                                <div class="flex items-center space-x-2 mb-2">
                                    @foreach ($course->categories as $category)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ ucfirst($course->level) }}
                                    </span>
                                </div>
                                <h2 class="text-xl font-bold text-white">{{ $course->title }}</h2>
                                <div class="mt-1 flex items-center text-white text-sm">
                                    <span class="flex items-center">
                                        <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="ml-1">{{ number_format($stats['average_rating'], 1) }}</span>
                                        <span class="mx-1">/</span>
                                        <span>{{ $stats['total_reviews'] }} reviews</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Author Information -->
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="{{ $course->instructor->avatar_url }}" alt="{{ $course->instructor->name }}">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $course->instructor->name }}</p>
                                <p class="text-xs text-gray-500">Instructor</p>
                            </div>
                        </div>
                        
                        <!-- Course Stats -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 text-center">
                            <div class="bg-blue-50 p-3 rounded-lg">
                                <p class="text-xs text-blue-700 font-semibold uppercase tracking-wide">Students</p>
                                <p class="text-xl font-bold text-gray-900">{{ number_format($stats['total_students']) }}</p>
                            </div>
                            <div class="bg-green-50 p-3 rounded-lg">
                                <p class="text-xs text-green-700 font-semibold uppercase tracking-wide">Revenue</p>
                                <p class="text-xl font-bold text-gray-900">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-purple-50 p-3 rounded-lg">
                                <p class="text-xs text-purple-700 font-semibold uppercase tracking-wide">Lessons</p>
                                <p class="text-xl font-bold text-gray-900">{{ number_format($stats['total_lessons']) }}</p>
                            </div>
                            <div class="bg-amber-50 p-3 rounded-lg">
                                <p class="text-xs text-amber-700 font-semibold uppercase tracking-wide">Duration</p>
                                <p class="text-xl font-bold text-gray-900">{{ floor($stats['total_duration']/60) }}h {{ $stats['total_duration'] % 60 }}m</p>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <div class="prose max-w-none mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                            <div class="text-gray-600">
                                {{ $course->description }}
                            </div>
                        </div>
                        
                        <!-- Course Requirements -->
                        @if($course->requirements)
                            <div class="mb-8">
                                <h3 class="text-xl font-bold mb-4">Requirements</h3>
                                <ul class="list-disc pl-6 space-y-2">
                                    @php
                                        $requirementsList = is_string($course->requirements) ? json_decode($course->requirements, true) : $course->requirements;
                                        $requirementsList = is_array($requirementsList) ? $requirementsList : [];
                                    @endphp
                                    
                                    @foreach($requirementsList as $requirement)
                                        <li>{{ $requirement }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- Course Objectives -->
                        @if($course->objectives)
                            <div class="mb-8">
                                <h3 class="text-xl font-bold mb-4">What Students Will Learn</h3>
                                <ul class="list-disc pl-6 space-y-2">
                                    @php
                                        $objectivesList = is_string($course->objectives) ? json_decode($course->objectives, true) : $course->objectives;
                                        $objectivesList = is_array($objectivesList) ? $objectivesList : [];
                                    @endphp
                                    
                                    @foreach($objectivesList as $objective)
                                        <li>{{ $objective }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- Course Details -->
                        <div class="border-t border-gray-200 pt-4">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4 text-sm">
                                <div>
                                    <dt class="text-gray-500">Created</dt>
                                    <dd class="font-medium text-gray-900">{{ $course->created_at->format('M d, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Last Updated</dt>
                                    <dd class="font-medium text-gray-900">{{ $course->updated_at->format('M d, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Price</dt>
                                    <dd class="font-medium text-gray-900">{{ $course->formatted_price }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Language</dt>
                                    <dd class="font-medium text-gray-900">{{ $course->language ?? 'English' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Completion Rate</dt>
                                    <dd class="font-medium text-gray-900">{{ $stats['completion_rate'] }}%</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Status</dt>
                                    <dd>
                                        @if($course->status === 'published')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Published</span>
                                        @elseif($course->status === 'draft')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Draft</span>
                                        @elseif($course->status === 'rejected')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
                
                <!-- Course Content -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200" x-data="{ openSection: null }">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Course Content</h3>
                        <p class="text-sm text-gray-500">{{ $course->sections->count() }} sections • {{ $stats['total_lessons'] }} lessons • {{ floor($stats['total_duration']/60) }}h {{ $stats['total_duration'] % 60 }}m total length</p>
                    </div>
                    
                    <div>
                        @foreach($course->sections as $section)
                        <div class="border-b border-gray-200 last:border-b-0">
                            <button 
                                @click="openSection = openSection === {{ $section->id }} ? null : {{ $section->id }}"
                                class="w-full px-6 py-4 flex items-center justify-between focus:outline-none"
                            >
                                <div class="flex items-center">
                                    <span class="font-medium text-gray-900">{{ $section->title }}</span>
                                    <span class="ml-2 text-gray-500 text-sm">{{ $section->lessons->count() }} lessons • {{ $section->lessons->sum('duration') }} min</span>
                                </div>
                                <svg 
                                    :class="{'rotate-180': openSection === {{ $section->id }} }" 
                                    class="h-5 w-5 text-gray-500 transform transition-transform duration-200" 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    viewBox="0 0 20 20" 
                                    fill="currentColor"
                                >
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            
                            <div x-show="openSection === {{ $section->id }}" x-collapse>
                                <div class="px-6 pb-4 space-y-2">
                                    @foreach($section->lessons as $lesson)
                                    <div class="flex items-center py-2 border-b border-gray-100 last:border-b-0">
                                        <div class="flex-shrink-0 mr-3">
                                            @if($lesson->is_preview)
                                                <span class="inline-block w-8 h-8 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </span>
                                            @else
                                                <span class="inline-block w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $lesson->title }}</p>
                                            @if($lesson->video_platform)
                                            <p class="text-xs text-gray-500">
                                                <span class="capitalize">{{ $lesson->video_platform }}</span> Video
                                            </p>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <span class="text-xs text-gray-500">{{ $lesson->duration }} min</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Reviews Section -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Student Reviews</h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Rating Summary -->
                            <div class="md:col-span-1">
                                <div class="flex flex-col items-center p-4 bg-gray-50 rounded-lg">
                                    <div class="text-5xl font-bold text-gray-900">{{ number_format($stats['average_rating'], 1) }}</div>
                                    <div class="flex items-center mt-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="h-5 w-5 {{ $i <= round($stats['average_rating']) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <div class="mt-1 text-sm text-gray-500">{{ $stats['total_reviews'] }} reviews</div>
                                    
                                    <div class="w-full mt-6 space-y-2">
                                        @for ($i = 5; $i >= 1; $i--)
                                        <div class="flex items-center">
                                            <div class="w-12 text-sm text-gray-700">{{ $i }} star</div>
                                            <div class="flex-1 mx-2">
                                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="h-full bg-yellow-400" style="width: {{ $stats['total_reviews'] > 0 ? ($reviewStats[$i] / $stats['total_reviews'] * 100) : 0 }}%"></div>
                                                </div>
                                            </div>
                                            <div class="w-8 text-xs text-gray-500 text-right">{{ $reviewStats[$i] }}</div>
                                        </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Review List -->
                            <div class="md:col-span-2 max-h-96 overflow-y-auto pr-2">
                                <div class="space-y-4">
                                    @forelse($course->reviews as $review)
                                    <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                                        <div class="flex items-start">
                                            <img class="h-10 w-10 rounded-full" src="{{ $review->user->avatar_url }}" alt="{{ $review->user->name }}">
                                            <div class="ml-3 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <h4 class="text-sm font-medium text-gray-900">{{ $review->user->name }}</h4>
                                                    <div class="flex items-center">
                                                        <div class="flex items-center">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <svg class="h-4 w-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-2 text-sm text-gray-700">
                                                    {{ $review->comment }}
                                                </div>
                                                <div class="mt-1 text-xs text-gray-500">
                                                    {{ $review->created_at->format('M d, Y') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-4">
                                        <p class="text-gray-500">No reviews yet</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Course Status Card -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Course Approval</h3>
                    </div>
                    
                    <div class="px-6 py-5">
                        <div class="mb-4">
                            <span class="block text-sm font-medium text-gray-700 mb-1">Current Status</span>
                            <div class="flex items-center">
                                @if($course->status === 'published')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Published
                                    </span>
                                    <span class="ml-2 text-xs text-gray-500">
                                        {{ $course->reviewed_at ? 'Published on ' . $course->reviewed_at->format('M d, Y') : '' }}
                                    </span>
                                @elseif($course->status === 'draft')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Draft
                                    </span>
                                    <span class="ml-2 text-xs text-gray-500">Awaiting review</span>
                                @elseif($course->status === 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Rejected
                                    </span>
                                    <span class="ml-2 text-xs text-gray-500">
                                        {{ $course->reviewed_at ? 'Rejected on ' . $course->reviewed_at->format('M d, Y') : '' }}
                                    </span>
                                @endif
                            </div>
                            
                            @if($course->status === 'rejected' && $course->rejection_reason)
                                <div class="mt-3 p-3 bg-red-50 border border-red-100 rounded-md">
                                    <h4 class="text-sm font-medium text-red-800 mb-1">Rejection Reason:</h4>
                                    <p class="text-sm text-red-700">{{ $course->rejection_reason }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <form action="{{ route('admin.courses.update-status', $course->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Change Status</label>
                                <select id="status" name="status" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="published" {{ $course->status === 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="draft" {{ $course->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="rejected" {{ $course->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            
                            <div class="mb-4" x-data="{ showReason: '{{ $course->status === 'rejected' ? 'true' : 'false' }}' }">
                                <div x-show="document.getElementById('status').value === 'rejected'" class="mb-3">
                                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-1">Rejection Reason</label>
                                    <textarea id="rejection_reason" name="rejection_reason" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $course->rejection_reason }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500">Please provide a reason for rejection. This will be visible to the instructor.</p>
                                </div>
                                
                                <script>
                                    document.getElementById('status').addEventListener('change', function() {
                                        const rejectReasonField = document.getElementById('rejection_reason').parentNode;
                                        if (this.value === 'rejected') {
                                            rejectReasonField.classList.remove('hidden');
                                        } else {
                                            rejectReasonField.classList.add('hidden');
                                        }
                                    });
                                </script>
                            </div>
                            
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Course Status
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Recent Enrollments Card -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Recent Enrollments</h3>
                    </div>
                    
                    <div class="px-6 py-5">
                        <ul class="divide-y divide-gray-200">
                            @forelse($recentEnrollments as $enrollment)
                                <li class="py-3 flex items-center">
                                    <img class="h-8 w-8 rounded-full" src="{{ $enrollment->user->avatar_url }}" alt="{{ $enrollment->user->name }}">
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $enrollment->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $enrollment->enrolled_at->format('M d, Y') }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        {{ $enrollment->formatted_amount_paid }}
                                    </span>
                                </li>
                            @empty
                                <li class="py-4 text-center text-sm text-gray-500">
                                    No enrollments yet
                                </li>
                            @endforelse
                        </ul>
                        
                        @if(count($recentEnrollments) > 0)
                            <div class="mt-4 text-center">
                                <button type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    View All Enrollments
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Student Progress Card -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Student Progress</h3>
                    </div>
                    
                    <div class="px-6 py-5">
                        <div class="space-y-4">
                            @forelse($studentProgress->take(5) as $student)
                                <div class="flex flex-col">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center">
                                            <img class="h-6 w-6 rounded-full" src="{{ asset('storage/' . $student->avatar) }}" alt="{{ $student->name }}">
                                            <span class="ml-2 text-sm font-medium text-gray-900">{{ $student->name }}</span>
                                        </div>
                                        <span class="text-xs text-gray-500">
                                            @if($student->completed_at)
                                                <span class="text-green-600">Completed</span>
                                            @else
                                                {{ $student->progress }}%
                                            @endif
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                                        <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $student->progress }}%"></div>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Enrolled: {{ \Carbon\Carbon::parse($student->enrolled_at)->format('M d, Y') }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-sm text-gray-500 py-4">
                                    No students enrolled yet
                                </div>
                            @endforelse
                        </div>
                        
                        @if($studentProgress->count() > 5)
                            <div class="mt-4 text-center">
                                <button type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    View All Students
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Alpine.js components if needed
    });
</script>
@endpush 