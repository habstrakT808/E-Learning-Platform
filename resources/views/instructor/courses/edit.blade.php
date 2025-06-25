{{-- resources/views/instructor/courses/edit.blade.php --}}
@extends('layouts.app')

@section('title', ' - Edit Course')
@section('meta_description', 'Edit your course details, manage sections and lessons.')

@section('content')
<!-- Edit Course Header -->
<section class="relative py-12 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="edit-pattern" width="20" height="20" patternUnits="userSpaceOnUse">
                    <circle cx="10" cy="10" r="1" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#edit-pattern)"/>
        </svg>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-white" data-aos="fade-up">
            <h1 class="text-4xl lg:text-5xl font-bold mb-4">
                Edit 
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">{{ $course->title }}</span>
            </h1>
            <p class="text-xl text-white/90">Manage your course details, sections, and lessons</p>
        </div>
    </div>
</section>

<!-- Edit Course Tabs -->
<section class="sticky top-0 bg-white shadow-md z-30 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex overflow-x-auto hide-scrollbar">
            <!-- Tab Navigation -->
            <nav class="flex space-x-1" aria-label="Tabs" x-data="{ activeTab: window.location.hash ? window.location.hash : '#course-details' }">
                <a href="#course-details"
                   @click="activeTab = '#course-details'"
                   :class="{ 'border-indigo-600 text-indigo-600': activeTab === '#course-details', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== '#course-details' }"
                   class="group inline-flex items-center py-4 px-6 border-b-2 font-medium text-lg transition duration-200">
                    <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Course Details
                </a>

                <a href="#curriculum"
                   @click="activeTab = '#curriculum'"
                   :class="{ 'border-indigo-600 text-indigo-600': activeTab === '#curriculum', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== '#curriculum' }"
                   class="group inline-flex items-center py-4 px-6 border-b-2 font-medium text-lg transition duration-200">
                    <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Curriculum
                </a>
            </nav>
        </div>
    </div>
</section>

