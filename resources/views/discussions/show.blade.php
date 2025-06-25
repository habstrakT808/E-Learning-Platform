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
                        @if($discussion->course)
                            <li>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                    <a href="{{ route('discussions.course', $discussion->course->slug) }}" class="ml-1 md:ml-2 text-white hover:text-indigo-200">
                                        {{ $discussion->course->title }}
                                    </a>
                                </div>
                            </li>
                        @endif
                        <li class="inline-flex items-center">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                                <span class="ml-1 md:ml-2 text-white">
                                    {{ \Illuminate\Support\Str::limit($discussion->title, 40) }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-3xl font-bold mb-2">{{ $discussion->title }}</h1>
                <div class="flex items-center text-sm">
                    @if($discussion->category)
                    <span class="inline-flex items-center rounded-md bg-white/20 px-2 py-1 text-xs font-medium text-white mr-2">
                        {{ $discussion->category->name }}
                    </span>
                    @else
                    <span class="inline-flex items-center rounded-md bg-white/20 px-2 py-1 text-xs font-medium text-white mr-2">
                        General
                    </span>
                    @endif
                    @if($discussion->is_pinned)
                        <span class="inline-flex items-center rounded-md bg-amber-400/20 px-2 py-1 text-xs font-medium text-amber-100 mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Dipin
                        </span>
                    @endif
                    @if($discussion->is_answered)
                        <span class="inline-flex items-center rounded-md bg-green-400/20 px-2 py-1 text-xs font-medium text-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            Terjawab
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <!-- Main Discussion Content -->
            <div class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden">
                <div class="flex flex-row">
                    <!-- Vote Column -->
                    <div class="py-6 px-3 flex flex-col items-center justify-start border-r border-gray-100 bg-gray-50">
                        <div class="flex flex-col items-center w-12">
                            @auth
                                <button type="button" 
                                        class="vote-btn" 
                                        data-discussion="{{ $discussion->id }}" 
                                        data-vote="up"
                                        title="Upvote"
                                        data-url="{{ route('discussions.vote', $discussion->slug) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6 {{ $discussion->getUserVote(Auth::id()) === 1 ? 'text-orange-500 fill-orange-500' : 'text-gray-400 hover:text-gray-500' }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </button>
                            @endauth
                            
                            <span class="text-gray-700 font-semibold my-2 text-lg vote-count-discussion">{{ $discussion->votes_count }}</span>
                            
                            @auth
                                <button type="button" 
                                        class="vote-btn" 
                                        data-discussion="{{ $discussion->id }}" 
                                        data-vote="down"
                                        title="Downvote"
                                        data-url="{{ route('discussions.vote', $discussion->slug) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6 {{ $discussion->getUserVote(Auth::id()) === -1 ? 'text-orange-500 fill-orange-500' : 'text-gray-400 hover:text-gray-500' }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            @endauth

                            <div class="mt-6 border-t border-gray-200 pt-4">
                                <div class="flex flex-col items-center text-xs text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mb-1 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $discussion->views_count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Column -->
                    <div class="p-6 flex-1">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <img src="{{ $discussion->user->getAvatarUrlAttribute() }}" alt="{{ $discussion->user->name }}" class="rounded-full w-10 h-10 mr-3">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $discussion->user->name }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $discussion->created_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex space-x-2">
                                @can('update', $discussion)
                                    <a href="{{ route('discussions.edit', $discussion->slug) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                        Edit
                                    </a>
                                @endcan
                                
                                @auth
                                    <x-bookmark-button :model="$discussion" type="discussion" size="sm" />
                                @endauth
                                
                                @can('delete', $discussion)
                                    <form method="POST" action="{{ route('discussions.destroy', $discussion->slug) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus diskusi ini? Semua balasan juga akan dihapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                @endcan
                                
                                @can('pin', $discussion)
                                    <form method="POST" action="{{ route('discussions.pin', $discussion->slug) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md {{ $discussion->is_pinned ? 'text-amber-700 bg-amber-50 hover:bg-amber-100' : 'text-gray-700 bg-white hover:bg-gray-50' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                            {{ $discussion->is_pinned ? 'Unpin' : 'Pin' }}
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>

                        <div class="prose max-w-none text-gray-700 mb-6">
                            {!! nl2br(e($discussion->content)) !!}
                        </div>
                        
                        <div class="flex items-center justify-between text-sm border-t border-gray-100 pt-4">
                            <div class="flex space-x-4">
                                <span class="text-gray-500">
                                    {{ $discussion->created_at != $discussion->updated_at ? 'Diubah ' . $discussion->updated_at->diffForHumans() : '' }}
                                </span>
                            </div>
                            
                            @auth
                                <button type="button" class="inline-flex items-center text-primary-600 hover:text-primary-700" id="toggleReplyForm">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                    </svg>
                                    Balas
                                </button>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reply Form -->
            @auth
                <div id="replyForm" class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden mb-6 p-6 hidden">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Balas Diskusi</h3>
                    
                    <form action="{{ route('discussions.replies.store', $discussion->slug) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Konten Balasan</label>
                            <textarea 
                                name="content" 
                                id="content" 
                                rows="5" 
                                class="w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                placeholder="Tulis balasan Anda di sini..."
                                required
                            >{{ old('content') }}</textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" class="mr-2 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none" id="cancelReply">
                                Batal
                            </button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none">
                                Kirim Balasan
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden mb-6 p-6 text-center">
                    <p class="text-gray-600 mb-4">Anda harus login untuk ikut berdiskusi</p>
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none">
                        Login untuk Membalas
                    </a>
                </div>
            @endauth

            <!-- Replies Header -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">
                    Balasan ({{ $discussion->replies_count }})
                </h2>
                <div class="text-sm text-gray-500">
                    <select id="replySort" class="border border-gray-300 rounded-md text-sm py-1 px-3">
                        <option value="oldest">Terlama</option>
                        <option value="newest">Terbaru</option>
                        <option value="votes">Terbanyak Vote</option>
                    </select>
                </div>
            </div>

            <!-- Replies List -->
            <div class="space-y-6 mb-6">
                @forelse($replies as $reply)
                    <div id="reply-{{ $reply->id }}" class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden {{ $reply->is_solution ? 'border-green-500 ring-1 ring-green-500' : '' }}">
                        <div class="flex flex-row">
                            <!-- Vote Column -->
                            <div class="py-6 px-3 flex flex-col items-center justify-start border-r border-gray-100 bg-gray-50 text-center">
                                <div class="flex flex-col items-center w-12">
                                    @auth
                                        <button type="button" 
                                                class="vote-btn" 
                                                data-reply="{{ $reply->id }}" 
                                                data-vote="up"
                                                title="Upvote"
                                                data-url="{{ route('discussions.replies.vote', $reply->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5 {{ $reply->getUserVote(Auth::id()) === 1 ? 'text-orange-500 fill-orange-500' : 'text-gray-400 hover:text-gray-500' }}">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </button>
                                    @endauth
                                    
                                    <span class="text-gray-700 font-semibold my-2 text-md vote-count-reply-{{ $reply->id }}">{{ $reply->votes_count }}</span>
                                    
                                    @auth
                                        <button type="button" 
                                                class="vote-btn" 
                                                data-reply="{{ $reply->id }}" 
                                                data-vote="down"
                                                title="Downvote"
                                                data-url="{{ route('discussions.replies.vote', $reply->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5 {{ $reply->getUserVote(Auth::id()) === -1 ? 'text-orange-500 fill-orange-500' : 'text-gray-400 hover:text-gray-500' }}">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                    @endauth
                                    
                                    @if($reply->is_solution)
                                        <div class="mt-4 mb-1">
                                            <div class="text-green-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                    <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <span class="text-xs text-green-600 font-medium">Solusi</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Content Column -->
                            <div class="p-6 flex-1">
                                <!-- Reply Header -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <img src="{{ $reply->user->getAvatarUrlAttribute() }}" alt="{{ $reply->user->name }}" class="rounded-full w-8 h-8 mr-3">
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $reply->user->name }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ $reply->created_at->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                    </div>

                                    @if(!$reply->is_solution && (Auth::id() == $discussion->user_id || Auth::user()?->hasRole('admin')))
                                        <form method="POST" action="{{ route('discussions.replies.solution', $reply->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full text-green-700 bg-green-100 hover:bg-green-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Tandai Sebagai Solusi
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <!-- Reply Content -->
                                <div class="prose max-w-none text-gray-700">
                                    {!! nl2br(e($reply->content)) !!}
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-4 flex justify-between text-sm">
                                    <div class="flex space-x-2">
                                        @can('update', $reply)
                                            <a href="{{ route('discussions.replies.edit', $reply->id) }}" class="text-gray-600 hover:text-gray-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline mr-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                                Edit
                                            </a>
                                        @endcan

                                        @can('delete', $reply)
                                            <form method="POST" action="{{ route('discussions.replies.destroy', $reply->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus balasan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline mr-1">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                    
                                    @auth
                                        <button type="button" class="inline-flex items-center text-gray-600 hover:text-gray-900 reply-button" data-parent-id="{{ $reply->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                            </svg>
                                            Balas
                                        </button>
                                    @endauth
                                </div>
                                
                                <!-- Nested Reply Form (hidden by default) -->
                                @auth
                                    <div id="replyForm-{{ $reply->id }}" class="mt-4 border-t border-gray-100 pt-4 hidden">
                                        <form action="{{ route('discussions.replies.store', $discussion->slug) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                                            <div class="mb-3">
                                                <textarea 
                                                    name="content" 
                                                    rows="3" 
                                                    class="w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                                    placeholder="Tulis balasan Anda kepada {{ $reply->user->name }}..."
                                                    required
                                                ></textarea>
                                            </div>
                                            <div class="flex justify-end">
                                                <button type="button" class="mr-2 inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none cancel-nested-reply" data-parent-id="{{ $reply->id }}">
                                                    Batal
                                                </button>
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none">
                                                    Kirim Balasan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endauth

                                <!-- Nested Replies -->
                                @if($reply->children && $reply->children->count() > 0)
                                    <div class="mt-4 space-y-4 border-t border-gray-100 pt-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">{{ $reply->children->count() }} balasan</h4>
                                        
                                        @foreach($reply->children as $childReply)
                                            <div class="pl-4 border-l-2 border-gray-100">
                                                <div class="flex items-start mb-2">
                                                    <img src="{{ $childReply->user->getAvatarUrlAttribute() }}" alt="{{ $childReply->user->name }}" class="rounded-full w-6 h-6 mr-2 mt-0.5">
                                                    <div class="flex-1">
                                                        <div class="flex items-center justify-between">
                                                            <div class="font-medium text-gray-900 text-sm">{{ $childReply->user->name }}</div>
                                                            <div class="text-xs text-gray-500">
                                                                {{ $childReply->created_at->diffForHumans() }}
                                                            </div>
                                                        </div>
                                                        <div class="text-sm text-gray-700 mt-1">
                                                            {!! nl2br(e($childReply->content)) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden mb-6 p-6 text-center">
                        <p class="text-gray-600 mb-4">Tidak ada balasan untuk diskusi ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle main reply form
            const toggleReplyFormButton = document.getElementById('toggleReplyForm');
            const replyFormContainer = document.getElementById('replyForm');
            const cancelReplyButton = document.getElementById('cancelReply');
            
            if (toggleReplyFormButton && replyFormContainer) {
                toggleReplyFormButton.addEventListener('click', function() {
                    replyFormContainer.classList.toggle('hidden');
                    
                    // Scroll to form
                    if (!replyFormContainer.classList.contains('hidden')) {
                        replyFormContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        replyFormContainer.querySelector('textarea').focus();
                    }
                });
            }
            
            if (cancelReplyButton && replyFormContainer) {
                cancelReplyButton.addEventListener('click', function() {
                    replyFormContainer.classList.add('hidden');
                });
            }
            
            // Toggle nested reply forms
            const replyButtons = document.querySelectorAll('.reply-button');
            const cancelNestedReplyButtons = document.querySelectorAll('.cancel-nested-reply');
            
            replyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const parentId = this.getAttribute('data-parent-id');
                    const replyForm = document.getElementById(`replyForm-${parentId}`);
                    
                    // Hide all other forms first
                    document.querySelectorAll('[id^="replyForm-"]').forEach(form => {
                        if (form.id !== `replyForm-${parentId}`) {
                            form.classList.add('hidden');
                        }
                    });
                    
                    // Toggle this form
                    replyForm.classList.toggle('hidden');
                    
                    // Scroll to form and focus
                    if (!replyForm.classList.contains('hidden')) {
                        replyForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        replyForm.querySelector('textarea').focus();
                    }
                });
            });
            
            cancelNestedReplyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const parentId = this.getAttribute('data-parent-id');
                    const replyForm = document.getElementById(`replyForm-${parentId}`);
                    replyForm.classList.add('hidden');
                });
            });
            
            // Vote functionality
            const voteButtons = document.querySelectorAll('.vote-btn');
            
            voteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');
                    const value = this.getAttribute('data-vote');
                    const discussionId = this.getAttribute('data-discussion');
                    const replyId = this.getAttribute('data-reply');
                    
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ value: value })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update vote count based on what was voted on
                            if (discussionId) {
                                document.querySelector('.vote-count-discussion').textContent = data.votes_count;
                            } else if (replyId) {
                                document.querySelector(`.vote-count-reply-${replyId}`).textContent = data.votes_count;
                            }
                            
                            // Update UI for vote buttons
                            const upButton = button.parentElement.querySelector(`[data-vote="up"]`);
                            const downButton = button.parentElement.querySelector(`[data-vote="down"]`);
                            
                            if (upButton) {
                                const svg = upButton.querySelector('svg');
                                if (data.user_vote === 1) {
                                    svg.classList.add('text-orange-500', 'fill-orange-500');
                                    svg.classList.remove('text-gray-400', 'hover:text-gray-500');
                                } else {
                                    svg.classList.remove('text-orange-500', 'fill-orange-500');
                                    svg.classList.add('text-gray-400', 'hover:text-gray-500');
                                }
                            }
                            
                            if (downButton) {
                                const svg = downButton.querySelector('svg');
                                if (data.user_vote === -1) {
                                    svg.classList.add('text-orange-500', 'fill-orange-500');
                                    svg.classList.remove('text-gray-400', 'hover:text-gray-500');
                                } else {
                                    svg.classList.remove('text-orange-500', 'fill-orange-500');
                                    svg.classList.add('text-gray-400', 'hover:text-gray-500');
                                }
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
            
            // Reply sorting
            const replySort = document.getElementById('replySort');
            if (replySort) {
                replySort.addEventListener('change', function() {
                    const url = new URL(window.location);
                    url.searchParams.set('sort', this.value);
                    window.location.href = url.toString();
                });
                
                // Set current sort
                const urlParams = new URLSearchParams(window.location.search);
                const sort = urlParams.get('sort');
                if (sort) {
                    replySort.value = sort;
                }
            }
        });
    </script>
@endpush 