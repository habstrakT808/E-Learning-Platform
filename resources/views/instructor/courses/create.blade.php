{{-- resources/views/instructor/courses/create.blade.php --}}
@extends('layouts.app')

@section('title', ' - Create New Course')
@section('meta_description', 'Create a new course and share your knowledge with students worldwide.')

@section('content')
<!-- Create Course Header -->
<section class="relative py-12 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="create-pattern" width="20" height="20" patternUnits="userSpaceOnUse">
                    <circle cx="10" cy="10" r="1" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#create-pattern)"/>
        </svg>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-white" data-aos="fade-up">
            <h1 class="text-4xl lg:text-5xl font-bold mb-4">
                Create New 
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">Course</span>
            </h1>
            <p class="text-xl text-white/90">Share your knowledge and expertise with students worldwide</p>
        </div>
    </div>
</section>

<!-- Create Course Form -->
<section class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Progress Steps -->
        <div class="mb-8" data-aos="fade-up">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-indigo-600 text-white rounded-full font-bold">1</div>
                    <span class="ml-3 text-gray-900 font-medium">Basic Information</span>
                </div>
                <div class="mx-4 flex-1 h-0.5 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-600 rounded-full font-bold">2</div>
                    <span class="ml-3 text-gray-600">Add Content</span>
                </div>
                <div class="mx-4 flex-1 h-0.5 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-600 rounded-full font-bold">3</div>
                    <span class="ml-3 text-gray-600">Publish</span>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Basic Information Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up" data-aos-delay="100">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Basic Information</h2>
                
                <div class="space-y-6">
                    <!-- Course Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Course Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('title') border-red-500 @enderror"
                               placeholder="e.g., Complete Web Development Bootcamp"
                               required>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Course Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Course Description <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('description') border-red-500 @enderror"
                                  placeholder="Describe what students will learn in this course..."
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categories -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Categories <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @if($categories->count() > 0)
                                @foreach($categories as $category)
                                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
                                        <input type="checkbox" 
                                               name="categories[]" 
                                               value="{{ $category->id }}"
                                               {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                               class="mr-3 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm font-medium text-gray-700">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            @else
                                <div class="col-span-3 text-red-500">
                                    No categories available. Please contact the administrator.
                                </div>
                            @endif
                        </div>
                        @error('categories')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Please select at least one category for your course.</p>
                    </div>

                    <!-- Level & Price -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Level -->
                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700 mb-2">
                                Difficulty Level <span class="text-red-500">*</span>
                            </label>
                            <select name="level" 
                                    id="level"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('level') border-red-500 @enderror"
                                    required>
                                <option value="">Select Level</option>
                                <option value="beginner" {{ old('level') === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('level') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('level') === 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                            @error('level')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Price (IDR) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" 
                                       name="price" 
                                       id="price" 
                                       value="{{ old('price', 0) }}"
                                       min="0"
                                       step="1000"
                                       class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('price') border-red-500 @enderror"
                                       placeholder="0"
                                       required>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Set to 0 for free course</p>
                            @error('price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Requirements & Objectives Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up" data-aos-delay="200">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Requirements & Learning Objectives</h2>
                
                <div class="space-y-6">
                    <!-- Requirements -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Course Requirements
                        </label>
                        <div id="requirements-container" class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <input type="text" 
                                       name="requirements[]" 
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                       placeholder="e.g., Basic computer knowledge">
                                <button type="button" onclick="addRequirement()" class="p-2 bg-indigo-100 text-indigo-600 rounded-lg hover:bg-indigo-200 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Learning Objectives -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            What Students Will Learn
                        </label>
                        <div id="objectives-container" class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <input type="text" 
                                       name="objectives[]" 
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                       placeholder="e.g., Build responsive websites">
                                <button type="button" onclick="addObjective()" class="p-2 bg-indigo-100 text-indigo-600 rounded-lg hover:bg-indigo-200 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Thumbnail Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up" data-aos-delay="300">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Course Thumbnail</h2>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Thumbnail Image
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="thumbnail" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a file</span>
                                    <input id="thumbnail" name="thumbnail" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                    <div id="image-preview" class="mt-4 hidden">
                        <img src="" alt="Preview" class="mx-auto h-48 object-cover rounded-lg">
                    </div>
                    @error('thumbnail')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-between" data-aos="fade-up" data-aos-delay="400">
                <a href="{{ route('instructor.courses.index') }}" 
                   class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition-colors duration-200">
                    Cancel
                </a>
                
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    Create Course & Continue
                    <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        // Check if at least one category is selected
        const categoryCheckboxes = document.querySelectorAll('input[name="categories[]"]:checked');
        if (categoryCheckboxes.length === 0) {
            e.preventDefault();
            const categoriesContainer = document.querySelector('.grid.grid-cols-2.md\\:grid-cols-3.gap-3');
            const errorMessage = document.createElement('p');
            errorMessage.className = 'mt-2 text-sm text-red-600';
            errorMessage.textContent = 'Please select at least one category for your course.';
            
            // Remove any existing error message
            const existingError = categoriesContainer.parentNode.querySelector('.text-red-600');
            if (existingError) {
                existingError.remove();
            }
            
            categoriesContainer.parentNode.insertBefore(errorMessage, categoriesContainer.nextSibling);
            
            // Scroll to the categories section
            categoriesContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    // Add requirement field
    function addRequirement() {
        const container = document.getElementById('requirements-container');
        const div = document.createElement('div');
        div.className = 'flex items-center space-x-2 mt-2';
        div.innerHTML = `
            <input type="text" 
                   name="requirements[]" 
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                   placeholder="Add another requirement">
            <button type="button" onclick="removeField(this)" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;
        container.appendChild(div);
    }

    // Add objective field
    function addObjective() {
        const container = document.getElementById('objectives-container');
        const div = document.createElement('div');
        div.className = 'flex items-center space-x-2 mt-2';
        div.innerHTML = `
            <input type="text" 
                   name="objectives[]" 
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                   placeholder="Add another learning objective">
            <button type="button" onclick="removeField(this)" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;
        container.appendChild(div);
    }

    // Remove field
    function removeField(button) {
        button.parentElement.remove();
    }

    // Preview image
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const previewImg = preview.querySelector('img');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush