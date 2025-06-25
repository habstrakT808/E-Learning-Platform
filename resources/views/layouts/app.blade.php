{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Learning Platform') }} @yield('title')</title>
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIj4KICA8cmVjdCB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgZmlsbD0iIzNCODJGNiIgcng9IjEwMCIgLz4KICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSg5MCwgMTAwKSBzY2FsZSgwLjY1KSI+CiAgICA8cGF0aCBkPSJNNDAgODBMNDAgMzkwQzQwIDQwOC40IDU0LjQgNDI0IDcyIDQyNEgzNTJDMzY5LjYgNDI0IDM4NCA0MDguNCAzODQgMzkwVjEyOEgxMzhDMTI5LjIgMTI4IDEyMiAxMjAuOCAxMjIgMTEyVjgwSDQwWiIgZmlsbD0iI0ZGRkZGRiIvPgogICAgPHBhdGggZD0iTTEyMiAxMTJWMEg5MEM3MS42IDAgNTYgMTUuNiA1NiAzNFY0MjRIMTA0VjQxNkg0MFY0NDhINzJDOTAuNCA0NDggMTA0IDQzMi40IDEwNCA0MTRWMTEySDEyMloiIGZpbGw9IiNGRkZGRkYiLz4KICAgIDxwYXRoIGQ9Ik0zODQgOTZIMjg4QzI1Ni40IDk2IDIxNiA1OC45IDIxNiAwVjk2SDM4NFoiIGZpbGw9IiNGRkZGRkYiLz4KICA8L2c+Cjwvc3ZnPg==" type="image/svg+xml">
    
    <!-- Meta Description -->
    <meta name="description" content="@yield('meta_description', 'Learn new skills with our comprehensive online courses. Expert instructors, interactive content, and certificates.')">
    
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', 'Learn new skills with our comprehensive online courses.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900" rel="stylesheet" />
    
    <!-- Heroicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/heroicons@2.0.18/24/outline/style.css">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Head Content -->
    @stack('head')

    <style>
        /* Notes Sidebar Styles */
        #notes-sidebar-container {
            position: fixed;
            inset: 0;
            z-index: 2147483647;
            display: none;
        }

        #notes-sidebar-container.active {
            display: block;
        }

        #notes-sidebar-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2147483646;
            opacity: 0;
            transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(4px);
        }

        #notes-sidebar-container.active #notes-sidebar-overlay {
            opacity: 1;
        }

        #notes-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: 400px;
            height: 100vh;
            background: linear-gradient(to bottom right, #ffffff, #f0f7ff);
            box-shadow: -4px 0 24px rgba(0, 0, 0, 0.1);
            z-index: 2147483647;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            transform: translateX(100%);
        }

        #notes-sidebar.open {
            transform: translateX(0);
        }

        #notes-sidebar-container.active #notes-sidebar {
            /* Remove old right/transform rules here */
        }

        /* Notes Sidebar Content Styles */
        .notes-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
        }

        .notes-content {
            padding: 1.5rem;
            height: calc(100vh - 180px);
            overflow-y: auto;
        }

        .notes-footer {
            padding: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
        }

        .notes-textarea {
            width: 100%;
            height: 100%;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 0.75rem;
            resize: none;
            transition: all 0.2s ease;
        }

        .notes-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .notes-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        /* Close button animation */
        .notes-close-button {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .notes-close-button:hover {
            transform: rotate(90deg);
        }

        /* Notes button animation */
        .notes-button svg {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .notes-button:hover svg {
            transform: rotate(12deg);
        }

    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
        <div class="text-center">
            <div class="loading-dots mx-auto mb-4">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <p class="text-gray-600 font-medium">Loading...</p>
        </div>
    </div>

    <div class="min-h-screen">
        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="flex-1">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button @click="show = false" class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button @click="show = false" class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.footer')
    </div>

    <!-- Scroll to Top Button -->
    <button id="scroll-to-top" class="fixed bottom-8 right-8 bg-primary-600 text-white p-3 rounded-full shadow-lg hover:bg-primary-700 transform transition-all duration-300 scale-0 hover:scale-110" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <!-- AOS JavaScript -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Swiper JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize AOS -->
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
    </script>

    <!-- Additional Scripts -->
    @stack('scripts')

    <script>
        // Hide loading screen when page is loaded
        window.addEventListener('load', function() {
            const loadingScreen = document.getElementById('loading-screen');
            if (loadingScreen) {
                loadingScreen.style.opacity = '0';
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                }, 300);
            }
        });

        // Show/hide scroll to top button
        window.addEventListener('scroll', function() {
            const scrollButton = document.getElementById('scroll-to-top');
            if (window.pageYOffset > 300) {
                scrollButton.classList.remove('scale-0');
                scrollButton.classList.add('scale-100');
            } else {
                scrollButton.classList.remove('scale-100');
                scrollButton.classList.add('scale-0');
            }
        });

        // Auto-hide flash messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[x-data*="show"]');
            alerts.forEach(alert => {
                if (alert.__x) {
                    alert.__x.$data.show = false;
                }
            });
        }, 5000);

        // Toast notifications
        window.showToast = function(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white transform transition-all duration-300 translate-x-full ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 
                type === 'warning' ? 'bg-yellow-500' : 
                'bg-blue-500'
            }`;
            toast.innerHTML = `
                <div class="flex items-center space-x-2">
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 300);
            }, 5000);
        };
    </script>
</body>
</html>