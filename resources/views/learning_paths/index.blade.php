@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Learning Paths</h1>
                    
                    <!-- Search and Filter -->
                    <div class="mb-8">
                        <form action="{{ route('learning_paths.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                            <div class="flex-grow">
                                <input type="text" name="search" value="{{ $search ?? '' }}" 
                                    placeholder="Search learning paths..." 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            </div>
                            
                            <div class="w-full md:w-auto">
                                <select name="difficulty" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                    <option value="all" {{ ($difficulty ?? '') == 'all' ? 'selected' : '' }}>All Levels</option>
                                    <option value="beginner" {{ ($difficulty ?? '') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ ($difficulty ?? '') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ ($difficulty ?? '') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                            </div>
                            
                            <div class="w-full md:w-auto">
                                <button type="submit" class="w-full px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                    Filter
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Learning Paths Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($paths as $path)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden flex flex-col">
                                <div class="h-40 bg-cover bg-center" style="background-image: url('{{ $path->thumbnail_url }}')"></div>
                                
                                <div class="p-5 flex-grow flex flex-col">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="bg-{{ $path->difficulty_level == 'beginner' ? 'green' : ($path->difficulty_level == 'intermediate' ? 'yellow' : 'red') }}-100 text-{{ $path->difficulty_level == 'beginner' ? 'green' : ($path->difficulty_level == 'intermediate' ? 'yellow' : 'red') }}-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ ucfirst($path->difficulty_level) }}
                                        </span>
                                        <span class="text-gray-500 text-sm">{{ $path->stages_count }} stages</span>
                                    </div>
                                    
                                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">{{ $path->title }}</h5>
                                    
                                    <p class="mb-3 font-normal text-gray-700 line-clamp-3 flex-grow">
                                        {{ $path->short_description ?? Str::limit($path->description, 100) }}
                                    </p>
                                    
                                    <div class="mt-4 flex justify-between items-center">
                                        <span class="text-sm text-gray-600">
                                            <i class="fas fa-clock mr-1"></i> {{ $path->estimated_hours }} hours
                                        </span>
                                        
                                        @if(in_array($path->id, $enrolledPathIds ?? []))
                                            <a href="{{ route('learning_paths.dashboard', $path) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-primary-600 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                                Continue
                                                <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                                </svg>
                                            </a>
                                        @else
                                            <a href="{{ route('learning_paths.show', $path) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-primary-600 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                                View Path
                                                <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 py-8 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No learning paths found</h3>
                                <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $paths->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 