<!-- Tab Content -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ activeTab: window.location.hash ? window.location.hash : '#course-details' }">
        
        <!-- Course Details Tab -->
        <div x-show="activeTab === '#course-details'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <!-- Course Details Form -->
            <form action="{{ route('instructor.courses.update', $course) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

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
                                   value="{{ old('title', $course->title) }}"
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
                                      required>{{ old('description', $course->description) }}</textarea>
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
                                @foreach($categories as $category)
                                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
                                        <input type="checkbox" 
                                               name="categories[]" 
                                               value="{{ $category->id }}"
                                               {{ in_array($category->id, old('categories', $course->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                                               class="mr-3 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm font-medium text-gray-700">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('categories')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                                    <option value="beginner" {{ old('level', $course->level) === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ old('level', $course->level) === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ old('level', $course->level) === 'advanced' ? 'selected' : '' }}>Advanced</option>
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
                                           value="{{ old('price', $course->price) }}"
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
                            <div class="mt-4" id="requirements-container">
                                @if(old('requirements'))
                                    @foreach(old('requirements') as $key => $requirement)
                                        <div class="flex items-center mb-2 requirement-row">
                                            <input type="text" name="requirements[]" value="{{ $requirement }}" class="form-input w-full" placeholder="Enter a requirement">
                                            <button type="button" class="ml-2 bg-red-500 text-white p-2 rounded delete-requirement">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @elseif(isset($course->requirements))
                                    @php
                                        $requirementsList = is_string($course->requirements) ? json_decode($course->requirements, true) : $course->requirements;
                                        $requirementsList = is_array($requirementsList) ? $requirementsList : [];
                                    @endphp
                                    
                                    @foreach($requirementsList as $requirement)
                                        <div class="flex items-center mb-2 requirement-row">
                                            <input type="text" name="requirements[]" value="{{ $requirement }}" class="form-input w-full" placeholder="Enter a requirement">
                                            <button type="button" class="ml-2 bg-red-500 text-white p-2 rounded delete-requirement">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="flex items-center mb-2 requirement-row">
                                        <input type="text" name="requirements[]" class="form-input w-full" placeholder="Enter a requirement">
                                        <button type="button" class="ml-2 bg-red-500 text-white p-2 rounded delete-requirement">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Learning Objectives -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                What Students Will Learn
                            </label>
                            <div class="mt-4" id="objectives-container">
                                @if(old('objectives'))
                                    @foreach(old('objectives') as $key => $objective)
                                        <div class="flex items-center mb-2 objective-row">
                                            <input type="text" name="objectives[]" value="{{ $objective }}" class="form-input w-full" placeholder="Enter a learning objective">
                                            <button type="button" class="ml-2 bg-red-500 text-white p-2 rounded delete-objective">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @elseif(isset($course->objectives))
                                    @php
                                        $objectivesList = is_string($course->objectives) ? json_decode($course->objectives, true) : $course->objectives;
                                        $objectivesList = is_array($objectivesList) ? $objectivesList : [];
                                    @endphp
                                    
                                    @foreach($objectivesList as $objective)
                                        <div class="flex items-center mb-2 objective-row">
                                            <input type="text" name="objectives[]" value="{{ $objective }}" class="form-input w-full" placeholder="Enter a learning objective">
                                            <button type="button" class="ml-2 bg-red-500 text-white p-2 rounded delete-objective">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="flex items-center mb-2 objective-row">
                                        <input type="text" name="objectives[]" class="form-input w-full" placeholder="Enter a learning objective">
                                        <button type="button" class="ml-2 bg-red-500 text-white p-2 rounded delete-objective">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Thumbnail Card -->
                <div class="bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up" data-aos-delay="300">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Course Thumbnail</h2>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Current Thumbnail -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Current Thumbnail
                            </label>
                            <div class="mt-1 rounded-lg overflow-hidden border border-gray-200 bg-gray-50">
                                <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                            </div>
                        </div>

                        <!-- Upload New Thumbnail -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Upload New Thumbnail Image
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
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between" data-aos="fade-up" data-aos-delay="400">
                    <a href="{{ route('instructor.courses.index') }}" 
                       class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition-colors duration-200">
                        Cancel
                    </a>

                    <div>
                        <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            Update Course Details
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Curriculum Tab -->
        <div x-show="activeTab === '#curriculum'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <!-- Section Management -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8" data-aos="fade-up" data-aos-delay="100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Curriculum Management</h2>
                    <button type="button" 
                            onclick="showAddSectionModal()"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add New Section
                    </button>
                </div>

                <!-- Sections Accordion -->
                <div id="sections-container" class="space-y-6">
                    @foreach($course->sections->sortBy('order') as $section)
                        <div class="section-item bg-gray-50 rounded-xl border border-gray-200 overflow-hidden" data-section-id="{{ $section->id }}">
                            <!-- Section Header -->
                            <div class="section-header flex items-center justify-between bg-gray-100 p-4 cursor-pointer hover:bg-gray-200 transition-colors duration-200" onclick="toggleSection(this)">
                                <div class="flex items-center">
                                    <div class="section-handle mr-3 cursor-move">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                        </svg>
                                    </div>
                                    <span class="section-order font-bold text-gray-600 mr-2">{{ $section->order }}.</span>
                                    <h3 class="font-semibold text-lg text-gray-900">{{ $section->title }}</h3>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-500 mr-4">{{ $section->lessons->count() }} lessons</span>
                                    <span class="text-sm text-gray-500 mr-4">{{ $section->duration_in_hours }} hours</span>
                                    <button type="button" 
                                            onclick="event.stopPropagation(); editSection({{ $section->id }}, '{{ $section->title }}')"
                                            class="p-2 text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button type="button" 
                                            onclick="event.stopPropagation(); confirmDeleteSection({{ $section->id }})"
                                            class="p-2 text-red-600 hover:text-red-800 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="section-toggle ml-2 transition-transform duration-300">
                                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Section Content (Lessons) -->
                            <div class="section-content hidden p-6 space-y-4">
                                <!-- Lessons List -->
                                <div class="lessons-container space-y-3">
                                    @foreach($section->lessons->sortBy('order') as $lesson)
                                        <div class="lesson-item flex items-center justify-between bg-white p-4 rounded-lg border border-gray-200 hover:shadow-md transition-all duration-200" data-lesson-id="{{ $lesson->id }}">
                                            <div class="flex items-center flex-1">
                                                <div class="lesson-handle mr-3 cursor-move">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                                    </svg>
                                                </div>
                                                <span class="lesson-order font-medium text-gray-600 mr-2">{{ $lesson->order }}.</span>
                                                
                                                <div class="flex-1">
                                                    <p class="font-medium text-gray-900 flex items-center">
                                                        @if($lesson->video_platform === 'youtube' || $lesson->video_platform === 'vimeo')
                                                            <svg class="w-4 h-4 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                                            </svg>
                                                        @elseif($lesson->video_platform === 'upload')
                                                            <svg class="w-4 h-4 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                                            </svg>
                                                        @else
                                                            <svg class="w-4 h-4 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                            </svg>
                                                        @endif
                                                        {{ $lesson->title }}
                                                        @if($lesson->is_preview)
                                                            <span class="ml-2 px-2 py-0.5 bg-green-100 text-green-800 text-xs font-medium rounded-full">Preview</span>
                                                        @endif
                                                    </p>
                                                    <p class="text-sm text-gray-500">{{ $lesson->formatted_duration }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <button type="button" 
                                                        onclick="editLesson({{ $lesson->id }})"
                                                        class="p-2 text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </button>
                                                <button type="button" 
                                                        onclick="confirmDeleteLesson({{ $lesson->id }})"
                                                        class="p-2 text-red-600 hover:text-red-800 transition-colors duration-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Add Lesson Button -->
                                <div class="flex justify-center">
                                    <button type="button" 
                                            onclick="showAddLessonModal({{ $section->id }})"
                                            class="px-4 py-2 bg-indigo-100 text-indigo-600 rounded-lg hover:bg-indigo-200 transition-colors duration-200 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Add Lesson
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($course->sections->count() === 0)
                        <div class="text-center py-12">
                            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">No sections yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Start building your curriculum by adding sections and lessons.</p>
                            <button type="button" 
                                    onclick="showAddSectionModal()"
                                    class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Add Your First Section
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Modals and JavaScript are outside of the for loop -->
            </div>
        </div>
    </div>
</section>

<!-- Add Section Modal -->
<div id="addSectionModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="addSectionForm" method="POST" action="{{ route('instructor.courses.sections.store', $course->id) }}">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Add New Section</h3>
                    <div class="mt-4">
                        <label for="sectionTitle" class="block text-sm font-medium text-gray-700">Section Title</label>
                        <input type="text" name="title" id="sectionTitle" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Add Section
                    </button>
                    <button type="button" onclick="closeAddSectionModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Section Modal -->
<div id="editSectionModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="editSectionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Section</h3>
                    <div class="mt-4">
                        <label for="editSectionTitle" class="block text-sm font-medium text-gray-700">Section Title</label>
                        <input type="text" name="title" id="editSectionTitle" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Update Section
                    </button>
                    <button type="button" onclick="closeEditSectionModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Lesson Modal -->
<div id="addLessonModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="addLessonForm" method="POST" action="{{ route('instructor.courses.lessons.store', $course->id) }}">
                @csrf
                <input type="hidden" name="section_id" id="lessonSectionId">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Add New Lesson</h3>
                    <div class="mt-4">
                        <label for="lessonTitle" class="block text-sm font-medium text-gray-700">Lesson Title</label>
                        <input type="text" name="title" id="lessonTitle" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="mt-4">
                        <label for="lessonDuration" class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                        <input type="number" name="duration" id="lessonDuration" min="1" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="mt-4 flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="is_preview" id="lessonIsPreview"
                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="lessonIsPreview" class="font-medium text-gray-700">Preview Lesson</label>
                            <p class="text-gray-500">Allow non-enrolled students to preview this lesson</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Add Lesson
                    </button>
                    <button type="button" onclick="closeAddLessonModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Lesson Modal -->
<div id="editLessonModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="editLessonForm" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Lesson</h3>
                    <div class="mt-4">
                        <label for="editLessonTitle" class="block text-sm font-medium text-gray-700">Lesson Title</label>
                        <input type="text" name="title" id="editLessonTitle" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="mt-4">
                        <label for="editLessonDuration" class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                        <input type="number" name="duration" id="editLessonDuration" min="1" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="mt-4 flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="is_preview" id="editLessonIsPreview"
                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="editLessonIsPreview" class="font-medium text-gray-700">Preview Lesson</label>
                            <p class="text-gray-500">Allow non-enrolled students to preview this lesson</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Update Lesson
                    </button>
                    <button type="button" onclick="closeEditLessonModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmationModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="deleteModalTitle">Delete Item</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="deleteModalMessage">
                                    Are you sure you want to delete this item? This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Preview thumbnail image on upload
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').classList.remove('hidden');
                document.getElementById('image-preview').querySelector('img').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Requirements functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Add requirement
        document.getElementById('add-requirement').addEventListener('click', function() {
            const container = document.getElementById('requirements-container');
            const newRow = document.createElement('div');
            newRow.className = 'flex items-center mb-2 requirement-row';
            newRow.innerHTML = `
                <input type="text" name="requirements[]" class="form-input w-full" placeholder="Enter a requirement">
                <button type="button" class="ml-2 bg-red-500 text-white p-2 rounded delete-requirement">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(newRow);
            
            // Add event listener to the new delete button
            newRow.querySelector('.delete-requirement').addEventListener('click', function() {
                this.parentElement.remove();
            });
        });
        
        // Delete requirement
        document.querySelectorAll('.delete-requirement').forEach(button => {
            button.addEventListener('click', function() {
                this.parentElement.remove();
            });
        });
        
        // Add objective
        document.getElementById('add-objective').addEventListener('click', function() {
            const container = document.getElementById('objectives-container');
            const newRow = document.createElement('div');
            newRow.className = 'flex items-center mb-2 objective-row';
            newRow.innerHTML = `
                <input type="text" name="objectives[]" class="form-input w-full" placeholder="Enter a learning objective">
                <button type="button" class="ml-2 bg-red-500 text-white p-2 rounded delete-objective">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(newRow);
            
            // Add event listener to the new delete button
            newRow.querySelector('.delete-objective').addEventListener('click', function() {
                this.parentElement.remove();
            });
        });
        
        // Delete objective
        document.querySelectorAll('.delete-objective').forEach(button => {
            button.addEventListener('click', function() {
                this.parentElement.remove();
            });
        });

        // Toggle section content
        window.toggleSection = function(element) {
            const content = element.nextElementSibling;
            const arrow = element.querySelector('.section-toggle svg');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                arrow.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                arrow.style.transform = 'rotate(0)';
            }
        }

        // Add Section Modal
        window.showAddSectionModal = function() {
            document.getElementById('addSectionModal').classList.remove('hidden');
        }

        window.closeAddSectionModal = function() {
            document.getElementById('addSectionModal').classList.add('hidden');
            document.getElementById('addSectionForm').reset();
        }

        // Handle Add Section Form Submission
        document.getElementById('addSectionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const formData = new FormData(form);
            
            // AJAX request to create section
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to show the new section
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });

        // Edit Section Modal
        window.editSection = function(sectionId, title) {
            document.getElementById('editSectionTitle').value = title;
            document.getElementById('editSectionForm').action = "{{ route('instructor.courses.sections.index', $course->id) }}/" + sectionId;
            document.getElementById('editSectionModal').classList.remove('hidden');
        }

        window.closeEditSectionModal = function() {
            document.getElementById('editSectionModal').classList.add('hidden');
            document.getElementById('editSectionForm').reset();
        }

        // Handle Edit Section Form Submission
        document.getElementById('editSectionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const formData = new FormData(form);
            
            // AJAX request to update section
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to show updated section
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });

        // Delete Section Confirmation
        window.confirmDeleteSection = function(sectionId) {
            document.getElementById('deleteModalTitle').textContent = 'Delete Section';
            document.getElementById('deleteModalMessage').textContent = 'Are you sure you want to delete this section? This will also delete all lessons in this section. This action cannot be undone.';
            document.getElementById('deleteForm').action = "{{ route('instructor.courses.sections.index', $course->id) }}/" + sectionId;
            document.getElementById('deleteConfirmationModal').classList.remove('hidden');
        }

        // Add Lesson Modal
        window.showAddLessonModal = function(sectionId) {
            document.getElementById('lessonSectionId').value = sectionId;
            document.getElementById('addLessonModal').classList.remove('hidden');
        }

        window.closeAddLessonModal = function() {
            document.getElementById('addLessonModal').classList.add('hidden');
            document.getElementById('addLessonForm').reset();
        }

        // Handle Add Lesson Form Submission
        document.getElementById('addLessonForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const formData = new FormData(form);
            
            // AJAX request to create lesson
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to show the new lesson
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });

        // Edit Lesson Modal
        window.editLesson = function(lessonId) {
            // AJAX request to get lesson details
            fetch("{{ route('instructor.courses.lessons.index', $course->id) }}/" + lessonId + "/edit", {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const lesson = data.lesson;
                    document.getElementById('editLessonTitle').value = lesson.title;
                    document.getElementById('editLessonDuration').value = lesson.duration;
                    document.getElementById('editLessonIsPreview').checked = lesson.is_preview;
                    document.getElementById('editLessonForm').action = "{{ route('instructor.courses.lessons.index', $course->id) }}/" + lessonId;
                    document.getElementById('editLessonModal').classList.remove('hidden');
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }

        window.closeEditLessonModal = function() {
            document.getElementById('editLessonModal').classList.add('hidden');
            document.getElementById('editLessonForm').reset();
        }

        // Handle Edit Lesson Form Submission
        document.getElementById('editLessonForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const formData = new FormData(form);
            
            // AJAX request to update lesson
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to show updated lesson
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });

        // Delete Lesson Confirmation
        window.confirmDeleteLesson = function(lessonId) {
            document.getElementById('deleteModalTitle').textContent = 'Delete Lesson';
            document.getElementById('deleteModalMessage').textContent = 'Are you sure you want to delete this lesson? This action cannot be undone.';
            document.getElementById('deleteForm').action = "{{ route('instructor.courses.lessons.index', $course->id) }}/" + lessonId;
            document.getElementById('deleteConfirmationModal').classList.remove('hidden');
        }

        // Close Delete Modal
        window.closeDeleteModal = function() {
            document.getElementById('deleteConfirmationModal').classList.add('hidden');
        }
    });
</script>
@endpush
