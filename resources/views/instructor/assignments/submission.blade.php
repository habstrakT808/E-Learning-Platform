<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Review Submission</h2>
                        <p class="text-gray-600">Assignment: {{ $assignment->title }}</p>
                        <p class="text-gray-600">Student: {{ $submission->student->name }}</p>
                    </div>
                    
                    <div class="mb-6">
                        <a href="{{ route('instructor.courses.assignments.show', [$course, $assignment]) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Assignment
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
                    
                    <!-- Submission Details -->
                    <div class="mb-8">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Submission Details</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <div class="mb-4">
                                                <h4 class="text-sm font-medium text-gray-500">Submission Date</h4>
                                                <p class="mt-1 text-sm text-gray-900">{{ $submission->created_at->format('M d, Y - H:i') }}</p>
                                                @if($submission->is_late)
                                                    <p class="text-sm text-red-500">Late submission</p>
                                                @else
                                                    <p class="text-sm text-green-500">On time</p>
                                                @endif
                                            </div>
                                            
                                            <div class="mb-4">
                                                <h4 class="text-sm font-medium text-gray-500">Status</h4>
                                                <div class="mt-1">
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $submission->status_class }}">
                                                        {{ $submission->formatted_status }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <h4 class="text-sm font-medium text-gray-500">Attempt</h4>
                                                <p class="mt-1 text-sm text-gray-900">{{ $submission->attempt_number }} of {{ $assignment->max_attempts }}</p>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <div class="mb-4">
                                                <h4 class="text-sm font-medium text-gray-500">File</h4>
                                                <div class="mt-1 flex items-center">
                                                    <div class="bg-gray-100 p-2 rounded border border-gray-300 flex items-center">
                                                        <i class="far fa-file mr-2 text-gray-500"></i>
                                                        <span class="text-sm text-gray-900">{{ $submission->original_filename }}</span>
                                                    </div>
                                                    <a href="{{ route('student.courses.assignments.submissions.download', [$course, $assignment, $submission]) }}" class="ml-2 text-blue-600 hover:text-blue-800">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                                <p class="mt-1 text-sm text-gray-500">{{ $submission->formatted_file_size }}</p>
                                            </div>
                                            
                                            @if($submission->score !== null)
                                                <div class="mb-4">
                                                    <h4 class="text-sm font-medium text-gray-500">Score</h4>
                                                    <p class="mt-1 text-sm text-gray-900">{{ $submission->score }} / {{ $assignment->max_score }}</p>
                                                </div>
                                            @endif
                                            
                                            @if($submission->reviewed_at)
                                                <div class="mb-4">
                                                    <h4 class="text-sm font-medium text-gray-500">Reviewed</h4>
                                                    <p class="mt-1 text-sm text-gray-900">{{ $submission->reviewed_at->format('M d, Y - H:i') }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($submission->notes)
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-500">Student Notes</h4>
                                    <div class="mt-2 bg-white p-4 rounded border border-gray-200">
                                        {!! nl2br(e($submission->notes)) !!}
                                    </div>
                                </div>
                            @endif
                            
                            @if($submission->feedback)
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-500">Feedback</h4>
                                    <div class="mt-2 bg-white p-4 rounded border border-gray-200">
                                        {!! nl2br(e($submission->feedback)) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Grading Form -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Grade Submission</h3>
                        
                        <form action="{{ route('instructor.courses.assignments.submissions.grade', [$course, $assignment, $submission]) }}" method="POST" class="bg-white p-6 rounded-lg border border-gray-200">
                            @csrf
                            
                            <div class="mb-6">
                                <label for="score" class="block text-sm font-medium text-gray-700 mb-1">Score (0-{{ $assignment->max_score }})</label>
                                <input type="number" name="score" id="score" min="0" max="{{ $assignment->max_score }}" value="{{ $submission->score ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            
                            <div class="mb-6">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="reviewed" {{ $submission->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                    <option value="need_revision" {{ $submission->status === 'need_revision' ? 'selected' : '' }}>Needs Revision</option>
                                    <option value="approved" {{ $submission->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $submission->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            
                            <div class="mb-6">
                                <label for="feedback" class="block text-sm font-medium text-gray-700 mb-1">Feedback</label>
                                <textarea name="feedback" id="feedback" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ $submission->feedback ?? '' }}</textarea>
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Submit Grading
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 