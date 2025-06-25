@props(['reply', 'discussion'])

<div id="reply-{{ $reply->id }}" class="bg-white rounded-lg border {{ $reply->is_solution ? 'border-green-500 ring-1 ring-green-500' : 'border-gray-200' }} shadow-sm overflow-hidden {{ $reply->is_solution ? 'border-green-500' : '' }}">
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
                            {{ $reply->created_at ? $reply->created_at->format('d M Y, H:i') : date('d M Y, H:i') }}
                        </div>
                    </div>
                </div>

                <div class="flex space-x-2">
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
                                            {{ $childReply->created_at ? $childReply->created_at->diffForHumans() : 'Recently' }}
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