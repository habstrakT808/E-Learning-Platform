<div class="bg-white rounded-lg shadow-sm p-6 mb-6 sticky top-20">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Forum Diskusi</h2>
    </div>
    <div class="space-y-2">
        <a href="{{ route('discussions.index') }}" 
           class="block px-3 py-2 rounded-md {{ request()->routeIs('discussions.index') ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Beranda Forum
            </div>
        </a>
        @auth
            <a href="{{ route('discussions.my') }}" 
               class="block px-3 py-2 rounded-md {{ request()->routeIs('discussions.my') ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                    Diskusi Saya
                </div>
            </a>
            <a href="{{ route('discussions.my-replies') }}" 
               class="block px-3 py-2 rounded-md {{ request()->routeIs('discussions.my-replies') ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                    </svg>
                    Balasan Saya
                </div>
            </a>
            <a href="{{ route('discussions.recent') }}" 
               class="block px-3 py-2 rounded-md {{ request()->routeIs('discussions.recent') ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Terakhir Dilihat
                </div>
            </a>
        @endauth
    </div>

    <div class="mt-6 pt-6 border-t border-gray-100">
        <h3 class="text-sm font-medium text-gray-700 mb-3">Kategori Diskusi</h3>
        <div class="space-y-2">
            <a href="{{ route('discussions.index') }}" 
               class="block px-3 py-2 rounded-md {{ !isset($currentCategory) && request()->routeIs('discussions.index') ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                Semua diskusi
            </a>
            @foreach($categories as $category)
                <a href="{{ route('discussions.category', $category->slug) }}" 
                   class="block px-3 py-2 rounded-md {{ isset($currentCategory) && $currentCategory->id == $category->id ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
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
        @auth
            <a href="{{ route('discussions.create') }}" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md inline-flex items-center justify-center transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Mulai Diskusi Baru
            </a>
        @else
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-3">Login untuk mulai berdiskusi dengan komunitas</p>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center w-full px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    Login
                </a>
            </div>
        @endauth
    </div>
</div> 