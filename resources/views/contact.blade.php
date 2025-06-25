@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-blue-600 to-purple-600 overflow-hidden min-h-screen flex items-center justify-center">
    <!-- Bubbles Animation -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="bubble absolute w-64 h-64 rounded-full bg-white/20 blur-xl animate-bubble-1"></div>
        <div class="bubble absolute w-96 h-96 rounded-full bg-purple-400/20 blur-xl animate-bubble-2"></div>
        <div class="bubble absolute w-80 h-80 rounded-full bg-blue-400/20 blur-xl animate-bubble-3"></div>
        <div class="bubble absolute w-72 h-72 rounded-full bg-white/20 blur-xl animate-bubble-4"></div>
        <div class="bubble absolute w-56 h-56 rounded-full bg-purple-400/20 blur-xl animate-bubble-5"></div>
        <div class="bubble absolute w-48 h-48 rounded-full bg-blue-400/20 blur-xl animate-bubble-6"></div>
        <div class="bubble absolute w-40 h-40 rounded-full bg-white/20 blur-xl animate-bubble-7"></div>
        <div class="bubble absolute w-32 h-32 rounded-full bg-purple-400/20 blur-xl animate-bubble-8"></div>
        <div class="bubble absolute w-24 h-24 rounded-full bg-blue-400/20 blur-xl animate-bubble-9"></div>
        <div class="bubble absolute w-20 h-20 rounded-full bg-white/20 blur-xl animate-bubble-10"></div>
        <div class="bubble absolute w-28 h-28 rounded-full bg-purple-400/20 blur-xl animate-bubble-11"></div>
        <div class="bubble absolute w-36 h-36 rounded-full bg-blue-400/20 blur-xl animate-bubble-12"></div>
        <div class="bubble absolute w-44 h-44 rounded-full bg-white/20 blur-xl animate-bubble-13"></div>
        <div class="bubble absolute w-52 h-52 rounded-full bg-purple-400/20 blur-xl animate-bubble-14"></div>
        <div class="bubble absolute w-60 h-60 rounded-full bg-blue-400/20 blur-xl animate-bubble-15"></div>
    </div>
    <div class="absolute inset-0">
        <svg class="absolute bottom-0 left-0 right-0" viewBox="0 0 1440 320">
            <path fill="rgba(255,255,255,0.1)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,106.7C1248,96,1344,96,1392,96L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center relative z-10">
            <div class="relative">
                <h1 class="text-5xl md:text-7xl font-black mb-6 animate-fade-in-up text-white">
                    Get In <span class="relative">
                        <span class="relative z-10">Touch</span>
                    </span>
                </h1>
                <p class="text-xl md:text-2xl text-white/90 max-w-2xl mx-auto leading-relaxed animate-fade-in-up animation-delay-200 font-light">
                    We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
                <div class="mt-8 flex justify-center space-x-4 animate-fade-in-up animation-delay-400">
                    <div class="w-3 h-3 rounded-full bg-white/50 animate-pulse"></div>
                    <div class="w-3 h-3 rounded-full bg-white/50 animate-pulse animation-delay-200"></div>
                    <div class="w-3 h-3 rounded-full bg-white/50 animate-pulse animation-delay-400"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Section -->
