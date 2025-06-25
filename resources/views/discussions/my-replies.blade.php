@extends('layouts.app')

@section('content')
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-16 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-4xl font-bold mb-2">Balasan Saya</h1>
                <p class="text-lg opacity-90">Diskusi yang telah Anda berikan balasan atau jawaban</p>
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
                            <a href="{{ route('discussions.my-replies', ['filter' => 'all']) }}" 
                               class="block px-3 py-2 rounded-md {{ $filter == 'all' ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                Semua balasan
                            </a>
                            <a href="{{ route('discussions.my-replies', ['filter' => 'solutions']) }}" 
                               class="block px-3 py-2 rounded-md {{ $filter == 'solutions' ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                Jawaban solusi
                            </a>
                            <a href="{{ route('discussions.my-replies', ['filter' => 'latest']) }}" 
                               class="block px-3 py-2 rounded-md {{ $filter == 'latest' ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                Terbaru
                            </a>
                            <a href="{{ route('discussions.my-replies', ['filter' => 'oldest']) }}" 
                               class="block px-3 py-2 rounded-md {{ $filter == 'oldest' ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                Terlama
                            </a>
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <a href="{{ route('discussions.index') }}" class="w-full bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 py-2 px-4 rounded-md inline-flex items-center justify-center transition-colors duration-200 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                </svg>
                                Kembali ke Forum
                            </a>
                            
                            <a href="{{ route('discussions.create') }}" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md inline-flex items-center justify-center transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Mulai Diskusi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Replies List -->
                    <div class="space-y-4">
                        @forelse($replies as $reply)
                            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                                <div class="flex flex-col">
                                    <!-- Discussion Header -->
                                    <div class="p-4 border-b border-gray-100 bg-gray-50">
                                        <div class="flex items-center justify-between">
                                            <h3 class="font-medium">
                                                <a href="{{ route('discussions.show', $reply->discussion->slug) }}" class="text-primary-600 hover:text-primary-800">
                                                    {{ $reply->discussion->title }}
                                                </a>
                                            </h3>
                                            
                                            <div class="flex items-center space-x-2">
                                                <div class="text-xs text-gray-500">
                                                    {{ $reply->created_at->format('d M Y, H:i') }}
                                                </div>
                                                
                                                @if($reply->is_solution)
                                                    <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                        </svg>
                                                        Solusi
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center text-xs text-gray-500 mt-1">
                                            <span class="inline-flex items-center mr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1 text-gray-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                                </svg>
                                                {{ $reply->discussion->user->name }}
                                            </span>
                                            
                                            <span class="inline-flex items-center mr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1 text-gray-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                                </svg>
                                                {{ $reply->discussion->replies_count }} balasan
                                            </span>
                                            
                                            @if($reply->discussion->category)
                                                <span class="inline-flex items-center rounded-md bg-primary-50 px-2 py-1 text-xs font-medium text-primary-700">
                                                    {{ $reply->discussion->category->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Reply Content -->
                                    <div class="p-4">
                                        <div class="prose max-w-none text-sm text-gray-700 mb-3 line-clamp-3">
                                            {!! nl2br(e(\Illuminate\Support\Str::limit($reply->content, 250))) !!}
                                        </div>
                                        
                                        <div class="flex items-center justify-between text-xs">
                                            <div class="flex items-center space-x-2">
                                                <span class="inline-flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1 text-gray-400">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                                                    </svg>
                                                    {{ $reply->votes_count }}
                                                </span>
                                                
                                                @if($reply->children && $reply->children->count() > 0)
                                                    <span class="inline-flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1 text-gray-400">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                                        </svg>
                                                        {{ $reply->children->count() }} balasan
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <div class="flex space-x-3 text-xs">
                                                <a href="{{ route('discussions.show', ['slug' => $reply->discussion->slug]) }}#reply-{{ $reply->id }}" class="text-primary-600 hover:text-primary-800 font-medium">
                                                    Lihat Diskusi
                                                </a>
                                                
                                                <a href="{{ route('discussions.replies.edit', $reply->id) }}" class="text-gray-600 hover:text-gray-900">
                                                    Edit
                                                </a>
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
                                
                                <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada balasan</h3>
                                <p class="text-gray-500 mb-6">Anda belum memberikan balasan pada diskusi manapun</p>
                                
                                <a href="{{ route('discussions.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-md font-medium inline-flex items-center transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                    </svg>
                                    Jelajahi Forum Diskusi
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $replies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 