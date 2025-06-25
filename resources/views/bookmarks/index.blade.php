<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden bg-gradient-to-br from-purple-600 via-blue-600 to-indigo-700 rounded-2xl shadow-xl">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-40 h-40 bg-purple-300 opacity-20 rounded-full"></div>
            
            <div class="relative flex items-center justify-between p-8">
                <div class="flex items-center">
                    <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-3 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-white leading-tight">
                {{ __('Bookmark Saya') }}
            </h2>
                        <p class="text-purple-100 mt-1">Kelola dan atur koleksi bookmark Anda</p>
                    </div>
                </div>
                
                <div class="flex space-x-3">
                    <a href="{{ route('bookmark-categories.create') }}" class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 backdrop-blur-sm text-black font-medium rounded-xl hover:bg-opacity-30 focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-30 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="black">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    {{ __('Kategori Baru') }}
                </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-purple-50 via-blue-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-purple-100">
                <div class="p-0">
                    <!-- Main Content -->
                    <div class="flex flex-col lg:flex-row">
                        <!-- Sidebar -->
                        <div class="w-full lg:w-80 bg-gradient-to-b from-purple-50 via-blue-50 to-white p-8 border-r border-purple-100">
                            <!-- Filter Section -->
                            <div class="mb-10">
                                <div class="flex items-center mb-6">
                                    <div class="bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">Filter</h3>
                                </div>
                                
                                <div class="space-y-3">
                                    <a href="{{ route('bookmarks.index') }}" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-300 {{ !request('type') && !request('category_id') ? 'bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg transform scale-105' : 'text-gray-700 hover:bg-gradient-to-r hover:from-purple-100 hover:to-blue-100 hover:scale-105' }}">
                                        <div class="bg-white bg-opacity-20 rounded-lg p-2 mr-3 group-hover:bg-opacity-30 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                            </svg>
                                        </div>
                                        <span class="font-medium">Semua</span>
                                        <span class="ml-auto bg-white bg-opacity-80 text-purple-700 text-xs rounded-full px-3 py-1 font-bold shadow-sm">{{ $counts['all'] }}</span>
                                    </a>
                                    
                                    <a href="{{ route('bookmarks.index', ['type' => 'lesson']) }}" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-300 {{ request('type') == 'lesson' ? 'bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg transform scale-105' : 'text-gray-700 hover:bg-gradient-to-r hover:from-purple-100 hover:to-blue-100 hover:scale-105' }}">
                                        <div class="bg-white bg-opacity-20 rounded-lg p-2 mr-3 group-hover:bg-opacity-30 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        </div>
                                        <span class="font-medium">Pelajaran</span>
                                        <span class="ml-auto bg-white bg-opacity-80 text-purple-700 text-xs rounded-full px-3 py-1 font-bold shadow-sm">{{ $counts['lesson'] }}</span>
                                    </a>
                                    
                                    <a href="{{ route('bookmarks.index', ['type' => 'resource']) }}" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-300 {{ request('type') == 'resource' ? 'bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg transform scale-105' : 'text-gray-700 hover:bg-gradient-to-r hover:from-purple-100 hover:to-blue-100 hover:scale-105' }}">
                                        <div class="bg-white bg-opacity-20 rounded-lg p-2 mr-3 group-hover:bg-opacity-30 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        </div>
                                        <span class="font-medium">Materi</span>
                                        <span class="ml-auto bg-white bg-opacity-80 text-purple-700 text-xs rounded-full px-3 py-1 font-bold shadow-sm">{{ $counts['resource'] }}</span>
                                    </a>
                                    
                                    <a href="{{ route('bookmarks.index', ['type' => 'discussion']) }}" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-300 {{ request('type') == 'discussion' ? 'bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg transform scale-105' : 'text-gray-700 hover:bg-gradient-to-r hover:from-purple-100 hover:to-blue-100 hover:scale-105' }}">
                                        <div class="bg-white bg-opacity-20 rounded-lg p-2 mr-3 group-hover:bg-opacity-30 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                        </div>
                                        <span class="font-medium">Diskusi</span>
                                        <span class="ml-auto bg-white bg-opacity-80 text-purple-700 text-xs rounded-full px-3 py-1 font-bold shadow-sm">{{ $counts['discussion'] }}</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Categories Section -->
                            <div class="mb-10">
                                <div class="flex items-center mb-6">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Kategori</h3>
                                </div>
                                
                                <div class="space-y-3">
                                    @foreach($categories as $category)
                                    <a href="{{ route('bookmarks.index', ['category_id' => $category->id]) }}" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-300 {{ request('category_id') == $category->id ? 'bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow-lg transform scale-105' : 'text-gray-700 hover:bg-gradient-to-r hover:from-purple-100 hover:to-blue-100 hover:scale-105' }}">
                                        <div class="relative mr-3">
                                            <span class="h-6 w-6 rounded-full shadow-lg border-2 border-white" style="background-color: {{ $category->color }}"></span>
                                            <span class="absolute -top-1 -right-1 h-3 w-3 bg-white rounded-full shadow-sm"></span>
                                        </div>
                                        <span class="font-medium">{{ $category->name }}</span>
                                        <span class="ml-auto bg-white bg-opacity-80 text-purple-700 text-xs rounded-full px-3 py-1 font-bold shadow-sm">{{ $category->bookmark_count }}</span>
                                    </a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Favorites Section -->
                            @if($favorites->count() > 0)
                            <div>
                                <div class="flex items-center mb-6">
                                    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-lg p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">Favorit Terbaru</h3>
                                </div>
                                
                                <div class="space-y-4">
                                    @foreach($favorites as $favorite)
                                    <a href="{{ $favorite->url }}" class="group block p-4 bg-white border-2 border-purple-100 rounded-xl hover:border-purple-300 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                                        <div class="flex items-center">
                                            <div class="relative">
                                                <span class="h-12 w-12 rounded-xl flex items-center justify-center text-white shadow-lg transform group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, {{ $favorite->color }}, {{ $favorite->color }}99)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                </svg>
                                            </span>
                                                <div class="absolute -top-1 -right-1 h-4 w-4 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full shadow-lg"></div>
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <p class="text-sm font-bold text-gray-900 group-hover:text-purple-600 transition-colors">{{ Str::limit($favorite->title, 25) }}</p>
                                                <p class="text-xs font-medium text-purple-500 bg-purple-50 px-2 py-1 rounded-full inline-block mt-1">{{ ucfirst($favorite->type) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Main Content -->
                        <div class="w-full p-8">
                            <!-- Search and Sort Controls -->
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-10 space-y-6 lg:space-y-0">
                                <form class="w-full lg:w-auto">
                                    <div class="relative w-full lg:w-96">
                                        <input type="hidden" name="type" value="{{ request('type') }}">
                                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                                        <input type="hidden" name="sort" value="{{ request('sort', 'created_at') }}">
                                        <input type="hidden" name="order" value="{{ request('order', 'desc') }}">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <div class="bg-blue-500 rounded-lg p-1">
                                                <svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                            </svg>
                                            </div>
                                        </div>
                                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-28 pr-4 py-4 border-2 border-purple-200 rounded-2xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-purple-200 focus:border-purple-400 text-sm shadow-lg transition-all duration-300" placeholder="Cari bookmark favorit Anda...">
                                    </div>
                                </form>

                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-3 bg-gradient-to-r from-purple-50 to-blue-50 px-4 py-2 rounded-xl border border-purple-200">
                                        <div class="bg-blue-500 rounded-lg p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-bold text-purple-700">Urutkan:</span>
                                    </div>
                                    <select onchange="window.location.href = this.value" class="block pl-4 pr-10 py-3 text-sm border-2 border-purple-200 focus:outline-none focus:ring-4 focus:ring-purple-200 focus:border-purple-400 rounded-xl shadow-lg bg-white font-medium text-gray-700 transition-all duration-300">
                                        <option value="{{ route('bookmarks.index', array_merge(request()->except(['sort', 'order', 'page']), ['sort' => 'created_at', 'order' => 'desc'])) }}" {{ request('sort') == 'created_at' && request('order') == 'desc' ? 'selected' : '' }}>✨ Terbaru</option>
                                        <option value="{{ route('bookmarks.index', array_merge(request()->except(['sort', 'order', 'page']), ['sort' => 'created_at', 'order' => 'asc'])) }}" {{ request('sort') == 'created_at' && request('order') == 'asc' ? 'selected' : '' }}>⏰ Terlama</option>
                                        <option value="{{ route('bookmarks.index', array_merge(request()->except(['sort', 'order', 'page']), ['sort' => 'title', 'order' => 'asc'])) }}" {{ request('sort') == 'title' && request('order') == 'asc' ? 'selected' : '' }}>🔤 Judul (A-Z)</option>
                                        <option value="{{ route('bookmarks.index', array_merge(request()->except(['sort', 'order', 'page']), ['sort' => 'title', 'order' => 'desc'])) }}" {{ request('sort') == 'title' && request('order') == 'desc' ? 'selected' : '' }}>🔤 Judul (Z-A)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Bookmarks Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                                @forelse($bookmarks as $bookmark)
                                <div class="group bg-white border-2 border-purple-100 rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl hover:border-purple-300 transition-all duration-500 transform hover:scale-105 hover:rotate-1">
                                    <div class="p-6">
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="flex items-center flex-1">
                                                <div class="relative">
                                                    <span class="h-14 w-14 rounded-2xl flex items-center justify-center text-white shadow-lg transform group-hover:scale-110 group-hover:rotate-12 transition-all duration-300" style="background: linear-gradient(135deg, {{ $bookmark->color }}, {{ $bookmark->color }}cc)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                    </svg>
                                                </span>
                                                    <div class="absolute -top-1 -right-1 h-5 w-5 bg-gradient-to-r from-purple-400 to-blue-400 rounded-full shadow-lg animate-pulse"></div>
                                                </div>
                                                <div class="ml-4 flex-1">
                                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-purple-600 transition-colors leading-tight">{{ Str::limit($bookmark->title, 30) }}</h3>
                                                    <p class="text-sm font-semibold text-purple-600 mt-1">{{ ucfirst($bookmark->type) }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="relative" x-data="{ open: false }">
                                                <button @click="open = !open" class="p-2 text-gray-500 hover:text-purple-600 focus:outline-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                                    </svg>
                                                </button>
                                                <div x-show="open" 
                                                     @click.away="open = false"
                                                     x-transition:enter="transition ease-out duration-100"
                                                     x-transition:enter-start="transform opacity-0 scale-95"
                                                     x-transition:enter-end="transform opacity-100 scale-100"
                                                     x-transition:leave="transition ease-in duration-75"
                                                     x-transition:leave-start="transform opacity-100 scale-100"
                                                     x-transition:leave-end="transform opacity-0 scale-95"
                                                     class="absolute right-0 mt-2 w-48 rounded-xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                                    <div class="py-1">
                                                        <a href="{{ route('bookmarks.edit', $bookmark) }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-blue-50 hover:text-purple-700 transition-all duration-300 rounded-xl mx-2" style="transform: translateY(0px);">
                                                            <div class="bg-blue-500 rounded-lg p-1 mr-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                            </div>
                                                            <span class="font-medium">Edit Bookmark</span>
                                                        </a>
                                                        <form action="{{ route('bookmarks.destroy', $bookmark) }}" method="POST" class="block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="flex w-full items-center px-4 py-3 text-sm text-red-600 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 hover:text-red-700 transition-all duration-300 rounded-xl mx-2">
                                                                <div class="bg-red-500 rounded-lg p-1 mr-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                    </svg>
                                                                </div>
                                                                <span class="font-medium">Hapus Bookmark</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @if($bookmark->category)
                                        <div class="mb-4">
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold shadow-lg border-2 border-white transform group-hover:scale-105 transition-all" style="background: linear-gradient(135deg, {{ $bookmark->category->color }}22, {{ $bookmark->category->color }}44); color: {{ $bookmark->category->color }}; border-color: {{ $bookmark->category->color }}33;">
                                                <span class="h-2 w-2 rounded-full mr-2 shadow-sm" style="background-color: {{ $bookmark->category->color }}"></span>
                                                {{ $bookmark->category->name }}
                                            </span>
                                        </div>
                                        @endif
                                        
                                        @if($bookmark->notes)
                                        <div class="mb-6 rounded-xl p-4 border border-purple-100">
                                            <p class="text-sm text-gray-700 leading-relaxed">{{ Str::limit($bookmark->notes, 100) }}</p>
                                        </div>
                                        @endif
                                        
                                        <div class="flex justify-between items-center pt-4 border-t border-purple-100">
                                            <a href="{{ $bookmark->url }}" style="background-color: #3B82F6;" class="inline-flex items-center px-6 py-3 text-white font-bold rounded-xl hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                </svg>
                                                <span class="text-white">Buka</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-span-full flex justify-center items-center py-20">
                                    <div style="width: 100%; display: flex; justify-content: center; align-items: center;">
                                        <div class="text-center" style="max-width: 400px;">
                                            <div class="relative inline-block mb-8">
                                                <div class="bg-gradient-to-r from-purple-100 to-blue-100 rounded-full p-10">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-24 w-24 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                        </svg>
                                                </div>
                                                <div class="absolute -top-2 -right-2 h-6 w-6 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full animate-bounce"></div>
                                            </div>
                                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum ada bookmark</h3>
                                            <p class="text-lg text-gray-500">
                                                {{ request('search') ? 'Tidak ada hasil yang cocok dengan pencarian Anda. Coba kata kunci lain!' : 'Mulai simpan konten favorit Anda sebagai bookmark untuk akses yang lebih mudah.' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforelse
                            </div>

                            <!-- Pagination -->
                            <div class="mt-12">
                                <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-2xl p-6 border border-purple-200">
                                {{ $bookmarks->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Confirm delete with beautiful alert
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (confirm('🗑️ Apakah Anda yakin ingin menghapus bookmark ini? Tindakan ini tidak dapat dibatalkan.')) {
                        this.submit();
                    }
                });
            });

            // Add some interactive animations
            document.querySelectorAll('a, button').forEach(element => {
                element.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                element.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
    @endpush
</x-app-layout> 