<div class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Contact Information Cards -->
            <div class="lg:col-span-1 space-y-6">
                <div class="text-center lg:text-left mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Contact Information</h2>
                    <p class="text-gray-600">Reach out to us through any of these channels</p>
                </div>

                <!-- Address Card -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-blue-500 hover:border-purple-500 transform hover:-translate-y-1">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Our Address</h3>
                            <p class="text-gray-600 leading-relaxed">123 Education Street<br>Learning City, 12345<br>United States</p>
                        </div>
                    </div>
                </div>

                <!-- Email Card -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-green-500 hover:border-blue-500 transform hover:-translate-y-1">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Email Us</h3>
                            <p class="text-gray-600">contact@elearning-platform.com</p>
                            <p class="text-gray-600">support@elearning-platform.com</p>
                        </div>
                    </div>
                </div>

                <!-- Phone Card -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-purple-500 hover:border-green-500 transform hover:-translate-y-1">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Call Us</h3>
                            <p class="text-gray-600">+1 (555) 123-4567</p>
                            <p class="text-gray-600 text-sm">Mon-Fri 9AM-6PM EST</p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-800 rounded-full flex items-center justify-center text-white hover:bg-blue-900 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center text-white hover:bg-pink-700 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-700 rounded-full flex items-center justify-center text-white hover:bg-blue-800 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-12">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Send us a Message</h2>
                        <p class="text-gray-600">Fill out the form below and we'll get back to you within 24 hours</p>
                    </div>

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                <input type="text" name="name" id="name" required
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors duration-300 group-hover:border-gray-300"
                                    placeholder="Your full name">
                            </div>
                            <div class="group">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                                <input type="email" name="email" id="email" required
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors duration-300 group-hover:border-gray-300"
                                    placeholder="your.email@example.com">
                            </div>
                        </div>

                        <div class="group">
                            <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subject *</label>
                            <input type="text" name="subject" id="subject" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors duration-300 group-hover:border-gray-300"
                                placeholder="What is this regarding?">
                        </div>

                        <div class="group">
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message *</label>
                            <textarea name="message" id="message" rows="6" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors duration-300 group-hover:border-gray-300 resize-none"
                                placeholder="Tell us more about your inquiry..."></textarea>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="newsletter" name="newsletter" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="newsletter" class="ml-2 block text-sm text-gray-700">
                                I'd like to receive updates and newsletters
                            </label>
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-300">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    Send Message
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Map Section -->
<div class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Find Our Location</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Visit us at our headquarters or reach out through our contact form above</p>
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="aspect-w-16 aspect-h-9">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387193.30591910525!2d-74.25986432970718!3d40.697149422113014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1645564750981!5m2!1sen!2s"
                    width="100%"
                    height="500"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    class="w-full">
                </iframe>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="bg-gray-50 py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
            <p class="text-gray-600">Quick answers to common questions</p>
        </div>
        
        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow-md">
                <button class="w-full px-6 py-4 text-left focus:outline-none" onclick="toggleFAQ(1)">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">How quickly do you respond to inquiries?</h3>
                        <svg id="faq-icon-1" class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>
                <div id="faq-content-1" class="hidden px-6 pb-4">
                    <p class="text-gray-600">We typically respond to all inquiries within 24 hours during business days. For urgent matters, please call us directly.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md">
                <button class="w-full px-6 py-4 text-left focus:outline-none" onclick="toggleFAQ(2)">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">What are your business hours?</h3>
                        <svg id="faq-icon-2" class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>
                <div id="faq-content-2" class="hidden px-6 pb-4">
                    <p class="text-gray-600">Our office hours are Monday through Friday, 9:00 AM to 6:00 PM EST. However, you can submit inquiries through our contact form 24/7.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md">
                <button class="w-full px-6 py-4 text-left focus:outline-none" onclick="toggleFAQ(3)">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Do you offer technical support?</h3>
                        <svg id="faq-icon-3" class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>
                <div id="faq-content-3" class="hidden px-6 pb-4">
                    <p class="text-gray-600">Yes, we provide comprehensive technical support for all our services. You can reach our support team via email or phone during business hours.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out forwards;
}

.animation-delay-200 {
    animation-delay: 0.2s;
    opacity: 0;
}

.animation-delay-400 {
    animation-delay: 0.4s;
    opacity: 0;
}

@keyframes bubble-1 {
    0% {
        transform: translate(0, 100vh) scale(0);
        opacity: 0;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translate(100px, -100vh) scale(1);
        opacity: 0;
    }
}

@keyframes bubble-2 {
    0% {
        transform: translate(0, 100vh) scale(0);
        opacity: 0;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translate(-200px, -100vh) scale(1);
        opacity: 0;
    }
}

@keyframes bubble-3 {
    0% {
        transform: translate(0, 100vh) scale(0);
        opacity: 0;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translate(300px, -100vh) scale(1);
        opacity: 0;
    }
}

