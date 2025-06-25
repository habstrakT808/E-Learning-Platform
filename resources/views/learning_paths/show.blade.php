@extends('layouts.app')

@section('content')
    <!-- Hero Section with Banner Image -->
    <div class="relative">
        <div class="h-64 md:h-80 bg-cover bg-center" style="background-image: url('{{ $learningPath->banner_image_url }}')">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative -mt-24">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                            <img src="{{ $learningPath->thumbnail_url }}" alt="{{ $learningPath->title }}" class="w-24 h-24 object-cover rounded-lg shadow">
                        </div>
                        
                        <div class="flex-grow">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="bg-{{ $learningPath->difficulty_level == 'beginner' ? 'green' : ($learningPath->difficulty_level == 'intermediate' ? 'yellow' : 'red') }}-100 text-{{ $learningPath->difficulty_level == 'beginner' ? 'green' : ($learningPath->difficulty_level == 'intermediate' ? 'yellow' : 'red') }}-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ ucfirst($learningPath->difficulty_level) }}
                                </span>
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ count($learningPath->stages) }} Stages
                                </span>
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $learningPath->estimated_hours }} Hours
                                </span>
                            </div>
                            
                            <h1 class="text-3xl font-bold text-gray-900">{{ $learningPath->title }}</h1>
                            
                            <p class="mt-2 text-gray-600">{{ $learningPath->short_description }}</p>
                        </div>
                        
                        <div class="mt-4 md:mt-0 md:ml-6 flex-shrink-0">
                            @if($isEnrolled)
                                <a href="{{ route('learning_paths.dashboard', $learningPath) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Continue Learning
                                </a>
                            @else
                                <form action="{{ route('learning_paths.enroll', $learningPath) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                        Start Learning Path
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <!-- Main Content Area -->
                <div class="lg:col-span-8">
                    <!-- About Section -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">About This Learning Path</h2>
                            <div class="prose max-w-none">
                                {!! nl2br(e($learningPath->description)) !!}
                            </div>
                            
                            @if($learningPath->prerequisites)
                                <div class="mt-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Prerequisites</h3>
                                    <div class="prose max-w-none">
                                        {!! nl2br(e($learningPath->prerequisites)) !!}
                                    </div>
                                </div>
                            @endif
                            
                            @if($learningPath->outcomes)
                                <div class="mt-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">What You'll Learn</h3>
                                    <div class="prose max-w-none">
                                        {!! nl2br(e($learningPath->outcomes)) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Learning Path Stages -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Learning Path Stages</h2>
                            
                            <div class="relative">
                                <!-- Vertical Timeline Line -->
                                <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                                
                                <!-- Stages -->
                                @foreach($learningPath->stages as $index => $stage)
                                    <div class="relative pl-12 pb-8">
                                        <!-- Timeline Dot -->
                                        <div class="absolute left-4 -translate-x-1/2 w-7 h-7 rounded-full bg-primary-100 border-4 border-primary-500 z-10 flex items-center justify-center">
                                            <span class="text-xs font-bold text-primary-800">{{ $index + 1 }}</span>
                                        </div>
                                        
                                        <!-- Stage Content -->
                                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $stage->title }}</h3>
                                            
                                            @if($stage->description)
                                                <p class="text-gray-600 mb-4">{{ $stage->description }}</p>
                                            @endif
                                            
                                            @if($isEnrolled)
                                                <div class="mb-4 flex items-center">
                                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                        <div class="bg-primary-600 h-2.5 rounded-full" style="width: {{ $stageProgress[$stage->id] ?? 0 }}%"></div>
                                                    </div>
                                                    <span class="ml-2 text-sm font-medium text-gray-700">{{ $stageProgress[$stage->id] ?? 0 }}%</span>
                                                </div>
                                            @endif
                                            
                                            <!-- Courses in Stage -->
                                            <div class="space-y-3">
                                                @foreach($stage->stageCourses as $stageCourse)
                                                    <div class="flex items-center p-3 border border-gray-100 rounded-md hover:bg-gray-50">
                                                        <div class="flex-shrink-0 mr-3">
                                                            <img src="{{ $stageCourse->course->thumbnail_url }}" alt="{{ $stageCourse->course->title }}" class="w-12 h-12 object-cover rounded">
                                                        </div>
                                                        <div class="flex-grow">
                                                            <h4 class="text-sm font-medium text-gray-900">{{ $stageCourse->course->title }}</h4>
                                                            <p class="text-xs text-gray-500">{{ $stageCourse->course->lessons_count ?? 0 }} lessons • {{ $stageCourse->course->duration ?? 0 }} hours</p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <a href="{{ route('courses.show', $stageCourse->course) }}" class="text-sm font-medium text-primary-600 hover:text-primary-800">View Course</a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-4 mt-6 lg:mt-0">
                    <!-- Progress Card (if enrolled) -->
                    @if($isEnrolled && $enrollment)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Your Progress</h2>
                                
                                <div class="mb-4">
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Overall Completion</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $enrollment->progress }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-primary-600 h-2.5 rounded-full" style="width: {{ $enrollment->progress }}%"></div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between text-sm text-gray-600 mb-4">
                                    <div>
                                        <span class="block font-medium">Started</span>
                                        <span>{{ $enrollment->started_at ? $enrollment->started_at->format('M d, Y') : 'Not started' }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="block font-medium">Est. Completion</span>
                                        <span>{{ $enrollment->expected_completion_date ? $enrollment->expected_completion_date->format('M d, Y') : 'Unknown' }}</span>
                                    </div>
                                </div>
                                
                                <a href="{{ route('learning_paths.dashboard', $learningPath) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Continue Learning
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Achievements Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Achievements</h2>
                            
                            <div class="grid grid-cols-2 gap-4">
                                @forelse($learningPath->achievements as $achievement)
                                    <div class="text-center">
                                        <div class="relative inline-block">
                                            <img src="{{ $achievement->badge_image_url }}" alt="{{ $achievement->title }}" class="w-16 h-16 mx-auto {{ in_array($achievement->id, $earnedAchievements ?? []) ? '' : 'filter grayscale opacity-50' }}">
                                            @if(in_array($achievement->id, $earnedAchievements ?? []))
                                                <div class="absolute -top-1 -right-1 bg-green-500 rounded-full w-5 h-5 flex items-center justify-center">
                                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <p class="mt-2 text-xs font-medium text-gray-900">{{ $achievement->title }}</p>
                                    </div>
                                @empty
                                    <div class="col-span-2 text-center py-4 text-gray-500">
                                        <p>No achievements available for this learning path.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    
                    <!-- CTA Card (if not enrolled) -->
                    @unless($isEnrolled)
                        <div class="bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg shadow-md overflow-hidden mb-6">
                            <div class="p-6 text-white">
                                <h2 class="text-xl font-bold mb-2">Ready to Start Your Journey?</h2>
                                <p class="mb-4 opacity-90">Enroll now and begin your structured learning experience.</p>
                                
                                <form action="{{ route('learning_paths.enroll', $learningPath) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-primary-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                                        Start Learning Path
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endunless
                </div>
            </div>
        </div>
    </div>
@endsection 