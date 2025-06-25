<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Edit Bookmark') }}
            </h2>
            <a href="{{ route('bookmarks.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Kembali') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('bookmarks.update', $bookmark) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                                <div class="mt-1">
                                    <input type="text" name="title" id="title" value="{{ old('title', $bookmark->title) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Category -->
                            <div>
                                <label for="bookmark_category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                                <div class="mt-1">
                                    <select name="bookmark_category_id" id="bookmark_category_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="">-- Tanpa Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('bookmark_category_id', $bookmark->bookmark_category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('bookmark_category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
                                <div class="mt-1">
                                    <textarea name="notes" id="notes" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('notes', $bookmark->notes) }}</textarea>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Tambahkan catatan atau keterangan tambahan tentang bookmark ini.</p>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Favorite -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="is_favorite" name="is_favorite" type="checkbox" value="1" {{ old('is_favorite', $bookmark->is_favorite) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_favorite" class="font-medium text-gray-700">Tandai sebagai favorit</label>
                                    <p class="text-gray-500">Bookmark favorit akan ditampilkan di bagian teratas.</p>
                                </div>
                            </div>
                            
                            <!-- Bookmark Info -->
                            <div class="bg-gray-50 rounded-md p-4">
                                <h3 class="text-sm font-medium text-gray-900">Informasi Bookmark</h3>
                                <div class="mt-3 text-sm text-gray-500">
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <span class="block text-xs uppercase tracking-wide text-gray-500">Tipe</span>
                                            <span class="block font-medium text-gray-900">{{ ucfirst($bookmark->type) }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-xs uppercase tracking-wide text-gray-500">Dibuat pada</span>
                                            <span class="block font-medium text-gray-900">{{ $bookmark->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 