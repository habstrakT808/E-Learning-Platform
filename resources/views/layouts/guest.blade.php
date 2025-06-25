<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LearnHub') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIj4KICA8cmVjdCB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgZmlsbD0iIzNCODJGNiIgcng9IjEwMCIgLz4KICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSg5MCwgMTAwKSBzY2FsZSgwLjY1KSI+CiAgICA8cGF0aCBkPSJNNDAgODBMNDAgMzkwQzQwIDQwOC40IDU0LjQgNDI0IDcyIDQyNEgzNTJDMzY5LjYgNDI0IDM4NCA0MDguNCAzODQgMzkwVjEyOEgxMzhDMTI5LjIgMTI4IDEyMiAxMjAuOCAxMjIgMTEyVjgwSDQwWiIgZmlsbD0iI0ZGRkZGRiIvPgogICAgPHBhdGggZD0iTTEyMiAxMTJWMEg5MEM3MS42IDAgNTYgMTUuNiA1NiAzNFY0MjRIMTA0VjQxNkg0MFY0NDhINzJDOTAuNCA0NDggMTA0IDQzMi40IDEwNCA0MTRWMTEySDEyMloiIGZpbGw9IiNGRkZGRkYiLz4KICAgIDxwYXRoIGQ9Ik0zODQgOTZIMjg4QzI1Ni40IDk2IDIxNiA1OC45IDIxNiAwVjk2SDM4NFoiIGZpbGw9IiNGRkZGRkYiLz4KICA8L2c+Cjwvc3ZnPg==" type="image/svg+xml">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .auth-background {
                background-color: #f9fafb;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%233b82f6' fill-opacity='0.05'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3Cpath d='M6 5V0H5v5H0v1h5v94h1V6h94V5H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            }
            
            .floating-shape {
                position: absolute;
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                border-radius: 50%;
                filter: blur(50px);
                opacity: 0.1;
                z-index: -1;
                animation: float 8s ease-in-out infinite;
            }
            
            .shape-1 {
                width: 300px;
                height: 300px;
                top: -150px;
                right: -150px;
                animation-delay: 0s;
            }
            
            .shape-2 {
                width: 200px;
                height: 200px;
                bottom: -100px;
                left: -100px;
                animation-delay: 2s;
            }
            
            .shape-3 {
                width: 150px;
                height: 150px;
                bottom: 250px;
                right: -75px;
                animation-delay: 4s;
            }
            
            @keyframes float {
                0% {
                    transform: translateY(0px) rotate(0deg);
                }
                50% {
                    transform: translateY(-20px) rotate(5deg);
                }
                100% {
                    transform: translateY(0px) rotate(0deg);
                }
            }
            
            .logo-glow {
                filter: drop-shadow(0 0 15px rgba(59, 130, 246, 0.3));
                transition: all 0.3s ease;
            }
            
            .logo-glow:hover {
                filter: drop-shadow(0 0 25px rgba(59, 130, 246, 0.5));
                transform: scale(1.05);
            }
            
            .auth-card {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-radius: 1rem;
                box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1), 0 8px 10px -6px rgba(59, 130, 246, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                transition: all 0.2s ease;
            }
            
            .auth-card:hover {
                box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.2), 0 8px 10px -6px rgba(59, 130, 246, 0.2);
            }
        </style>
    </head>
    <body class="font-sans antialiased auth-background">
        <div class="min-h-screen flex flex-col justify-center items-center pt-12 sm:pt-10 relative overflow-hidden">
            <!-- Animated Shapes -->
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
            
            <div class="z-10 mt-8">
                <a href="/" class="logo-glow flex flex-col items-center justify-center mb-6">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-12 h-12 text-white mt-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="absolute -top-1 -right-1 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-yellow-800" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        <h2 class="text-xl font-bold bg-gradient-to-r from-primary-500 to-primary-700 bg-clip-text text-transparent">
                            LearnHub
                        </h2>
                        <p class="text-sm text-gray-500">Learn & Grow</p>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-8 auth-card z-10">
                {{ $slot }}
            </div>
            
            <!-- Footer -->
            <div class="mt-8 mb-8 pb-4 text-center text-sm text-gray-500 z-10">
                &copy; {{ date('Y') }} LearnHub. All rights reserved.
            </div>
        </div>
    </body>
</html>
