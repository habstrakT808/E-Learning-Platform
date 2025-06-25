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
                        @if(isset($course))
                            <li>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                    <a href="{{ route('discussions.course', $course->slug) }}" class="ml-1 md:ml-2 text-white hover:text-indigo-200">
                                        {{ $course->title }}
                                    </a>
                                </div>
                            </li>
                        @endif
                    </ol>
                </nav>

                <h1 class="text-3xl font-bold mb-2">Buat Diskusi Baru</h1>
                <p class="text-lg opacity-90">Mulai percakapan baru dengan komunitas</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form action="{{ route('discussions.store') }}" method="POST">
                    @csrf
                    
                    @if(isset($course))
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                    @endif
                    
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            class="w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('title') border-red-500 @enderror"
                            value="{{ old('title') }}" 
                            required
                            autocomplete="off"
                            placeholder="Buat judul yang ringkas dan informatif"
                        >
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="discussion_category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <div class="relative">
                            <select 
                                name="discussion_category_id" 
                                id="discussion_category_id" 
                                class="w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('discussion_category_id') border-red-500 @enderror appearance-none pr-10"
                                required
                            >
                                <option value="">Pilih kategori...</option>
                                @foreach($categories as $category)
                                    <option 
                                        value="{{ $category->id }}" 
                                        {{ old('discussion_category_id') == $category->id ? 'selected' : '' }}
                                        style="{{ $category->is_course_specific ? 'color: #4338ca; font-weight: 500;' : '' }}"
                                        data-icon="{{ $category->icon }}"
                                        data-color="{{ $category->color }}"
                                    >
                                        {{ $category->name }} {{ $category->is_course_specific ? '(Khusus Kursus)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div id="category-badge" class="mt-2 hidden">
                            <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                <span id="category-icon-display" class="mr-1"></span>
                                <span id="category-name-display"></span>
                            </div>
                        </div>
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
                            placeholder="Deskripsikan pertanyaan atau topik diskusi Anda secara detail"
                        >{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-2">
                            * Anda dapat menggunakan format @username untuk mention pengguna
                        </p>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <a href="{{ isset($course) ? route('discussions.course', $course->slug) : route('discussions.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none">
                            Buat Diskusi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('discussion_category_id');
        const categoryBadge = document.getElementById('category-badge');
        const categoryIconDisplay = document.getElementById('category-icon-display');
        const categoryNameDisplay = document.getElementById('category-name-display');
        
        // Fungsi untuk menampilkan badge kategori
        function updateCategoryBadge() {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            
            if (categorySelect.value) {
                const color = selectedOption.dataset.color || '#3498db';
                const icon = selectedOption.dataset.icon;
                const categoryName = selectedOption.text;
                
                // Update badge style
                categoryBadge.style.display = 'block';
                categoryBadge.querySelector('div').style.backgroundColor = color + '20'; // 20% opacity
                categoryBadge.querySelector('div').style.color = color;
                
                // Update icon dan nama
                if (icon) {
                    categoryIconDisplay.innerHTML = `<i class="${icon}"></i>`;
                } else {
                    categoryIconDisplay.innerHTML = `<span class="inline-block w-2 h-2 rounded-full mr-1" style="background-color: ${color}"></span>`;
                }
                
                categoryNameDisplay.textContent = categoryName;
                categoryBadge.classList.remove('hidden');
            } else {
                categoryBadge.classList.add('hidden');
            }
        }
        
        // Update kategori saat halaman dimuat
        updateCategoryBadge();
        
        // Update ketika kategori berubah
        categorySelect.addEventListener('change', updateCategoryBadge);
    });
</script>
@endpush 