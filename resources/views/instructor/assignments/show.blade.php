<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">{{ $assignment->title }}</h2>
                                <p class="text-gray-600">Course: {{ $course->title }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('instructor.courses.assignments.edit', [$course, $assignment]) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                                    <i class="fas fa-edit mr-2"></i> Edit Assignment
                                </a>
                                <form action="{{ route('instructor.courses.assignments.destroy', [$course, $assignment]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this assignment?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                        <i class="fas fa-trash mr-2"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <a href="{{ route('instructor.courses.assignments.index', $course) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Assignments
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
                    
                    <!-- Assignment Details -->
                    <div class="mb-8 bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Assignment Details</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Status</h4>
                                    <div class="mt-1">
                                        @if($assignment->is_active)
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Inactive</span>
                                        @endif
                                        
                                        @if($assignment->allow_late_submission)
                                            <span class="ml-2 px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Late Submission Allowed</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Deadline</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $assignment->formatted_deadline }}</p>
                                    <p class="text-sm text-gray-500">{{ $assignment->time_remaining }}</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Max Score</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $assignment->max_score }} points</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Max Attempts</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $assignment->max_attempts }}</p>
                                </div>
                            </div>
                            
                            <div>
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Allowed File Types</h4>
                                    <div class="mt-1 flex flex-wrap gap-1">
                                        @foreach($assignment->allowed_file_types as $type)
                                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">{{ strtoupper($type) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Max File Size</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $assignment->max_file_size }} MB</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Created</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $assignment->created_at->format('M d, Y - H:i') }}</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Last Updated</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $assignment->updated_at->format('M d, Y - H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-500">Description</h4>
                            <div class="mt-2 prose max-w-none">
                                {!! nl2br(e($assignment->description)) !!}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submission Statistics -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Submission Statistics</h3>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                                <div class="text-2xl font-bold text-blue-600">{{ $totalSubmissions }}</div>
                                <div class="text-sm text-gray-500">Total Submissions</div>
                            </div>
                            
                            <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                                <div class="text-2xl font-bold text-green-600">{{ $submittedCount }}</div>
                                <div class="text-sm text-gray-500">Submitted</div>
                            </div>
                            
                            <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                                <div class="text-2xl font-bold text-purple-600">{{ $reviewedCount }}</div>
                                <div class="text-sm text-gray-500">Reviewed</div>
                            </div>
                            
                            <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                                <div class="text-2xl font-bold text-amber-600">{{ $needRevisionCount }}</div>
                                <div class="text-sm text-gray-500">Need Revision</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submissions List -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Student Submissions</h3>
                        
                        @if($submissions->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Student</th>
                                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Submitted</th>
                                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Score</th>
                                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($submissions as $submission)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full" src="{{ $submission->student->avatar_url }}" alt="{{ $submission->student->name }}">
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">{{ $submission->student->name }}</div>
                                                            <div class="text-sm text-gray-500">{{ $submission->student->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                    <div class="text-sm text-gray-900">{{ $submission->created_at->format('M d, Y - H:i') }}</div>
                                                    <div class="text-sm text-gray-500">
                                                        @if($submission->is_late)
                                                            <span class="text-red-500">Late submission</span>
                                                        @else
                                                            <span class="text-green-500">On time</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $submission->status_class }}">
                                                        {{ $submission->formatted_status }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                    @if($submission->score !== null)
                                                        <div class="text-sm text-gray-900">{{ $submission->score }} / {{ $assignment->max_score }}</div>
                                                    @else
                                                        <div class="text-sm text-gray-500">Not graded</div>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-sm font-medium">
                                                    <a href="{{ route('instructor.courses.assignments.submissions.show', [$course, $assignment, $submission]) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                                        <i class="fas fa-eye mr-1"></i> Review
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-4">
                                {{ $submissions->links() }}
                            </div>
                        @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-yellow-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            No submissions found for this assignment yet.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 