@props(['discussion'])

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
                
                <!-- Views and Replies Indicator -->
                <div class="mt-4 pt-3 border-t border-gray-200 flex flex-col items-center w-full">
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-xs text-gray-500">{{ $discussion->views_count }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>
                        <span class="text-xs text-gray-500">{{ $discussion->replies_count }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Column -->
        <div class="p-4 flex-1">
            <div class="flex items-center text-xs text-gray-500 mb-2">
                @if($discussion->category)
                    <span class="inline-flex items-center rounded-md bg-primary-50 px-2 py-1 text-xs font-medium text-primary-700 mr-2">
                        {{ $discussion->category->name }}
                    </span>
                @endif
                
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
            
            <div class="flex flex-wrap items-center justify-between text-sm text-gray-600">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <img src="{{ $discussion->user->getAvatarUrlAttribute() }}" alt="{{ $discussion->user->name }}" class="rounded-full w-5 h-5 mr-2">
                        <span class="font-medium text-gray-900">{{ $discussion->user->name }}</span>
                    </div>
                    <span>
                        {{ $discussion->created_at ? $discussion->created_at->diffForHumans() : 'Recently' }}
                    </span>
                </div>

                <div class="flex items-center mt-2 sm:mt-0">
                    @if (isset($discussion->latest_reply) && $discussion->latest_reply)
                        <div class="text-xs text-gray-500">
                            Balasan terakhir: {{ $discussion->latest_reply->created_at ? $discussion->latest_reply->created_at->diffForHumans() : 'Recently' }}
                        </div>
                    @endif
                    
                    @if(isset($discussion->pivot) && isset($discussion->pivot->viewed_at))
                        <div class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Dilihat: {{ $discussion->pivot->viewed_at ? $discussion->pivot->viewed_at->diffForHumans() : 'Recently' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div> 