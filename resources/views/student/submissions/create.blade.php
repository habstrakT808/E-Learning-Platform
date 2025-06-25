<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Submit Assignment</h2>
                        <p class="text-gray-600">{{ $course->title }} - {{ $assignment->title }}</p>
                    </div>
                    
                    <div class="mb-6">
                        <a href="{{ route('student.courses.assignments.show', [$course, $assignment]) }}" class="text-blue-600 hover:text-blue-800">
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
                    
                    @if($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                            <p class="font-bold">Please fix the following errors:</p>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <!-- Assignment Info -->
                    <div class="mb-8 bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Assignment Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Deadline</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $assignment->formatted_deadline }}</p>
                                    <p class="text-sm {{ $assignment->isPastDeadline() ? 'text-red-500' : 'text-green-500' }}">
                                        {{ $assignment->time_remaining }}
                                    </p>
                                    
                                    @if($assignment->isPastDeadline() && $assignment->allow_late_submission)
                                        <p class="text-sm text-amber-500 mt-1">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> 
                                            This will be marked as a late submission.
                                        </p>
                                    @endif
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Attempt</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $attemptCount + 1 }} of {{ $assignment->max_attempts }}</p>
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
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submission Form -->
                    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Upload Your Submission</h3>
                        
                        <form action="{{ route('student.courses.assignments.store', [$course, $assignment]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            
                            <div>
                                <label for="submission_file" class="block text-sm font-medium text-gray-700">File <span class="text-red-600">*</span></label>
                                <div class="mt-1 flex items-center">
                                    <label class="w-full flex flex-col items-center px-4 py-6 bg-white rounded-lg border border-gray-300 border-dashed cursor-pointer hover:bg-gray-50">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                                            <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                Allowed file types: {{ implode(', ', array_map('strtoupper', $assignment->allowed_file_types)) }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                Max file size: {{ $assignment->max_file_size }} MB
                                            </p>
                                        </div>
                                        <input id="submission_file" name="submission_file" type="file" class="hidden" required />
                                    </label>
                                </div>
                                <div id="file-name" class="mt-2 text-sm text-gray-500"></div>
                            </div>
                            
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                                <textarea name="notes" id="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Add any notes or comments about your submission...">{{ old('notes') }}</textarea>
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Submit Assignment
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Previous Submission -->
                    @if($latestSubmission)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Your Previous Submission</h3>
                            
                            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
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
                                    </div>
                                    
                                    <div>
                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-500">File</h4>
                                            <div class="mt-1 flex items-center">
                                                <div class="bg-white p-2 rounded border border-gray-300 flex items-center">
                                                    <i class="far fa-file mr-2 text-gray-500"></i>
                                                    <span class="text-sm text-gray-900">{{ $latestSubmission->original_filename }}</span>
                                                </div>
                                                <a href="{{ route('student.courses.assignments.submissions.download', [$course, $assignment, $latestSubmission]) }}" class="ml-2 text-blue-600 hover:text-blue-800">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
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
                                        <div class="mt-2 bg-white p-4 rounded border border-gray-200">
                                            {!! nl2br(e($latestSubmission->notes)) !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('submission_file');
            const fileNameDiv = document.getElementById('file-name');
            
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const fileName = this.files[0].name;
                    const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2); // in MB
                    fileNameDiv.innerHTML = `<span class="font-medium">Selected file:</span> ${fileName} (${fileSize} MB)`;
                    
                    if (this.files[0].size > {{ $assignment->max_file_size * 1024 * 1024 }}) {
                        fileNameDiv.innerHTML += '<p class="text-red-500 mt-1">Warning: File size exceeds the maximum allowed size.</p>';
                    }
                } else {
                    fileNameDiv.innerHTML = '';
                }
            });
        });
    </script>
    @endpush
</x-app-layout> 