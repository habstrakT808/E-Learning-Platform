@extends('layouts.app')

@section('content')
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-16 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-4xl font-bold mb-2">Diskusi Saya</h1>
                <p class="text-lg opacity-90">Kelola dan pantau semua diskusi yang telah Anda buat</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6 sticky top-20">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-800">Filter</h2>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('discussions.my', ['filter' => 'all']) }}" 
                               class="block px-3 py-2 rounded-md {{ $filter == 'all' ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                Semua diskusi
                            </a>
                            <a href="{{ route('discussions.my', ['filter' => 'solved']) }}" 
                               class="block px-3 py-2 rounded-md {{ $filter == 'solved' ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                Diskusi terjawab
                            </a>
                            <a href="{{ route('discussions.my', ['filter' => 'unsolved']) }}" 
                               class="block px-3 py-2 rounded-md {{ $filter == 'unsolved' ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                Diskusi belum terjawab
                            </a>
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <h3 class="text-sm font-medium text-gray-700 mb-3">Berdasarkan status</h3>
                            <div class="space-y-2">
                                <a href="{{ route('discussions.my', ['status' => 'active']) }}" 
                                   class="block px-3 py-2 rounded-md {{ $status == 'active' ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                    Aktif
                                </a>
                                <a href="{{ route('discussions.my', ['status' => 'pinned']) }}" 
                                   class="block px-3 py-2 rounded-md {{ $status == 'pinned' ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                    Dipin
                                </a>
                            </div>
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <a href="{{ route('discussions.create') }}" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md inline-flex items-center justify-center transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Mulai Diskusi Baru
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Sort options -->
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-5">
                        <div class="flex flex-wrap items-center justify-between">
                            <div class="flex items-center space-x-2 text-sm text-gray-500">
                                <span>Urutkan:</span>
                                <select id="sort" class="border border-gray-300 rounded-md py-1 px-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                    <option value="most_viewed" {{ $sort == 'most_viewed' ? 'selected' : '' }}>Terbanyak dilihat</option>
                                    <option value="most_replies" {{ $sort == 'most_replies' ? 'selected' : '' }}>Terbanyak balasan</option>
                                </select>
                            </div>
                            
                            <a href="{{ route('discussions.create') }}" class="sm:hidden bg-primary-600 hover:bg-primary-700 text-white py-1.5 px-3 rounded-md text-sm inline-flex items-center justify-center transition-colors duration-200 mt-3 sm:mt-0 w-full sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Diskusi Baru
                            </a>
                        </div>
                    </div>

                    <!-- Discussion List -->
                    <div class="space-y-4">
                        @forelse($discussions as $discussion)
                            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                                <div class="flex flex-row">
                                    <!-- Stats Column -->
                                    <div class="py-4 px-3 flex flex-col items-center justify-between border-r border-gray-100 bg-gray-50 text-center">
                                        <div class="flex flex-col items-center w-14">
                                            <div class="text-xs text-gray-500 mb-1">Balasan</div>
                                            <div class="text-lg font-semibold text-gray-700">{{ $discussion->replies_count }}</div>
                                            
                                            <div class="w-full border-t border-gray-200 my-2"></div>
                                            
                                            <div class="text-xs text-gray-500 mb-1">Dilihat</div>
                                            <div class="text-lg font-semibold text-gray-700">{{ $discussion->views_count }}</div>
                                        </div>
                                    </div>

                                    <!-- Content Column -->
                                    <div class="p-4 flex-1">
                                        <div class="flex items-center text-xs text-gray-500 mb-2">
                                            <span class="inline-flex items-center rounded-md bg-primary-50 px-2 py-1 text-xs font-medium text-primary-700 mr-2">
                                                {{ $discussion->category->name }}
                                            </span>
                                            
                                            @if($discussion->course)
                                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                                                    </svg>
                                                    {{ $discussion->course->title }}
                                                </span>
                                            @endif
                                            
                                            @if($discussion->is_pinned)
                                                <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                    </svg>
                                                    Dipin
                                                </span>
                                            @endif
                                            
                                            @if($discussion->is_answered)
                                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                    </svg>
                                                    Terjawab
                                                </span>
                                            @endif
                                        </div>

                                        <h3 class="font-semibold text-lg mb-2">
                                            <a href="{{ route('discussions.show', $discussion->slug) }}" class="text-gray-900 hover:text-primary-700">
                                                {{ $discussion->title }}
                                            </a>
                                        </h3>
                                        
                                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($discussion->content), 150) }}
                                        </p>
                                        
                                        <div class="flex items-center justify-between text-sm text-gray-600">
                                            <div>
                                                {{ $discussion->created_at->format('d M Y, H:i') }}
                                                {{ $discussion->created_at != $discussion->updated_at ? '(Diperbarui: ' . $discussion->updated_at->format('d M Y, H:i') . ')' : '' }}
                                            </div>

                                            <div class="flex space-x-3">
                                                <a href="{{ route('discussions.edit', $discussion->slug) }}" class="text-primary-600 hover:text-primary-800">
                                                    Edit
                                                </a>
                                                
                                                <form method="POST" action="{{ route('discussions.destroy', $discussion->slug) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus diskusi ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 text-center">
                                <div class="mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-12 w-12 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                    </svg>
                                </div>
                                
                                <h3 class="text-lg font-medium text-gray-900 mb-1">Anda belum memiliki diskusi</h3>
                                <p class="text-gray-500 mb-6">Mulai diskusi pertama Anda dan dapatkan bantuan dari komunitas</p>
                                
                                <a href="{{ route('discussions.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-md font-medium inline-flex items-center transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Mulai Diskusi
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $discussions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle sort change
            const sortSelect = document.getElementById('sort');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    const url = new URL(window.location);
                    url.searchParams.set('sort', this.value);
                    window.location.href = url.toString();
                });
            }
        });
    </script>
@endpush 