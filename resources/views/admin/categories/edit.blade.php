@extends('layouts.app')

@section('title', ' | Edit Category')

@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .icon-preview {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            border-radius: 0.375rem;
        }
    </style>
@endpush

@section('content')
<div class="py-6 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold text-gray-900">Edit Category: {{ $category->name }}</h1>
                <p class="mt-1 text-sm text-gray-600">Update the details of this category</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Categories
                </a>
            </div>
        </div>
        
        <!-- Form Card -->
        <div class="bg-white shadow-sm rounded-lg">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="space-y-6">
                    <!-- Category Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Category Name <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="text" name="name" id="name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="e.g. Web Development" value="{{ old('name', $category->name) }}" required>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">This will be displayed as the category name and used to generate the slug.</p>
                    </div>
                    
                    <!-- Parent Category -->
                    <div>
                        <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent Category</label>
                        <div class="mt-1">
                            <select name="parent_id" id="parent_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <option value="">None (Root Category)</option>
                                @foreach ($categories as $parentCategory)
                                    <option value="{{ $parentCategory->id }}" {{ (old('parent_id', $category->parent_id) == $parentCategory->id) ? 'selected' : '' }}>
                                        {{ $parentCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Note: You cannot select this category or any of its descendants as a parent.</p>
                    </div>
                    
                    <!-- Icon -->
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700">Icon</label>
                        <div class="mt-1 flex items-center space-x-3">
                            <div id="icon-preview" class="icon-preview bg-gray-100">
                                @if($category->icon)
                                    <i class="{{ $category->icon }}"></i>
                                @else
                                    <i class="fas fa-folder"></i>
                                @endif
                            </div>
                            <div class="w-full">
                                <input type="text" name="icon" id="icon" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="e.g. fas fa-code" value="{{ old('icon', $category->icon) }}">
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Enter a Font Awesome icon class (e.g. fas fa-code, far fa-file, etc.) - <a href="https://fontawesome.com/icons" target="_blank" class="text-indigo-600 hover:text-indigo-900">Browse Icons</a></p>
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="mt-1">
                            <textarea id="description" name="description" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Brief description of this category...">{{ old('description', $category->description) }}</textarea>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Optional. Provide a short description of what this category includes.</p>
                    </div>
                    
                    <!-- Current Information -->
                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Additional Information</h3>
                        <div class="grid grid-cols-2 gap-4 text-xs">
                            <div>
                                <span class="text-gray-500">Created:</span>
                                <span class="text-gray-700">{{ $category->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Last Updated:</span>
                                <span class="text-gray-700">{{ $category->updated_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Slug:</span>
                                <span class="text-gray-700">{{ $category->slug }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Courses:</span>
                                <span class="text-gray-700">{{ $category->courses_count }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-5 border-t border-gray-200">
                        <div class="flex justify-end">
                            <button type="button" onclick="window.location.href='{{ route('admin.categories.index') }}'" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </button>
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Category
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const iconInput = document.getElementById('icon');
        const iconPreview = document.getElementById('icon-preview');
        
        // Update icon preview when input changes
        iconInput.addEventListener('input', function() {
            if (this.value) {
                iconPreview.innerHTML = `<i class="${this.value}"></i>`;
                
                // Extract color class from FontAwesome icon class (assumes fa-colorname pattern)
                const iconClass = this.value;
                const colorPattern = /fa-([a-z]+)(?:\s|$)/;
                const colorMatch = iconClass.match(colorPattern);
                
                // Common colors used in Font Awesome
                const commonColors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'blue', 'red', 'green', 'yellow', 'purple', 'pink'];
                
                // Set background color if the match is one of the common colors
                if (colorMatch && commonColors.includes(colorMatch[1])) {
                    iconPreview.className = `icon-preview bg-${colorMatch[1]}-100`;
                } else {
                    iconPreview.className = 'icon-preview bg-gray-100';
                }
            } else {
                iconPreview.innerHTML = '<i class="fas fa-folder"></i>';
                iconPreview.className = 'icon-preview bg-gray-100';
            }
        });
        
        // Trigger initial preview
        if (iconInput.value) {
            const event = new Event('input');
            iconInput.dispatchEvent(event);
        }
    });
</script>
@endpush 