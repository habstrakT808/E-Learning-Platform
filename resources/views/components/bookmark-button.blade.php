@props(['model', 'type', 'size' => 'md', 'label' => false])

@php
$isBookmarked = $model->isBookmarkedBy(auth()->id());
$bookmark = $model->getBookmarkFor(auth()->id());
$categories = auth()->user()->bookmarkCategories()->orderBy('name')->get();
$sizeClasses = [
    'sm' => 'h-8 w-8',
    'md' => 'h-10 w-10',
    'lg' => 'h-12 w-12'
];
$iconSize = $sizeClasses[$size] ?? $sizeClasses['md'];
$modelId = $model->id;
$componentId = "bookmark-component-{$modelId}";
$modelClass = str_replace('\\', '\\\\', get_class($model));
@endphp

<style>
    /* Ensure the bookmark popup is above everything else */
    .bookmark-popup {
        z-index: 999999999 !important;
        position: fixed;
        border-radius: 1rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        background-color: white;
        width: 320px;
        border: 2px solid #e9d5ff;
    }
    
    /* Fix for any parent elements that might have overflow hidden */
    #{{ $componentId }} {
        position: relative !important;
        z-index: 999999999 !important;
    }
    
    /* Make sure the bookmark form is visible above all other elements */
    .bookmark-form-container {
        position: relative;
        z-index: 999999999 !important;
    }
    
    /* Force the popup to be visible and above everything */
    .bookmark-popup-visible {
        display: block !important;
        z-index: 999999999 !important;
    }
    
    /* Overlay to capture clicks outside the popup */
    .bookmark-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.1);
        z-index: 99999999;
    }
    
    /* Container for the popup at body level */
    #bookmark-container-root {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 0;
        overflow: visible;
        z-index: 999999999;
        pointer-events: none;
    }
    
    #bookmark-container-root > * {
        pointer-events: auto;
    }
</style>

<div 
    id="{{ $componentId }}"
    x-data="{ 
        open: false,
        closePopup() {
            this.open = false;
            const popup = document.getElementById('bookmark-popup-{{ $modelId }}');
            if (popup) popup.style.display = 'none';
            const overlay = document.getElementById('bookmark-overlay-{{ $modelId }}');
            if (overlay) overlay.remove();
        }
    }"
    class="relative bookmark-container"
