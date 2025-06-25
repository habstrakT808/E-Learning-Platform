@extends('layouts.app')

@section('title', ' | Category: ' . $category->name)

@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
<div class="py-6 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back navigation + Page heading -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <div class="flex items-center">
                    <a href="{{ route('admin.categories.index') }}" class="mr-2 inline-flex items-center px-2 py-1 border border-transparent rounded-md text-sm font-medium text-indigo-600 hover:bg-indigo-50 hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back
                    </a>

                    @if($category->ancestors()->count() > 0)
                        <div class="text-sm text-gray-500 flex items-center">
                            @foreach($category->ancestors() as $ancestor)
                                <a href="{{ route('admin.categories.show', $ancestor) }}" class="hover:underline hover:text-indigo-600">{{ $ancestor->name }}</a>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            @endforeach
                            <span class="font-medium text-gray-700">{{ $category->name }}</span>
                        </div>
                    @endif
                </div>
                
                <h1 class="text-2xl font-bold text-gray-900 mt-2 flex items-center">
                    @if($category->icon)
                        <span class="mr-3 text-{{ substr($category->icon, 0, strpos($category->icon, ' ')) }}-500">
                            <i class="{{ $category->icon }} text-2xl"></i>
                        </span>
                    @else
                        <span class="mr-3 text-gray-500">
                            <i class="fas fa-folder text-2xl"></i>
                        </span>
                    @endif
                    {{ $category->name }}
                </h1>
                <p class="mt-1 text-sm text-gray-600">{{ $category->description }}</p>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Category
                </a>
                <span class="hidden sm:block ml-3">
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this category?')" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </form>
                </span>
            </div>
        </div>
        
        <!-- Category Info -->
        <div class="bg-white shadow overflow-hidden rounded-lg mb-8">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Category Information</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Details and stats about this category.</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Slug</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $category->slug }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Total Courses</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $category->courses_count }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Subcategories</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $category->children->count() }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $category->created_at->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
        
        <!-- Subcategories -->
        @if($category->children->count() > 0)
            <div class="bg-white shadow overflow-hidden rounded-lg mb-8">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Subcategories</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Categories that belong to {{ $category->name }}</p>
                </div>
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Courses</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($category->children as $child)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($child->icon)
                                                <span class="mr-2 text-{{ substr($child->icon, 0, strpos($child->icon, ' ')) }}-500">
                                                    <i class="{{ $child->icon }}"></i>
                                                </span>
                                            @else
                                                <span class="mr-2 text-gray-500">
                                                    <i class="fas fa-folder"></i>
                                                </span>
                                            @endif
                                            <div class="text-sm font-medium text-gray-900">{{ $child->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $child->courses_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.categories.show', $child) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                        <a href="{{ route('admin.categories.edit', $child) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        
        <!-- Courses in this category -->
        <div class="bg-white shadow overflow-hidden rounded-lg">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Courses</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Courses in this category ({{ $category->courses->count() }})
                    </p>
                </div>
                <a href="{{ route('admin.courses.index') }}?category={{ $category->id }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    View All
                </a>
            </div>
            <div class="overflow-hidden">
                @if($category->courses->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Students</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($category->courses->take(5) as $course)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded object-cover" src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $course->title }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $course->instructor->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($course->status === 'published')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Published
                                            </span>
                                        @elseif($course->status === 'draft')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Draft
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                {{ ucfirst($course->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $course->enrollments_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.courses.show', $course->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="px-6 py-4 text-center text-gray-500">
                        <p>No courses found in this category.</p>
                    </div>
                @endif
                @if($category->courses->count() > 5)
                    <div class="bg-gray-50 px-6 py-3 text-right">
                        <a href="{{ route('admin.courses.index') }}?category={{ $category->id }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                            View all {{ $category->courses->count() }} courses
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 