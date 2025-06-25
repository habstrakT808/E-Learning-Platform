@extends('layouts.app')

@section('content')
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-16 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-4xl font-bold mb-2">Diskusi Kursus: {{ $course->title }}</h1>
                <p class="text-lg opacity-90">Tanya jawab dan diskusi seputar materi kursus</p>
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
                            <h2 class="text-xl font-semibold text-gray-800">Kategori</h2>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('discussions.course', $course->slug) }}" 
                               class="block px-3 py-2 rounded-md {{ !isset($category) ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                Semua diskusi
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('discussions.course', [$course->slug, 'category' => $cat->slug]) }}" 
                                   class="block px-3 py-2 rounded-md {{ isset($category) && $category->id == $cat->id ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                    <div class="flex items-center">
                                        @if($cat->icon)
                                            <span class="mr-2 flex-shrink-0 w-4 h-4 {!! $cat->icon !!}"></span>
                                        @else
                                            <span class="mr-2 flex-shrink-0 w-3 h-3 rounded-full" style="background-color: {{ $cat->color }}"></span>
                                        @endif
                                        {{ $cat->name }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <a href="{{ route('course.show', $course->slug) }}" class="w-full inline-flex items-center justify-center text-primary-600 hover:text-primary-700 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                </svg>
                                Kembali ke Kursus
                            </a>
                        </div>
                        
                        @auth
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <a href="{{ route('discussions.create', ['course_id' => $course->id]) }}" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md inline-flex items-center justify-center transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Mulai Diskusi
                                </a>
                            </div>
                        @else
                            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                                <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                    Login untuk memulai diskusi
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Filter options -->
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-5">
                        <div class="flex flex-wrap items-center justify-between">
                            <div class="flex items-center flex-wrap text-sm font-medium">
                                <a href="{{ route('discussions.course', [$course->slug, 'filter' => 'latest']) }}" 
                                   class="mr-4 px-3 py-1.5 rounded-full {{ $filter == 'latest' ? 'bg-primary-100 text-primary-800' : 'text-gray-700 hover:bg-gray-100' }}">
                                    Terbaru
                                </a>
                                <a href="{{ route('discussions.course', [$course->slug, 'filter' => 'popular']) }}" 
                                   class="mr-4 px-3 py-1.5 rounded-full {{ $filter == 'popular' ? 'bg-primary-100 text-primary-800' : 'text-gray-700 hover:bg-gray-100' }}">
                                    Populer
                                </a>
                                <a href="{{ route('discussions.course', [$course->slug, 'filter' => 'votes']) }}" 
                                   class="mr-4 px-3 py-1.5 rounded-full {{ $filter == 'votes' ? 'bg-primary-100 text-primary-800' : 'text-gray-700 hover:bg-gray-100' }}">
                                    Tervoting
                                </a>
                                <a href="{{ route('discussions.course', [$course->slug, 'filter' => 'unanswered']) }}" 
                                   class="mr-4 px-3 py-1.5 rounded-full {{ $filter == 'unanswered' ? 'bg-primary-100 text-primary-800' : 'text-gray-700 hover:bg-gray-100' }}">
                                    Belum dijawab
                                </a>
                                <a href="{{ route('discussions.course', [$course->slug, 'filter' => 'solved']) }}" 
                                   class="px-3 py-1.5 rounded-full {{ $filter == 'solved' ? 'bg-primary-100 text-primary-800' : 'text-gray-700 hover:bg-gray-100' }}">
                                    Terpecahkan
                                </a>
                            </div>
                            
                            @auth
                                <a href="{{ route('discussions.create', ['course_id' => $course->id]) }}" class="sm:hidden bg-primary-600 hover:bg-primary-700 text-white py-1.5 px-3 rounded-md text-sm inline-flex items-center justify-center transition-colors duration-200 mt-3 sm:mt-0 w-full sm:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Diskusi Baru
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Discussion List -->
                    <div class="space-y-4">
                        @forelse($discussions as $discussion)
                            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                                <div class="flex flex-row">
                                    <!-- Vote Column -->
                                    <div class="py-4 px-3 flex flex-col items-center justify-center border-r border-gray-100 bg-gray-50 text-center">
                                        <div class="flex flex-col items-center w-12">
                                            @auth
                                                <button type="button" 
                                                        class="discussion-vote vote-btn" 
                                                        data-discussion="{{ $discussion->id }}" 
                                                        data-vote="up"
                                                        title="Upvote"
                                                        data-url="{{ route('discussions.vote', $discussion->slug) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5 {{ $discussion->getUserVote(Auth::id()) === 1 ? 'text-orange-500 fill-orange-500' : 'text-gray-400 hover:text-gray-500' }}">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                </button>
                                            @endauth
                                            
                                            <span class="text-gray-700 font-semibold my-1 vote-count">{{ $discussion->votes_count }}</span>
                                            
                                            @auth
                                                <button type="button" 
                                                        class="discussion-vote vote-btn" 
                                                        data-discussion="{{ $discussion->id }}" 
                                                        data-vote="down"
                                                        title="Downvote"
                                                        data-url="{{ route('discussions.vote', $discussion->slug) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5 {{ $discussion->getUserVote(Auth::id()) === -1 ? 'text-orange-500 fill-orange-500' : 'text-gray-400 hover:text-gray-500' }}">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                            @endauth
                                        </div>
                                    </div>

                                    <!-- Content Column -->
                                    <div class="p-4 flex-1">
                                        <div class="flex items-center text-xs text-gray-500 mb-2">
                                            <span class="inline-flex items-center rounded-md bg-primary-50 px-2 py-1 text-xs font-medium text-primary-700 mr-2">
                                                {{ $discussion->category->name }}
                                            </span>
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
                                        
                                        <div class="flex flex-wrap items-center justify-between text-sm text-gray-600">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex items-center">
                                                    <img src="{{ $discussion->user->getAvatarUrlAttribute() }}" alt="{{ $discussion->user->name }}" class="rounded-full w-5 h-5 mr-2">
                                                    <span class="font-medium text-gray-900">{{ $discussion->user->name }}</span>
                                                </div>
                                                <span>
                                                    {{ $discussion->created_at->diffForHumans() }}
                                                </span>
                                            </div>

                                            <div class="flex items-center mt-2 sm:mt-0">
                                                <div class="flex items-center mr-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1 text-gray-400">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    {{ $discussion->views_count }}
                                                </div>
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1 text-gray-400">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                                    </svg>
                                                    {{ $discussion->replies_count }}
                                                </div>
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
                                
                                <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada diskusi</h3>
                                <p class="text-gray-500 mb-6">Jadilah yang pertama memulai diskusi di kursus ini!</p>
                                
                                @auth
                                    <a href="{{ route('discussions.create', ['course_id' => $course->id]) }}" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-md font-medium inline-flex items-center transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        Mulai Diskusi
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-md font-medium inline-flex items-center transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                        </svg>
                                        Login untuk Diskusi
                                    </a>
                                @endauth
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