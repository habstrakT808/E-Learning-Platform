<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Buat Kategori Bookmark Baru') }}
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
                    <form action="{{ route('bookmark-categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 text-gray-900 rounded-md">
                                </div>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <div class="mt-1">
                                    <textarea name="description" id="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 text-gray-900 rounded-md">{{ old('description') }}</textarea>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Deskripsi singkat tentang kategori ini (opsional).</p>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Color -->
                            <div>
                                <label for="color" class="block text-sm font-medium text-gray-700">Warna</label>
                                <div class="mt-1 flex items-center space-x-3">
                                    <input type="color" name="color" id="color" value="{{ old('color', '#3B82F6') }}" class="h-8 w-8 rounded-md border border-gray-300 cursor-pointer">
                                    <span class="text-sm text-gray-500">Pilih warna untuk kategori ini</span>
                                </div>
                                @error('color')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Icon (Optional) -->
                            <div>
                                <label for="icon" class="block text-sm font-medium text-gray-700">Ikon (Opsional)</label>
                                <div class="mt-1">
                                    <select name="icon" id="icon" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 text-gray-900 rounded-md">
                                        <option value="">-- Pilih Ikon --</option>
                                        <option value="book-open" {{ old('icon') == 'book-open' ? 'selected' : '' }}>Buku</option>
                                        <option value="document" {{ old('icon') == 'document' ? 'selected' : '' }}>Dokumen</option>
                                        <option value="link" {{ old('icon') == 'link' ? 'selected' : '' }}>Link</option>
                                        <option value="chat" {{ old('icon') == 'chat' ? 'selected' : '' }}>Chat</option>
                                        <option value="star" {{ old('icon') == 'star' ? 'selected' : '' }}>Bintang</option>
                                        <option value="bookmark" {{ old('icon') == 'bookmark' ? 'selected' : '' }}>Bookmark</option>
                                        <option value="folder" {{ old('icon') == 'folder' ? 'selected' : '' }}>Folder</option>
                                        <option value="tag" {{ old('icon') == 'tag' ? 'selected' : '' }}>Tag</option>
                                    </select>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Pilih ikon yang mewakili kategori ini (opsional).</p>
                                @error('icon')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Buat Kategori
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 