@extends('layouts.app')

@section('content')
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-8 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <nav class="flex mb-4 text-sm" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('discussions.index') }}" class="inline-flex items-center text-white hover:text-indigo-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Forum Diskusi
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                                <a href="{{ route('discussions.show', $discussion->slug) }}" class="ml-1 md:ml-2 text-white hover:text-indigo-200">
                                    {{ \Illuminate\Support\Str::limit($discussion->title, 30) }}
                                </a>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-3xl font-bold mb-2">Edit Diskusi</h1>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form action="{{ route('discussions.update', $discussion->slug) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            class="w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('title') border-red-500 @enderror"
                            value="{{ old('title', $discussion->title) }}" 
                            required
                            autocomplete="off"
                        >
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="discussion_category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select 
                            name="discussion_category_id" 
                            id="discussion_category_id" 
                            class="w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('discussion_category_id') border-red-500 @enderror"
                            required
                        >
                            <option value="">Pilih kategori...</option>
                            @foreach($categories as $category)
                                <option 
                                    value="{{ $category->id }}" 
                                    {{ (old('discussion_category_id', $discussion->discussion_category_id) == $category->id) ? 'selected' : '' }}
                                    style="{{ $category->is_course_specific ? 'color: #4338ca; font-weight: 500;' : '' }}"
                                >
                                    {{ $category->name }} {{ $category->is_course_specific ? '(Khusus Kursus)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('discussion_category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
                        <textarea 
                            name="content" 
                            id="content" 
                            rows="12" 
                            class="w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('content') border-red-500 @enderror"
                            required
                        >{{ old('content', $discussion->content) }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-2">
                            * Anda dapat menggunakan format @username untuk mention pengguna
                        </p>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('discussions.show', $discussion->slug) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 