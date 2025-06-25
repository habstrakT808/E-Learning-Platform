@extends('layouts.app')

@section('title', ' - About Us')

@section('meta_description', 'Learn more about LearnHub - your trusted platform for online learning. Discover our mission, team, and commitment to quality education.')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-primary-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6" data-aos="fade-up">
                Empowering Learners Worldwide
            </h1>
            <p class="text-xl text-white max-w-3xl mx-auto mb-8" data-aos="fade-up" data-aos-delay="100">
                At LearnHub, we believe that education should be accessible, engaging, and transformative. 
                Our mission is to empower learners with the skills and knowledge they need to succeed in an ever-evolving world.
            </p>
            <div class="flex justify-center space-x-4" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('courses.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-blue-900 bg-yellow-400 hover:bg-yellow-500 transition-colors duration-200">
                    Explore Courses
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                <a href="#contact" class="inline-flex items-center px-6 py-3 border border-primary-600 text-base font-medium rounded-lg text-primary-600 bg-white hover:bg-primary-50 transition-colors duration-200">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4" data-aos="fade-up">Why Choose LearnHub?</h2>
            <p class="text-xl text-gray-600" data-aos="fade-up" data-aos-delay="100">
                We're committed to providing the best learning experience for our students
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300" data-aos="fade-up">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Expert Instructors</h3>
                <p class="text-gray-600">Learn from industry professionals and experienced educators who are passionate about sharing their knowledge.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Quality Content</h3>
                <p class="text-gray-600">Access high-quality, up-to-date content that's designed to help you achieve your learning goals effectively.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Community Learning</h3>
                <p class="text-gray-600">Join a vibrant community of learners, share experiences, and grow together through collaborative learning.</p>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-20 bg-primary-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <!-- Stat 1 -->
            <div class="p-6" data-aos="fade-up">
                <div class="text-4xl font-bold mb-2">10K+</div>
                <div class="text-primary-100">Active Students</div>
            </div>

            <!-- Stat 2 -->
            <div class="p-6" data-aos="fade-up" data-aos-delay="100">
                <div class="text-4xl font-bold mb-2">500+</div>
                <div class="text-primary-100">Courses</div>
            </div>

            <!-- Stat 3 -->
            <div class="p-6" data-aos="fade-up" data-aos-delay="200">
                <div class="text-4xl font-bold mb-2">200+</div>
                <div class="text-primary-100">Expert Instructors</div>
            </div>

            <!-- Stat 4 -->
            <div class="p-6" data-aos="fade-up" data-aos-delay="300">
                <div class="text-4xl font-bold mb-2">98%</div>
                <div class="text-primary-100">Student Satisfaction</div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4" data-aos="fade-up">Meet Our Team</h2>
            <p class="text-xl text-gray-600" data-aos="fade-up" data-aos-delay="100">
                The passionate people behind LearnHub
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Team Member 1 -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Team Member" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">John Doe</h3>
                    <p class="text-primary-600 mb-4">Founder & CEO</p>
                    <p class="text-gray-600">Passionate about education and technology, John leads our mission to make quality education accessible to everyone.</p>
                </div>
            </div>

            <!-- Team Member 2 -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Team Member" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Jane Smith</h3>
                    <p class="text-primary-600 mb-4">Head of Education</p>
                    <p class="text-gray-600">With over 15 years of experience in education, Jane ensures the highest quality of our course content.</p>
                </div>
            </div>

            <!-- Team Member 3 -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Team Member" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Mike Johnson</h3>
                    <p class="text-primary-600 mb-4">Technical Director</p>
                    <p class="text-gray-600">Mike leads our technical team, ensuring a seamless learning experience for all our students.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4" data-aos="fade-up">What Our Students Say</h2>
            <p class="text-xl text-gray-600" data-aos="fade-up" data-aos-delay="100">
                Success stories from our community
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg" data-aos="fade-up">
                <div class="flex items-center mb-6">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Student" class="w-12 h-12 rounded-full">
                    <div class="ml-4">
                        <h4 class="text-lg font-semibold text-gray-900">Sarah Wilson</h4>
                        <p class="text-gray-600">Web Development Student</p>
                    </div>
                </div>
                <p class="text-gray-600">"LearnHub has transformed my career. The courses are well-structured and the instructors are incredibly supportive."</p>
            </div>

            <!-- Testimonial 2 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center mb-6">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Student" class="w-12 h-12 rounded-full">
                    <div class="ml-4">
                        <h4 class="text-lg font-semibold text-gray-900">David Chen</h4>
                        <p class="text-gray-600">Data Science Student</p>
                    </div>
                </div>
                <p class="text-gray-600">"The quality of content and the interactive learning experience at LearnHub is unmatched. Highly recommended!"</p>
            </div>

            <!-- Testimonial 3 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center mb-6">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Student" class="w-12 h-12 rounded-full">
                    <div class="ml-4">
                        <h4 class="text-lg font-semibold text-gray-900">Emily Brown</h4>
                        <p class="text-gray-600">UX Design Student</p>
                    </div>
                </div>
                <p class="text-gray-600">"I've learned more in three months at LearnHub than I did in a year of traditional education. The community is amazing!"</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-primary-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-6" data-aos="fade-up">Ready to Start Your Learning Journey?</h2>
        <p class="text-xl text-primary-100 mb-8 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            Join thousands of students who are already learning and growing with LearnHub
        </p>
        <div class="flex justify-center space-x-4" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('courses.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-rose-500 hover:bg-rose-600 transition-colors duration-200">
                Browse Courses
                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border-2 border-white text-base font-medium rounded-lg text-white hover:bg-white hover:text-primary-600 transition-colors duration-200">
                Sign Up Now
            </a>
        </div>
    </div>
</section>
@endsection 