{{-- resources/views/layouts/footer.blade.php --}}
<footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)"/>
        </svg>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-primary-500/10 rounded-full blur-xl animate-pulse"></div>
    <div class="absolute top-32 right-20 w-32 h-32 bg-blue-500/10 rounded-full blur-xl animate-pulse delay-1000"></div>
    <div class="absolute bottom-20 left-1/4 w-24 h-24 bg-purple-500/10 rounded-full blur-xl animate-pulse delay-2000"></div>

    <div class="relative z-10">
        <!-- Main Footer Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                
                <!-- Brand Section -->
                <div class="lg:col-span-1" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="relative">
                            <div class="w-12 h-12 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-yellow-400 rounded-full flex items-center justify-center">
                                <svg class="w-2 h-2 text-yellow-800" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                                LearnHub
                            </h2>
                            <p class="text-sm text-gray-400">Learn & Grow</p>
                        </div>
                    </div>
                    
                    <p class="text-gray-300 leading-relaxed mb-6">
                        Empowering learners worldwide with high-quality online education. Join millions of students and transform your career with our expert-led courses.
                    </p>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="text-center p-4 bg-white/5 rounded-lg backdrop-blur-sm border border-white/10">
                            <div class="text-2xl font-bold text-primary-400">10K+</div>
                            <div class="text-xs text-gray-400">Students</div>
                        </div>
                        <div class="text-center p-4 bg-white/5 rounded-lg backdrop-blur-sm border border-white/10">
                            <div class="text-2xl font-bold text-green-400">500+</div>
                            <div class="text-xs text-gray-400">Courses</div>
                        </div>
                    </div>
                    
                    <!-- Social Media -->
                    <div class="flex space-x-4">
                        <!-- Instagram -->
                        <a href="https://www.instagram.com/hafiyan_a_u/" target="_blank" class="group w-10 h-10 bg-white/10 hover:bg-gradient-to-br from-purple-600 via-pink-500 to-orange-400 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-pink-500/25">
                            <svg class="w-5 h-5 text-gray-300 group-hover:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                            </svg>
                        </a>
                        
                        <!-- LinkedIn -->
                        <a href="https://www.linkedin.com/in/habstrakt808/" target="_blank" class="group w-10 h-10 bg-white/10 hover:bg-blue-700 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-blue-700/25">
                            <svg class="w-5 h-5 text-gray-300 group-hover:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        
                        <!-- Email -->
                        <a href="mailto:jhodywiraputra@gmail.com" class="group w-10 h-10 bg-white/10 hover:bg-green-600 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-green-600/25">
                            <svg class="w-5 h-5 text-gray-300 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </a>
                        
                        <!-- Github -->
                        <a href="https://github.com/habstrakT808" target="_blank" class="group w-10 h-10 bg-white/10 hover:bg-gray-800 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-gray-800/25">
                            <svg class="w-5 h-5 text-gray-300 group-hover:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-lg font-semibold mb-6 flex items-center">
                        <div class="w-1 h-6 bg-gradient-to-b from-primary-400 to-primary-600 rounded-full mr-3"></div>
                        Quick Links
                    </h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('home') }}" class="group flex items-center text-gray-300 hover:text-white transition-all duration-300">
                                <svg class="w-4 h-4 mr-3 text-primary-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('courses.index') }}" class="group flex items-center text-gray-300 hover:text-white transition-all duration-300">
                                <svg class="w-4 h-4 mr-3 text-primary-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                All Courses
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="group flex items-center text-gray-300 hover:text-white transition-all duration-300">
                                <svg class="w-4 h-4 mr-3 text-primary-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="group flex items-center text-gray-300 hover:text-white transition-all duration-300">
                                <svg class="w-4 h-4 mr-3 text-primary-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Contact
                            </a>
                        </li>
                        @auth
                            @if(auth()->user()->isStudent())
                                <li>
                                    <a href="{{ route('student.dashboard') }}" class="group flex items-center text-gray-300 hover:text-white transition-all duration-300">
                                        <svg class="w-4 h-4 mr-3 text-primary-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                        My Dashboard
                                    </a>
                                </li>
                            @elseif(auth()->user()->isInstructor())
                                <li>
                                    <a href="{{ route('instructor.dashboard') }}" class="group flex items-center text-gray-300 hover:text-white transition-all duration-300">
                                        <svg class="w-4 h-4 mr-3 text-primary-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                        Instructor Panel
                                    </a>
                                </li>
                            @endif
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="group flex items-center text-gray-300 hover:text-white transition-all duration-300">
                                    <svg class="w-4 h-4 mr-3 text-primary-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    Sign In
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}" class="group flex items-center text-gray-300 hover:text-white transition-all duration-300">
                                    <svg class="w-4 h-4 mr-3 text-primary-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    Sign Up
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>

                <!-- Categories -->
                <div data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-lg font-semibold mb-6 flex items-center">
                        <div class="w-1 h-6 bg-gradient-to-b from-green-400 to-green-600 rounded-full mr-3"></div>
                        Popular Categories
                    </h3>
                    <ul class="space-y-3">
                        @php
                            $footerCategories = \App\Models\Category::withCount(['courses' => function($query) {
                                $query->where('status', 'published');
                            }])->orderBy('courses_count', 'desc')->take(6)->get();
                        @endphp
                        
                        @foreach($footerCategories as $category)
                            <li>
                                <a href="{{ route('courses.category', $category) }}" class="group flex items-center justify-between text-gray-300 hover:text-white transition-all duration-300">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-primary-500/20 to-primary-600/20 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas {{ $category->icon ?? 'fa-folder' }} text-primary-400 text-sm"></i>
                                        </div>
                                        <span>{{ $category->name }}</span>
                                    </div>
                                    <span class="text-xs bg-white/10 px-2 py-1 rounded-full">{{ $category->courses_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact & Newsletter -->
                <div data-aos="fade-up" data-aos-delay="400">
                    <h3 class="text-lg font-semibold mb-6 flex items-center">
                        <div class="w-1 h-6 bg-gradient-to-b from-purple-400 to-purple-600 rounded-full mr-3"></div>
                        Stay Connected
                    </h3>
                    
                    <!-- Contact Info -->
                    <div class="space-y-4 mb-6">
                        <div class="flex items-center text-gray-300">
                            <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium">Email</div>
                                <div class="text-xs text-gray-400">jhodywiraputra@gmail.com</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center text-gray-300">
                            <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium">Phone</div>
                                <div class="text-xs text-gray-400">+1 (555) 123-4567</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center text-gray-300">
                            <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium">Address</div>
                                <div class="text-xs text-gray-400">123 Learning St, Education City</div>
                            </div>
                        </div>
                    </div>

                    <!-- Newsletter Signup -->
                    <div class="bg-gradient-to-r from-primary-600/20 to-purple-600/20 rounded-xl p-4 border border-white/10 backdrop-blur-sm">
                        <h4 class="text-sm font-semibold mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            Newsletter
                        </h4>
                        <p class="text-xs text-gray-300 mb-3">Get the latest courses and updates delivered to your inbox.</p>
                        <form class="space-y-2" x-data="{ email: '', loading: false }" @submit.prevent="
                            loading = true;
                            setTimeout(() => {
                                showToast('Thank you for subscribing!', 'success');
                                email = '';
                                loading = false;
                            }, 1000);
                        ">
                            <div class="relative">
                                <input type="email" 
                                       x-model="email"
                                       placeholder="Enter your email" 
                                       required
                                       class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm">
                            </div>
                            <button type="submit" 
                                    :disabled="loading"
                                    class="w-full bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-all duration-300 hover:shadow-lg hover:shadow-primary-500/25 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                                <span x-show="!loading">Subscribe</span>
                                <span x-show="loading" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Subscribing...
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-white/10 bg-black/20 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col lg:flex-row items-center justify-between space-y-4 lg:space-y-0">
                    <!-- Copyright -->
                    <div class="flex items-center space-x-4 text-sm text-gray-400">
                        <span>&copy; {{ date('Y') }} LearnHub. All rights reserved.</span>
                        <span class="hidden sm:inline">•</span>
                        <span class="hidden sm:inline">Made with ❤️ for learners worldwide</span>
                    </div>

                    <!-- Links -->
                    <div class="flex items-center space-x-6 text-sm">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 hover:underline">
                            Privacy Policy
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 hover:underline">
                            Terms of Service
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 hover:underline">
                            Cookie Policy
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 hover:underline">
                            Help Center
                        </a>
                    </div>

                    <!-- Back to Top -->
                    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                            class="group flex items-center space-x-2 text-sm text-gray-400 hover:text-white transition-all duration-300">
                        <span>Back to Top</span>
                        <div class="w-8 h-8 bg-white/10 hover:bg-primary-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Achievement Badges -->
        <div class="absolute top-8 right-8 hidden xl:flex flex-col space-y-4" data-aos="fade-left" data-aos-delay="500">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20 text-center">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-2">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <div class="text-xs text-gray-300">Top Rated</div>
                <div class="text-sm font-bold text-white">4.9/5</div>
            </div>
            
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20 text-center">
                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-2">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-xs text-gray-300">Certified</div>
                <div class="text-sm font-bold text-white">Platform</div>
            </div>
        </div>
    </div>
</footer>

<!-- Cookie Consent Banner -->
<div id="cookie-banner" 
     class="fixed bottom-0 left-0 right-0 bg-white shadow-2xl border-t border-gray-200 p-4 z-50 transform translate-y-full transition-transform duration-500"
     x-data="{ show: false }"
     x-init="setTimeout(() => show = true, 2000)"
     x-show="show"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="translate-y-full"
     x-transition:enter-end="translate-y-0">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0 sm:space-x-4">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="text-sm text-gray-700">
                <span class="font-medium">We use cookies</span> to enhance your experience and analyze site usage. 
                <a href="#" class="text-primary-600 hover:text-primary-700 underline">Learn more</a>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <button @click="show = false" 
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors duration-200">
                Decline
            </button>
            <button @click="show = false" 
                    class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors duration-200">
                Accept All
            </button>
        </div>
    </div>
</div>

<!-- Add FontAwesome for icons -->
@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush