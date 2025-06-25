<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $assignment->title }}</h2>
                        <p class="text-gray-600">Course: {{ $course->title }}</p>
                    </div>
                    
                    <div class="mb-6">
                        <a href="{{ route('student.courses.assignments.index', $course) }}" class="text-blue-600 hover:text-blue-800">
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
                                    <h4 class="text-sm font-medium text-gray-500">Deadline</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $assignment->formatted_deadline }}</p>
                                    <p class="text-sm {{ $assignment->isPastDeadline() ? 'text-red-500' : 'text-green-500' }}">
                                        {{ $assignment->time_remaining }}
                                    </p>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Max Score</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $assignment->max_score }} points</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Max Attempts</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $assignment->max_attempts }}</p>
                                </div>
                                
                                @if($assignment->allow_late_submission)
                                    <div class="mb-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Late Submission Allowed
                                        </span>
                                    </div>
                                @endif
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
                                    <h4 class="text-sm font-medium text-gray-500">Your Attempts</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $submissions->count() }} of {{ $assignment->max_attempts }}</p>
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
                    
                    <!-- Latest Submission -->
                    @if($latestSubmission)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Latest Submission</h3>
                            
                            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-500">Submission Date</h4>
                                            <p class="mt-1 text-sm text-gray-900">{{ $latestSubmission->created_at->format('M d, Y - H:i') }}</p>
                                            @if($latestSubmission->is_late)
                                                <p class="text-sm text-red-500">Late submission</p>
                                            @else
                                                <p class="text-sm text-green-500">On time</p>
                                            @endif
                                        </div>
                                        
                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-500">Status</h4>
                                            <div class="mt-1">
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $latestSubmission->status_class }}">
                                                    {{ $latestSubmission->formatted_status }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-500">Attempt</h4>
                                            <p class="mt-1 text-sm text-gray-900">{{ $latestSubmission->attempt_number }} of {{ $assignment->max_attempts }}</p>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-500">File</h4>
                                            <div class="mt-1 flex items-center">
                                                <div class="bg-gray-100 p-2 rounded border border-gray-300 flex items-center">
                                                    <i class="far fa-file mr-2 text-gray-500"></i>
                                                    <span class="text-sm text-gray-900">{{ $latestSubmission->original_filename }}</span>
                                                </div>
                                                <a href="{{ route('student.courses.assignments.submissions.download', [$course, $assignment, $latestSubmission]) }}" class="ml-2 text-blue-600 hover:text-blue-800">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-500">{{ $latestSubmission->formatted_file_size }}</p>
                                        </div>
                                        
                                        @if($latestSubmission->score !== null)
                                            <div class="mb-4">
                                                <h4 class="text-sm font-medium text-gray-500">Score</h4>
                                                <p class="mt-1 text-sm text-gray-900">{{ $latestSubmission->score }} / {{ $assignment->max_score }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($latestSubmission->notes)
                                    <div class="mt-4">
                                        <h4 class="text-sm font-medium text-gray-500">Your Notes</h4>
                                        <div class="mt-2 bg-gray-50 p-4 rounded border border-gray-200">
                                            {!! nl2br(e($latestSubmission->notes)) !!}
                                        </div>
                                    </div>
                                @endif
                                
                                @if($latestSubmission->feedback)
                                    <div class="mt-4">
                                        <h4 class="text-sm font-medium text-gray-500">Instructor Feedback</h4>
                                        <div class="mt-2 bg-gray-50 p-4 rounded border border-gray-200">
                                            {!! nl2br(e($latestSubmission->feedback)) !!}
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="mt-6">
                                    @if($submissions->count() < $assignment->max_attempts && (!$assignment->isPastDeadline() || $assignment->allow_late_submission))
                                        <a href="{{ route('student.courses.assignments.submit', [$course, $assignment]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                            <i class="fas fa-upload mr-2"></i> Submit New Attempt
                                        </a>
                                    @elseif($submissions->count() >= $assignment->max_attempts)
                                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                            <p class="text-sm text-yellow-700">
                                                You have reached the maximum number of attempts for this assignment.
                                            </p>
                                        </div>
                                    @elseif($assignment->isPastDeadline() && !$assignment->allow_late_submission)
                                        <div class="bg-red-50 border-l-4 border-red-400 p-4">
                                            <p class="text-sm text-red-700">
                                                The deadline for this assignment has passed and late submissions are not allowed.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mb-8">
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-yellow-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            You haven't submitted anything for this assignment yet.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                @if(!$assignment->isPastDeadline() || $assignment->allow_late_submission)
                                    <a href="{{ route('student.courses.assignments.submit', [$course, $assignment]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                        <i class="fas fa-upload mr-2"></i> Submit Assignment
                                    </a>
                                @else
                                    <div class="bg-red-50 border-l-4 border-red-400 p-4">
                                        <p class="text-sm text-red-700">
                                            The deadline for this assignment has passed and late submissions are not allowed.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    <!-- Submission History -->
                    @if($submissions->count() > 0)
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Submission History</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Attempt</th>
                                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Score</th>
                                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($submissions as $submission)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                    <div class="text-sm text-gray-900">{{ $submission->attempt_number }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                    <div class="text-sm text-gray-900">{{ $submission->created_at->format('M d, Y - H:i') }}</div>
                                                    <div class="text-xs text-gray-500">
                                                        @if($submission->is_late)
                                                            <span class="text-red-500">Late</span>
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
                                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                    <a href="{{ route('student.courses.assignments.submissions.download', [$course, $assignment, $submission]) }}" class="text-blue-600 hover:text-blue-800">
                                                        <i class="fas fa-download mr-1"></i> {{ $submission->original_filename }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 