<x-guest-layout>
    <div class="flex flex-col items-center">
        <!-- Logo and Title -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-primary-600">Welcome Back!</h1>
            <p class="text-gray-600 mt-2">Sign in to continue your learning journey</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 w-full" :status="session('status')" />

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="w-full">
            @csrf

            <!-- Email Address -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input id="email" class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           autocomplete="username"
                           placeholder="your.email@example.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    @if (Route::has('password.request'))
                        <a class="text-xs text-primary-600 hover:text-primary-800 font-medium" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" 
                           class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500" 
                           type="password"
                           name="password"
                           required 
                           autocomplete="current-password"
                           placeholder="••••••••">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-6">
                <input id="remember_me" type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" name="remember">
                <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                    Remember me
                </label>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-150 ease-in-out">
                    <span class="mr-2">Sign In</span> 
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>

        <!-- Register Link -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600">
                Don't have an account yet? 
                <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:text-primary-700">
                    Sign up
                </a>
            </p>
        </div>

        <!-- Social Login Options -->
        <div class="mt-6 w-full">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Or continue with</span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-3 gap-3">
                <div>
                    <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <div>
                    <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12.0002 2C6.47791 2 2.00012 6.47778 2.00012 12C2.00012 16.2377 4.78569 19.7855 8.59827 21.2552C9.09788 21.3396 9.27907 21.0353 9.27907 20.7741C9.27907 20.5388 9.27178 19.883 9.26767 19.0363C6.73022 19.646 6.13947 17.8752 6.13947 17.8752C5.68472 16.7942 5.02766 16.4906 5.02766 16.4906C4.12131 15.873 5.09737 15.8855 5.09737 15.8855C6.10175 15.9512 6.63012 16.9026 6.63012 16.9026C7.52175 18.3914 9.0055 17.9189 9.29577 17.6682C9.37787 17.0068 9.6186 16.5343 9.88844 16.2377C7.81206 15.9411 5.62524 15.0716 5.62524 11.4824C5.62524 10.4337 6.01011 9.57432 6.64968 8.9023C6.54987 8.65125 6.20359 7.61337 6.74647 6.21455C6.74647 6.21455 7.58608 5.94984 9.24945 7.26665C10.0916 7.04909 11.0002 6.93953 11.9002 6.93665C12.8002 6.93953 13.7064 7.04908 14.5509 7.26665C16.2107 5.94984 17.049 6.21455 17.049 6.21455C17.5922 7.61337 17.2459 8.65125 17.1485 8.9023C17.7879 9.57432 18.1702 10.4337 18.1702 11.4824C18.1702 15.0818 15.9798 15.9397 13.8963 16.2316C14.2349 16.5918 14.5355 17.3198 14.5355 18.4237C14.5355 20.0082 14.5237 20.4477 14.5237 20.7741C14.5237 21.0366 14.7037 21.3431 15.2101 21.2535C19.0274 19.7833 21.8002 16.2363 21.8002 12C21.8002 6.47778 17.3224 2 12.0002 2Z" fill="currentColor"/>
                        </svg>
                    </a>
                </div>

                <div>
                    <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M23.4298 12.2631C23.4298 11.4764 23.3604 10.6897 23.2217 9.91846H12.2148V14.1302H18.5228C18.2686 15.4336 17.4588 16.5722 16.2999 17.2849V19.9782H19.9839C22.1669 18.0117 23.4298 15.4106 23.4298 12.2631Z" fill="#4285F4"/>
                            <path d="M12.214 23.0007C15.1068 23.0007 17.5353 22.0167 19.9831 19.9783L16.2992 17.2851C15.2915 17.9747 13.891 18.3871 12.214 18.3871C9.2734 18.3871 6.78022 16.4206 5.83984 13.7043H2.0332V16.4898C4.47058 20.3757 8.20195 23.0007 12.214 23.0007Z" fill="#34A853"/>
                            <path d="M5.84003 13.7044C5.62404 13.0148 5.50568 12.2742 5.50568 11.5002C5.50568 10.7263 5.62404 9.98563 5.84003 9.29608V6.51056H2.03338C1.25682 8.00931 0.813965 9.70681 0.813965 11.5002C0.813965 13.2937 1.25682 14.9911 2.03338 16.4899L5.84003 13.7044Z" fill="#FBBC05"/>
                            <path d="M12.214 4.61385C13.825 4.61385 15.2718 5.17127 16.3983 6.25175L19.6493 3.00073C17.5354 1.01478 15.1069 0.000732422 12.214 0.000732422C8.20195 0.000732422 4.47058 2.62576 2.0332 6.5116L5.83985 9.29712C6.78023 6.58082 9.2734 4.61385 12.214 4.61385Z" fill="#EA4335"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
