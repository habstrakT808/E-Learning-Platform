@extends('layouts.app')

@section('content')
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-16 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-4xl font-bold mb-2">Diskusi Terakhir Dilihat</h1>
                <p class="text-lg opacity-90">Diskusi yang baru-baru ini telah Anda kunjungi</p>
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
                            <h2 class="text-xl font-semibold text-gray-800">Forum Diskusi</h2>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('discussions.index') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                    </svg>
                                    Beranda Forum
                                </div>
                            </a>
                            <a href="{{ route('discussions.my') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                    </svg>
                                    Diskusi Saya
                                </div>
                            </a>
                            <a href="{{ route('discussions.my-replies') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                    </svg>
                                    Balasan Saya
                                </div>
                            </a>
                            <a href="{{ route('discussions.recent') }}" class="block px-3 py-2 rounded-md bg-primary-50 text-primary-700 font-medium">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Terakhir Dilihat
                                </div>
                            </a>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <h3 class="text-sm font-medium text-gray-700 mb-3">Kategori Diskusi</h3>
                            <div class="space-y-2">
                                @foreach($categories as $category)
                                    <a href="{{ route('discussions.category', $category->slug) }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50">
                                        <div class="flex items-center">
                                            @if($category->icon)
                                                <span class="mr-2 flex-shrink-0 w-4 h-4 {!! $category->icon !!}"></span>
                                            @else
                                                <span class="mr-2 flex-shrink-0 w-3 h-3 rounded-full" style="background-color: {{ $category->color }}"></span>
                                            @endif
                                            {{ $category->name }}
                                        </div>
                                    </a>
                                @endforeach
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
                    <!-- Discussion List -->
                    <div class="space-y-4">
                        @forelse($recentDiscussions as $discussion)
                            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                                <div class="flex flex-row">
                                    <!-- Vote Column -->
                                    <div class="py-4 px-3 flex flex-col items-center justify-center border-r border-gray-100 bg-gray-50 text-center">
                                        <div class="flex flex-col items-center w-12">
                                            <span class="text-xs text-gray-500 mb-1">Votes</span>
                                            <span class="text-lg font-semibold text-gray-700">{{ $discussion->votes_count }}</span>
                                            
                                            <div class="w-full border-t border-gray-200 my-2"></div>
                                            
                                            <span class="text-xs text-gray-500 mb-1">Balasan</span>
                                            <span class="text-lg font-semibold text-gray-700">{{ $discussion->replies_count }}</span>
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

                                            <div class="flex items-center space-x-4 mt-2 sm:mt-0">
                                                <div class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    Terakhir dilihat: {{ $discussion->pivot->viewed_at->diffForHumans() }}
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
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                
                                <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada diskusi yang dilihat</h3>
                                <p class="text-gray-500 mb-6">Mulai jelajahi forum diskusi untuk melihat daftar diskusi yang telah Anda kunjungi</p>
                                
                                <a href="{{ route('discussions.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-md font-medium inline-flex items-center transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                    </svg>
                                    Jelajahi Forum Diskusi
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 