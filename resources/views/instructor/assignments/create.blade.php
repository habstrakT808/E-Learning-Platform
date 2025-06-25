<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Create New Assignment</h2>
                        <p class="text-gray-600">Course: {{ $course->title }}</p>
                    </div>
                    
                    <div class="mb-6">
                        <a href="{{ route('instructor.courses.assignments.index', $course) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Assignments
                        </a>
                    </div>
                    
                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                            <p class="font-bold">Please fix the following errors:</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('instructor.courses.assignments.store', $course) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Assignment Title <span class="text-red-600">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description <span class="text-red-600">*</span></label>
                            <textarea name="description" id="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('description') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Provide clear instructions for the assignment.</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
                                <input type="datetime-local" name="deadline" id="deadline" value="{{ old('deadline') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <p class="mt-1 text-sm text-gray-500">Leave empty for no deadline.</p>
                            </div>
                            
                            <div>
                                <label for="max_score" class="block text-sm font-medium text-gray-700">Max Score <span class="text-red-600">*</span></label>
                                <input type="number" name="max_score" id="max_score" value="{{ old('max_score', 100) }}" min="0" max="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="max_attempts" class="block text-sm font-medium text-gray-700">Max Attempts <span class="text-red-600">*</span></label>
                                <input type="number" name="max_attempts" id="max_attempts" value="{{ old('max_attempts', 1) }}" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <p class="mt-1 text-sm text-gray-500">How many times can a student submit this assignment?</p>
                            </div>
                            
                            <div>
                                <label for="max_file_size" class="block text-sm font-medium text-gray-700">Max File Size (MB) <span class="text-red-600">*</span></label>
                                <input type="number" name="max_file_size" id="max_file_size" value="{{ old('max_file_size', 5) }}" min="1" max="50" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <p class="mt-1 text-sm text-gray-500">Maximum file size in megabytes.</p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Allowed File Types <span class="text-red-600">*</span></label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="allowed_file_types[]" value="pdf" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ in_array('pdf', old('allowed_file_types', [])) ? 'checked' : '' }}>
                                        <span class="ml-2">PDF</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="allowed_file_types[]" value="doc" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ in_array('doc', old('allowed_file_types', [])) ? 'checked' : '' }}>
                                        <span class="ml-2">DOC</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="allowed_file_types[]" value="docx" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ in_array('docx', old('allowed_file_types', [])) ? 'checked' : '' }}>
                                        <span class="ml-2">DOCX</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="allowed_file_types[]" value="ppt" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ in_array('ppt', old('allowed_file_types', [])) ? 'checked' : '' }}>
                                        <span class="ml-2">PPT</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="allowed_file_types[]" value="pptx" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ in_array('pptx', old('allowed_file_types', [])) ? 'checked' : '' }}>
                                        <span class="ml-2">PPTX</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="allowed_file_types[]" value="xls" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ in_array('xls', old('allowed_file_types', [])) ? 'checked' : '' }}>
                                        <span class="ml-2">XLS</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="allowed_file_types[]" value="xlsx" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ in_array('xlsx', old('allowed_file_types', [])) ? 'checked' : '' }}>
                                        <span class="ml-2">XLSX</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="allowed_file_types[]" value="zip" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ in_array('zip', old('allowed_file_types', [])) ? 'checked' : '' }}>
                                        <span class="ml-2">ZIP</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="allowed_file_types[]" value="rar" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ in_array('rar', old('allowed_file_types', [])) ? 'checked' : '' }}>
                                        <span class="ml-2">RAR</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="allowed_file_types[]" value="jpg" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ in_array('jpg', old('allowed_file_types', [])) ? 'checked' : '' }}>
                                        <span class="ml-2">JPG</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="allowed_file_types[]" value="png" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ in_array('png', old('allowed_file_types', [])) ? 'checked' : '' }}>
                                        <span class="ml-2">PNG</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col space-y-4">
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ old('is_active') ? 'checked' : 'checked' }}>
                                    <span class="ml-2">Make assignment active</span>
                                </label>
                                <p class="mt-1 text-sm text-gray-500">If unchecked, students won't see this assignment.</p>
                            </div>
                            
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="allow_late_submission" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ old('allow_late_submission') ? 'checked' : '' }}>
                                    <span class="ml-2">Allow late submissions</span>
                                </label>
                                <p class="mt-1 text-sm text-gray-500">If checked, students can submit after the deadline.</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Create Assignment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 