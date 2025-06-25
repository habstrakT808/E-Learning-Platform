<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Assignments for {{ $course->title }}</h2>
                    </div>
                    
                    <div class="mb-6">
                        <a href="{{ route('student.courses.show', $course) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Course
                        </a>
                    </div>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif
                    
                    @if($assignments->count() > 0)
                        <div class="grid grid-cols-1 gap-6">
                            @foreach($assignments as $assignment)
                                <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                                    <div class="p-6">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-800">{{ $assignment->title }}</h3>
                                                <div class="mt-2 text-sm text-gray-600">
                                                    <p><span class="font-medium">Deadline:</span> {{ $assignment->formatted_deadline }}</p>
                                                    <p><span class="font-medium">Time Remaining:</span> {{ $assignment->time_remaining }}</p>
                                                    <p><span class="font-medium">Max Score:</span> {{ $assignment->max_score }} points</p>
                                                    <p><span class="font-medium">Max Attempts:</span> {{ $assignment->max_attempts }}</p>
                                                </div>
                                                
                                                <div class="mt-3">
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                        @if($assignment->submission_status == 'Not submitted')
                                                            bg-gray-100 text-gray-800
                                                        @elseif($assignment->submission_status == 'Draft')
                                                            bg-gray-200 text-gray-800
                                                        @elseif($assignment->submission_status == 'Submitted')
                                                            bg-blue-100 text-blue-800
                                                        @elseif($assignment->submission_status == 'Reviewed')
                                                            bg-purple-100 text-purple-800
                                                        @elseif($assignment->submission_status == 'Needs Revision')
                                                            bg-amber-100 text-amber-800
                                                        @elseif($assignment->submission_status == 'Approved')
                                                            bg-green-100 text-green-800
                                                        @elseif($assignment->submission_status == 'Rejected')
                                                            bg-red-100 text-red-800
                                                        @endif
                                                    ">
                                                        {{ $assignment->submission_status }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="flex space-x-2">
                                                <a href="{{ route('student.courses.assignments.show', [$course, $assignment]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                                    <i class="fas fa-eye mr-2"></i> View Details
                                                </a>
                                                <a href="{{ route('student.courses.assignments.submit', [$course, $assignment]) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                                                    <i class="fas fa-upload mr-2"></i> Submit Assignment
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <div class="text-sm text-gray-600 line-clamp-2">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($assignment->description), 200) }}
                                            </div>
                                            <a href="{{ route('student.courses.assignments.show', [$course, $assignment]) }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800 text-sm">
                                                Read more
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        No assignments found for this course.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 