@keyframes bubble-4 {
    0% {
        transform: translate(0, 100vh) scale(0);
        opacity: 0;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translate(-150px, -100vh) scale(1);
        opacity: 0;
    }
}

@keyframes bubble-5 {
    0% {
        transform: translate(0, 100vh) scale(0);
        opacity: 0;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translate(250px, -100vh) scale(1);
        opacity: 0;
    }
}

@keyframes bubble-6 {
    0% {
        transform: translate(0, 100vh) scale(0);
        opacity: 0;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translate(180px, -100vh) scale(1);
        opacity: 0;
    }
}

@keyframes bubble-7 {
    0% {
        transform: translate(0, 100vh) scale(0);
        opacity: 0;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translate(-120px, -100vh) scale(1);
        opacity: 0;
    }
}

@keyframes bubble-8 {
    0% {
        transform: translate(0, 100vh) scale(0);
        opacity: 0;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translate(220px, -100vh) scale(1);
        opacity: 0;
    }
}

@keyframes bubble-9 {
    0% {
        transform: translate(0, 100vh) scale(0);
        opacity: 0;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translate(-80px, -100vh) scale(1);
        opacity: 0;
    }
}

@keyframes bubble-10 {
    0% {
        transform: translate(0, 100vh) scale(0);
        opacity: 0;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translate(150px, -100vh) scale(1);
        opacity: 0;
    }
}

@keyframes bubble-11 {
    0% {
        transform: translate(0, 100vh) scale(0);
        opacity: 0;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translate(160px, -100vh) scale(1);
        opacity: 0;
    }
}

@keyframes bubble-12 {
    0% {
        transform: translate(0, 100vh) scale(0);
        opacity: 0;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translate(-140px, -100vh) scale(1);
        opacity: 0;
    }
}

@keyframes bubble-13 {
    0% {
        transform: translate(0, 100vh) scale(0);
        opacity: 0;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translate(200px, -100vh) scale(1);
        opacity: 0;
    }
}

@keyframes bubble-14 {
    0% {
        transform: translate(0, 100vh) scale(0);
        opacity: 0;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translate(-90px, -100vh) scale(1);
        opacity: 0;
    }
}

@keyframes bubble-15 {
    0% {
        transform: translate(0, 100vh) scale(0);
        opacity: 0;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translate(170px, -100vh) scale(1);
        opacity: 0;
    }
}

.animate-bubble-1 {
    animation: bubble-1 6s infinite;
    left: 5%;
}

.animate-bubble-2 {
    animation: bubble-2 8s infinite;
    left: 15%;
}

.animate-bubble-3 {
    animation: bubble-3 7s infinite;
    left: 25%;
}

.animate-bubble-4 {
    animation: bubble-4 9s infinite;
    left: 35%;
}

.animate-bubble-5 {
    animation: bubble-5 6.5s infinite;
    left: 45%;
}

.animate-bubble-6 {
    animation: bubble-6 7.5s infinite;
    left: 55%;
}

.animate-bubble-7 {
    animation: bubble-7 8.5s infinite;
    left: 65%;
}

.animate-bubble-8 {
    animation: bubble-8 6s infinite;
    left: 75%;
}

.animate-bubble-9 {
    animation: bubble-9 7s infinite;
    left: 85%;
}

.animate-bubble-10 {
    animation: bubble-10 8s infinite;
    left: 95%;
}

.animate-bubble-11 {
    animation: bubble-11 6.5s infinite;
    left: 10%;
}

.animate-bubble-12 {
    animation: bubble-12 7.5s infinite;
    left: 20%;
}

.animate-bubble-13 {
    animation: bubble-13 8.5s infinite;
    left: 30%;
}

.animate-bubble-14 {
    animation: bubble-14 6s infinite;
    left: 40%;
}

.animate-bubble-15 {
    animation: bubble-15 7s infinite;
    left: 50%;
}
</style>

<script>
function toggleFAQ(id) {
    const content = document.getElementById(`faq-content-${id}`);
    const icon = document.getElementById(`faq-icon-${id}`);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>
@endsection