@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Learning Path Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                            <img src="{{ $learningPath->thumbnail_url }}" alt="{{ $learningPath->title }}" class="w-20 h-20 object-cover rounded-lg shadow">
                        </div>
                        
                        <div class="flex-grow">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $learningPath->title }}</h1>
                            <p class="text-gray-600">{{ $learningPath->short_description }}</p>
                            
                            <div class="mt-2 flex items-center">
                                <div class="w-48 bg-gray-200 rounded-full h-2.5 mr-2">
                                    <div class="bg-primary-600 h-2.5 rounded-full" style="width: {{ $enrollment->progress }}%"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ $enrollment->progress }}% Complete</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 md:mt-0 md:ml-6 flex-shrink-0">
                            <a href="{{ route('learning_paths.show', $learningPath) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content Area -->
                <div class="lg:col-span-2">
                    <!-- Learning Path Progress -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Your Learning Journey</h2>
                            
                            <div class="relative">
                                <!-- Vertical Timeline Line -->
                                <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                                
                                <!-- Stages -->
                                @foreach($learningPath->stages as $index => $stage)
                                    <div class="relative pl-12 pb-8">
                                        <!-- Timeline Dot -->
                                        <div class="absolute left-4 -translate-x-1/2 w-7 h-7 rounded-full {{ $stageProgress[$stage->id] >= 100 ? 'bg-green-100 border-green-500' : ($stageProgress[$stage->id] > 0 ? 'bg-primary-100 border-primary-500' : 'bg-gray-100 border-gray-300') }} border-4 z-10 flex items-center justify-center">
                                            @if($stageProgress[$stage->id] >= 100)
                                                <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <span class="text-xs font-bold {{ $stageProgress[$stage->id] > 0 ? 'text-primary-800' : 'text-gray-500' }}">{{ $index + 1 }}</span>
                                            @endif
                                        </div>
                                        
                                        <!-- Stage Content -->
                                        <div class="bg-white border {{ $stageProgress[$stage->id] >= 100 ? 'border-green-200' : ($stageProgress[$stage->id] > 0 ? 'border-primary-200' : 'border-gray-200') }} rounded-lg p-4">
                                            <div class="flex justify-between items-start mb-2">
                                                <h3 class="text-lg font-bold text-gray-900">{{ $stage->title }}</h3>
                                                <span class="text-sm font-medium {{ $stageProgress[$stage->id] >= 100 ? 'text-green-600' : 'text-gray-600' }}">
                                                    {{ $stageProgress[$stage->id] }}% Complete
                                                </span>
                                            </div>
                                            
                                            @if($stage->description)
                                                <p class="text-gray-600 mb-3 text-sm">{{ $stage->description }}</p>
                                            @endif
                                            
                                            <div class="mb-4">
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="{{ $stageProgress[$stage->id] >= 100 ? 'bg-green-500' : 'bg-primary-600' }} h-2 rounded-full" style="width: {{ $stageProgress[$stage->id] }}%"></div>
                                                </div>
                                            </div>
                                            
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
                                                            @if(in_array($stageCourse->course_id, $enrolledCourseIds))
                                                                <a href="{{ route('student.courses.show', $stageCourse->course) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                                    Continue
                                                                </a>
                                                            @else
                                                                <form action="{{ route('courses.enroll', $stageCourse->course) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                                        Enroll
                                                                    </button>
                                                                </form>
                                                            @endif
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
                <div class="lg:col-span-1">
                    <!-- Progress Stats -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h2 class="text-lg font-bold text-gray-900 mb-4">Your Progress</h2>
                            
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Overall Completion</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $enrollment->progress }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-primary-600 h-2.5 rounded-full" style="width: {{ $enrollment->progress }}%"></div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between text-sm text-gray-600">
                                    <div>
                                        <span class="block font-medium">Started</span>
                                        <span>{{ $enrollment->started_at ? $enrollment->started_at->format('M d, Y') : 'Not started' }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="block font-medium">Est. Completion</span>
                                        <span>{{ $enrollment->expected_completion_date ? $enrollment->expected_completion_date->format('M d, Y') : 'Unknown' }}</span>
                                    </div>
                                </div>
                                
                                <div class="pt-2 border-t border-gray-200">
                                    <span class="block font-medium text-sm text-gray-700 mb-2">Last Activity</span>
                                    <span class="text-sm text-gray-600">{{ $enrollment->last_activity_at ? $enrollment->last_activity_at->diffForHumans() : 'No activity yet' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Achievements -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h2 class="text-lg font-bold text-gray-900 mb-4">Your Achievements</h2>
                            
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
                    
                    <!-- Next Steps -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="text-lg font-bold text-gray-900 mb-4">Next Steps</h2>
                            
                            @php
                                $nextStage = null;
                                $nextCourse = null;
                                
                                foreach ($learningPath->stages as $stage) {
                                    if ($stageProgress[$stage->id] < 100) {
                                        $nextStage = $stage;
                                        
                                        foreach ($stage->stageCourses as $stageCourse) {
                                            if (!in_array($stageCourse->course_id, $enrolledCourseIds)) {
                                                $nextCourse = $stageCourse->course;
                                                break;
                                            }
                                        }
                                        
                                        if ($nextCourse) {
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            
                            @if($nextCourse)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Recommended Next Course</h3>
                                    <p class="text-sm text-gray-600 mb-3">{{ $nextCourse->title }}</p>
                                    
                                    <form action="{{ route('courses.enroll', $nextCourse) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            Enroll Now
                                        </button>
                                    </form>
                                </div>
                            @elseif($nextStage && $enrollment->progress < 100)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Continue Your Progress</h3>
                                    <p class="text-sm text-gray-600 mb-3">Complete the courses in "{{ $nextStage->title }}" stage.</p>
                                </div>
                            @else
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <h3 class="text-sm font-semibold text-green-900 mb-1">Congratulations!</h3>
                                    <p class="text-sm text-green-600">You've completed this learning path.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 