>
    <button 
        @click="
            open = !open; 
            $nextTick(() => { 
                if(open) {
                    const popup = document.getElementById('bookmark-popup-{{ $modelId }}');
                    if (popup) popup.style.display = 'block';
                    const overlay = document.createElement('div');
                    overlay.id = 'bookmark-overlay-{{ $modelId }}';
                    overlay.className = 'bookmark-overlay';
                    overlay.addEventListener('click', () => closePopup());
                    document.body.appendChild(overlay);
                    positionBookmarkPopup();
                } else {
                    closePopup();
                }
            })
        "
        type="button" 
        class="{{ $label ? 'group relative overflow-hidden px-6 py-3 bg-white hover:bg-gray-50 text-gray-900 border-2 border-purple-300 rounded-xl font-bold transition-all duration-300 flex items-center transform hover:scale-105 shadow-lg hover:shadow-xl' : 'inline-flex items-center justify-center rounded-2xl ' . $iconSize . ' bg-white hover:bg-gray-50 text-gray-900 focus:outline-none focus:ring-4 focus:ring-purple-200 border-2 border-purple-300 transition-all duration-300 transform hover:scale-110 shadow-lg' }}"
    >
        @if($label)
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-900" fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
            </svg>
            <span class="font-bold text-gray-900">{{ $isBookmarked ? 'Edit Bookmark' : 'Bookmark' }}</span>
        @else
        <span class="sr-only">{{ $isBookmarked ? 'Edit Bookmark' : 'Tambah Bookmark' }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-900" fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
        </svg>
        @endif
        
        @if($isBookmarked)
            <div class="absolute -top-1 -right-1 h-4 w-4 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full shadow-lg animate-pulse"></div>
        @endif
    </button>
</div>

<!-- Placeholder for the popup that will be moved to body level -->
<div 
    id="bookmark-popup-{{ $modelId }}"
    style="display: none;"
    class="bookmark-popup"
>
    <div class="p-6 bookmark-form-container">
        <div class="flex items-center mb-4">
            <div class="bg-gradient-to-r from-purple-500 to-blue-500 rounded-xl p-2 mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">{{ $isBookmarked ? 'Edit Bookmark' : 'Tambah Bookmark' }}</h3>
            
            <button 
                type="button" 
                onclick="closeBookmarkPopup_{{ $modelId }}()" 
                class="ml-auto bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full p-1 transition-colors"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form id="bookmark-form-{{ $modelId }}" class="space-y-5">
                @csrf
            <input type="hidden" name="bookmarkable_type" value="{{ $type ?? strtolower(class_basename($model)) }}">
                <input type="hidden" name="bookmarkable_id" value="{{ $modelId }}">
                
                <div>
                <label for="bookmark_category_id-{{ $modelId }}" class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                <select name="bookmark_category_id" id="bookmark_category_id-{{ $modelId }}" class="block w-full pl-4 pr-10 py-3 text-gray-900 border-2 border-purple-200 focus:outline-none focus:ring-4 focus:ring-purple-200 focus:border-purple-400 text-sm rounded-xl shadow-lg bg-white font-medium transition-all duration-300">
                    <option value="" class="text-gray-500">-- Tanpa Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $bookmark && $bookmark->bookmark_category_id == $category->id ? 'selected' : '' }}
                            class="text-gray-900 font-medium">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                <label for="notes-{{ $modelId }}" class="block text-sm font-bold text-gray-700 mb-2">Catatan</label>
                    <textarea 
                        name="notes" 
                        id="notes-{{ $modelId }}" 
                        rows="3"
                    class="shadow-lg focus:ring-4 focus:ring-purple-200 focus:border-purple-400 block w-full text-sm border-2 border-purple-200 text-gray-900 rounded-xl p-4 bg-gradient-to-r from-purple-50 to-blue-50 font-medium transition-all duration-300 placeholder-gray-400"
                    placeholder="Tambahkan catatan personal Anda..."
                    >{{ $bookmark ? $bookmark->notes : '' }}</textarea>
                </div>
                
            <div class="flex justify-between pt-4 border-t border-purple-100">
                    @if($isBookmarked)
                    <button 
                        type="button"
                        onclick="removeBookmark_{{ $modelId }}()"
                    class="inline-flex items-center px-4 py-3 border-2 border-red-200 shadow-lg text-sm font-bold rounded-xl text-red-600 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-4 focus:ring-red-200 transition-all duration-300 transform hover:scale-105"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </button>
                    <button 
                        type="button"
                        onclick="saveBookmark_{{ $modelId }}()"
                    class="inline-flex items-center px-6 py-3 border-2 border-purple-300 text-sm font-bold rounded-xl shadow-lg text-gray-900 bg-white hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-purple-200 transition-all duration-300 transform hover:scale-105"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    <span class="text-gray-900">Simpan</span>
                    </button>
                    @else
                    <div></div>
                    <button 
                        type="button"
                        onclick="saveBookmark_{{ $modelId }}()"
                    class="inline-flex items-center px-6 py-3 border-2 border-purple-300 text-sm font-bold rounded-xl shadow-lg text-gray-900 bg-white hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-purple-200 transition-all duration-300 transform hover:scale-105"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    <span class="text-gray-900">Bookmark</span>
                    </button>
                    @endif
                </div>
            </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Create a container at the body level if it doesn't exist
        let container = document.getElementById('bookmark-container-root');
        if (!container) {
            container = document.createElement('div');
            container.id = 'bookmark-container-root';
            document.body.appendChild(container);
        }
    });

    // Function to close the bookmark popup
    function closeBookmarkPopup_{{ $modelId }}() {
        const component = document.getElementById('{{ $componentId }}');
        if (component && typeof Alpine !== 'undefined') {
            Alpine.$data(component).closePopup();
        } else {
            // Fallback if Alpine is not available
            const popup = document.getElementById('bookmark-popup-{{ $modelId }}');
            if (popup) popup.style.display = 'none';
            
            const overlay = document.getElementById('bookmark-overlay-{{ $modelId }}');
            if (overlay) overlay.remove();
        }
    }
    
    // Position the bookmark popup relative to the button
    function positionBookmarkPopup() {
        const bookmarkPopup = document.getElementById('bookmark-popup-{{ $modelId }}');
        const button = document.querySelector('#{{ $componentId }} button');
        
        if (bookmarkPopup && button) {
            const rect = button.getBoundingClientRect();
            
            // Move popup to body to avoid any parent overflow issues
            let container = document.getElementById('bookmark-container-root');
            if (!container) {
                container = document.createElement('div');
                container.id = 'bookmark-container-root';
                document.body.appendChild(container);
            }
            
            // Move the popup to the container if it's not already there
            if (bookmarkPopup.parentElement.id !== 'bookmark-container-root') {
                container.appendChild(bookmarkPopup);
            }
            
            // Position the popup in the center of the screen
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight;
            
            bookmarkPopup.style.position = 'fixed';
            bookmarkPopup.style.top = '50%';
            bookmarkPopup.style.left = '50%';
            bookmarkPopup.style.transform = 'translate(-50%, -50%)';
            bookmarkPopup.style.zIndex = '999999999';
        }
    }
    
    // Define the functions with unique names based on model ID to avoid conflicts
    function saveBookmark_{{ $modelId }}() {
        const form = document.getElementById('bookmark-form-{{ $modelId }}');
        const formData = new FormData(form);
        
        // Close the popup
        closeBookmarkPopup_{{ $modelId }}();
        
        // Debug info
        console.log('Bookmark data:', {
            bookmarkable_type: formData.get('bookmarkable_type'),
            bookmarkable_id: formData.get('bookmarkable_id'),
            bookmark_category_id: formData.get('bookmark_category_id'),
            notes: formData.get('notes'),
            _token: formData.get('_token')
        });
        
        fetch('{{ route('bookmark.debug') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams(formData)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Network response was not ok');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show beautiful notification
                const message = data.message || 'Bookmark berhasil disimpan';
                showNotification(message, 'success');
                
                // Refresh page after a short delay
                setTimeout(() => {
                window.location.reload();
                }, 1000);
            } else {
                console.error('Error response:', data);
                showNotification(data.message || 'Gagal menyimpan bookmark', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Gagal menyimpan bookmark: ' + error.message, 'error');
        });
    }
    
    function removeBookmark_{{ $modelId }}() {
        const form = document.getElementById('bookmark-form-{{ $modelId }}');
        const formData = new FormData(form);
        
        // Close the popup
        closeBookmarkPopup_{{ $modelId }}();
        
        formData.append('toggle', 'true');
        
        // Debug info
        console.log('Remove bookmark data:', {
            bookmarkable_type: formData.get('bookmarkable_type'),
            bookmarkable_id: formData.get('bookmarkable_id'),
            toggle: formData.get('toggle'),
            _token: formData.get('_token')
        });
        
        fetch('{{ route('bookmark.debug') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams(formData)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Network response was not ok');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show beautiful notification
                const message = data.message || 'Bookmark berhasil dihapus';
                showNotification(message, 'success');
                
                // Refresh page after a short delay
                setTimeout(() => {
                window.location.reload();
                }, 1000);
            } else {
                console.error('Error response:', data);
                showNotification(data.message || 'Gagal menghapus bookmark', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Gagal menghapus bookmark: ' + error.message, 'error');
        });
    }
    
    // Beautiful notification function
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-[99999] px-6 py-4 rounded-2xl shadow-2xl border-2 transform transition-all duration-500 ${
            type === 'success' 
                ? 'bg-gradient-to-r from-green-50 to-emerald-50 border-green-200 text-green-800' 
                : 'bg-gradient-to-r from-red-50 to-pink-50 border-red-200 text-red-800'
        }`;
        
        notification.innerHTML = `
            <div class="flex items-center">
                <div class="bg-gradient-to-r ${type === 'success' ? 'from-green-500 to-emerald-500' : 'from-red-500 to-pink-500'} rounded-lg p-1 mr-3">
                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        ${type === 'success' 
                            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />'
                            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />'
                        }
                    </svg>
                </div>
                <span class="font-bold">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 500);
        }, 3000);
    }
    
    // Add global style to fix z-index issues with lesson navigation
    document.addEventListener('DOMContentLoaded', function() {
        const style = document.createElement('style');
        style.textContent = `
            .flex.items-center.justify-between.pt-6.border-t.border-slate-200.relative {
                z-index: 50 !important;
            }
            
            .flex.items-center.justify-between.pt-6.border-t.border-slate-200.relative a {
                z-index: 51 !important;
            }
            
            [x-show="activeTab === 'content'"] {
                z-index: 10 !important;
            }
        `;
        document.head.appendChild(style);
    });
</script> 